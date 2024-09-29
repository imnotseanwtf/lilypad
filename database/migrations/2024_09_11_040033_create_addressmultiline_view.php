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
        DB::statement(' DROP VIEW IF EXISTS `' . env('DB_DATABASE') . '`.`addressmultilineview`;');

        DB::statement('
    CREATE 
    ALGORITHM = UNDEFINED 
    DEFINER = `root`@`localhost` 
    SQL SECURITY DEFINER
    VIEW `' . env('DB_DATABASE') . '`.`addressmultilineview` AS
    SELECT 
        `address`.`id` AS `ID`,
        `address`.`accountId` AS `ACCOUNTID`,
        `address`.`typeID` AS `TYPEID`,
        `address`.`name` AS `NAME`,
        (CASE
            WHEN (LOCATE(\'\n\', `address`.`address`) > 0)
            THEN SUBSTR(`address`.`address`, 1, (LOCATE(\'\n\', `address`.`address`) - 1))
            ELSE `address`.`address`
        END) AS `ADDRESS1`,
        (CASE
            WHEN (LOCATE(\'\n\', `address`.`address`) > 0 
                AND LOCATE(\'\n\', `address`.`address`, (LOCATE(\'\n\', `address`.`address`) + 1)) = 0)
            THEN SUBSTR(`address`.`address`, (LOCATE(\'\n\', `address`.`address`) + 1))
            WHEN (LOCATE(\'\n\', `address`.`address`) > 0 
                AND LOCATE(\'\n\', `address`.`address`, (LOCATE(\'\n\', `address`.`address`) + 1)) > 0)
            THEN SUBSTR(`address`.`address`, (LOCATE(\'\n\', `address`.`address`) + 1),
                (LOCATE(\'\n\', `address`.`address`, (LOCATE(\'\n\', `address`.`address`) + 1)) - (LOCATE(\'\n\', `address`.`address`) + 1)))
            ELSE \'\' 
        END) AS `ADDRESS2`,
        (CASE
            WHEN (LOCATE(\'\n\', `address`.`address`, (LOCATE(\'\n\', `address`.`address`) + 1)) > 0)
            THEN SUBSTR(`address`.`address`, (LOCATE(\'\n\', `address`.`address`, (LOCATE(\'\n\', `address`.`address`) + 1)) + 1))
            ELSE \'\' 
        END) AS `ADDRESS3`,
        `address`.`city` AS `CITY`,
        `address`.`stateId` AS `STATEID`,
        `address`.`zip` AS `ZIP`,
        `address`.`countryId` AS `COUNTRYID`,
        `address`.`defaultFlag` AS `DEFAULTFLAG`
    FROM
        `address`;
');

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement(' DROP VIEW IF EXISTS `' . env('DB_DATABASE') . '`.`addressmultilineview`;');
    }
};
