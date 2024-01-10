<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Request;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;
use Symfony\Component\HttpFoundation\Response;

class CollectionRequestSearch extends FormRequest
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
            'start_date' => 'required_with:end_date'
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
    public function messages()
    {
        return [
            'start_date.required_with' => "Start date is required",
        ];
    }

}
