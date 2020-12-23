<?php

/*
 *  Copyright (C) 2020 BadPixxel <www.badpixxel.com>
 *
 *  This program is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 *
 *  For the full copyright and license information, please view the LICENSE
 *  file that was distributed with this source code.
 */

namespace BadPixxel\Dolibarr\Tests\Mink;

use Behat\Mink\Element\NodeElement as Element;

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
        self::assertInstanceOf(Element::class, $btn);
        //====================================================================//
        // Verify Module was Found
        $this->assertStringContainsStringIgnoringCase(
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
        self::assertInstanceOf(Element::class, $btn);
        self::assertStringContainsStringIgnoringCase('fa-toggle-', $btn->getHtml());
        $span = $btn->find('css', 'span');
        self::assertInstanceOf(Element::class, $span);
        if ($span->hasClass('fa-toggle-off')) {
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
        $reloadBtn = $page->find('xpath', '//a[contains(@href, "'.$modName.'")]');
        self::assertInstanceOf(Element::class, $reloadBtn);
        self::assertStringContainsStringIgnoringCase('fa-toggle-on', $reloadBtn->getHtml());
    }
}
