<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProjectRequest extends FormRequest
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
            'borroweraddress' => 'required',
            'email' => 'required_with:sendemail|unique:users,email',
            'name' => 'required',
            'borroweraddress' => 'required',
            'financetype' => 'required',
            'loantype' => 'required',
            'team' => 'required',
            'processor' => 'sometimes:required',
            'associate' => 'required',
            'juniorAssociate' => 'sometimes:required',
        ];
    }
}
