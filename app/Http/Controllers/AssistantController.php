<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Media;
use App\Services\CommonService;
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

    protected function catName($cat)
    {
        $categoryMappings = [
            'credit-report' => 0,
            'fillable-loan-application' => 1,
            'bank-statements' => 2,
            'pay-stubs' => 3,
            'tax-returns' => 4,
            'iddrivers-license' => 5,
            '1003-form' => 6,
            'mortgage-statement' => 7,
            'evidence-of-insurance' => 8,
            'purchase-agreement' => 9,
            'miscellaneous' => 10,
        ];
        return config('smm.file_category')[$categoryMappings[$cat]] ?? null;
    }    

    public function submitDocument(Request $request)
    {
        $Borrower = User::find(Auth::id())->assistantCategories()->first();
        $success = true;
    
        foreach ($request->all() as $key => $file) {
            if ($key === '_token') continue;
            foreach (request()->file($key) as $category) {
                $media = new Media();
                $media->file_name = $category->getClientOriginalName();
                $media->file_path = $category->store(getFileDirectory());
                $media->file_size = $category->getSize();
                $media->file_type = $category->getClientMimeType();
                $media->file_extension = $category->getClientOriginalExtension();
                $media->category = $this->catName($key);
                $media->user_id = $Borrower->user_id;
                $media->uploaded_by = Auth::id();
                if ($media->save()){
                    CommonService::storeNotification("Uploaded $request->category", $request->id ?? Auth::id());
                }else{
                    $success = false;
                    break; // Stop processing if there's an error
                }
            }
        }
    
        if ($success) return back()->with('msg_success', "Files Upload Successfully");
        else return back()->with('msg_danger', "Files Upload Failed");
    }
    
}