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
use BadPixxel\ProductMixer\Tests\Names;
use DoliDB;
use Entrepot;
use MouvementStock;
use PHPUnit\Framework\Assert;
use Product;

/**
 * Execute Dolibarr Products Stocks Actions for PhpUnit Tests
 */
class StocksActions
{
    /**
     * @var int 2=output (stock decrease)
     */
    const STOCK_OUT = 2;

    /**
     * @var int 3=input (stock increase)
     */
    const STOCK_IN = 3;

    /**
     * Create a New Warehouse with Values
     *
     * @global DoliDB $db
     *
     * @param string $ref
     * @param array  $values
     *
     * @return Entrepot
     */
    public static function createWarehouse(string $ref, array $values = array()): Entrepot
    {
        global $db, $user;

        self::init();
        $warehouse = new Entrepot($db);
        //====================================================================//
        // Pre-Setup of Dolibarr infos
        $dfValues = array(
            "ref" => $ref,
            "lieu" => ucfirst($ref),
            "libelle" => ucfirst($ref),
            "statut" => 1,
        );
        self::setProperties($warehouse, array_replace_recursive($dfValues, $values));
        //====================================================================//
        // Create Warehouse in database
        if (1 != $warehouse->create($user)) {
            Helper::log()->assertDolibarrErrors($warehouse);
        }
        Assert::assertNotEmpty($warehouse->id);

        return $warehouse;
    }

    /**
     * Get Warehouse from Database
     *
     * @global DoliDB $db
     *
     * @param string $ref
     *
     * @return Entrepot
     */
    public static function getWarehouse(string $ref = null): Entrepot
    {
        global $db;

        self::init();
        $warehouse = new Entrepot($db);
        if ($ref) {
            $warehouse->fetch(0, $ref);
        }
        if (!$ref) {
            $warehouse->fetch(1);
        }
        Assert::assertNotEmpty($warehouse->id);
        Assert::assertEquals($ref, $warehouse->ref);

        return $warehouse;
    }

    /**
     * Change Product Stock.
     *
     * @global DoliDB $db
     * @global User $user
     *
     * @param Product $product
     * @param int     $qty
     * @param string  $warhouse
     *
     * @return void
     */
    public static function change(Product $product, int $qty, string $warhouse = null): void
    {
        global $db, $user;
        //====================================================================//
        // Ensure Warehouse Id
        $warehouse = self::getWarehouse($warhouse);
        //====================================================================//
        // Create Stock Mouvement Object
        $movementstock = new MouvementStock($db);
        $movementstock->_create(
            $user,
            $product->id,
            $warehouse->id,
            abs($qty),
            ($qty > 0) ? self::STOCK_IN : self::STOCK_OUT,
            0,
            "PMX PhpUnit Change"
        );
    }

    /**
     * Set Product Stock.
     *
     * @global DoliDB $db
     * @global User $user
     *
     * @param Product $product
     * @param int     $qty
     * @param string  $whref
     *
     * @return void
     */
    public static function set(Product $product, int $qty, string $whref = null): void
    {
        global $user;

        //====================================================================//
        // Load Product Stock
        $product->load_stock();
        //====================================================================//
        // Ensure Warehouse Id
        $warehouse = self::getWarehouse($whref ? $whref : Names::WH_1);
        //====================================================================//
        // Ciorrect Stocks
        $current = self::get($product, $whref);
        $nbpiece = abs($current - $qty);
        $movement = ($current < $qty) ? 0 : 1;
        $product->correct_stock($user, $warehouse->id, $nbpiece, $movement, "PMX PhpUnit Set");
    }

    /**
     * Get Product Stock.
     *
     * @global DoliDB $db
     * @global User $user
     *
     * @param Product $product
     * @param string  $whref
     *
     * @return int
     */
    public static function get(Product $product, string $whref = null): int
    {
        //====================================================================//
        // Load Product Stock
        $product->load_stock();
        //====================================================================//
        // Get Real Stock
        if (null === $whref) {
            return (int) $product->stock_reel;
        }
        //====================================================================//
        // Get WareHouse Stock
        $warehouse = self::getWarehouse($whref);
        if (isset($product->stock_warehouse[$warehouse->id])) {
            return (int) $product->stock_warehouse[$warehouse->id]->real;
        }

        return 0;
    }

    /**
     * Update Warehouse with Values
     *
     * @param Product $warehouse
     * @param array   $values
     *
     * @return void
     */
    private static function setProperties(Entrepot &$warehouse, array $values): void
    {
        foreach ($values as $key => $value) {
            $warehouse->{$key} = $value;
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
        require_once DOL_DOCUMENT_ROOT.'/product/stock/class/entrepot.class.php';
        require_once DOL_DOCUMENT_ROOT.'/product/stock/class/mouvementstock.class.php';
    }
}
