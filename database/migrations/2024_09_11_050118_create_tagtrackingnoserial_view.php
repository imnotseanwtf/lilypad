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
        DB::statement('DROP VIEW IF EXISTS `' . env('DB_DATABASE') . '`.`tagtrackingnoserialview`;');

        DB::statement('
    CREATE 
    ALGORITHM = UNDEFINED 
    DEFINER = `root`@`localhost` 
    SQL SECURITY DEFINER
    VIEW `' . env('DB_DATABASE') . '`.`tagtrackingnoserialview` AS
    SELECT 
        `' . env('DB_DATABASE') . '`.`parttracking`.`id` AS `PARTTRACKINGID`,
        `' . env('DB_DATABASE') . '`.`parttracking`.`name` AS `NAME`,
        `' . env('DB_DATABASE') . '`.`parttracking`.`abbr` AS `ABBR`,
        `' . env('DB_DATABASE') . '`.`parttracking`.`description` AS `DESCRIPTION`,
        `' . env('DB_DATABASE') . '`.`parttracking`.`sortOrder` AS `SORTORDER`,
        `' . env('DB_DATABASE') . '`.`parttracking`.`typeId` AS `TYPEID`,
        `' . env('DB_DATABASE') . '`.`tag`.`id` AS `TAGID`,
        `' . env('DB_DATABASE') . '`.`tag`.`partId` AS `PARTID`,
        (CASE
            WHEN (`' . env('DB_DATABASE') . '`.`parttracking`.`typeId` = 10) THEN `' . env('DB_DATABASE') . '`.`trackingtext`.`info`
            WHEN (`' . env('DB_DATABASE') . '`.`parttracking`.`typeId` IN (20, 30)) THEN
                `' . env('DB_DATABASE') . '`.`trackingdate`.`info`
            WHEN (`' . env('DB_DATABASE') . '`.`parttracking`.`typeId` IN (50, 60)) THEN
                `' . env('DB_DATABASE') . '`.`trackingdecimal`.`info`
            WHEN (`' . env('DB_DATABASE') . '`.`parttracking`.`typeId` IN (70, 80)) THEN
                `' . env('DB_DATABASE') . '`.`trackinginteger`.`info`
            ELSE 0
        END) AS `INFO`,
        (CASE
            WHEN (`' . env('DB_DATABASE') . '`.`parttracking`.`typeId` = 10) THEN `' . env('DB_DATABASE') . '`.`trackingtext`.`info`
            WHEN (`' . env('DB_DATABASE') . '`.`parttracking`.`typeId` IN (20, 30)) THEN
                CAST(`' . env('DB_DATABASE') . '`.`trackingdate`.`info` AS DATE)
            WHEN (`' . env('DB_DATABASE') . '`.`parttracking`.`typeId` = 50) THEN
                CONCAT("$", ROUND(`' . env('DB_DATABASE') . '`.`trackingdecimal`.`info`, 2))
            WHEN (`' . env('DB_DATABASE') . '`.`parttracking`.`typeId` = 60) THEN
                ROUND(`' . env('DB_DATABASE') . '`.`trackingdecimal`.`info`, 5)
            WHEN (`' . env('DB_DATABASE') . '`.`parttracking`.`typeId` = 70) THEN
                `' . env('DB_DATABASE') . '`.`trackinginteger`.`info`
            WHEN (`' . env('DB_DATABASE') . '`.`parttracking`.`typeId` = 80) THEN
                (CASE
                    WHEN (`' . env('DB_DATABASE') . '`.`trackinginteger`.`info` = 0) THEN "False"
                    ELSE "True"
                END)
            ELSE 0
        END) AS `INFOFORMATTED`,
        `' . env('DB_DATABASE') . '`.`parttracking`.`activeFlag` AS `ACTIVEFLAG`
    FROM
        (((((`' . env('DB_DATABASE') . '`.`tag`
        LEFT JOIN `' . env('DB_DATABASE') . '`.`trackingtext` ON (`' . env('DB_DATABASE') . '`.`tag`.`id` = `' . env('DB_DATABASE') . '`.`trackingtext`.`tagId`))
        LEFT JOIN `' . env('DB_DATABASE') . '`.`trackinginteger` ON (`' . env('DB_DATABASE') . '`.`tag`.`id` = `' . env('DB_DATABASE') . '`.`trackinginteger`.`tagId`))
        LEFT JOIN `' . env('DB_DATABASE') . '`.`trackingdecimal` ON (`' . env('DB_DATABASE') . '`.`tag`.`id` = `' . env('DB_DATABASE') . '`.`trackingdecimal`.`tagId`))
        LEFT JOIN `' . env('DB_DATABASE') . '`.`trackingdate` ON (`' . env('DB_DATABASE') . '`.`tag`.`id` = `' . env('DB_DATABASE') . '`.`trackingdate`.`tagId`))
        LEFT JOIN `' . env('DB_DATABASE') . '`.`parttracking` ON (((`' . env('DB_DATABASE') . '`.`trackingtext`.`partTrackingId` = `' . env('DB_DATABASE') . '`.`parttracking`.`id`)
            OR (`' . env('DB_DATABASE') . '`.`trackinginteger`.`partTrackingId` = `' . env('DB_DATABASE') . '`.`parttracking`.`id`)
            OR (`' . env('DB_DATABASE') . '`.`trackingdecimal`.`partTrackingId` = `' . env('DB_DATABASE') . '`.`parttracking`.`id`)
            OR (`' . env('DB_DATABASE') . '`.`trackingdate`.`partTrackingId` = `' . env('DB_DATABASE') . '`.`parttracking`.`id`))))
    WHERE
        (`' . env('DB_DATABASE') . '`.`parttracking`.`id` IS NOT NULL)
    GROUP BY 
        `' . env('DB_DATABASE') . '`.`parttracking`.`id`, 
        `' . env('DB_DATABASE') . '`.`tag`.`id`
');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement('DROP VIEW IF EXISTS `' . env('DB_DATABASE') . '`.`tagtrackingnoserialview`;');
    }
};
