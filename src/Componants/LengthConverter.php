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
            $result = new Metric(
                UnitConverter::convertLength((float) $length, UnitConverter::LENGTH_KM),
                static::getDolUnitId("size", "3"),
                $length
            );
        //====================================================================//
        // Length - Meter
        } elseif ($length >= 1) {
            $result = new Metric(
                UnitConverter::convertLength((float) $length, UnitConverter::LENGTH_M),
                static::getDolUnitId("size", "0"),
                $length
            );
        //====================================================================//
        // Length - DeciMeter
        } elseif ($length >= 1e-1) {
            $result = new Metric(
                UnitConverter::convertLength((float) $length, UnitConverter::LENGTH_DM),
                static::getDolUnitId("size", "-1"),
                $length
            );
        //====================================================================//
        // Length - CentiMeter
        } elseif ($length >= 1e-2) {
            $result = new Metric(
                UnitConverter::convertLength((float) $length, UnitConverter::LENGTH_CM),
                static::getDolUnitId("size", "-2"),
                $length
            );
        //====================================================================//
        // Length - MilliMeter
        } else {
            $result = new Metric(
                UnitConverter::convertLength((float) $length, UnitConverter::LENGTH_MM),
                static::getDolUnitId("size", "-3"),
                $length
            );
        }
        //====================================================================//
        // Prepare Value for Display
        if (function_exists("measuring_units_string")) {
            $result->setPrint(
                $result->getValue()." ".measuring_units_string($result->getUnit(), "size")
            );
        }

        return $result;
    }
}
