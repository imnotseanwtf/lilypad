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
        DB::statement('DROP VIEW IF EXISTS `' . env('DB_DATABASE') . '`.`qohview`;');

        DB::statement('
    CREATE 
    ALGORITHM = UNDEFINED 
    DEFINER = `root`@`localhost` 
    SQL SECURITY DEFINER
    VIEW `' . env('DB_DATABASE') . '`.`qohview` AS
    SELECT 
        `' . env('DB_DATABASE') . '`.`location`.`locationGroupId` AS `LOCATIONGROUPID`,
        `' . env('DB_DATABASE') . '`.`tag`.`locationId` AS `LOCATIONID`,
        `' . env('DB_DATABASE') . '`.`tag`.`partId` AS `PARTID`,
        `' . env('DB_DATABASE') . '`.`tag`.`num` AS `TAGNUM`,
        `' . env('DB_DATABASE') . '`.`tagserialview`.`SERIALNUM` AS `SERIALNUM`,
        (((1 - `' . env('DB_DATABASE') . '`.`tag`.`qty`) * (COUNT(`' . env('DB_DATABASE') . '`.`tagserialview`.`SERIALNUM`) - 1)) + 1) AS `QTY`
    FROM
        (`' . env('DB_DATABASE') . '`.`location`
        JOIN (`' . env('DB_DATABASE') . '`.`tag`
        LEFT JOIN `' . env('DB_DATABASE') . '`.`tagserialview` ON ((`' . env('DB_DATABASE') . '`.`tagserialview`.`TAGID` = `' . env('DB_DATABASE') . '`.`tag`.`id`))))
    WHERE
        (`' . env('DB_DATABASE') . '`.`location`.`id` = `' . env('DB_DATABASE') . '`.`tag`.`locationId`)
    GROUP BY `' . env('DB_DATABASE') . '`.`location`.`locationGroupId`, `' . env('DB_DATABASE') . '`.`tag`.`locationId`, `' . env('DB_DATABASE') . '`.`tag`.`partId`, `' . env('DB_DATABASE') . '`.`tag`.`num`, `' . env('DB_DATABASE') . '`.`tagserialview`.`SERIALNUM`, `' . env('DB_DATABASE') . '`.`tag`.`qty`
');

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement('DROP VIEW IF EXISTS `' . env('DB_DATABASE') . '`.`qohview`;');
    }
};
