<?php

namespace App\Http\Requests\Customer;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Symfony\Component\HttpFoundation\Response;


class StoreCustomerRequest extends FormRequest
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
            'accountTypeId' => ['nullable', 'integer'], // Corresponds to customer group
            'activeFlag' => ['nullable', 'boolean'], // Specifies if the customer is active
            'creditLimit' => ['nullable', 'numeric'], // The customer's credit limit
            'currencyId' => ['nullable', 'integer'], // Related to CurrencyName
            'currencyRate' => ['nullable', 'numeric'], // The currency rate of the customer
            'defaultCarrierId' => ['nullable', 'integer'], // Related to CarrierName
            'defaultPaymentTermsId' => ['nullable', 'integer'], // Related to PaymentTerms
            'defaultSalesmanId' => ['nullable', 'integer'], // Related to Salesman
            'defaultShipTermsId' => ['nullable', 'integer'], // Related to ShippingTerms
            'customerName' => ['nullable', 'string', 'max:41'], // The name of the customer
            'note' => ['nullable', 'string', 'max:90'], // Likely corresponds to AlertNotes
            'number' => ['nullable', 'string', 'max:30'], // The account number associated with the customer
            'qbClassId' => ['nullable', 'integer'], // Related to QuickBooksClassName
            'statusId' => ['nullable', 'integer'], // The status of the customer (Normal, Preferred, Hold Sales, etc.)
            'taxExempt' => ['nullable', 'boolean'], // Specifies if this customer is tax exempt
            'taxExemptNumber' => ['nullable', 'string', 'max:30'], // The tax exempt number for the customer
            'taxRateId' => ['nullable', 'integer'], // Related to TaxRate
            'toBeEmailed' => ['nullable', 'boolean'], // Flags orders for this customer as To Be Emailed
            'toBePrinted' => ['nullable', 'boolean'], // Flags orders for this customer as To Be Printed
            'url' => ['nullable', 'url', 'max:30'], // The URL for this customer
            'issuableStatusId' => ['nullable', 'integer'], // Related to IssuableStatus
            'carrierServiceId' => ['nullable', 'integer'], // Related to CarrierService
            
            // IF IT HAS ADDRESS
            'name' => ['required', 'string', 'max:41'], // The name of the customer or address
            'city' => ['nullable', 'string', 'max:30'], // The city of the address
            'countryId' => ['nullable', 'integer', 'min:0'], // Related to Country
            'locationGroupId' => ['nullable', 'integer', 'min:0'],
            'addressName' => ['nullable', 'string', 'max:90'], // The name of the address
            'stateId' => ['nullable', 'integer', 'min:0'], // Related to State
            'address' => ['required', 'string', 'max:90'], // The address
            'typeID' => ['nullable', 'integer', 'min:0'], // Likely related to AddressType
            'zip' => ['nullable', 'string', 'max:10'], // The zip code 
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
