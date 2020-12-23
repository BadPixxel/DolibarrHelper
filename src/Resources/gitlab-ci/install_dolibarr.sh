#!/bin/bash
################################################################################
#
# Copyright (C) 2020 BadPixxel <www.badpixxel.com>
#
# This program is distributed in the hope that it will be useful,
# but WITHOUT ANY WARRANTY; without even the implied warranty of
# MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
#
# For the full copyright and license information, please view the LICENSE
# file that was distributed with this source code.
#
################################################################################

echo "----------------------------------------------------"
echo "--> Install Dolibarr $DOLIBARR_VERSION"
echo "----------------------------------------------------"

################################################################
# Clone Dolibarr & Move to Web folder
git clone --depth=1 --branch="$DOLIBARR_VERSION" https://github.com/Dolibarr/dolibarr.git /var/www/html

################################################################
# Copy Dolibarr Configuration
cp -Rf $CI_PROJECT_DIR/src/Resources/gitlab-ci/conf.php     /var/www/html/htdocs/conf/conf.php