<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use App\Models\User;

class ProfileController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function show()
    {
        $user = Auth::user();
        $orders = $user->orders()->latest()->limit(5)->get();
        return view('profile.index', compact('user', 'orders'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'fullname'      => 'required|string|max:255',
            'email'         => 'required|email|max:255|unique:users,email,' . $user->id,
            'phone'         => 'nullable|string|max:20',
            'bio'           => 'nullable|string|max:500',
            'profile_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:3072',
            'old_password'  => 'nullable|required_with:new_password',
            'new_password'  => 'nullable|string|min:6|confirmed',
        ]);

        $imageName = $user->profile_image ?? 'default.jfif';

        if ($request->hasFile('profile_image')) {
            $file = $request->file('profile_image');
            $imageName = 'profile_' . time() . '_' . uniqid() . '.' . $file->extension();
            $file->storeAs('public/profile_images', $imageName);

            if ($user->profile_image && $user->profile_image !== 'default.jfif') {
                $oldPath = 'public/profile_images/' . $user->profile_image;
                if (Storage::exists($oldPath)) {
                    Storage::delete($oldPath);
                }
            }
        }

        if ($request->filled('new_password')) {
            if (!Hash::check($request->old_password, $user->password)) {
                return back()->with('error', 'លេខសម្ងាត់ចាស់មិនត្រឹមត្រូវទេ!');
            }
            $user->password = Hash::make($request->new_password);
        }

        $user->name = $request->fullname;
        $user->email = $request->email;
        $user->phone = $request->phone ?? '';
        $user->bio = $request->bio ?? '';
        $user->profile_image = $imageName;
        $user->save();

        session([
            'user_name'  => $user->name,
            'user_bio'   => $user->bio,
            'user_image' => $imageName,
        ]);

        return redirect()->route('profile.index')->with('success', 'ព័ត៌មានរបស់អ្នកត្រូវបានធ្វើបច្ចុប្បន្នភាព។');
    }
}
