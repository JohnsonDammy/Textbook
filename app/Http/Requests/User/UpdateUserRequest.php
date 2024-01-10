<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Request;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;
use Symfony\Component\HttpFoundation\Response;

class UpdateUserRequest extends FormRequest
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
        $id = $this->route('user');
        if (Request::capture()->is('api/*')) {
            $id = $this->route('manage');
        }
        return [
            'organization' => 'required',
            'name' => 'required|regex:/^[a-zA-Z0-9 ]+$/u',
            'emis' => 'required_if:organization,2|exists:schools,emis|unique:users,username,' . $id . ',id,deleted_at,NULL',
            'surname' => 'required_if:organization,1|required_if:organization,3|regex:/^[a-zA-Z0-9 ]+$/u',
            'email' => 'required|email|unique:users,email,' . $id . ',id,deleted_at,NULL',
            'permission' => 'required'
        ];
    }

    public function messages()
    {
        return [
            'organization.required' => "Select an Organization",
            'name.required' => "Enter Name",
            'surname.required' => "Enter Surname",
            'emis.unique' => "The EMIS No. already exists",
            'emis.required_if' => 'The EMIS No. is required when organization is School',
            'email.required' => "Enter Email",
            'permission.required' => "Select atleast one functionality"
        ];
    }

    public function failedValidation(Validator $validator)
    {
        if (Request::capture()->is('api/*')) {
            throw new HttpResponseException(response()->json([
                'message' => 'Validation error',
                'data' => $validator->errors(),
                'status' => 422
            ], Response::HTTP_UNPROCESSABLE_ENTITY));
        }
    }
}
