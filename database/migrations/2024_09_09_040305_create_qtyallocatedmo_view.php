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
        DB::statement('DROP VIEW IF EXISTS `' . env('DB_DATABASE') . '`.`qtyallocatedmo`;');

        DB::statement('
    CREATE 
    ALGORITHM = UNDEFINED 
    DEFINER = `root`@`localhost` 
    SQL SECURITY DEFINER
    VIEW `' . env('DB_DATABASE') . '`.`qtyallocatedmo` AS
    SELECT 
        `part`.`id` AS `PARTID`,
        `wo`.`locationGroupId` AS `LOCATIONGROUPID`,
        COALESCE(SUM((CASE
                    WHEN
                        ((`woitem`.`uomId` <> `part`.`uomId`)
                            AND (`uomconversion`.`id` > 0))
                    THEN
                        ((`woitem`.`qtyTarget` * `uomconversion`.`multiply`) / `uomconversion`.`factor`)
                    ELSE `woitem`.`qtyTarget`
                END)),
                0) AS `QTY`
    FROM
        `part`
    JOIN `woitem` ON `part`.`id` = `woitem`.`partId`
    JOIN `wo` ON `wo`.`id` = `woitem`.`woId`
    LEFT JOIN `uomconversion` ON `uomconversion`.`toUomId` = `part`.`uomId`
        AND `uomconversion`.`fromUomId` = `woitem`.`uomId`
    WHERE
        (`wo`.`statusId` < 40)
        AND (`woitem`.`typeId` IN (20, 30))
        AND (`part`.`typeId` = 10)
    GROUP BY `part`.`id`, `wo`.`locationGroupId`;
');

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement('DROP VIEW IF EXISTS `' . env('DB_DATABASE') . '`.`qtyallocatedmo`;');
    }
};
