<?php

namespace App\Http\Requests\Part;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Symfony\Component\HttpFoundation\Response;

class StorePartRequest extends FormRequest
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
            'partNumber' => ['required', 'string', 'max:70', 'exists:part,num'], // num
            'partDescription' => ['nullable', 'string', 'max:252'], // description
            'partDetails' => ['nullable', 'string'],
            'uom' => ['required', 'string', 'exists:oum,name'], // uomId
            'upc' => ['nullable', 'string', 'max:31'],
            'partType' => ['required', 'string', 'exists:parttype,name'], // typeId
            'active' => ['required', 'boolean'], // active Flag
            'abcCode' => ['nullable', 'string', 'max:1'],
            'weight' => ['nullable', 'numeric'],
            'weightUom' => ['nullable', 'integer'], // weightuomId
            'width' => ['nullable', 'numeric'],
            'lenght' => ['nullable', 'numeric'], // lenght
            'sizeUom' => ['nullable', 'integer'], // size Uom Id
            'consumptionRate' => ['required', 'numeric'],
            'alertNote' => ['nullable', 'string', 'max:256'],
            'pictureUrl' => ['nullable', 'string', 'max:256', 'url'], // url
            'revision' => ['nullable', 'string', 'max:15'],
            'poItemType' => ['nullable', 'integer', 'exists:poitemtype,name'], // defualtPoItemTypeId
            'defaultOutsourcedReturnItem' => ['nullable', 'integer'], // defaultOutsourcedReturnItemId
            'primaryTracking' => ['required', 'string'],
            'tracks' => ['required', 'string'],
            'nextValue' => ['required', 'string'],
            'cf' => ['nullable', 'string'], // customFields
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
