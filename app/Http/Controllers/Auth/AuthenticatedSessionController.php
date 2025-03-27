<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use App\Models\Log;
use Illuminate\Validation\ValidationException;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(Request $request): RedirectResponse
{
    // Validation des données du formulaire
    $credentials = $request->validate([
        'email' => ['required', 'email'],
        'password' => ['required'],
    ]);

    // Vérification des identifiants
    if (!Auth::attempt($credentials, $request->boolean('remember'))) {
        // Log de l'échec de connexion
        Log::record('Échec de connexion', 'login_failed');

        throw ValidationException::withMessages([
            'email' => __('Ces identifiants ne correspondent pas à nos enregistrements.'),
        ]);
    }

    // Regénération de la session après connexion
    $request->session()->regenerate();

    // Log de la connexion réussie
    Log::record('Connexion réussie', 'login_success');

    // Suppression des anciens logs (plus de 180 jours)
    Log::deleteOldLogs(180);

    return redirect()->intended(route('dashboard'));
}


    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
