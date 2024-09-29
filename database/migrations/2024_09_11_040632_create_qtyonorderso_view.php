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
        DB::statement('DROP VIEW IF EXISTS `' . env('DB_DATABASE') . '`.`qtyonorderso`;');

        DB::statement('
        CREATE 
            ALGORITHM = UNDEFINED 
            DEFINER = `root`@`localhost` 
            SQL SECURITY DEFINER
        VIEW `' . env('DB_DATABASE') . '`.`qtyonorderso` AS
            SELECT 
                `' . env('DB_DATABASE') . '`.`part`.`id` AS `PARTID`,
                `' . env('DB_DATABASE') . '`.`so`.`locationGroupId` AS `LOCATIONGROUPID`,
                COALESCE(SUM((CASE
                            WHEN
                                ((`' . env('DB_DATABASE') . '`.`soitem`.`uomId` <> `' . env('DB_DATABASE') . '`.`part`.`uomId`)
                                    AND (`' . env('DB_DATABASE') . '`.`uomconversion`.`id` > 0))
                            THEN
                                (((`' . env('DB_DATABASE') . '`.`soitem`.`qtyToFulfill` - `' . env('DB_DATABASE') . '`.`soitem`.`qtyFulfilled`) * `' . env('DB_DATABASE') . '`.`uomconversion`.`multiply`) / `' . env('DB_DATABASE') . '`.`uomconversion`.`factor`)
                            ELSE (`' . env('DB_DATABASE') . '`.`soitem`.`qtyToFulfill` - `' . env('DB_DATABASE') . '`.`soitem`.`qtyFulfilled`)
                        END)),
                        0) AS `QTY`
            FROM
                ((((`' . env('DB_DATABASE') . '`.`part`
                JOIN `' . env('DB_DATABASE') . '`.`product` ON ((`' . env('DB_DATABASE') . '`.`part`.`id` = `' . env('DB_DATABASE') . '`.`product`.`partId`)))
                JOIN `' . env('DB_DATABASE') . '`.`soitem` ON ((`' . env('DB_DATABASE') . '`.`product`.`id` = `' . env('DB_DATABASE') . '`.`soitem`.`productId`)))
                JOIN `' . env('DB_DATABASE') . '`.`so` ON ((`' . env('DB_DATABASE') . '`.`so`.`id` = `' . env('DB_DATABASE') . '`.`soitem`.`soId`)))
                LEFT JOIN `' . env('DB_DATABASE') . '`.`uomconversion` ON (((`' . env('DB_DATABASE') . '`.`uomconversion`.`toUomId` = `' . env('DB_DATABASE') . '`.`part`.`uomId`)
                    AND (`' . env('DB_DATABASE') . '`.`uomconversion`.`fromUomId` = `' . env('DB_DATABASE') . '`.`soitem`.`uomId`))))
            WHERE
                ((`' . env('DB_DATABASE') . '`.`so`.`statusId` IN (20, 25))
                    AND (`' . env('DB_DATABASE') . '`.`soitem`.`statusId` IN (10, 14, 30))
                    AND (`' . env('DB_DATABASE') . '`.`soitem`.`typeId` = 20))
            GROUP BY `' . env('DB_DATABASE') . '`.`part`.`id`, `' . env('DB_DATABASE') . '`.`so`.`locationGroupId`
    ');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement('DROP VIEW IF EXISTS `' . env('DB_DATABASE') . '`.`qtyonorderso`;');
    }
};
