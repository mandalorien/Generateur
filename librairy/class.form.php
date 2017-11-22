<?php
/**
 *
 * Copyright (c) 2015-Present, mandalorien
 * All rights reserved.
 *
 * create 2015 by mandalorien
 */


class Form
{
	const MESS_SUCCESS  ='panel-success';
	const MESS_NORMALE  ='panel-info';
	const MESS_WARNING  ='panel-danger';
	const MESS_ALERT    ='panel-primary';

	const ALERT_SUCCESS ='alert-success';
	const ALERT_NORMALE ='alert-info';
	const ALERT_WARNING ='alert-warning';
	const ALERT_ALERT   ='alert-danger';
	
	private $_Template;
	
	public function __construct($template){
		$this->_Template = $template;
	}
	
	public function display($page, $title = NAME_SITE)
	{	
		$DisplayPage  = $this->StdUserHeader($title). PHP_EOL;
		$DisplayPage .= $this->ShowCorp($page,$title). PHP_EOL;
		$DisplayPage .= $this->StdFooter();
		
		echo $DisplayPage;
		die();
	}

	// ----------------------------------------------------------------------------------------------------------------
	//
	// Entete de page
	//
	private function StdUserHeader($title = NAME_SITE) 
	{
		$parse['Link'] = SITEURL;
		$parse['META_ENCODAGE'] = META_ENCODAGE;
		$parse['META_LANGAGE'] = META_LANGAGE;
		$parse['META_AUTHOR'] = META_AUTHOR;
		$parse['META_COPYRIGHT'] = META_COPYRIGHT;
		$parse['META_DESCRIPTION'] = META_DESCRIPTION;
		$parse['META_KEYWORDS'] = META_KEYWORDS;
		$parse['META_SUBJECT'] = META_SUBJECT;
		$parse['title'] = NAME_SITE;
		$parse['include_style_js'] = $this->Style();
		
		return $this->_Template->displaytemplate(('structure/simple_header'), $parse);
	}

	// ----------------------------------------------------------------------------------------------------------------
	//
	// Feuille(s) de style(s) et script(s)
	private function Style() 
	{	
		$parse['Link'] = SITEURL;
		$parse['time'] ='<script type="text/javascript" src="scripts/time.js"></script>';
		$parse['Style'] = "styles/default";
		
		return $this->_Template->displaytemplate(('structure/simple_style'), $parse);
	}

	// ----------------------------------------------------------------------------------------------------------------
	//
	// Menu de page

	private function ShowMenu()
	{
		global $lang;
		
		$parse = $lang;
		$parse['link'] = SITEURL;
		$parse['NAME_SITE'] = NAME_SITE;
		
		return $this->_Template->displaytemplate(('structure/menu'), $parse);
	}

	// ----------------------------------------------------------------------------------------------------------------
	//
	// Corp de page

	private function ShowCorp($page,$name)
	{	
		$DisplayCorp = $this->ShowMenu();
		$DisplayCorp .= $page;
		
		return $DisplayCorp;
	}

	// ----------------------------------------------------------------------------------------------------------------
	//
	// Pied de page

	private function StdFooter() {
		
		$parse['SCRIPT'] = '';
		
		$parse['link'] = SITEURL;
		$parse['copyright'] ='&copy; '.DATE_VERSION.' '. NAME_SITE .' <a href="#" title="V'.VERSION.'">V '.VERSION.'</a>';
		// $parse['credit'] = $lang['Credits'];
		$parse['credit'] = 'Crédit : '.META_AUTHOR;
		$parse['design'] = 'design bootswatch ';
		
		return $this->_Template->displaytemplate(('structure/overall_footer'), $parse);
	}

	// ----------------------------------------------------------------------------------------------------------------
	//
	// message dans la page

	public function Message($titre,$mess,$type) {
		
		$parse['titre'] = $titre;
		$parse['mess'] = $mess;
		$parse['type'] = $type;
		return $this->_Template->displaytemplate(('structure/message'), $parse);
	}

	public function AlertMessage($titre,$mess,$type) {
		
		$parse['titre'] = $titre;
		$parse['mess'] = $mess;
		$parse['type'] = $type;
		return $this->_Template->displaytemplate(('structure/message_bulle'), $parse);
	}
}
?>