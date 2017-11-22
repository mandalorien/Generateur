<?php
header('Content-Type: application/json');
require_once(dirname(dirname(__FILE__)) . DIRECTORY_SEPARATOR . 'constant.php');

require_once(ROOT_PATH .'librairy/class.tools.php');# outils diverse
require_once(ROOT_PATH .'librairy/class.template.php');# Base de donnee
require_once(ROOT_PATH .'librairy/class.form.php');# Base de donnee
require_once(ROOT_PATH .'librairy/class.pdo_connect.php');# Base de donnee
require_once(ROOT_PATH .'librairy/class.model_class.php');# Gestion de création des classes ou de la BDD si les classes existe !

$template = new Template();
$form = new Form($template);

$response = array();
$errors = null;
$text = null;

if(isset($_POST['host']) && isset($_POST['user']) && isset($_POST['pass']) && isset($_POST['database']) && isset($_POST['prefix'])){
	if(!empty($_POST['host']) && !empty($_POST['user']) && !empty($_POST['database'])){
		
		$PDO  = new DatabaseConnection($_POST['host'],$_POST['user'],$_POST['pass'],$_POST['database']);
		if($PDO->Connexion() !== false){
			$GENERATE = new Classes($PDO->Connexion());
			
			if (!empty($_POST['prefix'])) {
				$GENERATE->set_Prefix($_POST['prefix']);
			}
			
			$GENERATE->list_tables($PDO->Get_Database());
			foreach($GENERATE->get_listTables() as $Tables){
				
				$GENERATE->set_Table($Tables);
				$GENERATE->write_class($PDO->Get_Database(),true,true);
				$text .= $GENERATE->removePrefix($Tables) ." <br>";
			}
			$response['errors'] = 0;
			$response['message'] = $form->Message("Connexion à la base de donnée","connexion reussite et Génération des (".$GENERATE->get_NumbersTables().") tables :<br><span class='text-left'><code>".$text."</code></span>",Form::MESS_SUCCESS);
			$response['tables_send'] = null;
		}else{
			$response['errors'] = 1;
			$response['message'] = $form->Message("Connexion à la base de donnée","connexion échoué : <br>". $PDO->Message() ,Form::MESS_WARNING);
			$response['tables_send'] = null;
		}
	}else{
		$response['errors'] = 1;
		if(empty($_POST['host'])){ $errors .= "le champ <code>HOST</code> ,";}
		if(empty($_POST['user'])){ $errors .= "le champ <code>USER</code> ,";}
		if(empty($_POST['database'])){ $errors .= "le champ <code>DATABASE</code> ,";}
		$errors = substr($errors,0,-1);
		$response['message'] = $form->AlertMessage("Manque d'information","Veuillez saisir " .$errors .".",Form::ALERT_ALERT);
		$response['tables_send'] = null;
	}
}else{
	$response['errors'] = 1;
	$response['message'] = $form->AlertMessage("titre","message",Form::ALERT_ALERT);
	$response['tables_send'] = null;
}
echo json_encode($response);
?>