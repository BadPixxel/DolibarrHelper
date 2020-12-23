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

namespace BadPixxel\Dolibarr\Helpers;

use BadPixxel\Dolibarr\Models\AbstractHelper;

/**
 * Execute Core Dolibarr Framework Actions
 */
class Framework extends AbstractHelper
{
    /**
     * @var string
     */
    const MAIN_INC = "main.inc";

    /**
     * @var string
     */
    const MASTER_INC = "master.inc";

    /**
     * Detect Document Root Path
     *
     * @var null|string
     */
    private $rootPath;

    /**
     * Detect Main Include File Path to Boot Dolibarr Environment
     *
     * @SuppressWarnings(PHPMD.ExitExpression)
     */
    public function inc(): string
    {
        //====================================================================//
        // Try Root Path Detection
        $rootPath = $this->getRootPath();
        $mainInc = "/".self::MAIN_INC.".php";
        //====================================================================//
        // Path detection Failed
        if ((null === $rootPath) || (!is_file($rootPath.$mainInc))) {
            die("Detection of MAIN includes file fails");
        }
        //====================================================================//
        // Return Path to Dolibarr MainInclude
        return $rootPath.$mainInc;
    }

    /**
     * Detect Master Include File and Boot Dolibarr Environment for Scripting
     *
     * @SuppressWarnings(PHPMD.UnusedLocalVariable)
     * @SuppressWarnings(PHPMD.CamelCaseVariableName)
     * @SuppressWarnings(PHPMD.ExitExpression)
     * @SuppressWarnings(PHPMD.LongVariableName)
     */
    public function boot(): void
    {
        /** @codingStandardsIgnoreStart */
        global $db, $langs, $conf, $user, $hookmanager, $dolibarr_main_url_root;
        /** @codingStandardsIgnoreEnd */

        //====================================================================//
        // Try Root Path Detection
        $rootPath = $this->getRootPath();
        $masterInc = "/".self::MASTER_INC.".php";
        //====================================================================//
        // Path detection Failed
        if ((null === $rootPath) || (!is_file($rootPath.$masterInc))) {
            die("Detection of MASTER includes file fails");
        }
        //====================================================================//
        // Boot Dolibarr
        include_once($rootPath.$masterInc);
        include_once DOL_DOCUMENT_ROOT.'/core/lib/functions.lib.php';
    }

    /**
     * Search for Dolibarr Root Folder in upper folders
     *
     * @param int $maxLevels Mximim Number of Levels
     *
     * @return null|string
     *
     * @SuppressWarnings(PHPMD.Superglobals)
     */
    public function getRootPath(int $maxLevels = 8): ?string
    {
        //====================================================================//
        // Already Detected ?
        if (isset($this->rootPath)) {
            return $this->rootPath;
        }
        //====================================================================//
        // Try main.inc.php into web root known defined into CONTEXT_DOCUMENT_ROOT (not always defined)
        if (isset($_SERVER["CONTEXT_DOCUMENT_ROOT"]) && is_file($_SERVER["CONTEXT_DOCUMENT_ROOT"]."/main.inc.php")) {
            return $this->rootPath = $_SERVER["CONTEXT_DOCUMENT_ROOT"];
        }
        //====================================================================//
        // Always Start From Folder Above this module
        $rootPath = __DIR__;
        for ($i = 0; $i < 2; $i++) {
            $rootPath = dirname($rootPath);
        }
        //====================================================================//
        // Search for Dolibarr Root Folder
        for ($i = 0; $i < $maxLevels; $i++) {
            //====================================================================//
            // Check if main.inc.phpo file exist
            if (is_file($rootPath."/main.inc.php")) {
                return $this->rootPath = $rootPath;
            }
            //====================================================================//
            // Move one folder above
            $rootPath = dirname($rootPath);
        }

        return null;
    }

    /**
     * Security checks - Protection if User is NOT Logged
     */
    public function isLogged(): self
    {
        global $user;
        //====================================================================//
        // Check User is Logged
        if (empty($user)) {
            accessforbidden();
        }

        return $this;
    }

    /**
     * Security checks - Protection if User is Not Internal
     */
    public function isInternal(): self
    {
        global $user;
        //====================================================================//
        // Check User is Logged
        $this->isLogged();
        //====================================================================//
        // Protection if external user
        if ($user->societe_id > 0) {
            accessforbidden();
        }

        return $this;
    }

