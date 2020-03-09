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

namespace BadPixxel\Dolibarr\Tests\Tools;

use BadPixxel\Dolibarr\Helper;
use DoliDB;
use PHPUnit\Framework\Assert;
use User;

/**
 * Execute Dolibarr Core Actions for PhpUnit Tests
 */
class CoreActions
{
    /**
     * Initiate Test User if not already defined
     *
     * @global DoliDB $db
     * @global User $user
     *
     * @return boolean
     */
    public static function setupUser(): bool
    {
        global $db, $user;
        //====================================================================//
        // CHECK USER ALREADY LOADED
        if (isset($user->id) && !empty($user->id)) {
            return true;
        }
        //====================================================================//
        // CHECK PHPUNIT USER IS DEFINED
        Assert::assertTrue(defined("DOL_PHPUNIT_USER"));
        Assert::assertNotEmpty(DOL_PHPUNIT_USER);
        //====================================================================//
        // LOAD USER FROM DATABASE
        require_once DOL_DOCUMENT_ROOT.'/user/class/user.class.php';
        //====================================================================//
        // Load Local User
        $user = new User($db);
        if (1 != $user->fetch(null, DOL_PHPUNIT_USER)) {
            return Helper::log()->catchDolibarrErrors($user);
        }
        //====================================================================//
        // Load Local User Rights
        if (!$user->all_permissions_are_loaded) {
            $user->getrights();
        }

        return true;
    }

    /**
     * Initiate Test Entity
     *
     * @return bool
     */
    public static function setupEntity(): bool
    {
        global $conf, $db, $user;

        //====================================================================//
        // CHECK PHPUNIT ENTITY IS DEFINED
        if (!defined("DOL_PHPUNIT_ENTITY") && !empty(DOL_PHPUNIT_ENTITY)) {
            return false;
        }
        //====================================================================//
        // Detect MultiCompany Module
        if (!self::getParameter("MAIN_MODULE_MULTICOMPANY")) {
            return true;
        }
        //====================================================================//
        // Detect Entity Id
        $sql = "SELECT rowid FROM ".MAIN_DB_PREFIX."entity WHERE label = '".DOL_PHPUNIT_ENTITY."'";
        $resql = $db->query($sql);
        if ($resql) {
            $row = $db->fetch_row($resql);
            $entity = $row[0];
        } else {
            die("Unable to Select PhpUnit Entity : ".DOL_PHPUNIT_ENTITY);
        }
        //====================================================================//
        // Switch Entity
        $conf->entity = (int)   $entity;
        $conf->setValues($db);
        $user->entity = $conf->entity;

        return true;
    }

    /**
     * Reload Dolibarr Configuration
     *
     * @return void
     */
    public static function reload()
    {
        global $conf, $db;

        $conf->setValues($db);
    }

    /**
     * Safe Get of A Global Parameter
     *
     * @param string     $key
     * @param null|mixed $default
     *
     * @return string
     */
    public static function getParameter(string $key, $default = null)
    {
        global $conf;

        return isset($conf->global->{$key})  ? $conf->global->{$key} : $default;
    }

    /**
     * Safe Set of A Global Parameter
     *
     * @param string $key
     * @param string $value
     *
     * @return void
     */
    public static function setParameter(string $key, string $value)
    {
        global $db, $conf;
        dolibarr_set_const($db, $key, $value, 'chaine', 0, '', $conf->entity);
    }
}
