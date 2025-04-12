<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use App\Models\User;

class SettingsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $user = Auth::user();
        return view('settings', compact('user'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        if ($request->hasFile('profile_picture')) {
            try {
                $request->validate([
                    'profile_picture' => 'required|image|mimes:jpeg,png,jpg|max:2048'
                ]);

                // Delete old profile picture if exists
                if ($user->profile_picture && Storage::exists('public/profile_pictures/' . $user->profile_picture)) {
                    Storage::delete('public/profile_pictures/' . $user->profile_picture);
                }

                // Store new profile picture
                $image = $request->file('profile_picture');
                $imageName = time() . '_' . $image->getClientOriginalName();
                $path = $image->storeAs('public/profile_pictures', $imageName);
                
                if (!$path) {
                    throw new \Exception('Failed to store image');
                }

                // Update user profile picture
                User::where('id', $user->id)->update([
                    'profile_picture' => $imageName
                ]);

                if ($request->wantsJson()) {
                    return response()->json([
                        'success' => true,
                        'message' => 'Foto profil berhasil diubah',
                        'image_url' => Storage::url('profile_pictures/' . $imageName)
                    ]);
                }

                return redirect()->route('settings')->with('success', 'Foto profil berhasil diubah');
            } catch (\Exception $e) {
                if ($request->wantsJson()) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Gagal mengupload foto profil: ' . $e->getMessage()
                    ], 500);
                }
                return redirect()->route('settings')->with('error', 'Gagal mengupload foto profil: ' . $e->getMessage());
            }
        }

        // Validate user data
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        $updateData = [
            'name' => $request->name,
            'email' => $request->email,
        ];

        // Only update password if it's provided
        if ($request->filled('password')) {
            $updateData['password'] = Hash::make($request->password);
        }

        User::where('id', $user->id)->update($updateData);

        return redirect()->route('settings')->with('success', 'Profil berhasil diperbarui');
    }
} 