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
            'name' => ['required', 'string', 'max:41', 'unique:customer,name'],
            'addressName' => ['required','string'],  // name
            'addressContact' => ['required','string'],
            'addressType' => ['required','string',  'exists:addresstype,name'], // typeId
            'isDefault' => ['required', 'boolean'], // activeFlag
            'address' => ['required', 'string', 'max:90'], // The address
            'city' => ['required', 'string', 'max:30'], // The city of the address
            'state' => ['required', 'string', 'exists:state,name'], // Related to State
            'zip' => ['required', 'string', 'max:10'], // The zip code 
            'country' => ['required', 'string', 'exists:country,name'], // Related to Country
            'resident' => ['required', 'boolean'],
            'main' => ['required', 'string'],
            'home' => ['required', 'string'],
            'work' =>  ['required', 'string'],
            'mobile'=> ['required', 'string'],
            'fax'=> ['required', 'string'],
            'email'=> ['required', 'string','email'],
            'pager' => ['required', 'string'],
            'web' => ['required', 'string'],
            'other' => ['required', 'string'],
            'currencyName' => ['required', 'string', 'exists:currency,name'],
            'currencyRate' => ['required', 'numeric'],
            'group' => ['required', 'string'],
            'creditLimit' => ['required', 'numeric'], // The customer's credit limit
            'status' => ['required', 'string', 'exists:customerstatus,name'], // statusId
            'active' => ['required', 'boolean',], // activeFlag
            'taxRate' => ['required', 'string', 'exists:taxrate,name'], // taxRateId 
            'salesman' => ['required', 'integer'], // defaultSalesmanId
            'defaultPriority' => ['required', 'string', 'exists:priority,name'], 
            'number' => ['required', 'string', 'max:30', "unique:customer,number"], 
            'paymentTerms' => ['required', 'string', 'exists:paymentterms,name'], // defaultPaymentTermsId
            'taxExempt' => ['required', 'boolean'], // Specifies if this customer is tax exempt
            'taxExemptNumber' => ['required', 'string', 'max:30'], // The tax exempt number for the customer
            'url' => ['required', 'url', 'max:30'], // The URL for this customer
            'carrierName' => ['required', 'string', 'exists:carrier,name'], // defaultCarrierId
            'carrierService' => ['required', 'string', 'exists:carrierservice,name'], // carrierServiceId
            'shippingTerms' => ['required', 'string'], // defaultShipTermsId
            'alertNotes' => ['required', 'string'],
            'quickBooksClassName' => ['required', 'string', 'exists:qbclass,name'], // qbClassId
            'toBeEmailed' => ['required', 'boolean'], // Flags orders for this customer as To Be Emailed
            'toBePrinted' => ['required', 'boolean'], // Flags orders for this customer as To Be Printed
            'issuableStatus' => ['required', 'string'], // issuableStatusId
            'cf'=> ['required', 'string'],
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