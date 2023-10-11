<?php

namespace App\Services;

use App\Models\Info;
use App\Models\User;
use App\Models\Media;
use App\Models\Attachment;
use App\Models\Application;
use Illuminate\Support\Arr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Writer\Xls;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use App\Notifications\FileUploadNotification;
use Illuminate\Validation\ValidationException;

class CommonService
{
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
                $media->uploaded_by = $attachment->uploaded_by;
                try {
                    Storage::copy($attachment->file_path, getFileDirectory() . $uniqueName);
                    $filepath = $request->category;
                    $admin = User::where('role', 'Admin')->first();
                    $user = User::find($request->id ?? $attachment->user_id);
                    $admin->notify(new FileUploadNotification($filepath,$user));
                } catch (\Exception $e) {
                    return response()->json(['status' => "$e", 'filename' => $e]);
                    // return response()->json(['status'=>'File exists','filename'=>$attachment->file_name]);
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
            $media->user_id = $request->input('id') ?? Auth::user()->id;
            $media->uploaded_by = Auth::user()->id;
            if ($media->save()) {
                $filepath = $request->category;
                $admin = User::where('role', 'Admin')->first();
                $user = User::find($request->id ?? Auth::id());
                $admin->notify(new FileUploadNotification($filepath,$user));
                return response()->json(['status' => "success", 'msg' => "File uploaded."]);
            }
        }
        return response()->json(['status' => "failure", 'msg' => "File uploading failed."]);
    }

    public static function doApplication($request, $userId = null)
    {
        if (session('role') != "Borrower") {
            $user = User::where('email', $request->email)->first() ?? auth::user();
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
        $application->status = $status == 'accept' ? 1 : ($status == 'delete' ? 3 : 2);
        $msg = $status == 'accept' ? "Deal completed." : ($status == 'delete' ? "Deal deleted." : "Deal rejected.");
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
        $data['tables'] = ['Pending Applications', 'Completed Deals', 'Incomplete Deals', 'Deleted Deals'];
        if ($data['role'] == 'Admin' || $data['role'] === 'Processor') {
            $data['applications'] = Application::all();
        } else {
            $data['tables'] = array_diff($data['tables'], ['Deleted Deals']);
            $data['applications'] = Auth::user()->createdUsers()->whereIn('role', ['Associate', 'Junior Associate', 'Borrower'])->with('createdUsers')->get();
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
            'file' => 'required',
            'file.*' => 'mimes:png,jpg,jpeg,pdf,docx,doc',
        ]);
        foreach ($request->file('file') as $file) {
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
        $commonRoles = ['Processor', 'Admin'];
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
}
