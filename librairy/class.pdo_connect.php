<?php
/**
 *
 * Copyright (c) 2015-Present, mandalorien
 * All rights reserved.
 *
 * create 2015 by mandalorien
 */

class DatabaseConnection
{
	private $_host;
	private $_user;
	private $_password;
	private $_database;
	private $_countquery;
	private $_vuequery;
	private $_timexecutequery;

	Public function __construct($host,$user,$password,$database)
	{
		$this->_host = $host;
		$this->_user = $user;
		$this->_password = $password;
		$this->_database = $database;
		$this->_vuequery = array();
		$this->_timexecutequery = array();
	}

	public function Get_Database(){
		return $this->_database;
	}
	
	// nombre de requete executer
	public function Update_Countquery(){
		$this->_countquery = $this->_countquery + 1;
	}
	
	// visualisation des requetes executer
	public function Update_Vuequery($sql){
		array_push($this->_vuequery,$sql);
	}
	
	// temps d'execution des requetes executer
	public function Update_Timexecutequery($time_start){
		$time_end = microtime(true);
		$microtime = $time_end - $time_start;
		array_push($this->_timexecutequery,$microtime);
	}
	
	public function Get_Countquery(){
		return $this->_countquery;
	}
	
	public function Get_Vuequery(){
		return $this->_vuequery;
	}
	
	public function Get_Timexecutequery(){
		return $this->_timexecutequery;
	}
	
	public function Connexion(){
		try
		{
			$db = new PDO("mysql:host={$this->_host};dbname={$this->_database}","{$this->_user}","{$this->_password}");
			$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$db->exec('SET NAMES UTF8');
		}
		catch (PDOException $e)
		{
			return false;
		}
		return $db;
	}
	
	public function Message(){
		try
		{
			$db = new PDO("mysql:host={$this->_host};dbname={$this->_database}","{$this->_user}","{$this->_password}");
			$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$db->exec('SET NAMES UTF8');
		}
		catch (PDOException $e)
		{
			return utf8_encode("<code>Error code : {$e->getCode()}" . PHP_EOL . " Error message : {$e->getMessage()}" . PHP_EOL . "</code><br />");
		}
	}
	
	Public function Close($db)
	{
		$db = null;
	}
}
?>