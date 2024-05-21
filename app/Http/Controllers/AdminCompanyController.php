<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\User;
use Illuminate\Http\Request;

class AdminCompanyController extends Controller
{
    public function index()
    {
        $companies = Company::where('enable', true)->latest()->get();
        $trashed = Company::where('enable', false)->latest()->get();
        return view('admin.company.index', compact('companies', 'trashed'));
    }

    public function store(Request $request, $id = 0)
    {
        
        if ($id > 0) {
            $comp = Company::find($id);
            $comp->name = $request->name;
            $comp->max_users = $request->max_users ?? $comp->max_users;
            $comp->save();
        } else {
            Company::create([
                'name' => $request->name,
                'max_users' => $request->max_users ?? NULL
            ]);
        }

        return back()->with('msg_success', 'Company' . ($id > 0 ? ' updated ' : ' created ') . 'successfully');
    }
    public function destroy(Company $company)
    {
        $this->enableOrDisableUsers($company, false);
        return back()->with('msg_success', 'Company deleted successfully');
    }
    public function restore(Company $company)
    {
        $this->enableOrDisableUsers($company, true);
        return back()->with('msg_success', 'Company restored successfully');
    }
    
    public function enableOrDisableUsers($company, $active)
    {
        User::where('company_id', $company->id)->update(['active' => $active]);
        $company->update(['enable' => $active]);
    }

    public function getUsersByCompany(Company $company)
    {
        $users = $company->users()->get();
        $associates = [];
        foreach ($users as $user) {
            $associates[] = [
                'role' => $user->role,
                'name' => $user->name,
                'id' => $user->id,
            ];
        }
        return response()->json($associates, 200);
    }

    // public function permanent(Company $company)
    // {
    //     $company->forceDelete();
    //     return back()->with('msg_success', 'Company permanently deleted successfully');
    // }
}
