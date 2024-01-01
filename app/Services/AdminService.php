<?php

namespace App\Services;

use Faker\Factory;
use App\Models\Info;
use App\Models\Team;
use App\Models\User;
use App\Models\Media;
use App\Models\Contact;
use App\Models\Assistant;
use App\Models\Attachment;
use App\Mail\AssistantMail;
use App\Models\Company;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Validator;

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
        if(Auth::user()->role === 'Super Admin') $data['companies'] = Company::get();
        $data['user'] = $user;
        $data["active"] = "user";
        return $data;
    }

    //Saves the record of a newly inserted user in database
    public static function doUser(Request $request, $id)
    {
        $isNewUser = ($id == -1);
        if (!$request->ajax()) { 
            $request->validate([
                'email' => "required|email" . ($isNewUser ? "|unique:users" : "") . "|max:255",
                'name' => "required",
                'company' => 'required_if:role,Admin',
                'sendemail' => '',
                'password' => ($isNewUser && !$request->sendemail) ? 'required|min:8|confirmed' : '',
                'role' =>
                #This is the custom Rule. Less than Admin Role Can't add User with the role === admin OR Processor
                function ($attribute, $value, $fail) {
                    self::validateCurrentUser($attribute, $value, $fail);
                },
            ]);
        }
        $user = $isNewUser ? new User() : User::findOrFail($id);
        if ($isNewUser && $request->sendmail) {
            $msg = "Registered. A verification link has been sent. You need to verify your email before login. Please, check your email.";
        } elseif ($isNewUser && !$request->sendmail) {
            $msg = "User created successfully";
        } else {
            $msg = "User updated successfully";
        }

        $user->fill($request->only(['email', 'name']));
        $user->password = $request->filled('password') ?
        Hash::make($request->password) : $user->password = Hash::make(Str::random(8));
        $user->role = $request->input('role', 'Borrower');

        if ($request->file('file')) {
            if (!str_contains($user->pic, "default") && $id !== -1) {
                Storage::delete($user->pic);
            }
            $user->pic = $request->file('file')->store(getFileDirectory()) ?? 'img/profile-default.svg';
        }

        if ($request->role === 'Borrower' || Auth::guest()) {
            $user->finance_type = $request->finance_type;
            $user->loan_type = $request->loan_type;
        }

        $user->created_by = $user->created_by ?? optional(Auth::user())->id;
        $user->email_verified_at = !$request->sendemail ? now() : null;
        if ($user->save() && $request->sendemail) {
            if (session('role') != null && $isNewUser) {
                Password::sendResetLink($request->only('email'));
                Password::RESET_LINK_SENT;
            } else {
                event(new Registered($user));
            }
        }
        if ($request->role === 'Borrower') {
            $contact = new Contact;
            $contact->name = $request->name;
            $contact->email = $request->email;
            $contact->loantype = $request->loan_type;
            $contact->user_id = Auth::id();
            $contact->save();
        }
        if ($request->ajax()) {
            return $user->id;
        }
        return ['msg_type' => 'msg_success', 'msg_value' => $msg];
    }

    private static function validateCurrentUser($attribute, $value, $fail)
    {
        $role = Auth::user()->role;
        if ($role === 'Processor' && $value === 'Processor' || $value === 'Super Admin') {
            $fail('The selected ' . $attribute . ' is invalid');
        }

        if ($role === 'Associate' && ($value === 'Associate' || $value === 'Super Admin' || $value === 'Processor')) {
            $fail('The selected ' . $attribute . ' is invalid');
        }

        if ($role === 'Junior Associate' && ($value === 'Junior Associate' || $value === 'Super Admin' || $value === 'Processor' || $value === 'Associate')) {
            $fail('The selected ' . $attribute . ' is invalid');
        }

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
        $user = User::with(['info', 'media', 'categories', 'project', 'assistants'])->find($id);
        $data['user'] = $user;
        $data['id'] = $id;
        $data['info'] = $user->info;
        $data['filesCount'] = $user->media->count();
        $data["files"] = $user->media()->with('uploadedBy')->orderBy("category")->get();
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
            $users = User::where('role', 'user')->get();
        }
        $filesIds = [];
        foreach ($users as $user) {
            $media = $user->media;
            foreach ($media as $m) {
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
        $data['user'] = User::find($id);
        $media = $data['user']->media()->with('uploadedBy')->where('category', $cat)->get();
        $data['id'] = $id;
        $data['cat'] = $cat;
        $data['files'] = $media;
        $data['filesCount'] = $data['user']->media()->where('category', $cat)->count();
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
                "status" => $request->status,
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
                "cat_comments" => $request->cat_comments,
            ]);
        if ($updated) {
            CommonService::storeNotification("commented on $cat category", $request->user_id);
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
    public static function deleteAttachment(Request $request, $id)
    {
        $media = Attachment::find($id);
        if ($media->delete()) {
            Storage::delete($media->file_path);
            return ['msg_type' => 'msg_success', 'msg_value' => 'File deleted.'];
        }
        return ['msg_type' => 'msg_error', 'msg_value' => 'An error occured while deleting the file.'];
    }

    public static function allLeads()
    {
        if (session('role') == 'Super Admin') {
            $data['leads'] = Info::with('user')->get();
        } else {
            $user = User::find(Auth::id());

            $data['leads'] = $user
                ->createdUsers()
                ->with(['createdBy', 'info'])
                ->whereIn('role', ['Processor', 'Associate', 'Junior Associate', 'Borrower'])
                ->orWhereHas('createdBy', function ($query) {
                    // Add conditions for the createdBy relationship
                    $query->whereIn('role', ['Processor', 'Associate', 'Junior Associate', 'Borrower']);
                })
                ->get();

        }

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

    public static function StoreTeam($request, $id)
    {
        $teamData = $request->validate([
            'name' => 'required',
            // 'processor' => 'required|exists:users,id',
            // 'associate' => 'required|exists:users,id',
            // 'jrAssociate' => 'required|exists:users,id',
            'jrAssociateManager' => 'required',
        ]);

        if ($id) {
            $team = Team::find($id);
        } else {
            $team = new Team([
                'name' => $teamData['name'],
                'jrAssociateManager' => $teamData['jrAssociateManager'],
            ]);
        }
        $team->owner()->associate(Auth::id());
        $team->save();
        if ($request->processor) {
            foreach ($request->processor as $processorId) {
                $team->users()->attach($processorId);
            }
        }

        if ($request->associate) {
            foreach ($request->associate as $associateId) {
                $team->users()->attach($associateId);
            }
        }

        if ($request->jrAssociate) {
            foreach ($request->jrAssociate as $jrAssociateId) {
                $team->users()->attach($jrAssociateId);
            }
        }
        CommonService::storeNotification("Created new team by name : $request->name", Auth::id());
    }

    public static function getUsersByProcessor($id, $teamid)
    {
        $idArray = explode(',', $id);
        $associates = [];
        foreach ($idArray as $id) {
            $team = Team::find($teamid);
            if ($teamid > 0) {
                foreach ($team->users as $user) {
                    $associate = User::find($user->pivot->associates);
                    if ($associate->id == $id) {
                        return response()->json('processorerror', 403);
                    }
                }
            }
            $admin = User::find($id);
            if ($admin) {
                if ($admin->role === 'Processor') {
                    $users = $admin->createdUsers()->where('role', 'Associate')->with('createdUsers')->get();
                } else {
                    $users = $admin->createdUsers()->where('role', 'Junior Associate')->with('createdUsers')->get();
                }
                foreach ($users as $user) {
                    $associates[] = [
                        'role' => $user->role,
                        'id' => $user->id,
                        'name' => $user->name,
                    ];
                }
            }
        }
        return $associates;
    }

    public static function shareItemWithAssistant($request)
    {
        $faker = Factory::create();
        $validator = Validator::make($request->only(['email', 'items']), [
            'email' => 'required|unique:users,email',
            'items' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()->all()]);
        }

        $user = new User();
        $user->role = 'Assistant';
        $user->active = 0;
        $user->name = $faker->name;
        $user->password = bcrypt($faker->unique()->password(8));
        $user->email = $request->email;
        $user->created_by = Auth::id();
        $user->save();

        $assitant = new Assistant;
        $assitant->assistant_id = $user->id;
        $assitant->user_id = $request->userId;
        $assitant->categories = json_encode($request->items);
        $assitant->save();
        $id = Crypt::encryptString($user->id);
        $url = function () use ($id) {return Url::signedRoute('assistant.register', ['user' => $id]);};
        Mail::to($request->email)->send(new AssistantMail($url()));
        return response()->json('sucess', 200);
    }

}
