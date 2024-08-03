<?php

namespace App\Http\Controllers;

use App\Helpers\SubscriptionHelper;
use App\Http\Requests\ApplicationRequest;
use App\Http\Requests\CustomPlanRequest;
use App\Http\Requests\IntakeFormRequest;
use App\Mail\AssistantMail;
use App\Mail\UserMail;
use App\Models\Application;
use App\Models\Company;
use App\Models\Contact;
use App\Models\CustomQuote;
use App\Models\DiscountCode;
use App\Models\Info;
use App\Models\IntakeForm;
use App\Models\Project;
use App\Models\SubscriptionPlans;
use App\Models\Team;
use App\Models\User;
use App\Services\AdminService;
use App\Services\CommonService;
use App\Services\UserService;
use Faker\Factory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\View\View;
use Stripe\StripeClient;

class SuperAdminController extends Controller
{

    protected $faker;
    public function __construct()
    {
        $this->faker = Factory::create();
    }

    public function logoutAllUsers()
    {
        abort_if(Auth::user()->role !== 'Super Admin', 403, 'You are not allowed to this part of the world');
        $sessionPath = storage_path('framework/sessions');
        File::cleanDirectory($sessionPath);
        return redirect('dashboard')->with('msg_success', 'All users logged out successfully');
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

    public function getCompanyTeams(Company $company)
    {
        $companies = $company->teams;
        return response()->json($companies, 200);
    }
    public function getCompanyBorrowers(Company $company)
    {
        $projects = [];
        $teams = $company->teams()->with('projects')->get();
        foreach ($teams as $team) {
            foreach ($team->projects as $project) {
                $borrower = User::find($project->borrower_id);

                if ($borrower && $borrower->deleted_at === null) {
                    $projects[] = $project;
                }
            }
        }
        $borrowers = $projects;
        return response()->json($borrowers, 200);
    }

    public function LoginAsThisUser(Request $request)
    {
        $user = User::where('id', $request->user_id)->where('role', '<>', 'Super Admin')->first();
        if ($user->active != 1) {
            return back()->with('msg_error', 'Sorry this user has been disabled');
        }
        if ($user->email_verified_at !== null) {
            Auth::login($user);
            $request->session()->regenerate();
            $request->session()->put('role', $user->role);
            $request->session()->put('reLogin', Auth::id());
            $request->session()->put('url', url()->previous());
            return redirect('/dashboard');
        } else {
            return back()->with('msg_error', 'Sorry this user email is not verified');
        }
    }

    public function ReLoginFrom(Request $request)
    {
        $user = User::where('role', 'Super Admin')->first();
        abort_if(!$user, 403, 'You are not allowed to this part of the world!');
        Auth::login($user);
        $request->session()->forget('reLogin');
        $request->session()->regenerate();
        $request->session()->put('role', $user->role);
        return redirect()->intended(session('url') ?? '/');
    }

    public function deleteUser(Request $request, $id)
    {
        $msg = AdminService::deleteUser($request, $id);
        return back()->with($msg['msg_type'], $msg['msg_value']);
    }

    public function restoreUser(User $user)
    {
        abort_if(Auth::user()->role !== 'Super Admin', 403, 'you are not allowed to restore user');
        $user->restore();
        return back()->with('msg_success', 'User restored successfully');
    }

    public function deleteUserPermenant(User $user)
    {
        abort_if(Auth::user()->role !== 'Super Admin', 403, 'you are not allowed to to permenantly delete user');
        // if ($user->role === 'Borrower') {
        //     $user->project->delete();
        // }

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
            // $user = User::find($id)->application()->first();
            // return redirect(getRoutePrefix() . ($user ? "/application-show/$user->id" : "/application/$id"));
            $intake = IntakeForm::where('user_id', $id)->first();
            return redirect(getRoutePrefix() . "/loan-intake/$intake->id");
        }
        $data = AdminService::docs($request, $id, $cat);
        return view("admin.file.single-cat-docs", $data);
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
        $request->validate(['user_id' => 'required']);
        $msg = AdminService::updateCatComments($request, $cat);
        return back()->with($msg['msg_type'], $msg['msg_value']);
    }
    //Delete a files
    public function deleteFile(Request $request, $id)
    {
        $msg = AdminService::deleteFile($request, $id);
        return back()->with($msg['msg_type'], $msg['msg_value']);
    }
    public function deleteAttachment(Request $request, $id)
    {
        $msg = AdminService::deleteAttachment($request, $id);
        return back()->with($msg['msg_type'], $msg['msg_value']);
    }
    //Uploads a files
    public function fileUpload(Request $request)
    {
        return CommonService::fileUpload($request);
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

    public function addCategoryToUser(Request $request, User $user)
    {
        return CommonService::addCategoryToUser($request, $user);
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
        $data['projects'] = Project::with('users.assistants')->latest()->get();
        $data['enableProjects'] = Project::with(['creater', 'users.createdBy', 'team', 'borrower.assistants', 'borrower.createdBy'])->where('status', 'enable')->latest()->get();
        $data['disableProjects'] = Project::with(['users.createdBy', 'team', 'borrower.createdBy'])->where('status', 'disable')->latest()->get();
        $data['closeProjects'] = Project::with(['users.createdBy', 'team', 'borrower.createdBy'])->where('status', 'close')->latest()->get();
        $data['borrowers'] = User::where('role', 'Borrower')->latest()->get(['id', 'name', 'role']);
        $data['teams'] = Team::where('disable', false)->latest()->get();
        $data['trashed'] = User::onlyTrashed()->latest()->get();
        return view('admin.newpages.projects', $data);
    }

    public function ProjectOverview(Request $request, $id = -1, $sortby = null)
    {
        if ($request->ajax()) {
            $data['attachments'] = User::find(Auth::id())->load('attachments')->attachments()->paginate(2);
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
        $data['assistants'] = [];
        $data['assistantsusers'] = $data['user']->assistants->load('assistant');
        foreach ($data['assistantsusers'] as $assistant) {
            if ($assistant->assistant && $assistant->assistant->active == 1) {
                $data['assistants'][] = $assistant->assistant;
            }
        }
        $data['catCount'] = [];
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

    public function contacts()
    {
        $data['contacts'] = Contact::with(['user' => function ($query) {
            $query->withTrashed();
        }])->latest()->get();
        return view('admin.newpages.contacts', $data);
    }

    public function doContact(Request $request, $id = 0)
    {
        CommonService::doContact($request, $id);
        return back()->with('msg_success', 'Contact ' . ($id ? 'updated' : 'created') . ' successfully');
    }

    public function deleteContact(Contact $contact)
    {
        $contact->delete();
        return back()->with(['success', 'contact deleted successfully']);
    }

    public function teams($id = null): View
    {
        $data['teams'] = Team::with('users')->get();
        $data['enableTeams'] = Team::with(['users.createdBy', 'company'])->where('disable', false)->latest()->get();
        $data['disableTeams'] = Team::with('users')->where('disable', true)->latest()->get();
        $data['companies'] = Company::where('enable', true)->latest()->get();

        $data['users'] = User::where('role', '!=', 'Admin')
            ->whereIn('role', ['Associate', 'Processor', 'Junior Associate'])
            ->latest()
            ->get(['id', 'email', 'name', 'role']);
        return view('admin.newpages.teams', $data);
    }

    public function storeteam(Request $request, $id = 0)
    {
        AdminService::StoreTeam($request, $id);
        return back()->with('msg_success', $id ? 'Team members added successfully' : 'Team created successfully');
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

    public function updateShareItemWithAssistant(Request $request, $id)
    {
        return AdminService::updateShareItemWithAssistant($request, $id);
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

    public function submitIntakeForm(IntakeFormRequest $request)
    {
        return CommonService::submitIntakeForm($request);
    }
    public function loanIntake()
    {
        return CommonService::loanIntake();
    }

    public static function loanIntakeShow($id)
    {
        return CommonService::loanIntakeShow($id);
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

        $request->merge([
            'email' => $request->AssociateEmail,
            'role' => 'Associate',
            'name' => $request->AssociateName,
            'company' => $request->company,
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

    public function connections()
    {
        $data['connections'] = User::with('createdBy')
            ->whereNotIn('role', ['Admin', 'Super Admin'])
            ->latest()
            ->get(['id', 'name', 'email', 'role', 'company_id', 'created_by']);
        return view('admin.newpages.connections', $data);
    }

    public function deleteConnection(User $user)
    {
        $user->delete();
        return back()->with('msg_success', 'Connection deleted successfully');
    }

    public function customQuotes()
    {
        $customQuotes = CustomQuote::with('user')->where('status', true)->latest()->get();
        return view('superadmin.custom-quotes', compact('customQuotes'));
    }

    public function customPlan(User $user)
    {
        $user = User::with('personalInfo')->find($user->id);
        return view('superadmin.custom-quote', compact('user'));
    }

    public function createCustomPlan(CustomPlanRequest $request, User $user)
    {
        $stripe = new StripeClient(env('STRIPE_SK'));
        $user_id = $user->id;
        $planName = $request->team_size . ' members ' . $request->plan_type . ' plan';
        $price = $request->plan_price * 100;
        $isPlan = SubscriptionPlans::where('amount', $price)->where('max_users', $request->team_size)->first();
        if ($isPlan) {
            try {
                $product = $stripe->prices->retrieve($isPlan->stripe_price_id, []);
            } catch (\Exception $ex) {
                $product = SubscriptionHelper::createStripeProduct($stripe, $planName, $price, $request->plan_type);
            }
        } else {
            $product = SubscriptionHelper::createStripeProduct($stripe, $planName, $price, $request->plan_type);
        }

        DB::beginTransaction();
        try {
            if (!$isPlan) {
                SubscriptionPlans::create([
                    'name' => $planName,
                    'stripe_price_id' => $product->id,
                    'max_users' => $request->team_size,
                    'trial_days' => env('SUBSCRIPTION_TRIAL_DAYS'),
                    'amount' => $price,
                ]);
            }
            SubscriptionHelper::insertSubscriptionInfo($user_id);

            $request['training'] = $request->training_date;
            SubscriptionHelper::userTraining($request, $user_id);
            // the code below sending password create email to the user
            $id = Crypt::encryptString($user->id);
            DB::table('password_resets')->insert(['email' => $user->email, 'token' => Hash::make(Str::random(12)), 'created_at' => now()]);
            $url = function () use ($id) {return URL::signedRoute('user.register', ['user' => $id], now()->addMinutes(10));};
            $mailClass = $request->role === 'Borrower' ? new AssistantMail($url()) : new UserMail($url());
            Mail::to($request->email)->send($mailClass);
            // the code above sending password create email to the user

            SubscriptionHelper::insertPersonalInfo($request, $user);

            // creating  customer in stripe and charge 1 dollar and instant refund it
            $customer = SubscriptionHelper::charge($request);
            if ($customer instanceof \Stripe\Customer) {
                SubscriptionHelper::insertCardDetails($request, $customer->id, $user_id);
                $subscriptionPlan = SubscriptionPlans::where('name', $planName)->first();
                if ($subscriptionPlan) {
                    // the below line of code create subscription in stripe
                    SubscriptionHelper::startTrialSubscription($customer->id, $user_id, $subscriptionPlan);
                    // the above line of code create subscription in stripe

                    // the below code updating the company for the user
                    $company = $user->company;
                    $company->created_by = $user_id;
                    $company->max_users = $request->team_size;
                    $company->subscription_id = $user->subscriptionDetails->stripe_subscription_id;
                    $company->save();
                }
            }
            $user->customQuote->update([
                'status' => false,
            ]);
            DB::commit();
            return redirect(getRoutePrefix() . '/custom-quote')->with('msg_success', 'plan created');
        } catch (\Exception $ex) {
            DB::rollback();
            return back()->with('msg_error', 'An error occured:' . $ex->getMessage());
        }
    }

    public function discountCodes()
    {
        $discountCodes = DiscountCode::where('is_used', false)->latest()->get();
        return view('superadmin.discount-codes', compact('discountCodes'));
    }

    public function createDiscountCode(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'discount_type' => 'required',
            'fixed_amount' => 'required_if:discount_type,fixed_amount',
            'percent' => 'required_if:discount_type,percent',
        ], [
            'fixed_amount:required_if' => 'This field is required',
            'percent:required_if' => 'This field is required',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors());
        }

        $stripe = new StripeClient(env('STRIPE_SK'));
        $discountCode = DiscountCode::where('discount_type', $request->discount_type)->where('discount', $request->percent ?? $request->fixed_amount)->first();
        $oldCouponCode = $discountCode->coupon_code ?? 'null';
        if ($request->discount_type === 'percent') {
            try {
                $newCoupen = $stripe->coupons->retrieve($oldCouponCode, []);
            } catch (\Exception $ex) {
                $newCoupen = $stripe->coupons->create([
                    'duration' => 'forever',
                    'percent_off' => $request->percent,
                ]);
            }
        } else {
            try {
                $newCoupen = $stripe->coupons->retrieve($oldCouponCode, []);
            } catch (\Exception $ex) {
                $newCoupen = $stripe->coupons->create([
                    'duration' => 'forever',
                    'currency' => 'usd',
                    'amount_off' => $request->fixed_amount,
                ]);
            }
        }

        if ($request->discount_type === 'percent' || $request->discount_type === 'fixed_amount') {
            DiscountCode::create([
                'code' => $this->getUniqueCode(),
                'discount_type' => $request->discount_type,
                'discount' => $request->percent ?? $request->fixed_amount,
                'coupon_code' => $newCoupen->id,
            ]);
        }
        return response()->json('success');
        // return back()->with('msg_success', 'Discount code generated.');
    }

    private function getUniqueCode()
    {
        $code = Str::random(15);
        if (DiscountCode::where("code", $code)->exists()) {
            $this->getUniqueCode();
        }
        return $code;
    }

    public function deleteCode($id)
    {
        $code = DiscountCode::find($id)->delete();
        return back()->with('msg_success', 'Discount code deleted.');
    }

}
