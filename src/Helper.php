<?php

/*
 *  Copyright (C) BadPixxel <www.badpixxel.com>
 *
 *  This program is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 *
 *  For the full copyright and license information, please view the LICENSE
 *  file that was distributed with this source code.
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
     * @var null|Framework
     */
    private static ?Framework $framework = null;

    /**
     * Info Card Helper
     *
     * @var null|Card
     */
    private static ?Card $card = null;

    /**
     * Html Tables Helper
     *
     * @var null|Tables
     */
    private static ?Tables $tables = null;

    /**
     * Html Forms Helper
     *
     * @var null|Forms
     */
    private static ?Forms $forms = null;

    /**
     * Html Tables Forms Helper
     *
     * @var null|TableForms
     */
    private static ?TableForms $tableForms = null;

    /**
     * Html Elements Helper
     *
     * @var null|Elements
     */
    private static ?Elements $elements = null;

    /**
     * Dolibarr Logs Helper
     *
     * @var null|Logger
     */
    private static ?Logger $logger = null;

    /**
     * Dolibarr Units Helper
     *
     * @var null|Units
     */
    private static ?Units $units = null;

    /**
     * Return name of this library
     *
     * @return string
     */
    public static function getName(): string
    {
        return DOL_HELPER_CODE;
    }

    /**
     * Return Description of this library
     *
     * @return string Name of logger
     */
    public static function getDesc(): string
    {
        return DOL_HELPER_NAME;
    }

    /**
     * Version of the Helper or Library Version
     *
     * @return string
     */
    public static function getVersion(): string
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
        if (!isset(self::$framework)) {
            //====================================================================//
            //  Ensure Helper Init
            self::init();
            //====================================================================//
            //  Load Framework Helper
            self::$framework = new Framework();
        }

        return self::$framework;
    }

    /**
     * Acces to Library Id Card Functions
     *
     * @return Card
     */
    public static function card(): Card
    {
        if (!isset(self::$card)) {
            //====================================================================//
            //  Ensure Helper Init
            self::init();
            //====================================================================//
            //  Load Card Helper
            self::$card = new Card();
        }

        return self::$card;
    }

    /**
     * Acces to Html Tables Functions
     *
     * @return Tables
     */
    public static function tables(): Tables
    {
        if (!isset(self::$tables)) {
            //====================================================================//
            //  Ensure Helper Init
            self::init();
            //====================================================================//
            //  Load Tables Helper
            self::$tables = new Tables();
        }

        return self::$tables;
    }

    /**
     * Acces to Html Simples Elements Functions
     *
     * @return Elements
     */
    public static function html(): Elements
    {
        if (!isset(self::$elements)) {
            //====================================================================//
            //  Ensure Helper Init
            self::init();
            //====================================================================//
            //  Load Html Elements Helper
            self::$elements = new Elements();
        }

        return self::$elements;
    }

    /**
     * Acces to Forms Elements Functions
     *
     * @return Forms
     */
    public static function forms(): Forms
    {
        if (!isset(self::$forms)) {
            //====================================================================//
            //  Ensure Helper Init
            self::init();
            //====================================================================//
            //  Load Forms Elements Helper
            self::$forms = new Forms();
        }

        return self::$forms;
    }

    /**
     * Acces to Generic Tables Forms Functions
     *
     * @return TableForms
     */
    public static function tableForms(): TableForms
    {
        if (!isset(self::$tableForms)) {
            //====================================================================//
            //  Ensure Helper Init
            self::init();
            //====================================================================//
            //  Load Tables Helper
            self::$tableForms = new TableForms();
        }

        return self::$tableForms;
    }

    /**
     * Acces to Logger Functions
     *
     * @return Logger
     */
    public static function log(): Logger
    {
        if (!isset(self::$logger)) {
            //====================================================================//
            //  Ensure Helper Init
            self::init();
            //====================================================================//
            //  Load Logger Helper
            self::$logger = new Logger();
        }

        return self::$logger;
    }

    /**
     * Acces to Units Functions
     *
     * @return Units
     */
    public static function units(): Units
    {
        if (!isset(self::$units)) {
            //====================================================================//
            //  Ensure Helper Init
            self::init();
            //====================================================================//
            //  Load Units Helper
            self::$units = new Units();
        }

        return self::$units;
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
     * Safe Check if A Global Parameter is Not Empty
     *
     * @param string $key Global Parameter Key
     *
     * @return bool
     */
    public static function isConst(string $key): bool
    {
        return !empty(self::dol()->getConst($key));
    }

    /**
     * Safe Get of A Dolibarr Path Url
     *
     * @param string $relativePath Relative Uri Path
     */
    public static function uri(string $relativePath = ""): string
    {
        return self::dol()->getUri($relativePath);
    }

    /**
     * Safe Get of A Dolibarr Query Args as String
     */
    public static function query(?array $query = null): string
    {
        return self::dol()->getQuery($query);
    }

    /**
     * Safe Get Current User Uri
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
     *
     * @return void
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
