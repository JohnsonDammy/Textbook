<?php

namespace App\Http\Requests\FurnitureCollection;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Request;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;
use Symfony\Component\HttpFoundation\Response;

class UpdateFurnitureCollection extends FormRequest
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
            'total_furniture' => ['required', 'numeric'],
            'total_furniture' => ['numeric', 'gt:0'],
            'broken_items' => ['required', 'array','min:1'],
            "broken_items.*.id" => ['required'],
            "broken_items.*.category_id" => ['required', 'exists:stock_categories,id'],
            "broken_items.*.item_id" => ['required', 'exists:stock_items,id'],
            "broken_items.*.count" => ['required', 'numeric'],
            "broken_items.*.item_full_count" => ["required", "numeric"]
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
            'total_furniture.required' => "Total furniture count is required",
            'total_furniture.gt' => "Total furniture count should be greater than zero",
            'total_furniture.numeric' => "Total furniture count only allows numbers",
            "broken_items.*.category_id.required" => "Broken items category is required",
            "broken_items.*.category_id.exists" => "Broken items category does not exists",
            "broken_items.*.item_id.required" => "Broken item is required",
            "broken_items.*.item_id.exists" => "Broken item does not exists",
            "broken_items.*.count.required" => "Broken items count is required",
            "broken_items.*.count.numeric" => "Broken items only allows numbers",
        ];
    }
}
