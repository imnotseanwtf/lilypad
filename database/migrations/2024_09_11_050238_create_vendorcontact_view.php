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
        DB::statement('DROP VIEW IF EXISTS `' . env('DB_DATABASE') . '`.`vendorcontactview`;');

        DB::statement('
        CREATE 
        ALGORITHM = UNDEFINED 
        DEFINER = `root`@`localhost` 
        SQL SECURITY DEFINER
        VIEW `' . env('DB_DATABASE') . '`.`vendorcontactview` AS
        SELECT 
            `' . env('DB_DATABASE') . '`.`vendor`.`id` AS `VENDORID`,
            `' . env('DB_DATABASE') . '`.`vendor`.`name` AS `VENDORNAME`,
            COALESCE(`' . env('DB_DATABASE') . '`.`contact`.`contactName`, \'Unknown\') AS `CONTACTNAME`,
            COALESCE(`' . env('DB_DATABASE') . '`.`contact`.`datus`, \'\') AS `CONTACTNUM`
        FROM
            ((`' . env('DB_DATABASE') . '`.`vendor`
            JOIN `' . env('DB_DATABASE') . '`.`address` ON (((`' . env('DB_DATABASE') . '`.`address`.`accountId` = `' . env('DB_DATABASE') . '`.`vendor`.`accountId`)
                AND (`' . env('DB_DATABASE') . '`.`address`.`defaultFlag` = 1))))
            LEFT JOIN `' . env('DB_DATABASE') . '`.`contact` ON (((`' . env('DB_DATABASE') . '`.`address`.`id` = `' . env('DB_DATABASE') . '`.`contact`.`addressId`)
                AND (`' . env('DB_DATABASE') . '`.`contact`.`typeId` = 50)
                AND (`' . env('DB_DATABASE') . '`.`contact`.`defaultFlag` = 1))))
    ');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement('DROP VIEW IF EXISTS `' . env('DB_DATABASE') . '`.`vendorcontactview`;');
    }
};
