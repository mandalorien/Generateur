/**
 *
 * Copyright (c) 2015-Present, mandalorien
 * All rights reserved.
 *
 * create 2015 by mandalorien
 */
function connexion()
{
	var imgTestInternet = new Image();
	imgTestInternet.onload = function()
	{
		return true;
	};
	imgTestInternet.onerror = function()
	{
		return false;
	};
	imgTestInternet.src = "http://www.google.fr/images/srpr/nav_logo13.png";
};