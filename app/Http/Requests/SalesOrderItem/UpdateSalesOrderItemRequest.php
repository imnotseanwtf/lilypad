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
            // SALES ORDER ITEMS
            'items' => ['required', 'array'],
            'items.*.adjustAmount' => ['required', 'numeric'],
            'items.*.adjustPercentage' => ['required', 'numeric'],
            'items.*.customerPartNum' => ['required', 'string'],
            'items.*.dateLastFulfillment' => ['required', 'date'],
            'items.*.dateScheduledFulfillment' => ['required', 'date'],
            'items.*.description' => ['required', 'string'],
            'items.*.itemAdjustId' => ['required', 'integer'],
            'items.*.markupCost' => ['required', 'numeric'],
            'items.*.mcTotalPrice' => ['required', 'numeric'],
            'items.*.note' => ['required', 'string'],
            'items.*.productId' => ['required', 'integer'],
            'items.*.productNum' => ['required', 'string'],
            'items.*.qtyFulfilled' => ['required', 'integer'],
            'items.*.qtyOrdered' => ['required', 'integer'],
            'items.*.qtyPicked' => ['required', 'integer'],
            'items.*.qtyToFulfill' => ['required', 'integer'],
            'items.*.revLevel' => ['required', 'string'],
            'items.*.showItemFlag' => ['required', 'boolean'],
            'items.*.soLineItem' => ['required', 'integer'],
            'items.*.taxId' => ['required', 'integer'],
            'items.*.taxableFlag' => ['required', 'boolean'],
            'items.*.totalCost' => ['required', 'numeric'],
            'items.*.typeId' => ['required', 'integer'],
            'items.*.unitPrice' => ['required', 'numeric'],
            'items.*.uomId' => ['required', 'integer']
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
