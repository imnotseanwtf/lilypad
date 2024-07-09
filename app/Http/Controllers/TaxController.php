<?php

namespace App\Http\Controllers;

use App\Models\Tax;
use Illuminate\Http\Request;

class TaxController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $tax = Tax::firstOrCreate(['name' => $request->taxRateName]);

        return response()->json(
            [
                'tax_id' => $tax->id
            ]
        );
    }
}
