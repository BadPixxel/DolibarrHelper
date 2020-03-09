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

namespace BadPixxel\Dolibarr\Tests\Mink;

/**
 * Module Mink Functions to Access Dolibarr from Browser
 */
trait ModulesTrait
{
    /**
     * Verify Module Exits
     */
    public function moduleExists(string $modName): void
    {
        $page = $this->visit('/admin/modules.php');
        $btn = $page->find('xpath', '//a[contains(@href, "'.$modName.'")]');
        //====================================================================//
        // Verify Module was Found
        $this->assertContains(
            'fa-toggle-',
            $btn->getHtml()
        );
    }

    /**
     * Test enabling a module
     */
    public function moduleEnable(string $modName): void
    {
        $page = $this->visit('/admin/modules.php');
        $btn = $page->find('xpath', '//a[contains(@href, "'.$modName.'")]');
        //====================================================================//
        // Verify Module was Found
        $this->assertContains(
            'fa-toggle-',
            $btn->getHtml()
        );
        if ($btn->find('css', 'span')->hasClass('fa-toggle-off')) {
            // Enable the module
            $btn->click();
        } else {
            // Disable the module
            $btn->click();
            // Reenable the module
            $btn->click();
        }

        $this->getSession()->reload();
        //====================================================================//
        // Verify Module is Marked as Enabled
        $this->assertContains(
            'fa-toggle-on',
            $page->find('xpath', '//a[contains(@href, "'.$modName.'")]')->getHtml()
        );
    }
}
