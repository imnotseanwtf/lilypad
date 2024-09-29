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
        DB::statement('DROP VIEW IF EXISTS `' . env('DB_DATABASE') . '`.`tagtrackingview`;');

        DB::statement('
    CREATE 
    ALGORITHM = UNDEFINED 
    DEFINER = `root`@`localhost` 
    SQL SECURITY DEFINER
    VIEW `' . env('DB_DATABASE') . '`.`tagtrackingview` AS
    SELECT 
        pt.id AS PARTTRACKINGID,
        pt.name AS NAME,
        pt.abbr AS ABBR,
        pt.description AS DESCRIPTION,
        pt.sortOrder AS SORTORDER,
        pt.typeId AS TYPEID,
        t.id AS TAGID,
        t.partId AS PARTID,
        (CASE
            WHEN pt.typeId = 10 THEN tt.info
            WHEN pt.typeId IN (20, 30) THEN td.info
            WHEN pt.typeId IN (50, 60) THEN tdec.info
            WHEN pt.typeId IN (70, 80) THEN tint.info
            ELSE NULL
        END) AS INFO,
        (CASE
            WHEN pt.typeId = 10 THEN tt.info
            WHEN pt.typeId IN (20, 30) THEN CAST(td.info AS DATE)
            WHEN pt.typeId = 50 THEN CONCAT("$", ROUND(tdec.info, 2))
            WHEN pt.typeId = 60 THEN ROUND(tdec.info, 5)
            WHEN pt.typeId = 70 THEN tint.info
            WHEN pt.typeId = 80 THEN (CASE WHEN tint.info = 0 THEN "False" ELSE "True" END)
            ELSE NULL
        END) AS INFOFORMATTED,
        pt.activeFlag AS ACTIVEFLAG
    FROM
        `' . env('DB_DATABASE') . '`.tag t
    LEFT JOIN `' . env('DB_DATABASE') . '`.trackingtext tt ON t.id = tt.tagId
    LEFT JOIN `' . env('DB_DATABASE') . '`.trackinginteger tint ON t.id = tint.tagId
    LEFT JOIN `' . env('DB_DATABASE') . '`.trackingdecimal tdec ON t.id = tdec.tagId
    LEFT JOIN `' . env('DB_DATABASE') . '`.trackingdate td ON t.id = td.tagId
    LEFT JOIN (
        SELECT 
            s.tagId,
            sn.partTrackingId
        FROM `' . env('DB_DATABASE') . '`.serial s
        JOIN `' . env('DB_DATABASE') . '`.serialnum sn ON s.id = sn.serialId
        GROUP BY s.tagId, sn.partTrackingId
    ) serialnum ON t.id = serialnum.tagId
    LEFT JOIN `' . env('DB_DATABASE') . '`.parttracking pt ON (
        tt.partTrackingId = pt.id OR 
        tint.partTrackingId = pt.id OR 
        tdec.partTrackingId = pt.id OR 
        td.partTrackingId = pt.id OR 
        serialnum.partTrackingId = pt.id
    )
    WHERE pt.id IS NOT NULL
    GROUP BY pt.id, t.id
');


    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement('DROP VIEW IF EXISTS `' . env('DB_DATABASE') . '`.`tagtrackingview`;');
    }
};
