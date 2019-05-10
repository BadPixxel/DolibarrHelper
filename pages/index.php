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

ini_set('display_errors', 1);

//====================================================================//
//   INCLUDES
//====================================================================//

//====================================================================//
// Require Autoloader
require_once(dirname(__DIR__)."/vendor/autoload.php");
//====================================================================//
// Boot Dolibarr
include_once(Helper::dol()->inc());

//====================================================================//
//   INITIALISATION
//====================================================================//
//
//====================================================================//
// Security check
Helper::dol()->isAdmin();

//====================================================================//
//   ACTIONS
//====================================================================//

//====================================================================//
//   SHOW PAGE
//====================================================================//

$title = "Dolibarr Helper Test/Demo Page";
llxHeader('', $title);
print_fiche_titre($title, '', 'setup');

//====================================================================//
// Render A Demo Table
print_titre("Very Simple Table");
Helper::tables()->new();
Helper::tables()->head(array("Head 1", "Head 2", "Head 3", "Head 4"));
Helper::tables()->row(array("Row 1", "Row 2", "Row 3", "Row 4"));
Helper::tables()->row(array("1", "2", "3", "4"), array('style' => 'color: red; text-align:center;'), array());
Helper::tables()->row(
    array("Row 1", "Row 2", "Row 3", "Row 4"),
    array(),
    array(array('style' => 'background-color: gray !important;'))
);
Helper::tables()->row(array("Row 1", "Row 2", "Row 3", "Row 4"));
Helper::tables()->end()->render();
Helper::html()->br(2);

//====================================================================//
// Render A Generic Table
print_titre("Description | Value Table");
Helper::tables()->newDescVal();
Helper::tables()->row(array("Description", "Value"));
Helper::tables()->rowYesNo("A Simple Yes/No Value", true);
Helper::tables()->rowYesNo("A Simple Yes/No Value", false);
Helper::tables()->row(array("Description", "Value"));
Helper::tables()->end()->render();
Helper::html()->br(2);

//====================================================================//
// Render A Generic Table
print_titre("Parameter | Value | Description Table");
Helper::tables()->newParamValDesc();
Helper::tables()->row(array("Parameter", "Value", "Description"));
Helper::tables()->row(array("Parameter", "Value", "Description"));
Helper::tables()->end()->render();
Helper::html()->br(2);

//====================================================================//
// Render A Table Form
print_titre("Generic Forms: Description + Tooltip | Database Value (Nothing to Add)");
Helper::tableForms()->newDescVal();
Helper::tableForms()->rowConstSwitch("BP_HELPERS_DEMO_SWITCH", "Name", "Tooltip");
//Helper::tableForms()->rowConstText("BP_HELPERS_DEMO_TEXT", "Name", "Tooltip");
Helper::tableForms()->end()->render();
Helper::html()->br(2);

//====================================================================//
// Render Logger Demo
$rows = array(
    Helper::html()->btnDelete("#", "Error", array("doLogger" => "error")),
    Helper::html()->btnNew("#", "Warning", array("doLogger" => "warning")),
    Helper::html()->btn("#", "Success", array("doLogger" => "msg")),
    Helper::html()->btn("#", "Dump", array("doDump" => "msg")),
);
$rowsRefused = array(
    Helper::html()->btnNewRefused("Warning"),
    Helper::html()->btnRefused("Success"),
    Helper::html()->btnTrans("#Logger", "Transparant"),
);
print_titre("Logger: User Messages + Dolibarr Logs");
Helper::tables()->new(array("id" => "Logger"));
Helper::tables()->row($rows);
Helper::tables()->row($rowsRefused);
Helper::tables()->end()->render();
Helper::html()->br(2);
//====================================================================//
// Render Logger Messages
if (GETPOSTISSET("doLogger")) {
    Helper::log()->{ GETPOST("doLogger", "alpha") }("This is a Démo Message");
}
if (GETPOSTISSET("doDump")) {
    Helper::ddd(array("Dump" => "This is an Array Dump. Right?"));
}

//====================================================================//
// Render Library Id Card
Helper::card()->render();

llxFooter();
