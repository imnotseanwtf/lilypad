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
        DB::statement('   DROP VIEW IF EXISTS `' . env('DB_DATABASE') . '`.`addressmultilinepoview`;');

        DB::statement('
    CREATE 
        ALGORITHM = UNDEFINED 
        DEFINER = `root`@`localhost` 
        SQL SECURITY DEFINER
    VIEW `' . env('DB_DATABASE') . '`.`addressmultilinepoview` AS
        SELECT 
            `' . env('DB_DATABASE') . '`.`po`.`id` AS `POID`,
            (CASE
                WHEN (LOCATE(\'\n\', `' . env('DB_DATABASE') . '`.`po`.`remitAddress`) > 0)
                THEN SUBSTR(`' . env('DB_DATABASE') . '`.`po`.`remitAddress`, 1, (LOCATE(\'\n\', `' . env('DB_DATABASE') . '`.`po`.`remitAddress`) - 1))
                ELSE `' . env('DB_DATABASE') . '`.`po`.`remitAddress`
            END) AS `REMITADDRESS1`,
            (CASE
                WHEN ((LOCATE(\'\n\', `' . env('DB_DATABASE') . '`.`po`.`remitAddress`) > 0) AND (LOCATE(\'\n\', `' . env('DB_DATABASE') . '`.`po`.`remitAddress`, (LOCATE(\'\n\', `' . env('DB_DATABASE') . '`.`po`.`remitAddress`) + 1)) = 0))
                THEN SUBSTR(`' . env('DB_DATABASE') . '`.`po`.`remitAddress`, (LOCATE(\'\n\', `' . env('DB_DATABASE') . '`.`po`.`remitAddress`) + 1))
                WHEN ((LOCATE(\'\n\', `' . env('DB_DATABASE') . '`.`po`.`remitAddress`) > 0) AND (LOCATE(\'\n\', `' . env('DB_DATABASE') . '`.`po`.`remitAddress`, (LOCATE(\'\n\', `' . env('DB_DATABASE') . '`.`po`.`remitAddress`) + 1)) > 0))
                THEN SUBSTR(`' . env('DB_DATABASE') . '`.`po`.`remitAddress`, (LOCATE(\'\n\', `' . env('DB_DATABASE') . '`.`po`.`remitAddress`) + 1), (LOCATE(\'\n\', `' . env('DB_DATABASE') . '`.`po`.`remitAddress`, (LOCATE(\'\n\', `' . env('DB_DATABASE') . '`.`po`.`remitAddress`) + 1)) - (LOCATE(\'\n\', `' . env('DB_DATABASE') . '`.`po`.`remitAddress`) + 1)))
                ELSE \'\'
            END) AS `REMITADDRESS2`,
            (CASE
                WHEN (LOCATE(\'\n\', `' . env('DB_DATABASE') . '`.`po`.`remitAddress`, (LOCATE(\'\n\', `' . env('DB_DATABASE') . '`.`po`.`remitAddress`) + 1)) > 0)
                THEN SUBSTR(`' . env('DB_DATABASE') . '`.`po`.`remitAddress`, (LOCATE(\'\n\', `' . env('DB_DATABASE') . '`.`po`.`remitAddress`, (LOCATE(\'\n\', `' . env('DB_DATABASE') . '`.`po`.`remitAddress`) + 1)) + 1))
                ELSE \'\'
            END) AS `REMITADDRESS3`,
            (CASE
                WHEN (LOCATE(\'\n\', `' . env('DB_DATABASE') . '`.`po`.`shipToAddress`) > 0)
                THEN SUBSTR(`' . env('DB_DATABASE') . '`.`po`.`shipToAddress`, 1, (LOCATE(\'\n\', `' . env('DB_DATABASE') . '`.`po`.`shipToAddress`) - 1))
                ELSE `' . env('DB_DATABASE') . '`.`po`.`shipToAddress`
            END) AS `SHIPTOADDRESS1`,
            (CASE
                WHEN ((LOCATE(\'\n\', `' . env('DB_DATABASE') . '`.`po`.`shipToAddress`) > 0) AND (LOCATE(\'\n\', `' . env('DB_DATABASE') . '`.`po`.`shipToAddress`, (LOCATE(\'\n\', `' . env('DB_DATABASE') . '`.`po`.`shipToAddress`) + 1)) = 0))
                THEN SUBSTR(`' . env('DB_DATABASE') . '`.`po`.`shipToAddress`, (LOCATE(\'\n\', `' . env('DB_DATABASE') . '`.`po`.`shipToAddress`) + 1))
                WHEN ((LOCATE(\'\n\', `' . env('DB_DATABASE') . '`.`po`.`shipToAddress`) > 0) AND (LOCATE(\'\n\', `' . env('DB_DATABASE') . '`.`po`.`shipToAddress`, (LOCATE(\'\n\', `' . env('DB_DATABASE') . '`.`po`.`shipToAddress`) + 1)) > 0))
                THEN SUBSTR(`' . env('DB_DATABASE') . '`.`po`.`shipToAddress`, (LOCATE(\'\n\', `' . env('DB_DATABASE') . '`.`po`.`shipToAddress`) + 1), (LOCATE(\'\n\', `' . env('DB_DATABASE') . '`.`po`.`shipToAddress`, (LOCATE(\'\n\', `' . env('DB_DATABASE') . '`.`po`.`shipToAddress`) + 1)) - (LOCATE(\'\n\', `' . env('DB_DATABASE') . '`.`po`.`shipToAddress`) + 1)))
                ELSE \'\'
            END) AS `SHIPTOADDRESS2`,
            (CASE
                WHEN (LOCATE(\'\n\', `' . env('DB_DATABASE') . '`.`po`.`shipToAddress`, (LOCATE(\'\n\', `' . env('DB_DATABASE') . '`.`po`.`shipToAddress`) + 1)) > 0)
                THEN SUBSTR(`' . env('DB_DATABASE') . '`.`po`.`shipToAddress`, (LOCATE(\'\n\', `' . env('DB_DATABASE') . '`.`po`.`shipToAddress`, (LOCATE(\'\n\', `' . env('DB_DATABASE') . '`.`po`.`shipToAddress`) + 1)) + 1))
                ELSE \'\'
            END) AS `SHIPTOADDRESS3`
        FROM `' . env('DB_DATABASE') . '`.`po`
');

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement('   DROP VIEW IF EXISTS `' . env('DB_DATABASE') . '`.`addressmultilinepoview`;');
    }
};
