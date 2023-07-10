<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
use Illuminate\Http\Request;
use App\Services\UserService;
use Illuminate\Support\Facades\{Gate, Auth};

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
        $data = match (true) {
            Gate::allows('isAdmin') => $this->getAdminDashboard(),
            Gate::allows('isUser') => $this->getUserDashboard(),
            Gate::allows('isAssociate') => $this->getAssociateDashboard(),
            default => []
        };
        $data["authUrl"] = $this->client->createAuthUrl();
        $data["active"] = "dashboard";
        $data['carbon'] = Carbon::class;
        return view('dashboard', $data);
    }

    private function getAdminDashboard()
    {
        if(session('role') == 'Admin'){
            $data['users'] = User::whereNotIn("role", ["Admin"])->get();
            $data['usersCount'] = User::whereNotIn("role", ["Admin"])->count();
        }else{
            $user = Auth::user();
            $data['usersCount'] = $user->createdUsers()->whereIn('role', ['Processor', 'Associate', 'Junior Associate', 'Borrower'])->with('createdUsers')->count();
            $data['users'] = $user->createdUsers()->whereIn('role', ['Processor', 'Associate', 'Junior Associate', 'Borrower'])->with('createdUsers')->get();
        }
        return $data;
    }

    private function getAssociateDashboard()
    {
        $user = Auth::user(); // Assuming you have authenticated the admin
        // $data['usersCount'] = User::where("role", "Borrower")->count();
        // $data['users'] = User::where('role', 'Borrower')->get();
        $data['usersCount'] = $user->createdUsers()->whereIn('role', ['Processor', 'Associate', 'Junior Associate', 'Borrower'])->with('createdUsers')->count();
        $data['users'] = $user->createdUsers()->whereIn('role', ['Processor', 'Associate', 'Junior Associate', 'Borrower'])->with('createdUsers')->get();

        return $data;
    }

    private function getUserDashboard()
    {
        return UserService::getUserDashboard();
    }
}
