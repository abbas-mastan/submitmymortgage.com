<?php

namespace App\Services;

use App\Models\Application;
use App\Models\Attachment;
use App\Models\Company;
use App\Models\Contact;
use App\Models\Info;
use App\Models\IntakeForm;
use App\Models\Media;
use App\Models\Project;
use App\Models\User;
use App\Models\UserCategory;
use App\Notifications\FileUploadNotification;
use Faker\Factory;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Password as PasswordRule;
use Illuminate\Validation\ValidationException;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xls;

class CommonService
{

    protected $faker;
    public function __construct()
    {
        $this->faker = Factory::create();
    }

    //Updates profile picture of the user
    public static function doProfile(Request $request)
    {
        $msg = "Profile updated.";
        $user = Auth::user();
        if ($request->password) {
            self::validatePassword($request);
            $user->password = Hash::make($request->password);
        }
        if ($request->file('file')) {
            if (!str_contains($user->pic, "default")) {
                Storage::delete($user->pic);
            }
            $user->pic = $request->file('file')->store(getFileDirectory());
        }

        if ($user->save()) {
            return ['msg_type' => 'msg_success', 'msg_value' => $msg];
        }
        return ['msg_type' => 'msg_error', 'msg_value' => "Couldn't save the picture"];
    }
    //Uploads a file
    public static function fileUpload(Request $request)
    {
        $attachments = optional($request->attachment, function ($attachment) {
            return explode(',', $attachment);
        });
        if (!empty($attachments)) {
            foreach ($attachments as $id) {
                $attachment = Attachment::where('id', $id)->where('user_id', Auth::id())->first();
                $uniqueName = md5(uniqid()) . "." . pathinfo($attachment->file_name, PATHINFO_EXTENSION);
                $media = new Media();
                $media->file_name = $attachment->file_name;
                $media->file_path = getFileDirectory() . $uniqueName;
                $media->file_size = $attachment->file_size;
                $media->file_type = 'application/octet-stream';
                $media->file_extension = $attachment->file_extension;
                $media->category = $request->input('category');
                $media->user_id = $request->input('id') ?? $attachment->user_id;
                $media->uploaded_by = Auth::id();
                try {
                    Storage::copy($attachment->file_path, getFileDirectory() . $uniqueName);
                    $project = User::find($request->input('id') ?? $attachment->user_id)->project;
                    if ($project) {
                        self::storeNotification("$request->category", Auth::id(), $project->id, $request->category);
                    } else {
                        self::storeNotification("$request->category", Auth::id(), $project->id, $request->category);
                    }
                } catch (\Exception $e) {
                    return response()->json(['status' => "$e", 'filename' => $e]);
                }
                $media->save();
            }
            if (!$request->file('file')) {
                return response()->json(['status' => 'success', 'msg' => 'Gmail files uploaded.']);
            }
        }
        if ($request->file('file')) {
            $media = new Media();
            $media->file_name = $request->input('filename');
            $media->file_path = $request->file('file')->store(getFileDirectory());
            $media->file_size = $request->file('file')->getSize();
            $media->file_type = $request->file('file')->getClientMimeType();
            $media->file_extension = $request->file('file')->getClientOriginalExtension();
            $media->category = $request->input('category');
            $media->user_id = $request->input('id') ?? Auth::id();
            $media->uploaded_by = Auth::user()->id;
            if ($media->save()) {
                $project = User::find($request->input('id') ?? $attachment->user_id)->project;
                if ($project) {
                    self::storeNotification("$request->category", Auth::id(), $project->id, $request->category);
                } else {
                    self::storeNotification("$request->category", Auth::id(), $request->category);
                }
                return response()->json(['status' => "success", 'msg' => "File uploaded."]);
            }
        }
        return response()->json(['status' => "failure", 'msg' => "File uploading failed."]);
    }

