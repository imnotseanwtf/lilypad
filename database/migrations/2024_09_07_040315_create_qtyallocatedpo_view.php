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
        DB::statement('DROP VIEW IF EXISTS `' . env('DB_DATABASE') . '`.`qtyallocatedpo`;');

        DB::statement('

    CREATE ALGORITHM = UNDEFINED 
    DEFINER = `root`@`localhost` 
    SQL SECURITY DEFINER
    VIEW `' . env('DB_DATABASE') . '`.`qtyallocatedpo` AS
    SELECT 
        `part`.`id` AS `PARTID`,
        `po`.`locationGroupId` AS `LOCATIONGROUPID`,
        COALESCE(SUM((CASE
                    WHEN
                        ((`poitem`.`uomId` <> `part`.`uomId`)
                            AND (`uomconversion`.`id` > 0))
                    THEN
                        (((`poitem`.`qtyToFulfill` - `poitem`.`qtyFulfilled`) * `uomconversion`.`multiply`) / `uomconversion`.`factor`)
                    ELSE (`poitem`.`qtyToFulfill` - `poitem`.`qtyFulfilled`)
                END)),
                0) AS `QTY`
    FROM
        `part`
    JOIN `poitem` ON `part`.`id` = `poitem`.`partId`
    JOIN `po` ON `po`.`id` = `poitem`.`poId`
    LEFT JOIN `uomconversion` ON `uomconversion`.`toUomId` = `part`.`uomId`
        AND `uomconversion`.`fromUomId` = `poitem`.`uomId`
    WHERE
        (`po`.`statusId` BETWEEN 20 AND 55)
        AND (`poitem`.`statusId` IN (10, 20, 30, 40, 45))
        AND (`poitem`.`typeId` IN (20, 30))
        AND (`part`.`typeId` = 10)
    GROUP BY `part`.`id`, `po`.`locationGroupId`;
');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement('DROP VIEW IF EXISTS `' . env('DB_DATABASE') . '`.`qtyallocatedpo`;');
    }
};
