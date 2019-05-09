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

/**
 * Display Helpers Id Card Block
 */
class Card extends AbstractHelper
{
    /**
     * @var string
     */
    static $helperDesc = 'Library Id Card Generator.';
    
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
            array("This module use : " . Helper::getName(), "&nbsp;", "&nbsp;", "&nbsp;", "&nbsp;"), 
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
            dirname(__DIR__). "/Resources/img/logo.png",
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
                    "http://www.dolibarr-addict.com",
                    'www.dolibarr-addict.com',
                    array("title" => "Visit our website")
            )
        ));         
        
        
//        $r.= DA_Tables::R_NewTable("MyStyle","width=80%");
//        $r.= DA_Tables::R_NewLine("MyStyle",0,1);
//        $r.= DA_Tables::R_Cell("This module use : " . DA::getName(),'MyStyle','30%');
//        $r.= DA_Tables::R_Cell("&nbsp;","MyStyle","10%");
//        $r.= DA_Tables::R_Cell("&nbsp;","MyStyle","20%");
//        $r.= DA_Tables::R_Cell("&nbsp;","MyStyle","10%");
//        $r.= DA_Tables::R_Cell("&nbsp;","MyStyle","20%");
//         $r.= DA_Tables::R_EndLine();
//        $r.= DA_Tables::R_NewLine("MyStyle",0,0);
//        $r.= DA_Tables::R_Cell(DA_Html::R_Image($url,"/Logo_Dolibarr-Addict_HD.png","Dolibarr-Addict",NULL,'NoStyle',0,50),'NoStyle',NULL,' align="center" rowspan="4"');
//        $r.= DA_Tables::R_Cell("Version","MyStyle");
//        $r.= DA_Tables::R_Cell(DA::getVersion(),"MyStyle");
//        $r.= DA_Tables::R_Cell("Autor","MyStyle");
//        $r.= DA_Tables::R_Cell("Dolibarr-Addict - B. Paquier","MyStyle");
//        $r.= DA_Tables::R_EndLine();
//        $r.= DA_Tables::R_FullLine("MyStyle",
//                "Description",DA::getDesc(),
//                "Website",  DA_Html::R_Link("http://www.dolibarr-addict.com/",'www.dolibarr-addict.com','','next.png',$title='Visit Our Website','_blank'));
        $tables->end()->render();

    }    
    
    /**
     * Return Libary Main Id Card
     *  @param      url      $url                Library Folder Url
     *
     * @return string
     */
    public function R_LibIdCard($url)
    {
// Library Header        
        
        $r.= DA_Tables::R_NewTable("MyStyle","width=80%");
        $r.= DA_Tables::R_NewLine("MyStyle",0,1);
        $r.= DA_Tables::R_Cell("This module use : " . DA::getName(),'MyStyle','30%');
        $r.= DA_Tables::R_Cell("&nbsp;","MyStyle","10%");
        $r.= DA_Tables::R_Cell("&nbsp;","MyStyle","20%");
        $r.= DA_Tables::R_Cell("&nbsp;","MyStyle","10%");
        $r.= DA_Tables::R_Cell("&nbsp;","MyStyle","20%");
         $r.= DA_Tables::R_EndLine();
        $r.= DA_Tables::R_NewLine("MyStyle",0,0);
        $r.= DA_Tables::R_Cell(DA_Html::R_Image($url,"/Logo_Dolibarr-Addict_HD.png","Dolibarr-Addict",NULL,'NoStyle',0,50),'NoStyle',NULL,' align="center" rowspan="4"');
        $r.= DA_Tables::R_Cell("Version","MyStyle");
        $r.= DA_Tables::R_Cell(DA::getVersion(),"MyStyle");
        $r.= DA_Tables::R_Cell("Autor","MyStyle");
        $r.= DA_Tables::R_Cell("Dolibarr-Addict - B. Paquier","MyStyle");
        $r.= DA_Tables::R_EndLine();
        $r.= DA_Tables::R_FullLine("MyStyle",
                "Description",DA::getDesc(),
                "Website",  DA_Html::R_Link("http://www.dolibarr-addict.com/",'www.dolibarr-addict.com','','next.png',$title='Visit Our Website','_blank'));
        $r.= DA_Tables::R_EndTable();


        return $r;
    } 
    
}