    public static function doApplication($request, $userId = null)
    {
        if (session('role') != "Borrower") {
            $user = User::find($userId) ?? auth::user();
        } else {
            $user = $userId ? User::find($userId) : auth::user();
        }
        $data = $request->validated();
        $isNewApplication = !$user->application()->exists();
        $status = $data['employement_status'];
        $type = $data['property_type'];
        if ($status == 'other') {
            $status = $request->employment_other_status;
            $data = Arr::except($data, 'employment_other_status');
        }
        if ($type == 'other') {
            $type = $request->property_type_other;
            $data = Arr::except($data, 'property_type_other');
        }
        if (array_key_exists('property_type_other', $data)) {
            $data = Arr::except($data, 'property_type_other');
        }
        $data['user_id'] = $user->id ?? Auth::id();
        if ($request->has('user_id')) {
            $data['user_id'] = $request->user_id;
        }
        self::storeNotification(($isNewApplication ? 'Inserted ' : 'Updated ') . "Loan Application", $user->id ?? Auth::id());

        return [
            'msg_type' => 'msg_success',
            'msg_value' => $isNewApplication ? 'Application inserted successfully.' : 'Application updated successfully.',
            'data' => session('role') == 'Borrower'
            ? ($isNewApplication ? Application::create($data) : $user->application->update($data))
            : Application::create($data),
        ];
    }

    public static function updateApplicatinStatus($application, $status)
    {
        // $application->status = $status == 'accept' ? 1 : ($status == 'delete' ? 3 : 2);
        // $msg = $status == 'accept' ? "Deal completed." : ($status == 'delete' ? "Deal deleted." : "Deal rejected.");

        if ($status == 'accept') {
            $application->status = 1;
            $msg = "Application completed.";
        }
        if ($status == 'delete') {
            $application->status = 3;
            $msg = "Application deleted.";
        }
        if ($status == 'reject') {
            $application->status = 2;
            $msg = "Application rejected.";
        }
        if ($status == 'restore') {
            abort_if(Auth::user()->role !== 'Super Admin', 403, 'You are not allowed to restore an Application');
            $application->status = 0;
            $msg = "Application Restored.";
        }
        $application->update();
        return ['msg_value' => $msg, 'msg_type' => 'msg_success'];
    }
    public static function updateIntakeStatus($intake, $status)
    {
        // $application->status = $status == 'accept' ? 1 : ($status == 'delete' ? 3 : 2);
        // $msg = $status == 'accept' ? "Deal completed." : ($status == 'delete' ? "Deal deleted." : "Deal rejected.");
        if ($status == 'accept') {
            $intake->status = 1;
            $msg = "Intake completed.";
        }
        if ($status == 'delete') {
            $intake->status = 3;
            $msg = "Intake deleted.";
        }
        if ($status == 'reject') {
            $intake->status = 2;
            $msg = "Intake rejected.";
        }

        if ($status == 'restore') {
            abort_if(Auth::user()->role !== 'Super Admin', 403, 'You are not allowed to restore an Intake');
            $intake->status = 0;
            $msg = "Intake Restored.";
        }
        $intake->update();
        return ['msg_value' => $msg, 'msg_type' => 'msg_success'];
    }

    public static function hideCategory($user, $cat)
    {
        $skippedCategories = json_decode($user->skipped_category, true) ?: [];
        if (in_array($cat, $skippedCategories)) {
            $msg = "\"$cat\" showed successfully";
            $skippedCategories = array_values(array_diff($skippedCategories, [$cat]));
        } else {
            $msg = "\"$cat\" hidden successfully";
            $skippedCategories[] = $cat;
        }

        $user->skipped_category = json_encode($skippedCategories);
        $user->save();
        return ['msg_value' => $msg, 'msg_type' => 'msg_success'];
    }

    public static function deleteCategory($user, $cat)
    {
        $user->media()->where('category', $cat)->get()->each(function ($file) {
            Storage::delete($file->file_path);
        });
        $user->media()->where('category', $cat)->delete();
        $user->categories()->where('name', $cat)->delete();
        return ['msg_value' => "\"$cat\" category deleted!", 'msg_type' => 'msg_success'];

    }

