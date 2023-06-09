<?php

namespace App\Services;

use App\Models\Info;
use App\Models\User;
use App\Models\Media;
use App\Models\Application;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserService
{

    /**
     * 
     */
    public function __construct()
    {
    }

    public static function getUserDashboard()
    {
        $data['fileCount'] = Auth::user()->media()->count();
        $data['basicInfo'] = auth()->user()->info()->exists();
        $data['report'] = Auth::user()->media()->where("category", "Credit Report")->exists();
        $data['bank'] = Auth::user()->media()->where("category", "Bank Statements")->exists();
        $data['pay'] = Auth::user()->media()->where("category", "Pay Stubs")->exists();
        $data['tax'] = Auth::user()->media()->where("category", "Tax Returns")->exists();
        $data['license'] = Auth::user()->media()->where("category", "ID/Driver's License")->exists();
        $data['_1003'] = Auth::user()->media()->where("category", "1003 Form")->exists();
        $data['statement'] = Auth::user()->media()->where("category", "Mortgage Statement")->exists();
        $data['evidence'] = Auth::user()->media()->where("category", "Evidence of Insurance")->exists();
        $data['purchaseAgreement'] = Auth::user()->media()->where("category", "Purchase Agreement")->exists();
        $data['miscellaneous'] = Auth::user()->media()->where("category", "Miscellaneous")->exists();
        $data['applicationsidebar'] = auth()->user()->application()->exists();
        return $data;
    }
    //=====================================
    //==================File related methods
    //=====================================
    //Return credit report files
    public static function creditReport()
    {


        $data['files'] = Auth::user()->media()->where("category", "Credit Report")->get();
        $data = array_merge($data, self::getUserDashboard());
        return $data;
    }
    //Return credit report files
    public static function bankStatement()
    {


        $data['files'] = Auth::user()->media()->where("category", "Bank Statements")->get();
        $data = array_merge($data, self::getUserDashboard());
        return $data;
    } //Return credit report files
    public static function payStub()
    {


        $data['files'] = Auth::user()->media()->where("category", "Pay Stubs")->get();
        $data = array_merge($data, self::getUserDashboard());
        return $data;
    } //Return credit report files
    public static function taxReturn()
    {


        $data['files'] = Auth::user()->media()->where("category", "Tax Returns")->get();
        $data = array_merge($data, self::getUserDashboard());
        return $data;
    }
    //Return license/id files
    public static function idLicense()
    {


        $data['files'] = Auth::user()->media()->where("category", "ID/Driver's License")->get();
        $data = array_merge($data, self::getUserDashboard());
        return $data;
    }
    //Return 1003 files
    public static function _1003()
    {

        $data['files'] = Auth::user()->media()->where("category", "1003 Form")->get();
        $data = array_merge($data, self::getUserDashboard());
        return $data;
    }
    //Return 1003 files
    public static function mortgageStatement()
    {


        $data['files'] = Auth::user()->media()->where("category", "Mortgage Statement")->get();
        $data = array_merge($data, self::getUserDashboard());
        return $data;
    }
    //Return 1003 files
    public static function insuranceEvidence()
    {


        $data['files'] = Auth::user()->media()->where("category", "Evidence of Insurance")->get();
        $data = array_merge($data, self::getUserDashboard());
        return $data;
    }
    //Purchase Agreement files
    public static function purchaseAgreement()
    {


        $data['files'] = Auth::user()->media()->where("category", "Purchase Agreement")->get();
        $data = array_merge($data, self::getUserDashboard());
        return $data;
    }
    //Return 1003 files
    public static function miscellaneous()
    {


        $data['files'] = Auth::user()->media()->where("category", "Miscellaneous")->get();
        $data = array_merge($data, self::getUserDashboard());
        return $data;
    }
    //Return data for view for basic info
    public static function basicInfo($request)
    {

        if (auth()->user()->info()->exists()) {
            $data['info'] = auth()->user()->info;
        } else {
            $data['info'] = new Info();
        }
        $data = array_merge($data, self::getUserDashboard());
        return $data;
    }


    public static function application($request)
    {
        if (auth()->user()->application()->exists()) {
            $data['application'] = auth()->user()->application;
        } else {
            $data['application'] = new Application();
        }
        $data = array_merge($data, self::getUserDashboard());
        return $data;
    }

    //Saves or updates data/basic info
    public static function doInfo($request)
    {
        if (auth()->user()->info()->exists()) {
            $info = auth()->user()->info;
        } else {
            $info = new Info();
        }
        //Borrower's details
        $info->b_fname = $request->b_fname;
        $info->b_lname = $request->b_lname;
        $info->b_phone = $request->b_phone;
        $info->b_email = $request->b_email;
        $info->b_address = $request->b_address;
        $info->b_suite = $request->b_suite;
        $info->b_city = $request->b_city;
        $info->b_state = $request->b_state;
        $info->b_zip = $request->b_zip;

        //Co-borrower's details
        $info->co_fname = $request->co_fname;
        $info->co_lname = $request->co_lname;
        $info->co_phone = $request->co_phone;
        $info->co_email = $request->co_email;
        $info->co_address = $request->co_address;
        $info->co_suite = $request->co_suite;
        $info->co_city = $request->co_city;
        $info->co_state = $request->co_state;
        $info->co_zip = $request->co_zip;

        //Subject property address
        $info->p_address = $request->p_address;
        $info->p_suite = $request->p_suite;
        $info->p_city = $request->p_city;
        $info->p_state = $request->p_state;
        $info->p_zip = $request->p_zip;

        //Purchase details
        if (auth()->user()->finance_type == "Purchase") {
            $info->purchase_type = $request->purchase_type;
            if ($request->company_name) {
                $info->company_name = $request->company_name;
            }
            $info->purchase_purpose = $request->purchase_purpose;
            $info->purchase_price = $request->purchase_price;
            $info->purchase_dp = $request->purchase_dp;
            $info->loan_amount = $request->loan_amount;
        }


        //Refinance details
        if (auth()->user()->finance_type == "Refinance") {
            $info->mortage1 = $request->mortage1;
            $info->interest1 = $request->interest1;
            $info->mortage2 = $request->mortage2;
            $info->interest2 = $request->interest2;
            $info->value = $request->value;
            $info->cashout = $request->cashout;
            if ($request->cashout_amount) {
                $info->cashout_amount = $request->cashout_amount;
            }
        }

        $info->user_id = auth()->id();
        if ($info->save()) {
            $data['msg_type'] = 'msg_success';
            $data['msg_value'] = 'Basic info saved.';
            return $data;
        }
        $data['msg_type'] = 'msg_error';
        $data['msg_value'] = 'Couldn\'t saved basic info.';
        return $data;
    }
    //Retrieves status of the application
    public static function applicationStatus($request)
    {
        $data['user'] = Auth::user();
        $data = array_merge($data, self::getUserDashboard());
        return $data;
    }

    //Updates category comments on a file
    public static function updateCatComments($request)
    {
        // $cat = str_replace('-','/', $cat);
        $updated = Media::where('user_id', Auth::id())
            ->where('category', $request->cat)
            ->update([
                "user_cat_comments" => $request->cat_comments
            ]);
        if ($updated) {
            return ['msg_type' => 'msg_success', 'msg_value' => 'Comments added.'];
        }
        return ['msg_type' => 'msg_error', 'msg_value' => 'Couldn\'t add comments.'];
    }
}
