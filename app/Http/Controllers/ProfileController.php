<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use App\Models\Address;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        $user = $request->user();
        $addresses = $user->isReseller() ? $user->addresses()->latest()->get() : collect();
        return view('profile.edit', compact('user', 'addresses'));
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        if ($request->user()->isAdmin()) {
            abort(403, 'Admins cannot delete their own account. Only resellers can.');
        }

        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }

    /**
     * Save a new delivery address for the authenticated reseller.
     */
    public function storeAddress(Request $request)
    {
        $request->validate([
            'recipient_name' => 'required|string|max:255',
            'phone'          => 'required|string|max:20',
            'address_line_1' => 'required|string|max:255',
            'address_line_2' => 'nullable|string|max:255',
            'city'           => 'required|string|max:100',
            'state'          => 'required|string|max:100',
            'postal_code'    => 'required|string|max:20',
            'label'          => 'nullable|string|max:50',
        ]);

        $user = $request->user();

        // If first address, mark as default automatically
        $isFirst = $user->addresses()->count() === 0;

        $address = $user->addresses()->create([
            'label'          => $request->label ?: 'Home',
            'recipient_name' => $request->recipient_name,
            'phone'          => $request->phone,
            'address_line_1' => $request->address_line_1,
            'address_line_2' => $request->address_line_2,
            'city'           => $request->city,
            'state'          => $request->state,
            'postal_code'    => $request->postal_code,
            'is_default'     => $isFirst,
        ]);

        // Flash the newly created address ID so the checkout page can pre-select it
        session()->flash('selected_address_id', $address->id);

        if ($request->expectsJson() || $request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Address saved successfully.',
                'address' => $address
            ]);
        }

        return Redirect::route('profile.edit')->with('status', 'address-saved');
    }

    /**
     * Set an address as the default delivery address.
     */
    public function setDefaultAddress(Request $request, Address $address): RedirectResponse
    {
        if ($address->user_id !== $request->user()->id) abort(403);

        $request->user()->addresses()->update(['is_default' => false]);
        $address->update(['is_default' => true]);

        return Redirect::route('profile.edit')->with('status', 'address-saved');
    }

    /**
     * Remove a saved address.
     */
    public function destroyAddress(Request $request, Address $address): RedirectResponse
    {
        if ($address->user_id !== $request->user()->id) abort(403);

        $wasDefault = $address->is_default;
        $address->delete();

        // Auto-promote next address to default if deleted one was default
        if ($wasDefault) {
            $next = $request->user()->addresses()->first();
            if ($next) $next->update(['is_default' => true]);
        }

        return Redirect::route('profile.edit')->with('status', 'address-saved');
    }
}
