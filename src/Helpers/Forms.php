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
use BadPixxel\Dolibarr\Models\AbstractHelper;
use BadPixxel\Dolibarr\Models\HtmlBuilderTrait;

/**
 * Build & Render Form Elements
 */
class Forms extends AbstractHelper
{
    use HtmlBuilderTrait;

    /**
     * @var string
     */
    public static $helperDesc = 'Simplified HTML Forms. All major forms features unified and compliant with Dolibarr.';

    /**
     * Return form begin with accociated Action  & Additionnal Parameters
     *
     * @param string $name   Form Name/parameter
     * @param string $action action Parameter
     * @param array  $param  Hidden Parameters Array
     *
     * @return $this
     *
     * @SuppressWarnings(PHPMD.Superglobals)
     */
    public function new(string $name, string $action, array $param = array()): self
    {
        $this->add('<form name="'.$name.'" action="'.Helper::self().'" method="post">');
        $this->input("hidden", "token", $_SESSION['newtoken']);
        $this->input("hidden", "action", $action);
        foreach ($param as $key => $value) {
            $this->input("hidden", $key, $value);
        }

        return $this->render();
    }

    //====================================================================//
    // Form Fields Outputs
    //====================================================================//

    /**
     * Render Generic Text Input
     *
     * @param string $name  Parameter Name
     * @param string $value Parameter Value
     * @param array  $attr  Display Attributes
     *
     * @return string
     */
    public function text(string $name, string $value, array $attr = array()): string
    {
        return $this->input("text", $name, $value, $attr)->getHtml();
    }

    /**
     * Render Generic Password Input
     *
     * @param string $name  Parameter Name
     * @param string $value Parameter Value
     * @param array  $attr  Display Attributes
     *
     * @return string
     */
    public function pwd(string $name, string $value, array $attr = array()): string
    {
        $pwdAttr = array_replace(array("class" => "flat"), $attr);

        return $this->input("password", $name, $value, $pwdAttr)->getHtml();
    }

    /**
     * Render Generic CheckBox Input
     *
     * @param string $name  Parameter Name
     * @param string $value Parameter Value
     * @param array  $attr  Display Attributes
     *
     * @return string
     */
    public function checkbox(string $name, string $value, array $attr = array()): string
    {
        $boxAttr = array_replace(array("checked" => ($value?"checked":"")), $attr);

        return $this->input("checkbox", $name, $value, $boxAttr)->getHtml();
    }

    /**
     * Return Yes/No Form Switch
     *
     * @param string          $name  Parameter Name
     * @param bool|int|string $state Current Parameter Value (0/1)
     * @param array           $query Query Parameter
     * @param array           $attr  Display Attributes
     *
     * @return string
     */
    public static function switch(string $name, $state, array $query = array(), array $attr = array()): string
    {
        global $langs;
        //====================================================================//
        // Add Current State to Query Parameters
        $switchQuery = array_replace(
            $query,
            array($name => ($state ? "0" : "1"))
        );
        //====================================================================//
        // Build Switch
        $text = $state
            ? img_picto($langs->trans("Enabled"), 'switch_on')
            : img_picto($langs->trans("Disabled"), 'switch_off');

        return  Helper::html()->absoluteLink(Helper::self(), $text, $switchQuery, $attr);
    }

//    /**
//     * Add a value to a combo form
//     *
//     * @param string $name    Parameter Name
//     * @param string $value   Parameter Value
//     * @param string $current Currently selected
//     *
//     * @return string
//     */
//    public static function R_Combo($name, $value, $current): string
//    {
//        if ($current == $value) {
//            return '<option value="'.$value.'" selected="true">'.$name.'</option>';
//        }
//
//        return '<option value="'.$value.'">'.$name.'</option>';
//    }

    //====================================================================//
    //  Display Buttons Outputs
    //====================================================================//

    /**
     * Display a single submit button without any decoration
     *
     * @param string $text Button text
     * @param array  $attr Display Attributes
     *
     * @return string
     */
    public function submit($text, array $attr = array()): string
    {
        $submitAttr = array_replace(array("class" => "butAction"), $attr);

        return $this->input("submit", "", $text, $submitAttr)->getHtml();
    }

//    /**
//     * Display a single submit button with standard decoration
//     *
//     * @param      string   $text       Button text
//     * @param array  $attr Display Attributes
//     *
//     *  @return     string
//     */
//    public function submitBtn(string $text, $params = '', $align = 'center'): string
//    {
//        print '<a href="'.$_SERVER["PHP_SELF"].'?'.$params.'" class="button"> ';
//        print '<input type="submit" class="button" value="'.$text.'">';
//        print '</a>';
//        print '&nbsp;&nbsp;&nbsp;';
//    }

    /**
     * Add Generic Form Input to Buffer
     *
     * @param string     $type  Field Type
     * @param string     $name  Parameter Name
     * @param string     $value Parameter Value
     * @param null|array $attr  Display Attributes
     *
     * @return $this
     */
    private function input(string $type, string $name, string $value, array $attr = null): self
    {
        //====================================================================//
        //  Build Form Attributes
        $attributes = array("type" => $type, "name" => $name, "value" => $value);
        //====================================================================//
        //  Add Form Input to Html
        $this->add("<input ".self::attr($attributes, $attr).">");

        return $this;
    }
}
