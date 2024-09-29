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
        DB::statement(' DROP VIEW IF EXISTS `'. env('DB_DATABASE') . '`.`qtyinventorytotals`;');

        DB::statement('
    CREATE 
        ALGORITHM = UNDEFINED 
        DEFINER = `root`@`localhost` 
        SQL SECURITY DEFINER
    VIEW `'. env('DB_DATABASE') . '`.`qtyinventorytotals` AS
        SELECT 
            `'. env('DB_DATABASE') . '`.`qtyinventory`.`PARTID` AS `PARTID`,
            `'. env('DB_DATABASE') . '`.`qtyinventory`.`LOCATIONGROUPID` AS `LOCATIONGROUPID`,
            `'. env('DB_DATABASE') . '`.`qtyinventory`.`QTYONHAND` AS `QTYONHAND`,
            (((`'. env('DB_DATABASE') . '`.`qtyinventory`.`QTYALLOCATEDPO` + `'. env('DB_DATABASE') . '`.`qtyinventory`.`QTYALLOCATEDSO`) + 
            `'. env('DB_DATABASE') . '`.`qtyinventory`.`QTYALLOCATEDTO`) + `'. env('DB_DATABASE') . '`.`qtyinventory`.`QTYALLOCATEDMO`) AS `QTYALLOCATED`,
            `'. env('DB_DATABASE') . '`.`qtyinventory`.`QTYNOTAVAILABLE` AS `QTYNOTAVAILABLE`,
            `'. env('DB_DATABASE') . '`.`qtyinventory`.`QTYNOTAVAILABLETOPICK` AS `QTYNOTAVAILABLETOPICK`,
            `'. env('DB_DATABASE') . '`.`qtyinventory`.`QTYDROPSHIP` AS `QTYDROPSHIP`,
            (((`'. env('DB_DATABASE') . '`.`qtyinventory`.`QTYONORDERPO` + `'. env('DB_DATABASE') . '`.`qtyinventory`.`QTYONORDERSO`) + 
            `'. env('DB_DATABASE') . '`.`qtyinventory`.`QTYONORDERTO`) + `'. env('DB_DATABASE') . '`.`qtyinventory`.`QTYONORDERMO`) AS `QTYONORDER`
        FROM
            `'. env('DB_DATABASE') . '`.`qtyinventory`
');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement(' DROP VIEW IF EXISTS `'. env('DB_DATABASE') . '`.`qtyinventorytotals`;');
    }
};
