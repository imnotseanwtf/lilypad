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
            CREATE VIEW lilypad.qtyonhand AS
            SELECT 
                lilypad.tag.partId AS PARTID,
                lilypad.location.locationGroupId AS LOCATIONGROUPID,
                COALESCE(SUM(lilypad.tag.qty), 0) AS QTY
            FROM
                lilypad.tag
            JOIN lilypad.location 
                ON lilypad.location.id = lilypad.tag.locationId
            WHERE
                lilypad.tag.typeId IN (30, 40)
            GROUP BY 
                lilypad.location.locationGroupId, 
                lilypad.tag.partId
        ');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('qtyonhand_view');
    }
};
