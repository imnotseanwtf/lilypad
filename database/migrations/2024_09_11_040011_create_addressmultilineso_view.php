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
        DB::statement('DROP VIEW IF EXISTS `' . env('DB_DATABASE') . '`.`addressmultilinesoview`;');

        DB::statement('
    CREATE 
    ALGORITHM = UNDEFINED 
    DEFINER = `root`@`localhost` 
    SQL SECURITY DEFINER
    VIEW `' . env('DB_DATABASE') . '`.`addressmultilinesoview` AS
    SELECT 
        `so`.`id` AS `SOID`,
        (CASE
            WHEN (LOCATE(\'\n\', `so`.`shipToAddress`) > 0)
            THEN SUBSTR(`so`.`shipToAddress`, 1, (LOCATE(\'\n\', `so`.`shipToAddress`) - 1))
            ELSE `so`.`shipToAddress`
        END) AS `SHIPTOADDRESS1`,
        (CASE
            WHEN (LOCATE(\'\n\', `so`.`shipToAddress`) > 0 
                AND LOCATE(\'\n\', `so`.`shipToAddress`, (LOCATE(\'\n\', `so`.`shipToAddress`) + 1)) = 0)
            THEN SUBSTR(`so`.`shipToAddress`, (LOCATE(\'\n\', `so`.`shipToAddress`) + 1))
            WHEN (LOCATE(\'\n\', `so`.`shipToAddress`) > 0 
                AND LOCATE(\'\n\', `so`.`shipToAddress`, (LOCATE(\'\n\', `so`.`shipToAddress`) + 1)) > 0)
            THEN SUBSTR(`so`.`shipToAddress`, (LOCATE(\'\n\', `so`.`shipToAddress`) + 1),
                (LOCATE(\'\n\', `so`.`shipToAddress`, (LOCATE(\'\n\', `so`.`shipToAddress`) + 1)) - (LOCATE(\'\n\', `so`.`shipToAddress`) + 1)))
            ELSE \'\' 
        END) AS `SHIPTOADDRESS2`,
        (CASE
            WHEN (LOCATE(\'\n\', `so`.`shipToAddress`, (LOCATE(\'\n\', `so`.`shipToAddress`) + 1)) > 0)
            THEN SUBSTR(`so`.`shipToAddress`, (LOCATE(\'\n\', `so`.`shipToAddress`, (LOCATE(\'\n\', `so`.`shipToAddress`) + 1)) + 1))
            ELSE \'\' 
        END) AS `SHIPTOADDRESS3`
    FROM
        `so`;
');

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement('DROP VIEW IF EXISTS `' . env('DB_DATABASE') . '`.`addressmultilinesoview`;');
    }
};
