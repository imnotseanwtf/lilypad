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
        DB::statement('DROP VIEW IF EXISTS `' . env('DB_DATABASE') . '`.`customerfieldview`;');

        DB::statement('
        SELECT 
            `' . env('DB_DATABASE') . '`.`customfield`.`id` AS `cfID`,
            `' . env('DB_DATABASE') . '`.`customfield`.`name` AS `cfName`,
            `' . env('DB_DATABASE') . '`.`customfield`.`description` AS `cfDescription`,
            `' . env('DB_DATABASE') . '`.`customfield`.`sortOrder` AS `cfSortOrder`,
            `' . env('DB_DATABASE') . '`.`customfield`.`tableId` AS `cfTableID`,
            `' . env('DB_DATABASE') . '`.`customfield`.`customFieldTypeId` AS `cfTypeID`,
            `' . env('DB_DATABASE') . '`.`customfield`.`required` AS `cfRequired`,
            `' . env('DB_DATABASE') . '`.`po`.`id` AS `recordID`,
            JSON_UNQUOTE(JSON_EXTRACT(`' . env('DB_DATABASE') . '`.`po`.`customFields`, CONCAT(\'$."\', `' . env('DB_DATABASE') . '`.`customfield`.`id`, \'".value\'))) AS `info`
        FROM `' . env('DB_DATABASE') . '`.`customfield`
        LEFT JOIN `' . env('DB_DATABASE') . '`.`po` 
            ON `' . env('DB_DATABASE') . '`.`customfield`.`tableId` = 397076832
            AND `' . env('DB_DATABASE') . '`.`po`.`customFields` IS NOT NULL
            AND JSON_EXTRACT(`' . env('DB_DATABASE') . '`.`po`.`customFields`, CONCAT(\'$."\', `' . env('DB_DATABASE') . '`.`customfield`.`id`, \'".value\')) IS NOT NULL
            AND JSON_EXTRACT(`' . env('DB_DATABASE') . '`.`po`.`customFields`, CONCAT(\'$."\', `' . env('DB_DATABASE') . '`.`customfield`.`id`, \'".value\')) <> \'\'
    
        UNION SELECT 
            `' . env('DB_DATABASE') . '`.`customfield`.`id` AS `cfID`,
            `' . env('DB_DATABASE') . '`.`customfield`.`name` AS `cfName`,
            `' . env('DB_DATABASE') . '`.`customfield`.`description` AS `cfDescription`,
            `' . env('DB_DATABASE') . '`.`customfield`.`sortOrder` AS `cfSortOrder`,
            `' . env('DB_DATABASE') . '`.`customfield`.`tableId` AS `cfTableID`,
            `' . env('DB_DATABASE') . '`.`customfield`.`customFieldTypeId` AS `cfTypeID`,
            `' . env('DB_DATABASE') . '`.`customfield`.`required` AS `cfRequired`,
            `' . env('DB_DATABASE') . '`.`poitem`.`id` AS `recordID`,
            JSON_UNQUOTE(JSON_EXTRACT(`' . env('DB_DATABASE') . '`.`poitem`.`customFields`, CONCAT(\'$."\', `' . env('DB_DATABASE') . '`.`customfield`.`id`, \'".value\'))) AS `info`
        FROM `' . env('DB_DATABASE') . '`.`customfield`
        LEFT JOIN `' . env('DB_DATABASE') . '`.`poitem` 
            ON `' . env('DB_DATABASE') . '`.`customfield`.`tableId` = -1200586080
            AND `' . env('DB_DATABASE') . '`.`poitem`.`customFields` IS NOT NULL
            AND JSON_EXTRACT(`' . env('DB_DATABASE') . '`.`poitem`.`customFields`, CONCAT(\'$."\', `' . env('DB_DATABASE') . '`.`customfield`.`id`, \'".value\')) IS NOT NULL
            AND JSON_EXTRACT(`' . env('DB_DATABASE') . '`.`poitem`.`customFields`, CONCAT(\'$."\', `' . env('DB_DATABASE') . '`.`customfield`.`id`, \'".value\')) <> \'\'
    
        UNION SELECT 
            `' . env('DB_DATABASE') . '`.`customfield`.`id` AS `cfID`,
            `' . env('DB_DATABASE') . '`.`customfield`.`name` AS `cfName`,
            `' . env('DB_DATABASE') . '`.`customfield`.`description` AS `cfDescription`,
            `' . env('DB_DATABASE') . '`.`customfield`.`sortOrder` AS `cfSortOrder`,
            `' . env('DB_DATABASE') . '`.`customfield`.`tableId` AS `cfTableID`,
            `' . env('DB_DATABASE') . '`.`customfield`.`customFieldTypeId` AS `cfTypeID`,
            `' . env('DB_DATABASE') . '`.`customfield`.`required` AS `cfRequired`,
            `' . env('DB_DATABASE') . '`.`woinstruction`.`id` AS `recordID`,
            JSON_UNQUOTE(JSON_EXTRACT(`' . env('DB_DATABASE') . '`.`woinstruction`.`customFields`, CONCAT(\'$."\', `' . env('DB_DATABASE') . '`.`customfield`.`id`, \'".value\'))) AS `info`
        FROM `' . env('DB_DATABASE') . '`.`customfield`
        LEFT JOIN `' . env('DB_DATABASE') . '`.`woinstruction` 
            ON `' . env('DB_DATABASE') . '`.`customfield`.`tableId` = -123456789
            AND `' . env('DB_DATABASE') . '`.`woinstruction`.`customFields` IS NOT NULL
            AND JSON_EXTRACT(`' . env('DB_DATABASE') . '`.`woinstruction`.`customFields`, CONCAT(\'$."\', `' . env('DB_DATABASE') . '`.`customfield`.`id`, \'".value\')) IS NOT NULL
            AND JSON_EXTRACT(`' . env('DB_DATABASE') . '`.`woinstruction`.`customFields`, CONCAT(\'$."\', `' . env('DB_DATABASE') . '`.`customfield`.`id`, \'".value\')) <> \'\'
    
        UNION SELECT 
            `' . env('DB_DATABASE') . '`.`customfield`.`id` AS `cfID`,
            `' . env('DB_DATABASE') . '`.`customfield`.`name` AS `cfName`,
            `' . env('DB_DATABASE') . '`.`customfield`.`description` AS `cfDescription`,
            `' . env('DB_DATABASE') . '`.`customfield`.`sortOrder` AS `cfSortOrder`,
            `' . env('DB_DATABASE') . '`.`customfield`.`tableId` AS `cfTableID`,
            `' . env('DB_DATABASE') . '`.`customfield`.`customFieldTypeId` AS `cfTypeID`,
            `' . env('DB_DATABASE') . '`.`customfield`.`required` AS `cfRequired`,
            `' . env('DB_DATABASE') . '`.`location`.`id` AS `recordID`,
            JSON_UNQUOTE(JSON_EXTRACT(`' . env('DB_DATABASE') . '`.`location`.`customFields`, CONCAT(\'$."\', `' . env('DB_DATABASE') . '`.`customfield`.`id`, \'".value\'))) AS `info`
        FROM `' . env('DB_DATABASE') . '`.`customfield`
        LEFT JOIN `' . env('DB_DATABASE') . '`.`location` 
            ON `' . env('DB_DATABASE') . '`.`customfield`.`tableId` = -1559972096
            AND `' . env('DB_DATABASE') . '`.`location`.`customFields` IS NOT NULL
            AND JSON_EXTRACT(`' . env('DB_DATABASE') . '`.`location`.`customFields`, CONCAT(\'$."\', `' . env('DB_DATABASE') . '`.`customfield`.`id`, \'".value\')) IS NOT NULL
            AND JSON_EXTRACT(`' . env('DB_DATABASE') . '`.`location`.`customFields`, CONCAT(\'$."\', `' . env('DB_DATABASE') . '`.`customfield`.`id`, \'".value\')) <> \'\'
    ');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement('DROP VIEW IF EXISTS `' . env('DB_DATABASE') . '`.`customerfieldview`;');
    }
};
