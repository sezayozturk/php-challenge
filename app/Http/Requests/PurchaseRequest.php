<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class PurchaseRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'client_token' => ['required',Rule::exists('devices','client_token')],
            'receipt'      => ['required','numeric','digits_between:20,100']
        ];
    }

    public function attributes()
    {
        return [
            'client_token' => '"'.__('app.client_token').'"',
            'receipt'      => '"'.__('app.receipt').'"',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        $errors = (new ValidationException($validator))->errors();

        throw new HttpResponseException(
            response()->json([
                'status'   => 'error',
                'messages' => $errors
            ],412)
        );
    }
}
