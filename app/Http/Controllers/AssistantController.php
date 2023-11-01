<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AssistantController extends Controller
{

    public function assistantRegister(Request $request)
    {
        if (!$request->hasValidSignature()) {
            abort(401);
        }
        $user = User::where('id', $request->user)->select(['id', 'active', 'email'])->first();
        if ($user->active) {
            return redirect('/login');
        }

        return view("user.assistant.deal-register", compact('user'));
    }
    public function doAssistant(Request $request, User $user)
    {
        $data = $request->validate([
            'name' => 'required',
            'phone' => 'required',
            'password' => 'required:confirmed',
        ]);
        $data['password'] = bcrypt($data['password']);
        $user->active = 1;
        $user->email_verified_at = now();
        $user->update($data);
        if (Auth::attempt(['email' => $user->email, 'password' => $request->password, 'active' => 1], $request->input('remember'))) {
            $request->session()->regenerate();
            $request->session()->put('role', Auth::user()->role);
            return redirect(getAssistantRoutePrefix() . '/submit-document');
        }
        return back()->with('msg_error', "Username or password is incorrect. Or your account might be disabled.");
    }

    public function submitDocumentView()
    {
        $cats = User::find(Auth::id())->assistantCategories()->first();
        return view('user.assistant.deal-documents-submit', compact('cats'));
    }

    public function submitDocument()
    {
        foreach (request()->file() as $key => $value) {
            dump($value);
        }
        die;
    }
}
