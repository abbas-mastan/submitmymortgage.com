<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class IntakeFormRequest extends FormRequest
{
    protected $msg = "This field is required.";
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'company' => auth()->user()->role === 'Super Admin' && $this->input('user_id') < 1 ? 'required' : '',
            'team' => $this->input('user_id') > 0 ? '' : 'required',
            'email' => $this->input('user_id') > 0 ? '' : 'required|unique:users,email',
            'first_name' => 'required',
            'last_name' => 'required',
            'address' => 'required',
            'loan_type' => 'required',
            'property_type' => 'required',
            'property_profile' => 'required',
            'borrower_credit_score' => 'required',
            'borrower_employment' => 'required',
            'borrower_yearly_income' => 'required',
            'is_there_co_borrower' => 'required',
            'co_borrower_yearly_income' => 'required_if:is_there_co_borrower,Yes',
            'co_borrower_first_name' => 'required_if:is_there_co_borrower,Yes',
            'co_borrower_last_name' => 'required_if:is_there_co_borrower,Yes',
            'co_borrower_email' => 'required_if:is_there_co_borrower,Yes',
            'co_borrower_phone' => ['required_if:is_there_co_borrower,Yes',
                function ($attribute, $value, $fail) {
                    if ($this->input('is_there_co_borrower') === 'Yes' && !$value) {
                        $fail($this->msg);
                    }
                    if ($this->input('is_there_co_borrower') === 'Yes' && $value && !preg_match('/^\+1 \(\d{3}\) \d{3}-\d{4}$/', $value)) {
                        $fail('The phone number format is invalid.');
                    }
                }],
            'co_borrower_employment' => 'required_if:is_there_co_borrower,Yes',
            'co_borrower_credit_score' => 'required_if:is_there_co_borrower,Yes',
            'phone' => 'required|regex:/^\+1 \(\d{3}\) \d{3}-\d{4}$/',
            'note' => 'required',
            'finance_type' => 'required',
            'purchase_price' => 'required_if:finance_type,Purchase',
            'down_payment' => 'required_if:finance_type,Purchase',
            'current_loan_amount_purchase' => 'required_if:finance_type,Purchase',
            'closing_date_purchase' => 'required_if:finance_type,Purchase',
            'property_value_cashout' => 'required_if:finance_type,Cash Out',
            'current_loan_amount_cashout' => 'required_if:finance_type,Cash Out',
            'cashout_amount' => 'required_if:finance_type,Cash Out',
            'current_lender_cashout' => 'required_if:finance_type,Cash Out',
            'is_it_rental_property' => 'required_if:finance_type,Cash Out',
            'monthly_rental_income' => [
                function ($attribute, $value, $fail) {
                    if ($this->finance_type === 'Cash Out' && $this->is_it_rental_property === 'Yes' && empty($value)) {
                        $fail($this->msg);
                    }
                },
            ],
            'purchase_price_fix_flip' => 'required_if:finance_type,Fix & Flip',
            'property_value_fix_flip' => 'required_if:finance_type,Fix & Flip',
            'down_payment_fix_flip' => 'required_if:finance_type,Fix & Flip',
            'closing_date_fix_flip' => 'required_if:finance_type,Fix & Flip',
            'is_repair_finance_needed' => 'required_if:finance_type,Fix & Flip',
            'repair_finance_amount' => [
                function ($attribute, $value, $fail) {
                    if ($this->finance_type === 'Fix & Flip' && $this->is_repair_finance_needed === 'Yes' && empty($value)) {
                        $fail($this->msg);
                    }
                },
            ],
            'property_value_refinance' => 'required_if:finance_type,Refinance',
            'current_loan_amount_refinance' => 'required_if:finance_type,Refinance',
            'current_lender_refinance' => 'required_if:finance_type,Refinance',
            'rate_refinance' => 'required_if:finance_type,Refinance',
            'is_it_rental_property_refinance' => 'required_if:finance_type,Refinance',
            'monthly_rental_income_refinance' => [
                function ($attribute, $value, $fail) {
                    if ($this->finance_type === 'Refinance' && $this->is_it_rental_property_refinance === 'Yes' && empty($value)) {
                        $fail($this->msg);
                    }
                },
            ],
        ];
    }

    public function messages(): array
    {
        $msg = $this->msg;
        return [
            'purchase_price_fix_flip.required_if' => $msg,
            'is_there_co_borrower.required' => $msg,
            'loan_type.required' => $msg,
            'property_profile.required' => $msg,
            'property_type.required' => $msg,
            'co_borrower_yearly_income.required_if' => $msg,
            'co_borrower_credit_score.required_if' => $msg,
            'co_borrower_employment.required_if' => $msg,
            'co_borrower_phone.required_if' => $msg,
            'co_borrower_email.required_if' => $msg,
            'co_borrower_first_name.required_if' => $msg,
            'co_borrower_last_name.required_if' => $msg,
            'property_value_fix_flip.required_if' => $msg,
            'down_payment_fix_flip.required_if' => $msg,
            'closing_date_fix_flip.required_if' => $msg,
            'repair_finance_amount.required_if' => 'This Field Is Required When Is Repair Finance Needed Is Yes.',
            'current_loan_amount_purchase.required_if' => $msg,
            'current_loan_amount_refinance.required_if' => $msg,
            'current_lender_refinance.required_if' => $msg,
            'closing_date_purchase.required_if' => $msg,
            'down_payment.required_if' => $msg,
            'property_value.required_if' => $msg,
            'purchase_price.required_if' => $msg,
            'current_loan_amount_cashout.required_if' => $msg,
            'cashout_amount.required_if' => $msg,
            'current_lender_cashout.required_if' => $msg,
            'current_loan_amount.required_if' => $msg,
            'rate_refinance.required_if' => $msg,
        ];
    }

    protected function failedValidation(Validator $validator)
    {
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

        throw new HttpResponseException(response()->json($response));
    }

}
