<?php

namespace App\Services;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use App\Models\{User, Media, Info, Application};
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\{Hash, Auth, Storage};

class AdminService
{
    public static function users(Request $request)
    {
        $data['users'] = User::where('role', 'Borrower')->get();
        $data["active"] = "user";
        return $data;
    }
    //Shows input for adding a user
    public static function addUser(Request $request, $id)
    {
        if ($id == -1) {
            $user = new User();
        } else {
            $user = User::find($id);
        }
        $data['user'] = $user;
        $data["active"] = "user";
        return $data;
    }

    //Saves the record of a newly inserted user in database
    public static function doUser(Request $request, $id)
    {
        $isNewUser = ($id == -1);
        $request->validate([
            'email' => "required|email" . ($isNewUser ? "|unique:users" : "") . "|max:255",
            'name' => "required",
            'password' => 'sometimes|required',
            'role' =>
            #This the custom Rule. Less than Admin Role Can't add User with the role === admin OR Processor
            function ($attribute, $value, $fail) {
                self::validateCurrentUser($attribute, $value, $fail);
            }
        ]);
        $user = $isNewUser ? new User() : User::find($id);
        $msg = $isNewUser ? "User added." : "User updated.";
        $user->fill($request->only(['email', 'name']));
        $request->password != "" ? $user->password = Hash::make($request->password) : $user->password = bcrypt('password');
        $user->role = $request->role ?? 'Borrower';

        if ($request->file('file')) {
            if (!str_contains($user->pic, "default") && $id !== -1) {
                Storage::delete($user->pic);
            }
            $user->pic = $request->file('file')->store(getFileDirectory());
        }

        if ($request->role === 'Borrower' || Auth::guest()) {
            $user->finance_type = $request->finance_type;
            $user->loan_type = $request->loan_type;
        }
        $user->created_by = optional(Auth::user())->id;

        if (session('role') === 'Admin') {
            $user->email_verified_at = now();
        }
        if ($user->save()) {
            $msg = "Registered. A verification link has been sent. You need to verify your email before login. Please, check your email.";
            if (session('role') != null) {
                Password::sendResetLink(
                    $request->only('email')
                );
                Password::RESET_LINK_SENT;
            } else {
                event(new Registered($user));
            }
        }
        return ['msg_type' => 'msg_success', 'msg_value' => $msg];
    }

    private static function validateCurrentUser($attribute, $value, $fail)
    {
        $role = Session('role');
        if ($role === 'Processor' && $value === 'Processor' || $value === 'admin')
            $fail('The selected ' . $attribute . ' is invalid');
        if ($role === 'Associate' && ($value === 'Associate' || $value === 'admin' || $value === 'Processor'))
            $fail('The selected ' . $attribute . ' is invalid');
        if ($role === 'Junior Associate' && ($value === 'Junior Associate' || $value === 'admin' || $value === 'Processor' || $value === 'Associate'))
            $fail('The selected ' . $attribute . ' is invalid');
    }

    //Saves the record of a newly inserted user in database
    public static function deleteUser(Request $request, $id)
    {
        $user = User::find($id);
        if ($user->delete()) {
            return ['msg_type' => 'msg_success', 'msg_value' => 'User deleted.'];
        }
        return ['msg_type' => 'msg_error', 'msg_value' => 'An error occured while deleting the user.'];
    }
    //============================
    //=============user related methods
    //============================
    //Shows input for adding a user

    public static function filesCat(Request $request, $id)
    {
        $user = User::find($id);
        $data['user'] = $user;
        $data['id'] = $id;
        $data['info'] = $user->info;
        $media = $user->media()->orderBy("category")->get();
        $data["files"] = $media;
        $data['filesCount'] = $user->media()->count();
        $data["active"] = "file";
        return $data;
    }
    //Shows input for adding a user
    public static function files(Request $request, $id)
    {
        if ($id !== -1) {
            $users = User::where('role', 'user')
                ->where('id', $id)
                ->get();
            $data['id'] = $id;
            $data['info'] = User::find($id)->info;
        } else {
            $users = User::where('role', 'user')
                ->get();
        }

        $filesIds = [];
        foreach ($users as $user) {
            # code...
            $media = $user->media;
            foreach ($media as $m) {
                # code...
                $filesIds[] = $m->id;
            }
        }
        $filesIds = array_unique($filesIds);
        $data['files'] = Media::find($filesIds);
        $data['filesCount'] = Media::find($filesIds)->count();
        $data["active"] = "file";
        return $data;
    }
    //Shows input for adding a user
    public static function docs($request, $id, $cat)
    {
        $cat = str_replace('-', '/', $cat);
        $user = User::find($id);
        $media = $user->media()->where('category', $cat)->get();
        $data['id'] = $id;
        $data['cat'] = $cat;
        $data['files'] = $media;
        $data['filesCount'] = $user->media()->where('category', $cat)->count();
        $data["active"] = "file";
        return $data;
    }

    //Saves the record of a newly inserted user in database
    public static function updateFileStatus($request, $id)
    {
        $media = Media::find($id);
        $media->status = $request->status;
        $media->comments = $request->comments;
        if ($media->save()) {
            return ['msg_type' => 'msg_success', 'msg_value' => 'Status updated.'];
        }
        return ['msg_type' => 'msg_error', 'msg_value' => 'An error occured while udpate the status of the file.'];
    }

    //Saves the record of a newly inserted user in database
    public static function updateCategoryStatus($request)
    {

        if (Media::where('user_id', $request->user_id)
            ->where('category', $request->category)
            ->update([
                "status" => $request->status
            ])
        ) {
            return ['msg_type' => 'msg_success', 'msg_value' => 'Status updated.'];
        }
        return ['msg_type' => 'msg_error', 'msg_value' => 'An error occured while udpate the status of the file.'];
    }

    //Updates category comments on a file
    public static function updateCatComments($request, $cat)
    {
        $cat = str_replace('-', '/', $cat);
        $updated = Media::where('user_id', $request->user_id)
            ->where('category', $cat)
            ->update([
                "cat_comments" => $request->cat_comments
            ]);
        if ($updated) {
            return ['msg_type' => 'msg_success', 'msg_value' => 'Category comments saved.'];
        }
        return ['msg_type' => 'msg_error', 'msg_value' => 'Couldn\'t save category comments.'];
    }
    //Saves the record of a newly inserted user in database
    public static function deleteFile(Request $request, $id)
    {

        $media = Media::find($id);
        if ($media->delete()) {
            Storage::delete($media->file_path);
            return ['msg_type' => 'msg_success', 'msg_value' => 'File deleted.'];
        }
        return ['msg_type' => 'msg_error', 'msg_value' => 'An error occured while deleting the file.'];
    }

    public static function applications()
    {
        $data['applications'] = Application::all();
        return $data;
    }

    public static function allLeads()
    {
        $data['leads'] = Info::all();
        return $data;
    }

    public static function lead($user)
    {
        $user = User::find($user);
        $data['info'] = $user->info;
        $data['user'] = $user;
        return $data;
    }

    public static function deleteLead(Info $info)
    {
        $info->delete();
        return ['msg_type' => 'msg_success', 'msg_value' => 'Lead deleted.'];
    }
}