    public static function filterCat($user, $cat)
    {
        if ((isset($user) && $user->loan_type !== 'Private Loan' && $cat === 'Credit Report') ||
            (isset($user) && $user->loan_type === 'Private Loan' && ($cat === 'Pay Stubs' || $cat === 'Tax Returns')) ||
            (!empty($user->skipped_category) && in_array($cat, json_decode($user->skipped_category))) ||
            ($user->role === 'Borrower' && $user->loan_type === 'Private Loan' && ($cat === 'Pay Stubs' || $cat === 'Tax Returns')) ||
            ($user->role === 'Borrower' && $user->loan_type !== 'Private Loan' && $cat === 'Credit Report')) {
            return true;
        } else {
            return false;
        }

    }

    public static function uploadFiles($request)
    {
        $request->validate([
            'files' => 'required',
            'files.*' => 'mimes:png,jpg,jpeg,pdf,docx,doc',
        ]);
        foreach ($request->file('files') as $file) {
            $filename = $file->getClientOriginalName();
            $newAattachment = new Attachment();
            $newAattachment->file_name = $filename;
            $newAattachment->file_path = $file->store(getGmailFileDirectory());
            $newAattachment->file_size = $file->getSize();
            $newAattachment->file_extension = $file->getClientOriginalExtension();
            $newAattachment->user_id = Auth::user()->id;
            $newAattachment->uploaded_by = Auth::user()->id;
            $newAattachment->save();
        }
        $msg = ['msg_type' => 'msg_success', 'msg_value' => 'Files Uploaded Successfully'];
        return $msg;
    }

    public static function insertFromExcel(Request $request)
    {
        $request->validate([
            'spreadsheet' => 'required|file|mimes:xlsx',
        ]);
        $spreadsheet = IOFactory::load($request->spreadsheet);
        $excelSheet = $spreadsheet->getActiveSheet()->toArray(null, true, true, true);

        $allowedRoles = ["Processor", "Associate", "Junior Associate", "Borrower"];
        $allowedLoanTypes = ["Private Loan", "Full Doc", "Non QM"];
        $commonRoles = ['Processor', 'Admin', 'Super Admin'];
        $roleHierarchy = [
            'Processor' => $commonRoles,
            'Associate' => array_merge($commonRoles, ['Associate']),
            'Junior Associate' => array_merge($commonRoles, ['Junior Associate']),
        ];
        foreach (array_slice($excelSheet, 1) as $index => $row) {
            $financeType = ucfirst($row['D']) === "" ? null : ucfirst($row['D']);
            $loanType = ucwords($row['E']) === "" ? null : ucwords($row['E']);
            if ($row['A'] == null && $row['B'] == null) {
                continue;
            }
            self::validateRow($row, $allowedRoles, $allowedLoanTypes, $index, $financeType, $loanType, $roleHierarchy);
            $users[] = [
                'name' => $row['A'],
                'email' => $row['B'],
                'password' => bcrypt($row['C']),
                'role' => ucwords($row['F']),
                'loan_type' => $loanType,
                'finance_type' => $financeType,
                'created_by' => Auth::id(),
            ];
        }
        User::insert($users);
        return ['msg_type' => 'msg_success', 'msg_value' => 'users data inserted successfully'];
    }

    private static function validateRow($row, $allowedRoles, $allowedLoanTypes, $index, $financeType, $loanType, $roleHierarchy)
    {

        if (!filter_var($row['B'], FILTER_VALIDATE_EMAIL) || $row['B'] === 'email@email.com') {
            self::getMessage($index, 'Email is not  valid.');
        }
        if (!in_array(ucwords($row['F']), $allowedRoles)
            || ($financeType && !in_array($financeType, ["Purchase", "Refinance"]))
            || ($loanType && !in_array($loanType, $allowedLoanTypes))) {
            self::getMessage($index, 'data is incorrect. Please correct the data and try again');
        }
        if (array_key_exists(Auth::user()->role, $roleHierarchy)
            && in_array(ucwords($row['F']), $roleHierarchy[Auth::user()->role])) {
            self::getMessage($index, '. You can not create user with this role.');
        }
        $emailArray = User::withTrashed()->pluck('email')->toArray();
        if (in_array($row['B'], $emailArray)) {
            self::getMessage($index, 'Email is already Exists');
        }
    }

