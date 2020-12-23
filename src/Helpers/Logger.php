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

namespace BadPixxel\Dolibarr\Helpers;

use BadPixxel\Dolibarr\Models\AbstractHelper;
use Exception;

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
     * @param string $text Message Text
     *
     * @return false
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
     * @param string $text Message Text
     *
     * @return false
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
     * @param string $text Message Text
     *
     * @return true
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
     * @param string $text Message Text
     *
     * @return true
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
     * @param string $text Message Text
     *
     * @return true
     */
    public static function log(string $text): bool
    {
        global $conf;
        if (!empty(DOL_HELPER_DEBUG) && ($conf->global->SYSLOG_LEVEL >= 5)) {
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
     * @param string $text Message Text
     *
     * @return true
     */
    public static function debug(string $text): bool
    {
        global $conf;
        if (!empty(DOL_HELPER_DEBUG) && ($conf->global->SYSLOG_LEVEL >= 6)) {
            setEventMessage($text, 'warnings');
        }

        dol_syslog(DOL_HELPER_LOG_PREFIX.$text, LOG_DEBUG);

        return true;
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
        return self::warning('<PRE>'.print_r($var, true).'</PRE>');
    }

    /**
     * Catch Dolibarr Common Objects Errors and Push to Logger
     *
     * @param null|object $subject Focus on a specific object
     *
     * @return bool False if Error was Found
     *
     * @SuppressWarnings(PHPMD.CyclomaticComplexity)
     */
    public static function catchDolibarrErrors($subject = null): bool
    {
        global $db, $langs;
        //====================================================================//
        // Safety Check
        if (!is_object($subject)) {
            return true;
        }
        $noError = true;
        //====================================================================//
        // Catch Database Errors
        if (isset($subject->error) && !empty($subject->error) && !empty($db->lasterror())) {
            $noError = self::error(html_entity_decode($db->lasterror()));
        }
        //====================================================================//
        // Simple Error
        if (isset($subject->error) && !empty($subject->error) && is_scalar($subject->error)) {
            $noError = self::error(html_entity_decode($langs->trans($subject->error)));
        }
        //====================================================================//
        // Array of Errors
        if (isset($subject->errors) && is_iterable($subject->errors)) {
            foreach ($subject->errors as $error) {
                if (is_scalar($error) && !empty($error)) {
                    $noError = self::error(html_entity_decode($langs->trans($error)));
                }
            }
        }

        return $noError;
    }

    /**
     * Catch Dolibarr Common Objects Errors and Push to PhpUnit
     *
     * @param null|object $subject Focus on a specific object
     *
     * @return void
     *
     * @SuppressWarnings(PHPMD.CyclomaticComplexity)
     */
    public static function assertDolibarrErrors($subject = null): void
    {
        global $db, $langs;
        //====================================================================//
        // Safety Check
        if (!is_object($subject)) {
            return;
        }
        //====================================================================//
        // Catch Database Errors
        if (isset($subject->error) && !empty($subject->error) && !empty($db->lasterror())) {
            throw new Exception(html_entity_decode($db->lasterror()));
        }
        //====================================================================//
        // Simple Error
        if (isset($subject->error) && !empty($subject->error) && is_scalar($subject->error)) {
            throw new Exception(html_entity_decode($langs->trans($subject->error)).PHP_EOL);
        }
        //====================================================================//
        // Array of Errors
        if (isset($subject->errors) && is_iterable($subject->errors)) {
            foreach ($subject->errors as $error) {
                if (is_scalar($error) && !empty($error)) {
                    throw new Exception(html_entity_decode($langs->trans($error)).PHP_EOL);
                }
            }
        }
    }
}
