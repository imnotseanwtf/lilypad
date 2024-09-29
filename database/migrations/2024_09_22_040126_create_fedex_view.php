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
        DB::statement(' DROP VIEW IF EXISTS `' . env('DB_DATABASE') . '`.`fedexview`;');

        DB::statement('
        CREATE 
        ALGORITHM = UNDEFINED 
        DEFINER = `root`@`localhost` 
        SQL SECURITY DEFINER
        VIEW `' . env('DB_DATABASE') . '`.`fedexview` AS
        SELECT 
            `ship`.`id` AS `ID`,
            `so`.`num` AS `ORDERNUM`,
            `so`.`customerPO` AS `PONUM`,
            `so`.`shipToName` AS `COMPANYNAME`,
            `so`.`customerContact` AS `CONTACTNAME`,
            `so`.`shipToAddress` AS `SHIPTOADDRESS`,
            `so`.`shipToCity` AS `SHIPTOCITY`,
            `so`.`shipToZip` AS `SHIPTOZIP`,
            `carrier`.`name` AS `SERVICETYPE`,
            `shipcarton`.`freightWeight` AS `WEIGHT`,
            `shipcarton`.`id` AS `CARTONID`,
            `ship`.`cartonCount` AS `CARTONCOUNT`,
            COALESCE(`so`.`phone`, \'\') AS `PHONE`,
            COALESCE(`so`.`email`, \'\') AS `EMAIL`
        FROM
            `ship`
            JOIN `carrier` ON `carrier`.`id` = `ship`.`carrierId`
            JOIN `so` ON `so`.`id` = `ship`.`soId`
            JOIN `shipcarton` ON `shipcarton`.`shipId` = `ship`.`id`
            JOIN `customer` ON `so`.`customerId` = `customer`.`id`
            JOIN `address` ON `address`.`accountId` = `customer`.`accountId`
                AND `address`.`defaultFlag` = 1
                AND `address`.`typeID` = 50
        WHERE
            `carrier`.`name` LIKE \'%Fed%\' 
            AND `ship`.`statusId` = 20
    ');

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement(' DROP VIEW IF EXISTS `' . env('DB_DATABASE') . '`.`fedexview`;');
    }
};
