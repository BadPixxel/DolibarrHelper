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

namespace BadPixxel\Dolibarr\Models;

/**
 * Base Class for Dolibarr Helpers
 */
abstract class AbstractHelper implements HelperInterface
{
    /**
     * Helper Html Buffer
     *
     * @var string
     */
    protected $buffer;

    /**
     * @var string
     */
    protected static $helperName = null;

    /**
     * @var string
     */
    protected static $helperDesc = null;

    /**
     * {@inheritdoc}
     */
    public function getName(): string
    {
        if (!empty(static::$helperName)) {
            return static::$helperName;
        }

        $obj = new \ReflectionClass($this);

        return DOL_HELPER_CODE." - ".pathinfo((string) $obj->getFileName(), PATHINFO_FILENAME);
    }

    /**
     * {@inheritdoc}
     */
    public function getDesc(): string
    {
        if (!empty(static::$helperDesc)) {
            return static::$helperDesc;
        }

        $obj = new \ReflectionClass($this);

        return DOL_HELPER_NAME." - ".pathinfo((string) $obj->getFileName(), PATHINFO_FILENAME);
    }

    /**
     * {@inheritdoc}
     */
    public function getVersion(): string
    {
        return DOL_HELPER_VERSION;
    }
}
