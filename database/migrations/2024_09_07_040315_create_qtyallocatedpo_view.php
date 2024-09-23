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
        DB::statement('
    CREATE ALGORITHM = UNDEFINED 
    DEFINER = `root`@`localhost` 
    SQL SECURITY DEFINER
    VIEW `lilypad`.`qtyallocatedpo` AS
    SELECT 
        `lilypad`.`part`.`id` AS `PARTID`,
        `lilypad`.`po`.`locationGroupId` AS `LOCATIONGROUPID`,
        COALESCE(SUM((CASE
                    WHEN
                        ((`lilypad`.`poitem`.`uomId` <> `lilypad`.`part`.`uomId`)
                            AND (`lilypad`.`uomconversion`.`id` > 0))
                    THEN
                        (((`lilypad`.`poitem`.`qtyToFulfill` - `lilypad`.`poitem`.`qtyFulfilled`) * `lilypad`.`uomconversion`.`multiply`) / `lilypad`.`uomconversion`.`factor`)
                    ELSE (`lilypad`.`poitem`.`qtyToFulfill` - `lilypad`.`poitem`.`qtyFulfilled`)
                END)),
                0) AS `QTY`
    FROM
        (((`lilypad`.`part`
        JOIN `lilypad`.`poitem` ON ((`lilypad`.`part`.`id` = `lilypad`.`poitem`.`partId`)))
        JOIN `lilypad`.`po` ON ((`lilypad`.`po`.`id` = `lilypad`.`poitem`.`poId`)))
        LEFT JOIN `lilypad`.`uomconversion` ON (((`lilypad`.`uomconversion`.`toUomId` = `lilypad`.`part`.`uomId`)
            AND (`lilypad`.`uomconversion`.`fromUomId` = `lilypad`.`poitem`.`uomId`))))
    WHERE
        ((`lilypad`.`po`.`statusId` BETWEEN 20 AND 55)
            AND (`lilypad`.`poitem`.`statusId` IN (10, 20, 30, 40, 45))
            AND (`lilypad`.`poitem`.`typeId` IN (20, 30))
            AND (`lilypad`.`part`.`typeId` = 10))
    GROUP BY `lilypad`.`part`.`id`, `lilypad`.`po`.`locationGroupId`
');

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('qtyallocatedpo_view');
    }
};
