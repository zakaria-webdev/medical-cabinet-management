<?php

namespace App\Http\Controllers;

// Import the User model → to create and find users in DB
use App\Models\User;
// Import Patient model → to create patient profile after registration
use App\Models\Patient;
// Request → contains everything the user sent (form fields, files, etc.)
use Illuminate\Http\Request;
// Auth → Laravel's login/logout/session system
use Illuminate\Support\Facades\Auth;
// Hash → to encrypt passwords with bcrypt before saving
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    // =============================================
    // SHOW REGISTER PAGE
    // =============================================
    // GET /register → browser asks for the page → we return the view
    // No logic here, just display the form
    public function showRegisterForm()
    {
        return view('auth.register');
        // 'auth.register' = resources/views/auth/register.blade.php
        // dot (.) = folder separator
    }

    // =============================================
    // PROCESS REGISTRATION
    // =============================================
    // POST /register → user submitted the form → validate → save → login
    public function register(Request $request)
    {
        // STEP 1: VALIDATE
        // Laravel checks all rules BEFORE we do anything
        // If any rule fails → redirect back automatically with error messages
        // Code below never runs if validation fails
        $request->validate([
            'nom'      => 'required|string|max:100',
            // required = cannot be empty
            // string = must be text
            // max:100 = max 100 characters

            'prenom'   => 'required|string|max:100',

            'email'    => 'required|email|unique:users,email',
            // email = must contain @ and valid format
            // unique:users,email = this email must not already exist
            // in the 'email' column of 'users' table → no duplicate accounts

            'password' => 'required|min:8|confirmed',
            // min:8 = at least 8 characters
            // confirmed = form must also have 'password_confirmation' field
            // and both must be identical → prevents typos
        ]);
        // NO 'role' field here → role is always forced to 'patient'
        // Médecin/Secrétaire accounts are created by Admin only

        // STEP 2: CREATE USER ACCOUNT
        $user = User::create([
            'nom'      => $request->nom,
            'prenom'   => $request->prenom,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
            // Hash::make() = bcrypt algorithm
            // 'abc123' becomes '$2y$10$KIx9s...' (60 chars, irreversible)
            // Even if DB is stolen → passwords cannot be read
            'role'     => 'patient',
            // HARDCODED → not taken from the form
            // Even if hacker adds role=admin to the request → ignored
        ]);

        // STEP 3: CREATE PATIENT PROFILE
        // users table = login info (email, password, role)
        // patients table = medical info (phone, address, etc.)
        // We create a linked patient profile for this new user
        Patient::create([
            'user_id'        => $user->id,
            // foreign key → links this patient to the user account
            'nom'            => $request->nom,
            'prenom'         => $request->prenom,
            'telephone'      => '',
            // empty for now → patient fills it later in his profile
            'date_naissance' => now(),
            // placeholder → patient updates it later
            'sexe'           => 'Homme',
            // default → patient updates it later
        ]);

        // STEP 4: AUTO-LOGIN after registration
        // No need to go to login page after registering
        Auth::login($user);
        // Creates a session → user is now authenticated

        // STEP 5: REDIRECT to patient dashboard
        return redirect()->route('patient.dashboard');
    }

    // =============================================
    // SHOW LOGIN PAGE
    // =============================================
    // GET /login → just display the form
    public function showLoginForm()
    {
        return view('auth.login');
        // = resources/views/auth/login.blade.php
    }

    // =============================================
    // PROCESS LOGIN
    // =============================================
    // POST /login → user submitted email + password → verify → redirect
    public function login(Request $request)
    {
        // STEP 1: BASIC VALIDATION
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required',
            // We don't check min:8 here
            // The real password check happens inside Auth::attempt()
        ]);

        // STEP 2: EXTRACT CREDENTIALS
        $credentials = $request->only('email', 'password');
        // only() = take just these two fields from the request
        // Safer than passing all form data to attempt()

        $remember = $request->boolean('remember');
        // boolean('remember') = true if "Se souvenir de moi" checkbox is checked
        // When true → Laravel creates a long-lived cookie
        // User stays logged in even after closing the browser

        // STEP 3: AUTH::ATTEMPT()
        // Internally does this:
        // 1. SELECT * FROM users WHERE email = 'submitted@email.com'
        // 2. If no user found → return false
        // 3. If found → Hash::check('submitted_password', 'stored_hash')
        //    bcrypt can verify even though Hash::make() gives different result each time
        //    (because the random salt is stored inside the hash string itself)
        // 4. If match → create session → return true
        // 5. If no match → return false
        if (Auth::attempt($credentials, $remember)) {

            $request->session()->regenerate();
            // SECURITY: generate a NEW session ID after login
            // Why? Before login, visitor had an anonymous session ID
            // If hacker captured that ID, they could reuse it after login
            // → called "Session Fixation Attack"
            // regenerate() = new ID → old one is useless

            return $this->redirectByRole(Auth::user());
            // Auth::user() = the User object that just logged in
            // We send them to the right dashboard based on their role
        }

        // STEP 4: LOGIN FAILED
        return back()
            ->withErrors(['email' => 'Email ou mot de passe incorrect.'])
            // withErrors() = send error message back to the form
            // We attach it to 'email' field (not 'password')
            // Security: never tell the hacker which field was wrong
            ->withInput($request->except('password'));
            // withInput() = refill the form with what was typed
            // except('password') = refill everything EXCEPT password
            // Never pre-fill password fields (browser security rule)
    }

    // =============================================
    // LOGOUT
    // =============================================
    public function logout(Request $request)
    {
        Auth::logout();
        // Removes the user from the current session
        // auth()->user() returns null after this line

        $request->session()->invalidate();
        // Destroys ALL session data (not just the user)

        $request->session()->regenerateToken();
        // Creates a new CSRF token
        // The old token in user's browser is now invalid
        // Prevents CSRF attacks after logout

        return redirect()->route('login');
        // Send back to login page
    }

    // =============================================
    // PRIVATE HELPER: Redirect by role
    // =============================================
    // private = only callable from INSIDE this class
    // Not a route → internal use only
    // Called by login() and register()
    private function redirectByRole(User $user)
    {
        // match() = PHP 8 clean version of switch/case
        // Checks $user->role and returns the matching redirect
        // default = safety net if role has unexpected value
        return match($user->role) {
            'admin'      => redirect()->route('admin.dashboard'),
            'medecin'    => redirect()->route('medecin.dashboard'),
            'secretaire' => redirect()->route('secretaire.dashboard'),
            'patient'    => redirect()->route('patient.dashboard'),
            default      => redirect('/'),
        };
    }
}