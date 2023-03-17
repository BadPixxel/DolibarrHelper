<?php

/*
 *  Copyright (C) BadPixxel <www.badpixxel.com>
 *
 *  This program is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 *
 *  For the full copyright and license information, please view the LICENSE
 *  file that was distributed with this source code.
 */

namespace BadPixxel\Dolibarr\Componants;

use BadPixxel\Dolibarr\Models\AbstractUnitConverter;
use BadPixxel\Dolibarr\Models\Metric;

/**
 * Dolibarr Surface Converter
 */
class SurfaceConverter extends AbstractUnitConverter
{
    /**
     * @var array
     */
    protected static $knowUnits = array(
        "-6" => UnitConverter::AREA_MM2,
        "-4" => UnitConverter::AREA_CM2,
        "-2" => UnitConverter::AREA_DM2,
        "0" => UnitConverter::AREA_M2,
        "3" => UnitConverter::AREA_KM2,
        "98" => UnitConverter::AREA_FOOT2,
        "99" => UnitConverter::AREA_INCH2,
    );

    /**
     * Convert Surface form all units to m².
     *
     * @param null|float $surface Surface Value
     * @param int|string $unit    Surface Unit
     *
     * @return float Surface Value in m²
     */
    public static function convert($surface, $unit)
    {
        //====================================================================//
        // Detect Generic Unit Factor
        $factor = static::detectUnit((string) $unit, UnitConverter::AREA_M2);
        //====================================================================//
        // Convert Value to Generic Factor
        return UnitConverter::normalizeSurface((float) $surface, $factor);
    }

    /**
     * Return Normalized Surface form raw m2 value.
     *
     * @param null|float $surface Surface Raw Value
     *
     * @return Metric
     */
    public static function normalize($surface)
    {
        //====================================================================//
        // Surface - KiloMeter 2
        if ($surface >= 1E3) {
            $factor = UnitConverter::AREA_KM2;
            $unit = "3";
        //====================================================================//
        // Surface - Meter 2
        } elseif ($surface >= 1) {
            $factor = UnitConverter::AREA_M2;
            $unit = "0";
        //====================================================================//
        // Surface - DecaMeter 2
        } elseif ($surface >= 1e-2) {
            $factor = UnitConverter::AREA_DM2;
            $unit = "-2";
        //====================================================================//
        // Surface - CentiMeter 2
        } elseif ($surface >= 1e-4) {
            $factor = UnitConverter::AREA_CM2;
            $unit = "-4";
        //====================================================================//
        // Surface - MilliMeter 2
        } else {
            $factor = UnitConverter::AREA_MM2;
            $unit = "-6";
        }
        //====================================================================//
        // Build result
        $result = new Metric(
            UnitConverter::convertWeight((float) $surface, $factor),
            static::getDolUnitId("surface", (int) $unit),
            (float) $surface
        );
        //====================================================================//
        // Prepare Value for Display
        if (function_exists("measuring_units_string")) {
            $result->setPrint(
                $result->getValue()." ".measuring_units_string($unit, "surface")
            );
        }

        return $result;
    }
}
