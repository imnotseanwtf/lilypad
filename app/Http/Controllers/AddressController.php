<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;
use App\Models\AccountType;
use App\Models\Address;
use App\Models\Country;
use App\Models\State;

class AddressController extends Controller
{
    public function __invoke(Request $request): JsonResponse
    {
        try {
            // Log the incoming request data
            Log::info('AddressController invoked with data:', $request->all());

            // Process the request and create or find the necessary records
            $account_type = AccountType::firstOrCreate(['name' => $request->accountName]);
            $country = Country::firstOrCreate(['name' => $request->countryName]);
            $state = State::firstOrCreate(['name' => $request->stateName]);

            Address::create(
                [
                    'account_type_id' => $account_type->id,
                    'country_id' => $country->id,
                    'state_id' => $state->id,
                ]
            );

            // Log the IDs of the created or found records
            Log::info('Account, Country, and State IDs:', [
                'account_type_id' => $account_type->id,
                'country_id' => $country->id,
                'state_id' => $state->id
            ]);

            return response()->json([
                'account_type_id' => $account_type->id,
                'country_id' => $country->id,
                'state_id' => $state->id,
            ]);
        } catch (\Exception $e) {
            // Log the error message
            Log::error('Error in AddressController:', ['message' => $e->getMessage()]);

            return response()->json(['error' => 'Something went wrong in AddressController'], 500);
        }
    }
}
