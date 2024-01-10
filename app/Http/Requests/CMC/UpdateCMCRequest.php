<?php

namespace App\Http\Requests\CMC;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Request;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;
use Symfony\Component\HttpFoundation\Response;

class UpdateCMCRequest extends FormRequest
{
    protected $connection = 'itrfurn'; // Use the 'itrfurn' database connection

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
        $id = $this->route('schoolcmc');
        if (Request::is('api/*')) {
            $id = $this->route('school_cmc');
        }
        return [
            "cmc_name" => ['required', 'unique:c_m_c_s,cmc_name,' . $id . ',id,deleted_at,NULL'],
            "district_id" => ['required', 'exists:school_districts,id']
        ];
    }
}
