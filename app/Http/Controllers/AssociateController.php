<?php

namespace App\Http\Controllers;

use App\Http\Requests\ApplicationRequest;
use App\Http\Requests\IntakeFormRequest;
use App\Models\Application;
use App\Models\Contact;
use App\Models\Info;
use App\Models\IntakeForm;
use App\Models\Project;
use App\Models\Team;
use App\Models\User;
use App\Services\AdminService;
use App\Services\CommonService;
use App\Services\UserService;
use Faker\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AssociateController extends Controller
{

    protected $faker;
    public function __construct()
    {
        $this->faker = Factory::create();
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
        $checkMaximumUsers = AdminService::restrictMaxUser($id, $request);
        if ($checkMaximumUsers) {
            return redirect(url()->previous())->with('msg_error', 'Your Team Size Exceeds Your Plan Limit');
        }
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
            $intake = IntakeForm::where('user_id', $id)->first();
            return redirect(getRoutePrefix() . "/loan-intake/$intake->id");
        }
        $data = AdminService::docs($request, $id, $cat);
        return view("admin.file.single-cat-docs", $data);

    }

    public function applicationShow(Application $application)
    {
        $data['application'] = $application;
        return view('admin.applications.show', $data);
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

    public function allUsers()
    {
        abort_if(auth()->user()->role !== 'Admin', 403, 'You are not allowed');
        $data = CommonService::getUsers();
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
        return back()->with($msg['msg_type'], $msg['msg_value']);
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
        return CommonService::addCategoryToUser($request, $user);
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
        $admin = User::find(auth()->id());
        $data['teams'] = Team::whereHas('users', function ($query) use ($admin) {
            $query->where('user_id', $admin->id);
        })->get();

        $data['borrowers'] = User::with('projects')->where('role', 'Borrower')->get(['id', 'name']);
        $data['projects'] = Project::where('created_by', $admin->id)
            ->where('status', 'enable')
            ->orWhereHas('users', function ($query) use ($admin) {
                $query->where('users.id', $admin->id);
            })
            ->with(['team', 'users.createdBy', 'borrower.createdBy'])
            ->get();
        $data['enableProjects'] = $data['projects'];

        $data['users'] = $admin->createdUsers()->whereIn('role', ['Processor', 'Associate', 'Junior Associate', 'Borrower'])->with('createdUsers')->get();
        return view('admin.newpages.projects', $data);
    }
    public function shareItemWithAssistant(Request $request, $id)
    {
        return AdminService::shareItemWithAssistant($request, $id);
    }

    public function updateShareItemWithAssistant(Request $request, $id)
    {
        return AdminService::updateShareItemWithAssistant($request, $id);
    }

    public function storeProject(Request $request, $id = -1)
    {
        return AdminService::storeProject($request, $id);
    }

    public function getUsersByTeam(Team $team)
    {
        $associates = [];
        if (!$team) {
            return response()->json([], 404);
        }
        // Team not found
        // Retrieve associates and store them in the $associates array
        foreach ($team->users as $user) {
            $associates[] = [
                'role' => $user->role,
                'name' => $user->name,
                'id' => $user->id,
            ];
        }
        return response()->json($associates, 200);
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
        return back()->with('msg_success', 'Contact ' . ($id ? 'updated' : 'created') . ' successfully');
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
        $data['assistants'] = $user->assistants->filter(function ($assistant) {
            return $assistant->active == 1;
        });
        return view('admin.newpages.project-overview', $data);
    }
    public function redirectTo($route, $message)
    {
        return CommonService::redirectTo($route, $message);
    }

    public function teams($id = null): View
    {
        abort_if(auth()->user()->role !== 'Admin', 403, 'You are not allowed!');
        $admin = $id ? User::where('id', $id)->first() : Auth::user(); // Assuming you have authenticated the admin
        $data['teams'] = $this->enableTeams($admin);
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

    public function enableTeams($id)
    {
        $admin = $id ? User::where('id', $id)->first() : Auth::user(); // Assuming you have authenticated the admin
        return Team::where('owner_id', $admin->id)
            ->with('users.createdBy')
            ->where('disable', false)
            ->orWhereHas('users', function ($query) use ($admin) {
                $query->where('user_id', $admin->id);
            })
            ->get();
    }
    public static function markAsRead($id)
    {
        Auth::user()->notifications->where('id', $id)->markAsRead();
    }

    public function submitIntakeForm(IntakeFormRequest $request)
    {
        return CommonService::submitIntakeForm($request);
    }

    public function loanIntake()
    {
        return CommonService::loanIntake();

    }
    public function loanIntakeShow($id)
    {
        $data['intake'] = IntakeForm::find($id);
        $data['enableTeams'] = [];
        return view('admin.intakes.show', $data);
    }
    public function updateIntakeStatus(IntakeForm $intake, $status)
    {
        $msg = CommonService::updateIntakeStatus($intake, $status);
        return back()->with($msg['msg_type'], $msg['msg_value']);
    }

    public function removeAcess(Request $request, User $user)
    {
        $user->active = 2;
        $user->save();
        if ($request->ajax()) {
            return response()->json('access removed', 200);
        } else {
            return back()->with('msg_success', 'Assistant deleted successfully');
        }
    }

    public function changeProjectStatus($type, Project $project)
    {
        $project->update(['status' => $type]);
        return redirect(getRoutePrefix() . '/projects')->with('msg_success', "project $type" . "d successfully");
    }

    //Updates the status of  a files
    public function updateFileStatus(Request $request, $id)
    {
        $msg = AdminService::updateFileStatus($request, $id);
        return back()->with($msg['msg_type'], $msg['msg_value']);
    }

    public function updateCatComments(Request $request, $cat)
    {
        $request->validate([
            'user_id' => 'required',
        ]);
        $msg = AdminService::updateCatComments($request, $cat);
        return back()->with($msg['msg_type'], $msg['msg_value']);
    }

}
