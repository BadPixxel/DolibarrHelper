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
 * Base Interface for Dolibarr Helpers
 */
interface HelperInterface
{
    /**
     * Return name of this library
     *
     * @return string
     */
    public function getName(): string;

    /**
     * Return Description of this library
     *
     * @return string Name of logger
     */
    public function getDesc(): string;

    /**
     * Version of the Helper or Library Version
     *
     * @return string
     */
    public function getVersion(): string;
}
