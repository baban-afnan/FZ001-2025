<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\View\View;
use App\Models\User;

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
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

        return Redirect::route('settings.services')->with('status', 'profile-updated');
    }

    /**
     * Update BVN and Phone No if missing.
     */
    public function updateRequired(Request $request): RedirectResponse
    {
        $request->validate([
            'bvn' => 'required|digits:11',
            'phone_no' => 'required|string|max:15',
            'nin' => ['nullable', 'string', 'min:11', 'max:20'],
            'address' => ['nullable', 'string', 'max:255'],
            'email' => ['nullable', 'email'],
            'photo' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif', 'max:2048'],
        ]);

        $user = Auth::user();
        $user->update([
            'bvn' => $request->bvn,
            'phone_no' => $request->phone_no,
        ]);

        return redirect()->route('dashboard')->with('success', 'Profile updated successfully.');
    }

    /**
     * Upload or update profile photo.
     */
    public function updatePhoto(Request $request): RedirectResponse
    {
        $request->validate([
            'photo' => 'required|image|mimes:jpg,jpeg,png,webp|max:2048', // 2MB max
        ]);

        $user = Auth::user();

        try {
            // ✅ Delete old photo if exists (and not external link)
            if ($user->photo && !Str::startsWith($user->photo, 'http')) {
                $oldPath = str_replace(url('/') . '/storage/', '', $user->photo);
                Storage::disk('public')->delete($oldPath);
            }

            // ✅ Store new image
            $path = $request->file('photo')->store('profile_photos', 'public');

            // ✅ Build full HTTP link
            $fullUrl = url('storage/' . $path);

            // ✅ Save to database
            $user->update([
                'photo' => $fullUrl,
            ]);

            return back()->with('status', '✅ Profile photo updated successfully!');
        } catch (\Exception $e) {
            return back()->with('error', '❌ Failed to update profile photo: ' . $e->getMessage());
        }
    }
}
