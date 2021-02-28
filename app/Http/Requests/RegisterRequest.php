<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class RegisterRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'app_id' => ['required','numeric',Rule::exists('apps','id')->where('status',1)],
            'u_id'   => ['required','max:100'],
            'os'     => ['required','max:10',Rule::in(config('masm.allowOperationSystem'))],
            'lang'   => ['required','max:10',Rule::in(config('masm.allowLanguages'))]
        ];
    }

    public function attributes()
    {
        return [
            'app_id' => '"'.__('app.app_id').'"',
            'u_id'   => '"'.__('app.u_id').'"',
            'os'     => '"'.__('app.os').'"',
            'lang'   => '"'.__('app.lang').'"',
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
