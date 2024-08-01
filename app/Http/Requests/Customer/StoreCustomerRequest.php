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
            'name' => ['nullable', 'string', 'max:41', 'unique:customer,name'],
            'addressName' => ['required','string'],  // name
            'addressContact' => ['required','string'],
            'addressType' => ['required','string',  'exists:addresstype,name'], // typeId
            'isDefault' => ['required', 'boolean'], // activeFlag
            'address' => ['nullable', 'string', 'max:90'], // The address
            'city' => ['nullable', 'string', 'max:30'], // The city of the address
            'state' => ['nullable', 'string', 'exists:state,name'], // Related to State
            'zip' => ['nullable', 'string', 'max:10'], // The zip code 
            'country' => ['nullable', 'string', 'exists:country,name'], // Related to Country
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
            'creditLimit' => ['nullable', 'numeric'], // The customer's credit limit
            'status' => ['nullable', 'string', 'exists:customerstatus,name'], // statusId
            'active' => ['nullable', 'boolean',], // activeFlag
            'taxRate' => ['nullable', 'string', 'exists:taxrate,name'], // taxRateId 
            'salesman' => ['nullable', 'integer'], // defaultSalesmanId
            'defaultPriority' => ['required', 'string', 'exists:priority,name'], 
            'number' => ['nullable', 'string', 'max:30', 'unique:customer,name'], 
            'paymentTerms' => ['nullable', 'string', 'exists:paymentterms,name'], // defaultPaymentTermsId
            'taxExempt' => ['nullable', 'boolean'], // Specifies if this customer is tax exempt
            'taxExemptNumber' => ['nullable', 'string', 'max:30'], // The tax exempt number for the customer
            'url' => ['nullable', 'url', 'max:30'], // The URL for this customer
            'carrierName' => ['nullable', 'string', 'exists:carrier,name'], // defaultCarrierId
            'carrierService' => ['nullable', 'string', 'exists:carrierservice,name'], // carrierServiceId
            'shippingTerms' => ['nullable', 'string'], // defaultShipTermsId
            'alertNotes' => ['required', 'string'],
            'quickBooksClassName' => ['nullable', 'string', 'exists:qbclass,name'], // qbClassId
            'toBeEmailed' => ['nullable', 'boolean'], // Flags orders for this customer as To Be Emailed
            'toBePrinted' => ['nullable', 'boolean'], // Flags orders for this customer as To Be Printed
            'issuableStatus' => ['nullable', 'string'], // issuableStatusId
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