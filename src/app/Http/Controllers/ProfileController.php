<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function show(Request $request)
    {
        $user = $request->user()->loadMissing('classGroup');

        $filledFields = collect([
            $user->name,
            $user->email,
            $user->reg_number,
            $user->role,
            optional($user->classGroup)->name,
        ])->filter(fn ($value) => filled($value))->count();

        $profileCompletion = (int) round(($filledFields / 5) * 100);

        $roleLabel = match ($user->role) {
            'admin' => 'Administrator',
            'class_rep' => 'Perwakilan Kelas',
            default => 'Mahasiswa',
        };

        return view('profile.show', compact('user', 'profileCompletion', 'roleLabel'));
    }
}
