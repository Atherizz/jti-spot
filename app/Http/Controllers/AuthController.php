<?php

namespace App\Http\Controllers;

use App\Http\Services\SiakadService;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;

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
        $validate = $request->validate([
            'username' => 'required',
            'email' => 'required|unique:users|email',
            'password' => 'required',
        ]);

        try {

            // $isRegistered = User::where('username')

            

            $isLoggedIn = $this->siakadService->login([
                'username' => $validate['username'],
                'password' => $validate['password'],
            ]);

            if ($isLoggedIn) {
                // Scrape the bio immediately after successful login
                $studentBio = $this->siakadService->getStudentBio();


                
                // Flash data to session for the welcome page
                return redirect()->route('welcome')->with('studentBio', $studentBio);
            }

            return back()->with('error', 'Login fails. Check your credentials.');
        } catch (\Exception $e) {
            return back()->with('error', 'Scraping error: ' . $e->getMessage());
        }
    }

    public function logout(Request $request): RedirectResponse
{
    Auth::logout();
 
    $request->session()->invalidate();
 
    $request->session()->regenerateToken();
 
    return redirect('/');
}

    public function welcome()
    {
        // Avoid error if the user accesses /welcome directly without logging in
        if (!session()->has('studentBio')) {
            return redirect()->route('login')->with('error', 'Please login first.');
        }

        return view('welcome', [
            'studentBio' => session('studentBio')
        ]);
    }
}
