<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

use App\Models\User;

use App\Http\Requests\auth\LoginRequest;
use App\Http\Requests\auth\RegisterRequest;
use App\Http\Requests\auth\EmailVerificationRequest;
use App\Http\Requests\auth\PasswordForgetRequest;
use App\Http\Requests\auth\PasswordResetRequest;
use App\Http\Requests\auth\PasswordChangeRequest;

use App\Mail\auth\RegisterMail;
use App\Mail\auth\EmailVerification;
use App\Mail\auth\PasswordReset;



class AuthController extends Controller
{
    // Get Login
    public function login()
    {
        // If user is already logged in, redirect to home
        if(Auth::check()) {

            // If the password expired
            $user = Auth::user();
            if($user->password_expires_at < now()) {
                return redirect()->route('auth.password.change')->with(['error' => 'Votre mot de passe a expiré']);
            }

            // If the email is not verified
            if(!$user->email_verified_at) {
                $user->generateUserToken();
                $this->sendEmailVerification();
                return redirect()->route('auth.email-verification', ['user_token' => $user->user_token]);
            }

            return redirect()->route('main.account')->with(['success' => 'Vous êtes connecté']);
            
        }

        // If user is not logged in,
        return view('auth.login');
    }

    // Get Register
    public function register()
    {
        return view('auth.register');
    }

    // Get Logout
    public function logout()
    {
        $user = Auth::user();
        if($user) {
            Auth::logout();
            return redirect()->route('auth.login')->with(['success' => 'Vous êtes maintenant déconnecté']);
        } else {
            return redirect()->route('auth.login')->with(['error' => 'Vous n\'êtes pas connecté']);
        }
    }

    // Get Email Verification
    public function emailVerification(String $user_token)
    {
        $user = User::where('user_token', $user_token)->first();

        if(!$user) {
            Auth::logout();
            return redirect()->route('auth.login')->with(['error' => 'Le token est invalide']);
        }

        if($user->user_token_expires_at < now()) {
            return redirect()->route('main.index')->with(['success' => 'Le token a expiré']);
        }

        if($user->email_verified_at) {
            return redirect()->route('main.index')->with(['success' => 'Votre email est déjà vérifié']);
        }


        return view('auth.email-verification')->with(['user_token' => $user_token]);
    }

    // Get Email Verification Resend
    public function emailVerificationResend(String $user_token)
    {

        $user = User::where('email_token', $user_token)->first();

        if(!$user) {
            return redirect()->route('auth.login')->with(['error' => 'Le token est invalide']);
        }

        if($user->user_token_expires_at < now()) {
            return redirect()->route('main.index')->with(['success' => 'Le token a expiré']);
        }

        if($user->email_verified_at) {
            return redirect()->route('main.index')->with(['success' => 'Votre email est déjà vérifié']);
        }

        $user->generateUserToken();
        $this->sendEmailVerification();

        return redirect()->route('auth.email-verification', ['user_token' => $user_token])->with(['success' => 'Email de vérification envoyé']);
    }


    // Post Login
    public function loginPost(LoginRequest $request)
    {
        $data = $request->all();

        $remember = $request->has('remember');

        if(Auth::attempt(['email' => $data['email'], 'password' => $data['password']], $remember)) {

            $user = Auth::user();

            if(!$user->email_verified_at) {
                $user->user_token = Str::random(30);
                $user->user_token_expires_at = now()->addHours(24);

                $this->sendEmailVerification();
                return redirect()->route('auth.email-verification', ['user_token' => $user->user_token]);
            }

            return redirect()->route('auth.login')->with(['success' => 'Vous êtes maintenant connecté']);
        } else{
            return redirect()->route('auth.login')->with(['error' => 'Email ou mot de passe incorrect']);
        }

    }

    // Post Register
    public function registerPost(RegisterRequest $request)
    {
        $data = $request->all();

        $user = User::create([
            'role'                  => 'member',
            'firstname'             => $data['firstname'],
            'lastname'              => $data['lastname'],
            'email'                 => $data['email'],
            'password'              => Hash::make($data['password']),
            'password_expires_at'   => now()->addYear(),
            'phone'                 => $data['phone'],
            'address'               => $data['address'],
            'city'                  => $data['city'],
            'postal_code'           => $data['postal_code'],
            'address_complement'    => $data['address_complement'],
            'country'               => $data['country'],
        ]);
        $user->save();
        
        // Envoi du mail de bienvenue
        Mail::send(new RegisterMail($user));

        // Authentification de l'utilisateur
        Auth::login($user);

        // Envoi du mail de vérification
        $user->generateUserToken();

        $this->sendEmailVerification();

        return redirect()->route('auth.email-verification', ['user_token' => $user->user_token]);
    }

