<?php

namespace App\Http\Controllers;

use App\Mail\AssistantMail;
use App\Mail\UserMail;
use App\Models\User;
use App\Services\AdminService;
use App\Services\CommonService;
use Carbon\Carbon;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Auth\Events\Verified;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules\Password as PasswordRule;

class AuthController extends Controller
{
    public function userRegister(Request $request)
    {
        $expires = $request->input('expires');
        $id = Crypt::decryptString($request->user);
        $user = User::find($id);
        if ($user->email_verified_at) {
            return redirect()->route('login');
        }
        if (now()->timestamp > $expires) {
            $request['user'] = $user;
            $request['email'] = $user->email;
            $this->emailVerificationResend($request);
            return $this->doLogin($request);
        }
        abort_unless($request->hasValidSignature(), 403, 'The signature is not valid');
        $token = DB::table('password_resets')->where('email', $user->email)->value('token');
        if ($user->role === 'Borrower' && $user->password !== 'null') {
            $user->email_verified_at = now();
            $user->save();
            $this->loginwithid($user->id);
            $request->session()->regenerate();
            $request->session()->put('role', $user->role);
            return redirect('/dashboard');
        }
        return view('auth.reset-password', compact('token', 'user'));
    }

    public function loginwithid($id)
    {
        return Auth::loginUsingId($id);
    }

    public function setPasswordForNewUsers(Request $request)
    {
        // this validation checking password and token also
        $this->passwordValidation($request);
        $token = DB::table('password_resets')->where('email', $request->email)->value('token');
        if ($token == $request->token) {
            $user = User::where('email', $request->email)->first();
            $user->password = Hash::make($request->password);
            if (!$user->emaail_verified_at) {
                $user->email_verified_at = now();
            }
            $user->save();
        } else {
            return back()->with('msg_error', 'Token does not match');
        }
        return $this->doLogin($request);
    }

    public function doLogin(Request $request)
    {
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password, 'active' => 1], $request->input('remember'))) {
            // Authentication passed...
            $user = Auth::user();
            $request->session()->regenerate();
            $request->session()->put('role', $user->role);
            if ($user->role === 'Assistant') {
                return redirect(getAssistantRoutePrefix() . '/submit-document');
            }
            if($user->trial && $user->trial->login_sequence < 1){
                $user->trial->update(['login_sequence' => 1]);
                return redirect()->intended('/dashboard')->with('msg_success','Your 7 days trial
                 period started successfully!');
            }

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
        // this validation checking password and token also
        dd($request->all());
        $this->passwordValidation($request);
        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) {
                $user->forceFill([
                    'password' => Hash::make($password),
                ])->setRememberToken(Str::random(60));
                if (!$user->emaail_verified_at) {
                    $user->email_verified_at = now();
                }
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
        $request->merge(['sendemail' => 'on']);
        $msg = AdminService::doUser($request, $id);
        $msg['msg_info'] = 'Please check your email inbox to verify email.';
        $user = User::where('email', $request->email)->first();
        if ($user->email_verified_at === null) {
            $this->loginwithid($user->id);
            return redirect()->route('verification.notice');
        }
    }

    //Method to be called for notifying email verification
    public function notifyEmailVerification(Request $request)
    {
        // return Redirect::to('/login')->with("msg_info", 'Check your email for verification link');
        if ($request->user()->email_verified_at != null) {
            $this->loginwithid($request->user()->id);
            $request->session()->regenerate();
            $request->session()->put('role', Auth::user()->role);
            return redirect()->intended('/dashboard');
        }
        return view('auth.verify', ['status' => session('status')]);
    }
    //Method to be called for handling email verification
    public function emailVerificationHandler(Request $request)
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

    public function emailVerificationResend(Request $request)
    {
        // $request->user()->sendEmailVerificationNotification();
        $role = $request->user()->role ?? $request->user->role;
        $email = $request->user()->email ?? $request->user->email;
        $requestId = $request->user()->id ?? $request->user->id;
        $id = Crypt::encryptString($requestId);
        DB::table('password_resets')->insert(['email' => $email, 'token' => Hash::make(Str::random(12)), 'created_at' => now()]);
        $url = function () use ($id, $role) {return Url::signedRoute($role !== 'Borrower' && $role !== 'Assistant' ? 'user.register' : 'borrower.register', ['user' => $id], now()->addMinutes(10));};
        Mail::to($email)->send($role !== 'Borrower' && $role !== 'Assistant' ? new UserMail($url()) : new AssistantMail($url()));
        return back()->with('msg_info', 'Verification link sent!');
    }

    public function passwordExpired()
    {
        return view('auth.reset-password')->with('msg_info', 'Your password has expired. Please change it.');
    }
    public function expiredPasswordUpdate(Request $request)
    {
        // Checking current password
        if (!Hash::check($request->current_password, $request->user()->password)) {
            return redirect()->back()->withErrors(['current_password' => 'Current password is not correct']);
        }
        CommonService::validatePassword($request);
        $request->user()->update([
            'password' => bcrypt($request->password),
            'password_changed_at' => Carbon::now()->toDateTimeString(),
        ]);
        return redirect()->back()->with(['msg_success' => 'Password changed successfully']);
    }

    private function passwordValidation(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => ['required', PasswordRule::min(12)
                    ->mixedCase()
                    ->letters()
                    ->numbers()
                    ->symbols()
                    ->uncompromised(), 'confirmed'],
        ], [
            'password.required' => 'The password field is required.',
            'password.confirmed' => 'The password confirmation does not match.',
            'password.*' => 'The password must be at least 12 characters long and contain a mix of uppercase and lowercase letters, numbers, and symbols.',
        ]);
    }
}
