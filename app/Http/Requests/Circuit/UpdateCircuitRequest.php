<?php

namespace App\Http\Requests\Circuit;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Request;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;
use Symfony\Component\HttpFoundation\Response;

class UpdateCircuitRequest extends FormRequest
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
        $id = $this->route('schoolcircuit');
        if (Request::is('api/*')) {
            $id = $this->route('school_circuit');
        }
        return [
            "circuit_name" => ['required', 'unique:circuits,circuit_name,' . $id . ',id,deleted_at,NULL'],
            "cmc_id" => ['required', 'exists:c_m_c_s,id']
        ];
    }
}
