<?php

namespace App\Http\Controllers;

use App\Models\Company;
use Illuminate\Http\Request;

class CompanyController extends Controller
{
    public function index()
    {
        $companies = Company::get();
        return view('admin.company.index', compact('companies'));
    }

    public function store(Request $request,$id = 0)
    {
        if($id > 0) {
            $comp = Company::find($id);
            $comp->name = $request->name;
            $comp->save();
        }else{
            Company::create(['name' => $request->name]);
        }
        return back()->with('msg_success', 'Company'. ($id > 0 ? ' updated ' :' created ') .'successfully');
    }
    public function destroy(Company $company)
    {
        $company->delete();
        return back()->with('msg_success', 'Company deleted successfully');
    }
}
