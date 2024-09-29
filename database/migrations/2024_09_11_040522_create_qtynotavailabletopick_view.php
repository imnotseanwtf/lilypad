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
        DB::statement('DROP VIEW IF EXISTS `' . env('DB_DATABASE') . '`.`qtynotavailabletopick`;');

        DB::statement('
        CREATE 
        ALGORITHM = UNDEFINED 
        DEFINER = `root`@`localhost` 
        SQL SECURITY DEFINER
        VIEW `' . env('DB_DATABASE') . '`.`qtynotavailabletopick` AS
        SELECT 
            `' . env('DB_DATABASE') . '`.`tag`.`partId` AS `PARTID`,
            `' . env('DB_DATABASE') . '`.`location`.`locationGroupId` AS `LOCATIONGROUPID`,
            COALESCE(SUM((`' . env('DB_DATABASE') . '`.`tag`.`qty` - `' . env('DB_DATABASE') . '`.`tag`.`qtyCommitted`)),
                    0) AS `QTY`
        FROM
            (`' . env('DB_DATABASE') . '`.`tag`
            JOIN `' . env('DB_DATABASE') . '`.`location` ON ((`' . env('DB_DATABASE') . '`.`location`.`id` = `' . env('DB_DATABASE') . '`.`tag`.`locationId`)))
        WHERE
            ((`' . env('DB_DATABASE') . '`.`tag`.`typeId` IN (30 , 40))
                AND (`' . env('DB_DATABASE') . '`.`location`.`pickable` = 0)
                AND (`' . env('DB_DATABASE') . '`.`location`.`typeId` <> 100))
        GROUP BY `' . env('DB_DATABASE') . '`.`location`.`locationGroupId`, `' . env('DB_DATABASE') . '`.`tag`.`partId`');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement('DROP VIEW IF EXISTS `' . env('DB_DATABASE') . '`.`qtynotavailabletopick`;');
    }
};
