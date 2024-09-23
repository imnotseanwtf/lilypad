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
        DB::statement('
CREATE 
    ALGORITHM = UNDEFINED 
    DEFINER = `root`@`localhost` 
    SQL SECURITY DEFINER
VIEW `lilypad`.`qtyonorder` AS
    SELECT 
        `totalqty`.`PARTID` AS `PARTID`,
        `totalqty`.`LOCATIONGROUPID` AS `LOCATIONGROUPID`,
        COALESCE(SUM(`totalqty`.`QTY`), 0) AS `QTY`
    FROM
        (SELECT 
            \'SO\' AS `t`,
                `lilypad`.`qtyonorderso`.`PARTID` AS `PARTID`,
                `lilypad`.`qtyonorderso`.`LOCATIONGROUPID` AS `LOCATIONGROUPID`,
                `lilypad`.`qtyonorderso`.`QTY` AS `QTY`
        FROM
            `lilypad`.`qtyonorderso` UNION SELECT 
            \'PO\' AS `t`,
                `lilypad`.`qtyonorderpo`.`PARTID` AS `PARTID`,
                `lilypad`.`qtyonorderpo`.`LOCATIONGROUPID` AS `LOCATIONGROUPID`,
                `lilypad`.`qtyonorderpo`.`QTY` AS `QTY`
        FROM
            `lilypad`.`qtyonorderpo` UNION SELECT 
            \'TOSend\' AS `t`,
                `lilypad`.`qtyonordertosend`.`PARTID` AS `PARTID`,
                `lilypad`.`qtyonordertosend`.`LOCATIONGROUPID` AS `LOCATIONGROUPID`,
                `lilypad`.`qtyonordertosend`.`QTY` AS `QTY`
        FROM
            `lilypad`.`qtyonordertosend` UNION SELECT 
            \'TOReceive\' AS `t`,
                `lilypad`.`qtyonordertoreceive`.`PARTID` AS `PARTID`,
                `lilypad`.`qtyonordertoreceive`.`LOCATIONGROUPID` AS `LOCATIONGROUPID`,
                `lilypad`.`qtyonordertoreceive`.`QTY` AS `QTY`
        FROM
            `lilypad`.`qtyonordertoreceive` UNION SELECT 
            \'MO\' AS `t`,
                `lilypad`.`qtyonordermo`.`PARTID` AS `PARTID`,
                `lilypad`.`qtyonordermo`.`LOCATIONGROUPID` AS `LOCATIONGROUPID`,
                `lilypad`.`qtyonordermo`.`QTY` AS `QTY`
        FROM
            `lilypad`.`qtyonordermo`) `totalQty`
    GROUP BY `totalqty`.`PARTID`, `totalqty`.`LOCATIONGROUPID`
');

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('qtyonorder_view');
    }
};
