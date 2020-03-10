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

namespace BadPixxel\Dolibarr\Tests\Tools;

use BadPixxel\Dolibarr\Helper;
use DoliDB;
use PHPUnit\Framework\Assert;
use Product;

/**
 * Execute Dolibarr Products Actions for PhpUnit Tests
 *
 * Tests Products are Accessed By Ref. for Smarter Usage
 */
class ProductActions
{
    /**
     * Create a New Product with Values
     *
     * @global DoliDB $db
     *
     * @param string $ref
     * @param array  $values
     * @param bool   $runTriggers
     *
     * @return Product
     */
    public static function create(string $ref, array $values = array(), $runTriggers = true): Product
    {
        global $db, $user;

        self::init();
        $product = new Product($db);
        //====================================================================//
        // Pre-Setup of Dolibarr infos
        $dfValues = array(
            "ref" => $ref,
            "label" => ucfirst($ref),
            "weight" => 0,
            "type" => 0,
            "barcode" => -1,
        );
        self::setProperties($product, array_replace_recursive($dfValues, $values));
        //====================================================================//
        // Create Product in database
        if (1 != $product->create($user, $runTriggers ? 0 : 1)) {
            Helper::log()->catchDolibarrErrors($product);
        }
        Assert::assertNotEmpty($product->id);

        return $product;
    }

    /**
     * Get Product from Database
     *
     * @global DoliDB $db
     *
     * @param string $ref
     *
     * @return Product
     */
    public static function get(string $ref): Product
    {
        global $db;

        self::init();
        $product = new Product($db);
        $product->fetch(null, $ref);
        Assert::assertNotEmpty($product->id);
        Assert::assertEquals($ref, $product->ref);

        return $product;
    }

    /**
     * Create a New Product with Values
     *
     * @global DoliDB $db
     *
     * @param string $ref
     * @param array  $values
     * @param bool   $runTriggers
     *
     * @return Product
     */
    public static function set(Product $product, array $values = array(), $runTriggers = true): Product
    {
        global $user;

        self::init();
        self::setProperties($product, $values);
        //====================================================================//
        // Update Product in database
        Assert::assertNotEmpty($product->id);
        $result = $product->update($product->id, $user, $runTriggers ? 0 : 1);
        if (1 != $result) {
            Helper::log()->assertDolibarrErrors($product);
        }
        Assert::assertEquals(1, $result);

        return $product;
    }

    /**
     * Update Product with Values
     *
     * @param Product $product
     * @param array   $values
     *
     * @return void
     */
    private static function setProperties(Product &$product, array $values): void
    {
        foreach ($values as $key => $value) {
            $product->{$key} = $value;
        }
    }

    /**
     * Init This Library
     *
     * @return void
     */
    private static function init(): void
    {
        //====================================================================//
        // Classes Dolibarr
        require_once DOL_DOCUMENT_ROOT.'/core/lib/product.lib.php';
        require_once DOL_DOCUMENT_ROOT.'/product/class/product.class.php';
    }
}
