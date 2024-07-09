<?php

namespace App\Http\Controllers;

use App\Http\Requests\SalesOrder\StoreSalesOrderRequest;
use App\Http\Requests\SalesOrder\UpdateSalesOrderRequest;
use App\Models\SalesOrder;
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
    public function store(StoreSalesOrderRequest $controllerOrderRequest): JsonResponse
    {
        try {
            // Prepare data for AddressController
            $addressData = [
                'accountName' => $controllerOrderRequest->accountName,
                'countryName' => $controllerOrderRequest->countryName,
                'stateName' => $controllerOrderRequest->stateName,
            ];
            $addressRequest = new Request($addressData);

            // Call AddressController and get response
            $addressController = new AddressController();
            $addressResponse = $addressController($addressRequest)->getData();

            // Log response from AddressController
            Log::info('Response from AddressController:', (array) $addressResponse);

            // Ensure AddressController response contains the required data
            if (!isset($addressResponse->account_type_id, $addressResponse->country_id, $addressResponse->state_id)) {
                return response()->json(['error' => 'Invalid response from AddressController'], 500);
            }

            // Prepare data for TaxController
            $taxData = 
            [
                'taxRateName' => $controllerOrderRequest->taxRateName,
            ];

            $taxRequest = new Request($taxData);

            // Call TaxController and get response
            $taxController = new TaxController();
            $taxResponse = $taxController($taxRequest)->getData();

            // Log response from TaxController
            Log::info('Response from TaxController:', (array) $taxResponse);

            // Ensure TaxController response contains the required data
            if (!isset($taxResponse->tax_id)) {
                return response()->json(['error' => 'Invalid response from TaxController'], 500);
            }

            // Create SalesOrder
            $salesOrder = SalesOrder::create(
                $controllerOrderRequest->except(['accountName', 'countryName', 'stateName', 'taxRateName']) +
                    [
                        'account_type_id' => $addressResponse->account_type_id,
                        'country_id' => $addressResponse->country_id,
                        'state_id' => $addressResponse->state_id,
                        'tax_id' => $taxResponse->tax_id,
                    ]
            );

            return response()->json([
                'message' => 'Sales order created successfully',
                'salesOrder' => $salesOrder
            ], 201);
        } catch (\Exception $e) {
            // Log error and return response
            Log::error('Error creating sales order: ' . $e->getMessage());
            return response()->json(['error' => 'Something went wrong'], 500);
        }
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
    public function update(UpdateSalesOrderRequest $updateSalesOrderRequest, SalesOrder $salesOrder): JsonResponse
    {
        $salesOrder->update($updateSalesOrderRequest->validated());

        return response()->json(
            [
               'data' => $salesOrder,
               'message' => 'Sales Updated Successfully'
            ]
        );
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
