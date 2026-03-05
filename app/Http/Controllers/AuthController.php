<?php

namespace App\Http\Controllers;

use App\Http\Services\SiakadService;
use App\Models\ClassGroup;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Auth\Events\Registered;

class AuthController extends Controller
{
    public function __construct(
        private readonly SiakadService $siakadService
    ) {}

    public function showLogin()
    {
        return view('auth.login');
    }

    public function authenticate(Request $request)
    {
        $request->validate([
            'reg_number' => 'required',
            'password' => 'required',
        ]);

        try {
            // Check if user already registered
            $existingUser = User::where('reg_number', $request->reg_number)->first();
            
            if ($existingUser) {
                // User exists, attempt login with reg_number
                if (Auth::attempt(['reg_number' => $request->reg_number, 'password' => $request->password], true)) {
                    $request->session()->regenerate();
                    return redirect()->route('dashboard.home');
                }
                
                return back()->with('error', 'Login failed. Check your credentials.');
            }

            // New user - scrape from Siakad
            $isLoggedIn = $this->siakadService->login([
                'username' => $request->reg_number,
                'password' => $request->password,
            ]);

            if (!$isLoggedIn) {
                return back()->with('error', 'Login failed. Check your credentials.');
            }

            // Scrape student bio
            $studentBio = $this->siakadService->getStudentBio();

            // Find class group
            $classGroup = ClassGroup::where('name', $studentBio['class'])
                ->where('major', $studentBio['major'])
                ->first();

            if (!$classGroup) {
                return back()->with('error', 'Class group not found: ' . $studentBio['class'] . ' - ' . $studentBio['major']);
            }

            // Create new user
            $user = User::create([
                'name' => $studentBio['fullname'],
                'email' => $studentBio['email'],
                'email_verified_at' => now(),
                'reg_number' => $request->reg_number,
                'class_group_id' => $classGroup->id,
                'password' => Hash::make($request->password),
            ]);

            Auth::login($user, true); 
            event(new Registered($user));

            return redirect()->route('dashboard.home');

        } catch (\Exception $e) {
            return back()->with('error', 'Error: ' . $e->getMessage());
        }
    }

    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }

    
}
