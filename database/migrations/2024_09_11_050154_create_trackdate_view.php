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
        DB::statement('DROP VIEW IF EXISTS `' . env('DB_DATABASE') . '`.`trackdate`;');

        DB::statement('
    CREATE 
    ALGORITHM = UNDEFINED 
    DEFINER = `root`@`localhost` 
    SQL SECURITY DEFINER
    VIEW `' . env('DB_DATABASE') . '`.`trackdate` AS
    SELECT 
        td.tagId AS TAGID,
        pt.abbr AS ABBR,
        td.info AS INFO
    FROM `' . env('DB_DATABASE') . '`.trackingdate td
    JOIN `' . env('DB_DATABASE') . '`.parttracking pt ON pt.id = td.partTrackingId
');


    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement('DROP VIEW IF EXISTS `' . env('DB_DATABASE') . '`.`trackdate`;');
    }
};
