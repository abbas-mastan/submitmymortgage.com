<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\AdminService;
use App\Services\CommonService;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{


    //============================
    //=============Teacher related methods
    //============================
    //Shows input for adding a teacher
    public function users(Request $request)
    {
        $data = AdminService::users($request);

        return view('admin.user.users', $data);
    }
    //Shows input for adding a teacher
    public function addUser(Request $request, $id)
    {
        if (session('role') === 'sadmin') {
            abort(403, 'You don\'t have the permission to access this resource');
        }
        $data = AdminService::addUser($request, $id);
        return view('admin.user.add-user', $data);
    }


    //Saves the record of a newly inserted teacher in database
    public function doUser(Request $request, $id)
    {
        if (session('role') === 'sadmin') {
            abort(403, 'You don\'t have the permission to access this resource');
        }
        $msg = AdminService::doUser($request, $id);
        return redirect('/dashboard')->with($msg['msg_type'], $msg['msg_value']);
    }


    //Shows input for adding a new package
    public function deleteUser(Request $request, $id)
    {

        $msg = AdminService::deleteUser($request, $id);
        return redirect('/dashboard')->with($msg['msg_type'], $msg['msg_value']);
    }
    //============================
    //=============Files related methods
    //============================
    //Shows input for adding a files
    public function filesCat(Request $request, $id = -1)
    {
        if ($request->ajax()) {
            $data['attachments'] = \App\Models\Attachment::where('user_id', Auth::id())->paginate(2);
            return $data;
        }
        $data = AdminService::filesCat($request, $id);
        return view('admin.file.file-cats', $data);
    }

    public function files(Request $request, $id = -1)
    {
        $data = AdminService::files($request, $id);

        return view('admin.file.files', $data);
    }
    //Showing documents for a user in specified category
    public function docs(Request $request, $id, $cat)
    {
        $data = AdminService::docs($request, $id, $cat);

        return view('admin.file.single-cat-docs', $data);
    }
    //Updates the status of  a files
    public function updateFileStatus(Request $request, $id)
    {
        $msg = AdminService::updateFileStatus($request, $id);
        return back()->with($msg['msg_type'], $msg['msg_value']);
    }
    //Updates the status of  a whole category
    public function updateCategoryStatus(Request $request)
    {
        $msg = AdminService::updateCategoryStatus($request);
        return back()->with($msg['msg_type'], $msg['msg_value']);
    }
    //Updates the category comments of a file category
    public function updateCatComments(Request $request, $cat)
    {
        $request->validate([
            'user_id' => 'required'
        ]);
        $msg = AdminService::updateCatComments($request, $cat);
        return back()->with($msg['msg_type'], $msg['msg_value']);
    }
    //Delete a files
    public function deleteFile(Request $request, $id)
    {
        $msg = AdminService::deleteFile($request, $id);
        return back()->with($msg['msg_type'], $msg['msg_value']);
    }
    //Uploads a files
    public function fileUpload(Request $request)
    {
        return CommonService::fileUpload($request);
    }

    //=====================================
    //==================Profile related methods
    //=====================================
    //Showing courses and their respective classes
    public function profile(Request $request)
    {
        $data[''] = '';
        return view('admin.profile.profile', $data);
    }
    //Updates profile data and picture

    public function doProfile(Request $request)
    {
        $msg = CommonService::doProfile($request);
        return redirect("/dashboard")->with($msg['msg_type'], $msg['msg_value']);
    }

    //============================================
    //==================Account related methods
    //============================================
    //Showing the input for account related information
    public function account(Request $request)
    {

        $data = AdminService::account($request);
        return view('admin.account.account', $data);
    }

    //Updates info of students after changing in the system
    public function updatePass(Request $request)
    {
        $msg = AdminService::updatePass($request);
        return redirect('/dashboard')->with($msg['msg_type'], $msg['msg_value']);
    }
}
