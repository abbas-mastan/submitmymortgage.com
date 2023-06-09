<?php

namespace App\Services;

use Illuminate\Support\Arr;
use Illuminate\Http\Request;
use App\Models\{Media, Attachment,User,Application};
use Illuminate\Support\Facades\{Storage, Auth, File as FacadesFile};

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
        if(session('role') != "Borrower"){
            $user = User::where('email',$request->email)->first();
        }else{
            $user = $userId ? User::find($userId) : auth()->user();
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
        if ($isNewApplication) {
            $data['user_id'] = $user->id ?? Auth::id();
        }
        return [
            'msg_type' => 'msg_success',
            'msg_value' => $isNewApplication ? 'Application inserted successfully.' : 'Application updated successfully.',
            'data' => $isNewApplication ? Application::create($data) : $user->application->update($data)
        ];
    }
}
