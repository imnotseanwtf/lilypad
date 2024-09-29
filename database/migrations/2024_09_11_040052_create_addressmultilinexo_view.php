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
        DB::statement(' DROP VIEW IF EXISTS `' . env('DB_DATABASE') . '`.`addressmultilinexoview`;');
        
        DB::statement('
    CREATE 
    ALGORITHM = UNDEFINED 
    DEFINER = `root`@`localhost` 
    SQL SECURITY DEFINER
    VIEW `' . env('DB_DATABASE') . '`.`addressmultilinexoview` AS
    SELECT 
        `xo`.`id` AS `XOID`,
        (CASE
            WHEN (LOCATE(\'\n\', `xo`.`shipToAddress`) > 0)
            THEN SUBSTR(`xo`.`shipToAddress`, 1, (LOCATE(\'\n\', `xo`.`shipToAddress`) - 1))
            ELSE `xo`.`shipToAddress`
        END) AS `SHIPTOADDRESS1`,
        (CASE
            WHEN ((LOCATE(\'\n\', `xo`.`shipToAddress`) > 0)
                AND (LOCATE(\'\n\', `xo`.`shipToAddress`, (LOCATE(\'\n\', `xo`.`shipToAddress`) + 1)) = 0))
            THEN SUBSTR(`xo`.`shipToAddress`, (LOCATE(\'\n\', `xo`.`shipToAddress`) + 1))
            WHEN ((LOCATE(\'\n\', `xo`.`shipToAddress`) > 0)
                AND (LOCATE(\'\n\', `xo`.`shipToAddress`, (LOCATE(\'\n\', `xo`.`shipToAddress`) + 1)) > 0))
            THEN SUBSTR(`xo`.`shipToAddress`,
                (LOCATE(\'\n\', `xo`.`shipToAddress`) + 1),
                (LOCATE(\'\n\', `xo`.`shipToAddress`, (LOCATE(\'\n\', `xo`.`shipToAddress`) + 1)) - (LOCATE(\'\n\', `xo`.`shipToAddress`) + 1)))
            ELSE \'\' 
        END) AS `SHIPTOADDRESS2`,
        (CASE
            WHEN (LOCATE(\'\n\', `xo`.`shipToAddress`, (LOCATE(\'\n\', `xo`.`shipToAddress`) + 1)) > 0)
            THEN SUBSTR(`xo`.`shipToAddress`,
                (LOCATE(\'\n\', `xo`.`shipToAddress`, (LOCATE(\'\n\', `xo`.`shipToAddress`) + 1)) + 1))
            ELSE \'\' 
        END) AS `SHIPTOADDRESS3`,
        (CASE
            WHEN (LOCATE(\'\n\', `xo`.`fromAddress`) > 0)
            THEN SUBSTR(`xo`.`fromAddress`, 1, (LOCATE(\'\n\', `xo`.`fromAddress`) - 1))
            ELSE `xo`.`fromAddress`
        END) AS `FROMADDRESS1`,
        (CASE
            WHEN ((LOCATE(\'\n\', `xo`.`fromAddress`) > 0)
                AND (LOCATE(\'\n\', `xo`.`fromAddress`, (LOCATE(\'\n\', `xo`.`fromAddress`) + 1)) = 0))
            THEN SUBSTR(`xo`.`fromAddress`, (LOCATE(\'\n\', `xo`.`fromAddress`) + 1))
            WHEN ((LOCATE(\'\n\', `xo`.`fromAddress`) > 0)
                AND (LOCATE(\'\n\', `xo`.`fromAddress`, (LOCATE(\'\n\', `xo`.`fromAddress`) + 1)) > 0))
            THEN SUBSTR(`xo`.`fromAddress`,
                (LOCATE(\'\n\', `xo`.`fromAddress`) + 1),
                (LOCATE(\'\n\', `xo`.`fromAddress`, (LOCATE(\'\n\', `xo`.`fromAddress`) + 1)) - (LOCATE(\'\n\', `xo`.`fromAddress`) + 1)))
            ELSE \'\' 
        END) AS `FROMADDRESS2`,
        (CASE
            WHEN (LOCATE(\'\n\', `xo`.`fromAddress`, (LOCATE(\'\n\', `xo`.`fromAddress`) + 1)) > 0)
            THEN SUBSTR(`xo`.`fromAddress`,
                (LOCATE(\'\n\', `xo`.`fromAddress`, (LOCATE(\'\n\', `xo`.`fromAddress`) + 1)) + 1))
            ELSE \'\' 
        END) AS `FROMADDRESS3`
    FROM
        `xo`;
');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    { 
        DB::statement(' DROP VIEW IF EXISTS `' . env('DB_DATABASE') . '`.`addressmultilinexoview`;');
    }
};
