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

namespace BadPixxel\Dolibarr\Tests\Componants;

use BadPixxel\Dolibarr\Componants\VolumeConverter;

/**
 * Helpers Test Suite - Volume Converter Verifications
 */
class H04VolumeConverterTest extends AbstractConverterTest
{
    /**
     * Generate Test Values Sets for Convertion Test
     *
     * @return array
     */
    public function valuesProvider()
    {
        return array(
            // MilliMeter Cube
            array(VolumeConverter::class, 1000,       "-9", 0.000001, "-6"),
            array(VolumeConverter::class, 123,       "-9", 0.000000123, "-9"),
            array(VolumeConverter::class, 12.3456, "-9", 0.0000000123456, "-9"),
            // Centimenter Cube
            array(VolumeConverter::class, 1,       "-6", 0.000001, "-6"),
            array(VolumeConverter::class, 12.3456, "-6", 0.0000123456, "-6"),
            array(VolumeConverter::class, 123.456, "-6", 0.000123456, "-6"),
            array(VolumeConverter::class, 1234.56, "-6", 0.00123456, "-3"),
            array(VolumeConverter::class, 0.1234, "-6", 0.0000001234, "-9"),
            array(VolumeConverter::class, 0.0123, "-6", 0.0000000123, "-9"),
            // Decimenter Cube
            array(VolumeConverter::class, 1,       "-3", 0.001, "-3"),
            array(VolumeConverter::class, 12.3456, "-3", 0.0123456, "-3"),
            array(VolumeConverter::class, 123.456, "-3", 0.123456, "-3"),
            array(VolumeConverter::class, 0.12345, "-3", 0.00012345, "-6"),
            array(VolumeConverter::class, 0.01234, "-3", 0.00001234, "-6"),
            // Meters Cube
            array(VolumeConverter::class, 1,       "0", 1, "0"),
            array(VolumeConverter::class, 1234.56, "0", 1234.56, "0"),
            array(VolumeConverter::class, 123.456, "0", 123.456, "0"),
            array(VolumeConverter::class, 0.123456, "0", 0.123456, "-3"),
            array(VolumeConverter::class, 0.012345, "0", 0.012345, "-3"),
            array(VolumeConverter::class, 0.001234, "0", 0.001234, "-3"),
            array(VolumeConverter::class, 0.000123, "0", 0.000123, "-6"),
            // Foot Cube
            array(VolumeConverter::class, 1, "88", 0.028317, "-3"),
            array(VolumeConverter::class, 123456, "88", 3495.884613, "0"),
            // Inch Cube
            array(VolumeConverter::class, 1, "89", 0.000016, "-6"),
            array(VolumeConverter::class, 123456, "89", 2.023081, "0"),
            // Ounce Cube
            array(VolumeConverter::class, 1, "97", 0.000029574, "-6"),
            array(VolumeConverter::class, 123456, "97", 3.651028, "0"),
            // Liter
            array(VolumeConverter::class, 1, "98", 0.001, "-3"),
            array(VolumeConverter::class, 123456, "98", 123.456, "0"),
            // Galon
            array(VolumeConverter::class, 1, "99", 0.00378541, "-3"),
            array(VolumeConverter::class, 123456, "99", 467.331577, "0"),
        );
    }
}
