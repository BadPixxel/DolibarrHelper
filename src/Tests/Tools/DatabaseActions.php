<?php

/*
 * This file is part of BadPixxel Dolibarr Helper Library.
 *
 * Copyright (C) 2015-2020 BadPixxel  <www.badpixxel.com>
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace BadPixxel\Dolibarr\Tests\Tools;

use DoliDB;

/**
 * @abstract    Execute Multiple Dolibarr Raw Actions
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
    public static function dbDeleteTable(string $table) : bool
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
    public static function dbTruncateTable(string $table) : bool
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
}
