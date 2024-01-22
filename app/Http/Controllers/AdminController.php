<?php

namespace App\Http\Controllers;

use Faker\Factory;
use App\Models\Info;
use App\Models\Team;
use App\Models\User;
use App\Models\Company;
use App\Models\Contact;
use App\Models\Project;
use Illuminate\View\View;
use App\Models\IntakeForm;
use App\Models\Application;
use App\Models\UserCategory;
use Illuminate\Http\Request;
use App\Services\UserService;
use App\Services\AdminService;
use App\Services\CommonService;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\IntakeFormRequest;
use App\Http\Requests\ApplicationRequest;
use Illuminate\Support\Facades\Validator;

class AdminController extends Controller
{

    protected $faker;
    public function __construct()
    {
        $this->faker = Factory::create();
    }

    public function users(Request $request)
    {
        $data = AdminService::users($request);
        return view('admin.user.users', $data);
    }

    public function addUser(Request $request, $id)
    {
        $data = AdminService::addUser($request, $id);
        return view('admin.user.add-user', $data);
    }

    //Saves the record of a newly inserted teacher in database
    public function doUser(Request $request, $id)
    {
        $msg = AdminService::doUser($request, $id);
        return redirect('/dashboard')->with($msg['msg_type'], $msg['msg_value']);
    }

    public function deleteUser(Request $request, $id)
    {
        $msg = AdminService::deleteUser($request, $id);
        return back()->with($msg['msg_type'], $msg['msg_value']);
    }

    public function restoreUser(User $user)
    {
        if (Auth::user()->role !== 'Admin') {
            abort(403, 'you are not allowed to restore user');
        }

        $user->restore();
        return back()->with('msg_success', 'User restored successfully');
    }

