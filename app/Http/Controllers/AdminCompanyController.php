<?php

namespace App\Http\Controllers;

use App\Models\Company;
use Illuminate\Http\Request;

class AdminCompanyController extends Controller
{
    public function index()
    {
        $companies = Company::get();
        $trashed = Company::onlyTrashed()->get();
        return view('admin.company.index', compact('companies','trashed'));
    }

    public function store(Request $request,$id = 0)
    {
        if($id > 0) {
            $comp = Company::find($id);
            $comp->name = $request->name;
            $comp->save();
        } 
        else Company::create(['name' => $request->name]);

        return back()->with('msg_success', 'Company'. ($id > 0 ? ' updated ' :' created ') .'successfully');
    }
    public function restore(Company $company)
    {
        $company->restore();
        return back()->with('msg_success', 'Company restored successfully');
    }
    public function permanent(Company $company)
    {
        $company->forceDelete();
        return back()->with('msg_success', 'Company permanently deleted successfully');
    }
    public function destroy(Company $company)
    {
        $company->delete();
        return back()->with('msg_success', 'Company deleted successfully');
    }
}
