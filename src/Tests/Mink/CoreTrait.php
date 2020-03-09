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

use Behat\Mink\Driver\Goutte\Client as GoutteClient;
use Behat\Mink\Driver\GoutteDriver;
use Behat\Mink\Element\DocumentElement;
use Behat\Mink\Session;
use GuzzleHttp\Client as GuzzleClient;

/**
 * Core Mink Functions to Access Dolibarr from Browser
 */
trait CoreTrait
{
    /**
     * @var Session
     */
    private $session;

    /**
     * Setup Dolibarr Default Language
     *
     * @param string $isoLang
     *
     * @return void
     */
    public function setupDefaultLanguage(string $isoLang): void
    {
        $page = $this->visit('/admin/ihm.php?action=edit');
        $this->assertPageIsLoaded();
        //====================================================================//
        // Change Language
        $page->fillField("MAIN_LANG_DEFAULT", $isoLang);
        $btn = $page->findButton('submit');
        $this->assertNotEmpty($btn);
        $btn->click();
    }
    /**
     * Get Current User Session
     *
     * @return Session
     */
    protected function getSession() : Session
    {
        return $this->session;
    }

    /**
     * Start PhpUnit User Session
     *
     * @return void
     */
    protected function setupSession()
    {
        $this->ensureInit();
        //====================================================================//
        // We Uses Dolibarr in French
        $this->session->setRequestHeader('Accept-Language', 'fr_FR');
        //====================================================================//
        // Connect User to Dolibarr
        $this->ensureLogin();

        /** @var GoutteDriver $driver */
        $driver = $this->session->getDriver();
        $driver->getClient()->followRedirects(true);
    }

    protected function ensureLogin()
    {
        //====================================================================//
        // On se connecte a Dolibarr
        $page = $this->visit('index.php');
        //====================================================================//
        // Login??
        if ($page->findById('login')) {
            //====================================================================//
            // Rempli le Formulaire et Connecte
            $page->fillField("username", DOL_PHPUNIT_USER);
            $page->fillField("password", DOL_PHPUNIT_PWD);
            //====================================================================//
            // Multicompany ??
            $select = $page->findById('entity');
            if ($select) {
                $select->selectOption(DOL_PHPUNIT_ENTITY);
            }
            $btnLogin = $page->findButton('Se connecter');
            if ($btnLogin) {
                $btnLogin->press();
            }
        }
        $indexTitle = $this->visit('index.php')->find('css', 'title');
        self::assertNotEmpty($indexTitle);
        //====================================================================//
        // On verifie que la config Minimale est faite
        if (false === strpos("Configuration", $indexTitle->getHtml())) {
            $this->ensureConfig();
        } else {
            //====================================================================//
            // On verifie
            self::assertContains('accueil', strtolower($indexTitle->getHtml()));
        }
    }

    /**
     * Extract Parameters from Current Url
     *
     * @return array
     */
    protected function getUrlQueryArgs() : array
    {
        $args = array();

        parse_str(
            (string) parse_url($this->getSession()->getCurrentUrl(), PHP_URL_QUERY),
            $args
        );

        return $args;
    }

    /**
     * Extract One Parameter from Current Url
     *
     * @param string $name
     *
     * @return null|string
     */
    protected function getUrlQueryArg(string  $name): ?string
    {
        $args = $this->getUrlQueryArgs();

        return isset($args[$name]) ? $args[$name] : null;
    }

    /**
     * Asert Page is Loaded
     *
     * @return void
     */
    protected function assertPageIsLoaded(): void
    {
        self::assertEquals(200, $this->session->getStatusCode(), $this->session->getPage()->getHtml());
    }

    /**
     * Visit a Dolibarr Page
     *
     * @param string $url
     *
     * @return DocumentElement
     */
    protected function visit($url): DocumentElement
    {
        $this->session->visit(DOL_PHPUNIT_HOST.$url);

        return $this->session->getPage();
    }

    /**
     * Ensure Minimal Dolibarr Configuration is Done
     *
     * @return void
     */
    private function ensureConfig()
    {
        //====================================================================//
        // Configure Company
        $page = $this->visit('admin/company.php?action=edit');
        //====================================================================//
        // Fill the Form & Go
        $page->fillField("name", "BadPixxel PhpUnit Test");
        $page->fillField("selectcountry_id", 1);
        $page->findButton('Enregistrer')->click();
        //====================================================================//
        // On verifie
        self::assertContains(
            'accueil',
            strtolower($this->visit('index.php')->find('css', 'title')->getHtml())
        );
    }

    /**
     * Start PhpUnit User Session
     *
     * @return void
     */
    private function ensureInit()
    {
        if (!($this->session instanceof Session)) {
            $client = new GoutteClient;
            $client->setClient(
                new GuzzleClient(array(
                    'allow_redirects' => false,
                    'cookies' => true,
                    'verify' => false
                ))
            );
            $driver = new GoutteDriver($client);
            $this->session = new Session($driver);
        }
    }
}
