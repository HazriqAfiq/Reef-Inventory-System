<?php

namespace Tests\Feature\Storefront;

use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ScentFinderTest extends TestCase
{
    use RefreshDatabase;

    public function test_scent_finder_page_can_be_rendered(): void
    {
        $response = $this->get(route('storefront.scent-finder'));

        $response->assertOk();
    }

    public function test_scent_finder_results_accept_valid_answers(): void
    {
        $response = $this->get(route('storefront.scent-finder.results', [
            'answers' => [
                'vibe' => 'fresh',
                'intensity' => 'subtle',
                'time' => 'day',
            ],
        ]));

        $response->assertOk();
    }

    public function test_scent_finder_results_reject_invalid_answers(): void
    {
        $response = $this->from(route('storefront.scent-finder'))
            ->get(route('storefront.scent-finder.results', [
                'answers' => [
                    'vibe' => 'random-value',
                ],
            ]));

        $response->assertRedirect(route('storefront.scent-finder'));
        $response->assertSessionHasErrors('answers.vibe');
    }

    public function test_scent_finder_recommends_product_based_on_notes_matching_vibe(): void
    {
        $freshProduct = Product::create([
            'sku' => 'SKU-FRESH',
            'name' => 'Fresh Scent',
            'slug' => 'fresh-scent',
            'description' => 'Test description',
            'top_note' => 'Citrus',
            'heart_note' => 'Bergamot',
            'base_note' => 'Musk',
            'fragrance_family' => 'fresh',
            'wholesale_price' => 50,
            'retail_price' => 100,
            'stock' => 10,
            'is_active' => true,
        ]);

        $woodyProduct = Product::create([
            'sku' => 'SKU-WOODY',
            'name' => 'Woody Scent',
            'slug' => 'woody-scent',
            'description' => 'Test description',
            'top_note' => 'Oud',
            'heart_note' => 'Sandalwood',
            'base_note' => 'Patchouli',
            'fragrance_family' => 'woody',
            'wholesale_price' => 50,
            'retail_price' => 100,
            'stock' => 10,
            'is_active' => true,
        ]);

        $response = $this->get(route('storefront.scent-finder.results', [
            'answers' => [
                'vibe' => 'fresh',
                'intensity' => 'subtle',
                'time' => 'day',
            ],
        ]));

        $response->assertOk();
        $recommendations = $response->viewData('recommendations');
        $this->assertNotEmpty($recommendations);
        $this->assertEquals('Fresh Scent', $recommendations->first()->name);
        $this->assertTrue($recommendations->first()->scent_score > $recommendations->last()->scent_score);
    }
}
