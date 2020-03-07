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
     * @return float Splash Unit Factor
     */
    protected static function detectUnit($unit, $fallBack)
    {
        //====================================================================//
        // BEFORE V10 => Dolibarr Unit Code Stored in Object
        if (Framework::dolVersionCmp("10.0.0") < 0) {
            if (isset(static::$knowUnits[$unit])) {
                return static::$knowUnits[$unit];
            }

            return $fallBack;
        }

        //====================================================================//
        // SINCE V10 => Dolibarr Unit Code Stored in Dictionnary
        if (!static::loadDolUnits() || !isset(static::$dico[$unit])) {
            return $fallBack;
        }
        if (isset(static::$knowUnits[$type][static::$dico[$unit]->scale])) {
            return static::$knowUnits[$type][static::$dico[$unit]->scale];
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
        // BEFORE V10 => Dolibarr Unit Code Stored in Object
        if (Framework::dolVersionCmp("10.0.0") < 0) {
            return $scale;
        }
        //====================================================================//
        // SINCE V10 => Dolibarr Unit Code Stored in Dictionnary
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
        // BEFORE V10 => Dolibarr Unit Code Stored in Object
        if (Framework::dolVersionCmp("10.0.0") < 0) {
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
            return Helper::log()->err($db->lasterror());
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
}
