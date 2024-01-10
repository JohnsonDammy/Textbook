<?php

namespace App\Http\Requests\District;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Request;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;
use Symfony\Component\HttpFoundation\Response;

class UpdateDistrictRequest extends FormRequest
{
    protected $connection = 'itrfurns'; // Use the 'itrfurn' database connection

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
        $id = $this->route('schooldistrict');
        if (Request::capture()->is('api/*')) {
            $id = $this->route('school_district');
        }
        return  [
            'district_office' => ['required', 'regex:/^[a-zA-Z0-9 ]+$/u','unique:school_districts,district_office,' . $id . ',id,deleted_at,NULL']
            // 'director' => ['nullable', 'string'],
            // 'tel' => ['nullable', 'digits:10', 'integer'],
            // 'address1' => ['nullable', 'string'],
            // 'address2' => ['nullable', 'string'],
            // 'address3' => ['nullable', 'string'],
            // 'address4' => ['nullable', 'string'],
            // 'street_code' => ['nullable', 'digits:4', 'integer']
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
            'district_office.required' => "District is required",
            'district_office.unique' => "District already exists"
            // 'street_code.integer' => "Street code only allows numbers",
            // 'street_code.digits' => "Street code should be 4 digits only",
            // 'tel.integer' => "Tel. number only allows numbers",
            // 'tel.digits' => "Tel. number should be 10 digits only",
        ];
    }
}
