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
        DB::statement(' DROP VIEW IF EXISTS `' . env('DB_DATABASE') . '`.`invlogtrackingsummary`;');

        DB::statement('
    CREATE 
    ALGORITHM = UNDEFINED 
    DEFINER = `root`@`localhost` 
    SQL SECURITY DEFINER
    VIEW `' . env('DB_DATABASE') . '`.`invlogtrackingsummary` AS
    SELECT 
        `parTrackInfo`.`invLogID` AS `INVLOGID`,
        GROUP_CONCAT(`parTrackInfo`.`trackValue`, ", " SEPARATOR ",") AS `TRACKVALUE`
    FROM
        (SELECT 
            `tiinventorylog`.`inventoryLogId` AS `invLogID`,
            CONCAT(`parttracking`.`abbr`, ": ", GROUP_CONCAT(
                CASE
                    WHEN (`parttracking`.`typeId` = 20) THEN `tiinventorylog`.`info`
                    WHEN (`parttracking`.`typeId` = 30) THEN `tiinventorylog`.`infoDate`
                    WHEN (`parttracking`.`typeId` = 50) THEN `tiinventorylog`.`infoDouble`
                    WHEN (`parttracking`.`typeId` = 60) THEN `tiinventorylog`.`infoDouble`
                    WHEN (`parttracking`.`typeId` = 70) THEN `tiinventorylog`.`infoInteger`
                    WHEN (`parttracking`.`typeId` = 80) THEN `tiinventorylog`.`infoInteger`
                    ELSE `tiinventorylog`.`info`
                END
                SEPARATOR ","
            )) AS `trackValue`
        FROM
            `tiinventorylog`
        JOIN `parttracking` ON `tiinventorylog`.`partTrackingId` = `parttracking`.`id`
        GROUP BY `tiinventorylog`.`inventoryLogId`, `parttracking`.`abbr`, `parttracking`.`sortOrder`
        ORDER BY `parttracking`.`sortOrder`
        ) `parTrackInfo`
    GROUP BY `parTrackInfo`.`invLogID`
');

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement(' DROP VIEW IF EXISTS `' . env('DB_DATABASE') . '`.`invlogtrackingsummary`;');
    }
};