    public static function getMessage($index, $message)
    {
        throw ValidationException::withMessages(["spreadsheet" => "Row no " . ($index + 1) . " $message"]);
    }

    public static function exportContactsToExcel($request)
    {
        $request->validate([
            'contact' => 'required',
        ]);
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $feilds = ['b_fname', 'b_lname', 'b_phone', 'b_email', 'b_address', 'b_suite', 'b_city', 'b_state', 'b_zip', 'co_fname', 'co_lname', 'co_phone', 'co_email', 'co_address', 'co_suite', 'co_city', 'co_state', 'co_zip', 'p_address', 'p_suite', 'p_city', 'p_state', 'p_zip', 'purchase_type', 'company_name', 'purchase_purpose', 'purchase_price', 'purchase_dp', 'loan_amount', 'mortage1', 'interest1', 'mortage2', 'interest2', 'value', 'cashout', 'cashout_amount', 'purpose'];
        $headers = ['First Name', 'Last Name', 'Phone', 'Email', 'Address', 'Suite', 'City', 'State', 'Zip', 'Co-Borrower First Name', 'Co-Borrower Last Name', 'Co-Borrower Phone', 'Co-Borrower Email', 'Co-Borrower Address', 'Co-Borrower Suite', 'Co-Borrower City', 'Co-Borrower State', 'Co-Borrower Zip', 'Co-Borrower Address', 'Property Suite', 'Property City', 'Property State', 'Property Zip', 'Purchase Type', 'Company Name', 'Purchase Purpose', 'Purchase Price', 'Purchase Down Payment', 'Loan Amount',
            'Mortage-1', 'interest1', 'mortage2', 'interest2', 'value', 'cashout', 'cashout_amount', 'purpose'];
        $cell = "A";
        foreach ($headers as $header) {
            $sheet->setCellValue($cell . '1', $header);
            $cell++;
        }
        $row = 2;
        foreach ($request->contact as $contact) {
            $cell = 'A';
            $info = Info::find($contact);
            foreach ($feilds as $field) {
                $sheet->setCellValue($cell . $row, $info->$field);
                $cell++;
            }
            $row++;
        }
        $writer = new Xls($spreadsheet);
        $writer->save('contact.xlsx');
        return ['msg_type' => 'msg_success', 'msg_value' => 'data exported successfully'];

    }

    public static function storeNotification($message, $userid, $projectId = null, $category = null)
    {

        $project = Project::where('borrower_id', $userid)->first();
        $user = User::find($userid);
        if ($projectId) {
            $project = Project::find($projectId);
        }
        if ($project) {
            $allIds = $project->users->pluck('id')->toArray();
            array_push($allIds, User::where('role', 'Super Admin')->first()->id);
            foreach ($allIds as $Admin) {
                $notifyThisUser = User::find($Admin);
                $notifyThisUser->notify(new FileUploadNotification($user, $message, $project->id, $category));
            }
        } else {
            $admin = User::where('role', 'Super Admin')->first();
            $admin->notify(new FileUploadNotification($user, $message, $category));
            if ($user->created_by) {
                $createdby = User::find($user->created_by);
                $createdby->notify(new FileUploadNotification($user, $message, $category));
            }
        }
    }

    public static function markAsRead($id)
    {
        Auth::user()->notifications->where('id', $id)->markAsRead();
    }

