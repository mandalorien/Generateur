<?php
/**
 *
 * Copyright (c) 2015-Present, mandalorien
 * All rights reserved.
 *
 * create 2015 by mandalorien
 */

class Classes extends DatabaseConnection
{
	private $_PDO;
	private $_NumbersTables = 0;
	private $_Table;
	private $_ListTables = array();
	private $_Prefix = '';
	
	
	public function __construct($connexion){
		$this->_PDO = $connexion;
		$this->_NumbersTables = 0;
	}
	
	public function set_Table($table){
		$this->_Table = $table;
	}
	
	public function get_listTables(){
		return $this->_ListTables;
	}
	
	public function get_NumbersTables(){
		return count($this->_ListTables);
	}
	
	public function set_Prefix($var){
		$this->_Prefix = $var;
	}
	
	public function write_class($database,$crush = false,$constructeur = false){
		
		$templates = new Template();
		
		// const table
		$ParseConst['name'] = strtoupper('TABLE');
		$ParseConst['value'] = $this->_Table;
				
		$construct = $templates->displaytemplate('models/attributes/constant',$ParseConst). PHP_EOL . PHP_EOL;
		
		// methods list table
		$this->list_tables($database);
		
		if(in_array($this->_Table,$this->_ListTables)){
			
			$parse = null;
			
			if($constructeur){
				$ParseMethodsConstruct['varMethods'] = '';
				$ParseMethodsConstruct['Method'] = '';
				$methods =$templates->displaytemplate('models/methods/construct',$ParseMethodsConstruct). PHP_EOL;
			}else{
				$methods = null;
			}
			
			foreach($this->list_columns() as $columns){
				
				// attributes
				$ParseConst['name'] = strtoupper($columns->Field);
				$ParseConst['value'] = $columns->Field;
				
				$construct .= $templates->displaytemplate('models/attributes/constant',$ParseConst). PHP_EOL;

				$ParseAttrib['name'] = ucfirst(strtolower($columns->Field));
				
				if($columns->Key == 'PRI'){
					$construct .= $templates->displaytemplate('models/attributes/protected',$ParseAttrib). PHP_EOL;
				}else{
					$construct .= $templates->displaytemplate('models/attributes/private',$ParseAttrib). PHP_EOL;
				}
				$construct .= PHP_EOL;
				
				// methods
				// Get
				
				$attr = '/***'. PHP_EOL;
				$attr .= '		@'.$columns->Field . DIRECTORY_SEPARATOR .$columns->Type . DIRECTORY_SEPARATOR .$columns->Key . PHP_EOL;
				$attr .= '	***/'. PHP_EOL;
				$ParseMethodPublic['attributes'] = $attr;
				$ParseMethodPublic['nameMethod'] = 'Get_'. ucfirst(strtolower($columns->Field));
				$ParseMethodPublic['varMethods'] = null;
				$ParseMethodPublic['Method'] = 'return $this->_'.ucfirst(strtolower($columns->Field)) .';';
				
				$methods .= $templates->displaytemplate('models/methods/public',$ParseMethodPublic). PHP_EOL;
				
				
				// Set
				$ParseMethodPublic['attributes'] = null;
				$ParseMethodPublic['nameMethod'] = 'Set_'. ucfirst(strtolower($columns->Field));
				$ParseMethodPublic['varMethods'] = '$var';
				$ParseMethodPublic['Method'] = '$this->_'.ucfirst(strtolower($columns->Field)) .' = $var;';
				
				$methods .= $templates->displaytemplate('models/methods/public',$ParseMethodPublic). PHP_EOL;
				
				$methods .= PHP_EOL;
			}
			
			$parse['nameclass'] = $this->_Prefix . ucfirst(strtolower($this->removePrefix($this->_Table)));
			$parse['methods'] = $methods;
			$parse['attributes'] = $construct;
			$classe = $templates->displaytemplate('models/corp',$parse);

			//on s'occupe des création
			if(!file_exists(CLASSE_ORIGIN)){mkdir(CLASSE_ORIGIN, 0755);}
			
			if($crush){
				file_put_contents(CLASSE_ORIGIN  . $this->_Prefix . ucfirst(strtolower($this->removePrefix($this->_Table))).'.php', $classe);
			}else{
				if(!file_exists(CLASSE_ORIGIN . DIRECTORY_SEPARATOR . $this->_Prefix .ucfirst(strtolower($this->removePrefix($this->_Table))).'.php')){
					file_put_contents(CLASSE_ORIGIN  . $this->_Prefix . ucfirst(strtolower($this->removePrefix($this->_Table))).'.php', $classe);
				}
			}
			// la on executera toutes les méthods voulu
		}else{
			return false;
		}
	}
	
	public function read_class(){
	}
	

	public function list_tables($database){
		$SQL  = "SHOW TABLES FROM " . $database;
		foreach($REQ = $this->_PDO->query($SQL) as $count => $tables){
			array_push($this->_ListTables,$tables[0]);
			$this->_NumbersTables ++;
		}
		$REQ->CloseCursor();
	}
	
	private function list_columns(){
		$SQL  = "SHOW COLUMNS FROM ". $this->_Table;
		return $this->_PDO->query($SQL)->fetchAll(PDO::FETCH_OBJ);
	}
	
	public function removePrefix($table){
	
		if (preg_match("/_/i",$table)) {
			$a = explode("_",$table);
			$this->_Table = $a[1];
		}
		return $this->_Table;
	}
	
	private function List_Methods($nameclass)
	{
		$class = new ReflectionClass($nameclass);
		return $methods = $class->getMethods();
	}
	
	private function List_Constants($nameclass)
	{
		$class = new ReflectionClass($nameclass);
		return $class->getConstants();
	}
	
	private function List_properties($nameclass)
	{
		$class = new ReflectionClass($nameclass);
		return $properties = $class->getProperties(ReflectionProperty::IS_PUBLIC);
	}
	
	private function Control_Methods($nameclass,$constante)
	{
		$class = new ReflectionClass($nameclass);
		return $class->hasConstant($constante);
	}
	
	private function Control_Constant($nameclass,$methods)
	{
		$class = new ReflectionClass($nameclass);
		return $class->hasMethod($methods);
	}
	
	private function Control_Property($nameclass,$property)
	{
		$class = new ReflectionClass($nameclass);
		return $class->hasProperty($property);
	}
	// http://php.net/manual/fr/reflectionclass.getdoccomment.php
}
?>