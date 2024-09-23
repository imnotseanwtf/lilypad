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
VIEW `lilypad`.`qtyonorderpo` AS
    SELECT 
        `lilypad`.`part`.`id` AS `PARTID`,
        `lilypad`.`receipt`.`locationGroupId` AS `LOCATIONGROUPID`,
        COALESCE(SUM((CASE
                    WHEN
                        ((`lilypad`.`receiptitem`.`uomId` <> `lilypad`.`part`.`uomId`)
                            AND (`lilypad`.`uomconversion`.`id` > 0))
                    THEN
                        ((`lilypad`.`receiptitem`.`qty` * `lilypad`.`uomconversion`.`multiply`) / `lilypad`.`uomconversion`.`factor`)
                    ELSE `lilypad`.`receiptitem`.`qty`
                END)),
                0) AS `QTY`
    FROM
        (((`lilypad`.`receipt`
        JOIN `lilypad`.`receiptitem` ON ((`lilypad`.`receipt`.`id` = `lilypad`.`receiptitem`.`receiptId`)))
        JOIN `lilypad`.`part` ON ((`lilypad`.`part`.`id` = `lilypad`.`receiptitem`.`partId`)))
        LEFT JOIN `lilypad`.`uomconversion` ON (((`lilypad`.`uomconversion`.`toUomId` = `lilypad`.`part`.`uomId`)
            AND (`lilypad`.`uomconversion`.`fromUomId` = `lilypad`.`receiptitem`.`uomId`))))
    WHERE
        ((`lilypad`.`receipt`.`orderTypeId` = 10)
            AND (`lilypad`.`receiptitem`.`statusId` IN (10, 20)))
    GROUP BY `lilypad`.`part`.`id`, `lilypad`.`receipt`.`locationGroupId`
');

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('qtyonorderpo_view');
    }
};