    public static function getAssociates(Company $company)
    {
        $admin = User::find(Auth::id());
        if ($admin->role === 'Super Admin' || $admin->role === 'Admin') {
            $users = $company->users()->get();
        } else {
            $currentUserId = $admin->id();
            $users = $admin->createdUsers()
                ->with(['createdBy', 'info'])
                ->whereIn('role', ['Processor', 'Associate', 'Junior Associate', 'Borrower'])
                ->where(function ($query) use ($currentUserId) {
                    // Associates directly created by the current user
                    $query->where('created_by', $currentUserId);
                    // Associates created by users who were created by the current user
                    $query->orWhereHas('createdBy', function ($nestedQuery) use ($currentUserId) {
                        $nestedQuery->where('created_by', $currentUserId);
                    });
                })
                ->get();
        }
        foreach ($users as $user) {
            $associates[] = [
                'role' => $user->role,
                'id' => $user->id,
                'name' => $user->name,
            ];
        }

        return $associates;

    }

    public static function doContact($request, $id)
    {
        $req = $request->validate([
            'name' => 'required',
            'email' => 'required',
            'loanamount' => 'nullable',
            'loantype' => 'required',
        ]);
        $contact = $id > 0 ? Contact::find($id) : new Contact();
        $contact->name = $request->name;
        $contact->email = $req['email'];
        $contact->loanamount = $req['loanamount'];
        $contact->loantype = $req['loantype'];
        $contact->user_id = $contact->user_id ?? Auth::id();
        $contact->save();
    }

    public static function redirectTo($route, $message)
    {
        $message = ucfirst(str_replace('-', ' ', $message));
        if ($route === 'back') {
            return back()->with('msg_success', "$message.");
        }

        return redirect(getRoutePrefix() . "/$route")->with('msg_success', "$message.");
    }

    public static function submitIntakeForm(Request $request)
    {
        if (!$request->user_id) {
            $admin = Auth::user();
            $user = new User;
            $intakeForm = new IntakeForm();
        } else {
            $user = User::where('id',$request->user_id)->first();
            $intakeForm = IntakeForm::where('user_id', $request->user_id)->first();
            $admin = User::where('created_by', $user->created_by)->first();
        }
        $faker = Factory::create();
        DB::beginTransaction();
        try {

            if (!$request->user_id) {
                $user->name = $request->first_name . ' ' . $request->last_name;
                $user->email = $request->email;
                $user->role = 'Borrower';
                $user->created_by = $admin->id;
                $user->company_id = $request->company ?? $admin->company_id ?? null;
                $user->password = bcrypt($faker->password(8));
                if ($user->save()) {
                    Password::sendResetLink($request->only('email'));
                    Password::RESET_LINK_SENT;
                }
            }

            $intakeForm->user_id = $user->id;
            $intakeForm->created_by = $admin->id;
            $intakeForm->name = $request->first_name ?? null . '' . $request->last_name;
            $intakeForm->email = $request->email;
            $intakeForm->phone = $request->phone;
            $intakeForm->borrower_employment = $request->borrower_employment;
            $intakeForm->borrower_yearly_income = $request->borrower_yearly_income;
            $intakeForm->borrower_credit_score = $request->borrower_credit_score;
            $intakeForm->address = $request->address;
            $intakeForm->address_two = $request->address_two ?? null;
            $intakeForm->co_borrower_name = $request->is_there_co_borrower == 'Yes' ? $request->co_borrower_first_name . ' ' . $request->co_borrower_last_name : null;
            $intakeForm->co_borrower_email = $request->is_there_co_borrower == 'Yes' ? $request->co_borrower_email : null;
            $intakeForm->co_borrower_phone = $request->is_there_co_borrower == 'Yes' ? $request->co_borrower_phone : null;
            $intakeForm->co_borrower_employment = $request->is_there_co_borrower == 'Yes' ? $request->co_borrower_employment : null;
            $intakeForm->co_borrower_yearly_income = $request->is_there_co_borrower == 'Yes' ? $request->co_borrower_yearly_income : null;
            $intakeForm->co_borrower_credit_score = $request->is_there_co_borrower == 'Yes' ? $request->co_borrower_credit_score : null;
            $intakeForm->city = $request->city ?? null;
            $intakeForm->state = $request->state ?? null;
            $intakeForm->zip = $request->zip ?? null;
            $intakeForm->finance_type = $request->finance_type;
            $intakeForm->loan_type = $request->loan_type;
            $intakeForm->property_type = $request->property_type;
            $intakeForm->property_profile = $request->property_profile;
            $intakeForm->purchase_price = $request->purchase_price ?? $request->purchase_price_fix_flip ?? null;
            $intakeForm->property_value = $request->property_value_cashout ?? $request->property_value_fix_flip ?? null;
            $intakeForm->down_payment = $request->down_payment ?? $request->down_payment_fix_flip ?? null;
            $intakeForm->current_loan_amount = $request->current_loan_amount_purchase ??
            $request->current_loan_amount_cashout ??
            $request->current_loan_amount_refinance ?? null;
            $intakeForm->closing_date = $request->closing_date_purchase ?? $request->closing_date_fix_flip ?? null;
            $intakeForm->current_lender = $request->current_lender_cashout ?? $request->current_lender_refinance ?? null;
            $intakeForm->rate = $request->rate_refinance ?? $request->rate_cashout ?? null;
            $intakeForm->is_it_rental_property = $request->finance_type === 'Cash Out' ? $request->is_it_rental_property : null;
            $intakeForm->monthly_rental_income = $request->monthly_rental_income ?? $request->monthly_rental_income_refinance ?? null;
            $intakeForm->cashout_amount = $request->cashout_amount ?? null;
            $intakeForm->is_repair_finance_needed = $request->finance_type == 'Fix & Flip' ? $request->is_repair_finance_needed : null;
            $intakeForm->how_much = $request->repair_finance_amount ?? null;
            $intakeForm->note = $request->note ?? null;
            $intakeForm->save();

            $request['borroweraddress'] = $request->address;
            if (!$request->user_id) {
                self::storeProject($request, $user->id);
            }
            Application::create([
                'email' => $request->email,
                'phone' => $request->phone,
                'name' => $request->first_name . ' ' . $request->last_name,
                'city' => $request->city,
                'address' => $request->address,
                'zip' => $request->zip,
                'user_id' => $user->id,
            ]);
            DB::commit();
            return response()->json('success', 200);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json($e->getMessage(), 200);
        }
    }

