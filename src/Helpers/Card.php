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

namespace BadPixxel\Dolibarr\Helpers;

use BadPixxel\Dolibarr\Helper;
use BadPixxel\Dolibarr\Models\AbstractHelper;

/**
 * Display Helpers Id Card Block
 */
class Card extends AbstractHelper
{
    /**
     * @var string
     */
    protected static $helperDesc = 'Library Id Card Generator.';

    /**
     * Render Library Id Card
     */
    public function render(): void
    {
        print_titre("Rendering Library");

        // Load Tables Helper
        $tables = Helper::tables();

        // Build Id Card
        $tables->new(array("width" => "80%"));

        $tables->head(
            array("This module use : ".Helper::getName(), "&nbsp;", "&nbsp;", "&nbsp;", "&nbsp;"),
            array(),
            array(
                array("width" => "30%"),
                array("width" => "10%"),
                array("width" => "20%"),
                array("width" => "10%"),
                array("width" => "20%"),
            )
        );

        $libImage = Helper::html()->image(
            dirname(__DIR__)."/Resources/img/logo.png",
            Helper::getDesc(),
            array("height" => "50")
        );

        $tables->row(
            array($libImage, "Version", Helper::getVersion(), "Author", DOL_HELPER_AUTHOR),
            array(),
            array(
                array("align" => "center", "rowspan" => "4")
            )
        );

        $tables->row(array(
            "Description",
            Helper::getDesc(),
            "Website",
            Helper::html()->absoluteLink(
                "http://badpixxel.com",
                'badpixxel.com',
                array("title" => "Visit our website")
            )
        ));

        $tables->end()->render();
    }
}
