#!/bin/bash
# Deploy script for Katherine Bank
# Pulls latest changes from GitHub

cd /var/www/katherine-bank
git pull https://github.com/shinichikudo18/finanzas.git main
