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
            $result = new Metric(
                UnitConverter::convertWeight((float) $surface, UnitConverter::AREA_KM2),
                static::getDolUnitId("surface", "3"),
                $surface
            );
        //====================================================================//
        // Surface - Meter 2
        } elseif ($surface >= 1) {
            $result = new Metric(
                UnitConverter::convertWeight((float) $surface, UnitConverter::AREA_M2),
                static::getDolUnitId("surface", "0"),
                $surface
            );
        //====================================================================//
        // Surface - DecaMeter 2
        } elseif ($surface >= 1e-2) {
            $result = new Metric(
                UnitConverter::convertWeight((float) $surface, UnitConverter::AREA_DM2),
                static::getDolUnitId("surface", "-2"),
                $surface
            );
        //====================================================================//
        // Surface - CentiMeter 2
        } elseif ($surface >= 1e-4) {
            $result = new Metric(
                UnitConverter::convertWeight((float) $surface, UnitConverter::AREA_CM2),
                static::getDolUnitId("surface", "-4"),
                $surface
            );
        //====================================================================//
        // Surface - MilliMeter 2
        } elseif ($surface >= 1e-6) {
            $result = new Metric(
                UnitConverter::convertWeight((float) $surface, UnitConverter::AREA_MM2),
                static::getDolUnitId("surface", "-6"),
                $surface
            );
        }
        //====================================================================//
        // Prepare Value for Display
        if (function_exists("measuring_units_string")) {
            $result->setPrint(
                $result->getValue()." ".measuring_units_string($result->getUnit(), "surface")
            );
        }

        return $result;
    }
}
