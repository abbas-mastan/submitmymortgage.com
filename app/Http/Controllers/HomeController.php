<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Team;
use App\Models\User;
use App\Models\Media;
use App\Models\Project;
use App\Models\IntakeForm;
use Illuminate\Http\Request;
use App\Services\UserService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class HomeController extends Controller
{
    private $client;
    public function __construct()
    {
        $this->client = new \Google\Client();
        $this->client->setAuthConfig('client.json');
        $this->client->addScope(\Google_Service_Gmail::GMAIL_READONLY);
    }

    public function index(Request $request)
    {
        $data['landingPage'] = true;
        return view('home', $data);
    }
    public function dashboard(Request $request)
    {
        if(Gate::allows('isAssistant')) return redirect(getRoutePrefix().'/submit-document');
        
        $data = match (true) {
            Gate::allows('isSuperAdmin') => $this->getSuperAdminDashboard(),
            Gate::allows('isAdmin') => $this->getAdminDashboard(),
            Gate::allows('isUser') => $this->getUserDashboard(),
            Gate::allows('isAssociate') => $this->getAssociateDashboard(),
            default => []
        };
        
        $data['intake'] = new IntakeForm();
        $data["authUrl"] = $this->client->createAuthUrl();
        $data["active"] = "dashboard";
        $data['carbon'] = Carbon::class;
        return view('dashboard', $data);
    }

    private function getSuperAdminDashboard()
    {
        if (session('role') == 'Super Admin') {
            $data['users'] = User::whereNotIn("role", ["Admin","Super Admin"])->get();
            $data['usersCount'] = User::whereNotIn("role", ["Admin","Super Admin"])->count();
            $data['teams'] = Team::where('disable', false)->get();
            $data['projects'] = Project::where('status', 'enable')->get();
            $data['closedProjects'] = Project::where('status', 'close')->get();
        }
        return $data;
    }
    private function getAdminDashboard()
    {
        $data['teams'] = Team::whereHas('users', function ($query) {
            $query->where('user_id', Auth::id());
        })->get();
        $user = Auth::user();
        $data['usersCount'] = $user->createdUsers()->whereIn('role', ['Processor', 'Associate', 'Junior Associate', 'Borrower'])->with('createdUsers')->count();
        $data['users'] = $user->createdUsers()->whereIn('role', ['Processor', 'Associate', 'Junior Associate', 'Borrower'])->with('createdUsers')->get();
        $data['projects'] = Project::where('created_by', $user->id)
            ->orWhereHas('users', function ($query) use ($user) {
                $query->where('users.id', $user->id);
            })->get();
        $data['closedProjects'] = Project::where('status','close')->whereHas('users', function ($query) use ($user) {
            $query->where('user_id', $user->id);
        })->get();
        return $data;
    }

    private function getAssociateDashboard()
    {
        $user = Auth::user(); // Assuming you have authenticated the admin
        $data['teams'] = Team::whereHas('users', function ($query) use ($user) {
            $query->where('user_id', $user->id);   
        })->get();
        $data['usersCount'] = $user->createdUsers()->whereIn('role', ['Processor', 'Associate', 'Junior Associate', 'Borrower'])->with('createdUsers')->count();
        $data['users'] = $user->createdUsers()->whereIn('role', ['Processor', 'Associate', 'Junior Associate', 'Borrower'])->with('createdUsers')->get();
        $data['projects'] = Project::where('created_by', $user->id)
        ->orWhereHas('users', function ($query) use ($user) {
            $query->where('users.id', $user->id);
        })
        ->get();
        $data['closedProjects'] = Project::where('status','close')->whereHas('users', function ($query) use ($user) {
            $query->where('user_id', $user->id);
        })->get();
        return $data;
    }

    private function getUserDashboard()
    {
        return UserService::getUserDashboard();
    }

    public function showDocx(Media $media)
    {
       $path = url($media->file_path);
       return view('show-docx',compact('path'));
    }
}
