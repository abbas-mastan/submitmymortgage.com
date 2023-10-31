<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AssistantController extends Controller
{
    public function doAssistant(Request $request, User $user)
    {
        $request->merge([
            'email' => $user->email,
        ]);
        $data = $request->validate([
            'name' => 'required',
            'phone' => 'required',
            'email' => '',
            'password' => 'required:confirmed',
        ]);
        $data['password'] = bcrypt($data['password']);
        $user->update($data);
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password, 'active' => 1], $request->input('remember'))) {
            // Authentication passed...
            $request->session()->regenerate();
            $request->session()->put('role', Auth::user()->role);
            return redirect(getAssistantRoutePrefix() . '/submit-document');
        }
        return back()->with('msg_error', "Username or password is incorrect. Or your account might be disabled.");
    }

    
    public function submitDocument()
    {
        return view('user.assistant.deal-documents-submit');
    }
    public function login()
    {
        dd('asdfasdf');
    }
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        return redirect(getAssistantRoutePrefix().'/login');
    }
}
