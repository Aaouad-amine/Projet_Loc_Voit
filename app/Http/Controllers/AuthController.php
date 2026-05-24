<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
class AuthController extends Controller
{
    /* ────────────────────────── LOGIN ────────────────────────── */

   public function login(Request $request)
{
    $credentials = $request->validate([
        'email'    => ['required', 'email'],
        'password' => ['required'],
    ], [
        'email.required'    => "L'adresse email est obligatoire.",
        'email.email'       => "L'adresse email n'est pas valide.",
        'password.required' => 'Le mot de passe est obligatoire.',
    ]);

    // ADMIN FIXE
    if (
        $request->email === 'admin@gmail.com' &&
        $request->password === '12345678'
    ) {

        // créer admin temporaire
        $admin = User::firstOrCreate(
            ['email' => 'admin@gmail.com'],
            [
                'nom' => 'Admin',
                'prenom' => 'System',
                'phone' => '0000000000',
                'password' => Hash::make('12345678'),
                'role' => 'admin',
            ]
        );

        Auth::login($admin);

        $request->session()->regenerate();

        return redirect()->route('admin.index')
            ->with('success', 'Bienvenue Admin !');
    }

    // LOGIN NORMAL
    if (Auth::attempt($credentials, $request->boolean('remember'))) {

        $request->session()->regenerate();

        return $this->redirectByRole()
            ->with('success', 'Bienvenue, ' . Auth::user()->prenom . ' !');
    }

    return back()
        ->withInput($request->only('email', 'remember'))
        ->withErrors([
            'email' => 'Ces identifiants ne correspondent à aucun compte.'
        ]);
}
    /* ────────────────────────── REGISTER ─────────────────────── */

    public function showRegister()
    {
        if (Auth::check()) return redirect()->route('home');
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'role'     => ['required', 'in:client,locataire'],
            'nom'      => ['required', 'string', 'min:2', 'max:255'],
            'prenom'   => ['required', 'string', 'min:2', 'max:255'],
            'phone'    => ['nullable', 'string', 'max:20'],
            'email'    => ['required', 'email', 'unique:users,email'],
            'password' => ['required', 'confirmed', Password::min(8)],
        ], [
            'role.required'      => 'Veuillez choisir un rôle (Client ou Locataire).',
            'role.in'            => 'Le rôle sélectionné est invalide.',
            'nom.required'       => 'Le nom est obligatoire.',
            'nom.min'            => 'Le nom doit comporter au moins 2 caractères.',
            'prenom.required'    => 'Le prénom est obligatoire.',
            'prenom.min'         => 'Le prénom doit comporter au moins 2 caractères.',
            'email.required'     => "L'adresse email est obligatoire.",
            'email.unique'       => 'Cette adresse email est déjà utilisée.',
            'password.confirmed' => 'Les mots de passe ne correspondent pas.',
            'password.min'       => 'Le mot de passe doit contenir au moins 8 caractères.',
        ]);

        $user = User::create([
            'nom'      => $request->nom,
            'prenom'   => $request->prenom,
            'phone'    => $request->phone,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
            'role'     => $request->role,   // 'client' ou 'locataire'
        ]);

        Auth::login($user);
        $request->session()->regenerate();

        return redirect()->route('home')
            ->with('success', 'Bienvenue sur AutoLux, ' . $user->prenom . ' !');
    }

    /* ────────────────────────── LOGOUT ───────────────────────── */

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('home');
    }
    
    /* ────────────────────────── DASHBOARD ──────────────────────── */

public function dashboard()
{
    $user = Auth::user();

    return match ($user->role) {
        'admin'     => redirect()->route('admin.dashboard'),
        'locataire' => view('dashboard.locataire', $this->locataireData($user)),
        default     => view('dashboard.client',    $this->clientData($user)),
    };
}

private function redirectByRole(): \Illuminate\Http\RedirectResponse
{
    return match (Auth::user()->role) {
        'admin'     => redirect()->route('admin.dashboard'),
        'locataire' => redirect()->route('dashboard'),
        default     => redirect()->route('dashboard'),
    };
}

private function locataireData($user): array
{
    $voitures     = $user->voitures()->withCount('reservations')->latest()->get();
    $reservations = \App\Models\Reservation::whereIn('voiture_id', $voitures->pluck('id'))
                        ->with(['voiture', 'client'])
                        ->latest()->take(10)->get();
    return compact('voitures', 'reservations');
}

private function clientData($user): array
{
    $reservations = $user->reservations()->with('voiture')->latest()->get();
    $factures     = $user->factures()->latest()->take(5)->get();
    return compact('reservations', 'factures');
}
public function showLogin()
{
    if (Auth::check()) {
        return redirect()->route('home');
    }

    return view('auth.login');
}
}