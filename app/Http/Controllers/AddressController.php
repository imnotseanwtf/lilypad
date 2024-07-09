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
        $account_type = AccountType::firstOrCreate(['name' => $request->accountName]);
        $country = Country::firstOrCreate(['name' => $request->countryName]);
        $state = State::firstOrCreate(['name' => $request->stateName]);

        $addressData = Address::create(
            [
                'account_type_id' => $account_type->id,
                'country_id' => $country->id,
                'state_id' => $state->id,
            ]
        );

        return response()->json($addressData);
    }
}
