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
        DB::statement('DROP VIEW IF EXISTS `' . env('DB_DATABASE') . '`.`shipcartonpoview`;');

        DB::statement('
    CREATE 
        ALGORITHM = UNDEFINED 
        DEFINER = `root`@`localhost` 
        SQL SECURITY DEFINER
    VIEW `' . env('DB_DATABASE') . '`.`shipcartonpoview` AS
        SELECT 
            `' . env('DB_DATABASE') . '`.`shipcarton`.`id` AS `SHIPCARTONID`,
            `' . env('DB_DATABASE') . '`.`shipcarton`.`orderId` AS `POID`
        FROM
            `' . env('DB_DATABASE') . '`.`shipcarton`
        WHERE
            (`' . env('DB_DATABASE') . '`.`shipcarton`.`orderTypeId` = 10);
');

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement('DROP VIEW IF EXISTS `' . env('DB_DATABASE') . '`.`shipcartonpoview`;');
    }
};
