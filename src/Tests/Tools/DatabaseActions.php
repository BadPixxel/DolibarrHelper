<?php

/*
 *  Copyright (C) 2021 BadPixxel <www.badpixxel.com>
 *
 *  This program is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 *
 *  For the full copyright and license information, please view the LICENSE
 *  file that was distributed with this source code.
 */

namespace BadPixxel\Dolibarr\Tests\Tools;

use DoliDB;
use PHPUnit\Framework\Assert;

/**
 * Execute Multiple Dolibarr Raw Actions
 */
class DatabaseActions
{
    /**
     * Check if Db has Table
     *
     * @global DoliDB $db
     *
     * @param string $table
     *
     * @return bool
     */
    public static function hasTable(string $table) : bool
    {
        global $db;

        $tables = $db->DDLListTables($db->database_name, MAIN_DB_PREFIX.$table);

        return !empty($tables);
    }

    /**
     * Delete a Db Table
     *
     * @global DoliDB $db
     *
     * @param string $table
     *
     * @return bool
     */
    public static function deleteTable(string $table) : bool
    {
        global $db;

        $db->query("SET FOREIGN_KEY_CHECKS = 0;");
        if (self::hasTable($table)) {
            $db->DDLDropTable(MAIN_DB_PREFIX.$table);
        }
        $db->query("SET FOREIGN_KEY_CHECKS = 1;");

        return !self::hasTable($table);
    }

    /**
     * Delete a Db Table
     *
     * @global DoliDB $db
     *
     * @param string $table
     *
     * @return bool
     */
    public static function truncateTable(string $table) : bool
    {
        global $db;

        if (!self::hasTable($table)) {
            return true;
        }

        $db->query("SET FOREIGN_KEY_CHECKS = 0;");

        $sql = "TRUNCATE TABLE ".MAIN_DB_PREFIX.$table.";";
        if (!$db->query($sql)) {
            throw new \Exception($db->lasterror);
        }

        $db->query("SET FOREIGN_KEY_CHECKS = 1;");

        return true;
    }

    /**
     * Check Db Table has Field
     *
     * @global DoliDB $db
     *
     * @param string $table
     * @param string $field
     * @param string $format
     *
     * @return void
     */
    public static function hasField(string $table, string $field, string $format = null)
    {
        global $db;
        //====================================================================//
        // Ensure Table Exists
        Assert::assertTrue(self::hasTable($table));
        //====================================================================//
        // Load List of Table Fields
        $tableInfos = $db->DDLInfoTable(MAIN_DB_PREFIX.$table);
        //====================================================================//
        // Search Field
        $tableField = null;
        foreach ($tableInfos as $fieldInfos) {
            if ($fieldInfos[0] == $field) {
                $tableField = $fieldInfos;
            }
        }
        Assert::assertIsArray($tableField);
        //====================================================================//
        // Verify Field Format
        if ($format) {
            Assert::assertEquals($format, $tableField[1]);
        }
    }
}
