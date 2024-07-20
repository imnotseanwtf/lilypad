<?php

namespace App\Http\Controllers;

use App\Http\Requests\Address\StoreAddressRequest;
use App\Http\Requests\Carrier\StoreCarrierRequest;
use App\Http\Requests\Carrier\UpdateCarrierRequest;
use App\Http\Requests\Currency\StoreCurrencyRequest;
use App\Http\Requests\Currency\UpdateCurrencyRequest;
use App\Http\Requests\Customer\StoreCustomerRequest;
use App\Http\Requests\Customer\UpdateCustomerRequest;
use App\Http\Requests\Location\StoreLocationRequest;
use App\Http\Requests\Location\UpdateLocationRequest;
use App\Http\Requests\Payment\StorePaymentTermsRequest;
use App\Http\Requests\Payment\UpdatePaymentTermsRequest;
use App\Http\Requests\SalesOrder\StoreSalesOrderRequest;
use App\Http\Requests\SalesOrder\UpdateSalesOrderRequest;
use App\Http\Requests\SalesOrderItem\StoreSalesOrderItemRequest;
use App\Http\Requests\SalesOrderItem\UpdateSalesOrderItemRequest;
use App\Http\Requests\TaxRate\StoreTaxRateRequest;
use App\Http\Requests\TaxRate\UpdateTaxRateRequest;
use App\Models\Account;
use App\Models\AccountType;
use App\Models\Customer;
use App\Models\Priority;
use App\Models\Product;
use App\Models\qbClass;
use App\Models\SalesOrder;
use App\Models\SalesOrderItemType;
use App\Models\SalesOrderStatus;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;

