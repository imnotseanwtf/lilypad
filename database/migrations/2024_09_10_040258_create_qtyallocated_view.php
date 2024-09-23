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
        CREATE VIEW lilypad.qtyallocated AS
        SELECT 
            totalqty.PARTID AS PARTID,
            totalqty.LOCATIONGROUPID AS LOCATIONGROUPID,
            COALESCE(SUM(totalqty.QTY), 0) AS QTY
        FROM
            (SELECT 
                \'SO\' AS t,
                    lilypad.qtyallocatedso.PARTID AS PARTID,
                    lilypad.qtyallocatedso.LOCATIONGROUPID AS LOCATIONGROUPID,
                    lilypad.qtyallocatedso.QTY AS QTY
            FROM
                lilypad.qtyallocatedso 
            UNION 
            SELECT 
                \'PO\' AS t,
                    lilypad.qtyallocatedpo.PARTID AS PARTID,
                    lilypad.qtyallocatedpo.LOCATIONGROUPID AS LOCATIONGROUPID,
                    lilypad.qtyallocatedpo.QTY AS QTY
            FROM
                lilypad.qtyallocatedpo 
            UNION 
            SELECT 
                \'TOSend\' AS t,
                    lilypad.qtyallocatedtosend.PARTID AS PARTID,
                    lilypad.qtyallocatedtosend.LOCATIONGROUPID AS LOCATIONGROUPID,
                    lilypad.qtyallocatedtosend.QTY AS QTY
            FROM
                lilypad.qtyallocatedtosend 
            UNION 
            SELECT 
                \'TOReceive\' AS t,
                    lilypad.qtyallocatedtoreceive.PARTID AS PARTID,
                    lilypad.qtyallocatedtoreceive.LOCATIONGROUPID AS LOCATIONGROUPID,
                    lilypad.qtyallocatedtoreceive.QTY AS QTY
            FROM
                lilypad.qtyallocatedtoreceive 
            UNION 
            SELECT 
                \'MO\' AS t,
                    lilypad.qtyallocatedmo.PARTID AS PARTID,
                    lilypad.qtyallocatedmo.LOCATIONGROUPID AS LOCATIONGROUPID,
                    lilypad.qtyallocatedmo.QTY AS QTY
            FROM
                lilypad.qtyallocatedmo
            ) totalQty
        GROUP BY totalqty.PARTID, totalqty.LOCATIONGROUPID
    ');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('qtyallocated_view');
    }
};
