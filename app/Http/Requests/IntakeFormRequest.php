<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class IntakeFormRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
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
            'email' => 'required|unique:users,email',
            'first_name' => 'required',
            'last_name' => 'required',
            'address' => 'required',
            'phone' => 'required',
            'note' => 'required',
            'purchase_price' => 'required_if:loan_type,Purchase',
            'property_value' => 'required_if:loan_type,Purchase',
            'down_payment' => 'required_if:loan_type,Purchase',
            'current_loan_amount_purchase' => 'required_if:loan_type,Purchase',
            'closing_date' => 'required_if:loan_type,Purchase',
            'current_loan_amount_cashout' => 'required_if:loan_type,Cash Out',
            'cashout_amount' => 'required_if:loan_type,Cash Out',
            'current_lender_cashout' => 'required_if:loan_type,Cash Out',
            'is_it_rental_property' => 'required_if:loan_type,Cash Out',
            'monthly_rental_income' => 'required_if:is_it_rental_property,Yes',
            'purchase_price_fix_flip' => 'required_if:loan_type,Fix & Flip',
            'property_value_fix_flip' => 'required_if:loan_type,Fix & Flip',
            'down_payment_fix_flip' => 'required_if:loan_type,Fix & Flip',
            'closing_date_fix_flip' => 'required_if:loan_type,Fix & Flip',
            'is_repair_finance_needed' => 'required_if:loan_type,Fix & Flip',
            'repair_finance_amount' => 'required_if:is_repair_finance_needed,Yes',
            'current_loan_amount_refinance' => 'required_if:loan_type,Refinance',
            'current_lender_refinance' => 'required_if:loan_type,Refinance',
            'rate_refinance' => 'required_if:loan_type,Refinance',
            'is_it_rental_property_refinance' => 'required_if:loan_type,Refinance',
            'monthly_rental_income_refinance' => 'required_if:is_it_rental_property_refinance,Yes',

        ];
    }

    public function messages(): array
    {
        return [
            'purchase_price_fix_flip.required_if' => 'This Field Is Required.',
            'property_value_fix_flip.required_if' => 'This Field Is Required.',
            'down_payment_fix_flip.required_if' => 'This Field Is Required.',
            'closing_date_fix_flip.required_if' => 'This Field Is Required.',
            'repair_finance_amount.required_if' => 'This Field Is Required When Is Repair Finance Needed Is Yes.',
            'current_loan_amount_refinance.required_if' => 'This Field Is Required.',
            'current_lender_refinance.required_if' => 'This Field Is Required.',
            'closing_date.required_if' => 'This Field Is Required.',
            'down_payment.required_if' => 'This Field Is Required.',
            'property_value.required_if' => 'This Field Is Required.',
            'purchase_price.required_if' => 'This Field Is Required.',
            'current_loan_amount_purchase.required_if' => 'This Field Is Required.',
            'cashout_amount.required_if' => 'This Field Is Required.',
            'current_lender_cashout.required_if' => 'This Field Is Required.',
            'current_loan_amount_cashout.required_if' => 'This Field Is Required.',
            'rate_refinance.required_if' => 'This Field Is Required.',
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
