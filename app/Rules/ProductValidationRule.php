<?php

namespace App\Rules;

use App\Models\Part;
use App\Models\Product;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class ProductValidationRule implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $part = Part::where('num', $value)->first();

        if (!$part) {
            $fail('Part Number Does Not Exist');
        }

        if (Product::where('partId', $part->id)->exists()) {
            $fail('This Part is already taken');
        }
    }
}
