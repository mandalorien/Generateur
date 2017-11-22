<?php
require_once('constant.php');

require_once(ROOT_PATH .'librairy/class.template.php');# Base de donnee
require_once(ROOT_PATH .'librairy/class.form.php');# Base de donnee

$template = new Template();
$form = new Form($template);

$parse = array();
$parse['SCRIPT'] = SCRIPT;
$form->display($template->displaytemplate('install_body', $parse));
?>