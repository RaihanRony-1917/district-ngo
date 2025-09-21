<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    //
    public function edit(Request $request)
    {
        return view('pages.profile.form', [
            'user' => $request->user(),
        ]);
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        // Validate the request data
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'image' => ['nullable', 'image', 'max:2048'], // 2MB Max
        ]);

        // Update the name
        $user->name = $validated['name'];

        // Handle the photo upload
        if ($request->hasFile('image')) {
            // Delete the old photo if it exists
            if ($user->image && Storage::disk('public')->exists($user->image)) {
                Storage::disk('public')->delete($user->image);
            }

            // Store the new photo and update the user's photo path
            $path = $request->file('image')->store('profile-photos', 'public');
            $user->image = $path;
        }

        $user->save();

        // Redirect back with a success status
        return redirect()->route('admin.profile.edit')->with('status', 'profile-updated');
    }

}
