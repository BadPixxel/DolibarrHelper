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

namespace BadPixxel\Dolibarr\Helpers;

use BadPixxel\Dolibarr\Helper;

/**
 * Build & Render Genric Forms Tables
 */
class TableForms extends Tables
{
    /**
     * @var string
     */
    public static $helperDesc = 'Generic HTML Forms Tables Generator. I.e: On/Off Switch for a Dolibarr Parameter.';

    /**
     * Dolibarr Form Fucntions
     */
    private $form;

    /**
     * Class Constructor
     */
    public function __construct()
    {
        global $db;

        dol_include_once("/core/lib/admin.lib.php");
        dol_include_once('/core/class/html.form.class.php');

        $this->form = new \Form($db);
    }

    /**
     * Display a 2 Column table line with Complete Switch
     * No Need to Catch Changes, Already Done here
     *
     * @param string $name    Name of a FGlobal Parameter
     * @param string $text    Parameter Description Text
     * @param string $tooltip Tooltip Description Text
     * @param array  $attr    Display Attributes
     *
     * @return $this
     */
    public function rowConstSwitch(string $name, string $text, string $tooltip, array $attr = array()): self
    {
        global $langs;

        //====================================================================//
        //  Load Current Value
        $action = "bpConstSwitch";
        $current = Helper::dol()->getConst($name);
        //====================================================================//
        //  Upate Value if Requested
        if (($action == GETPOST('action')) && GETPOSTISSET($name)) {
            $value = GETPOST($name);
            if (is_string($value) && Helper::dol()->setConst($name, $value)) {
                $current = $value;
            }
        }
        //====================================================================//
        //  Prepare Parameter Description
        $contents = $tooltip
                ? $this->form->textwithpicto($langs->trans($text), $langs->trans($tooltip))
                : $langs->trans($text);
        //====================================================================//
        //  Prepare Switch
        $switch = Helper::forms()->switch($name, $current, array("action" => $action));
        //====================================================================//
        //  Add Row to Table
        $this->row(array($contents, $switch), $attr);

        return $this;
    }
}
