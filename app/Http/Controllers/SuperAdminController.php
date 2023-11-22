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
use App\Models\UserCategory;
use App\Notifications\FileUploadNotification;
use App\Services\AdminService;
use App\Services\CommonService;
use App\Services\UserService;
use Faker\Factory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Validator;
use Illuminate\View\View;

class SuperAdminController extends Controller
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

    public function LoginAsThisUser(Request $request)
    {
        $id = Auth::id();
        $user = User::where('id', $request->user_id)->where('role', '<>', 'Super Admin')->first();
        Auth::login($user);
        $request->session()->regenerate();
        $request->session()->put('role', $user->role);
        $request->session()->put('reLogin', $id);
        $request->session()->put('url',url()->previous());
        return redirect('/dashboard');
    }

    public function ReLoginFrom(Request $request)
    {
        $user = User::where('id', $request->user_id)->where('role', 'Super Admin')->first();
        if (!$user) {
            abort(403, 'You are not allowed to this part of the world!');
        }

        Auth::login($user);
        $request->session()->forget('reLogin');
        $request->session()->regenerate();
        $request->session()->put('role', $user->role);
        return redirect()->intended(session('url'));
    }

    public function deleteUser(Request $request, $id)
    {
        $msg = AdminService::deleteUser($request, $id);
        return back()->with($msg['msg_type'], $msg['msg_value']);
    }

    public function restoreUser(User $user)
    {
        if (Auth::user()->role !== 'Super Admin') {
            abort(403, 'you are not allowed to restore user');
        }

        $user->restore();
        return back()->with('msg_success', 'User restored successfully');
    }

    public function deleteUserPermenant(User $user)
    {
        if (Auth::user()->role !== 'Super Admin') {
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

    //Showing documents for a user in specified category
    // public function docs(Request $request, $id, $cat)
    // {
    //     if ($cat === "Loan Application") {
    //         $id = User::find($id)->application()->first()->id;
    //         return redirect(getAdminRoutePrefix() . '/application-show/' . $id);
    //     } else {
    //         $data = AdminService::docs($request, $id, $cat);
    //         return view("admin.file.single-cat-docs", $data);
    //     }
    // }

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
        $user = $id ? User::find($id) : Auth::user(); // Assuming you have authenticated the admin
        if ($user->role === 'Super Admin') {
            $data['role'] = $user->role;
            $data['users'] = User::with(['createdBy', 'createdUsers'])
            ->where('role', '!=', 'Super Admin')
                ->get(['id', 'name', 'email', 'created_by', 'role', 'email_verified_at']);
            $data['trashed'] = User::withTrashed()
                ->with('createdBy')
                ->whereNotNull('deleted_at')
                ->get();
        } else {
            $data['role'] = $user->role;
            $data['users'] = $user->createdUsers()
                ->with(['createdUsers', 'createdBy'])
                ->whereIn('role', ['Processor', 'Associate', 'Junior Associate', 'Borrower'])
                ->get();
        }
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
        return view('admin.file.upload-files');
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
        $data['projects'] = Project::with('users')->get();
        $data['enableProjects'] = Project::with(['users.createdBy', 'team', 'borrower.createdBy'])->where('status', 'enable')->get();
        $data['disableProjects'] = Project::with(['users.createdBy', 'team', 'borrower.createdBy'])->where('status', 'disable')->get();
        $data['closeProjects'] = Project::with(['users.createdBy', 'team', 'borrower.createdBy'])->where('status', 'close')->get();
        $data['borrowers'] = User::where('role', 'Borrower')->get(['id', 'name', 'role']);
        $data['teams'] = Team::where('disable', false)->get();
        $data['trashed'] = User::onlyTrashed()->get();
        return view('admin.newpages.projects', $data);
    }

    public function ProjectOverview(Request $request, $id = -1, $sortby = null)
    {
        if ($request->ajax()) {
            $data['attachments'] = Auth::user()->load('attachments')->attachments()->paginate(2);
            // $data['attachments'] = \App\Models\Attachment::where('user_id', Auth::id())->paginate(2);
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
        $data['assistants'] = User::find($id)->assistants; // Initialize the array
        $data['catCount'] = [];
        $data['categories'] = array_unique($data['categories']);
        foreach ($data['categories'] as $category) {
            if ($category === 'Credit Report') continue;
            $data['catCount'][$category] = [
                $data['user']->media()->where('category', $category)->count(),
            ];
        }
        return view('admin.newpages.project-overview', $data);
    }

    public function storeProject(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'borroweraddress' => 'required',
            'email' => 'required_with:sendemail|unique:users,email',
            'name' => 'required',
            'borroweraddress' => 'required',
            'financetype' => 'required',
            'loantype' => 'required',
            'team' => 'required',
            'processor' => 'sometimes:required',
            'associate' => 'required',
            'juniorAssociate' => 'sometimes:required',
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
        } else {
            $request->merge(['email' => $request->email ?? $this->faker->unique()->safeEmail,
                'role' => 'Borrower',
            ]);
            $user = AdminService::doUser($request, -1);
            $project = Project::create([
                'name' => $request->borroweraddress,
                'borrower_id' => $user,
                'team_id' => $request->team,
                'created_by' => Auth::id(),
            ]);

            foreach ($request->associate as $associate_id) {
                $project->users()->attach($associate_id);
            }
            foreach ($request->juniorAssociate as $associate_id) {
                $project->users()->attach($associate_id);
            }
            foreach ($request->processor as $associate_id) {
                $project->users()->attach($associate_id);
            }

            $message = "Created new Deal by name : $request->borroweraddress";
            $admin = User::where('role', 'Super Admin')->first();
            $user = User::find(Auth::id());
            $admin->notify(new FileUploadNotification($user, $message));
            return response()->json('success', 200);
        }
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
        $admin = $id ? User::where('id', $id)->first() : Auth::user(); // Assuming you have authenticated the admin
        if ($admin->role == 'Super Admin') {
            $data['users'] = User::with(['createdBy'])->where('role', '!=', 'Super Admin')->get(['id', 'name', 'email', 'role', 'created_by', 'email_verified_at']);
            $data['trashed'] = User::onlyTrashed()->get();
        } else {
            $data['users'] = $admin->with(['createdUsers', 'createdBy'])->whereIn('role', ['Processor', 'Associate', 'Junior Associate', 'Borrower'])->with('createdUsers')->get();
        }
        return view('admin.newpages.users', $data);
    }

    public function contacts()
    {
        $data['contacts'] = Contact::where('user_id', Auth::id())->get();
        return view('admin.newpages.contacts', $data);
    }

    public function doContact(Request $request, $id = 0)
    {
        // dd($request);
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
        $data['teams'] = Team::with('users')->get();
        $data['enableTeams'] = Team::with('users')->where('disable', false)->get();
        $data['disableTeams'] = Team::with('users')->where('disable', true)->get();
        $data['users'] = User::where('role', '!=', 'Admin')
            ->whereIn('role', ['Associate', 'Processor', 'Junior Associate'])
            ->get(['id', 'email', 'name', 'role']);
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

    public function shareItemWithAssistant(Request $request)
    {
        return AdminService::shareItemWithAssistant($request);
    }

    public function removeAcess(User $user)
    {
        $user->active = 2;
        $user->save();
        return response()->json('access removed', 200);
    }

    public function submitIntakeForm(IntakeFormRequest $request)
    {
        $user = new User;
        $user->name = $request->first_name . ' ' . $request->last_name;
        $user->email = $request->email;
        $user->role = 'Borrower';
        $user->created_by = Auth::id();
        $user->password = bcrypt($this->faker->password(8));
        if ($user->save()) {
            Password::sendResetLink($request->only('email'));
            Password::RESET_LINK_SENT;
        }

        IntakeForm::create([
            'user_id' => $user->id,
            'name' => $request->first_name ?? null . '' . $request->last_name,
            'email' => $request->email ?? null,
            'address' => $request->address ?? null,
            'phone' => $request->phone ?? null,
            'address' => $request->address . ' ' . $request->address_two ?? null,
            'city' => $request->city ?? null,
            'state' => $request->state ?? null,
            'zip' => $request->zip ?? null,
            'loan_type' => $request->loan_type ?? null,
            'purchase_price' => $request->purchase_price ?? null,
            'property_value' => $request->property_value ?? null,
            'down_payment' => $request->down_payment ?? null,
            'current_loan_amount' => $request->current_loan_amount ?? null,
            'closing_date' => $request->closing_date ?? null,
            'current_lender' => $request->current_lender ?? null,
            'rate' => $request->rate ?? null,
            'is_it_rental_property' => $request->is_it_rental_property ?? null,
            'monthly_rental_income' => $request->monthly_rental_income ?? null,
            'cashout_amount' => $request->cashout_amount ?? null,
            'is_repair_finance_needed' => $request->is_repair_finance_needed ?? null,
            'how_much' => $request->how_much ?? null,
            'note' => $request->note ?? null,
        ]);
        return response()->json('success', 200);
    }

    public function redirectTo($route, $message)
    {
        $message = ucfirst(str_replace('-', ' ', $message));
        if ($route === 'back') {
            return back()->with('msg_success', "$message.");
        }

        return redirect(getRoutePrefix() . "/$route")->with('msg_success', "$message.");
    }

    public function doAssociate(Request $request)
    {
        $validator = Validator::make($request->only(['AssociateName', 'AssociateEmail']), [
            'AssociateEmail' => 'required|email:rfc,dns|unique:users,email',
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

}
