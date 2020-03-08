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
 * Dolibarr Length Converter
 */
class LengthConverter extends AbstractUnitConverter
{
    /**
     * @var array
     */
    protected static $knowUnits = array(
        "-3" => UnitConverter::LENGTH_MILIMETER,
        "-2" => UnitConverter::LENGTH_CENTIMETER,
        "-1" => UnitConverter::LENGTH_DECIMETER,
        "0" => UnitConverter::LENGTH_METER,
        "3" => UnitConverter::LENGTH_KM,
        "98" => UnitConverter::LENGTH_FOOT,
        "99" => UnitConverter::LENGTH_INCH,
    );

    /**
     * Convert Lenght form all units to m.
     *
     * @param null|float $length Length Value
     * @param int|string $unit   Length Unit
     *
     * @return float Length Value in m
     */
    public static function convert($length, $unit)
    {
        //====================================================================//
        // Detect Generic Unit Factor
        $factor = static::detectUnit((string) $unit, UnitConverter::LENGTH_M);
        //====================================================================//
        // Convert Value to Generic Factor
        return UnitConverter::normalizeLength((float) $length, $factor);
    }

    /**
     * Return Normalized Length form raw m value.
     *
     * @param null|float $length Length Raw Value
     *
     * @return Metric
     */
    public static function normalize($length)
    {
        //====================================================================//
        // Length - KiloMeter
        if ($length >= 1E3) {
            $factor = UnitConverter::LENGTH_KM;
            $unit = "3";
        //====================================================================//
        // Length - Meter
        } elseif ($length >= 1) {
            $factor = UnitConverter::LENGTH_M;
            $unit = "0";
        //====================================================================//
        // Length - DeciMeter
        } elseif ($length >= 1e-1) {
            $factor = UnitConverter::LENGTH_DM;
            $unit = "-1";
        //====================================================================//
        // Length - CentiMeter
        } elseif ($length >= 1e-2) {
            $factor = UnitConverter::LENGTH_CM;
            $unit = "-2";
        //====================================================================//
        // Length - MilliMeter
        } else {
            $factor = UnitConverter::LENGTH_MM;
            $unit = "-3";
        }
        //====================================================================//
        // Build result
        $result = new Metric(
            UnitConverter::convertWeight((float) $length, $factor),
            static::getDolUnitId("size", (int) $unit),
            (float) $length
        );
        //====================================================================//
        // Prepare Value for Display
        if (function_exists("measuring_units_string")) {
            $result->setPrint(
                $result->getValue()." ".measuring_units_string($unit, "size")
            );
        }

        return $result;
    }
}
