<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use App\Models\UserProfile;
use App\Models\User;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    // Admin profile form
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    // Resident profile form
    public function residentEdit(Request $request): View
    {
        return view('profile.useredit', [
            'user' => $request->user(),
        ]);
    }

    // Update user profile
    public function update(Request $request)
{
    $user = auth()->user();

    $validated = $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|max:255|unique:users,email,' . $user->id,
        'password' => 'nullable|string|min:8|confirmed',

        // Profile fields (optional)
        'gender' => 'nullable|string|max:50',
        'date_of_birth' => 'nullable|date',
        'mobile_number' => 'nullable|string|max:20',
        'bio' => 'nullable|string',
        'address' => 'nullable|string|max:255',
        'profile_picture' => 'nullable|image|max:2048',
    ]);

    // Update users table
    $user->name = $validated['name'];
    $user->email = $validated['email'];

    if (!empty($validated['password'])) {
        $user->password = bcrypt($validated['password']);
    }

    $user->save();

    // Handle profile picture upload
  //  $profilePicturePath = optional($user->profile)->profile_picture;
// for local storage image only
  //  if ($request->hasFile('profile_picture')) {
    //    $profilePicturePath = $request->file('profile_picture')
      //      ->store('profile_pictures', 'public');
    //}

    // Handle profile picture upload
$profilePicturePath = optional($user->profile)->profile_picture;

if ($request->hasFile('profile_picture')) {

    $path = $request->file('profile_picture')->storePublicly(
        'profile_pictures',
        'spaces'
    );

    $profilePicturePath = Storage::disk('spaces')->url($path);
}

    // Update or create profile safely
    UserProfile::updateOrCreate(
        ['user_id' => $user->id],
        [
            'gender' => $validated['gender'] ?? null,
            'date_of_birth' => $validated['date_of_birth'] ?? null,
            'mobile_number' => $validated['mobile_number'] ?? null,
            'bio' => $validated['bio'] ?? null,
            'address' => $validated['address'] ?? null,
            'profile_picture' => $profilePicturePath,
        ]
    );

    return redirect()->back()->with('success', 'Your profile was updated successfully.');
}

    // Delete user account
    public function destroy(Request $request): RedirectResponse
    {
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
    public function viewUser($id)
{
    $user = User::with('profile')->findOrFail($id);

    return view('admin.reports.viewuser', compact('user'));
}
}
