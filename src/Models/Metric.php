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

namespace BadPixxel\Dolibarr\Models;

/**
 * Temporary  Storage for Units Converter Values
 */
class Metric
{
    //====================================================================//
    // Data Storage
    //====================================================================//

    /**
     * @var float
     */
    private $value = 0;

    /**
     * @var int
     */
    private $unit = 0;

    /**
     * @var float
     */
    private $raw = 0;

    /**
     * @var string
     */
    private $print = "";

    //====================================================================//
    // Main Functions
    //====================================================================//

    /**
     * @param float $value
     * @param int   $unit
     * @param float $raw
     */
    public function __construct(float $value, int $unit, float $raw)
    {
        $this->raw = $raw;
        $this->value = $value;
        $this->unit = $unit;
    }

    /**
     * @param float $value
     * @param int   $unit
     * @param float $raw
     *
     * @return $this
     */
    public function setValue(float $value, int $unit, float $raw)
    {
        $this->value = $value;
        $this->unit = $unit;
        $this->raw = $raw;

        return $this;
    }

    /**
     * Compare a Value to this Metric
     *
     * @param float $value
     * @param int   $unit
     *
     * @return bool TRUE if Similar
     */
    public function compare(float $value, int $unit)
    {
        if (abs($this->value - $value) > 1E-3) {
            return false;
        }
        if ($this->unit != $unit) {
            return false;
        }

        return true;
    }

    //====================================================================//
    // Getters & Setters
    //====================================================================//

    /**
     * @param string $print
     *
     * @return $this
     */
    public function setPrint(string $print)
    {
        $this->print = $print;

        return $this;
    }

    /**
     * @return float
     */
    public function getRaw(): float
    {
        return $this->raw;
    }

    /**
     * @return float
     */
    public function getValue(): float
    {
        return $this->value;
    }

    /**
     * @return int
     */
    public function getUnit(): int
    {
        return $this->unit;
    }

    /**
     * @return string
     */
    public function getPrint(): string
    {
        return $this->print;
    }
}