    /**
     * Security checks - Protection if User is Not Admin
     */
    public function isAdmin(): self
    {
        global $user;
        //====================================================================//
        // Check this is An Internal User
        $this->isInternal();
        //====================================================================//
        // Check User Rights
        if (!$user->admin) {
            accessforbidden();
        }

        return $this;
    }

    /**
     * Detect File Url from Absolute Path
     *
     * @param string $path
     *
     * @return string
     */
    public function pathToUrl(string $path): string
    {
        //====================================================================//
        // Safety Checks
        if (empty($this->getRootPath()) || !is_file($path)) {
            return dol_buildpath("theme/eldy/img/warning.png", 1);
        }
        //====================================================================//
        // Try to detect File Url
        $relPath = explode((string) $this->getRootPath(), (string) realpath($path));
        if (!is_array($relPath) || !isset($relPath[1])) {
            return dol_buildpath("theme/eldy/img/warning.png", 1);
        }

        return dol_buildpath($relPath[1], 1);
    }

    /**
     * Safe Get of A Global Parameter
     *
     * @param string      $key     Global Parameter Key
     * @param null|string $default Default Parameter Value
     *
     * @return null|string
     */
    public static function getConst(string $key, string $default = null)
    {
        global $conf;

        return isset($conf->global->{$key})  ? $conf->global->{$key} : $default;
    }

    /**
     * Safe Set of A Global Parameter
     *
     * @param string $key   Global Parameter Key
     * @param string $value Default Parameter Value
     * @param mixed  $type
     *
     * @return bool
     */
    public static function setConst(string $key, $value, $type = "chaine"): bool
    {
        global $db, $conf, $langs;

        include_once DOL_DOCUMENT_ROOT.'/core/lib/admin.lib.php';
        //====================================================================//
        // Update value in Database
        $res = dolibarr_set_const($db, $key, $value, $type, 0, '', $conf->entity);
        //====================================================================//
        // Display user message
        if ($res) {
            setEventMessages($langs->trans('RecordSaved'), array(), 'mesgs');

            return true;
        }
        setEventMessages($langs->trans('Error'), array(), 'error');

        return false;
    }

    /**
     * Safe Get of A Dolibarr Path Url
     *
     * @param string $relativePath Relitive Uri Path
     *
     * @return string
     */
    public static function getUri(string $relativePath = ""): string
    {
        //====================================================================//
        // Link to Current Uri
        if ("#" == $relativePath) {
            return self::getCurrentUri();
        }
        //====================================================================//
        // Link to Current Uri with Anchor
        if (0 === strpos($relativePath, "#")) {
            return self::getCurrentUri().$relativePath;
        }
        //====================================================================//
        // Link to Another Relative Path
        return dol_buildpath($relativePath, 1);
    }

    /**
     * Safe Get Current User Uri
     *
     * @return string
     *
     * @SuppressWarnings(PHPMD.Superglobals)
     */
    public static function getCurrentUri(): string
    {
        return $_SERVER["PHP_SELF"];
    }

    /**
     * Compare Dolibarr version is lower/greater then version given.
     *
     * @param string $version Dolibarr Version to compare (ie : 3.3.3)
     *
     * @return int -1 if given version is lower then current version
     *             0 if given version is egal to current version
     *             1 if given version is above current version
     *
     * @SuppressWarnings(PHPMD.CyclomaticComplexity)
     * @SuppressWarnings(PHPMD.NPathComplexity)
     */
    public static function dolVersionCmp($version)
    {
        $current = explode('.', DOL_VERSION);
        $cmp = explode('.', $version);

        if (($current["0"] == $cmp ["0"]) && ($current["1"] == $cmp ["1"]) && ($current["2"] == $cmp ["2"])) {
            return 0;
        }
        if (($current["0"] > $cmp ["0"])) {
            return 1;
        }
        if (($current["0"] < $cmp ["0"])) {
            return -1;
        }
        if (($current["1"] > $cmp ["1"])) {
            return 1;
        }
        if (($current["1"] < $cmp ["1"])) {
            return -1;
        }
        if (($current["2"] > $cmp ["2"])) {
            return 1;
        }
        if (($current["2"] < $cmp ["2"])) {
            return -1;
        }

        return 0;
    }
}
