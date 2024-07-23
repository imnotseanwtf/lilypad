<?php

namespace App\Http\Requests\SalesOrder;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Symfony\Component\HttpFoundation\Response;

class StoreSalesOrderRequest extends FormRequest
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
    public function rules()
    {
        return [
            'billToAddress' => ['required', 'string', 'max:90'],
            'billToCity' => ['required', 'string', 'max:30'],
            'billToCountryId' => ['required', 'integer'],
            'billToName' => ['required', 'string', 'max:60'],
            'billToStateId' => ['required', 'integer'],
            'billToZip' => ['required', 'string', 'max:10'],
            'carrierId' => ['required', 'integer'],
            'carrierServiceId' => ['nullable', 'integer'],
            'cost' => ['nullable', 'numeric'],
            'currencyId' => ['nullable', 'integer'],
            'currencyRate' => ['nullable', 'numeric'],
            'customerContact' => ['nullable', 'string', 'max:30'],
            'customerId' => ['required', 'integer'],
            'customerPO' => ['nullable', 'string', 'max:15'],
            'dateCompleted' => ['nullable', 'date'],
            'dateCreated' => ['nullable', 'date'],
            'dateExpired' => ['nullable', 'date'],
            'dateFirstShip' => ['nullable', 'date'],
            'dateIssued' => ['nullable', 'date'],
            'dateLastModified' => ['nullable', 'date'],
            'dateRevision' => ['nullable', 'date'],
            'email' => ['nullable', 'email', 'max:256'],
            'estimatedTax' => ['nullable', 'numeric'],
            'locationGroupId' => ['nullable', 'integer'],
            'mcTotalTax' => ['nullable', 'numeric'],
            'note' => ['nullable', 'string'],
            'num' => ['required', 'string', 'max:25'],
            'paymentTermsId' => ['nullable', 'integer'],
            'phone' => ['nullable', 'string', 'max:256'],
            'priorityId' => ['required', 'integer', 'in:10,20,30,40,50'],
            'qbClassId' => ['nullable', 'integer'],
            'residentialFlag' => ['nullable', 'boolean'],
            'revisionNum' => ['nullable', 'integer', 'max:15'],
            'salesman' => ['nullable', 'string', 'max:100'],
            'salesmanId' => ['nullable', 'integer'],
            'salesmanInitials' => ['nullable', 'string'],
            'shipTermsId' => ['nullable', 'integer'],
            'shipToAddress' => ['required', 'string', 'max:90'],
            'shipToCity' => ['required', 'string', 'max:30'],
            'shipToCountryId' => ['required', 'integer'],
            'shipToName' => ['required', 'string', 'max:60'],
            'shipToStateId' => ['required', 'integer'],
            'shipToZip' => ['required', 'string', 'max:10'],
            'statusId' => ['required', 'integer', 'in:10,20,95'],
            'taxRate' => ['nullable', 'numeric'],
            'taxRateId' => ['required', 'integer'],
            'taxRateName' => ['required', 'string', 'max:31'],
            'toBeEmailed' => ['nullable', 'boolean'],
            'toBePrinted' => ['nullable', 'boolean'],
            'totalIncludesTax' => ['nullable', 'boolean'],
            'totalTax' => ['nullable', 'numeric'],
            'subTotal' => ['nullable', 'numeric'],
            'totalPrice' => ['nullable', 'numeric'],
            'typeId' => ['nullable', 'integer'],
            'url' => ['nullable', 'url', 'max:256'],
            'username' => ['nullable', 'string'],
            'vendorPO' => ['nullable', 'string', 'max:25'],

            // SALES ORDER ITEMS
            'items' => ['required', 'array'],
            'items.*.adjustAmount' => ['nullable', 'numeric'],
            'items.*.adjustPercentage' => ['nullable', 'numeric'],
            'items.*.customerPartNum' => ['nullable', 'string'],
            'items.*.dateLastFulfillment' => ['nullable', 'date'],
            'items.*.dateScheduledFulfillment' => ['nullable', 'date'],
            'items.*.description' => ['nullable', 'string'],
            'items.*.exchangeSOLineItem' => ['nullable', 'integer'],
            'items.*.itemAdjustId' => ['nullable', 'integer'],
            'items.*.markupCost' => ['nullable', 'numeric'],
            'items.*.mcTotalPrice' => ['nullable', 'numeric'],
            'items.*.note' => ['nullable', 'string'],
            'items.*.productId' => ['required', 'integer'],
            'items.*.productNum' => ['nullable', 'string'],
            'items.*.qtyFulfilled' => ['nullable', 'integer'],
            'items.*.qtyOrdered' => ['required', 'integer'],
            'items.*.qtyPicked' => ['nullable', 'integer'],
            'items.*.qtyToFulfill' => ['nullable', 'integer'],
            'items.*.revLevel' => ['nullable', 'string'],
            'items.*.showItemFlag' => ['nullable', 'boolean'],
            'items.*.soLineItem' => ['nullable', 'integer'],
            'items.*.taxId' => ['nullable', 'integer'],
            'items.*.taxableFlag' => ['nullable', 'boolean'],
            'items.*.totalCost' => ['nullable', 'numeric'],
            'items.*.typeId' => ['nullable', 'integer'],
            'items.*.unitPrice' => ['required', 'numeric'],
            'items.*.uomId' => ['nullable', 'integer']
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
