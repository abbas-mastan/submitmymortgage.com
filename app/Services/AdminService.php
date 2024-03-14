<?php

namespace App\Services;

use App\Mail\AssistantMail;
use App\Mail\UserMail;
use App\Models\Assistant;
use App\Models\Attachment;
use App\Models\Company;
use App\Models\Contact;
use App\Models\Info;
use App\Models\Media;
use App\Models\Project;
use App\Models\Team;
use App\Models\User;
use App\Notifications\DealCreatedNotification;
use App\Notifications\TeamNotification;
use App\Notifications\UserCreatedNotification;
use Faker\Factory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules\Password;

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

        if ($user->role === 'Assistant') {
            $assistant = Assistant::where('assistant_id', $user->id)->first();
            if ($assistant) {
                $project = User::find($assistant->user_id);
                if ($project) {
                    $data['projectid'] = $project->project->id;
                }
            }
        }
        $data['oldteams'] = [];
        if ($user->role !== 'Assistant' || $user->role !== 'Admin' || $user->role !== 'Borrower') {
            $data['oldteams'] = $user->teams->pluck('id')->toArray();
        }

        if (Auth::user()->role === 'Super Admin') {
            $data['companies'] = Company::get();
        } elseif (Auth::user()->role === 'Admin') {
            $company = Company::find(Auth::user()->company_id);
            $data['teams'] = $company->teams;
            $data['borrowers'] = $company->users;
        } else {
            $admin = User::find(Auth::id());
            $data['teams'] = Team::where('owner_id', $admin->id)
                ->with('users.createdBy')
                ->where('disable', false)
                ->orWhereHas('users', function ($query) use ($admin) {
                    $query->where('user_id', $admin->id);
                })
                ->get();
        }

        $data['user'] = $user;
        $data["active"] = "user";
        return $data;
    }

    //Saves the record of a newly inserted user in database
    public static function doUser(Request $request, $id)
    {
        $isNewUser = ($id == -1);
        $user = $isNewUser ? new User() : User::find($id);
        self::userValidation($request, $user, $isNewUser);
        if (!$isNewUser && $user->role === 'Assistant') {
            Assistant::where('assistant_id', $user->id)->delete();
        }

        if ($isNewUser && $request->sendmail) {
            $msg = "Registered. A verification link has been sent. You need to verify your email before login. Please, check your email.";
        } elseif ($isNewUser && !$request->sendmail) {
            $msg = "User created successfully";
        } else {
            $msg = "User updated successfully";
        }

        $user->name = $request->name;
        if ($isNewUser) {
            $user->email = $request->email;
        }
        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }
        if ($isNewUser && !$request->filled('password')) {
            $user->password = 'null';
        }
        $user->role = $request->input('role', 'Borrower');
        $user->active = 1;
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

        if (Auth::check() && Auth::user()->role !== 'Super Admin') {
            $user->company_id = Auth::user()->company_id;
        } else if (Auth::check() && Auth::user()->role === 'Super Admin') {
            $user->company_id = $request->company;
        }

        $user->created_by = $user->created_by ?? optional(Auth::user())->id;
        $user->email_verified_at = !$request->sendemail ? now() : null;
        if ($user->save() && $request->sendemail) {
            if (session('role') != null && $isNewUser) {
                // Password::sendResetLink($request->only('email'));
                // Password::RESET_LINK_SENT;
                $id = Crypt::encryptString($user->id);
                DB::table('password_resets')->insert(['email' => $user->email, 'token' => Hash::make(Str::random(12)), 'created_at' => now()]);
                $url = function () use ($id) {return Url::signedRoute('user.register', ['user' => $id], now()->addMinutes(10));};
                if ($request->role === 'Borrower') {
                    Mail::to($request->email)->send(new AssistantMail($url()));
                } else {
                    Mail::to($request->email)->send(new UserMail($url()));
                }
            } else {
                $id = Crypt::encryptString($user->id);
                DB::table('password_resets')->insert(['email' => $user->email, 'token' => Hash::make(Str::random(12)), 'created_at' => now()]);
                $url = function () use ($id) {return Url::signedRoute('borrower.register', ['user' => $id], now()->addMinutes(10));};
                Mail::to($request->email)->send(new AssistantMail($url()));
                // event(new Registered($user));

            }
        }
        if (Auth::check() && $request->role !== 'Borrower' && $user->teams) {
            $user->teams()->detach();
        }

        if (Auth::check() && $request->role !== 'Borrower' && $request->team > 0) {
            foreach ($request->team as $team) {
                $team = Team::find($team);
                if (!$team->users->contains($user->id)) {
                    $team->users()->attach($user->id);
                }
            }
        }

        if ($request->role === 'Borrower' && $isNewUser) {
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
        if (auth()->check() && !isSuperAdmin()) {
            $request['company'] = auth()->user()->company_id;
        }
        if (!auth()->check()) {
            $request['id'] = $user->id;
        }

        $user = User::where('role', 'Super Admin')->first();

        $user->notify(new UserCreatedNotification(Auth::user(), $request));

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
        $user = Auth::user();
        if ($id !== -1) {
            $users = User::with('media')->where('role', 'Borrower')->where('id', $id)->get();
            $data['id'] = $id;
            $data['info'] = User::find($id)->info;
        } else {
            if ($user->role === 'Super Admin') {
                $users = User::with(['media.user'])->where('role', 'Borrower')->get();
            } elseif ($user->role === 'Admin') {
                $users = User::with(['media', 'createdBy'])
                    ->where('role', '!=', 'Admin')
                    ->where('company_id', Auth::user()->company_id)->get();

            } elseif ($user->role === 'Processor') {
                $teams = Team::where('owner_id', $user->id)
                    ->with(['users.createdBy', 'users.media'])
                    ->orWhereHas('users', function ($query) use ($user) {
                        $query->where('user_id', $user->id);
                    })
                    ->get();
                $users = collect(); // Initialize a collection to store users
                foreach ($teams as $team) {
                    $users = $users->merge($team->users); // Merge users into the collection
                }
            } else {
                $projects = Project::where('created_by', $user->id)
                    ->orWhereHas('users', function ($query) use ($user) {
                        $query->where('users.id', $user->id);
                    })
                    ->with(['users.createdBy', 'borrower.createdBy', 'users.media'])
                    ->get();
                $users = [];
                foreach ($projects as $project) {
                    $users[] = $project->borrower;
                }
            }
        }
        $filesIds = [];
        foreach ($users as $user) {
            $media = $user->media ?? [];
            foreach ($media as $m) {
                $filesIds[] = $m->id;
            }
        }
        $filesIds = array_unique($filesIds);
        $data['files'] = Media::with(['uploadedBy', 'user'])
            ->whereIn('id', $filesIds)
            ->latest()
            ->get();
        $data['filesCount'] = Media::with(['uploadedBy', 'user'])->find($filesIds)->count();
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
            ->update(["cat_comments" => $request->cat_comments]);
        if ($updated) {
            // CommonService::storeNotification("commented on $cat category", $request->user_id);
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

    public static function StoreTeam($request, $id = -1)
    {
        $teamData = $request->validate([
            'name' => 'required',
            'company' => (Auth::user()->role == 'Super Admin') ? 'sometimes:required' : '',
        ]);

        if ($id != -1) {
            $team = Team::find($id);
            if ($request->processor) {
                foreach ($request->processor as $processorId) {
                    if (!$team->users->contains($processorId)) {
                        $team->users()->attach($processorId);
                    }
                }
            }
            if ($request->associate) {
                foreach ($request->associate as $associateId) {
                    if (!$team->users->contains($associateId)) {
                        $team->users()->attach($associateId);
                    }
                }
            }
            if ($request->jrAssociate) {
                foreach ($request->jrAssociate as $id) {
                    if (!$team->users->contains($id)) {
                        $team->users()->attach($id);
                    }
                }
            }
        } else {
            $team = new Team([
                'name' => $teamData['name'],
                'company_id' => Auth::user()->role == 'Super Admin' ? $teamData['company'] : Auth::user()->company_id,
                'jrAssociateManager' => $teamData['jrAssociateManager'] ?? null,
            ]);
            $team->owner()->associate(Auth::id());
            $team->save();
            if ($request->processor) {
                foreach ($request->processor as $processorId) {
                    $team->users()->attach($processorId);
                }
            }

            // Attach associates
            if ($request->associate) {
                foreach ($request->associate as $associateId) {
                    $team->users()->attach($associateId);
                }
            }

            // Attach junior associates
            if ($request->jrAssociate) {
                foreach ($request->jrAssociate as $id) {
                    $team->users()->attach($id);
                }
            }
        }
        if (!isSuperAdmin()) {
            $request['company'] = auth()->user()->company_id;
        }

        $user = User::where('role', 'Super Admin')->first();
        $user->notify(new TeamNotification(Auth::user(), $request));
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

    public static function shareItemWithAssistant($request, $id = -1)
    {
        if ($id != -1) {
            $user = User::find($id);
            $assitant = Assistant::where('assistant_id', $user->id)->delete();
        } else {
            $user = new User();
        }
        $assitant = new Assistant;
        $admin = Auth::user();
        $user->email_verified_at = $admin->role === 'Super Admin' || $admin->role === 'Admin' ? now() : null;
        $validator = Validator::make($request->all(), [
            'email' => -1 == $id ? 'required|unique:users,email' : '',
            'items' => 'required|sometimes',
            'company' => Auth::user()->role !== 'Super Admin' && Route::current()->getName() !== 'share-items' ? '' : 'required',
            'deal' => Route::current()->getName() == 'share-items' ? 'required' : '',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()->all()]);
        }

        if ($request->deal) {
            $deal = Project::find($request->deal);
            $request->userId = $deal->borrower->id;
            $categories = array_values(array_diff(config('smm.file_category'), ['Credit Report']));
        }

        if ($request->userId && !$request->deal) {
            $request->company = User::find($request->userId)->company_id;
        }
        $faker = Factory::create();
        if ($id == -1) {
            $user->role = 'Assistant';
            $user->active = 1;
            $user->email = $request->email;
        }
        $user->name = $request->name ?? "Assistant";
        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }
        if ($id == -1 && !$request->filled('password')) {
            $user->password = Hash::make($faker->unique()->password(12));
        }
        $user->created_by = Auth::id();
        if (!$request->company && $user->company_id) {
            $user->company_id = $user->company_id;
        } else {
            $user->company_id = $request->company ?? Auth::user()->company_id;
        }
        if ($id != -1) {
            $user->update();
        } else {
            $user->save();
        }
        $routename = Route::getRoutes()->match(Request::create(url()->previous()))->getName();
        if ($request->sendemail || $routename != 'add-user') {
            $id = Crypt::encryptString($user->id);
            $url = function () use ($id) {return Url::signedRoute('assistant.register', ['user' => $id]);};
            Mail::to($request->email)->send(new AssistantMail($url()));
        }

        $assitant->user_id = $request->userId ?? $assitant->user_id;
        $assitant->categories = json_encode($request->items ?? $categories);
        $assitant->assistant_id = $user->id;
        $assitant->save();
        return response()->json('sucess', 200);
    }

    public static function storeProject(Request $request, $id)
    {
        if ($id == -1) {
            $validator = Validator::make($request->all(), [
                'borroweraddress' => 'required',
                'email' => 'required_with:sendemail|unique:users,email',
                'name' => 'required',
                'finance_type' => 'required',
                'loan_type' => 'required',
                'team' => 'required',
                'processor' => 'sometimes:required',
                'associate' => 'sometimes:required',
                'juniorAssociate' => 'sometimes:required',
            ], [
                'email.required_with' => 'This field is required',
                'borroweraddress.required' => 'This field is required',
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
        }
        if ($id == -1) {
            $faker = Factory::create();
            $team = Team::find($request->team);
            $request->merge(['email' => $request->email ?? $faker->unique()->safeEmail,
                'role' => 'Borrower',
                'company' => Auth::user()->company_id ?? $team->company_id,
            ]);
            $user = self::doUser($request, -1);
            $project = new Project();
            $project->name = $request->borroweraddress;
            $project->borrower_id = $user;
            $project->team_id = $request->team;
            $project->created_by = Auth::id();
            $project->save();
        } else {
            $project = Project::find($id);
        }

        if ($request->associate) {
            foreach ($request->associate as $associate_id) {
                if (!$project->users->contains($associate_id)) {
                    $project->users()->attach($associate_id);
                }

            }
        }
        if ($request->juniorAssociate) {
            foreach ($request->juniorAssociate as $associate_id) {
                if (!$project->users->contains($associate_id)) {
                    $project->users()->attach($associate_id);
                }

            }
        }
        if ($request->processor) {
            foreach ($request->processor as $associate_id) {
                if (!$project->users->contains($associate_id)) {
                    $project->users()->attach($associate_id);
                }
            }
        }
        if ($id != -1) {
            $message = "Updated Deal by name : $project->name";
        } else {
            $message = "Created new Deal by name : $project->name";
        }
        $admin = User::where('role', 'Super Admin')->first();
        $user = User::find(Auth::id());
        $request['id'] = $project->id;
        $admin->notify(new DealCreatedNotification($user, $request));
        return response()->json('success', 200);

    }

    private static function userValidation($request, $user, $isNewUser)
    {
        if (!$request->ajax()) {
            $request->validate([
                'email' => "sometimes:required|email|unique:users,email," . $user->id,
                'name' => "required",
                'company' => (Auth::check() && Auth::user()->role == 'Super Admin') ? 'required' : '',
                'sendemail' => '',
                'password' => ($isNewUser && !$request->sendemail) || !Auth::check() ? ['required', Password::min(12)
                        ->mixedCase()
                        ->letters()
                        ->numbers()
                        ->symbols()
                        ->uncompromised(), 'confirmed'] : '',
                'role' =>
                #This is the custom Rule. Less than Admin Role Can't add User with the role === admin OR Processor
                function ($attribute, $value, $fail) {
                    self::validateCurrentUser($attribute, $value, $fail);
                },
            ], [
                'password.required' => 'The password field is required.',
                'password.confirmed' => 'The password confirmation does not match.',
                'password.*' => 'The password must be at least 12 characters long and contain a mix of uppercase and lowercase letters, numbers, and symbols.',
            ]);
        }
    }

}
