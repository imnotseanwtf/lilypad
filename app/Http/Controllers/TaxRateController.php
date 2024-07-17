<?php

namespace App\Http\Controllers;

use App\Models\TaxRate;
use App\Models\TaxRateType;
use Illuminate\Http\Request;

class TaxRateController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $taxRateType = TaxRateType::firstOrCreate(['name' => $request->name]);

        $taxRate = TaxRate::firstOrCreate([
            'activeFlag' => $request->activeFlag,
            'code' => $request->code,
            'defaultFlag' => $request->defaultFlag,
            'description' => $request->description,
            'orderTypeId' => $request->orderTypeId,
            'rate' => $request->rate,
            'taxAccountId' => $request->taxAccountId,
            'typeId' => $taxRateType->id
        ]);

        return response()->json($taxRate);
    }
}
