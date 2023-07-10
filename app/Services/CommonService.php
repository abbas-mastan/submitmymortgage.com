<?php

namespace App\Services;

use App\Models\{Application,Media,Attachment,User};
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\{Storage,Auth};

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
                } catch (\Exception $e) {
                    return response()->json(['status' => "File exists", 'filename' => $e]);
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

        if ($data['employement_status'] == 'other') {
            $data['employement_status'] = $request->employment_other_status;
            $data = Arr::except($data, 'employment_other_status');
        }
        if ($data['property_type'] == 'other') {
            $data['property_type'] = $request->property_type_other;
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
            'data' => session('role') == 'Borrower' ?
            $isNewApplication ? Application::create($data) : $user->application->update($data)
            : Application::create($data),
        ];
    }

    public static function updateApplicatinStatus($application, $status)
    {
        $application->status = $status == 'accept' ? 1 : 2;
        $msg = $status == 'accept' ? "Deal completed." : "Deal rejected.";
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
        if (session('role') == 'Admin') {
            $data['applications'] = Application::all();
        } else {
            $data['applications'] = Auth::user()->createdUsers()->whereIn('role', ['Associate', 'Junior Associate', 'Borrower'])->with('createdUsers')->get();
        }
        return $data;
    }
}