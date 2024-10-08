<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Symfony\Component\HttpFoundation\Response;

class StoreInventoryRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'partNumber' => ['required', 'string', 'max:70', 'exists:part,num'],
            'partDescription' => ['nullable', 'string', 'max:252',],
            'location' => ['required', 'string', 'exists:location,name'],
            'qty' => ['required', 'numeric'],
            'uom' => ['required', 'string', 'exists:uom,name'],
            'cost' => ['required', 'numeric', 'max:9999999999'],
            'qbClass' => ['nullable', 'string', 'exists:qbclass,name'],
            'date' => ['nullable', 'date'],
            'note' => ['nullable', 'string'],
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json(
            [
                'success' => false,
                'message' => 'Validation errors',
                'data' => $validator->errors()
            ],
            Response::HTTP_UNPROCESSABLE_ENTITY
        ));
    }
}
