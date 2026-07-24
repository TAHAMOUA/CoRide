<?php

namespace App\Http\Controllers\Auth;

use App\Enums\RoleEmploye;
use App\Http\Controllers\Controller;
use App\Models\Employe;
use App\Models\Entreprise;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     *
     * Regle de gestion : un employe appartient a une seule entreprise, choisie
     * parmi les entreprises partenaires existantes (pas de saisie libre).
     */
    public function create(): View
    {
        $entreprises = Entreprise::orderBy('nom')->get();

        return view('auth.register', compact('entreprises'));
    }

    /**
     * Handle an incoming registration request.
     *
     * Cree un Employe (le modele d'authentification metier de CoRide, voir
     * config/auth.php -> providers.users.model), et non un User Breeze par
     * defaut qui n'est relie a aucune entreprise/role.
     *
     * @throws ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'nom' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.Employe::class],
            'entreprise_id' => ['required', 'integer', Rule::exists('entreprises', 'id')],
            'ville_residence' => ['required', 'string', 'max:255'],
            'role' => ['required', Rule::enum(RoleEmploye::class)],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $employe = Employe::create([
            'nom' => $validated['nom'],
            'email' => $validated['email'],
            'entreprise_id' => $validated['entreprise_id'],
            'ville_residence' => $validated['ville_residence'],
            'role' => $validated['role'],
            'password' => Hash::make($validated['password']),
        ]);

        event(new Registered($employe));

        Auth::login($employe);

        return redirect(route('dashboard', absolute: false));
    }
}
