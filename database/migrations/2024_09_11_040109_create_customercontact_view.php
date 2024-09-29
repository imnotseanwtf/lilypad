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
        DB::statement(' DROP VIEW IF EXISTS `' . env('DB_DATABASE') . '`.`customercontactview`;');

DB::statement('
    CREATE 
    ALGORITHM = UNDEFINED 
    DEFINER = `root`@`localhost` 
    SQL SECURITY DEFINER
    VIEW `' . env('DB_DATABASE') . '`.`customercontactview` AS
    SELECT 
        `customer`.`id` AS `CUSTID`,
        `customer`.`name` AS `CUSTNAME`,
        COALESCE(`contact`.`contactName`, \'Unknown\') AS `CONTACTNAME`,
        COALESCE(`contact`.`datus`, \'\') AS `CONTACTNUM`
    FROM
        `customer`
    JOIN `address` ON 
        `address`.`accountId` = `customer`.`accountId`
        AND `address`.`defaultFlag` = 1
        AND `address`.`typeID` = 50
    LEFT JOIN `contact` ON 
        `address`.`id` = `contact`.`addressId`
        AND `contact`.`typeId` = 50
        AND `contact`.`defaultFlag` = 1
');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement(' DROP VIEW IF EXISTS `' . env('DB_DATABASE') . '`.`customercontactview`;');
    }
};
