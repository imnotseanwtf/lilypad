<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::statement('DROP VIEW IF EXISTS `' . env('DB_DATABASE') . '`.`qtyonordertoreceive`;');

        DB::statement('
    CREATE 
        ALGORITHM = UNDEFINED 
        DEFINER = `root`@`localhost` 
        SQL SECURITY DEFINER
    VIEW `' . env('DB_DATABASE') . '`.`qtyonordertoreceive` AS
        SELECT 
            `' . env('DB_DATABASE') . '`.`part`.`id` AS `PARTID`,
            `' . env('DB_DATABASE') . '`.`xo`.`fromLGId` AS `LOCATIONGROUPID`,
            COALESCE(SUM((CASE
                        WHEN
                            ((`' . env('DB_DATABASE') . '`.`xoitem`.`uomId` <> `' . env('DB_DATABASE') . '`.`part`.`uomId`)
                                AND (`' . env('DB_DATABASE') . '`.`uomconversion`.`id` > 0))
                        THEN
                            (((`' . env('DB_DATABASE') . '`.`xoitem`.`qtyToFulfill` - `' . env('DB_DATABASE') . '`.`xoitem`.`qtyFulfilled`) * `' . env('DB_DATABASE') . '`.`uomconversion`.`multiply`) / `' . env('DB_DATABASE') . '`.`uomconversion`.`factor`)
                        ELSE (`' . env('DB_DATABASE') . '`.`xoitem`.`qtyToFulfill` - `' . env('DB_DATABASE') . '`.`xoitem`.`qtyFulfilled`)
                    END)),
                    0) AS `QTY`
        FROM
            (((`' . env('DB_DATABASE') . '`.`part`
            JOIN `' . env('DB_DATABASE') . '`.`xoitem` ON ((`' . env('DB_DATABASE') . '`.`part`.`id` = `' . env('DB_DATABASE') . '`.`xoitem`.`partId`)))
            JOIN `' . env('DB_DATABASE') . '`.`xo` ON ((`' . env('DB_DATABASE') . '`.`xo`.`id` = `' . env('DB_DATABASE') . '`.`xoitem`.`xoId`)))
            LEFT JOIN `' . env('DB_DATABASE') . '`.`uomconversion` ON (((`' . env('DB_DATABASE') . '`.`uomconversion`.`toUomId` = `' . env('DB_DATABASE') . '`.`part`.`uomId`)
                AND (`' . env('DB_DATABASE') . '`.`uomconversion`.`fromUomId` = `' . env('DB_DATABASE') . '`.`xoitem`.`uomId`))))
        WHERE
            ((`' . env('DB_DATABASE') . '`.`xo`.`statusId` IN (20 , 30, 40, 50, 60))
                AND (`' . env('DB_DATABASE') . '`.`xoitem`.`statusId` IN (10 , 20, 30, 40, 50))
                AND (`' . env('DB_DATABASE') . '`.`xoitem`.`typeId` = 20))
        GROUP BY `' . env('DB_DATABASE') . '`.`part`.`id`, `' . env('DB_DATABASE') . '`.`xo`.`fromLGId`
');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement('DROP VIEW IF EXISTS `' . env('DB_DATABASE') . '`.`qtyonordertoreceive`;');
    }
};
