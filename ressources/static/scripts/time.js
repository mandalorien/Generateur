/**
 *
 * Copyright (c) 2015-Present, mandalorien
 * All rights reserved.
 *
 * create 2015 by mandalorien
 */
$( document ).ready(function()
{
	if (!!window.EventSource) {
		var timer = new EventSource(getBaseURL() + "/Ajax/time.php");                   
			timer.addEventListener('majdateheure', function(e) {
			var data = JSON.parse(e.data);
			document.getElementById('dateheure').innerHTML = data.msg;
		}, false);
	}
});