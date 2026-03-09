<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class ProfileController extends Controller
{
    /**
     * Show the profile settings page.
     */
    public function index()
    {
        return view('settings', [
            'user' => Auth::user()
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'bio' => ['nullable', 'string', 'max:1000'],
        ]);

        $user->update($validated);

        return back()->with('success', 'Profil berhasil diperbarui.');
    }

    /**
     * Update the user's profile photo.
     */
    public function updatePhoto(Request $request)
    {
        $request->validate([
            'foto_profile' => ['required', 'image', 'mimes:jpg,jpeg,png,gif', 'max:2048'],
        ]);

        $user = Auth::user();

        if ($request->hasFile('foto_profile')) {
            // Delete old photo if exists
            if ($user->foto_profile) {
                Storage::disk('public')->delete($user->foto_profile);
            }

            // Create Image Manager instance with GD driver
            $manager = new \Intervention\Image\ImageManager(new \Intervention\Image\Drivers\Gd\Driver());

            // Read the uploaded image
            $image = $manager->read($request->file('foto_profile'));

            // Scale down the image to a maximum of 500x500 pixels to make it even lighter
            $image->scaleDown(500, 500);

            // Encode the image into WEBP format with 80% quality
            $webpImage = $image->toWebp(80);

            // Generate a unique filename with .webp extension
            $filename = 'profiles/' . uniqid('profile_') . '.webp';

            // Save the WEBP image to storage
            Storage::disk('public')->put($filename, (string) $webpImage);

            $user->update(['foto_profile' => $filename]);
        }

        return back()->with('success', 'Foto profil berhasil diperbarui.');
    }

    /**
     * Update the user's password.
     */
    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => ['required', 'current_password'],
            'password' => ['required', 'confirmed', \Illuminate\Validation\Rules\Password::defaults()],
        ], [
            'current_password.current_password' => 'Password saat ini salah.',
            'password.confirmed' => 'Konfirmasi password baru tidak cocok.',
        ]);

        Auth::user()->update([
            'password' => Hash::make($request->password),
        ]);

        return back()->with('success', 'Password berhasil diperbarui.');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request)
    {
        $request->validate([
            'password' => ['required', 'current_password'],
            'confirmation' => ['required', 'string', 'in:KONFIRMASI'],
        ], [
            'password.current_password' => 'Password yang Anda masukkan salah.',
            'confirmation.in' => 'Anda harus mengetik KONFIRMASI untuk melanjutkan.',
        ]);

        $user = Auth::user();

        Auth::logout();

        if ($user->foto_profile) {
            Storage::disk('public')->delete($user->foto_profile);
        }

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login')->with('success', 'Akun Anda berhasil dihapus selamanya.');
    }
}
