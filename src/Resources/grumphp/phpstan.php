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

use BadPixxel\Dolibarr\Helper;

//====================================================================//
// Require Autoloader
require_once(dirname(dirname(dirname(__DIR__)))."/vendor/autoload.php");

//====================================================================//
// Boot Dolibarr
include_once(Helper::dol()->getRootPath()."master.inc.php");
