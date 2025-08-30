<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('settings.services', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information (no validation, no activation lock).
     */
    public function update(Request $request): RedirectResponse
    {
        $user = $request->user();

        // Handle profile photo upload
        if ($request->hasFile('photo')) {
            // Delete old image if exists
            if ($user->profile_photo_url && Storage::disk('public')->exists($user->profile_photo_url)) {
                Storage::disk('public')->delete($user->profile_photo_url);
            }

            $file = $request->file('photo');
            $filename = Str::uuid() . '.' . $file->getClientOriginalExtension();

            $path = $file->storeAs('profile_photos', $filename, 'public');

            $user->profile_photo_url = $path;
            $user->photo = $filename;
        }

        // Fill all fields (including photo if manually provided)
        $user->fill($request->except([]));

        // Reset email verification if email changed
        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        $user->save();

        return Redirect::route('settings.services')->with('status', 'profile-updated');
    }

    /**
     * Delete the user's account (no password validation).
     */
    public function destroy(Request $request): RedirectResponse
    {
        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
