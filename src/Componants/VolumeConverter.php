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
 * Dolibarr Volume Converter
 */
class VolumeConverter extends AbstractUnitConverter
{
    /**
     * @var array
     */
    protected static $knowUnits = array(
        "-9" => UnitConverter::VOLUME_MM3,
        "-6" => UnitConverter::VOLUME_CM3,
        "-3" => UnitConverter::VOLUME_DM3,
        "0" => UnitConverter::VOLUME_M3,
        "88" => UnitConverter::VOLUME_FOOT3,
        "89" => UnitConverter::VOLUME_INCH3,
        "97" => UnitConverter::VOLUME_OUNCE3,
        "98" => UnitConverter::VOLUME_LITER,
        "99" => UnitConverter::VOLUME_GALON,
    );

    /**
     * Convert Volume form all units to m3.
     *
     * @param null|float $volume Volume Value
     * @param int|string $unit   Volume Unit
     *
     * @return float Surface Value in m²
     */
    public static function convert($volume, $unit)
    {
        //====================================================================//
        // Detect Generic Unit Factor
        $factor = static::detectUnit((string) $unit, UnitConverter::VOLUME_M3);
        //====================================================================//
        // Convert Value to Generic Factor
        return UnitConverter::normalizeVolume((float) $volume, $factor);
    }

    /**
     * Return Normalized Volume form raw m3 value.
     *
     * @param null|float $volume Volume Raw Value
     *
     * @return Metric
     */
    public static function normalize($volume)
    {
        //====================================================================//
        // Volume - Meter 3
        if ($volume >= 1) {
            $factor = UnitConverter::VOLUME_M3;
            $unit = "0";
        //====================================================================//
        // Volume - DecaMeter 3
        } elseif ($volume >= 1e-3) {
            $factor = UnitConverter::VOLUME_DM3;
            $unit = "-3";
        //====================================================================//
        // Volume - CentiMeter 3
        } elseif ($volume >= 1e-6) {
            $factor = UnitConverter::VOLUME_CM3;
            $unit = "-6";
        //====================================================================//
        // Volume - MilliMeter 3
        } else {
            $factor = UnitConverter::VOLUME_MM3;
            $unit = "-9";
        }
        //====================================================================//
        // Build result
        $result = new Metric(
            UnitConverter::convertWeight((float) $volume, $factor),
            static::getDolUnitId("volume", (int) $unit),
            (float) $volume
        );
        //====================================================================//
        // Prepare Value for Display
        if (function_exists("measuring_units_string")) {
            $result->setPrint(
                $result->getValue()." ".measuring_units_string($unit, "volume")
            );
        }

        return $result;
    }
}
