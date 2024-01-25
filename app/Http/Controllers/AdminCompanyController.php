<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Company;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminCompanyController extends Controller
{
    public function index()
    {
        $companies = DB::table('companies')
        ->where('enable', true)
        ->orderBy('created_at', 'desc') // Assuming you want to order by created_at
        ->get();
    
    $trashed = DB::table('companies')
        ->where('enable', false)
        ->orderBy('created_at', 'desc') // Assuming you want to order by created_at
        ->get();
    
        return view('admin.company.index', compact('companies', 'trashed'));
    }

    public function store(Request $request, $id = 0)
    {
        if ($id > 0) {
            $comp = Company::find($id);
            $comp->name = $request->name;
            $comp->save();
        } else {
            Company::create(['name' => $request->name]);
        }

        return back()->with('msg_success', 'Company' . ($id > 0 ? ' updated ' : ' created ') . 'successfully');
    }
    public function destroy(Company $company)
    {
        $this->disableUsers($company->id, false);
        $company->update(['enable' => false]);
        return back()->with('msg_success', 'Company deleted successfully');
    }
    public function restore(Company $company)
    {
        $this->disableUsers($company->id, true);
        $company->update(['enable' => true]);
        return back()->with('msg_success', 'Company restored successfully');
    }

    private function disableUsers($company_id, $active)
    {
        User::where('company_id', $company_id)->update(['active' => $active]);
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
