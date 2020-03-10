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

use BadPixxel\Dolibarr\Helper;

define('DOL_PHPUNIT_HOST', "");
define('DOL_PHPUNIT_USER', "");
define('DOL_PHPUNIT_PWD', "");
define('DOL_PHPUNIT_ENTITY', "");

//====================================================================//
// Require Autoloader
require_once(dirname(dirname(dirname(__DIR__)))."/vendor/autoload.php");

//====================================================================//
// Do not create database handler $db
define('NOREQUIREDB', '1');

//====================================================================//
// Boot Dolibarr (Master Only)
Helper::dol()->boot();

//====================================================================//
// Include Dolibarr Libs (dol_include_once not working with PhpStan)
dol_include_once("/core/lib/admin.lib.php");
dol_include_once('/core/class/html.form.class.php');
dol_include_once('/core/lib/product.lib.php');
dol_include_once('/core/lib/product.lib.php');
dol_include_once('/product/class/product.class.php');
dol_include_once('/product/stock/class/entrepot.class.php');
dol_include_once('/product/stock/class/mouvementstock.class.php');
