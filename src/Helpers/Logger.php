<?php

/*
 * This file is part of BadPixxel ProductMixer Module.
 *
 * Copyright (C) 2015-2019 BadPixxel  <www.badpixxel.com>
 *
 * This program is free software: you can redistribute it
 * and/or modify it under the terms of the GNU General Public License
 * as published by the Free Software Foundation, version 3.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 * See the GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * long with this program. If not, see <https://www.gnu.org/licenses/>.
 */

namespace BadPixxel\Dolibarr\Helpers;

use BadPixxel\Dolibarr\Models\AbstractHelper;
use BadPixxel\Dolibarr\Models\HtmlBuilderTrait;

/**
 * Build & Render Tables Blocks
 */
class Logger extends AbstractHelper
{
    /**
     * @var string
     */
    public static $helperDesc = 'Unified Logging. Dedicated to user information, warning and error reporting.';

    /**
     * Class Constructor
     */
    public function __construct()
    {
        global $langs;
        
        // Load traductions files requiredby by page
        $langs->load("errors");
    }
    


    /**
     * Display an emergency message.
     * Dolibarr Event level :  errors
     * Dolibarr LOG level :    LOG_EMERG
     *
     * @param      string   $text      Message Text
     *
     * @return     false
     */
    public static function emerg(string $text): bool
    {
        setEventMessage($text, 'errors');
        dol_syslog(DOL_HELPER_LOG_PREFIX.$text, LOG_EMERG);

        return false;
    }

    /**
     * Display an error message.
     * Dolibarr Event level :  errors
     * Dolibarr LOG level :    LOG_ERR
     *
     * @param      string   $text      Message Text
     *
     * @return     false
     */
    public static function error(string $text): bool
    {
        setEventMessage($text, 'errors');
        dol_syslog(DOL_HELPER_LOG_PREFIX.$text, LOG_ERR);

        return false;
    }

    /**
     * Display an warning message.
     * Dolibarr Event level :  warnings
     * Dolibarr LOG level :    LOG_WARNING
     *
     * @param      string   $text      Message Text
     *
     * @return     true
     */
    public static function warning(string $text): bool
    {
        setEventMessage($text, 'warnings');
        dol_syslog(DOL_HELPER_LOG_PREFIX.$text, LOG_WARNING);

        return true;
    }

    /**
     * Display an information message.
     * Dolibarr Event level :  mesgs
     * Dolibarr LOG level :    LOG_INFO
     *
     * @param      string   $text      Message Text
     *
     * @return     true
     */
    public static function msg(string $text): bool
    {
        setEventMessage($text, 'mesgs');
        dol_syslog(DOL_HELPER_LOG_PREFIX.$text, LOG_INFO);

        return true;
    }
    
    /**
     * Display an logging message. Can be used for debug with temporary HMI feedback.
     * Dolibarr Event level :  mesgs if DA_LOG_SHOWDEBUG and SYSLOG_LEVEL >= 5
     * Dolibarr LOG level :    LOG_NOTICE
     *
     * @param      string   $text      Message Text
     *
     * @return     true
     */
    public static function log(string $text): bool
    {
        global $conf;
        if ((DOL_HELPER_DEBUG) && ($conf->global->SYSLOG_LEVEL >= 5)) {
            setEventMessage($text, 'mesgs');
        }

        dol_syslog(DOL_HELPER_LOG_PREFIX.$text, LOG_NOTICE);

        return true;
    }

    /**
     * Display an logging message. Can be used for debug with static HMI feedback.
     * Dolibarr Event level :  warnings if DA_LOG_SHOWDEBUG and SYSLOG_LEVEL >= 6
     * Dolibarr LOG level :    LOG_DEBUG
     *
     * @param      string   $text      Message Text
     *
     * @return     true
     */
    public static function debug(string $text): bool
    {
        global $conf;
        if ((DOL_HELPER_DEBUG) && ($conf->global->SYSLOG_LEVEL >= 6)) {
            setEventMessage($text, 'warnings');
        }

        dol_syslog(DOL_HELPER_LOG_PREFIX.$text, LOG_DEBUG);

        return true;
    }
    
    /**
     * Read & Returns print_r() of a variable in a warning message
     *
     * @param mixed  $var Any Object to dump
     *
     * @return true
     */
    public static function ddd($var): bool
    {
        return self::warning('<PRE>'.print_r($var, true).'</PRE>');
    }  
    
}
