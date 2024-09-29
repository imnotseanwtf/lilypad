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
        DB::statement('DROP VIEW IF EXISTS `' . env('DB_DATABASE') . '`.`qtyonorderpo`;');

        DB::statement('
    CREATE 
        ALGORITHM = UNDEFINED 
        DEFINER = `root`@`localhost` 
        SQL SECURITY DEFINER
    VIEW `' . env('DB_DATABASE') . '`.`qtyonorderpo` AS
        SELECT 
            `' . env('DB_DATABASE') . '`.`part`.`id` AS `PARTID`,
            `' . env('DB_DATABASE') . '`.`receipt`.`locationGroupId` AS `LOCATIONGROUPID`,
            COALESCE(SUM((CASE
                        WHEN
                            ((`' . env('DB_DATABASE') . '`.`receiptitem`.`uomId` <> `' . env('DB_DATABASE') . '`.`part`.`uomId`)
                                AND (`' . env('DB_DATABASE') . '`.`uomconversion`.`id` > 0))
                        THEN
                            ((`' . env('DB_DATABASE') . '`.`receiptitem`.`qty` * `' . env('DB_DATABASE') . '`.`uomconversion`.`multiply`) / `' . env('DB_DATABASE') . '`.`uomconversion`.`factor`)
                        ELSE `' . env('DB_DATABASE') . '`.`receiptitem`.`qty`
                    END)),
                    0) AS `QTY`
        FROM
            (((`' . env('DB_DATABASE') . '`.`receipt`
            JOIN `' . env('DB_DATABASE') . '`.`receiptitem` ON ((`' . env('DB_DATABASE') . '`.`receipt`.`id` = `' . env('DB_DATABASE') . '`.`receiptitem`.`receiptId`)))
            JOIN `' . env('DB_DATABASE') . '`.`part` ON ((`' . env('DB_DATABASE') . '`.`part`.`id` = `' . env('DB_DATABASE') . '`.`receiptitem`.`partId`)))
            LEFT JOIN `' . env('DB_DATABASE') . '`.`uomconversion` ON (((`' . env('DB_DATABASE') . '`.`uomconversion`.`toUomId` = `' . env('DB_DATABASE') . '`.`part`.`uomId`)
                AND (`' . env('DB_DATABASE') . '`.`uomconversion`.`fromUomId` = `' . env('DB_DATABASE') . '`.`receiptitem`.`uomId`))))
        WHERE
            ((`' . env('DB_DATABASE') . '`.`receipt`.`orderTypeId` = 10)
                AND (`' . env('DB_DATABASE') . '`.`receiptitem`.`statusId` IN (10, 20)))
        GROUP BY `' . env('DB_DATABASE') . '`.`part`.`id`, `' . env('DB_DATABASE') . '`.`receipt`.`locationGroupId`
');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement('DROP VIEW IF EXISTS `' . env('DB_DATABASE') . '`.`qtyonorderpo`;');
    }
};
