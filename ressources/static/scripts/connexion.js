/**
 *
 * Copyright (c) 2015-Present, mandalorien
 * All rights reserved.
 *
 * create 2015 by mandalorien
 */
$(document).ready(function()
{
	$('#canvasloader-container').hide();
	var cl = new CanvasLoader('canvasloader-container');
		cl.setColor('#2970db'); /* default is '#000000' */
		cl.setShape('sqare'); /* default is 'oval' */
		cl.setDiameter(67); /* default is 40 */
		cl.setDensity(20); /* default is 40 */
		cl.setRange(1); /* default is 1.3 */
		cl.setSpeed(1); /* default is 2 */
		cl.setFPS(25); /* default is 24 */
		cl.show(); /* Hidden by default */
	
	$("#connect_reset").click(function()
	{
		$('#canvasloader-container').hide();
	});
	
	
	$("#connect_go").click(function()
	{
			$("#message").hide();
			var host = $("#inputHost").val();
			var user = $("#inputUser").val();
			var pass = $("#inputPassword").val();
			var database = $("#inputBdd").val();
			var prefix = $("#inputPrefix").val();
			$('#canvasloader-container').show();
			
			$.post(getBaseURL()+"/ajax/index.php", { host: host, user: user, pass: pass, database: database, prefix: prefix}, function( data) {
					$('#canvasloader-container').show();
			})
			.done(function( data )
			{
				$('#canvasloader-container').show();
				if(data.errors != 0)
				{
					$('#canvasloader-container').hide();
					$("#message").show();
					$("#message").html(data.message);
				}
				else
				{
					$('#canvasloader-container').hide();
					$("#message").show();
					$("#message").html(data.message);
				}
			})
			.fail(function() {
				$('#canvasloader-container').show();
				console.log( "error" );
			});
	});
});