    public function deleteUserPermenant(User $user)
    {
        if (Auth::user()->role !== 'Admin') {
            abort(403, 'you are not allowed to to permenantly delete user');
        }

        $user->forceDelete();
        return back()->with('msg_success', 'User permenantly deleted successfully');
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

    public function doApplication(ApplicationRequest $request)
    {
        $data = CommonService::doApplication($request);
        return redirect('/dashboard')->with($data['msg_type'], $data['msg_value']);
    }

    public function docs(Request $request, $id, $cat)
    {
        if ($cat == "Loan Application") {
            $user = User::find($id)->application()->first();
            if ($user != null) {
                return redirect(getAssociateRoutePrefix() . "/application-show/" . $user->id);
            } else {
                return redirect(getAssociateRoutePrefix() . "/application/" . $id);
            }
        } else {
            $data = AdminService::docs($request, $id, $cat);
            return view("admin.file.single-cat-docs", $data);
        }
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
            'user_id' => 'required',
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

    public function applications()
    {
        $data = CommonService::applications();
        return view('admin.applications.index', $data);
    }

    public function application(Request $request, $id = -1)
    {
        $data = UserService::application($request, $id);
        return view('user.loan.application', $data);
    }

    public function applicationShow(Application $application)
    {
        $data['application'] = $application;
        return view('admin.applications.show', $data);
    }
    public function applicationEdit(Application $application)
    {
        $data['application'] = $application;
        return view('admin.applications.show', $data);
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

    public function basicInfo()
    {
        $data['info'] = new Info();
        return view('user.info.basic-info', $data);
    }

    public function allUsers($id = null)
    {
        $data = CommonService::getUsers();
        return view('admin.user.all-users', $data);
    }

    #disconnect from google
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
    public function deleteAttachment(Request $request, $id)
    {
        $msg = AdminService::deleteAttachment($request, $id);
        return back()->with($msg['msg_type'], $msg['msg_value']);
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
        return redirect(getRoutePrefix() . '/all-users')
            ->with($msg['msg_type'], $msg['msg_value']);
    }

    public function exportContactsToExcel(Request $request)
    {
        $msg = CommonService::exportContactsToExcel($request);
        return $this->downloadXls();
        return redirect(getRoutePrefix() . '/leads')
            ->with($msg['msg_type'], $msg['msg_value']);
    }

    public function downloadXls()
    {
        $myFile = public_path("contact.xlsx");
        $headers = ['Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'];
        $newName = 'contact.xlsx';
        return response()->download($myFile, $newName, $headers);
    }

    public function projects($id = null): View
    {
        $admin = $id ? User::where('id', $id)->first() : Auth::user(); // Assuming you have authenticated the admin
        if($admin->role === 'Admin'){
            $data['teams'] = Team::with(['users.createdBy'])->where('company_id', $admin->company_id)->get();
            $teamIds = $data['teams']->pluck('id')->toArray();
            $data['projects'] = Project::whereIn('team_id', $teamIds)
                ->with(['team', 'users.createdBy', 'borrower.createdBy'])
                ->get();
                $data['borrowers'] = User::where('role', 'Borrower')->where('company_id',$admin->company_id)->get(['id', 'name']);
        }else{
        $data['teams'] = Team::where('owner_id', $admin->id)
            ->orWhereHas('users', function ($query) use ($admin) {
                $query->where('user_id', $admin->id);
            })
            ->get();

        $data['borrowers'] = User::where('role', 'Borrower')->get(['id', 'name']);
        $data['projects'] = Project::with('creater')->where('created_by', $admin->id)
            ->orWhereHas('users', function ($query) use ($admin) {
                $query->where('users.id', $admin->id);
            })
            ->with(['team', 'users.createdBy', 'borrower.createdBy'])
            ->get();
        }
        $data['enableProjects'] = $data['projects'];
        return view('admin.newpages.projects', $data);
    }

    public function ProjectOverview(Request $request, $id = -1, $sortby = null)
    {
        if ($request->ajax()) {
            $data['attachments'] = Auth::user()->load('attachments')->attachments()->paginate(2);
            return $data;
        }
        $data = AdminService::filesCat($request, $id);
        if ($sortby && $sortby === 'latest') {
            $data['categories'] = [];
            foreach ($data['user']->media()->latest()->get() as $file) {
                $data['categories'][] = $file->category;
            }
            $data['sortby'] = $sortby;
        } else {
            $data['sortby'] = 'category';
            $data['categories'] = config('smm.file_category');
            sort($data['categories']); // Sort the array in ascending order
        }
        $data['assistants'] = []; // Initialize the array
        $data['catCount'] = [];
        foreach ($data['user']->assistants as $assistant) {
            $user = $data['assistants'][] = User::with('assistants')->find($assistant->assistant_id);
            if ($user) {
                $data['assistants'][$user->id] = $user;
            }
        }
        $data['assistants'] = collect($data['assistants'])->unique('id');
        $data['categories'] = array_unique($data['categories']);
        foreach ($data['categories'] as $category) {
            if ($category === 'Credit Report') {
                continue;
            }

            $data['catCount'][$category] = [
                $data['user']->media()->where('category', $category)->count(),
            ];
        }
        return view('admin.newpages.project-overview', $data);
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

        // Pass the $associates array to a Blade view
        return response()->json($associates, 200);
    }

    public function newusers($id = null)
    {
        $admin = $id ? User::find($id) : Auth::user(); // Assuming you have authenticated the admin
        $data['users'] = $admin->createdUsers()->with(['createdBy'])->whereIn('role', ['Processor', 'Associate', 'Junior Associate', 'Borrower'])->with('createdUsers')->get();
        return view('admin.newpages.users', $data);
    }

    public function contacts()
    {
        if (Auth::user()->role === 'Admin') {

            $data['contacts'] = Contact::with('user')->where('user_id', Auth::id())
                ->orWhereHas('user', function ($query) {
                    $query->where('created_by', Auth::id());
                })
                ->get();
        } else {
            $data['contacts'] = Contact::with('user')->where('user_id', Auth::id())->get();
        }

        return view('admin.newpages.contacts', $data);
    }
    public function connections()
    {
        $user = User::find(Auth::id()); // Assuming you have authenticated the admin
        abort_if($user->role !== 'Admin', 403, 'You are not allowed to this part of the world!');
        if (Auth::user()->role === 'Admin') {
            $data['role'] = $user->role;
            $data['connections'] = $user
                ->createdUsers()
                ->with(['createdBy'])
                ->orWhere('company_id', $user->company_id ?? -1)
                ->whereNotIn('role', ['Admin', 'Super Admin'])
                ->get(['id', 'name', 'email', 'role', 'created_by']);
        }
        return view('admin.newpages.connections', $data);

    }
    public function deleteConnection(User $user)
    {
        abort_if(Auth::user()->role !== 'Admin', 403, 'You are not allowed to this part of the world!');
        $user->delete();
        return back()->with('msg_success', 'Connection deleted successfully');
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

    public function teams($id = null): View
    {
        $admin = $id ? User::find($id) : Auth::user(); // Assuming you have authenticated the admin

        if ($admin->role === 'Admin') {
            $data['disableTeams'] = Team::with(['users.createdBy'])->where('company_id', $admin->company_id)->Where('disable',true)->get();
            $data['enableTeams'] = Team::with(['users.createdBy'])->where('company_id', $admin->company_id)->Where('disable',false)->get();
            $data['teams'] = Team::with(['users.createdBy'])->where('company_id', $admin->company_id)->get();
        } else {
            $data['disableTeams'] = $admin->teamsOwnend()
                ->with('users')
                ->where('disable', true)
                ->orWhereHas('users', function ($query) use ($admin) {
                    $query->where('user_id', $admin->id);
                })->get();

            $data['enableTeams'] = $admin->teamsOwnend()
                ->with('users.createdBy')
                ->where('disable', false)
                ->orWhereHas('users', function ($query) use ($admin) {
                    $query->where('user_id', $admin->id);
                })->get();

            $data['teams'] = $admin->teamsOwnend()
                ->with('users')
                ->whereHas('users', function ($query) use ($admin) {
                    $query->where('user_id', $admin->id);
                })->get();
        }
        $data['users'] = $admin->createdUsers()
            ->orWhere('company_id', $admin->role == 'Admin' ? $admin->company_id : -1)
            ->whereIn('role', ['Processor', 'Associate', 'Junior Associate', 'Borrower'])
            ->orWhereHas('createdBy', function ($query) use ($admin) {
                $query->where('created_by', $admin->id);
            })
            ->get();
        return view('admin.newpages.teams', $data);
    }

    public function storeteam(Request $request, $id = 0)
    {
        AdminService::StoreTeam($request, $id);
        return back()->with('msg_success', 'Team created successfully');
    }

    public function deleteProjectUser(Project $project, $id)
    {
        $project->users()->detach($id);
        return back()->with('msg_success', 'User deleted successfully');
    }

    public function deleteTeamMember(Team $team, User $user)
    {
        $team->users()->detach($user->id);
        return back()->with("msg_success", "$user->name deleted from $team->name successfully");
    }

    public function deleteTeam(Team $team)
    {
        if ($team->disable) {
            $team->update(['disable' => false]);
        } else {
            $team->update(['disable' => true]);
        }

        return back()->with('msg_success', " \"$team->name\" team has been " . ($team->disable ? "Disabled" : "Enabled") . "  Successfully");
    }

    public function getUsersByProcessor($id, $teamid = 0)
    {
        $associates = AdminService::getUsersByProcessor($id, $teamid);
        return response()->json($associates, 200);
    }
    public function markAsRead($id)
    {
        CommonService::markAsRead($id);
        return back();
    }

    public function changeProjectStatus($type, Project $project)
    {
        $project->update(['status' => $type]);
        return redirect(getRoutePrefix() . '/projects')->with('msg_success', "project $type" . "d successfully");
    }

    public function shareItemWithAssistant(Request $request, $id)
    {
        return AdminService::shareItemWithAssistant($request, $id);
    }

    public function removeAcess(Request $request,User $user)
    {
        $user->active = 2;
        $user->save();
        if($request->ajax()) return response()->json('access removed', 200);
        else return back()->with('msg_success','Assistant deleted successfully');
    }

    public function submitIntakeForm(IntakeFormRequest $request)
    {
        return CommonService::submitIntakeForm($request);
    }

    public function loanIntake()
    {
        $data['role'] = Auth::user()->role;
        $data['tables'] = ['Pending Intake', 'Completed Intake', 'Incomplete Intake', 'Deleted Intake'];
        if($data['role'] === 'Admin'){
        
        }
        $data['intakes'] = IntakeForm::get();
        return view('admin.intakes.index', $data);
    }
    public function updateIntakeStatus(IntakeForm $intake, $status)
    {
        $msg = CommonService::updateIntakeStatus($intake, $status);
        return back()->with($msg['msg_type'], $msg['msg_value']);
    }
    public function redirectTo($route, $message)
    {
        return CommonService::redirectTo($route, $message);
    }

    public function doAssociate(Request $request)
    {
        $validator = Validator::make($request->only(['AssociateName', 'AssociateEmail']), [
            'AssociateEmail' => 'required|email:rfc,dns|unique:users,email',
            'AssociateName' => '',
        ]);
        if ($validator->fails()) {
            $errors = $validator->errors()->toArray();
            $response = ['error' => []];
            foreach ($errors as $field => $error) {
                foreach ($error as $message) {
                    $response['error'][] = [
                        'field' => $field,
                        'message' => $message,
                    ];
                }
            }
            return response()->json($response);
        }

        $request->merge(['email' => $request->AssociateEmail, 'role' => 'Associate', 'name' => $request->AssociateName,
        ]);
        AdminService::doUser($request, -1);
        return response()->json('success', 200);
    }

    public function getAssociates(Company $company)
    {
        $associates = CommonService::getAssociates($company);
        return response()->json($associates);
    }

    public function verifyUser(User $user)
    {
        $user->email_verified_at = now();
        $user->save();
        return back()->with('msg_success', 'User verified successfully');
    }
}
