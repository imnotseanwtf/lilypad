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
        DB::statement('DROP VIEW IF EXISTS `' . env('DB_DATABASE') . '`.`qtyonorder`;');

        DB::statement('
            CREATE 
            ALGORITHM = UNDEFINED 
            DEFINER = `root`@`localhost` 
            SQL SECURITY DEFINER
            VIEW `' . env('DB_DATABASE') . '`.`qtyonorder` AS
            SELECT 
                `totalqty`.`PARTID` AS `PARTID`,
                `totalqty`.`LOCATIONGROUPID` AS `LOCATIONGROUPID`,
                COALESCE(SUM(`totalqty`.`QTY`), 0) AS `QTY`
            FROM
            (
                SELECT 
                    \'SO\' AS `t`,
                    `' . env('DB_DATABASE') . '`.`qtyonorderso`.`PARTID` AS `PARTID`,
                    `' . env('DB_DATABASE') . '`.`qtyonorderso`.`LOCATIONGROUPID` AS `LOCATIONGROUPID`,
                    `' . env('DB_DATABASE') . '`.`qtyonorderso`.`QTY` AS `QTY`
                FROM
                    `' . env('DB_DATABASE') . '`.`qtyonorderso`
                UNION 
                SELECT 
                    \'PO\' AS `t`,
                    `' . env('DB_DATABASE') . '`.`qtyonorderpo`.`PARTID` AS `PARTID`,
                    `' . env('DB_DATABASE') . '`.`qtyonorderpo`.`LOCATIONGROUPID` AS `LOCATIONGROUPID`,
                    `' . env('DB_DATABASE') . '`.`qtyonorderpo`.`QTY` AS `QTY`
                FROM
                    `' . env('DB_DATABASE') . '`.`qtyonorderpo`
                UNION 
                SELECT 
                    \'TOSend\' AS `t`,
                    `' . env('DB_DATABASE') . '`.`qtyonordertosend`.`PARTID` AS `PARTID`,
                    `' . env('DB_DATABASE') . '`.`qtyonordertosend`.`LOCATIONGROUPID` AS `LOCATIONGROUPID`,
                    `' . env('DB_DATABASE') . '`.`qtyonordertosend`.`QTY` AS `QTY`
                FROM
                    `' . env('DB_DATABASE') . '`.`qtyonordertosend`
                UNION 
                SELECT 
                    \'TOReceive\' AS `t`,
                    `' . env('DB_DATABASE') . '`.`qtyonordertoreceive`.`PARTID` AS `PARTID`,
                    `' . env('DB_DATABASE') . '`.`qtyonordertoreceive`.`LOCATIONGROUPID` AS `LOCATIONGROUPID`,
                    `' . env('DB_DATABASE') . '`.`qtyonordertoreceive`.`QTY` AS `QTY`
                FROM
                    `' . env('DB_DATABASE') . '`.`qtyonordertoreceive`
                UNION 
                SELECT 
                    \'MO\' AS `t`,
                    `' . env('DB_DATABASE') . '`.`qtyonordermo`.`PARTID` AS `PARTID`,
                    `' . env('DB_DATABASE') . '`.`qtyonordermo`.`LOCATIONGROUPID` AS `LOCATIONGROUPID`,
                    `' . env('DB_DATABASE') . '`.`qtyonordermo`.`QTY` AS `QTY`
                FROM
                    `' . env('DB_DATABASE') . '`.`qtyonordermo`
            ) `totalQty`
            GROUP BY `totalqty`.`PARTID`, `totalqty`.`LOCATIONGROUPID`
        ');

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement('DROP VIEW IF EXISTS `' . env('DB_DATABASE') . '`.`qtyonorder`;');
    }
};