class SalesOrderController extends Controller
{
    /**true;true;
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(
        StoreSalesOrderRequest $storeSalesOrderRequest,
        StoreLocationRequest $storeLocationRequest,
        StoreCarrierRequest $storeCarrierRequest,
        StoreCustomerRequest $storeCustomerRequest,
        StoreTaxRateRequest $storeTaxRateRequest,
        StoreSalesOrderItemRequest $storeSalesOrderItemRequest,
        StorePaymentTermsRequest $storePaymentTermsRequest,
        StoreCurrencyRequest $storeCurrencyRequest,
    ): JsonResponse {
        // ACCOUNT TYPE
        $accountType = AccountType::firstOrCreate(['name' => $storeSalesOrderRequest->accountTypeName]);

        // ACCOUNT
        $account = Account::firstOrCreate(['typeId' => $accountType->id]);

        // LOCATION GROUP
        $locationGroupData =
            [
                'locationGroupName' => $storeLocationRequest->locationGroupName,
                'countedAsAvailable' => $storeLocationRequest->countedAsAvailable,
                'locationName' => $storeLocationRequest->locationName,
                'pickable' => $storeLocationRequest->pickable,
                'receivable' => $storeLocationRequest->receivable,
                'sortOrder' => $storeLocationRequest->sortOrder,
                'typeId' => $account->id,
            ];

        $locationGroupRequest = new Request($locationGroupData);
        $locationGroupController = new LocationGroupController();
        $locationGroupResponse = $locationGroupController($locationGroupRequest)->getData();

        // ADDRESS
        $addressData =
            [
                'accountId' => $account->id,
                'billToName' => $storeSalesOrderRequest->billToName,
                'billToCity' => $storeSalesOrderRequest->billToCity,
                'billToCountryName' => $storeSalesOrderRequest->billToCountryName,
                'defaultFlag' => $storeSalesOrderRequest->defaultFlag,
                'locationGroupId' => $locationGroupResponse->locationGroupId,
                'billToAddress' => $storeSalesOrderRequest->billToAddress,
                'billToStateName' => $storeSalesOrderRequest->billToStateName,
                'billToZip' => $storeSalesOrderRequest->billToZip,
                // SHIP
                'shipToName' => $storeSalesOrderRequest->shipToName,
                'shipToCity' => $storeSalesOrderRequest->shipToCity,
                'shipToCountryName' => $storeSalesOrderRequest->shipToCountryName,
                'shipToAddress' => $storeSalesOrderRequest->shipToAddress,
                'shipToStateName' => $storeSalesOrderRequest->shipToStateName,
                'shipToZip' => $storeSalesOrderRequest->shipToZip,
            ];

        $addressRequest = new Request($addressData);

        $addressController = new AddressController();
        $addressResponse = $addressController($addressRequest)->getData();

        $carrierData = [
            'carrierServiceName' => $storeCarrierRequest->carrierServiceName,
            'readOnly' => $storeCarrierRequest->readOnly,
            'scac' => $storeCarrierRequest->scac,
            'carrierDescription' => $storeCarrierRequest->carrierDescription,
            'carrierCode' => $storeCarrierRequest->carrierCode,
        ];

        $carrierRequest = new Request($carrierData);

        $carrierController = new CarrierController();
        $carrierResponse = $carrierController($carrierRequest)->getData();

        // CUSTOMER
        $customer = Customer::firstOrCreate(
            [
                'name' => $storeCustomerRequest->customerName,
            ],
            [
                'accountId' => $account->id,
                'statusId' => $storeSalesOrderRequest->status,
                'taxExempt' => $storeCustomerRequest->taxExempt,
                'defaultSalesmanId' => $storeSalesOrderRequest->salesmanId,
                'toBeEmailed' => $storeSalesOrderRequest->toBeEmailed,
                'toBePrinted' => $storeSalesOrderRequest->toBePrinted,
            ]
        );

        $currencyData =
            [
                'name' => $storeCurrencyRequest->currencyName,
                'code' => $storeCurrencyRequest->currencyCode,
                'excludeFromUpdate' => $storeCurrencyRequest->excludeFromUpdate,
                'homeCurrency' => $storeCurrencyRequest->homeCurrency,
                'symbol' => $storeCurrencyRequest->currencySymbol,
            ];

        $currencyRequest = new Request($currencyData);
        $currencyController = new CurrencyController();
        $currencyResponse = $currencyController($currencyRequest)->getData();

        // SALES ORDER ITEM TYPE
        $salesOrderItemType = SalesOrderItemType::firstOrCreate(['name' => $storeSalesOrderRequest->salesOrderItemTypeName]);

        $product = Product::firstOrCreate(
            [
                'defaultSoItemType' => $salesOrderItemType->id,
                'details' => $storeSalesOrderRequest->productDetails,
            ]
        );

        $taxRateData =
            [
                'name' => $storeTaxRateRequest->taxRateName,
                'code' => $storeTaxRateRequest->taxRateCode,
                'description' => $storeTaxRateRequest->taxRateDescription,
                'orderTypeId' => $salesOrderItemType->id,
                'rate' => $storeTaxRateRequest->taxRate,
                'taxAccountId' => $account->id,
                // type code
                // unit cost
                // vendor Id
            ];

        $taxRateRequest = new Request($taxRateData);
        $taxRateController = new TaxRateController();
        $taxRateResponse = $taxRateController($taxRateRequest)->getData();

        $paymentTermsData =
            [
                'defaultTerm' => $storePaymentTermsRequest->defaultTerm,
                'name' => $storePaymentTermsRequest->paymentTermsName,
                'discount' => $storePaymentTermsRequest->discount,
                'discountDays' => $storePaymentTermsRequest->discountDays,
                'netDays' => $storePaymentTermsRequest->netDays,
                'nextMonth' => $storePaymentTermsRequest->nextMonth,
                'readOnly' => $storePaymentTermsRequest->readOnly,
            ];

        $paymentTermsRequest = new Request($paymentTermsData);

        $paymentTermsController = new PaymentTermsController();
        $paymentTermsResponse = $paymentTermsController($paymentTermsRequest)->getData();

        $priority = Priority::firstOrCreate(['name' => $storeSalesOrderRequest->priorityName]);

        $qbclass = qbClass::firstOrCreate(
            [
                'name' => $storeSalesOrderRequest->quickBookName,
            ]
        );

        $lastNum = optional(SalesOrder::orderBy('id', 'desc')->first())->num;
        $newNum = $lastNum ? (string)((int)$lastNum + 1) : '10001';

        $salesOrder = SalesOrder::create(
            $storeSalesOrderRequest->except(
                [
                    'billToCountryName',
                    'billToStateName',
                    'currencyName',
                    'locationGroupName',
                    'paymentTermsName',
                    'priorityName',
                    'quickBookName',
                    'shipToCountryName',
                    'shipToStateName',
                ]
            ) +
                [
                    'customerId' => $customer->id,
                    'billToCountryId' => $addressResponse->billToCountryId,
                    'billToStateId' => $addressResponse->billToStateId,
                    'carrierId' => $carrierResponse->carrierId,
                    'carrierServiceId' => $carrierResponse->carrierServiceId,
                    'currencyId' => $currencyResponse->id,
                    'locationGroupId' => $locationGroupResponse->id,
                    'paymentTermsId' => $paymentTermsResponse->id,
                    'priorityId' => $priority->id,
                    'qbClassId' => $qbclass->id,
                    'shipToCountryId' => $addressResponse->shipToCountryId,
                    'shipToStateId' => $addressResponse->shipToStateId,
                    'taxRateId' => $taxRateResponse->id,
                    'taxRate' => $storeTaxRateRequest->taxRate,
                    'taxRateName' => $storeTaxRateRequest->taxRateName,
                    'num' => $newNum,
                ]   
        );

        // SALES ORDER STATUS
        $salesOrderStatus = SalesOrderStatus::firstOrCreate(['name' => $storeSalesOrderItemRequest->salesOrderStatus]);

        // SALES ORDER ITEMS
        $salesOrderItemData =
            [
                'productId' => $product->id,
                'note' => $storeSalesOrderItemRequest->note,
                'soLineItem' => $storeSalesOrderItemRequest->salesOrderLineItem,
                'soId' => $salesOrder->id,
                'statusId' => $salesOrderStatus->id,
                'typeId' => $salesOrderItemType->id,
            ];

        $salesOrderItemRequest = new Request($salesOrderItemData);
        $salesOrderItemController = new SalesOrderItemController();
        $salesOrderItemResponse = $salesOrderItemController($salesOrderItemRequest)->getData();

        return response()->json([
            'salesOrder' => $salesOrder,
            'salesOrderItem' => $salesOrderItemResponse,
            'message' => 'Success',
        ], 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(SalesOrder $salesOrder): JsonResponse
    {
        return response()->json($salesOrder);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(
        UpdateSalesOrderRequest $updateSalesOrderRequest,
        UpdateLocationRequest $updateLocationRequest,
        UpdateCarrierRequest $updateCarrierRequest,
        UpdateCustomerRequest $updateCustomerRequest,
        UpdateTaxRateRequest $updateTaxRateRequest,
        UpdateSalesOrderItemRequest $updateSalesOrderItemRequest,
        UpdatePaymentTermsRequest $updatePaymentTermsRequest,
        UpdateCurrencyRequest $updateCurrencyRequest,
        SalesOrder $salesOrder
    ): JsonResponse {
        // ACCOUNT TYPE
        $accountType = AccountType::firstOrCreate(['name' => $updateSalesOrderRequest->accountTypeName]);

        // ACCOUNT
        $account = Account::updateOrCreate(
            ['id' => $salesOrder->accountId],
            ['typeId' => $accountType->id]
        );

        // LOCATION GROUP
        $locationGroupData = [
            'locationGroupName' => $updateLocationRequest->locationGroupName,
            'countedAsAvailable' => $updateLocationRequest->countedAsAvailable,
            'locationName' => $updateLocationRequest->locationName,
            'pickable' => $updateLocationRequest->pickable,
            'receivable' => $updateLocationRequest->receivable,
            'sortOrder' => $updateLocationRequest->sortOrder,
            'typeId' => $account->id,
        ];

        $locationGroupRequest = new Request($locationGroupData);
        $locationGroupController = new LocationGroupController();
        $locationGroupResponse = $locationGroupController($locationGroupRequest)->getData();

        // ADDRESS
        $addressData = [
            'accountId' => $account->id,
            'billToName' => $updateSalesOrderRequest->billToName,
            'billToCity' => $updateSalesOrderRequest->billToCity,
            'billToCountryName' => $updateSalesOrderRequest->billToCountryName,
            'defaultFlag' => $updateSalesOrderRequest->defaultFlag,
            'locationGroupId' => $locationGroupResponse->locationGroupId,
            'billToAddress' => $updateSalesOrderRequest->billToAddress,
            'billToStateName' => $updateSalesOrderRequest->billToStateName,
            'billToZip' => $updateSalesOrderRequest->billToZip,
            'shipToName' => $updateSalesOrderRequest->shipToName,
            'shipToCity' => $updateSalesOrderRequest->shipToCity,
            'shipToCountryName' => $updateSalesOrderRequest->shipToCountryName,
            'shipToAddress' => $updateSalesOrderRequest->shipToAddress,
            'shipToStateName' => $updateSalesOrderRequest->shipToStateName,
            'shipToZip' => $updateSalesOrderRequest->shipToZip,
        ];

        $addressRequest = new Request($addressData);
        $addressController = new AddressController();
        $addressResponse = $addressController($addressRequest)->getData();

        // CARRIER
        $carrierData = [
            'carrierServiceName' => $updateCarrierRequest->carrierServiceName,
            'readOnly' => $updateCarrierRequest->readOnly,
            'scac' => $updateCarrierRequest->scac,
            'carrierDescription' => $updateCarrierRequest->carrierDescription,
            'carrierCode' => $updateCarrierRequest->carrierCode,
        ];

        $carrierRequest = new Request($carrierData);
        $carrierController = new CarrierController();
        $carrierResponse = $carrierController($carrierRequest)->getData();

        // CUSTOMER
        $customer = Customer::updateOrCreate(
            ['id' => $salesOrder->customerId],
            [
                'name' => $updateCustomerRequest->customerName,
                'accountId' => $account->id,
                'statusId' => $updateSalesOrderRequest->status,
                'taxExempt' => $updateCustomerRequest->taxExempt,
                'defaultSalesmanId' => $updateSalesOrderRequest->salesmanId,
                'toBeEmailed' => $updateSalesOrderRequest->toBeEmailed,
                'toBePrinted' => $updateSalesOrderRequest->toBePrinted,
            ]
        );

        // CURRENCY
        $currencyData = [
            'name' => $updateCurrencyRequest->currencyName,
            'code' => $updateCurrencyRequest->currencyCode,
            'excludeFromUpdate' => $updateCurrencyRequest->excludeFromUpdate,
            'homeCurrency' => $updateCurrencyRequest->homeCurrency,
            'symbol' => $updateCurrencyRequest->currencySymbol,
        ];

        $currencyRequest = new Request($currencyData);
        $currencyController = new CurrencyController();
        $currencyResponse = $currencyController($currencyRequest)->getData();

        // SALES ORDER ITEM TYPE
        $salesOrderItemType = SalesOrderItemType::firstOrCreate(['name' => $updateSalesOrderRequest->salesOrderItemTypeName]);

        $product = Product::updateOrCreate(
            ['id' => $salesOrder->productId],
            [
                'defaultSoItemType' => $salesOrderItemType->id,
                'details' => $updateSalesOrderRequest->productDetails,
            ]
        );

        // TAX RATE
        $taxRateData = [
            'name' => $updateTaxRateRequest->taxRateName,
            'code' => $updateTaxRateRequest->taxRateCode,
            'description' => $updateTaxRateRequest->taxRateDescription,
            'orderTypeId' => $salesOrderItemType->id,
            'rate' => $updateTaxRateRequest->taxRate,
            'taxAccountId' => $account->id,
        ];

        $taxRateRequest = new Request($taxRateData);
        $taxRateController = new TaxRateController();
        $taxRateResponse = $taxRateController($taxRateRequest)->getData();

        // PAYMENT TERMS
        $paymentTermsData = [
            'defaultTerm' => $updatePaymentTermsRequest->defaultTerm,
            'name' => $updatePaymentTermsRequest->paymentTermsName,
            'discount' => $updatePaymentTermsRequest->discount,
            'discountDays' => $updatePaymentTermsRequest->discountDays,
            'netDays' => $updatePaymentTermsRequest->netDays,
            'nextMonth' => $updatePaymentTermsRequest->nextMonth,
            'readOnly' => $updatePaymentTermsRequest->readOnly,
        ];

        $paymentTermsRequest = new Request($paymentTermsData);
        $paymentTermsController = new PaymentTermsController();
        $paymentTermsResponse = $paymentTermsController($paymentTermsRequest)->getData();

        // PRIORITY
        $priority = Priority::firstOrCreate(['name' => $updateSalesOrderRequest->priorityName]);

        // QBCLASS
        $qbclass = qbClass::firstOrCreate(['name' => $updateSalesOrderRequest->quickBookName]);

        // SALES ORDER
        $salesOrder->update(
            $updateSalesOrderRequest->except(
                [
                    'billToCountryName',
                    'billToStateName',
                    'currencyName',
                    'locationGroupName',
                    'paymentTermsName',
                    'priorityName',
                    'quickBookName',
                    'shipToCountryName',
                    'shipToStateName',
                ]
            ) + [
                'customerId' => $customer->id,
                'billToCountryId' => $addressResponse->billToCountryId,
                'billToStateId' => $addressResponse->billToStateId,
                'carrierId' => $carrierResponse->carrierId,
                'carrierServiceId' => $carrierResponse->carrierServiceId,
                'currencyId' => $currencyResponse->id,
                'locationGroupId' => $locationGroupResponse->id,
                'paymentTermsId' => $paymentTermsResponse->id,
                'priorityId' => $priority->id,
                'qbClassId' => $qbclass->id,
                'shipToCountryId' => $addressResponse->shipToCountryId,
                'shipToStateId' => $addressResponse->shipToStateId,
                'taxRateId' => $taxRateResponse->id,
                'taxRate' => $updateTaxRateRequest->taxRate,
                'taxRateName' => $updateTaxRateRequest->taxRateName,
            ]
        );

        // SALES ORDER STATUS
        $salesOrderStatus = SalesOrderStatus::firstOrCreate(['name' => $updateSalesOrderItemRequest->salesOrderStatus]);

        // SALES ORDER ITEMS
        $salesOrderItemData = [
            'productId' => $product->id,
            'note' => $updateSalesOrderItemRequest->note,
            'soLineItem' => $updateSalesOrderItemRequest->salesOrderLineItem,
            'soId' => $salesOrder->id,
            'statusId' => $salesOrderStatus->id,
            'typeId' => $salesOrderItemType->id,
        ];

        $salesOrderItemRequest = new Request($salesOrderItemData);
        $salesOrderItemController = new SalesOrderItemController();
        $salesOrderItemResponse = $salesOrderItemController($salesOrderItemRequest)->getData();

        return response()->json([
            'salesOrder' => $salesOrder,
            'salesOrderItem' => $salesOrderItemResponse,
            'message' => 'Success',
        ], 200);
    }




    /**
     * Remove the specified resource from storage.
     */
    public function destroy(SalesOrder $salesOrder): JsonResponse
    {
        $salesOrder->delete();

        return response()->json(['message' => 'Sales order deleted successfully']);
    }
}
