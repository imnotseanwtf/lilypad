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
        DB::statement('DROP VIEW IF EXISTS `' . env('DB_DATABASE') . '`.`qtyonordermo`;');

        DB::statement('
    CREATE 
        ALGORITHM = UNDEFINED 
        DEFINER = `root`@`localhost` 
        SQL SECURITY DEFINER
    VIEW `' . env('DB_DATABASE') . '`.`qtyonordermo` AS
        SELECT 
            `' . env('DB_DATABASE') . '`.`part`.`id` AS `PARTID`,
            `' . env('DB_DATABASE') . '`.`wo`.`locationGroupId` AS `LOCATIONGROUPID`,
            COALESCE(SUM((CASE
                        WHEN
                            ((`' . env('DB_DATABASE') . '`.`woitem`.`uomId` <> `' . env('DB_DATABASE') . '`.`part`.`uomId`)
                                AND (`' . env('DB_DATABASE') . '`.`uomconversion`.`id` > 0))
                        THEN
                            ((`' . env('DB_DATABASE') . '`.`woitem`.`qtyTarget` * `' . env('DB_DATABASE') . '`.`uomconversion`.`multiply`) / `' . env('DB_DATABASE') . '`.`uomconversion`.`factor`)
                        ELSE `' . env('DB_DATABASE') . '`.`woitem`.`qtyTarget`
                    END)),
                    0) AS `QTY`
        FROM
            (((`' . env('DB_DATABASE') . '`.`part`
            JOIN `' . env('DB_DATABASE') . '`.`woitem` ON ((`' . env('DB_DATABASE') . '`.`part`.`id` = `' . env('DB_DATABASE') . '`.`woitem`.`partId`)))
            JOIN `' . env('DB_DATABASE') . '`.`wo` ON ((`' . env('DB_DATABASE') . '`.`wo`.`id` = `' . env('DB_DATABASE') . '`.`woitem`.`woId`)))
            LEFT JOIN `' . env('DB_DATABASE') . '`.`uomconversion` ON (((`' . env('DB_DATABASE') . '`.`uomconversion`.`toUomId` = `' . env('DB_DATABASE') . '`.`part`.`uomId`)
                AND (`' . env('DB_DATABASE') . '`.`uomconversion`.`fromUomId` = `' . env('DB_DATABASE') . '`.`woitem`.`uomId`))))
        WHERE
            ((`' . env('DB_DATABASE') . '`.`wo`.`statusId` < 40)
                AND (`' . env('DB_DATABASE') . '`.`woitem`.`typeId` IN (10 , 31)))
        GROUP BY `' . env('DB_DATABASE') . '`.`part`.`id`, `' . env('DB_DATABASE') . '`.`wo`.`locationGroupId`;
');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement('DROP VIEW IF EXISTS `' . env('DB_DATABASE') . '`.`qtyonordermo`;');
    }
};
