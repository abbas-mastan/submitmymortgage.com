<?php

namespace App\Services;

use App\Models\Media;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Auth\Events\Registered;

class AdminService
{
    
    /**
       * 
       */
    public function __construct()
    {
        
    }

    // Your methods for repository
    //
    //============================
    //=============user related methods
    //============================
    //Shows input for adding a user
    public static function users(Request $request) {
        $data['users'] = User::where('role','user')
                ->get();
        $data["active"] = "user";
       return $data;
    }
    //Shows input for adding a user
    public static function addUser(Request $request,$id) {
        if($id == -1)
        {
            $user = new User();  
        }
        else
        {
            $user = User::find($id);
        }
       
        $data['user'] = $user;
        $data["active"] = "user";
       return $data;
    }
     //Returns a list of users in a college for adding user
    public static function getUsers(Request $request) {
        
        $users = College::find($request->college)
            ->users;
       
       return response()->json(["status" => true,"users" => $users]);
    }
    
    
    //Saves the record of a newly inserted user in database
    public static function doUser(Request $request,$id) {
        
        if($id == -1)
        {
            $request->validate([
            'email' => "required|email|unique:users|max:255",
            'name' => "required",
            'password' => 'required|confirmed'
            ]);
            $user = new User();
            $user->email = $request->email;
            $msg = "User added.";
            if(session('role') !== 'admin')
            {
                $msg = "Registered. A verification link has been sent. You need to verify your email before login. Please, check your email.";
            }
            
        }
        else
        {
            $request->validate([
            'email' => "required|email|max:255",
            'name' => "required",
            ]);
            $user = User::find($id);
            $msg = "User updated.";
        }
        $user->name = $request->name;
        if($request->password != "")
            $user->password = Hash::make($request->password);
        $user->role = "user";
        if( !empty($request->role) )
        {
            $user->role = $request->role;
            $user->email_verified_at = now();
        }
        if($request->file('file'))
        {
            if(!str_contains($user->pic, "default") && $id !== -1)
            {
                Storage::delete($user->pic);
            }
            
            $user->pic = $request->file('file')->store(getFileDirectory());
            
        }
        $user->finance_type = $request->finance_type;
        if($user->save() && session('role') !== 'admin')
        {
            event(new Registered($user));
        }
        //Meta values of users
        
        // if($userId == -1)
        // {
        //     logActivity(Auth::id(), "user Added", "user Added ({$user->name},{$user->id})", "") ;
        //     event(new UserEvent($user));
        // }
        
        return ['msg_type' => 'msg_success','msg_value' => $msg];
    }
    //Saves the record of a newly inserted user in database
    public static function deleteUser(Request $request,$id) {
        
        $user = User::find($id);
        if($user->delete())
        {
            return ['msg_type' => 'msg_success','msg_value' => 'User deleted.'];
        }
        return ['msg_type' => 'msg_error','msg_value' => 'An error occured while deleting the user.'];
    }
    //============================
    //=============user related methods
    //============================
    //Shows input for adding a user
    public static function filesCat(Request $request,$id) {
        
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
    public static function files(Request $request,$id) {
        if($id !== -1)
        {
            $users = User::where('role','user')
            ->where('id', $id)
                ->get();
            $data['id'] = $id;
            $data['info'] = User::find($id)->info;
        }
        else
        {
            $users = User::where('role','user')
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
    public static function docs($request, $id, $cat) {
        $cat = str_replace('-','/', $cat);
        $user = User::find($id);
        $media = $user->media()->where('category',$cat)->get();
        
        $data['id'] = $id;
        $data['cat'] = $cat;
        $data['files'] = $media;
        $data['filesCount'] = $user->media()->where('category', $cat)->count();
        $data["active"] = "file";
       return $data;
    }
    //Saves the record of a newly inserted user in database
    public static function updateFileStatus($request,$id) {
        
        $media = Media::find($id);
        $media->status = $request->status;
        $media->comments = $request->comments;
        if($media->save())
        {
            return ['msg_type' => 'msg_success','msg_value' => 'Status updated.'];
        }
        return ['msg_type' => 'msg_error','msg_value' => 'An error occured while udpate the status of the file.'];
    }
    //Saves the record of a newly inserted user in database
    public static function updateCategoryStatus($request) {
        
        if(Media::where('user_id',$request->user_id)
        ->where('category',$request->category)
        ->update([
            "status" => $request->status
        ]))
        {
            return ['msg_type' => 'msg_success','msg_value' => 'Status updated.'];
        }
        return ['msg_type' => 'msg_error','msg_value' => 'An error occured while udpate the status of the file.'];
    }
    //Updates category comments on a file
    public static function updateCatComments($request,$cat) {
        $cat = str_replace('-','/', $cat);
        $updated = Media::where('user_id',$request->user_id)
        ->where('category',$cat)
        ->update([
            "cat_comments" => $request->cat_comments
        ]);
        if($updated)
        {
            return ['msg_type' => 'msg_success','msg_value' => 'Category comments saved.'];
        }
        return ['msg_type' => 'msg_error','msg_value' => 'Couldn\'t save category comments.'];
    }
    //Saves the record of a newly inserted user in database
    public static function deleteFile(Request $request,$id) {
        
        $media = Media::find($id);
        if($media->delete())
        {
            Storage::delete($media->file_path);
            return ['msg_type' => 'msg_success','msg_value' => 'File deleted.'];
        }
        return ['msg_type' => 'msg_error','msg_value' => 'An error occured while deleting the file.'];
    }
}
