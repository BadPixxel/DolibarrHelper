<?php

/*
 *  Copyright (C) 2021 BadPixxel <www.badpixxel.com>
 *
 *  This program is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 *
 *  For the full copyright and license information, please view the LICENSE
 *  file that was distributed with this source code.
 */

namespace BadPixxel\Dolibarr\Models;

/**
 * For Helpers who Generate Html
 */
trait HtmlBuilderTrait
{
    /**
     * Helper Html Buffer
     *
     * @var string
     */
    protected $html = "";

    /**
     * Return Html Buffer & Clear
     */
    public function getHtml(): string
    {
        $html = $this->html;
        $this->clear();

        return $html;
    }

    /**
     * Echo Html Buffer & Clear
     *
     * @return $this
     */
    public function render(): self
    {
        print $this->html;
        $this->clear();

        return $this;
    }

    /**
     * Add to Html Buffer
     *
     * @param string $contents
     *
     * @return $this
     */
    protected function add(string $contents): self
    {
        $this->html .= $contents;

        return $this;
    }

    /**
     * Clear Html Buffer
     *
     * @return $this
     */
    protected function clear(): self
    {
        $this->html = "";

        return $this;
    }

    /**
     * Check if Html Buffer is Empty
     */
    protected function isEmpty(): bool
    {
        return empty($this->html);
    }

    /**
     * Merge Two Array of Html Attributes and return Attributes String
     *
     * @param array      $default
     * @param null|array $custom
     *
     * @return string
     */
    protected static function attr(array $default, array $custom = null): string
    {
        //====================================================================//
        //  Merge Defaults with Custom Attributes
        $attributes = (array) array_replace($default, is_array($custom) ? $custom : array());
        //====================================================================//
        //  Build Attributes String
        $attrString = "";
        foreach ($attributes as $key => $value) {
            $attrString .= $key.'="'.$value.'" ';
        }
        //====================================================================//
        //  Retun Attributes String
        return $attrString;
    }

    /**
     * Merge Two Array of Query Values and return Html Query String
     *
     * @param array      $default
     * @param null|array $custom
     *
     * @return string
     */
    protected static function toQuery(array $default = null, array $custom = null): string
    {
        //====================================================================//
        //  Merge Defaults with Custom Attributes
        $query = array_replace(
            is_array($default) ? $default : array(),
            is_array($custom) ? $custom : array()
        );
        //====================================================================//
        //  If Empty Attributes
        if (empty($query)) {
            return "";
        }
        //====================================================================//
        //  Build Query String
        $queryString = "";
        $first = true;
        foreach ($query as $key => $value) {
            $queryString .= $first ? '?' : '&';
            $queryString .= $key.'='.$value;
            $first = false;
        }
        //====================================================================//
        //  Retun Query String
        return $queryString;
    }
}