    public static function loanIntake()
    {
        $user = Auth::user();
        $data['role'] = $user->role;
        $data['tables'] = ['Pending Intake'];
        if ($user->role == 'Super Admin') {
            $data['intakes'] = IntakeForm::latest()->get();
        } elseif ($user->role == 'Admin') {
            $users = User::where('company_id', $user->company_id)->get();
            $data['intakes'] = IntakeForm::whereHas('user', function ($query) use ($users) {
                $query->whereIn('id', $users->pluck('id'));
            })
                ->latest()
                ->get();
        } else {
            $users = User::where('created_by', $user->id)->get();
            $data['intakes'] = IntakeForm::whereHas('user', function ($query) use ($users) {
                $query->whereIn('id', $users->pluck('id'));
            })->latest()->get();
        }
        return view('admin.intakes.index', $data);
    }

    public static function loanIntakeShow($id)
    {
        $data['intake'] = IntakeForm::find($id);
        $data['enableTeams'] = [];
        return view('admin.intakes.show', $data);
    }

    public static function storeProject(Request $request, $user)
    {
        $project = Project::create([
            'name' => $request->borroweraddress,
            'borrower_id' => $user,
            'team_id' => $request->team,
            'created_by' => Auth::id(),
        ]);

        if ($request->associate) {
            foreach ($request->associate as $associate_id) {
                $project->users()->attach($associate_id);
            }
        }
        if ($request->juniorAssociate) {
            foreach ($request->juniorAssociate as $associate_id) {
                $project->users()->attach($associate_id);
            }
        }
        if ($request->processor) {
            foreach ($request->processor as $associate_id) {
                $project->users()->attach($associate_id);
            }
        }

        return "Created new Deal by name : $request->borroweraddress";
    }

