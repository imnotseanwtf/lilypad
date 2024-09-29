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
        DB::statement('DROP VIEW IF EXISTS `' . env('DB_DATABASE') . '`.`paymentview`;');

        DB::statement('
    CREATE 
    ALGORITHM = UNDEFINED 
    DEFINER = `root`@`localhost` 
    SQL SECURITY DEFINER
    VIEW `' . env('DB_DATABASE') . '`.`paymentview` AS
    SELECT DISTINCT
        `' . env('DB_DATABASE') . '`.`postransaction`.`id` AS `posTransactionId`,
        `' . env('DB_DATABASE') . '`.`postransaction`.`amount` AS `amount`,
        `' . env('DB_DATABASE') . '`.`customer`.`name` AS `customerName`,
        `' . env('DB_DATABASE') . '`.`postransaction`.`dateTime` AS `dateTime`,
        `' . env('DB_DATABASE') . '`.`so`.`num` AS `soNum`,
        `' . env('DB_DATABASE') . '`.`paymentmethod`.`name` AS `methodName`,
        `' . env('DB_DATABASE') . '`.`customer`.`id` AS `customerId`,
        `' . env('DB_DATABASE') . '`.`paymentmethod`.`id` AS `paymentMethodId`
    FROM
        `' . env('DB_DATABASE') . '`.`postransaction`
        JOIN `' . env('DB_DATABASE') . '`.`so` 
            ON `' . env('DB_DATABASE') . '`.`postransaction`.`soId` = `' . env('DB_DATABASE') . '`.`so`.`id`
        JOIN `' . env('DB_DATABASE') . '`.`customer` 
            ON `' . env('DB_DATABASE') . '`.`so`.`customerId` = `' . env('DB_DATABASE') . '`.`customer`.`id`
        JOIN `' . env('DB_DATABASE') . '`.`paymentmethod` 
            ON `' . env('DB_DATABASE') . '`.`postransaction`.`paymentMethodId` = `' . env('DB_DATABASE') . '`.`paymentmethod`.`id`
');
    
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement('DROP VIEW IF EXISTS `' . env('DB_DATABASE') . '`.`paymentview`;');
    }
};
