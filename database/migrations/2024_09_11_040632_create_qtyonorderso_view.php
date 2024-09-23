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
CREATE 
    ALGORITHM = UNDEFINED 
    DEFINER = `root`@`localhost` 
    SQL SECURITY DEFINER
VIEW `lilypad`.`qtyonorderso` AS
    SELECT 
        `lilypad`.`part`.`id` AS `PARTID`,
        `lilypad`.`so`.`locationGroupId` AS `LOCATIONGROUPID`,
        COALESCE(SUM((CASE
                    WHEN
                        ((`lilypad`.`soitem`.`uomId` <> `lilypad`.`part`.`uomId`)
                            AND (`lilypad`.`uomconversion`.`id` > 0))
                    THEN
                        (((`lilypad`.`soitem`.`qtyToFulfill` - `lilypad`.`soitem`.`qtyFulfilled`) * `lilypad`.`uomconversion`.`multiply`) / `lilypad`.`uomconversion`.`factor`)
                    ELSE (`lilypad`.`soitem`.`qtyToFulfill` - `lilypad`.`soitem`.`qtyFulfilled`)
                END)),
                0) AS `QTY`
    FROM
        ((((`lilypad`.`part`
        JOIN `lilypad`.`product` ON ((`lilypad`.`part`.`id` = `lilypad`.`product`.`partId`)))
        JOIN `lilypad`.`soitem` ON ((`lilypad`.`product`.`id` = `lilypad`.`soitem`.`productId`)))
        JOIN `lilypad`.`so` ON ((`lilypad`.`so`.`id` = `lilypad`.`soitem`.`soId`)))
        LEFT JOIN `lilypad`.`uomconversion` ON (((`lilypad`.`uomconversion`.`toUomId` = `lilypad`.`part`.`uomId`)
            AND (`lilypad`.`uomconversion`.`fromUomId` = `lilypad`.`soitem`.`uomId`))))
    WHERE
        ((`lilypad`.`so`.`statusId` IN (20, 25))
            AND (`lilypad`.`soitem`.`statusId` IN (10, 14, 30))
            AND (`lilypad`.`soitem`.`typeId` = 20))
    GROUP BY `lilypad`.`part`.`id`, `lilypad`.`so`.`locationGroupId`
');

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('qtyonorderso_view');
    }
};
