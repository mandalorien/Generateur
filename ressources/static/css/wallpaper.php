<?php
/**
 * This file is part of Legacies
 *
 * @license none
 *
 * Copyright (c) 2015-Present, mandalorien
 * All rights reserved.
 *
 * create 2015 by mandalorien
 */
require_once dirname(dirname(dirname(dirname(__FILE__)))) .'/Core/core.php';
header("Content-type: text/css");
?>
body { 
<?php
if(!is_null($user))
{
	if(isset($_GET['user'])) # si c'est un autres profil utilisateur
	{
		$token = $_GET['user'];
		$OthersUsers = new Game_users_extends();
		if($OthersUsers->SeletedOtherToken($token))
		{
			$ProfilOtherUser = new Game_profil();
			$ProfilOtherUser->Seleted($OthersUsers->Get_Id());
			
			$wallpaper = $ProfilOtherUser->Get_Wallpaper();
		}
		else
		{
			$wallpaper = $ProfilUser->Get_Wallpaper();
		}
	}
	else
	{
		$wallpaper = $ProfilUser->Get_Wallpaper();
	}
?>
background:url('<?=$wallpaper;?>');
<?php
}
?>
background-attachment : fixed!important;
background-repeat:repeat-y!important;
-webkit-background-size: cover!important; /* Pour Chrome et Safari */
-moz-background-size: cover!important; /* Pour Firefox */
-o-background-size: cover!important; /* Pour Opera */
background-size: cover!important; /* version standardisée */
}
