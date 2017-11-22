<?php

class Template
{
	const TEMPLATE_NAME = 'default';
	const EXTENSION_TEMPLATE = '.html';
	private $_Filename;			// type string
	private $_PhpVersion;		// type floatval
	private $_Parse;			// type array
	private $_Ajax = false;		// type boolean
	private $_TemplateDir;		// type dir for theme
	

	public function __construct(){
		$this->_PhpVersion = floatval(phpversion());
		$this->_TemplateDir = VUES .'/template';
	}
	
	private function ReadFromFile($root) {
		$content = @file_get_contents($root . $this->_Filename . self::EXTENSION_TEMPLATE);
		return $content;
	}

	private function gettemplate() {

		$root = $this->_TemplateDir . DIRECTORY_SEPARATOR . self::TEMPLATE_NAME . DIRECTORY_SEPARATOR;
		if($this->_Ajax){
			$newscript = preg_replace('/\s\s+/', '',$this->ReadFromFile($root));
			$newscript = preg_replace('/\n/', '', $newscript);
			return $newscript;
		}
		else{
			return $this->ReadFromFile($root);
		}
	}

	private function parsetemplate($template, $array){
		if($this->_PhpVersion <= 5.3){
			return preg_replace(
			'#\{([a-z0-9\-_]*?)\}#Ssie',
			'( ( isset($array[\'\1\']) ) ? $array[\'\1\'] : \'\' );',
			$template);
		}
		else
		{
			return preg_replace_callback(
						"#\{([a-z0-9\-_]*?)\}#Ssi",
						function ($m) use ($array) { return $array[$m[1]]; } , 
						$template);
		}
	}
	
	public function displaytemplate($f,$p,$a = false)
	{
		$this->_Filename = $f;
		$this->_Parse = $p;
		$this->_Ajax = $a;
		return $this->parsetemplate($this->gettemplate(),$this->_Parse);
	}
}