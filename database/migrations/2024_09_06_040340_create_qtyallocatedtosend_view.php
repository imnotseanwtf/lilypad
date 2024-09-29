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
        DB::statement(' DROP VIEW IF EXISTS `' . env('DB_DATABASE') . '`.`qtyallocatedtosend`;');

        DB::statement('
        CREATE 
            ALGORITHM = UNDEFINED 
            DEFINER = `root`@`localhost` 
            SQL SECURITY DEFINER
        VIEW `' . env('DB_DATABASE') . '`.`qtyallocatedtosend` AS
            SELECT 
                `part`.`id` AS `PARTID`,
                `xo`.`fromLGId` AS `LOCATIONGROUPID`,
                COALESCE(SUM(CASE
                    WHEN (`xoitem`.`uomId` <> `part`.`uomId` AND `uomconversion`.`id` > 0) THEN
                        ((`xoitem`.`qtyToFulfill` - `xoitem`.`qtyFulfilled`) * `uomconversion`.`multiply` / `uomconversion`.`factor`)
                    ELSE 
                        (`xoitem`.`qtyToFulfill` - `xoitem`.`qtyFulfilled`)
                END), 0) AS `QTY`
            FROM
                `' . env('DB_DATABASE') . '`.`part`
            JOIN `' . env('DB_DATABASE') . '`.`xoitem` ON `part`.`id` = `xoitem`.`partId`
            JOIN `' . env('DB_DATABASE') . '`.`xo` ON `xo`.`id` = `xoitem`.`xoId`
            LEFT JOIN `' . env('DB_DATABASE') . '`.`uomconversion` ON `uomconversion`.`toUomId` = `part`.`uomId` 
                AND `uomconversion`.`fromUomId` = `xoitem`.`uomId`
            WHERE
                `xo`.`statusId` IN (20, 30, 40, 50, 60) AND 
                `xoitem`.`statusId` IN (10, 20, 30, 40, 50) AND 
                `xoitem`.`typeId` = 10 AND 
                `part`.`typeId` = 10
            GROUP BY `part`.`id`, `xo`.`fromLGId`;
    ');
    
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement(' DROP VIEW IF EXISTS `' . env('DB_DATABASE') . '`.`qtyallocatedtosend`;');
    }
};
