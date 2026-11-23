<?php // PHP opening tag

namespace App\Http\Controllers; // Controller namespace declaration

use App\Models\User; // Import User model class
use Exception; // Import base Exception class
use Illuminate\Http\RedirectResponse; // Import HTTP redirect response
use Illuminate\Support\Facades\Auth; // Import Auth facade
use Illuminate\Support\Facades\Hash; // Import Hash facade for secure passwords
use Illuminate\Support\Str; // Import Str utility for cryptographic random tokens
use Laravel\Socialite\Facades\Socialite; // Import Socialite facade

class GoogleController extends Controller { // Controller managing Google OAuth authentication
    public function redirect_to_google(): RedirectResponse { // Redirect user to Google OAuth consent
        return Socialite::driver('google')->redirect(); // Trigger socialite redirect
    } // End of redirect_to_google method

    public function redirectToGoogle(): RedirectResponse { // CamelCase alias for backward compatibility
        return $this->redirect_to_google(); // Delegate to snake_case implementation
    } // End of redirectToGoogle alias

    public function handle_google_callback(): RedirectResponse { // Process OAuth callback from Google
        try { // Wrap OAuth retrieval in error catching block
            $google_user = Socialite::driver('google')->user(); // Retrieve user profile from Google OAuth provider
            $user = User::where('google_id', $google_user->getId())->first(); // Check if user already linked via google_id
            if (!$user) { // If user was not found by google_id
                $user = User::where('email', $google_user->getEmail())->first(); // Check if existing user has matching email
                if ($user) { // If user exists with same email address
                    $user->update(['google_id' => $google_user->getId()]); // Link Google ID to existing account
                } else { // Otherwise create a fresh user account
                    $user = User::create([ // Persist new user in database
                        'name' => $google_user->getName() ?? 'Usuario Google', // Assign name from Google profile
                        'email' => $google_user->getEmail(), // Assign verified email from Google
                        'google_id' => $google_user->getId(), // Save unique provider Google ID
                        'password' => Hash::make(Str::random(32)), // Generate secure cryptographic random password
                    ]); // Close user creation attributes array
                } // Close user branching
            } // Close existing user lookup
            Auth::login($user, true); // Log in user with remember session enabled
            return redirect()->intended('/dashboard'); // Redirect to intended destination or dashboard
        } catch (Exception $exception) { // Catch any OAuth communication errors
            return redirect()->route('login')->withErrors(['email' => 'Error al iniciar sesión con Google.']); // Redirect with message
        } // Close try-catch block
    } // End of handle_google_callback method

    public function handleGoogleCallback(): RedirectResponse { // CamelCase alias for backward compatibility
        return $this->handle_google_callback(); // Delegate to snake_case implementation
    } // End of handleGoogleCallback alias
} // End of GoogleController class
