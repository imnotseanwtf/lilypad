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
        DB::statement(' DROP VIEW IF EXISTS `' . env('DB_DATABASE') . '`.`qtyallocated`;');

        DB::statement('
    CREATE VIEW `' . env('DB_DATABASE') . '`.`qtyallocated` AS
    SELECT 
        totalqty.PARTID AS PARTID,
        totalqty.LOCATIONGROUPID AS LOCATIONGROUPID,
        COALESCE(SUM(totalqty.QTY), 0) AS QTY
    FROM
        (SELECT 
            \'SO\' AS t,
            `qtyallocatedso`.`PARTID` AS `PARTID`,
            `qtyallocatedso`.`LOCATIONGROUPID` AS `LOCATIONGROUPID`,
            `qtyallocatedso`.`QTY` AS `QTY`
        FROM
            `qtyallocatedso` 
        UNION 
        SELECT 
            \'PO\' AS t,
            `qtyallocatedpo`.`PARTID` AS `PARTID`,
            `qtyallocatedpo`.`LOCATIONGROUPID` AS `LOCATIONGROUPID`,
            `qtyallocatedpo`.`QTY` AS `QTY`
        FROM
            `qtyallocatedpo` 
        UNION 
        SELECT 
            \'TOSend\' AS t,
            `qtyallocatedtosend`.`PARTID` AS `PARTID`,
            `qtyallocatedtosend`.`LOCATIONGROUPID` AS `LOCATIONGROUPID`,
            `qtyallocatedtosend`.`QTY` AS `QTY`
        FROM
            `qtyallocatedtosend` 
        UNION 
        SELECT 
            \'TOReceive\' AS t,
            `qtyallocatedtoreceive`.`PARTID` AS `PARTID`,
            `qtyallocatedtoreceive`.`LOCATIONGROUPID` AS `LOCATIONGROUPID`,
            `qtyallocatedtoreceive`.`QTY` AS `QTY`
        FROM
            `qtyallocatedtoreceive` 
        UNION 
        SELECT 
            \'MO\' AS t,
            `qtyallocatedmo`.`PARTID` AS `PARTID`,
            `qtyallocatedmo`.`LOCATIONGROUPID` AS `LOCATIONGROUPID`,
            `qtyallocatedmo`.`QTY` AS `QTY`
        FROM
            `qtyallocatedmo`
        ) totalQty
    GROUP BY totalqty.PARTID, totalqty.LOCATIONGROUPID;
');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement(' DROP VIEW IF EXISTS `' . env('DB_DATABASE') . '`.`qtyallocated`;');
    }
};
