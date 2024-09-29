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
        DB::statement('DROP VIEW IF EXISTS `' . env('DB_DATABASE') . '`.`ontracview`;');

        DB::statement('
    CREATE 
    ALGORITHM = UNDEFINED 
    DEFINER = `root`@`localhost` 
    SQL SECURITY DEFINER
    VIEW `' . env('DB_DATABASE') . '`.`ontracview` AS
    SELECT 
        `ship`.`num` AS `OrderNumber`,
        `so`.`shipToName` AS `Name`,
        `address`.`SHIPTOADDRESS1` AS `AddressLine1`,
        `address`.`SHIPTOADDRESS2` AS `AddressLine2`,
        `address`.`SHIPTOADDRESS3` AS `AddressLine3`,
        `so`.`shipToCity` AS `City`,
        `so`.`shipToZip` AS `Zip`,
        `ship`.`note` AS `Instructions`,
        `ship`.`contact` AS `Contact`,
        `shipcarton`.`insuredValue` AS `DeclaredValue`,
        `shipstatus`.`name` AS `ShipStatus`
    FROM
        `shipcarton`
        JOIN `ship` ON `shipcarton`.`shipId` = `ship`.`id`
        JOIN `shipstatus` ON `ship`.`statusId` = `shipstatus`.`id`
        JOIN `so` ON `ship`.`soId` = `so`.`id` AND `ship`.`orderTypeId` = 20
        JOIN `carrier` ON `so`.`carrierId` = `carrier`.`id`
        JOIN `addressmultilinesoview` `address` ON `so`.`id` = `address`.`SOID`
    WHERE
        LOWER(`carrier`.`name`) = "ontrac"
        AND `ship`.`statusId` < 30
');

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement('DROP VIEW IF EXISTS `' . env('DB_DATABASE') . '`.`ontracview`;');
    }
};
