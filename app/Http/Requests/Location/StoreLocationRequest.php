<?php

namespace App\Http\Requests\Location;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Symfony\Component\HttpFoundation\Response;


class StoreLocationRequest extends FormRequest
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
            // LOCATION REQUEST
            'locationGroupName' => ['nullable', 'integer', 'min:0'], // locationGroupId EXCEPT
            'activeFlag' => ['boolean'],
            'countedAsAvailable' => ['boolean'],
            'locationName' => ['string', 'nullable', 'max:50'],
            'pickable' => ['boolean'],
            'receivable' => ['boolean', 'required'],
            'sortOrder' => ['integer', 'nullable', 'min:0', 'max:9999'],
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
