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

use BadPixxel\Dolibarr\Componants\SurfaceConverter;

/**
 * Helpers Test Suite - Surface Converter Verifications
 */
class H03SurfaceConverterTest extends AbstractConverterTest
{
    /**
     * Generate Test Values Sets for Convertion Test
     *
     * @return array
     */
    public function valuesProvider()
    {
        return array(
            // MilliMeter Square
            array(SurfaceConverter::class, 1,       "-6", 0.000001, "-6"),
            array(SurfaceConverter::class, 12.3456, "-6", 0.0000123456, "-6"),
            array(SurfaceConverter::class, 123.456, "-6", 0.000123456, "-4"),
            array(SurfaceConverter::class, 1234.56, "-6", 0.00123456, "-4"),
            // Centimenter Square
            array(SurfaceConverter::class, 1,       "-4", 0.0001, "-4"),
            array(SurfaceConverter::class, 12.3456, "-4", 0.00123456, "-4"),
            array(SurfaceConverter::class, 123.456, "-4", 0.0123456, "-2"),
            array(SurfaceConverter::class, 1234.56, "-4", 0.123456, "-2"),
            array(SurfaceConverter::class, 0.1234, "-4", 0.00001234, "-6"),
            array(SurfaceConverter::class, 0.0123, "-4", 0.00000123, "-6"),
            // Decimenter Square
            array(SurfaceConverter::class, 1,       "-2", 0.01, "-2"),
            array(SurfaceConverter::class, 12.3456, "-2", 0.123456, "-2"),
            array(SurfaceConverter::class, 123.456, "-2", 1.23456, "0"),
            array(SurfaceConverter::class, 0.12345, "-2", 0.0012345, "-4"),
            array(SurfaceConverter::class, 0.01234, "-2", 0.0001234, "-4"),
            // Meters Square
            array(SurfaceConverter::class, 1,       "0", 1, "0"),
            array(SurfaceConverter::class, 1234.56, "0", 1234.56, "3"),
            array(SurfaceConverter::class, 123.456, "0", 123.456, "0"),
            array(SurfaceConverter::class, 0.123456, "0", 0.123456, "-2"),
            array(SurfaceConverter::class, 0.012345, "0", 0.012345, "-2"),
            array(SurfaceConverter::class, 0.001234, "0", 0.001234, "-4"),
            array(SurfaceConverter::class, 0.000123, "0", 0.000123, "-4"),
            // KiloMeters Square
            array(SurfaceConverter::class, 1,       "3", 1000000, "3"),
            array(SurfaceConverter::class, 1234.56, "3", 1234560000, "3"),
            array(SurfaceConverter::class, 123.456, "3", 123456000, "3"),
            array(SurfaceConverter::class, 0.123456, "3", 123456, "3"),
            array(SurfaceConverter::class, 0.012345, "3", 12345, "3"),
            array(SurfaceConverter::class, 0.001234, "3", 1234, "3"),
            array(SurfaceConverter::class, 0.000123, "3", 123, "0"),
            // Foot Square
            array(SurfaceConverter::class, 1, "98", 0.092903, "-2"),
            array(SurfaceConverter::class, 123456, "98", 11469.437706, "3"),
            // Inch Square
            array(SurfaceConverter::class, 1, "99", 0.000645, "-4"),
            array(SurfaceConverter::class, 123456, "99", 79.648873, "0"),
        );
    }
}
