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
    CREATE VIEW lilypad.qtyallocatedso AS
    SELECT 
        lilypad.part.id AS PARTID,
        lilypad.so.locationGroupId AS LOCATIONGROUPID,
        COALESCE(SUM(lilypad.soitem.qtyToFulfill - lilypad.soitem.qtyFulfilled), 0) AS QTY
    FROM
        lilypad.part
    JOIN lilypad.product 
        ON lilypad.part.id = lilypad.product.partId    JOIN lilypad.soitem 
        ON lilypad.product.id = lilypad.soitem.productId
    JOIN lilypad.so 
        ON lilypad.so.id = lilypad.soitem.soId
    WHERE
        lilypad.so.statusId IN (20, 25)
        AND lilypad.soitem.statusId IN (10, 14, 20, 30, 40)
        AND lilypad.soitem.typeId IN (10, 12)
        AND lilypad.part.typeId = 10
    GROUP BY lilypad.part.id, lilypad.so.locationGroupId
');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('qtyallocatedso_view');
    }
};
