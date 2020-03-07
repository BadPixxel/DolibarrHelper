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
            $result = new Metric(
                UnitConverter::convertWeight((float) $weight, UnitConverter::MASS_TONNE),
                static::getDolUnitId("weight", 3),
                (float) $weight
            );
        //====================================================================//
        // Weight - KiloGram
        } elseif ($weight >= 1) {
            $result = new Metric(
                UnitConverter::convertWeight((float) $weight, UnitConverter::MASS_KILOGRAM),
                static::getDolUnitId("weight", 0),
                (float) $weight
            );
        //====================================================================//
        // Weight - Gram
        } elseif ($weight >= 1e-3) {
            $result = new Metric(
                UnitConverter::convertWeight((float) $weight, UnitConverter::MASS_GRAM),
                static::getDolUnitId("weight", -3),
                (float) $weight
            );
        //====================================================================//
        // Weight - MilliGram
        } else {
            $result = new Metric(
                UnitConverter::convertWeight((float) $weight, UnitConverter::MASS_MILLIGRAM),
                static::getDolUnitId("weight", -6),
                (float) $weight
            );
        }
        //====================================================================//
        // Prepare Value for Display
        if (function_exists("measuring_units_string")) {
            $result->setPrint(
                $result->getValue()." ".measuring_units_string($result->getUnit(), "weight")
            );
        }

        return $result;
    }
}
