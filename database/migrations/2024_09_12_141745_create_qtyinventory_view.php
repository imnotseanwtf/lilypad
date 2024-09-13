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
        //     DB::statement('
        //     CREATE VIEW lilypad.qtyinventory AS
        //     SELECT 
        //         totalqty.PARTID AS PARTID,
        //         totalqty.LOCATIONGROUPID AS LOCATIONGROUPID,
        //         SUM((CASE
        //             WHEN (totalqty.t = \'QTYONHAND\') THEN totalqty.QTY
        //             ELSE 0
        //         END)) AS QTYONHAND,
        //         SUM((CASE
        //             WHEN (totalqty.t = \'QTYALLOCATEDPO\') THEN totalqty.QTY
        //             ELSE 0
        //         END)) AS QTYALLOCATEDPO,
        //         SUM((CASE
        //             WHEN (totalqty.t = \'QTYALLOCATEDSO\') THEN totalqty.QTY
        //             ELSE 0
        //         END)) AS QTYALLOCATEDSO,
        //         SUM((CASE
        //             WHEN (totalqty.t = \'QTYALLOCATEDMO\') THEN totalqty.QTY
        //             ELSE 0
        //         END)) AS QTYALLOCATEDMO,
        //         (SUM((CASE
        //             WHEN (totalqty.t = \'QTYALLOCATEDTORECEIVE\') THEN totalqty.QTY
        //             ELSE 0
        //         END)) + SUM((CASE
        //             WHEN (totalqty.t = \'QTYALLOCATEDTOSEND\') THEN totalqty.QTY
        //             ELSE 0
        //         END))) AS QTYALLOCATEDTO,
        //         SUM((CASE
        //             WHEN (totalqty.t = \'QTYNOTAVAILABLE\') THEN totalqty.QTY
        //             ELSE 0
        //         END)) AS QTYNOTAVAILABLE,
        //         SUM((CASE
        //             WHEN (totalqty.t = \'QTYNOTAVAILABLETOPICK\') THEN totalqty.QTY
        //             ELSE 0
        //         END)) AS QTYNOTAVAILABLETOPICK,
        //         SUM((CASE
        //             WHEN (totalqty.t = \'QTYDROPSHIP\') THEN totalqty.QTY
        //             ELSE 0
        //         END)) AS QTYDROPSHIP,
        //         SUM((CASE
        //             WHEN (totalqty.t = \'QTYONORDERPO\') THEN totalqty.QTY
        //             ELSE 0
        //         END)) AS QTYONORDERPO,
        //         SUM((CASE
        //             WHEN (totalqty.t = \'QTYONORDERSO\') THEN totalqty.QTY
        //             ELSE 0
        //         END)) AS QTYONORDERSO,
        //         (SUM((CASE
        //             WHEN (totalqty.t = \'QTYONORDERTORECEIVE\') THEN totalqty.QTY
        //             ELSE 0
        //         END)) + SUM((CASE
        //             WHEN (totalqty.t = \'QTYONORDERTOSEND\') THEN totalqty.QTY
        //             ELSE 0
        //         END))) AS QTYONORDERTO,
        //         SUM((CASE
        //             WHEN (totalqty.t = \'QTYONORDERMO\') THEN totalqty.QTY
        //             ELSE 0
        //         END)) AS QTYONORDERMO
        //     FROM
        //         (SELECT 
        //             \'QTYONHAND\' AS t,
        //                 lilypad.qtyonhand.PARTID AS PARTID,
        //                 lilypad.qtyonhand.LOCATIONGROUPID AS LOCATIONGROUPID,
        //                 lilypad.qtyonhand.QTY AS QTY
        //         FROM
        //             lilypad.qtyonhand UNION SELECT 
        //             \'QTYALLOCATED\' AS t,
        //                 lilypad.qtyallocated.PARTID AS PARTID,
        //                 lilypad.qtyallocated.LOCATIONGROUPID AS LOCATIONGROUPID,
        //                 lilypad.qtyallocated.QTY AS QTY
        //         FROM
        //             lilypad.qtyallocated UNION SELECT 
        //             \'QTYALLOCATEDPO\' AS t,
        //                 lilypad.qtyallocatedpo.PARTID AS PARTID,
        //                 lilypad.qtyallocatedpo.LOCATIONGROUPID AS LOCATIONGROUPID,
        //                 lilypad.qtyallocatedpo.QTY AS QTY
        //         FROM
        //             lilypad.qtyallocatedpo UNION SELECT 
        //             \'QTYALLOCATEDSO\' AS t,
        //                 lilypad.qtyallocatedso.PARTID AS PARTID,
        //                 lilypad.qtyallocatedso.LOCATIONGROUPID AS LOCATIONGROUPID,
        //                 lilypad.qtyallocatedso.QTY AS QTY
        //         FROM
        //             lilypad.qtyallocatedso UNION SELECT 
        //             \'QTYALLOCATEDTORECEIVE\' AS t,
        //                 lilypad.qtyallocatedtoreceive.PARTID AS PARTID,
        //                 lilypad.qtyallocatedtoreceive.LOCATIONGROUPID AS LOCATIONGROUPID,
        //                 lilypad.qtyallocatedtoreceive.QTY AS QTY
        //         FROM
        //             lilypad.qtyallocatedtoreceive UNION SELECT 
        //             \'QTYALLOCATEDTOSEND\' AS t,
        //                 lilypad.qtyallocatedtosend.PARTID AS PARTID,
        //                 lilypad.qtyallocatedtosend.LOCATIONGROUPID AS LOCATIONGROUPID,
        //                 lilypad.qtyallocatedtosend.QTY AS QTY
        //         FROM
        //             lilypad.qtyallocatedtosend UNION SELECT 
        //             \'QTYALLOCATEDMO\' AS t,
        //                 lilypad.qtyallocatedmo.PARTID AS PARTID,
        //                 lilypad.qtyallocatedmo.LOCATIONGROUPID AS LOCATIONGROUPID,
        //                 lilypad.qtyallocatedmo.QTY AS QTY
        //         FROM
        //             lilypad.qtyallocatedmo UNION SELECT 
        //             \'QTYNOTAVAILABLE\' AS t,
        //                 lilypad.qtynotavailable.PARTID AS PARTID,
        //                 lilypad.qtynotavailable.LOCATIONGROUPID AS LOCATIONGROUPID,
        //                 lilypad.qtynotavailable.QTY AS QTY
        //         FROM
        //             lilypad.qtynotavailable UNION SELECT 
        //             \'QTYNOTAVAILABLETOPICK\' AS t,
        //                 lilypad.qtynotavailabletopick.PARTID AS PARTID,
        //                 lilypad.qtynotavailabletopick.LOCATIONGROUPID AS LOCATIONGROUPID,
        //                 lilypad.qtynotavailabletopick.QTY AS QTY
        //         FROM
        //             lilypad.qtynotavailabletopick UNION SELECT 
        //             \'QTYDROPSHIP\' AS t,
        //                 lilypad.qtydropship.PARTID AS PARTID,
        //                 lilypad.qtydropship.LOCATIONGROUPID AS LOCATIONGROUPID,
        //                 lilypad.qtydropship.QTY AS QTY
        //         FROM
        //             lilypad.qtydropship UNION SELECT 
        //             \'QTYONORDERPO\' AS t,
        //                 lilypad.qtyonorderpo.PARTID AS PARTID,
        //                 lilypad.qtyonorderpo.LOCATIONGROUPID AS LOCATIONGROUPID,
        //                 lilypad.qtyonorderpo.QTY AS QTY
        //         FROM
        //             lilypad.qtyonorderpo UNION SELECT 
        //             \'QTYONORDERSO\' AS t,
        //                 lilypad.qtyonorderso.PARTID AS PARTID,
        //                 lilypad.qtyonorderso.LOCATIONGROUPID AS LOCATIONGROUPID,
        //                 lilypad.qtyonorderso.QTY AS QTY
        //         FROM
        //             lilypad.qtyonorderso UNION SELECT 
        //             \'QTYONORDERTORECEIVE\' AS t,
        //                 lilypad.qtyonordertoreceive.PARTID AS PARTID,
        //                 lilypad.qtyonordertoreceive.LOCATIONGROUPID AS LOCATIONGROUPID,
        //                 lilypad.qtyonordertoreceive.QTY AS QTY
        //         FROM
        //             lilypad.qtyonordertoreceive UNION SELECT 
        //             \'QTYONORDERTOSEND\' AS t,
        //                 lilypad.qtyonordertosend.PARTID AS PARTID,
        //                 lilypad.qtyonordertosend.LOCATIONGROUPID AS LOCATIONGROUPID,
        //                 lilypad.qtyonordertosend.QTY AS QTY
        //         FROM
        //             lilypad.qtyonordertosend UNION SELECT 
        //             \'QTYONORDERMO\' AS t,
        //                 lilypad.qtyonordermo.PARTID AS PARTID,
        //                 lilypad.qtyonordermo.LOCATIONGROUPID AS LOCATIONGROUPID,
        //                 lilypad.qtyonordermo.QTY AS QTY
        //         FROM
        //             lilypad.qtyonordermo) totalQty
        //     GROUP BY totalqty.PARTID, totalqty.LOCATIONGROUPID
        // ');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('qtyinventory_view');
    }
};
