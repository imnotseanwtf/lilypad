<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Config;

class SerialNumber extends Model
{
    protected $table = 'serialnum';

    use HasFactory;

    protected $fillable =
    [
        'serialId',
        'serialNum',
        'partTrackingId'
    ];

    /**
     * Generate and save a unique serial number.
     *
     * @return string
     */

    public static function createUniqueSerialNumbers($partTrackingId, $serialId, $qty): array
    {
        $prefixes = Config::get('serial_numbers.prefixes');
        $serialLength = Config::get('serial_numbers.serial_length');

        $serialNumbers = array_map(function () use ($prefixes, $serialLength, $partTrackingId, $serialId) {
            do {
                $prefix = $prefixes[array_rand($prefixes)];
                $uniquePart = self::generateUniquePart($serialLength);
                $serialNumber = "{$prefix}-{$uniquePart}";
            } while (self::where('serialNum', $serialNumber)->exists());

            self::create([
                'serialNum' => $serialNumber,
                'partTrackingId' => $partTrackingId,
                'serialId' => $serialId
            ]);

            return $serialNumber;
        }, range(1, $qty));

        return $serialNumbers;
    }

    /**
     * Generate a unique part of the serial number.
     *
     * @param int $length
     * @return string
     */

    private static function generateUniquePart(int $length): string
    {
        return str_pad(rand(0, pow(10, $length) - 1), $length, '0', STR_PAD_LEFT);
    }

    public $timestamps = false;
}
