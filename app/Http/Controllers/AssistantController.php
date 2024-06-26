<?php

namespace App\Http\Controllers;

use App\Http\Controllers\AdminController;
use App\Models\Media;

use App\Models\User;
use App\Services\CommonService;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Storage;

class AssistantController extends Controller
{

    public function assistantRegister(Request $request)
    {
        abort_if(!$request->hasValidSignature(), 403);
        $id = Crypt::decryptString($request->user);
        $user = User::where('id', $id)->select(['id', 'active', 'email'])->first();
        abort_if($user->active === 2, 403, 'Sorry, your account has been disabled!');
        // if ($user->active === 1) {
        //     return redirect('/login');
        // }

        return view("user.assistant.deal-register", compact('user'));
    }
    public function doAssistant(Request $request, User $user)
    {
        $data = $request->validate([
            'name' => 'required',
            'phone' => 'required|regex:/^\+1 \(\d{3}\) \d{3}-\d{4}$/',
            'password' => 'required:confirmed|min:8',
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
            'fillable-loan-application' => null,
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
        $borrower = User::find(Auth::id())->assistantCategories()->first();
        $success = true;

        foreach ($request->all() as $key => $file) {
            if ($key === '_token') {
                continue;
            }

            $catName = $this->catName($key);
            $cat = $catName ? $catName : ucwords(str_replace('-', ' ', $key));

            $user = User::find($borrower->user_id);
            $admin = new AdminController();
            $addCategoryResult = $admin->addCategoryToUser($request->merge(['name' => $cat]), $user);

            if ($addCategoryResult) {
                foreach (request()->file($key) as $category) {
                    $media = new Media();
                    $media->file_name = $category->getClientOriginalName();
                    $media->file_path = $category->store(getFileDirectory());
                    $media->file_size = $category->getSize();
                    $media->file_type = $category->getClientMimeType();
                    $media->file_extension = $category->getClientOriginalExtension();
                    $media->category = $cat;
                    $media->user_id = $borrower->user_id;
                    $media->uploaded_by = Auth::id();
                    if ($media->save()) {
                        $project = User::find($borrower->user_id)->project;
                        if($project){   
                            CommonService::storeNotification("$cat", Auth::id(),$project->id,$cat);
                        }else{
                            CommonService::storeNotification("$cat", Auth::id());
                        }
                    }
                }
            } else {
                $success = false;
                break;
            }
        }

        if ($success) {
            return back()->with('msg_success', "Files Upload Successfully");
        }

        return back()->with('msg_error', "Files Upload Failed");

    }

    public function deleteFile($id)
    {
        $media = Media::find($id);
        if ($media->delete()) {
            Storage::delete($media->file_path);
            return response()->json('file delete');
        }
        return ['msg_type' => 'msg_error', 'msg_value' => 'An error occured while deleting the file.'];
    }

}
