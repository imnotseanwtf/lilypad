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
        DB::statement('DROP VIEW IF EXISTS `' . env('DB_DATABASE') . '`.`qtyallocatedso`;');

        DB::statement('
    CREATE VIEW `' . env('DB_DATABASE') . '`.`qtyallocatedso` AS
    SELECT 
        `part`.`id` AS `PARTID`,
        `so`.`locationGroupId` AS `LOCATIONGROUPID`,
        COALESCE(SUM(`soitem`.`qtyToFulfill` - `soitem`.`qtyFulfilled`), 0) AS `QTY`
    FROM
        `part`
    JOIN `product` 
        ON `part`.`id` = `product`.`partId`    
    JOIN `soitem` 
        ON `product`.`id` = `soitem`.`productId`
    JOIN `so` 
        ON `so`.`id` = `soitem`.`soId`
    WHERE
        `so`.`statusId` IN (20, 25)
        AND `soitem`.`statusId` IN (10, 14, 20, 30, 40)
        AND `soitem`.`typeId` IN (10, 12)
        AND `part`.`typeId` = 10
    GROUP BY `part`.`id`, `so`.`locationGroupId`;
');

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement('DROP VIEW IF EXISTS `' . env('DB_DATABASE') . '`.`qtyallocatedso`;');
    }
};
