<?php

namespace App\Http\Requests\Product;

use App\Rules\ProductValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreProductRequest extends FormRequest
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
            'partNumber' => ['required', 'string', 'exists:part,num', 'unique:product,partId' ], // partId
            'productNumber' => ['required', 'string', 'max:70', 'unique:product,num'], // num
            'productDescription' => ['required', 'string', 'max:252'], // description
            'productDetails' => ['required', 'string'], // details
            'uom' => ['required', 'string', 'exists:uom,name'],
            'price' => ['required', 'numeric'],
            'class' => ['required', 'string'],
            'active' => ['required', 'boolean'], // activeFlag
            'taxable' => ['required', 'boolean'], // taxbableFlag
            'combo' => ['required', 'boolean'], // showSoComboFlag
            'allowUom' => ['required', 'boolean'], // sellableInOtherUoms
            'productUrl' => ['required', 'string', 'max:256'], // url
            'productPictureUrl' => ['required', 'string', 'max:256'],
            'productUpc' => ['required', 'string', 'max:41'], // upc
            'productSku' => ['required', 'string', 'max:41'], // sku
            'productSoItemType' => ['required', 'string', 'exists:soitemtype,name'], // defaultSoItemType
            'incomeAccount' => ['required', 'string'],
            'weight' => ['required', 'numeric'],
            'weightUom' => ['required', 'string'], // weightUom 
            'width' => ['required', 'numeric'],
            'height' => ['required', 'numeric'],
            'length' => ['required', 'numeric'],
            'sizeUom' => ['required', 'string'],
            'default' => ['required', 'boolean'],
            'alertNote' => ['required', 'string', 'max:90'],
            'cartonCount' => ['required', 'numeric'],
            'cartonType' => ['required', 'string'],
            'cf' => ['required', 'string'],
        ];
    }
}