    // Post Logout
    public function logoutPost()
    {
        $user = Auth::user();
        if($user) {
            Auth::logout();
            return redirect()->route('main.index')->with(['success' => 'Vous êtes maintenant déconnecté']);
        } else {
            return redirect()->route('auth.login')->with(['error' => 'Vous n\'êtes pas connecté']);
        }
    }

    // Post Email Verification
    public function emailVerificationPost(EmailVerificationRequest $request)
    {
        $data = $request->all();
        $email_token = $data['email_token'];
        $user = User::where('email_token', $email_token)->first();

        if(!$user) {
            return redirect()->route('auth.login')->with(['error' => 'L\'utilisateur n\'existe pas']);
        }

        if($user->email_verified_at) {
            return redirect()->route('main.index')->with(['success' => 'Votre email est déjà vérifié']);
        }

        if($user->email_token !== $email_token) {
            return redirect()->route('auth.email-verification', ['user_token' => $user->user_token])->with(['error' => 'Token invalide']);
        }

        if($user->email_token_expires_at < now()) {
            return redirect()->route('auth.email-verification', ['user_token' => $user->user_token])->with(['error' => 'Token expiré']);
        }

        $user->verifyEmail();
        $user->removeEmailToken();
        $user->removeUserToken();

        return redirect()->route('auth.login')->with(['success' => 'Votre email a été vérifié']);
    }

    // Send Email Verification
    public function sendEmailVerification()
    {
        $user = Auth::user();
        
        if(!$user) {
            return false;
        }

        $user->generateEmailToken();

        // Send email with token
        Mail::send(new EmailVerification($user));

        return true;
    }


    // Get Forgot Password
    public function forget()
    {
        return view('auth.password.forget');
    }

    // Get Reset Password
    public function reset(String $password_token)
    {
        if(!$password_token) {
            return redirect()->route('auth.password.forget')->with(['error' => 'Token invalide']);
        }

        $user = User::where('password_token', $password_token)->first();

        if(!$user) {
            return redirect()->route('auth.password.forget')->with(['error' => 'Token invalide']);
        }

        if($user->password_token_expires_at < now()) {
            return redirect()->route('auth.password.forget')->with(['error' => 'Token expiré']);
        }

        return view('auth.password.reset')->with(['password_token' => $password_token]);
    }

    // Get Change Password
    public function change()
    {
        $user = Auth::user();

        if(!$user) {
            return redirect()->route('auth.login')->with(['error' => 'Vous n\'êtes pas connecté']);
        }

        if($user->password_expires_at > now()) {
            return redirect()->route('auth.login')->with(['error' => 'Votre mot de passe n\'a pas expiré']);
        }

        return view('auth.password.change');
    }

    // Post Forgot Password
    public function forgetPost(PasswordForgetRequest $request)
    {
        $data = $request->all();
        $email = $data['email'];

        $user = User::where('email', $email)->first();

        if($user) {

            $user->generatePasswordToken();

            // Send email with token
            Mail::send(new PasswordReset($user));

        }
        
        return redirect()->route('auth.password.forget')->with(['success' => 'Si un compte existe avec cet email, un email de réinitialisation de mot de passe vous a été envoyé']);
    }

    // Post Reset Password
    public function resetPost(PasswordResetRequest $request)
    {
        $data = $request->all();
        $password_token = $data['password_token'];
        $password = $data['password'];

        $user = User::where('password_token', $password_token)->first();

        if(!$user) {
            return redirect()->route('auth.password.forget')->with(['error' => 'Token invalide']);
        }

        if($user->password_token_expires_at < now()) {
            return redirect()->route('auth.password.forget')->with(['error' => 'Token expiré']);
        }

        $user->password = Hash::make($password);
        $user->save();

        $user->removePasswordToken();

        return redirect()->route('auth.login')->with(['success' => 'Mot de passe réinitialisé']);
    }

    // Post Change Password
    public function changePost(PasswordChangeRequest $request)
    {
        $data = $request->all();
        $password = $data['password'];

        $user = Auth::user();

        if(!$user) {
            return redirect()->route('auth.login')->with(['error' => 'Vous n\'êtes pas connecté']);
        }

        if($user->password_expires_at > now()) {
            return redirect()->route('auth.login')->with(['error' => 'Votre mot de passe n\'a pas expiré']);
        }

        if(Hash::check($password, $user->password)) {
            return redirect()->route('auth.password.change')->with(['error' => 'Le nouveau mot de passe doit être différent de l\'ancien']);
        }

        $user->password = Hash::make($password);
        $user->password_expires_at = now()->addYear();

        $user->save();

        return redirect()->route('auth.login')->with(['success' => 'Mot de passe changé']);
    }
}
