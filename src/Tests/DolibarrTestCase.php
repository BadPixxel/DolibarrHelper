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

namespace BadPixxel\Dolibarr\Tests;

use BadPixxel\Dolibarr\Helper;
use BadPixxel\Dolibarr\Tests\Tools\CoreActions;
use PHPUnit\Framework\TestCase;

/**
 * Base Test Case for Dolibarr Modules Testing
 */
class DolibarrTestCase extends TestCase
{
    use Mink\CoreTrait;
    use Mink\ModulesTrait;

    /**
     * Boot PhpUnit Test Case
     *
     * @return void
     */
    protected function setUp(): void
    {
        //====================================================================//
        // Boot Dolibarr in PHP
        Helper::dol()->boot();
        CoreActions::setupEntity();
        CoreActions::setupMySoc();
        CoreActions::setupUser();
        //====================================================================//
        // Start Mink Browser Session & Connect to Dolibarr
        $this->setupSession();
    }

    /**
     * Verify Booting Dolibarr
     *
     * @return void
     *
     * @SuppressWarnings(PHPMD.CamelCaseVariableName)
     * @SuppressWarnings(PHPMD.LongVariableName)
     */
    public function testBootDolibarr(): void
    {
        global $db,$langs,$conf,$user,$hookmanager, $dolibarr_main_url_root;

        $this->assertNotEmpty($db);
        $this->assertNotEmpty($langs);
        $this->assertNotEmpty($conf);
        $this->assertNotEmpty($user);
        $this->assertNotEmpty($hookmanager);
        $this->assertNotEmpty($dolibarr_main_url_root);
    }
}
