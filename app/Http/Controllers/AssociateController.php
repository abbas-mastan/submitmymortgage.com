<?php

namespace App\Http\Controllers;

use App\Models\Info;
use App\Models\User;
use App\Models\Application;
use Illuminate\Http\Request;
use App\Services\UserService;
use App\Services\AdminService;
use App\Services\CommonService;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\ApplicationRequest;

class AssociateController extends Controller
{
    public function profile(Request $request)
    {
        $data[''] = '';
        return view('admin.profile.profile', $data);
    }

    public function doProfile(Request $request)
    {
        $msg = CommonService::doProfile($request);
        return redirect("/dashboard")->with($msg['msg_type'], $msg['msg_value']);
    }

    public function addUser(Request $request, $id)
    {
        $data = AdminService::addUser($request, $id);
        return view('admin.user.add-user', $data);
    }

    public function doUser(Request $request, $id)
    {
        $msg = AdminService::doUser($request, $id);
        return redirect('/dashboard')->with($msg['msg_type'], $msg['msg_value']);
    }

    public function basicInfo()
    {
        $data['info'] = new Info();
        return view('user.info.basic-info', $data);
    }

    public function application(Request $request)
    {
        $data = UserService::application($request);
        return view('user.loan.application', $data);
    }

    public function doApplication(ApplicationRequest $request)
    {
        $data = CommonService::doApplication($request);
        return redirect('/dashboard')->with($data['msg_type'], $data['msg_value']);
    }

    public function filesCat(Request $request, $id = -1)
    {
        if ($request->ajax()) {
            $data['attachments'] = \App\Models\Attachment::where('user_id', Auth::id())->paginate(2);
            return $data;
        }
        $data = AdminService::filesCat($request, $id);
        return view('admin.file.file-cats', $data);
    }

    public function docs(Request $request, $id, $cat)
    {
        if ($cat === "Loan Application") {
            $id = User::find($id)->application()->first()->id;

            return redirect(getAssociateRoutePrefix() . '/application-show/' . $id);
        } else {
            $data = AdminService::docs($request, $id, $cat);
            return view("admin.file.single-cat-docs", $data);
        }
    }

    public function applicationShow(Application $application)
    {
        $data['application'] = $application;
        return view('admin.applications.show', $data);
    }

    public function allUsers()
    {
        $user = Auth::user();
        $data['usersCount'] = $user->createdUsers()->whereIn('role', ['Processor', 'Associate', 'Junior Associate', 'Borrower'])->with('createdUsers')->count();
        $data['users'] = $user->createdUsers()->whereIn('role', ['Processor', 'Associate', 'Junior Associate', 'Borrower'])->with('createdUsers')->get();
        return view('admin.user.all-users', $data);
    }

    public function deleteUser(Request $request, $id)
    {
        $msg = AdminService::deleteUser($request, $id);
        return redirect('/dashboard')->with($msg['msg_type'], $msg['msg_value']);
    }

    public function fileUpload(Request $request)
    {
        return CommonService::fileUpload($request);
    }

    public function deleteFile(Request $request, $id)
    {
        $msg = AdminService::deleteFile($request, $id);
        return back()->with($msg['msg_type'], $msg['msg_value']);
    }

    public function updateCategoryStatus(Request $request)
    {
        $msg = AdminService::updateCategoryStatus($request);
        return back()->with($msg['msg_type'], $msg['msg_value']);
    }
}
