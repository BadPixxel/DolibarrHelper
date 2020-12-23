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

use BadPixxel\Dolibarr\Componants\LengthConverter;

/**
 * Helpers Test Suite - Length Converter Verifications
 */
class H02LengthConverterTest extends AbstractConverterTest
{
    /**
     * Generate Test Values Sets for Convertion Test
     *
     * @return array
     */
    public function valuesProvider()
    {
        return array(
            // MilliMeter
            array(LengthConverter::class, 1,       "-3", 0.001, "-3"),
            array(LengthConverter::class, 12.3456, "-3", 0.0123456, "-2"),
            array(LengthConverter::class, 123.456, "-3", 0.123456, "-1"),
            array(LengthConverter::class, 1234.56, "-3", 1.23456, "0"),
            // Centimenter
            array(LengthConverter::class, 1,       "-2", 0.01, "-2"),
            array(LengthConverter::class, 12.3456, "-2", 0.123456, "-1"),
            array(LengthConverter::class, 123.456, "-2", 1.23456, "0"),
            array(LengthConverter::class, 1234.56, "-2", 12.3456, "0"),
            array(LengthConverter::class, 0.1234, "-2", 0.001234, "-3"),
            array(LengthConverter::class, 0.0123, "-2", 0.000123, "-3"),
            // Decimenter
            array(LengthConverter::class, 1,       "-1", 0.1, "-1"),
            array(LengthConverter::class, 12.3456, "-1", 1.23456, "0"),
            array(LengthConverter::class, 123.456, "-1", 12.3456, "0"),
            array(LengthConverter::class, 0.12345, "-1", 0.012345, "-2"),
            array(LengthConverter::class, 0.01234, "-1", 0.001234, "-3"),
            // Meters
            array(LengthConverter::class, 1,       "0", 1, "0"),
            array(LengthConverter::class, 1234.56, "0", 1234.56, "3"),
            array(LengthConverter::class, 123.456, "0", 123.456, "0"),
            array(LengthConverter::class, 0.123456, "0", 0.123456, "-1"),
            array(LengthConverter::class, 0.012345, "0", 0.012345, "-2"),
            array(LengthConverter::class, 0.001234, "0", 0.001234, "-3"),
            array(LengthConverter::class, 0.000123, "0", 0.000123, "-3"),
            // KiloMeters
            array(LengthConverter::class, 1,       "3", 1000, "3"),
            array(LengthConverter::class, 1234.56, "3", 1234560, "3"),
            array(LengthConverter::class, 123.456, "3", 123456, "3"),
            array(LengthConverter::class, 0.123456, "3", 123.456, "0"),
            array(LengthConverter::class, 0.012345, "3", 12.345, "0"),
            array(LengthConverter::class, 0.001234, "3", 1.234, "0"),
            array(LengthConverter::class, 0.000123, "3", 0.123, "-1"),
            // Foot
            array(LengthConverter::class, 1, "98", 0.304800, "-1"),
            array(LengthConverter::class, 123456, "98", 37629.388800, "3"),
            array(LengthConverter::class, 1, "99", 0.025400, "-2"),
            array(LengthConverter::class, 123456, "99", 3135.782400, "3"),
        );
    }
}
