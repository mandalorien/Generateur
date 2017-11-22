<?php
/**
 *
 * Copyright (c) 2015-Present, mandalorien
 * All rights reserved.
 *
 * create 2015 by mandalorien
 */
 
ini_set('session.use_cookies', '1');
ini_set('session.use_only_cookies', '1');
ini_set('url_rewriter.tags', '');

ini_set('error_reporting',E_ALL);
ini_set('display_errors',true);

define('URL_LIGHT',		false);
define('MODE_DEBUG',	false);
define('MODE_LOG',		true);

define('ROOT_PATH', dirname(__FILE__) . DIRECTORY_SEPARATOR); # racine du dossier

define('CACHE',ROOT_PATH .'cache/');
define('LIBRAIRY',ROOT_PATH .'librairy/');
define('LOG_FILES',ROOT_PATH .'log/');
define('CLASSE_EXTENDS',ROOT_PATH .'class/');
define('CLASSE_ORIGIN',ROOT_PATH .'model/');
define('VUES',ROOT_PATH .'ressources');

# pour le header de page
define('META_ENCODAGE','utf-8');
define('META_LANGAGE','fr');
define('META_AUTHOR','mandalorien');
define('META_COPYRIGHT','mandalorien');
define('META_DESCRIPTION','la meta description');
define('META_KEYWORDS','keywords');
define('META_SUBJECT','sujet');

define('VERSION','0.0.1');
define('DATE_VERSION','2016');
define('NAME_SITE','Generateur');
define('FOLDER','Generateur/');
define('CONTACT_WEBSITE','mandalorien.wootook@gmail.com');


$baseUrl = $_SERVER["HTTP_REFERER"] . ($_SERVER["SERVER_PORT"] != "80" ? ":{$_SERVER["SERVER_PORT"]}" : '');
define('SITEURL',$baseUrl . DIRECTORY_SEPARATOR . FOLDER);
define('CSS',SITEURL .'styles/');
define('IMAGES',SITEURL .'images/');
define('JQUERY',SITEURL .'jquery/');
define('SCRIPT',SITEURL .'scripts/');
?>