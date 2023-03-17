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

namespace BadPixxel\Dolibarr\Helpers;

use BadPixxel\Dolibarr\Models\AbstractHelper;
use BadPixxel\Dolibarr\Models\HtmlBuilderTrait;

/**
 * Build & Render Tables Blocks
 */
class Tables extends AbstractHelper
{
    use HtmlBuilderTrait;

    /**
     * Defaults Html Arributes for Tables
     *
     * @var array
     */
    const TABLES = array(
        'class' => "noborder",
        'width' => "100%"
    );

    /**
     * Defaults Html Arributes for Head Lines
     *
     * @var array
     */
    const HEAD = array(
        'class' => "liste_titre",
    );

    /**
     * @var string
     */
    public static $helperDesc = 'Simplified HTML Tables Builder. Render tables compliant with Dolibarr & Themes.';

    /**
     * Start a New Table
     *
     * @param null|array $attr Display Attributes
     *
     * @return $this
     */
    public function new(array $attr = null): self
    {
        //====================================================================//
        //  Clean Buffer
        $this->clear();
        //====================================================================//
        //  Init New Table
        $this->add("<!-- Start Html Table -->");
        $this->add("<table ".self::attr(self::TABLES, $attr).">");

        return $this;
    }

    /**
     * Close Current Table
     *
     * @return $this
     */
    public function end(): self
    {
        //====================================================================//
        //  End Table
        $this->add("</table>");
        $this->add("<!-- End Html Table -->");

        return $this;
    }

    /**
     *  Add a Line to Current Table
     *
     * @param array $data      Line Data to Render
     * @param array $lineAttr  Line Attributes
     * @param array $cellsAttr Array of Cells Attributes
     *
     * @return $this
     */
    public function row(array $data, array $lineAttr = null, array $cellsAttr = null): self
    {
        //====================================================================//
        //  Start Table Line
        $this->add("<tr ".self::attr(array(), $lineAttr).">");
        //====================================================================//
        //  Add Cells to Line
        foreach ($data as $cellData) {
            $this->cell(
                (string) $cellData,
                is_array($cellsAttr) ? array_shift($cellsAttr) : null
            );
        }
        //====================================================================//
        //  Close Table Line
        $this->add("</tr>");

        return $this;
    }

    /**
     *  Add a Line to Current Table
     *
     * @param array $data      Line Data to Render
     * @param array $lineAttr  Line Attributes
     * @param array $cellsAttr Array of Cells Attributes
     *
     * @return $this
     */
    public function head(array $data, array $lineAttr = array(), array $cellsAttr = array()): self
    {
        //====================================================================//
        //  Start Table Line Header
        $this->add("<thead>");
        //====================================================================//
        //  Add Table Line
        $this->row($data, array_replace(self::HEAD, $lineAttr), $cellsAttr);
        //====================================================================//
        //  Close Table Header
        $this->add("</thead>");

        return $this;
    }

    //====================================================================//
    //  Standard Tables Layouts
    //====================================================================//

    /**
     * Start a New Table  with Desc & Value columns
     *
     * @param array $attr Display Attributes
     *
     * @return $this
     */
    public function newDescVal(array $attr = array()): self
    {
        global $langs;

        $this->new();
        $this->head(
            array($langs->trans("Description"), $langs->trans("Value")),
            $attr,
            array(array(), array("width" => "25%"))
        );

        return $this;
    }

    /**
     * Start a New Table  with Parameter, Valmue + Decsription columns
     *
     * @param array $attr Display Attributes
     *
     * @return $this
     */
    public function newParamValDesc(array $attr = array()): self
    {
        global $langs;

        $this->new();
        $this->head(
            array(
                $langs->trans("Parameter"),
                $langs->trans("Value"),
                $langs->trans("Description")
            ),
            $attr,
            array(
                array("width" => "20%"),
                array("width" => "25%")
            )
        );

        return $this;
    }

    /**
     * Display a 2 Column table line with Yes/No test result
     *
     * @param string          $text  Parameter Description
     * @param bool|int|string $state Current Parameter Value (0/1)
     * @param array           $attr  Display Attributes
     *
     * @return $this
     */
    public function rowYesNo(string $text, $state, array $attr = array()): self
    {
        global $langs;

        $picto = $state
            ? img_picto($langs->trans("Ok"), "tick").' '.$langs->trans("Ok")
            : img_picto($langs->trans("Nok"), "high").' '.$langs->trans("Nok");

        $this->row(array($text, $picto), $attr);

        return $this;
    }

    //====================================================================//
    //  PRIVATE METHODS
    //====================================================================//

    /**
     * Add a Table Cell
     *
     * @param string     $contents Table Cell Contents
     * @param null|array $attr     Display Attributes
     *
     * @return $this
     */
    private function cell(string $contents, array $attr = null)
    {
        global $langs;

        //  Start Table
        $this->add("<td ".self::attr(array(), $attr).">");
        //  Add Cells Contents
        $this->add($langs->trans($contents));
        //  Close Table Cell
        $this->add("</td>");

        return $this;
    }
}
