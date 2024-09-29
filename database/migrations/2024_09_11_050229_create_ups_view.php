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
        DB::statement('DROP VIEW IF EXISTS `' . env('DB_DATABASE') . '`.`upsview`;');

        DB::statement('
        CREATE 
        ALGORITHM = UNDEFINED 
        DEFINER = `root`@`localhost` 
        SQL SECURITY DEFINER
        VIEW `' . env('DB_DATABASE') . '`.`upsview` AS
        SELECT 
            `' . env('DB_DATABASE') . '`.`ship`.`id` AS `ID`,
            `' . env('DB_DATABASE') . '`.`so`.`num` AS `ORDERNUM`,
            `' . env('DB_DATABASE') . '`.`ship`.`soId` AS `ORDERID`,
            `' . env('DB_DATABASE') . '`.`ship`.`carrierId` AS `CARRIERID`,
            `' . env('DB_DATABASE') . '`.`ship`.`carrierServiceId` AS `CARRIERSERVICEID`
        FROM
            ((`' . env('DB_DATABASE') . '`.`ship`
            JOIN `' . env('DB_DATABASE') . '`.`carrier` ON ((`' . env('DB_DATABASE') . '`.`carrier`.`id` = `' . env('DB_DATABASE') . '`.`ship`.`carrierId`)))
            JOIN `' . env('DB_DATABASE') . '`.`so` ON ((`' . env('DB_DATABASE') . '`.`so`.`id` = `' . env('DB_DATABASE') . '`.`ship`.`soId`)))
        WHERE
            ((`' . env('DB_DATABASE') . '`.`carrier`.`name` LIKE \'UPS%\')
                AND (`' . env('DB_DATABASE') . '`.`ship`.`statusId` = 20))
    ');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement('DROP VIEW IF EXISTS `' . env('DB_DATABASE') . '`.`upsview`;');
    }
};
