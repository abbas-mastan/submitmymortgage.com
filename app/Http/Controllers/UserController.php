<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\View\View;
use App\Models\IntakeForm;
use Illuminate\Http\Request;
use App\Services\UserService;
use App\Services\CommonService;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\IntakeFormRequest;
use App\Http\Requests\ApplicationRequest;

class UserController extends Controller
{
    //=====================================
    //==================File related methods
    //=====================================
    //Processing file upload
    public function fileUpload(Request $request)
    {
        return CommonService::fileUpload($request);
    }
    //
    //Showing input for creating/updating a course item
    //Showing input for profile
    public function creditReport(Request $request)
    {
        $data = UserService::creditReport($request);
        return view('user.files.credit-report', $data);
    }
    public function bankStatement(Request $request)
    {

        $data = UserService::bankStatement($request);
        return view('user.files.bank-statement', $data);
    }
    public function payStub(Request $request)
    {

        $data = UserService::payStub($request);
        return view('user.files.pay-stub', $data);
    }
    public function taxReturn(Request $request)
    {

        $data = UserService::taxReturn($request);
        return view('user.files.tax-return', $data);
    }
    public function idLicense(Request $request)
    {

        $data = UserService::idLicense($request);
        return view('user.files.id-license', $data);
    }
    public function _1003(Request $request)
    {
        $data = UserService::_1003($request);
        return view('user.files.1003', $data);
    }
    public function mortgageStatement(Request $request)
    {
        $data = UserService::mortgageStatement($request);
        return view('user.files.mortgage-statement', $data);
    }

    public function insuranceEvidence(Request $request)
    {
        $data = UserService::insuranceEvidence($request);
        return view('user.files.insurance-evidence', $data);
    }
    public function purchaseAgreement(Request $request)
    {
        $data = UserService::purchaseAgreement($request);
        return view('user.files.purchase-agreement', $data);
    }

    public function miscellaneous(Request $request)
    {
        $data = UserService::miscellaneous($request);
        return view('user.files.miscellaneous', $data);
    }
    public function basicInfo(Request $request)
    {
        $data = UserService::basicInfo($request);
        return view('user.info.basic-info', $data);
    }
    public function doInfo(Request $request)
    {
        $this->validateFunction($request);
        $data = UserService::doInfo($request);
        return redirect('/dashboard')->with($data['msg_type'], $data['msg_value']); //view('user.info.basic-info',$data);
    }
    //Retrieves information abou the application and shows it to the user
    public function applicationStatus(Request $request)
    {
        $data = UserService::applicationStatus($request);
        return view('user.files.application-status', $data);
    }
    //=====================================
    //==================Profile related methods
    //=====================================
    //Showing input for profile
    public function profile(Request $request)
    {
        $data[''] = '';
        $data = array_merge($data, UserService::getUserDashboard());
        return view('admin.profile.profile', $data);
    }
    //Updates profile data and picture

    public function doProfile(Request $request)
    {
        $msg = CommonService::doProfile($request);
        return redirect("/dashboard")->with($msg['msg_type'], $msg['msg_value']);
    }
    //Updates the category comments of a file category
    public function updateCatComments(Request $request)
    {
        $msg = UserService::updateCatComments($request);
        return back()->with($msg['msg_type'], $msg['msg_value']);
    }

    public function application(Request $request)
    {
        // dd(auth()->id());
        $data['intake'] = IntakeForm::where('user_id',auth()->id())->first();
        $data['enableTeams'] = [];
        return view('admin.intakes.show',$data);
        // return view('user.loan.application', $data);
    }

    public function doApplication(ApplicationRequest $request)
    {
        $data = CommonService::doApplication($request);
        return redirect('/dashboard')->with($data['msg_type'], $data['msg_value']);
    }

    public function category($cat)
    {
        $data = UserService::category();
        $data['cat'] = str_replace('-', ' ', $cat);
        return view('user.files.single-cat', $data);
    }

    #disconnect from google
    public function disconnectGoogle(Request $request)
    {
        User::where('id', Auth::id())->update(array('accessToken' => null));
        return redirect('/dashboard')->with("msg_success", "Google Disconnected Successfully.");
    }

    public function redirectTo($route, $message)
    {
        return CommonService::redirectTo($route, $message);
    }

    private function validateFunction($request)
    {
        return $request->validate([
            'b_fname' => 'required',
            'b_lname' => 'required',
            'b_phone' => 'required|regex:/^\+1 \(\d{3}\) \d{3}-\d{4}$/',
            'b_email' => 'required',
            'b_address' => 'required',
            'b_suite' => '',
            'b_city' => 'required',
            'b_state' => 'required',
            'b_zip' => 'required',
            // co borrwowers details
            'co_fname' => 'required',
            'co_lname' => 'required',
            'co_phone' => 'required|regex:/^\+1 \(\d{3}\) \d{3}-\d{4}$/',
            'co_email' => 'required',
            'co_address' => 'required',
            'co_suite' => '',
            'co_city' => 'required',
            'co_state' => 'required',
            'co_zip' => 'required',
            'p_address' => 'required',
            'p_suite' => 'required',
            'p_city' => 'required',
            'p_state' => 'required',
            'p_zip' => 'required',
        ], [
            'b_email.required' => 'The borrower email is required.',
            'b_address.required' => 'The borrower address is required.',
            'co_email.required' => 'The co-borrower email is required.',
            'b_phone.required' => 'The borrower phone is required.',
            'co_phone.required' => 'The co-borrower phone is required.',
            'b_phone.regex' => 'The borrower phone number format is invalid.',
            'co_phone.regex' => 'The co-borrower phone number format is invalid.',
        ]);
    }

    public function submitIntakeForm(IntakeFormRequest $request)
    {
        return CommonService::submitIntakeForm($request);
    }

}
