<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class ProfileController extends Controller
{
    /**
     * Display administrator profile.
     */
    public function edit()
    {
        return view('admin.profile.edit', [
            'user' => auth()->user(),
        ]);
    }

    /**
     * Update administrator information and profile picture.
     */
    public function update(Request $request)
    {
        $user = auth()->user();

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],

            'email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('users', 'email')->ignore($user->id),
            ],

            'profile_photo' => [
                'nullable',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:2048',
            ],
        ]);

        $user->name = $validated['name'];
        $user->email = $validated['email'];

        // Upload new profile picture.
        if ($request->hasFile('profile_photo')) {

            $oldPhoto = $user->profile_photo_path;

            $newPath = $request->file('profile_photo')
                ->store('admin/profile-photos', 'public');

            $user->profile_photo_path = $newPath;
        }

        $user->save();

        // Delete old picture after successful database save.
        if (!empty($oldPhoto ?? null)) {
            Storage::disk('public')->delete($oldPhoto);
        }

        return redirect()
            ->route('admin.profile.edit')
            ->with('success', 'Your profile has been updated successfully.');
    }

    /**
     * Update administrator password.
     */
    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => [
                'required',
                'current_password',
            ],

            'password' => [
                'required',
                'string',
                'min:8',
                'confirmed',
            ],
        ], [
            'current_password.current_password' =>
                'Your current password is incorrect.',

            'password.confirmed' =>
                'The new password confirmation does not match.',
        ]);

        $user = auth()->user();

        // Laravel automatically hashes this through the User model cast.
        $user->password = $request->password;
        $user->save();

        return redirect()
            ->route('admin.profile.edit')
            ->with('success', 'Your password has been changed successfully.');
    }

    /**
     * Remove administrator profile picture.
     */
    public function removePhoto()
    {
        $user = auth()->user();

        if ($user->profile_photo_path) {

            Storage::disk('public')->delete(
                $user->profile_photo_path
            );

            $user->profile_photo_path = null;
            $user->save();
        }

        return redirect()
            ->route('admin.profile.edit')
            ->with('success', 'Your profile picture has been removed.');
    }
}
