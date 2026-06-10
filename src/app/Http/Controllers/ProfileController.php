<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Validation\Rules\Password;

class ProfileController extends Controller
{
    public function show(Request $request)
    {
        $user = $request->user()->loadMissing('classGroup');

        $filledFields = collect([
            $user->name,
            $user->email,
            $user->reg_number,
            $user->phone_number,
            $user->role,
            optional($user->classGroup)->name,
        ])->filter(fn ($value) => filled($value))->count();

        $profileCompletion = (int) round(($filledFields / 6) * 100);

        $roleLabel = match ($user->role) {
            'admin' => 'Administrator',
            'class_rep' => 'Perwakilan Kelas',
            default => 'Mahasiswa',
        };

        return view('profile.show', compact('user', 'profileCompletion', 'roleLabel'));
    }

    public function updatePhone(Request $request): RedirectResponse
    {
        $request->merge([
            'phone_number' => preg_replace('/\D+/', '', (string) $request->input('phone_number')),
        ]);

        $validated = $request->validate([
            'phone_number' => ['required', 'string', 'max:20', 'regex:/^(0|62)\d{8,15}$/'],
        ], [
            'phone_number.required' => 'Nomor WhatsApp wajib diisi.',
            'phone_number.regex' => 'Gunakan nomor WhatsApp Indonesia yang valid, contoh: 085235342960.',
        ]);

        $request->user()->update([
            'phone_number' => $validated['phone_number'],
        ]);

        return back()->with('success', 'Nomor WhatsApp berhasil diperbarui.');
    }

    public function updatePassword(Request $request): RedirectResponse
    {
        if ($request->user()->role !== 'admin') {
            abort(403);
        }

        $validated = $request->validate([
            'current_password' => ['required', 'current_password'],
            'password' => ['required', 'confirmed', Password::min(8)],
        ], [
            'current_password.current_password' => 'Kata sandi saat ini tidak sesuai.',
            'password.confirmed' => 'Konfirmasi kata sandi baru tidak cocok.',
        ]);

        $request->user()->update([
            'password' => $validated['password'],
        ]);

        return back()->with('success', 'Kata sandi berhasil diperbarui.');
    }
}
