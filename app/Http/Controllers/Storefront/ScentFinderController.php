<?php

namespace App\Http\Controllers\Storefront;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;

class ScentFinderController extends Controller
{
    public function index()
    {
        return view('storefront.scent-finder.index');
    }

    public function results(Request $request)
    {
        if ($request->isMethod('get') && !$request->has('answers')) {
            return redirect()->route('storefront.scent-finder');
        }

        $validated = $request->validate([
            'answers.vibe' => 'nullable|in:fresh,woody,floral',
            'answers.time' => 'nullable|in:day,night',
            'answers.intensity' => 'nullable|in:subtle,bold',
        ]);

        $answers = Arr::get($validated, 'answers', []);
        
        // Fetch all active products
        $products = Product::active()
            ->with(['variants', 'images'])
            ->withSum('sales', 'quantity')
            ->get();

        $vibePref = $answers['vibe'] ?? null;
        $timePref = $answers['time'] ?? null;
        $intensityPref = $answers['intensity'] ?? null;

        // Load Note Dictionary Config
        $notesConfig = config('scent-notes.notes', []);
        $familiesConfig = config('scent-notes.families', []);

        // Find which families map to the user's selected vibe
        $targetFamilies = [];
        if ($vibePref) {
            foreach ($familiesConfig as $famId => $famData) {
                if (($famData['vibe'] ?? null) === $vibePref) {
                    $targetFamilies[] = $famId;
                }
            }
        }

        // Calculate score and accuracy for each product
        $scoredProducts = $products->map(function ($product) use ($vibePref, $timePref, $intensityPref, $notesConfig, $targetFamilies) {
            $score = 0;
            $matchedNotes = [];

            // Helper to clean and split comma/pipe/slash separated text into individual note blocks
            $parseNotes = function ($noteText) {
                if (empty($noteText)) return [];
                return array_filter(array_map('trim', preg_split('/[\/|,|;]+/u', strtolower($noteText))));
            };

            // Helper to perform robust substring matches
            $hasNote = function ($noteKeyword, $notesList) {
                foreach ($notesList as $note) {
                    if (str_contains($note, $noteKeyword)) {
                        return true;
                    }
                }
                return false;
            };

            $topNotesList = $parseNotes($product->top_note);
            $heartNotesList = $parseNotes($product->heart_note);
            $baseNotesList = $parseNotes($product->base_note);

            // 1. SCENT VIBE SCORING
            if ($vibePref) {
                // Direct Fragrance Family Match Bonus (high confidence signal)
                if (!empty($product->fragrance_family)) {
                    $prodFam = strtolower($product->fragrance_family);
                    if (in_array($prodFam, $targetFamilies)) {
                        $score += 8; // Direct family match bonus
                    }
                }

                // Note-level vibe matches
                foreach ($notesConfig as $noteKeyword => $meta) {
                    $family = $meta['family'] ?? null;
                    if (in_array($family, $targetFamilies)) {
                        if ($hasNote($noteKeyword, $topNotesList)) {
                            $score += 3; // Match in top layer
                            $matchedNotes[] = $noteKeyword;
                        }
                        if ($hasNote($noteKeyword, $heartNotesList)) {
                            $score += 2; // Match in heart layer
                            $matchedNotes[] = $noteKeyword;
                        }
                        if ($hasNote($noteKeyword, $baseNotesList)) {
                            $score += 1; // Match in base layer
                            $matchedNotes[] = $noteKeyword;
                        }
                    }
                }
            }

            // 2. TIME OF DAY SCORING
            if ($timePref) {
                foreach ($notesConfig as $noteKeyword => $meta) {
                    $timeBias = $meta['time'] ?? null;
                    if ($timeBias === $timePref) {
                        if ($hasNote($noteKeyword, $topNotesList)) {
                            $score += 1.5;
                            $matchedNotes[] = $noteKeyword;
                        }
                        if ($hasNote($noteKeyword, $heartNotesList)) {
                            $score += 1.5;
                            $matchedNotes[] = $noteKeyword;
                        }
                        if ($hasNote($noteKeyword, $baseNotesList)) {
                            $score += 1.5;
                            $matchedNotes[] = $noteKeyword;
                        }
                    }
                }
            }

            // 3. INTENSITY SCORING
            if ($intensityPref) {
                foreach ($notesConfig as $noteKeyword => $meta) {
                    $intensityBias = $meta['intensity'] ?? null;
                    if ($intensityBias === $intensityPref) {
                        if ($hasNote($noteKeyword, $topNotesList)) {
                            $score += 1.5;
                            $matchedNotes[] = $noteKeyword;
                        }
                        if ($hasNote($noteKeyword, $heartNotesList)) {
                            $score += 1.5;
                            $matchedNotes[] = $noteKeyword;
                        }
                        if ($hasNote($noteKeyword, $baseNotesList)) {
                            $score += 1.5;
                            $matchedNotes[] = $noteKeyword;
                        }
                    }
                }
            }

            // Compute realistic accuracy percentage matching high premium look feel
            $baseAccuracy = 45;
            if ($score > 0) {
                $accuracy = min(99, $baseAccuracy + ($score * 3.5));
            } else {
                // Baseline soft accuracy match
                $accuracy = min(68, 45 + (crc32($product->sku) % 20));
            }

            $product->scent_score = $score;
            $product->scent_accuracy = round($accuracy);
            $product->matched_notes = array_values(array_unique($matchedNotes));

            return $product;
        });

        // Sort by score descending, then by ID descending to keep it consistent
        $recommendations = $scoredProducts
            ->sortByDesc(function ($product) {
                return [$product->scent_score, $product->id];
            })
            ->values()
            ->take(4);

        return view('storefront.scent-finder.results', compact('recommendations', 'answers'));
    }
}
