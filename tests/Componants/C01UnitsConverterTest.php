<?php

/*
 *  Copyright (C) 2020 BadPixxel <www.badpixxel.com>
 *
 *  This program is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 *
 *  For the full copyright and license information, please view the LICENSE
 *  file that was distributed with this source code.
 */

namespace BadPixxel\Dolibarr\Tests\Componants;

use BadPixxel\Dolibarr\Componants\UnitConverter;
use PHPUnit\Framework\TestCase;

/**
 * Componants Test Suite - Unit Converter Verifications
 */
class C01UnitsConverterTest extends TestCase
{
    //==============================================================================
    // MASS UNIT CONVERTER FUNCTIONS
    //==============================================================================

    /**
     * Test of Mass Unit Converter
     *
     * @param float $source
     * @param float $factor
     * @param float $target
     *
     * @dataProvider massValuesProvider
     *
     * @return void
     */
    public function testMassConverter(float $source, float $factor, float $target)
    {
        //====================================================================//
        // Convert Source to Base Unit
        $normalized = UnitConverter::normalizeWeight($source, $factor);
        $this->assertSame(round($target, 6), round($normalized, 6));

        //====================================================================//
        // Revert Normalized to Original Unit
        $reverse = UnitConverter::convertWeight($normalized, $factor);
        $this->assertSame(round($source, 9), round($reverse, 9));
    }

    /**
     * Generate Test Values Sets for Mass Convertion Test
     *
     * @return array
     */
    public function massValuesProvider()
    {
        return array(
            array(123456, UnitConverter::MASS_MICROGRAM, 0.000123456),
            array(123456, UnitConverter::MASS_MILLIGRAM, 0.123456),
            array(1, UnitConverter::MASS_GRAM, 0.001),
            array(123456, UnitConverter::MASS_GRAM, 123.456),
            array(1,        UnitConverter::MASS_OUNCE, 0.028349523),
            array(123456, UnitConverter::MASS_OUNCE, 3499.918721917),
            array(123456, UnitConverter::MASS_KG, 123456),
            array(123456, UnitConverter::MASS_TONNE, 123456000),
            array(123456, UnitConverter::MASS_LIVRE, 55998.699631),
        );
    }

    //==============================================================================
    // LENGTH UNIT CONVERTER FUNCTIONS
    //==============================================================================

    /**
     * Test of Length Unit Converter
     *
     * @param float $source
     * @param float $factor
     * @param float $target
     *
     * @dataProvider lengthValuesProvider
     *
     * @return void
     */
    public function testLengthConverter(float $source, float $factor, float $target)
    {
        //====================================================================//
        // Convert Source to Base Unit
        $normalized = UnitConverter::normalizeLength($source, $factor);
        $this->assertSame(round($target, 6), round($normalized, 6));

        //====================================================================//
        // Revert Normalized to Original Unit
        $reverse = UnitConverter::convertLength($normalized, $factor);
        $this->assertSame(round($source, 9), round($reverse, 9));
    }

    /**
     * Generate Test Values Sets for Lenght Convertion Test
     *
     * @return array
     */
    public function lengthValuesProvider()
    {
        return array(
            array(1,        UnitConverter::LENGTH_MILIMETER, 0.001),
            array(1,        UnitConverter::LENGTH_CENTIMETER, 0.01),
            array(1,        UnitConverter::LENGTH_M, 1),
            array(1,        UnitConverter::LENGTH_KM, 1000),
            array(1,        UnitConverter::LENGTH_FOOT, 0.304800),
            array(1,        UnitConverter::LENGTH_INCH, 0.025400),
            array(1,        UnitConverter::LENGTH_YARD, 0.914400),
            array(123456,   UnitConverter::LENGTH_MILIMETER, 123.456),
            array(123456,   UnitConverter::LENGTH_CENTIMETER, 1234.56),
            array(123456,   UnitConverter::LENGTH_KM, 123456000),
            array(123456,   UnitConverter::LENGTH_FOOT, 37629.388800),
            array(123456,   UnitConverter::LENGTH_INCH, 3135.782400),
            array(123456,   UnitConverter::LENGTH_YARD, 112888.166400),
        );
    }

