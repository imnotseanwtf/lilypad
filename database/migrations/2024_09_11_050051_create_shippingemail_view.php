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
        DB::statement('DROP VIEW IF EXISTS `' . env('DB_DATABASE') . '`.`shippingemailview`;');

        DB::statement('
    CREATE 
    ALGORITHM = UNDEFINED 
    DEFINER = `root`@`localhost` 
    SQL SECURITY DEFINER
    VIEW `' . env('DB_DATABASE') . '`.`shippingemailview` AS
    SELECT 
        `' . env('DB_DATABASE') . '`.`so`.`id` AS `SOID`,
        `' . env('DB_DATABASE') . '`.`customer`.`id` AS `CUSTOMERID`,
        `' . env('DB_DATABASE') . '`.`so`.`email` AS `EMAILADDRESS`
    FROM
        (`' . env('DB_DATABASE') . '`.`so`
        JOIN `' . env('DB_DATABASE') . '`.`customer` ON (`' . env('DB_DATABASE') . '`.`so`.`customerId` = `' . env('DB_DATABASE') . '`.`customer`.`id`)
        JOIN `' . env('DB_DATABASE') . '`.`account` ON (`' . env('DB_DATABASE') . '`.`customer`.`accountId` = `' . env('DB_DATABASE') . '`.`account`.`id`)
    )
');

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement('DROP VIEW IF EXISTS `' . env('DB_DATABASE') . '`.`shippingemailview`;');
    }
};
