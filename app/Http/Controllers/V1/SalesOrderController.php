<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Customer\StoreCustomerRequest;
use App\Http\Requests\Customer\UpdateCustomerRequest;
use App\Http\Requests\SalesOrder\StoreSalesOrderRequest;
use App\Http\Requests\SalesOrder\UpdateSalesOrderRequest;
use App\Http\Requests\SalesOrderItem\StoreSalesOrderItemRequest;
use App\Http\Requests\SalesOrderItem\UpdateSalesOrderItemRequest;
use App\Models\Account;
use App\Models\Address;
use App\Models\Carrier;
use App\Models\CarrierService;
use App\Models\Country;
use App\Models\Customer;
use App\Models\qbClass;
use App\Models\SalesOrder;
use App\Models\SalesOrderItems;
use App\Models\SalesOrderStatus;
use App\Models\State;
use App\Models\TaxRate;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class SalesOrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreSalesOrderRequest $storeSalesOrderRequest, StoreCustomerRequest $storeCustomerRequest): JsonResponse
    {
        // BILL TO
        $billToCountry = Country::firstOrCreate(['name' => $storeSalesOrderRequest->billToCountry]);
        $billToState = State::firstOrCreate(['name' => $storeSalesOrderRequest->billToState]);

        // SHIP TO
        $shipToCountry = Country::firstOrCreate(['name' => $storeSalesOrderRequest->shipToCountry]);
        $shipToState = State::firstOrCreate(['name' => $storeSalesOrderRequest->shipToState]);

        // qbclass
        $qbclass = qbClass::firstOrCreate(['name' => $storeSalesOrderRequest->quickBookClassName]);

        // Status
        $status = SalesOrderStatus::firstOrCreate(['name' => $storeSalesOrderRequest->status]);

        // Carrier`
        $carrier = Carrier::where('name', $storeSalesOrderRequest->carrierName)->first();
        // $carrierService = CarrierService::where('name', $storeSalesOrderRequest->carrierService)->first();

        // Tax Rate
        $taxRate = TaxRate::firstOrCreate(['name' => $storeSalesOrderRequest->taxRateName]);

        $customerId = null;

        // CUSTOMER
        if ($storeCustomerRequest->customerName !== null) {
            // Create an account
            $account = Account::create(['typeId' => $storeCustomerRequest->accountTypeId]);

            // Find or instantiate a customer
            $customer = Customer::firstOrNew(
                ['name' => $storeCustomerRequest->customerName]
            );

            // Check if the customer is newly created
            if (!$customer->exists) {
                $customer->fill($storeCustomerRequest->except([
                    'accountTypeId',
                    'city',
                    'countryId',
                    'locationGroupId',
                    'addressName',
                    'pipelineContactNum',
                    'stateId',
                    'address',
                    'typeId',
                    'zip'
                ]) + [
                    'statusId' => $storeSalesOrderRequest->status,
                    'accountId' => $account->id,
                ]);
                $customer->save();
            }

            $customerId = $customer->id;

            // Create or update an address only if the customer is newly created
            if ($customer->wasRecentlyCreated) {
                $address = Address::create(
                    $storeCustomerRequest->only([
                        'name',
                        'countryId',
                        'locationGroupId',
                        'addressName',
                        'pipelineContactNum',
                        'stateId',
                        'address',
                        'typeId',
                        'zip'
                    ]) + [
                        'accountId' => $account->id,
                    ]
                );

                $address->save();
            }
        }

        // SoNum
        $lastNum = optional(SalesOrder::orderBy('id', 'desc')->first())->num;
        $newNum = $lastNum ? (string)((int)$lastNum + 1) : '1001';

        $salesOrder = SalesOrder::create(
            $storeSalesOrderRequest->except('items') +
                [
                    'billToCountryId' => $billToCountry->id,
                    'billToStateId' => $billToState->id,

                    'shipToCountryId' => $shipToCountry->id,
                    'shipToStateId' => $shipToState->id,

                    'taxRateId' => $taxRate->id,
                    // 'taxRate' => $taxRate->rate,

                    'statusId' => $storeSalesOrderRequest->status,

                    'customerId' => $customerId,

                    'carrierId' => $carrier->id,
                    // 'carrierServiceId' => $carrierService->id,

                    'residentialFlag' => $storeSalesOrderRequest->shipToResidential,
                    'qbClassId' => $qbclass->id,

                    'num' =>  $storeSalesOrderRequest->soNum ?? $newNum,
                ]
        );

        return response()->json(
            [
                'salesOrder' => $salesOrder,
                'customer' => $customer,
                'address' => $address,
                'message' => 'Sales Order Created Successfully!',
            ],
            Response::HTTP_CREATED
        );
    }

    /**
     * Display the specified resource.
     */
    public function show(SalesOrder $salesOrder): JsonResponse
    {
        return response()->json($salesOrder, Response::HTTP_OK);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateSalesOrderRequest $updateSalesOrderRequest, UpdateCustomerRequest $updateCustomerRequest, SalesOrder $salesOrder): JsonResponse
    {

        // BILL TO
        $billToCountry = Country::firstOrCreate(['name' => $updateSalesOrderRequest->billToCountry]);
        $billToState = State::firstOrCreate(['name' => $updateSalesOrderRequest->billToState]);

        // SHIP TO
        $shipToCountry = Country::firstOrCreate(['name' => $updateSalesOrderRequest->shipToCountry]);
        $shipToState = State::firstOrCreate(['name' => $updateSalesOrderRequest->shipToState]);

        // qbclass
        $qbclass = qbClass::firstOrCreate(['name' => $updateSalesOrderRequest->quickBookClassName]);

        // Status
        $status = SalesOrderStatus::firstOrCreate(['name' => $updateSalesOrderRequest->status]);

        // Carrier
        $carrier = Carrier::where('name', $updateSalesOrderRequest->carrierName)->first();

        // Tax Rate
        $taxRate = TaxRate::firstOrCreate(['name' => $updateSalesOrderRequest->taxRateName]);

        // CUSTOMER
        if ($updateCustomerRequest->customerName !== null) {
            $customer = Customer::findOrFail($salesOrder->customerId);

            $customer->update($updateCustomerRequest->except([
                'accountTypeId',
                'city',
                'countryId',
                'locationGroupId',
                'addressName',
                'pipelineContactNum',
                'stateId',
                'address',
                'typeId',
                'zip'
            ]) + [
                'statusId' => $updateSalesOrderRequest->status,
            ]);

            // Update the associated address
            $address = Address::where('accountId', $customer->accountId)->first();
            if ($address) {
                $address->update(
                    $updateCustomerRequest->only([
                        'name',
                        'countryId',
                        'locationGroupId',
                        'addressName',
                        'pipelineContactNum',
                        'stateId',
                        'address',
                        'typeId',
                        'zip'
                    ])
                );
            }
        }

        $salesOrder->update(
            $updateSalesOrderRequest->except('items') +
                [
                    'billToCountryId' => $billToCountry->id,
                    'billToStateId' => $billToState->id,

                    'shipToCountryId' => $shipToCountry->id,
                    'shipToStateId' => $shipToState->id,

                    'taxRateId' => $taxRate->id,

                    'statusId' => $updateSalesOrderRequest->status,

                    'carrierId' => $carrier->id,

                    'residentialFlag' => $updateSalesOrderRequest->shipToResidential,
                    'qbClassId' => $qbclass->id,
                ]
        );

        return response()->json(
            [
                'salesOrder' => $salesOrder,
                'customer' => $customer ?? null,
                'address' => $address ?? null,
                'message' => 'Sales Order Updated Successfully!',
            ],
            Response::HTTP_OK
        );
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(SalesOrder $salesOrder): JsonResponse
    {
        $salesOrder->delete();

        return response()->json(
            [
                'message' => 'Sales Order Deleted Successfully!'
            ],
            Response::HTTP_OK
        );
    }
}
