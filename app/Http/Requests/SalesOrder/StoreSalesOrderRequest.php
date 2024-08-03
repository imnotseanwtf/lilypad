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
            // General Information
            'flag' => ['required', 'boolean'],
            'soNum' => ['nullable', 'integer'],
            'status' => ['required', 'integer', 'exists:sostatus,id'], // Status
            'customerName' => ['required', 'string', 'max:100'], // CustomerName
            'customerContact' => ['required', 'string', 'max:30'], // CustomerContact

            // Billing Information
            'billToName' => ['required', 'string', 'max:41'], // BillToName
            'billToAddress' => ['required', 'string', 'max:90'], // BillToAddress
            'billToCity' => ['required', 'string', 'max:30'], // BillToCity
            'billToState' => ['required', 'string', 'exists:state,name'], // BillToState
            'billToZip' => ['required', 'string', 'max:10'], // BillToZip
            'billToCountry' => ['required', 'string', 'exists:country,name'], // BillToCountry

            // Shipping Information
            'shipToName' => ['required', 'string', 'max:41'], // ShipToName
            'shipToAddress' => ['required', 'string', 'max:90'], // ShipToAddress
            'shipToCity' => ['required', 'string', 'max:30'], // ShipToCity
            'shipToState' => ['required', 'string', 'exists:state,name'], // ShipToState
            'shipToZip' => ['required', 'string', 'max:10'], // ShipToZip
            'shipToCountry' => ['required', 'string', 'exists:country,name'], // ShipToCountry
            'shipToResidential' => ['required', 'boolean'], // ShipToResidential

            // Carrier Information
            'carrierName' => ['required', 'string', 'max:100', 'exists:carrier,name'], // CarrierName
            'carrierService' => ['required', 'string', 'max:100', 'exists:carrierservice,name'], // CarrierService

            // Tax and Priority Information
            'taxRateName' => ['required', 'string', 'max:100', 'exists:taxrate,name'], // TaxRateName
            'priorityId' => ['required', 'integer', 'min:0', 'exists:priority,id'], // PriorityId

            // Order Information
            'poNum' => ['required', 'string', 'max:50'], // PONum
            'vendorPONum' => ['required', 'string', 'max:25'], // VendorPONum
            'date' => ['required', 'date'], // Date
            'orderDateScheduled' => ['required', 'date'], // OrderDateScheduled
            'dateExpired' => ['required', 'date'], // DateExpired

            // Sales Information
            'salesman' => ['required', 'string', 'max:100'], // Salesman
            'shippingTerms' => ['required', 'string', 'exists:shipterms,name'], // ShippingTerms
            'paymentTerms' => ['required', 'string', 'max:50'], // PaymentTerms
            'fob' => ['required', 'string', 'max:50'], // FOB
            'note' => ['required', 'string', 'max:500'], // Note

            // QuickBooks and Location Information
            'quickBookClassName' => ['required', 'string', 'exists:qbclass,name'], // QuickBooksClassName
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

            'currencyName' => ['required', 'string', 'max:255', 'exists:currency,name'],
            'currencyRate' => ['required', 'numeric'],
            'priceIsHomeCurrency' => ['required', 'numeric'],


            // SO ITEM
            'items' => ['required', 'array'],
            'items.*.flag' => ['required', 'boolean'],
            'items.*.soItemTypeId' => ['required', 'integer', 'exists:soitemtype,id'], // typeId
            'items.*.productNumber' => ['required', 'string', 'max:70', 'exists:product,num'], // productNum
            'items.*.productDescription' => ['required', 'string', 'max:256'], // description
            'items.*.productQuantity' => ['required', 'integer'], // qtyOrdered
            'items.*.uom' => ['required', 'integer'],
            'items.*.productPrice' => ['required', 'numeric'], // unitPrice
            'items.*.taxable' => ['required', 'boolean'],
            'items.*.taxCode' => ['required', 'integer'],
            'items.*.note' => ['required', 'string'],
            'items.*.itemQuickBooksClassName' => ['required', 'integer'],  //qbClassId
            'items.*.itemDateScheduled' => ['required', 'date'], //dateScheduledFulfillment
            'items.*.showItem' => ['required', 'boolean'],
            'items.*.revisionLevel' => ['required', 'string'], // revLevel
            'items.*.customerPartNumber' => ['required', 'string', 'max:70'],
            'items.*.kitItem' => ['required', 'boolean'],
            'items.*.cfi' => ['required', 'string'],
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
