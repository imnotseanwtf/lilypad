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
        DB::statement(
            'CREATE 
    ALGORITHM = UNDEFINED 
    DEFINER = `root`@`localhost` 
    SQL SECURITY DEFINER
VIEW `lilypad`.`qtyallocatedtoreceive` AS
    SELECT 
        `lilypad`.`part`.`id` AS `PARTID`,
        `lilypad`.`xo`.`shipToLGId` AS `LOCATIONGROUPID`,
        COALESCE(SUM((CASE
                    WHEN
                        ((`lilypad`.`xoitem`.`uomId` <> `lilypad`.`part`.`uomId`)
                            AND (`lilypad`.`uomconversion`.`id` > 0))
                    THEN
                        (((`lilypad`.`xoitem`.`qtyToFulfill` - `lilypad`.`xoitem`.`qtyFulfilled`) * `lilypad`.`uomconversion`.`multiply`) / `lilypad`.`uomconversion`.`factor`)
                    ELSE (`lilypad`.`xoitem`.`qtyToFulfill` - `lilypad`.`xoitem`.`qtyFulfilled`)
                END)),
                0) AS `QTY`
    FROM
        (((`lilypad`.`part`
        JOIN `lilypad`.`xoitem` ON ((`lilypad`.`part`.`id` = `lilypad`.`xoitem`.`partId`)))
        JOIN `lilypad`.`xo` ON ((`lilypad`.`xo`.`id` = `lilypad`.`xoitem`.`xoId`)))
        LEFT JOIN `lilypad`.`uomconversion` ON (((`lilypad`.`uomconversion`.`toUomId` = `lilypad`.`part`.`uomId`)
            AND (`lilypad`.`uomconversion`.`fromUomId` = `lilypad`.`xoitem`.`uomId`))))
    WHERE
        ((`lilypad`.`xo`.`statusId` IN (20 , 30, 40, 50, 60))
            AND (`lilypad`.`xoitem`.`statusId` IN (10 , 20, 30, 40, 50))
            AND (`lilypad`.`xoitem`.`typeId` = 20)
            AND (`lilypad`.`part`.`typeId` = 10))
    GROUP BY `lilypad`.`part`.`id` , `lilypad`.`xo`.`shipToLGId`');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('qtyallocatedtoreceive_view');
    }
};
