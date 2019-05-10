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
 * Build & Render Html Simple Elements Blocks
 * Links, Images, Buttons, and more...
 *
 * @SuppressWarnings(PHPMD.TooManyPublicMethods)
 */
class Elements extends AbstractHelper
{
    use HtmlBuilderTrait;

    /**
     * @var string
     */
    public static $helperDesc = 'Simplified HTML Elements. All major structures unified and compliant with Dolibarr.';

    //====================================================================//
    //  Display Icons
    //====================================================================//

    /**
     * Return an Icon href from Dolibarr Current Theme
     *
     * @param string $file Icon filename
     *
     * @return string
     */
    public static function icoUrl($file): string
    {
        global $conf;

        return dol_buildpath('/theme/'.$conf->theme.'/img/'.$file, 1);
    }

    /**
     * Return an Icon display from Dolibarr Current Theme
     *
     * @param type $file Icon filename
     *
     * @return string
     */
    public static function ico($file): string
    {
        return  '<img src="'.self::icoUrl($file).'" border="0" width="16" height="16" alt="ICO">&nbsp;&nbsp;';
    }

    //====================================================================//
    //  Return Links Outputs
    //====================================================================//

    /**
     * Return an Internal Link
     *
     * @param string     $url   Link target Absolute URL
     * @param string     $text  Link Text
     * @param null|array $query Query Parameters
     * @param null|array $attr  Display Attributes
     *
     * @return string
     */
    public function link(string $url, string $text, array $query = null, array $attr = null): string
    {
        return $this->absoluteLink(dol_buildpath($url, 1), $text, $query, $attr);
    }

    /**
     * Return an Internal Link
     *
     * @param string     $text  Link Text
     * @param null|array $query Query Parameters
     * @param null|array $attr  Display Attributes
     *
     * @return string
     */
    public function selfLink(string $text, array $query = null, array $attr = null): string
    {
        return $this->absoluteLink(Helper::self(), $text, $query, $attr);
    }

    /**
     * Return an Absolute Link with standard decoration
     *
     * @param string     $url   Link target Absolute URL
     * @param string     $text  Link Text
     * @param null|array $query Query Parameters
     * @param null|array $attr  Display Attributes
     *
     * @return string
     */
    public function absoluteLink(string $url, string $text, array $query = null, array $attr = null): string
    {
        //====================================================================//
        // Prepare Link Attributes
        $linkAttr = array(
            "href" => $url.self::toQuery($query),
        );
        //====================================================================//
        // Prepare Link Html
        $this->add('<a '.self::attr($linkAttr, $attr).'>');
        $this->add($text);
        $this->add('</a>');
        //====================================================================//
        // Return Link Html
        return $this->getHtml();
    }

    //====================================================================//
    //  Display Images Outputs
    //====================================================================//

    /**
     *  Return an image with advanced decoration
     *
     * @param string     $path       File path
     * @param string     $title      Image Title
     * @param null|array $attr       Display Attributes
     * @param string     $modulepart Use Dolibar viewimage function as a specific module
     *
     * @return string
     */
    public static function image(string $path, string $title, array $attr = null, string $modulepart = null): string
    {
        global $langs;

        //====================================================================//
        // Setup of image link with ModulePart management
        $url = !empty($modulepart)
                ? DOL_URL_ROOT.'/viewimage.php?modulepart='.$modulepart.'&file='.urlencode($path)
                : Helper::dol()->pathToUrl($path);

        //====================================================================//
        // Prepare Image Attributes
        $imgAttr = array(
            "src" => $url,
            "title" => $langs->trans($title)
        );

        //====================================================================//
        // Build image in html format
        return '<img '.self::attr($imgAttr, $attr).'>';
    }

    /**
     *  Return an image with advanced decoration
     *
     * @param string    $path       File path
     * @param string    $title      Image Title
     * @param nullarray $attr       Display Attributes
     * @param string    $modulepart Use Dolibar viewimage function as a specific module
     *
     * @return string
     */
    public function imageWithLink(string $path, string $title, array $attr = null, string $modulepart = null): string
    {
        //====================================================================//
        // Setup of image link with ModulePart management
        $url = !empty($modulepart)
                ? DOL_URL_ROOT.'/viewimage.php?modulepart='.$modulepart.'&file='.urlencode($path)
                : Helper::dol()->pathToUrl($path);
        //====================================================================//
        // Build Image Link
        $this->add('<a '.self::attr(array("href" => $url, "target" => "_blank")).'>');
        $this->add($this->image($path, $title, $attr, $modulepart));
        $this->add('</a>');

        return $this->getHtml();
    }

