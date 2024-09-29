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
        DB::statement('DROP VIEW IF EXISTS `' . env('DB_DATABASE') . '`.`qtyinventory`;');

        DB::statement('
            CREATE VIEW ' . env('DB_DATABASE') . '.qtyinventory AS
            SELECT 
                totalqty.PARTID AS PARTID,
                totalqty.LOCATIONGROUPID AS LOCATIONGROUPID,
                SUM((CASE
                    WHEN (totalqty.t = \'QTYONHAND\') THEN totalqty.QTY
                    ELSE 0
                END)) AS QTYONHAND,
                SUM((CASE
                    WHEN (totalqty.t = \'QTYALLOCATEDPO\') THEN totalqty.QTY
                    ELSE 0
                END)) AS QTYALLOCATEDPO,
                SUM((CASE
                    WHEN (totalqty.t = \'QTYALLOCATEDSO\') THEN totalqty.QTY
                    ELSE 0
                END)) AS QTYALLOCATEDSO,
                SUM((CASE
                    WHEN (totalqty.t = \'QTYALLOCATEDMO\') THEN totalqty.QTY
                    ELSE 0
                END)) AS QTYALLOCATEDMO,
                (SUM((CASE
                    WHEN (totalqty.t = \'QTYALLOCATEDTORECEIVE\') THEN totalqty.QTY
                    ELSE 0
                END)) + SUM((CASE
                    WHEN (totalqty.t = \'QTYALLOCATEDTOSEND\') THEN totalqty.QTY
                    ELSE 0
                END))) AS QTYALLOCATEDTO,
                SUM((CASE
                    WHEN (totalqty.t = \'QTYNOTAVAILABLE\') THEN totalqty.QTY
                    ELSE 0
                END)) AS QTYNOTAVAILABLE,
                SUM((CASE
                    WHEN (totalqty.t = \'QTYNOTAVAILABLETOPICK\') THEN totalqty.QTY
                    ELSE 0
                END)) AS QTYNOTAVAILABLETOPICK,
                SUM((CASE
                    WHEN (totalqty.t = \'QTYDROPSHIP\') THEN totalqty.QTY
                    ELSE 0
                END)) AS QTYDROPSHIP,
                SUM((CASE
                    WHEN (totalqty.t = \'QTYONORDERPO\') THEN totalqty.QTY
                    ELSE 0
                END)) AS QTYONORDERPO,
                SUM((CASE
                    WHEN (totalqty.t = \'QTYONORDERSO\') THEN totalqty.QTY
                    ELSE 0
                END)) AS QTYONORDERSO,
                (SUM((CASE
                    WHEN (totalqty.t = \'QTYONORDERTORECEIVE\') THEN totalqty.QTY
                    ELSE 0
                END)) + SUM((CASE
                    WHEN (totalqty.t = \'QTYONORDERTOSEND\') THEN totalqty.QTY
                    ELSE 0
                END))) AS QTYONORDERTO,
                SUM((CASE
                    WHEN (totalqty.t = \'QTYONORDERMO\') THEN totalqty.QTY
                    ELSE 0
                END)) AS QTYONORDERMO
            FROM
                (SELECT 
                    \'QTYONHAND\' AS t,
                        ' . env('DB_DATABASE') . '.qtyonhand.PARTID AS PARTID,
                        ' . env('DB_DATABASE') . '.qtyonhand.LOCATIONGROUPID AS LOCATIONGROUPID,
                        ' . env('DB_DATABASE') . '.qtyonhand.QTY AS QTY
                FROM
                    ' . env('DB_DATABASE') . '.qtyonhand UNION SELECT 
                    \'QTYALLOCATED\' AS t,
                        ' . env('DB_DATABASE') . '.qtyallocated.PARTID AS PARTID,
                        ' . env('DB_DATABASE') . '.qtyallocated.LOCATIONGROUPID AS LOCATIONGROUPID,
                        ' . env('DB_DATABASE') . '.qtyallocated.QTY AS QTY
                FROM
                    ' . env('DB_DATABASE') . '.qtyallocated UNION SELECT 
                    \'QTYALLOCATEDPO\' AS t,
                        ' . env('DB_DATABASE') . '.qtyallocatedpo.PARTID AS PARTID,
                        ' . env('DB_DATABASE') . '.qtyallocatedpo.LOCATIONGROUPID AS LOCATIONGROUPID,
                        ' . env('DB_DATABASE') . '.qtyallocatedpo.QTY AS QTY
                FROM
                    ' . env('DB_DATABASE') . '.qtyallocatedpo UNION SELECT 
                    \'QTYALLOCATEDSO\' AS t,
                        ' . env('DB_DATABASE') . '.qtyallocatedso.PARTID AS PARTID,
                        ' . env('DB_DATABASE') . '.qtyallocatedso.LOCATIONGROUPID AS LOCATIONGROUPID,
                        ' . env('DB_DATABASE') . '.qtyallocatedso.QTY AS QTY
                FROM
                    ' . env('DB_DATABASE') . '.qtyallocatedso UNION SELECT 
                    \'QTYALLOCATEDTORECEIVE\' AS t,
                        ' . env('DB_DATABASE') . '.qtyallocatedtoreceive.PARTID AS PARTID,
                        ' . env('DB_DATABASE') . '.qtyallocatedtoreceive.LOCATIONGROUPID AS LOCATIONGROUPID,
                        ' . env('DB_DATABASE') . '.qtyallocatedtoreceive.QTY AS QTY
                FROM
                    ' . env('DB_DATABASE') . '.qtyallocatedtoreceive UNION SELECT 
                    \'QTYALLOCATEDTOSEND\' AS t,
                        ' . env('DB_DATABASE') . '.qtyallocatedtosend.PARTID AS PARTID,
                        ' . env('DB_DATABASE') . '.qtyallocatedtosend.LOCATIONGROUPID AS LOCATIONGROUPID,
                        ' . env('DB_DATABASE') . '.qtyallocatedtosend.QTY AS QTY
                FROM
                    ' . env('DB_DATABASE') . '.qtyallocatedtosend UNION SELECT 
                    \'QTYALLOCATEDMO\' AS t,
                        ' . env('DB_DATABASE') . '.qtyallocatedmo.PARTID AS PARTID,
                        ' . env('DB_DATABASE') . '.qtyallocatedmo.LOCATIONGROUPID AS LOCATIONGROUPID,
                        ' . env('DB_DATABASE') . '.qtyallocatedmo.QTY AS QTY
                FROM
                    ' . env('DB_DATABASE') . '.qtyallocatedmo UNION SELECT 
                    \'QTYNOTAVAILABLE\' AS t,
                        ' . env('DB_DATABASE') . '.qtynotavailable.PARTID AS PARTID,
                        ' . env('DB_DATABASE') . '.qtynotavailable.LOCATIONGROUPID AS LOCATIONGROUPID,
                        ' . env('DB_DATABASE') . '.qtynotavailable.QTY AS QTY
                FROM
                    ' . env('DB_DATABASE') . '.qtynotavailable UNION SELECT 
                    \'QTYNOTAVAILABLETOPICK\' AS t,
                        ' . env('DB_DATABASE') . '.qtynotavailabletopick.PARTID AS PARTID,
                        ' . env('DB_DATABASE') . '.qtynotavailabletopick.LOCATIONGROUPID AS LOCATIONGROUPID,
                        ' . env('DB_DATABASE') . '.qtynotavailabletopick.QTY AS QTY
                FROM
                    ' . env('DB_DATABASE') . '.qtynotavailabletopick UNION SELECT 
                    \'QTYDROPSHIP\' AS t,
                        ' . env('DB_DATABASE') . '.qtydropship.PARTID AS PARTID,
                        ' . env('DB_DATABASE') . '.qtydropship.LOCATIONGROUPID AS LOCATIONGROUPID,
                        ' . env('DB_DATABASE') . '.qtydropship.QTY AS QTY
                FROM
                    ' . env('DB_DATABASE') . '.qtydropship UNION SELECT 
                    \'QTYONORDERPO\' AS t,
                        ' . env('DB_DATABASE') . '.qtyonorderpo.PARTID AS PARTID,
                        ' . env('DB_DATABASE') . '.qtyonorderpo.LOCATIONGROUPID AS LOCATIONGROUPID,
                        ' . env('DB_DATABASE') . '.qtyonorderpo.QTY AS QTY
                FROM
                    ' . env('DB_DATABASE') . '.qtyonorderpo UNION SELECT 
                    \'QTYONORDERSO\' AS t,
                        ' . env('DB_DATABASE') . '.qtyonorderso.PARTID AS PARTID,
                        ' . env('DB_DATABASE') . '.qtyonorderso.LOCATIONGROUPID AS LOCATIONGROUPID,
                        ' . env('DB_DATABASE') . '.qtyonorderso.QTY AS QTY
                FROM
                    ' . env('DB_DATABASE') . '.qtyonorderso UNION SELECT 
                    \'QTYONORDERTORECEIVE\' AS t,
                        ' . env('DB_DATABASE') . '.qtyonordertoreceive.PARTID AS PARTID,
                        ' . env('DB_DATABASE') . '.qtyonordertoreceive.LOCATIONGROUPID AS LOCATIONGROUPID,
                        ' . env('DB_DATABASE') . '.qtyonordertoreceive.QTY AS QTY
                FROM
                    ' . env('DB_DATABASE') . '.qtyonordertoreceive UNION SELECT 
                    \'QTYONORDERTOSEND\' AS t,
                        ' . env('DB_DATABASE') . '.qtyonordertosend.PARTID AS PARTID,
                        ' . env('DB_DATABASE') . '.qtyonordertosend.LOCATIONGROUPID AS LOCATIONGROUPID,
                        ' . env('DB_DATABASE') . '.qtyonordertosend.QTY AS QTY
                FROM
                    ' . env('DB_DATABASE') . '.qtyonordertosend UNION SELECT 
                    \'QTYONORDERMO\' AS t,
                        ' . env('DB_DATABASE') . '.qtyonordermo.PARTID AS PARTID,
                        ' . env('DB_DATABASE') . '.qtyonordermo.LOCATIONGROUPID AS LOCATIONGROUPID,
                        ' . env('DB_DATABASE') . '.qtyonordermo.QTY AS QTY
                FROM
                    ' . env('DB_DATABASE') . '.qtyonordermo) totalQty
            GROUP BY totalqty.PARTID, totalqty.LOCATIONGROUPID
        ');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement(' DROP VIEW IF EXISTS `' . env('DB_DATABASE') . '`.`qtyonorder`;');
    }
};
