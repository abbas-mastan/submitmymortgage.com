<?php

namespace App\Services;

use App\Models\Info;
use App\Models\User;
use Illuminate\Support\Facades\Password;
use App\Models\Media;
use App\Models\Company;
use App\Models\Contact;
use App\Models\Project;
use App\Models\Attachment;
use App\Models\IntakeForm;
use App\Models\Application;
use Illuminate\Support\Arr;
use Faker\Factory;
use Illuminate\Http\Request;
use App\Notifications\FileUploadNotification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xls;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Validator;
use PhpOffice\PhpSpreadsheet\IOFactory;

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
        $msg = "Picture updated.";
        $user = Auth::user();
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
                    self::storeNotification("Uploaded $request->category", $request->id ?? $attachment->user_id);
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
                self::storeNotification("Uploaded $request->category", $request->id ?? Auth::id());
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
        if($status == 'reject') {
            $application->status = 2;
            $msg = "Application rejected.";
        }
        
        if($status == 'restore') {
            abort_if(Auth::user()->role !== 'Super Admin',403,'You are not allowed to restore an Application');
            $application->status = 0;
            $msg = "Application Restored.";
        }
        $application->update();
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
    public static function applications()
    {
        $data['role'] = Auth::user()->role;
        $data['tables'] = ['Pending Applications', 'Completed Applications', 'Incomplete Applications', 'Deleted Applications'];

        if ($data['role'] == 'Super Admin') {
            $data['applications'] = Application::with(['user' => function ($query) {
                $query->withTrashed();
            }])->get();
        } else {
            $data['tables'] = array_diff($data['tables'], ['Deleted Applications']);

            $user = User::find(auth()->id());
            $role = $user->role;
            // Fetch users created directly by the user
            $directlyCreatedUsers = $user->createdUsers()
                ->with(['createdBy', 'application.user'])
                ->withTrashed()
                ->whereIn('role', [($role === 'Processor' ? '' : 'Processor'), 'Associate', 'Junior Associate', 'Borrower'])
                ->get();

            $indirectlyCreatedUsers = User::whereIn('created_by', $directlyCreatedUsers
                    ->pluck('id'))
                ->with('application.user')
                ->withTrashed()
                ->orWhere('company_id', $role === 'Admin' ? $user->company_id ?? -1 : -1)
                ->whereIn('role', [($role === 'Processor' ? '' : 'Processor'), 'Associate', 'Junior Associate', 'Borrower'])
                ->get();
            // Combine the directly and indirectly created users
            $allUsers = $directlyCreatedUsers->merge($indirectlyCreatedUsers);
            $data['users'] = $allUsers;

        }

        return $data;
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

    public static function storeNotification($message, $userid)
    {

        $project = Project::where('borrower_id', $userid)->first();
        if ($project) {
            $allIds = $project->users->pluck('id')->toArray();
            array_push($allIds, User::where('role', 'Super Admin')->first()->id);
            foreach ($allIds as $Admin) {
                $notifyThisUser = User::find($Admin);
                $user = User::find($userid);
                $notifyThisUser->notify(new FileUploadNotification($user, $message));
            }
        } else {
            $admin = User::where('role', 'Super Admin')->first();
            $user = User::find($userid);
            $admin->notify(new FileUploadNotification($user, $message));
            if ($user->created_by) {
                $createdby = User::find($user->created_by);
                $createdby->notify(new FileUploadNotification($user, $message));
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
        if($admin->role === 'Super Admin' || $admin->role === 'Admin'){
            $users = $company->users()->get();
        }else{
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

    public  static function submitIntakeForm(Request $request)
    {
        $user = new User;
        $faker = Factory::create();
        $user->name = $request->first_name . ' ' . $request->last_name;
        $user->email = $request->email;
        $user->role = 'Borrower';
        $user->created_by = Auth::id();
        $user->password = bcrypt($faker->password(8));
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

    public  static function storeProject(Request $request,$user)
    {
        $project = Project::create([
            'name' => $request->borroweraddress,
            'borrower_id' => $user,
            'team_id' => $request->team,
            'created_by' => Auth::id(),
        ]);

        if($request->associate){
        foreach ($request->associate as $associate_id) {
            $project->users()->attach($associate_id);
        }
        }
        if($request->juniorAssociate){
            foreach ($request->juniorAssociate as $associate_id) {
                $project->users()->attach($associate_id);
            }
        }
        if($request->processor){
        foreach ($request->processor as $associate_id) {
            $project->users()->attach($associate_id);
        }
        }

        return "Created new Deal by name : $request->borroweraddress";
    }

}
