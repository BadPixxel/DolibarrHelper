<?php

/*
 * This file is part of BadPixxel Dolibarr Helper Library.
 *
 * Copyright (C) 2015-2019 BadPixxel  <www.badpixxel.com>
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace BadPixxel\Dolibarr\Helpers;

use ArrayObject;

/**
 * Dolibarr Unit Converter
 *
 * @SuppressWarnings(PHPMD.ExcessiveClassComplexity)
 */
class Units
{
    /**
     * Convert Weight form all units to kg.
     *
     * @param float $weight Weight Value
     * @param int   $unit   Weight Unit
     *
     * @return float Weight Value in kg
     */
    public static function convertWeight(float $weight, int $unit): float
    {
        //====================================================================//
        // mg
        if (-6 == $unit) {
            return $weight * 1e-6;
        }
        //====================================================================//
        // g
        if (-3 == $unit) {
            return $weight * 1e-3;
        }
        //====================================================================//
        // kg
        if (0 == $unit) {
            return $weight;
        }
        //====================================================================//
        // Tonne
        if (3 == $unit) {
            return $weight * 1e3;
        }
        //====================================================================//
        // livre
        if (99 == $unit) {
            return $weight * 0.45359237;
        }

        return 0;
    }

    /**
     * Return Normalized Weight form raw kg value.
     *
     * @param float $weight Weight Raw Value
     *
     * @return arrayobject $r->weight , $r->weight_units , $r->print, $r->raw
     */
    public static function normalizeWeight(float $weight): ArrayObject
    {
        //====================================================================//
        // Include Needed Dolibarr Functions Libraries
        dol_include_once('/core/lib/product.lib.php');
        //====================================================================//
        // Create Result
        $result = new ArrayObject();
        //====================================================================//
        // Tonne
        if ($weight >= 1e3) {
            $result->weight = $weight * 1e-3;
            $result->weight_units = 3;
        //====================================================================//
        // Kg
        } elseif ($weight >= 1) {
            $result->weight = $weight;
            $result->weight_units = 0;
        //====================================================================//
        // Gram
        } elseif ($weight >= 1e-3) {
            $result->weight = $weight * 1e3;
            $result->weight_units = "-3";
        //====================================================================//
        // MilliGrams
        } elseif ($weight >= 1e-6) {
            $result->weight = $weight * 1e6;
            $result->weight_units = "-6";
        }
        //====================================================================//
        // Prepare Value for Display
        $result->print = $result->weight." ".measuring_units_string($result->weight_units, "weight");
        //====================================================================//
        // Copy Raw Value for Computation
        $result->raw = $weight;

        return $result;
    }

    /**
     * Convert Lenght form all units to m.
     *
     * @param float $length Length Value
     * @param int   $unit   Length Unit
     *
     * @return float Length Value in m
     */
    public static function convertLength(float $length, int $unit): float
    {
        //====================================================================//
        // MM
        if ("-3" == $unit) {
            return $length / 1e3;
        }
        //====================================================================//
        // CM
        if ("-2" == $unit) {
            return $length / 1e2;
        }
        //====================================================================//
        // DM
        if ("-1" == $unit) {
            return $length / 10;
        }
        //====================================================================//
        // M
        if ("0" == $unit) {
            return $length;
        }
        //====================================================================//
        // Foot
        if ("98" == $unit) {
            return $length * 0.3048;
        }
        //====================================================================//
        // Inch
        if ("99" == $unit) {
            return $length * 0.0254;
        }

        return 0;
    }

    /**
     * Return Normalized Length form raw m value.
     *
     * @param float $length Length Raw Value
     *
     * @return arrayobject $r->length , $r->length_units , $r->print, $r->raw
     */
    public static function normalizeLength(float $length): ArrayObject
    {
        //====================================================================//
        // Include Needed Dolibarr Functions Libraries
        dol_include_once('/core/lib/product.lib.php');
        //====================================================================//
        // Create Result
        $result = new ArrayObject();
        //====================================================================//
        // M
        if ($length >= 1) {
            $result->length = $length;
            $result->length_units = "0";
        //====================================================================//
        // Dm
        } elseif ($length >= 1e-1) {
            $result->length = $length * 1e1;
            $result->length_units = "-1";
        //====================================================================//
        // CM
        } elseif ($length >= 1e-2) {
            $result->length = $length * 1e2;
            $result->length_units = "-2";
        //====================================================================//
        // MM
        } elseif ($length >= 1e-3) {
            $result->length = $length * 1e3;
            $result->length_units = "-3";
        }
        //====================================================================//
        // Prepare Value for Display
        $result->print = $result->length." ".measuring_units_string($result->length_units, "size");
        //====================================================================//
        // Copy Raw Value for Computation
        $result->raw = $length;

        return $result;
    }

