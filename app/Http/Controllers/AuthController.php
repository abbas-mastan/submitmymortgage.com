<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\{Redirect, Hash, Auth, Password};
use App\Services\AdminService;
use Illuminate\Support\Str;
use Illuminate\Auth\Events\{Verified, PasswordReset};

class AuthController extends Controller
{
    //Called when a user submits login form
    //Or press login button in login form
    public function doLogin(Request $request)
    {
        //$credentials = $request->only('email', 'password');
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password, 'active' => 1], $request->input('remember'))) {
            // Authentication passed...
            $request->session()->regenerate();
            $request->session()->put('role', Auth::user()->role);
            return redirect()->intended('/dashboard');
        }
        return redirect('/login')->with('msg_error', "Username or password is incorrect. Or your account might be disabled.");
    }
    //Called when a user tries to logout
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        return redirect('/');
    }

    //Show view for password reset link
    public function forgotPassword(Request $request)
    {
        return view('auth.forgot-password');
    }

    public function sendForgotPasswordLink(Request $request)
    {
        $request->validate(['email' => 'required|email']);
        $status = Password::sendResetLink(
            $request->only('email')
        );
        return $status === Password::RESET_LINK_SENT
            ? back()->with(['msg_success' => __($status)])
            : back()->withErrors(['email' => __($status)]);
    }

    public function resetPassword(Request $request, $token)
    {
        return view('auth.reset-password', ['token' => $token, 'email' => $request->email]);
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|confirmed',
        ]);

        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) {
                $user->forceFill([
                    'password' => Hash::make($password)
                ])->setRememberToken(Str::random(60));

                $user->save();

                event(new PasswordReset($user));
            }
        );

        return $status === Password::PASSWORD_RESET
            ? redirect()->route('login')->with('msg_success', __($status))
            : back()->withErrors(['email' => [__($status)]]);
    }
    //Method to be called for registeration form
    public function register()
    {

        $data['unis'] = '';
        return view('auth.register', $data);
    }
    //Method to be called for saving registeration in the database
    public function doRegister(Request $request)
    {

        $id = -1;
        $msg = AdminService::doUser($request, $id);
        return redirect('/login')->with($msg['msg_type'], $msg['msg_value']);
    }

    //Method to be called for notifying email verification
    public function notifyEmailVerification(Request  $request)
    {

        return Redirect::to('/login')->with("msg_info", 'Check your email for verification link');
    }
    //Method to be called for handling email verification
    public function emailVerificationHandler(Request  $request)
    {
        $userId = $request->route('id');
        $user = User::findOrFail($userId);
        if ($user->markEmailAsVerified()) {
            event(new Verified($user));
        }
        Auth::login($user);
        //$request->fulfill();
        return Redirect::to('/dashboard'); //->with("msg_success", 'Email sucessfully verified. Please login to access your profile.');
    }

    //Resend the email verification link again

    public function emailVerificationResend(Request  $request)
    {
        $request->user()->sendEmailVerificationNotification();
        return back()->with('msg_info', 'Verification link sent!');
    }
}
