<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CertificatePostRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'first_name' => 'required|max:255',
            'last_name' => 'required|max:255',
            'email' => 'email:rfc,dns|required|max:100',
            'plantation_id' => 'required|numeric',
            'total' => 'required|numeric',
            'amount' => 'required|numeric',
            'payment_option_id' => 'required|numeric',
            'currency_id' => 'required|numeric',
        ];
    }
}
