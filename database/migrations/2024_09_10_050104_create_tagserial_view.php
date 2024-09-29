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
        DB::statement('DROP VIEW IF EXISTS `' . env('DB_DATABASE') . '`.`tagserialview`;');

        DB::statement('
        CREATE 
        ALGORITHM = UNDEFINED 
        DEFINER = `root`@`localhost` 
        SQL SECURITY DEFINER
        VIEW `' . env('DB_DATABASE') . '`.`tagserialview` AS
        SELECT 
            `' . env('DB_DATABASE') . '`.`serialnum`.`partTrackingId` AS `PARTTRACKINGID`,
            `' . env('DB_DATABASE') . '`.`serial`.`id` AS `SERIALID`,
            `' . env('DB_DATABASE') . '`.`parttracking`.`name` AS `NAME`,
            `' . env('DB_DATABASE') . '`.`parttracking`.`abbr` AS `ABBR`,
            `' . env('DB_DATABASE') . '`.`parttracking`.`description` AS `DESCRIPTION`,
            `' . env('DB_DATABASE') . '`.`parttracking`.`sortOrder` AS `SORTORDER`,
            `' . env('DB_DATABASE') . '`.`parttracking`.`typeId` AS `TYPEID`,
            `' . env('DB_DATABASE') . '`.`serial`.`tagId` AS `TAGID`,
            `' . env('DB_DATABASE') . '`.`serialnum`.`id` AS `SERIALNUMID`,
            `' . env('DB_DATABASE') . '`.`serialnum`.`serialNum` AS `SERIALNUM`,
            `' . env('DB_DATABASE') . '`.`serial`.`committedFlag` AS `COMMITTEDFLAG`,
            `' . env('DB_DATABASE') . '`.`parttracking`.`activeFlag` AS `ACTIVEFLAG`
        FROM
            (`' . env('DB_DATABASE') . '`.`serial`
            JOIN `' . env('DB_DATABASE') . '`.`serialnum` ON (`' . env('DB_DATABASE') . '`.`serialnum`.`serialId` = `' . env('DB_DATABASE') . '`.`serial`.`id`)
            JOIN `' . env('DB_DATABASE') . '`.`parttracking` ON (`' . env('DB_DATABASE') . '`.`parttracking`.`id` = `' . env('DB_DATABASE') . '`.`serialnum`.`partTrackingId`)
        )
    ');
    
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement('DROP VIEW IF EXISTS `' . env('DB_DATABASE') . '`.`tagserialview`;');
    }
};
