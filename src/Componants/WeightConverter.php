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
 * Dolibarr Weight Converter
 */
class WeightConverter extends AbstractUnitConverter
{
    /**
     * @var array
     */
    protected static $knowUnits = array(
        "-9" => UnitConverter::MASS_MICROGRAM,
        "-6" => UnitConverter::MASS_MILLIGRAM,
        "-3" => UnitConverter::MASS_GRAM,
        "0" => UnitConverter::MASS_KILOGRAM,
        "3" => UnitConverter::MASS_TONNE,
        "98" => UnitConverter::MASS_OUNCE,
        "99" => UnitConverter::MASS_LIVRE,
    );

    /**
     * Convert Weight form all units to kg.
     *
     * @param null|float $weight Weight Value
     * @param int|string $unit   Weight Unit
     *
     * @return float Weight Value in kg
     */
    public static function convert($weight, $unit)
    {
        //====================================================================//
        // Detect Generic Unit Factor
        $factor = static::detectUnit((string) $unit, UnitConverter::MASS_KG);
        //====================================================================//
        // Convert Value to Generic Factor
        return UnitConverter::normalizeWeight((float) $weight, $factor);
    }

    /**
     * Return Normalized Weight form raw kg value.
     *
     * @param null|float $weight Weight Raw Value
     *
     * @return Metric
     */
    public static function normalize($weight)
    {
        //====================================================================//
        // Weight - Tonne
        if ($weight >= 1e3) {
            $factor = UnitConverter::MASS_TONNE;
            $unit = "3";
        //====================================================================//
        // Weight - KiloGram
        } elseif ($weight >= 1) {
            $factor = UnitConverter::MASS_KILOGRAM;
            $unit = "0";
        //====================================================================//
        // Weight - Gram
        } elseif ($weight >= 1e-3) {
            $factor = UnitConverter::MASS_GRAM;
            $unit = "-3";
        //====================================================================//
        // Weight - MilliGram
        } else {
            $factor = UnitConverter::MASS_MILLIGRAM;
            $unit = "-6";
        }
        //====================================================================//
        // Build result
        $result = new Metric(
            UnitConverter::convertWeight((float) $weight, $factor),
            static::getDolUnitId("weight", (int) $unit),
            (float) $weight
        );
        //====================================================================//
        // Prepare Value for Display
        if (function_exists("measuring_units_string")) {
            $result->setPrint(
                $result->getValue()." ".measuring_units_string($unit, "weight")
            );
        }

        return $result;
    }
}
