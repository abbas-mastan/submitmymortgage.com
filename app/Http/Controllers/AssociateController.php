<?php

namespace App\Http\Controllers;

use App\Http\Requests\ApplicationRequest;
use App\Models\Application;
use App\Models\Contact;
use App\Models\Info;
use App\Models\Project;
use App\Models\Team;
use App\Models\User;

use App\Models\UserCategory;
use App\Services\AdminService;
use App\Services\CommonService;

use App\Services\UserService;
use Illuminate\Http\RedirectResponse;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Facades\Validator;
use Illuminate\View\View;

class AssociateController extends Controller
{
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
        return view('user.info.basic-info', ['info' => new Info()]);
    }

    public function application(Request $request, $id = -1)
    {
        $data = UserService::application($request, $id);
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
        if ($cat == "Loan Application") {
            $user = User::find($id)->application()->first();
            return redirect(getAssociateRoutePrefix() . ($user ? "/application-show/$user->id" : "/application/$id"));
        }
        $data = AdminService::docs($request, $id, $cat);
        return view("admin.file.single-cat-docs", $data);

    }

    public function applicationShow(Application $application)
    {
        return view('admin.applications.show', $application);
    }

    public function applicationEdit(Application $application)
    {
        return view('admin.applications.show', $application);
    }

    public function applicationUpdate(ApplicationRequest $request, Application $application)
    {
        $msg = CommonService::doApplication($request, $application->user_id);
        return redirect('/dashboard')->with($msg['msg_type'], $msg['msg_value']);
    }
    public function applicationUpdateStatus(Application $application, $status)
    {
        $msg = CommonService::updateApplicatinStatus($application, $status);
        return back()->with($msg['msg_type'], $msg['msg_value']);
    }

    public function allUsers($id = null)
    {
        $user = $id ? User::find($id) : Auth::user();
        $data['role'] = $user->role;
        $role = $user->role;
// Fetch users created directly by the user
        $directlyCreatedUsers = $user->createdUsers()
            ->with(['createdBy'])
            ->whereIn('role', [($role === 'Processor' ? '' : 'Processor'), 'Associate', 'Junior Associate', 'Borrower'])
            ->get();

        $indirectlyCreatedUsers = User::whereIn('created_by', $directlyCreatedUsers->pluck('id'))
            ->orWhere('company_id', $role === 'Admin' ? $user->company_id ?? -1 : -1)
            ->whereIn('role', [($role === 'Processor' ? '' : 'Processor'), 'Associate', 'Junior Associate', 'Borrower'])
            ->get();

        // Combine the directly and indirectly created users
        $allUsers = $directlyCreatedUsers->merge($indirectlyCreatedUsers);

        $data['users'] = $allUsers;

        return view('admin.user.all-users', $data);
    }

    public function files(Request $request, $id = -1)
    {
        $data = AdminService::files($request, $id);
        return view('admin.file.files', $data);
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
    public function disconnectGoogle(Request $request)
    {
        User::where('id', Auth::id())->update(array('accessToken' => null));
        return redirect('/dashboard')->with("msg_success", "Google Disconnected Successfully.");
    }

    public function hideCategory(User $user, $cat)
    {
        $msg = CommonService::hideCategory($user, $cat);
        return back()->with($msg['msg_type'], $msg['msg_value']);
    }

    public function deleteCategory(User $user, $cat)
    {
        $msg = CommonService::deleteCategory($user, $cat);
        return back()->with($msg['msg_type'], $msg['msg_value']);
    }

    public function doInfo(Request $request)
    {
        $this->validateFunction($request);
        $data = UserService::doInfo($request);
        return redirect('/dashboard')->with($data['msg_type'], $data['msg_value']); //view('user.info.basic-info',$data);
    }

    public function allLeads()
    {
        $data = AdminService::allLeads();
        return view('admin.leads.allleads', $data);
    }
    public function lead($id)
    {
        $data = AdminService::lead($id);
        return view('admin.leads.singlelead', $data);
    }

    public function deleteLead(Info $info)
    {
        $msg = AdminService::deleteLead($info);
        return back()->with($msg['msg_type'], $msg['msg_value']);
    }

    public function applications()
    {
        $data = CommonService::applications();
        return view('admin.applications.index', $data);
    }

    public function deleteApplication(Application $application)
    {
        $application->delete();
        return back()->with("msg_success", "Application Deleted Successfully.");
    }

    public function addCategoryToUser(Request $request, User $user)
    {
        if (in_array(ucwords($request->name), config('smm.file_category')) || $request->name == "id/driver's license") {
            return response()->json(["error" => "This Category \" $request->name\" already exists"]);
        }
        $validator = Validator::make($request->all(), [
            'name' => 'required|unique:user_categories,name,user_id' . $user->id,
        ]);
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()->all()]);
        }
        UserCategory::create([
            'name' => $request->name,
            'user_id' => $user->id,
        ]);
        return response()->json(['success' => 'Added new records.']);
    }

    private function validateFunction($request)
    {
        return $request->validate([
            'b_fname' => 'required',
            'b_lname' => 'required',
            'b_phone' => 'required',
            'b_email' => 'required',
            'b_address' => 'required',
            'b_suite' => 'required',
            'b_city' => 'required',
            'b_state' => 'required',
            'b_zip' => 'required',
            // co borrwowers details
            'co_fname' => 'required',
            'co_lname' => 'required',
            'co_phone' => 'required',
            'co_email' => 'required',
            'co_address' => 'required',
            'co_suite' => 'required',
            'co_city' => 'required',
            'co_state' => 'required',
            'co_zip' => 'required',
            'p_address' => 'required',
            'p_suite' => 'required',
            'p_city' => 'required',
            'p_state' => 'required',
            'p_zip' => 'required',
        ]);
    }

    public function uploadFilesView()
    {
        $user = User::with('attachments.user')->find(Auth::id());
        return view('admin.file.upload-files', compact('user'));
    }
    public function uploadFiles(Request $request)
    {
        $msg = CommonService::uploadFiles($request);
        return back()->with($msg['msg_type'], $msg['msg_value']);

    }
    public function spreadsheet(Request $request)
    {
        $msg = CommonService::insertFromExcel($request);
        return redirect(getRoutePrefix() . '/all-users')->with($msg['msg_type'], $msg['msg_value']);
    }

    public function exportContactsToExcel(Request $request): RedirectResponse
    {
        $msg = CommonService::exportContactsToExcel($request);
        return redirect(getRoutePrefix() . '/leads')->with($msg['msg_type'], $msg['msg_value']);
    }

    public function projects($id = null): View
    {
        $admin = Auth::user();
        $data['teams'] = Team::whereHas('users', function ($query) use ($admin) {
            $query->where('user_id', $admin->id);
        })->get();

        $data['borrowers'] = User::with('projects')->where('role', 'Borrower')->get(['id', 'name']);
        $data['projects'] = Project::where('created_by', $admin->id)
            ->orWhereHas('users', function ($query) use ($admin) {
                $query->where('users.id', $admin->id);
            })
            ->with(['team', 'users.createdBy', 'borrower.createdBy'])
            ->get();
        $data['enableProjects'] = $data['projects'];

        $data['users'] = $admin->createdUsers()->whereIn('role', ['Processor', 'Associate', 'Junior Associate', 'Borrower'])->with('createdUsers')->get();
        return view('admin.newpages.projects', $data);
    }

    public function newusers($id = null)
    {
        $admin = $id ? User::where('id', $id)->first() : Auth::user(); // Assuming you have authenticated the admin
        $data['users'] = $admin->createdUsers()->with('createdBy')->whereIn('role', ['Processor', 'Associate', 'Junior Associate', 'Borrower'])->with('createdUsers')->get();
        return view('admin.newpages.users', $data);
    }
    public function contacts()
    {
        $data['contacts'] = Contact::where('user_id', Auth::id())->get();
        return view('admin.newpages.contacts', $data);
    }

    public function doContact(Request $request, $id = 0)
    {
        $req = $request->validate([
            'name' => 'required',
            'email' => 'required',
            'loanamount' => 'required',
            'loantype' => 'required',
        ]);
        $contact = $id ? Contact::find($id) : new Contact();
        $contact->name = $req['name'];
        $contact->email = $req['email'];
        $contact->loanamount = $req['loanamount'];
        $contact->loantype = $req['loantype'];
        $contact->user_id = Auth::id();
        $contact->save();
        return back()->with('success', 'Contact ' . ($id ? 'updated' : 'created') . ' successfully');
    }

    public function deleteContact(Contact $contact)
    {
        $contact->delete();
        return back()->with(['success', 'contact deleted successfully']);
    }

    public function ProjectOverview(Request $request, $id = -1)
    {
        if ($request->ajax()) {
            $data['attachments'] = \App\Models\Attachment::where('user_id', Auth::id())->paginate(2);
            return $data;
        }
        $data = AdminService::filesCat($request, $id);
        $data['categories'] = config('smm.file_category');
        $user = User::find($id);
        $data['assistants'] = $user->assistants;
        return view('admin.newpages.project-overview', $data);
    }
    public function redirectTo($route, $message)
    {
        return CommonService::redirectTo($route, $message);
    }

    public function teams($id = null): View
    {
        $admin = $id ? User::where('id', $id)->first() : Auth::user(); // Assuming you have authenticated the admin
        $data['teams'] = Team::where('owner_id', $admin->id)
            ->with('users.createdBy')
            ->where('disable', false)
            ->orWhereHas('users', function ($query) use ($admin) {
                $query->where('user_id', $admin->id);
            })
            ->get();
        $data['disableTeams'] = Team::where('owner_id', $admin->id)
            ->with('users.createdBy')
            ->where('disable', true)
            ->orWhereHas('users', function ($query) use ($admin) {
                $query->where('user_id', $admin->id);
            })
            ->get();
        $data['enableTeams'] = $data['teams'];

        $data['users'] = $admin->createdUsers()->whereIn('role', ['Processor', 'Associate', 'Junior Associate', 'Borrower'])->with(['createdUsers', 'createdBy'])->get();
        return view('admin.newpages.teams', $data);
    }

    public static function markAsRead($id)
    {
        Auth::user()->notifications->where('id', $id)->markAsRead();
    }
}
