<?php
/**
 *
 * Copyright (c) 2015-Present, mandalorien
 * All rights reserved.
 *
 * create 2015 by mandalorien
 */

class Database extends DatabaseConnection
{
	static function Create_Table($bdd,$database,$table)
	{
		$SQL  = "SHOW TABLES FROM " . $database;
		foreach  ($bdd->query($SQL) as $row) {
			$ListTable[] = $row[0];
		}
		unset($SQL);
		
		if(!in_array($table['name'],$ListTable))
		{ 
			$firstChamp = null;
			$compteur = 1;
			$SQL  = "CREATE TABLE IF NOT EXISTS `".$table['name']."` ( \n";
			foreach($table as $champs)
			{
				if(isset($champs['name']))
				{
					if($compteur == 1)
					{
						$firstChamp = $champs['name'];
						$SQL .= "`".$champs['name']."` ".$champs['type']." NOT NULL AUTO_INCREMENT, \n";
					}
					else
					{
						$SQL .= "`".$champs['name']."` ".$champs['type'].", \n";
					}
					
					
					$compteur ++;
				}
			}
			$SQL .= "PRIMARY KEY (`".$firstChamp."`) \n";
			$SQL .= ") ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;";
			$bdd->query($SQL);
		}
	}
	
	static function Read_Classe($bdd,$database,$table)
	{
		$tableauFinal = array();
		$tableauNom = array();
		$tableauType = array();
		$filename = CLASSE_ORIGIN . DIRECTORY_SEPARATOR . $table .".Class.php";
		$handle = fopen($filename, "r");
		$contents = fread($handle, filesize($filename));
		
		$search = explode("** PARAM **",$contents);
		$infoClasse = Classes::List_Constants($table);
		
		foreach(Classes::List_Constants($table) as $Const=>$fieldalias)
		{
			if($Const != "TABLE")
			{
				$tableauNom[] = $fieldalias;
			}
			else
			{
				$tableauFinal['name'] = $fieldalias;
			}
		}
		
		for($i = 1;$i<= (count(Classes::List_Constants($table)) - 1);$i++)
		{
			$find = explode("**********/",$search[$i]);
			$result = explode(": ",$find[0]);
			$tableauType[] = rtrim($result[1]);
		}
		
		foreach($tableauNom as $keys=>$noms)
		{
			$tableauFinal[] = array(
			"name"=>$tableauNom[$keys],
			"type"=>$tableauType[$keys]
			);
		}
		self::Create_Table($bdd,$tableauFinal);
		fclose($handle);

	}
}
$Database = new Database();
?>