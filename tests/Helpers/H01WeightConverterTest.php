<?php

/*
 *  Copyright (C) 2021 BadPixxel <www.badpixxel.com>
 *
 *  This program is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 *
 *  For the full copyright and license information, please view the LICENSE
 *  file that was distributed with this source code.
 */

namespace BadPixxel\Dolibarr\Tests\Helpers;

use BadPixxel\Dolibarr\Componants\WeightConverter;

/**
 * Helpers Test Suite - Weight Converter Verifications
 */
class H01WeightConverterTest extends AbstractConverterTest
{
    /**
     * Generate Test Values Sets for Convertion Test
     *
     * @return array
     */
    public function valuesProvider()
    {
        return array(
            // Micro Grams
            array(WeightConverter::class, 123456, "-9", 0.000123456, "-6"),
            // Milli Grams
            array(WeightConverter::class, 0.123, "-6", 0.000000123, "-6"),
            array(WeightConverter::class, 123, "-6", 0.000123, "-6"),
            array(WeightConverter::class, 123456, "-6", 0.123456, "-3"),
            // Grams
            array(WeightConverter::class, 0.123, "-3", 0.000123, "-6"),
            array(WeightConverter::class, 123, "-3", 0.123, "-3"),
            array(WeightConverter::class, 123456, "-3", 123.456, "0"),
            // Kilo Grams
            array(WeightConverter::class, 123456, "0", 123456, "3"),
            array(WeightConverter::class, 12345.6, "0", 12345.6, "3"),
            array(WeightConverter::class, 1234.56, "0", 1234.56, "3"),
            array(WeightConverter::class, 123.456, "0", 123.456, "0"),
            array(WeightConverter::class, 123456, "0", 123456, "3"),
            // Tons
            array(WeightConverter::class, 0.123, "3", 123, "0"),
            array(WeightConverter::class, 123, "3", 123000, "3"),
            array(WeightConverter::class, 123456, "3", 123456000, "3"),
            // Ounce
            array(WeightConverter::class, 1, "98", 0.028349523, "-3"),
            array(WeightConverter::class, 123456, "98", 3499.918721917, "3"),
            // LIVRE
            array(WeightConverter::class, 123456, "99", 55998.699631, "3"),
        );
    }
}
