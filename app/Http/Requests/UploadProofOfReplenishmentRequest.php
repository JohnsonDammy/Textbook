<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Request;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;
use Symfony\Component\HttpFoundation\Response;

class UploadProofOfReplenishmentRequest extends FormRequest
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
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            "ref_number" => ['required', 'exists:collection_requests,ref_number'],
            "accept_array" => ["required"],
            "upload_proof" => ['required', 'file', 'mimes:jpg,webp,jpeg,bmp,png,gif,svg,pdf']
        ];
    }
}
