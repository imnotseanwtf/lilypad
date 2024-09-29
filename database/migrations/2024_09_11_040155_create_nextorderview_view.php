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
        DB::statement('DROP VIEW IF EXISTS `' . env('DB_DATABASE') . '`.`nextorderview`;');

        DB::statement('
    CREATE 
    ALGORITHM = UNDEFINED 
    DEFINER = `root`@`localhost` 
    SQL SECURITY DEFINER
    VIEW `' . env('DB_DATABASE') . '`.`nextorderview` AS
    SELECT 
        `po`.`num` AS `NUM`,
        `po`.`id` AS `ID`,
        CONCAT("10:", `poitem`.`id`) AS `VIEWID`,
        `poitem`.`dateScheduledFulfillment` AS `DATESCHEDULEDFULFILLMENT`,
        SUM(`poitem`.`qtyToFulfill`) AS `QTYTOFULFILL`,
        SUM(`poitem`.`qtyFulfilled`) AS `QTYFULFILLED`,
        `poitem`.`uomId` AS `ORDERITEMUOMID`,
        `poitem`.`note` AS `NOTE`,
        `part`.`uomId` AS `PARTUOMID`,
        10 AS `TYPEID`,
        `poitem`.`partId` AS `PARTID`,
        `po`.`locationGroupId` AS `LOCATIONGROUPID`,
        `po`.`statusId` AS `ORDERSTATUSID`,
        `poitem`.`statusId` AS `ITEMSTATUSID`
    FROM
        `poitem`
    JOIN `po` ON `po`.`id` = `poitem`.`poId`
    JOIN `part` ON `part`.`id` = `poitem`.`partId`
    WHERE
        (`poitem`.`qtyToFulfill` - `poitem`.`qtyFulfilled`) > 0
    GROUP BY 
        `po`.`num`, `po`.`id`, `VIEWID`, `poitem`.`dateScheduledFulfillment`,
        `poitem`.`uomId`, `poitem`.`note`, `part`.`uomId`, `TYPEID`,
        `poitem`.`partId`, `po`.`locationGroupId`, `po`.`statusId`, `poitem`.`statusId`
        
    UNION
    
    SELECT 
        `wo`.`num` AS `NUM`,
        `wo`.`id` AS `ID`,
        CONCAT("30:", `woitem`.`id`) AS `VIEWID`,
        `wo`.`dateScheduled` AS `DATESCHEDULEDFULFILLMENT`,
        SUM(`woitem`.`qtyTarget`) AS `QTYTOFULFILL`,
        SUM(`woitem`.`qtyUsed`) AS `QTYFULFILLED`,
        `woitem`.`uomId` AS `ORDERITEMUOMID`,
        `wo`.`note` AS `NOTE`,
        `part`.`uomId` AS `PARTUOMID`,
        30 AS `TYPEID`,
        `woitem`.`partId` AS `PARTID`,
        `wo`.`locationGroupId` AS `LOCATIONGROUPID`,
        `wo`.`statusId` AS `ORDERSTATUSID`,
        0 AS `ITEMSTATUSID`
    FROM
        `woitem`
    JOIN `wo` ON `wo`.`id` = `woitem`.`woId`
    JOIN `part` ON `part`.`id` = `woitem`.`partId`
    WHERE
        (`woitem`.`qtyTarget` - `woitem`.`qtyUsed`) > 0
        AND `woitem`.`typeId` IN (10, 31)
    GROUP BY 
        `wo`.`num`, `wo`.`id`, `VIEWID`, `wo`.`dateScheduled`,
        `woitem`.`uomId`, `wo`.`note`, `part`.`uomId`, `TYPEID`,
        `woitem`.`partId`, `wo`.`locationGroupId`, `wo`.`statusId`, `ITEMSTATUSID`
        
    UNION
    
    SELECT 
        `so`.`num` AS `NUM`,
        `so`.`id` AS `ID`,
        CONCAT("20:", `soitem`.`id`) AS `VIEWID`,
        `soitem`.`dateScheduledFulfillment` AS `DATESCHEDULEDFULFILLMENT`,
        SUM(`soitem`.`qtyToFulfill`) AS `QTYTOFULFILL`,
        SUM(`soitem`.`qtyFulfilled`) AS `QTYFULFILLED`,
        `soitem`.`uomId` AS `ORDERITEMUOMID`,
        `soitem`.`note` AS `NOTE`,
        `part`.`uomId` AS `PARTUOMID`,
        20 AS `TYPEID`,
        `part`.`id` AS `PARTID`,
        `so`.`locationGroupId` AS `LOCATIONGROUPID`,
        `so`.`statusId` AS `ORDERSTATUSID`,
        `soitem`.`statusId` AS `ITEMSTATUSID`
    FROM
        `soitem`
    JOIN `so` ON `so`.`id` = `soitem`.`soId`
    JOIN `product` ON `soitem`.`productId` = `product`.`id`
    JOIN `part` ON `part`.`id` = `product`.`partId`
    WHERE
        (`soitem`.`qtyToFulfill` - `soitem`.`qtyFulfilled`) > 0
        AND `soitem`.`typeId` = 20
    GROUP BY 
        `so`.`num`, `so`.`id`, `VIEWID`, `soitem`.`dateScheduledFulfillment`,
        `soitem`.`uomId`, `soitem`.`note`, `part`.`uomId`, `TYPEID`,
        `part`.`id`, `so`.`locationGroupId`, `so`.`statusId`, `soitem`.`statusId`
');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement('DROP VIEW IF EXISTS `' . env('DB_DATABASE') . '`.`nextorderview`;');
    }
};
