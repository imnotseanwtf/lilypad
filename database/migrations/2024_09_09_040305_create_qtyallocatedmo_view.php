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
VIEW `lilypad`.`qtyallocatedmo` AS
    SELECT 
        `lilypad`.`part`.`id` AS `PARTID`,
        `lilypad`.`wo`.`locationGroupId` AS `LOCATIONGROUPID`,
        COALESCE(SUM((CASE
                    WHEN
                        ((`lilypad`.`woitem`.`uomId` <> `lilypad`.`part`.`uomId`)
                            AND (`lilypad`.`uomconversion`.`id` > 0))
                    THEN
                        ((`lilypad`.`woitem`.`qtyTarget` * `lilypad`.`uomconversion`.`multiply`) / `lilypad`.`uomconversion`.`factor`)
                    ELSE `lilypad`.`woitem`.`qtyTarget`
                END)),
                0) AS `QTY`
    FROM
        (((`lilypad`.`part`
        JOIN `lilypad`.`woitem` ON ((`lilypad`.`part`.`id` = `lilypad`.`woitem`.`partId`)))
        JOIN `lilypad`.`wo` ON ((`lilypad`.`wo`.`id` = `lilypad`.`woitem`.`woId`)))
        LEFT JOIN `lilypad`.`uomconversion` ON (((`lilypad`.`uomconversion`.`toUomId` = `lilypad`.`part`.`uomId`)
            AND (`lilypad`.`uomconversion`.`fromUomId` = `lilypad`.`woitem`.`uomId`))))
    WHERE
        ((`lilypad`.`wo`.`statusId` < 40)
            AND (`lilypad`.`woitem`.`typeId` IN (20 , 30))
            AND (`lilypad`.`part`.`typeId` = 10))
    GROUP BY `lilypad`.`part`.`id` , `lilypad`.`wo`.`locationGroupId`
        '
        );
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('qtyallocatedmo_view');
    }
};
