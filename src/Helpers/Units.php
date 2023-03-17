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

namespace BadPixxel\Dolibarr\Helpers;

use BadPixxel\Dolibarr\Componants\LengthConverter;
use BadPixxel\Dolibarr\Componants\SurfaceConverter;
use BadPixxel\Dolibarr\Componants\VolumeConverter;
use BadPixxel\Dolibarr\Componants\WeightConverter;
use BadPixxel\Dolibarr\Models\Metric;

/**
 * Dolibarr Unit Converter
 */
class Units
{
    /**
     * Convert Weight form all units to kg.
     *
     * @param null|float $weight Weight Value
     * @param int|string $unit   Weight Unit
     *
     * @return float Weight Value in kg
     */
    public static function convertWeight($weight, $unit)
    {
        //====================================================================//
        // Forward to Convert
        return WeightConverter::convert($weight, $unit);
    }

    /**
     * Return Normalized Weight form raw kg value.
     *
     * @param null|float $weight Weight Raw Value
     *
     * @return Metric
     */
    public function normalizeWeight($weight)
    {
        //====================================================================//
        // Include Needed Dolibarr Functions Libraries
        dol_include_once('/core/lib/product.lib.php');
        //====================================================================//
        // Forward to Convert
        return WeightConverter::normalize($weight);
    }

    /**
     * Convert Lenght form all units to m.
     *
     * @param null|float $length Length Value
     * @param int|string $unit   Length Unit
     *
     * @return float Length Value in m
     */
    public static function convertLength($length, $unit)
    {
        //====================================================================//
        // Forward to Convert
        return LengthConverter::convert($length, $unit);
    }

    /**
     * Return Normalized Length form raw m value.
     *
     * @param null|float $length Length Raw Value
     *
     * @return Metric
     */
    public static function normalizeLength($length)
    {
        //====================================================================//
        // Include Needed Dolibarr Functions Libraries
        dol_include_once('/core/lib/product.lib.php');
        //====================================================================//
        // Forward to Convert
        return LengthConverter::normalize($length);
    }

    /**
     * Convert Surface form all units to m².
     *
     * @param null|float $surface Surface Value
     * @param int|string $unit    Surface Unit
     *
     * @return float Surface Value in m²
     */
    public static function convertSurface($surface, $unit)
    {
        //====================================================================//
        // Forward to Convert
        return SurfaceConverter::convert($surface, $unit);
    }

    /**
     * Return Normalized Surface form raw m2 value.
     *
     * @param null|float $surface Surface Raw Value
     *
     * @return Metric
     */
    public static function normalizeSurface($surface)
    {
        //====================================================================//
        // Include Needed Dolibarr Functions Libraries
        dol_include_once('/core/lib/product.lib.php');
        //====================================================================//
        // Forward to Convert
        return SurfaceConverter::normalize($surface);
    }

    /**
     * Convert Volume form all units to m3.
     *
     * @param null|float $volume Volume Value
     * @param int|string $unit   Volume Unit
     *
     * @return float Volume Value in m3
     */
    public static function convertVolume($volume, $unit)
    {
        //====================================================================//
        // Forward to Convert
        return VolumeConverter::convert($volume, $unit);
    }

    /**
     * Return Normalized Volume form raw m3 value.
     *
     * @param null|float $volume Volume Raw Value
     *
     * @return Metric
     */
    public static function normalizeVolume($volume)
    {
        //====================================================================//
        // Include Needed Dolibarr Functions Libraries
        dol_include_once('/core/lib/product.lib.php');
        //====================================================================//
        // Forward to Convert
        return VolumeConverter::normalize($volume);
    }
}
