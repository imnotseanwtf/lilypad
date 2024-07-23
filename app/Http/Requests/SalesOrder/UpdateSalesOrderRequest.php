<?php

namespace App\Http\Requests\SalesOrder;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Symfony\Component\HttpFoundation\Response;

class UpdateSalesOrderRequest extends FormRequest
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
            // General Information
            'flag' => ['required', 'boolean'], // Flag
            'status' => ['required', 'integer'], // Status
            'customerName' => ['required', 'string', 'max:100'], // CustomerName
            'customerContact' => ['required', 'string', 'max:30'], // CustomerContact

            // Billing Information
            'billToName' => ['required', 'string', 'max:41'], // BillToName
            'billToAddress' => ['required', 'string', 'max:90'], // BillToAddress
            'billToCity' => ['required', 'string', 'max:30'], // BillToCity
            'billToState' => ['required', 'string'], // BillToState
            'billToZip' => ['required', 'string', 'max:10'], // BillToZip
            'billToCountry' => ['required', 'string'], // BillToCountry

            // Shipping Information
            'shipToName' => ['required', 'string', 'max:41'], // ShipToName
            'shipToAddress' => ['required', 'string', 'max:90'], // ShipToAddress
            'shipToCity' => ['required', 'string', 'max:30'], // ShipToCity
            'shipToState' => ['required', 'string'], // ShipToState
            'shipToZip' => ['required', 'string', 'max:10'], // ShipToZip
            'shipToCountry' => ['required', 'string'], // ShipToCountry
            'shipToResidential' => ['required', 'boolean'], // ShipToResidential

            // Carrier Information
            'carrierName' => ['required', 'string', 'max:100'], // CarrierName
            'carrierService' => ['required', 'string', 'max:100'], // CarrierService

            // Tax and Priority Information
            'taxRateName' => ['required', 'string', 'max:100'], // TaxRateName
            'priorityId' => ['required', 'integer', 'min:0'], // PriorityId

            // Order Information
            'poNum' => ['required', 'string', 'max:50'], // PONum
            'vendorPONum' => ['required', 'string', 'max:25'], // VendorPONum
            'date' => ['required', 'date'], // Date
            'orderDateScheduled' => ['required', 'date'], // OrderDateScheduled
            'dateExpired' => ['required', 'date'], // DateExpired

            // Sales Information
            'salesman' => ['required', 'string', 'max:100'], // Salesman
            'shippingTerms' => ['required', 'integer', 'in:10,20,30'], // ShippingTerms
            'paymentTerms' => ['required', 'string', 'max:50'], // PaymentTerms
            'fob' => ['required', 'string', 'max:50'], // FOB
            'note' => ['required', 'string', 'max:500'], // Note

            // QuickBooks and Location Information
            'quickBooksClassName' => ['required', 'integer', 'min:0'], // QuickBooksClassName
            'locationGroupName' => ['required', 'string', 'max:100'], // LocationGroupName

            // Contact Information
            'phone' => ['required', 'string', 'max:256'], // Phone
            'email' => ['required', 'string', 'max:256', 'email'], // Email

            // URL
            'url' => ['required', 'string', 'max:256', 'url'], // URL

            // Category
            'category' => ['required', 'string', 'max:100'], // Category

            // Custom Field
            'customField' => ['required', 'string', 'max:255'], // CF-Custom
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
