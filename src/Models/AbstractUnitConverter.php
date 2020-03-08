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

namespace BadPixxel\Dolibarr\Models;

use BadPixxel\Dolibarr\Helper;
use BadPixxel\Dolibarr\Helpers\Framework;

/**
 * Abstract Unit Converter
 */
abstract class AbstractUnitConverter
{
    /**
     * Current Install Units Dictionnary
     *
     * @var array
     */
    protected static $dico;

    /**
     * List of Known Dolibarr Units factors
     *
     * @var array
     */
    protected static $knowUnits = array();

    /**
     * Detect Unit from Object or Database Dictionary.
     *
     * @param string $unit     Raw Unit Code or Database Id
     * @param float  $fallBack FallBack Splash Unit Code
     *
     * @return float Unit Factor
     */
    protected static function detectUnit(string $unit, float $fallBack)
    {
        //====================================================================//
        // STANDARD => Dolibarr Unit Scale Factored Stored in Objects
        if (!self::useDatabaseUnitsIds()) {
            if (isset(static::$knowUnits[$unit])) {
                return static::$knowUnits[$unit];
            }

            return $fallBack;
        }
        //====================================================================//
        // V10.0.0 to V10.0.2 => Dolibarr Unit IDs Stored in Object
        if (!static::loadDolUnits() || !isset(static::$dico[$unit])) {
            return $fallBack;
        }
        if (isset(static::$knowUnits[static::$dico[$unit]->scale])) {
            return static::$knowUnits[static::$dico[$unit]->scale];
        }

        return $fallBack;
    }

    /**
     * Identify Dolibarr Unit from Scale.
     *
     * @param string $type
     * @param int    $scale
     *
     * @return int
     */
    protected static function getDolUnitId(string $type, int $scale)
    {
        //====================================================================//
        // STANDARD => Dolibarr Unit Scale Factored Stored in Objects
        if (!self::useDatabaseUnitsIds()) {
            return $scale;
        }
        //====================================================================//
        // V10.0.0 to V10.0.2 => Dolibarr Unit IDs Stored in Object
        if (!static::loadDolUnits()) {
            return 0;
        }
        //====================================================================//
        // Search for Unit in Dictionnary
        foreach (static::$dico as $cUnit) {
            if ($cUnit->unit_type != $type) {
                continue;
            }
            if ($cUnit->scale != $scale) {
                continue;
            }

            return (int) $cUnit->id;
        }

        return 0;
    }

    /**
     * Load Units Scales from Dictionary in Database.
     *
     * @return bool
     */
    private static function loadDolUnits(): bool
    {
        global $db;
        //====================================================================//
        // STANDARD => Dolibarr Unit Scale Factored Stored in Objects
        if (!self::useDatabaseUnitsIds()) {
            return true;
        }
        //====================================================================//
        // Dictionnary Already Loaded
        if (isset(static::$dico)) {
            return true;
        }
        //====================================================================//
        // Load Dictionnary Already Loaded
        static::$dico = array();
        $sql = "SELECT t.rowid as id, t.code, t.label, t.short_label, t.unit_type, t.scale, t.active";
        $sql .= " FROM ".MAIN_DB_PREFIX."c_units as t WHERE t.active=1";
        $resql = $db->query($sql);
        if (!$resql) {
            return Helper::log()->error($db->lasterror());
        }
        //====================================================================//
        // Parse Dictionnary to Cache
        $num = $db->num_rows($resql);
        if ($num > 0) {
            while ($obj = $db->fetch_object($resql)) {
                static::$dico[$obj->id] = $obj;
            }
        }
        $db->free($resql);

        return true;
    }

    /**
     * Detect if Stored Units are Scales or Database Dictionary IDs.
     *
     * V10.0.0 to V10.0.2 => Dolibarr Unit IDs Stored in Objects
     *
     * @return bool TRUE if Database
     */
    private static function useDatabaseUnitsIds(): bool
    {
        if (Framework::dolVersionCmp("10.0.0") < 0) {
            return false;
        }
        if (Framework::dolVersionCmp("10.0.2") > 0) {
            return false;
        }

        return true;
    }
}
