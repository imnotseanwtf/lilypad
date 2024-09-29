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
        DB::statement('DROP VIEW IF EXISTS `' . env('DB_DATABASE') . '`.`shipnumview`;');
    
        DB::statement('
    CREATE 
        ALGORITHM = UNDEFINED 
        DEFINER = `root`@`localhost` 
        SQL SECURITY DEFINER
    VIEW `' . env('DB_DATABASE') . '`.`shipnumview` AS
        SELECT 
            `' . env('DB_DATABASE') . '`.`ship`.`num` AS `shipNumber`,
            `' . env('DB_DATABASE') . '`.`ship`.`id` AS `shipid`,
            `' . env('DB_DATABASE') . '`.`so`.`num` AS `sonum`,
            `' . env('DB_DATABASE') . '`.`so`.`id` AS `soid`,
            `' . env('DB_DATABASE') . '`.`customer`.`name` AS `customerName`,
            `' . env('DB_DATABASE') . '`.`so`.`shipToName` AS `shiptoname`,
            `' . env('DB_DATABASE') . '`.`addressmultilinesoview`.`SHIPTOADDRESS1` AS `shiptoaddress1`,
            `' . env('DB_DATABASE') . '`.`addressmultilinesoview`.`SHIPTOADDRESS2` AS `shiptoaddress2`,
            `' . env('DB_DATABASE') . '`.`addressmultilinesoview`.`SHIPTOADDRESS3` AS `shiptoaddress3`,
            `' . env('DB_DATABASE') . '`.`so`.`shipToCity` AS `shiptocity`,
            `' . env('DB_DATABASE') . '`.`so`.`shipToZip` AS `shiptozip`,
            `' . env('DB_DATABASE') . '`.`so`.`email` AS `email`,
            `' . env('DB_DATABASE') . '`.`so`.`phone` AS `phone`,
            `' . env('DB_DATABASE') . '`.`so`.`customerPO` AS `customerpo`,
            `' . env('DB_DATABASE') . '`.`carrierservice`.`code` AS `carrierservice`,
            `' . env('DB_DATABASE') . '`.`shipcarton`.`id` AS `cartonID`,
            `' . env('DB_DATABASE') . '`.`shipcarton`.`len` AS `length`,
            `' . env('DB_DATABASE') . '`.`shipcarton`.`width` AS `width`,
            `' . env('DB_DATABASE') . '`.`shipcarton`.`height` AS `height`,
            `' . env('DB_DATABASE') . '`.`shipcarton`.`freightWeight` AS `cartonweight`
        FROM
            (((((`' . env('DB_DATABASE') . '`.`so`
            LEFT JOIN `' . env('DB_DATABASE') . '`.`addressmultilinesoview` ON ((`' . env('DB_DATABASE') . '`.`addressmultilinesoview`.`SOID` = `' . env('DB_DATABASE') . '`.`so`.`id`)))
            LEFT JOIN `' . env('DB_DATABASE') . '`.`ship` ON (((`' . env('DB_DATABASE') . '`.`so`.`id` = `' . env('DB_DATABASE') . '`.`ship`.`soId`)
                AND (`' . env('DB_DATABASE') . '`.`ship`.`orderTypeId` = 20))))
            LEFT JOIN `' . env('DB_DATABASE') . '`.`customer` ON ((`' . env('DB_DATABASE') . '`.`so`.`customerId` = `' . env('DB_DATABASE') . '`.`customer`.`id`)))
            LEFT JOIN `' . env('DB_DATABASE') . '`.`shipcarton` ON ((`' . env('DB_DATABASE') . '`.`ship`.`id` = `' . env('DB_DATABASE') . '`.`shipcarton`.`shipId`)))
            LEFT JOIN `' . env('DB_DATABASE') . '`.`carrierservice` ON ((`' . env('DB_DATABASE') . '`.`ship`.`carrierServiceId` = `' . env('DB_DATABASE') . '`.`carrierservice`.`id`)))
        WHERE
            (`' . env('DB_DATABASE') . '`.`ship`.`statusId` IN (10 , 20));
');

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement('DROP VIEW IF EXISTS `' . env('DB_DATABASE') . '`.`shipnumview`;');
    }
};
