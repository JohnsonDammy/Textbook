<?php

namespace App\Http\Requests\FurnitureCollection;

use App\Models\BrokenItem;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Request;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;
use Symfony\Component\HttpFoundation\Response;

class StoreCollectionItems extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public $validator = null;
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
            'ref_number' => ['required', 'exists:collection_requests,ref_number'],
            'confirm_count' => [
                'required', 'array',
                function ($attribute, $value, $fail) {
                    // index arr
                    $ids = array_keys($value);
                    // query to check if array keys is not valid
                    $stockCntWithinArrIDs = BrokenItem::whereIn('id', $ids)->count();
                    if ($stockCntWithinArrIDs != count($ids))
                        return $fail($attribute . " broken item id is invalid.");  // -> "quantity is invalid"
                }
            ],
            'confirm_count.*' => ['required'],
            'images' => ['required', 'array'],
            'images.*' => ['image'],

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
        $this->validator = $validator;
        // dd($validator->errors());

    }

    public function messages()
    {
        return [
            'confirm_count.*.required' => "Confirmed count is required",
            'confirm_count.*.numeric' => "Confirmed count only allows numbers",
            'images.required' => 'Photos are required',
            'images.*.mimes' => 'Photos only allows jpg, jpeg, png, bmp extensions.'
        ];
    }
}
