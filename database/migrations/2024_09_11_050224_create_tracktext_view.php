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
        DB::statement('DROP VIEW IF EXISTS `' . env('DB_DATABASE') . '`.`tracktext`;');

        DB::statement('
    CREATE 
    ALGORITHM = UNDEFINED 
    DEFINER = `root`@`localhost` 
    SQL SECURITY DEFINER
    VIEW `' . env('DB_DATABASE') . '`.`tracktext` AS
    SELECT 
        `' . env('DB_DATABASE') . '`.`trackingtext`.`tagId` AS `TAGID`,
        `' . env('DB_DATABASE') . '`.`parttracking`.`abbr` AS `ABBR`,
        `' . env('DB_DATABASE') . '`.`trackingtext`.`info` AS `INFO`
    FROM `' . env('DB_DATABASE') . '`.`trackingtext`
    JOIN `' . env('DB_DATABASE') . '`.`parttracking`
        ON `' . env('DB_DATABASE') . '`.`parttracking`.`id` = `' . env('DB_DATABASE') . '`.`trackingtext`.`partTrackingId`
');

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement('DROP VIEW IF EXISTS `' . env('DB_DATABASE') . '`.`tracktext`;');
    }
};
