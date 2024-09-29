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
        DB::statement(' DROP VIEW IF EXISTS `' . env('DB_DATABASE') . '`.`qtyonhand`;');

        DB::statement('

    CREATE VIEW `' . env('DB_DATABASE') . '`.`qtyonhand` AS
    SELECT 
        `tag`.`partId` AS `PARTID`,
        `location`.`locationGroupId` AS `LOCATIONGROUPID`,
        COALESCE(SUM(`tag`.`qty`), 0) AS `QTY`
    FROM
        `' . env('DB_DATABASE') . '`.`tag`
    JOIN `' . env('DB_DATABASE') . '`.`location` 
        ON `location`.`id` = `tag`.`locationId`
    WHERE
        `tag`.`typeId` IN (30, 40)
    GROUP BY 
        `location`.`locationGroupId`, 
        `tag`.`partId`;
');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement(' DROP VIEW IF EXISTS `' . env('DB_DATABASE') . '`.`qtyonhand`;');
    }
};
