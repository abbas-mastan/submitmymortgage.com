<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ApplicationRequest extends FormRequest
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
            'name' => 'required|min:4',
            'date' => 'required',
            'phone' => 'required|regex:/^\+1 \(\d{3}\) \d{3}-\d{4}$/',
            'email' => 'required|email',
            'property_profile' => 'required',
            'address' => 'required',
            'city' => 'required',
            'state' => 'required',
            'zip' => 'required',
            'property_value' => 'required',
            'purchase_date' => 'required',
            'purchase_value' => 'required',
            'property_type' => 'required',
            'property_type_other' => 'required_if:property_type,other',
            'property_vested' => 'required',
            'seek_loan_amount' => 'required',
            'closing_date' => 'required',
            'loan_purpose' => 'required',
            'income_type' => 'required',
            'monthly_rental_income' => 'required',
            'is_property_paid' => 'required',
            'loan_type' => 'required',
            'first_loan' => 'required',
            'first_loan_rate' => 'required',
            'first_loan_lender' => 'required',
            'second_loan' => 'required',
            'second_loan_rate' => 'required',
            'second_loan_lender' => 'required',
            'late_payments' => 'required',
            'foreclosure' => 'required',
            'liens' => 'required',
            'LTV' => 'required',
            'CLTV' => 'required',
            'employement_status' => 'required',
            'employment_other_status' => 'required_if:employement_status,other',
            'credit_score1' => 'required',
            'credit_score2' => 'required',
            'reserves' => 'required',
            'down' => 'required',
            'additional_property' => 'required',
            'goal' => 'required',
            'note' => 'required',
        ];
    }
}
