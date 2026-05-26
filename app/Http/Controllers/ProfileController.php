<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class ProfileController extends Controller
{
    /**
     * POST /profile/update — Update user's name, bio, profile image, and password.
     */
    public function update(Request $request)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $user = Auth::user();

        $request->validate([
            'fullname'      => 'required|string|max:255',
            'bio'           => 'nullable|string|max:500',
            'profile_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'old_password'  => 'nullable|required_with:new_password',
            'new_password'  => 'nullable|string|min:6|different:old_password',
        ]);

        // ── Handle profile image upload ──
        $imageName = $user->profile_image ?? 'default.jfif';
        if ($request->hasFile('profile_image')) {
            $file = $request->file('profile_image');
            $imageName = time() . '_' . uniqid() . '.' . $file->extension();
            $file->move(public_path('assets/profiles'), $imageName);

            // Delete old non-default image
            if ($user->profile_image && $user->profile_image !== 'default.jfif') {
                $oldPath = public_path('assets/profiles/' . $user->profile_image);
                if (file_exists($oldPath)) {
                    unlink($oldPath);
                }
            }
        }

        // ── Handle password change ──
        $canUpdate = true;
        if ($request->filled('new_password')) {
            if ($request->filled('old_password') && Hash::check($request->old_password, $user->password)) {
                $user->password = Hash::make($request->new_password);
            } else {
                $canUpdate = false;
                return back()->with('error', 'លេខសម្ងាត់ចាស់មិនត្រឹមត្រូវទេ!');
            }
        }

        // ── Update profile fields ──
        if ($canUpdate) {
            $user->name = $request->fullname;
            $user->bio = $request->bio ?? '';
            $user->profile_image = $imageName;
            $user->save();

            // Refresh session
            session([
                'user_name'  => $user->name,
                'user_bio'   => $user->bio,
                'user_image' => $imageName,
            ]);

            return redirect()->route('home')->with('success', 'ព័ត៌មានរបស់អ្នកត្រូវបានធ្វើបច្ចុប្បន្នភាព។');
        }

        return back();
    }
}