    //====================================================================//
    //  Display Buttons Outputs
    //====================================================================//

    /**
     * Return an Internal Button
     *
     * @param string     $url   Link target Absolute URL
     * @param string     $text  Link Text
     * @param null|array $query Query Parameters
     * @param null|array $attr  Display Attributes
     *
     * @return string
     */
    public function btn(string $url, string $text, array $query = null, array $attr = null): string
    {
        //====================================================================//
        //  Merge Defaults with Custom Attributes
        $btnAttr = array_replace(array("class" => "butAction"), is_array($attr) ? $attr : array());
        //====================================================================//
        //  Return generic Link
        return $this->absoluteLink(Helper::uri($url), $text, $query, $btnAttr);
    }

    /**
     * Return an Internal Button
     *
     * @param string     $text Link Text
     * @param null|array $attr Display Attributes
     *
     * @return string
     */
    public function btnRefused(string $text, array $attr = null): string
    {
        //====================================================================//
        //  Merge Defaults with Custom Attributes
        $btnAttr = array_replace(array("class" => "butActionRefused"), is_array($attr) ? $attr : array());
        //====================================================================//
        //  Return generic Link
        return $this->absoluteLink("", $text, array(), $btnAttr);
    }

    /**
     * Return an Internal Button
     *
     * @param string     $url   Link target Absolute URL
     * @param string     $text  Link Text
     * @param null|array $query Query Parameters
     * @param null|array $attr  Display Attributes
     *
     * @return string
     */
    public function btnNew(string $url, string $text, array $query = null, array $attr = null): string
    {
        //====================================================================//
        //  Merge Defaults with Custom Attributes
        $btnAttr = array_replace(array("class" => "butActionNew"), is_array($attr) ? $attr : array());
        //====================================================================//
        //  Return generic Link
        return $this->absoluteLink(Helper::uri($url), $text, $query, $btnAttr);
    }

    /**
     * Return an Internal Button New Refused
     *
     * @param string     $text Link Text
     * @param null|array $attr Display Attributes
     *
     * @return string
     */
    public function btnNewRefused(string $text, array $attr = null): string
    {
        //====================================================================//
        //  Merge Defaults with Custom Attributes
        $btnAttr = array_replace(array("class" => "butActionNewRefused"), is_array($attr) ? $attr : array());
        //====================================================================//
        //  Return generic Link
        return $this->absoluteLink("", $text, array(), $btnAttr);
    }

    /**
     * Return an Internal Button Delete
     *
     * @param string     $url   Link target Absolute URL
     * @param string     $text  Link Text
     * @param null|array $query Query Parameters
     * @param null|array $attr  Display Attributes
     *
     * @return string
     */
    public function btnDelete(string $url, string $text, array $query = null, array $attr = null): string
    {
        //====================================================================//
        //  Merge Defaults with Custom Attributes
        $btnAttr = array_replace(array("class" => "butActionDelete"), is_array($attr) ? $attr : array());
        //====================================================================//
        //  Return generic Link
        return $this->absoluteLink(Helper::uri($url), $text, $query, $btnAttr);
    }

    /**
     * Return an Internal Button Transparant
     *
     * @param string     $url   Link target Absolute URL
     * @param string     $text  Link Text
     * @param null|array $query Query Parameters
     * @param null|array $attr  Display Attributes
     *
     * @return string
     */
    public function btnTrans(string $url, string $text, array $query = null, array $attr = null): string
    {
        //====================================================================//
        //  Merge Defaults with Custom Attributes
        $btnAttr = array_replace(array("class" => "butActionTransparent"), is_array($attr) ? $attr : array());
        //====================================================================//
        //  Return generic Link
        return $this->absoluteLink(Helper::uri($url), $text, $query, $btnAttr);
    }

    //====================================================================//
    //  Display Various Outputs
    //====================================================================//

    /**
     * Return empty Separator
     *
     * @param int $count Number of lines
     *
     * @return $this
     *
     * @SuppressWarnings(PHPMD.ShortMethodName)
     */
    public function br(int $count = 1): self
    {
        for ($i = 0; $i < $count; $i++) {
            $this->add("<br />");
        }

        return $this->render();
    }

    /**
     * Return empty Separator
     *
     * @return $this
     *
     * @SuppressWarnings(PHPMD.ShortMethodName)
     */
    public function hr(): self
    {
        return $this->add("<hr />")->render();
    }
}