    //==============================================================================
    // SURFACE UNIT CONVERTER FUNCTIONS
    //==============================================================================

    /**
     * Test of Surface Unit Converter
     *
     * @param float $source
     * @param float $factor
     * @param float $target
     *
     * @dataProvider surfaceValuesProvider
     *
     * @return void
     */
    public function testSurfaceConverter(float $source, float $factor, float $target)
    {
        //====================================================================//
        // Convert Source to Base Unit
        $normalized = UnitConverter::normalizeSurface($source, $factor);
        $this->assertSame(round($target, 6), round($normalized, 6));

        //====================================================================//
        // Revert Normalized to Original Unit
        $reverse = UnitConverter::convertSurface($normalized, $factor);
        $this->assertSame(round($source, 9), round($reverse, 9));
    }

    /**
     * Generate Test Values Sets for Surface Convertion Test
     *
     * @return array
     */
    public function surfaceValuesProvider()
    {
        return array(
            array(1,        UnitConverter::AREA_MM2, 0.000001),
            array(1,        UnitConverter::AREA_CM2, 0.0001),
            array(1,        UnitConverter::AREA_M2, 1),
            array(1,        UnitConverter::AREA_KM2, 1000000),
            array(1,        UnitConverter::AREA_FOOT2, 0.092903),
            array(1,        UnitConverter::AREA_INCH2, 0.000645),
            array(123456,   UnitConverter::AREA_MM2, 0.123456),
            array(123456,   UnitConverter::AREA_CM2, 12.3456),
            array(123456,   UnitConverter::AREA_M2, 123456),
            array(123456,   UnitConverter::AREA_KM2, 123456000000),
            array(123456,   UnitConverter::AREA_FOOT2, 11469.437706),
            array(123456,   UnitConverter::AREA_INCH2, 79.648873),
        );
    }

    //==============================================================================
    // VOLUME UNIT CONVERTER FUNCTIONS
    //==============================================================================

    /**
     * Test of Volume Unit Converter
     *
     * @param float $source
     * @param float $factor
     * @param float $target
     *
     * @dataProvider volumeValuesProvider
     *
     * @return void
     */
    public function testVolumeConverter(float $source, float $factor, float $target)
    {
        //====================================================================//
        // Convert Source to Base Unit
        $normalized = UnitConverter::normalizeSurface($source, $factor);
        $this->assertSame(round($target, 6), round($normalized, 6));

        //====================================================================//
        // Revert Normalized to Original Unit
        $reverse = UnitConverter::convertSurface($normalized, $factor);
        $this->assertSame(round($source, 9), round($reverse, 9));
    }

    /**
     * Generate Test Values Sets for Volume Convertion Test
     *
     * @return array
     */
    public function volumeValuesProvider()
    {
        return array(
            array(1,        UnitConverter::VOLUME_MM3, 0.000000001),
            array(1,        UnitConverter::VOLUME_CM3, 0.000001),
            array(1,        UnitConverter::VOLUME_M3, 1),
            array(1,        UnitConverter::VOLUME_KM3, 1000000000),
            array(1,        UnitConverter::VOLUME_FOOT3, 0.028317),
            array(1,        UnitConverter::VOLUME_INCH3, 0.000016),
            array(123456,   UnitConverter::VOLUME_MM3, 0.000123456),
            array(123456,   UnitConverter::VOLUME_CM3, 0.123456),
            array(123456,   UnitConverter::VOLUME_M3, 123456),
            array(12.3,     UnitConverter::VOLUME_KM3, 12300000000),
            array(123456,   UnitConverter::VOLUME_FOOT3, 3495.884613),
            array(123456,   UnitConverter::VOLUME_INCH3, 2.023081),
        );
    }
}
