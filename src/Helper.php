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

namespace BadPixxel\Dolibarr;

use BadPixxel\Dolibarr\Helpers\Card;
use BadPixxel\Dolibarr\Helpers\Elements;
use BadPixxel\Dolibarr\Helpers\Forms;
use BadPixxel\Dolibarr\Helpers\Framework;
use BadPixxel\Dolibarr\Helpers\Logger;
use BadPixxel\Dolibarr\Helpers\TableForms;
use BadPixxel\Dolibarr\Helpers\Tables;
use BadPixxel\Dolibarr\Helpers\Units;

/**
 * BadPixxel Dolibarr Helpers Core Access Class
 *
 * @SuppressWarnings(PHPMD.TooManyPublicMethods)
 */
class Helper
{
    /**
     * Framework Helper
     *
     * @var Framework
     */
    private static $framework;

    /**
     * Info Card Helper
     *
     * @var Card
     */
    private static $card;

    /**
     * Html Tables Helper
     *
     * @var Tables
     */
    private static $tables;

    /**
     * Html Forms Helper
     *
     * @var Forms
     */
    private static $forms;

    /**
     * Html Tables Forms Helper
     *
     * @var TableForms
     */
    private static $tableForms;

    /**
     * Html Elements Helper
     *
     * @var Elements
     */
    private static $elements;

    /**
     * Dolibarr Logs Helper
     *
     * @var Logger
     */
    private static $logger;

    /**
     * Dolibarr Units Helper
     *
     * @var Units
     */
    private static $units;

    /**
     * Return name of this library
     *
     * @return string
     */
    public static function getName()
    {
        return DOL_HELPER_CODE;
    }

    /**
     * Return Description of this library
     *
     * @return string Name of logger
     */
    public static function getDesc()
    {
        return DOL_HELPER_NAME;
    }

    /**
     * Version of the Helper or Library Version
     *
     * @return string
     */
    public static function getVersion()
    {
        return DOL_HELPER_VERSION;
    }

    //====================================================================//
    //  STATIC CLASS ACCESS
    //  Creation & Acces to all subclasses Instances
    //====================================================================//

    /**
     * Acces to all Dolibarr Framework Core Functions
     *
     * @return Framework
     */
    public static function dol(): Framework
    {
        if (!isset(static::$framework)) {
            //====================================================================//
            //  Ensure Helper Init
            self::init();
            //====================================================================//
            //  Load Framework Helper
            static::$framework = new Framework();
        }

        return static::$framework;
    }

    /**
     * Acces to Library Id Card Functions
     *
     * @return Card
     */
    public static function card(): Card
    {
        if (!isset(static::$card)) {
            //====================================================================//
            //  Ensure Helper Init
            self::init();
            //====================================================================//
            //  Load Card Helper
            static::$card = new Card();
        }

        return static::$card;
    }

    /**
     * Acces to Html Tables Functions
     *
     * @return Tables
     */
    public static function tables(): Tables
    {
        if (!isset(static::$tables)) {
            //====================================================================//
            //  Ensure Helper Init
            self::init();
            //====================================================================//
            //  Load Tables Helper
            static::$tables = new Tables();
        }

        return static::$tables;
    }

    /**
     * Acces to Html Simples Elements Functions
     *
     * @return Elements
     */
    public static function html(): Elements
    {
        if (!isset(static::$elements)) {
            //====================================================================//
            //  Ensure Helper Init
            self::init();
            //====================================================================//
            //  Load Html Elements Helper
            static::$elements = new Elements();
        }

        return static::$elements;
    }

    /**
     * Acces to Forms Elements Functions
     *
     * @return Forms
     */
    public static function forms(): Forms
    {
        if (!isset(static::$forms)) {
            //====================================================================//
            //  Ensure Helper Init
            self::init();
            //====================================================================//
            //  Load Forms Elements Helper
            static::$forms = new Forms();
        }

        return static::$forms;
    }

    /**
     * Acces to Generic Tables Forms Functions
     *
     * @return TableForms
     */
    public static function tableForms(): TableForms
    {
        if (!isset(static::$tableForms)) {
            //====================================================================//
            //  Ensure Helper Init
            self::init();
            //====================================================================//
            //  Load Tables Helper
            static::$tableForms = new TableForms();
        }

        return static::$tableForms;
    }

    /**
     * Acces to Logger Functions
     *
     * @return Logger
     */
    public static function log(): Logger
    {
        if (!isset(static::$logger)) {
            //====================================================================//
            //  Ensure Helper Init
            self::init();
            //====================================================================//
            //  Load Logger Helper
            static::$logger = new Logger();
        }

        return static::$logger;
    }

    /**
     * Acces to Units Functions
     *
     * @return Units
     */
    public static function units(): Units
    {
        if (!isset(static::$units)) {
            //====================================================================//
            //  Ensure Helper Init
            self::init();
            //====================================================================//
            //  Load Units Helper
            static::$units = new Units();
        }

        return static::$units;
    }
    
    //====================================================================//
    //  Fastlane Actions
    //====================================================================//

    /**
     * Safe Get of A Global Parameter
     *
     * @param string $key Global Parameter Key
     *
     * @return null|mixed
     */
    public static function const(string $key)
    {
        return self::dol()->getConst($key);
    }

    /**
     * Safe Get of A Dolibarr Path Url
     *
     * @param string $relativePath Relitive Uri Path
     *
     * @return string
     */
    public static function uri(string $relativePath = ""): string
    {
        return self::dol()->getUri($relativePath);
    }

    /**
     * Safe Get Current User Uri
     *
     * @return string
     */
    public static function self(): string
    {
        return self::dol()->getCurrentUri();
    }

    /**
     * Read & Returns print_r() of a variable in a warning message
     *
     * @param mixed $var Any Object to dump
     *
     * @return true
     */
    public static function ddd($var): bool
    {
        return self::log()->warning('<PRE>'.print_r($var, true).'</PRE>');
    }

    /**
     * Init the Helper
     */
    private static function init()
    {
        //====================================================================//
        // Already Done
        if (defined('DOL_HELPER_VERSION')) {
            return;
        }
        //====================================================================//
        // Include Constants Definitions
        require_once __DIR__.'/Conf/defines.inc.php';
    }
}
