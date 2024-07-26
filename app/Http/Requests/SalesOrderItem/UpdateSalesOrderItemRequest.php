<?php

namespace App\Http\Requests\SalesOrderItem;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Symfony\Component\HttpFoundation\Response;

class UpdateSalesOrderItemRequest extends FormRequest
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
            'items' => ['required', 'array'],
            'items.*.flag' => ['required', 'boolean'],
            'items.*.soItemtypeId' => ['required', 'integer', 'exist:soitemtype,id'], // typeId
            'items.*.soId' => ['required', 'integer', 'exists:so,id'],
            'items.*.statusId' => ['required' , 'integer'],
            'items.*.productNum' => ['nullable', 'string', 'max:70'], 
            'items.*.productDescription' => ['nullable', 'string', 'max:256'], // description
            'items.*.productQuantity' => ['required', 'integer'], // qtyOrdered
            'items.*.uomId' => ['nullable', 'integer'],
            'items.*.productPrice' => ['nullable', 'numeric'], // unitPrice
            'items.*.taxableFlag' => ['required', 'boolean'],
            'items.*.taxRateCode' => ['required', 'integer'],
            'items.*.note' => ['required', 'string'],
            'items.*.itemQuickBooksClassName' => ['nullable', 'integer'],  //qbClassId
            'items.*.itemScheduledFulfillment' => ['required', 'date'], //dateScheduledFulfillment
            'items.*.showItemFlag' => ['required', 'boolean'],
            'items.*.revisionLevel' => ['required', 'string'], // revLevel
            'items.*.customerPartNum' => ['nullable', 'string', 'max:70'],
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
