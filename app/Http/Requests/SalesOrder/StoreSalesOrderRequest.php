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
            [
                // General Information
                'flag' => ['boolean'], // Flag
                'status' => ['nullable', 'integer'], // Status
                'customerName' => ['nullable', 'string', 'max:100'], // CustomerName
                'customerContact' => ['string', 'nullable', 'max:30'], // CustomerContact

                // Billing Information
                'billToName' => ['string', 'nullable', 'max:41'], // BillToName
                'billToAddress' => ['string', 'nullable', 'max:90'], // BillToAddress
                'billToCity' => ['string', 'nullable', 'max:30'], // BillToCity
                'billToState' => ['nullable', 'string', 'min:0'], // BillToState
                'billToZip' => ['string', 'nullable', 'max:10'], // BillToZip
                'billToCountry' => ['nullable', 'integer', 'min:0'], // BillToCountry

                // Shipping Information
                'shipToName' => ['string', 'nullable', 'max:41'], // ShipToName
                'shipToAddress' => ['string', 'nullable', 'max:90'], // ShipToAddress
                'shipToCity' => ['string', 'nullable', 'max:30'], // ShipToCity
                'shipToState' => ['nullable', 'string', 'min:0'], // ShipToState
                'shipToZip' => ['string', 'nullable', 'max:10'], // ShipToZip
                'shipToCountry' => ['nullable', 'integer', 'min:0'], // ShipToCountry
                'shipToResidential' => ['boolean'], // ShipToResidential

                // Carrier Information
                'carrierName' => ['nullable', 'string', 'max:100'], // CarrierName
                'carrierService' => ['nullable', 'string', 'max:100'], // CarrierService

                // Tax and Priority Information
                'taxRateName' => ['nullable', 'string', 'max:100'], // TaxRateName
                'priorityId' => ['nullable', 'integer', 'min:0'], // PriorityId

                // Order Information
                'poNum' => ['nullable', 'string', 'max:50'], // PONum
                'vendorPONum' => ['string', 'nullable', 'max:25'], // VendorPONum
                'date' => ['nullable', 'date'], // Date
                'orderDateScheduled' => ['nullable', 'date'], // OrderDateScheduled
                'dateExpired' => ['nullable', 'date'], // DateExpired

                // Sales Information
                'salesman' => ['nullable', 'string', 'max:100'], // Salesman
                'shippingTerms' => ['nullable', 'integer', 'in:10,20,30'], // ShippingTerms
                'paymentTerms' => ['nullable', 'string', 'max:50'], // PaymentTerms
                'fob' => ['nullable', 'string', 'max:50'], // FOB
                'note' => ['nullable', 'string', 'max:500'], // Note

                // QuickBooks and Location Information
                'quickBooksClassName' => ['nullable', 'integer', 'min:0'], // QuickBooksClassName
                'locationGroupName' => ['nullable', 'string', 'max:100'], // LocationGroupName

                // Contact Information
                'phone' => ['string', 'nullable', 'max:256'], // Phone
                'email' => ['string', 'nullable', 'max:256', 'email'], // Email

                // URL
                'url' => ['string', 'nullable', 'max:256', 'url'], // URL

                // Category
                'category' => ['nullable', 'string', 'max:100'], // Category

                // Custom Field
                'customField' => ['string', 'nullable', 'max:255'], // CF-Custom
            ]

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
