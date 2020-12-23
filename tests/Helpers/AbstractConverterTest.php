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

namespace BadPixxel\Dolibarr\Tests\Helpers;

use BadPixxel\Dolibarr\Models\Metric;
use PHPUnit\Framework\TestCase;

/**
 * Helpers Test Suite - Base Class for Converter Verifications
 */
abstract class AbstractConverterTest extends TestCase
{
    /**
     * Test of Unit Converter
     *
     * @param string $class  Converter Class
     * @param float  $value  Original value
     * @param string $unit   Original Unit
     * @param float  $target Base Unit Value
     * @param string $tUnit  Base Unit Value
     *
     * @dataProvider valuesProvider
     *
     * @return void
     */
    public function testUnitConverter(string $class, float $value, string $unit, float $target, string $tUnit)
    {
        //====================================================================//
        // Ensure DOL_VERSION is Defined
        if (!defined("DOL_VERSION")) {
            define("DOL_VERSION", "8.0.0");
        }
        //====================================================================//
        // Convert Source to Base Unit
        $baseValue = $class::convert($value, $unit);
        $this->assertSame(round($target, 6), round($baseValue, 6));
        //====================================================================//
        // Normalize Units
        $normalized = $class::normalize($baseValue);
        $this->assertInstanceOf(Metric::class, $normalized);
        $this->assertEquals($tUnit, $normalized->getUnit());
        //====================================================================//
        // Revert Normalized Value to Base Unit
        $reverted = $class::convert($normalized->getValue(), $normalized->getUnit());
        $this->assertSame(round($target, 6), round($reverted, 6));
        $this->assertSame(round($baseValue, 6), round($reverted, 6));
    }

    /**
     * Generate Test Values Sets for Mass Convertion Test
     *
     * @return array
     */
    public function valuesProvider()
    {
        return array();
    }
}
