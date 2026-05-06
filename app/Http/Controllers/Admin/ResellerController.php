<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Http\Requests\StoreResellerRequest;
use App\Http\Requests\UpdateResellerRequest;
use App\Services\NotificationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ResellerController extends Controller
{
    public function index(Request $request)
    {
        $query = User::where('role', 'reseller')
            ->withCount('sales')
            ->withSum('sales', 'total_price');

        if ($search = $request->input('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        $resellers = $query->latest()->paginate(15)->appends($request->all());

        if ($request->ajax() && !$request->header('X-SPA')) {
            return view('admin.resellers.partials.table', compact('resellers'))->render();
        }

        $totalResellers = User::where('role', 'reseller')->count();
        $totalSalesCount = \App\Models\Sale::count();
        $totalRevenue = \App\Models\Sale::sum('total_price');

        return view('admin.resellers.index', compact('resellers', 'totalResellers', 'totalSalesCount', 'totalRevenue'));
    }

    public function create()
    {
        return view('admin.resellers.create');
    }

    public function store(StoreResellerRequest $request)
    {
        $reseller = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'reseller',
            'commission_rate' => $request->commission_rate,
        ]);

        NotificationService::newReseller($reseller);

        return redirect()->route('admin.resellers.index')->with('success', 'Reseller created successfully.');
    }

    public function show(User $reseller) {}

    public function edit(User $reseller)
    {
        // Prevent editing admins
        if ($reseller->isAdmin()) {
            return redirect()->route('admin.resellers.index')->withErrors('Cannot edit an admin from the reseller management panel.');
        }
        return view('admin.resellers.edit', compact('reseller'));
    }

    public function update(UpdateResellerRequest $request, User $reseller)
    {
        if ($reseller->isAdmin()) return abort(403);

        $reseller->name = $request->name;
        $reseller->email = $request->email;
        if ($request->filled('password')) {
            $reseller->password = Hash::make($request->password);
        }
        $reseller->commission_rate = $request->commission_rate;
        $reseller->save();

        return redirect()->route('admin.resellers.index')->with('success', 'Reseller updated successfully.');
    }

    public function destroy(User $reseller)
    {
        if ($reseller->isAdmin()) return abort(403);
        
        $reseller->delete();
        return redirect()->route('admin.resellers.index')->with('success', 'Reseller removed successfully.');
    }
}
