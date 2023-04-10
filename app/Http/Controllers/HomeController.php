<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Services\UserService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Carbon\Carbon;

class HomeController extends Controller
{

    private $client;

    public function __construct()
    {
        $this->client = new \Google\Client();
        $this->client->setAuthConfig('client.json');
        $this->client->addScope(\Google_Service_Gmail::GMAIL_READONLY);
    }
    
    //
    public function index(Request $request) {
        $data['landingPage'] = true;
        return view('home',$data);
    }
    public function dashboard(Request $request) {
         if(Gate::allows('isAdmin'))
         {
             $data = $this->getAdminDashboard();
         }
         if(Gate::allows('isUser'))
         {
             $data = $this->getUserDashboard();
         }
         $data["authUrl"] = $this->client->createAuthUrl(); 
         $data["active"] = "dashboard";
         $data['carbon'] = Carbon::class;
        return view('dashboard',$data);
    }
   
    private function getAdminDashboard() {
        $data['usersCount'] = User::where("role","user")->count();
        $data['users'] = User::where("role","user")->get();
        return $data;
    }
    private function getUserDashboard() {
        
        return UserService::getUserDashboard();
    }
    
    
}
