<?php

namespace App\Http\Requests\School;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Request;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;
use Symfony\Component\HttpFoundation\Response;

class UpdateSchoolRequest extends FormRequest
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
        $id = $this->route('school');
        return [
            'name' => ['required', 'regex:/^[a-zA-Z0-9 ]+$/u'],
            'emis' => ['required', 'integer', 'digits:9', 'unique:schools,emis,' . $id . ',id,deleted_at,NULL'],
            'district_id' => ['required', 'integer', 'exists:school_districts,id'],
            'cmc_id' => ['required', 'integer', 'exists:c_m_c_s,id'],
            'circuit_id' => ['required', 'integer', 'exists:circuits,id'],
            'subplace_id' => ['required', 'integer', 'exists:subplaces,id'],
            'snq_id' => ['required', 'integer', 'exists:school_snqs,id'],
            'level_id' => ['required', 'integer', 'exists:school_levels,id'],
            'school_principal' => ['string', 'nullable'],
            'tel' => ['regex:/^[0-9]+$/u', 'digits:10', 'nullable'],
            'street_code' => ['integer', 'digits:4', 'nullable']
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
            'name.required' => "School name is required",
            'name.regex' => "School name allows only numbers and alphabets",
            'emis.required' => "School EMIS number is required",
            'emis.digits' => "School EMIS number should be 9 character",
            'emis.unique' => "School with same EMIS number already exists",
            'emis.integer' => "EMIS number only allows numbers.",
            'street_code.integer' => "Street code only allows numbers.",
            'street_code.digits' => "Street code number should be 4 digits.",
            'tel.regex' => "Telephone number only allows numbers.",
            'tel.digits' => "Telephone number should be 10 digits.",
            'district_id.required' => "School district is required",
        ];
    }
}