    public static function getUsers()
    {
        $user = User::find(Auth::id());
        $data['role'] = $user->role;
        if ($user->role == 'Super Admin') {
            $allUsers = User::with(['company', 'createdBy'])->whereNotIn('role', ['Super Admin'])->latest()->get();
            $data['trashed'] = User::withTrashed()
                ->with('createdBy')
                ->whereNotNull('deleted_at')
                ->latest()
                ->get();
        } elseif ($user->role === 'Admin') {
            $allUsers = User::where('company_id', $user->company_id)
                ->where('role', '!=', 'Admin')
                ->where('role', '!=', 'Super Admin')
                ->with(['createdBy'])
                ->latest()
                ->get();
        } else {
            $allUsers = self::allusers($user);
        }

        $data['verified'] = $allUsers->filter(function ($user) {
            return $user->email_verified_at !== null;
        });
        $data['unverified'] = $allUsers->filter(function ($user) {
            return $user->email_verified_at === null;
        });
        return $data;
    }

    public static function applications()
    {
        $admin = Auth::user();
        $data['role'] = $admin->role;
        $data['tables'] = ['Pending Applications', 'Completed Applications', 'Rejected Applications', 'Deleted Applications'];
        if ($data['role'] == 'Super Admin') {
            $data['applications'] = Application::with(['user' => function ($query) {
                $query->withTrashed();
            }])->latest()->get();
        } elseif ($admin->role == 'Admin') {
            $data['users'] = User::where('company_id', $admin->company_id)->withTrashed()->get();
            $data['applications'] = Application::whereIn('user_id', $data['users']->pluck('id'))->latest()->get();
        } else {
            $data['tables'] = array_diff($data['tables'], ['Deleted Applications']);
            $allUsers = self::allusers($admin);
            $projects = Project::where('created_by', $admin->id)
                ->orWhereHas('users', function ($query) use ($admin) {
                    $query->where('users.id', $admin->id);
                })
                ->get();
            $projects->each(function ($project) use (&$allUsers) {
                $borrower = optional($project->borrower)->load('application');
                if ($borrower && $borrower->application) {
                    $allUsers = $allUsers->merge([$borrower]);
                }
            });
            $data['users'] = $allUsers;
        }
        return $data;
    }
    public static function allusers($user)
    {
        $directlyCreatedUsers = $user->createdUsers()
            ->with(['createdBy', 'company'])
            ->whereIn('role', ['Associate', 'Junior Associate', 'Borrower', 'Assistant'])
            ->latest()
            ->get();

        $indirectlyCreatedUsers = User::whereIn('created_by', $directlyCreatedUsers->pluck('id'))
            ->with(['createdBy', 'company'])
            ->whereIn('role', ['Associate', 'Junior Associate', 'Borrower', 'Assistant'])
            ->latest()
            ->get();

        return $directlyCreatedUsers->merge($indirectlyCreatedUsers);
    }

    public static function validatePassword(Request $request)
    {
        $request->validate([
            'password' => ['required', PasswordRule::min(8)
                    ->mixedCase()
                    ->letters()
                    ->numbers()
                    ->symbols()
                    ->uncompromised(), 'confirmed'],
        ], [
            'password.required' => 'The password field is required.',
            'password.confirmed' => 'The password confirmation does not match.',
            'password.*' => 'The password must be at least 8 characters long and contain a mix of uppercase and lowercase letters, numbers, and symbols.',
        ]);
    }

    public static function addCategoryToUser(Request $request, User $user)
    {
        if (in_array(ucwords($request->name), config('smm.file_category')) || $request->name == "id/driver's license") {
            return response()->json(["error" => "This Category \" $request->name\" already exists"]);
        }
        $validator = Validator::make($request->all(), [
            'name' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()->all()]);
        }
        $cate = $user->categories()->get('name');
        if (in_array($request->name, array_column($cate->toArray(), 'name'), true)) {
            return response()->json(['error' => 'The name has already been taken']);
        }

        UserCategory::create([
            'name' => $request->name,
            'user_id' => $user->id,
        ]);
        return response()->json(['success' => 'Added new records.']);
    }
}