    /**
     * Convert Surface form all units to m².
     *
     * @param float $surface Surface Value
     * @param int   $unit    Surface Unit
     *
     * @return float Surface Value in m²
     */
    public static function convertSurface(float $surface, int $unit): float
    {
        //====================================================================//
        // mm²
        if ("-6" == $unit) {
            return $surface / 1e6;
        }
        //====================================================================//
        // cm²
        if ("-4" == $unit) {
            return $surface / 1e4;
        }
        //====================================================================//
        // dm²
        if ("-2" == $unit) {
            return $surface / 1e2;
        }
        //====================================================================//
        // m²
        if ("0" == $unit) {
            return $surface;
        }
        //====================================================================//
        // foot²
        if ("98" == $unit) {
            return $surface * 0.092903;
        }
        //====================================================================//
        // inch²
        if ("99" == $unit) {
            return $surface * 0.00064516;
        }

        return 0;
    }

    /**
     * Return Normalized Surface form raw m2 value.
     *
     * @param float $surface Surface Raw Value
     *
     * @return arrayobject $r->surface , $r->surface_units , $r->print, $r->raw
     */
    public static function normalizeSurface(float $surface): ArrayObject
    {
        //====================================================================//
        // Include Needed Dolibarr Functions Libraries
        dol_include_once('/core/lib/product.lib.php');
        //====================================================================//
        // Create Result
        $result = new ArrayObject();
        //====================================================================//
        // m2
        if ($surface >= 1) {
            $result->surface = $surface;
            $result->surface_units = "0";
        //====================================================================//
        // dm2
        } elseif ($surface >= 1e-2) {
            $result->surface = $surface * 1e2;
            $result->surface_units = "-2";
        //====================================================================//
        // cm2
        } elseif ($surface >= 1e-4) {
            $result->surface = $surface * 1e4;
            $result->surface_units = "-4";
        //====================================================================//
        // mm2
        } elseif ($surface >= 1e-6) {
            $result->surface = $surface * 1e6;
            $result->surface_units = "-6";
        }
        //====================================================================//
        // Prepare Value for Display
        $result->print = $result->surface." ".measuring_units_string($result->surface_units, "surface");
        //====================================================================//
        // Copy Raw Value for Computation
        $result->raw = $surface;

        return $result;
    }

    /**
     * Convert Volume form all units to m3.
     *
     * @param float $volume Volume Value
     * @param int   $unit   Volume Unit
     *
     * @return float Volume Value in m3
     *
     * @SuppressWarnings(PHPMD.CyclomaticComplexity)
     * @SuppressWarnings(PHPMD.NPathComplexity)
     */
    public static function convertVolume(float $volume, int $unit): float
    {
        //====================================================================//
        // mm cube
        if ("-9" == $unit) {
            return $volume * 1e-9;
        }
        //====================================================================//
        // cm cube
        if ("-6" == $unit) {
            return $volume * 1e-6;
        }
        //====================================================================//
        // dm cube
        if ("-3" == $unit) {
            return $volume * 1e-3;
        }
        //====================================================================//
        // m cube
        if ("0" == $unit) {
            return $volume;
        }
        //====================================================================//
        // foot cube
        if ("88" == $unit) {
            return $volume * 0.0283168;
        }
        //====================================================================//
        // inch cube
        if ("89" == $unit) {
            return $volume * 1.6387e-5;
        }
        //====================================================================//
        // ounce
        if ("97" == $unit) {
            return $volume * 2.9574e-5;
        }
        //====================================================================//
        // litre
        if ("98" == $unit) {
            return $volume * 1e-3;
        }
        //====================================================================//
        // gallon
        if ("99" == $unit) {
            return $volume * 0.00378541;
        }

        return 0;
    }

    /**
     * Return Normalized Volume form raw m3 value.
     *
     * @param float $volume Volume Raw Value
     *
     * @return arrayobject $r->volume , $r->volume_units , $r->print, $r->raw
     */
    public static function normalizeVolume(float $volume): ArrayObject
    {
        //====================================================================//
        // Include Needed Dolibarr Functions Libraries
        dol_include_once('/core/lib/product.lib.php');
        //====================================================================//
        // Create Result
        $result = new ArrayObject();
        //====================================================================//
        // m3
        if ($volume >= 1) {
            $result->volume = $volume;
            $result->volume_units = "0";
        //====================================================================//
        // dm3
        } elseif ($volume >= 1e-3) {
            $result->volume = $volume * 1e3;
            $result->volume_units = "-3";
        //====================================================================//
        // cm2
        } elseif ($volume >= 1e-6) {
            $result->volume = $volume * 1e6;
            $result->volume_units = "-6";
        //====================================================================//
        // mm2
        } elseif ($volume >= 1e-9) {
            $result->volume = $volume * 1e9;
            $result->volume_units = "-9";
        }
        //====================================================================//
        // Prepare Value for Display
        $result->print = $result->volume." ".measuring_units_string($result->volume_units, "volume");
        //====================================================================//
        // Copy Raw Value for Computation
        $result->raw = $volume;

        return $result;
    }
}
