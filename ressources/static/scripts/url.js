/**
 *
 * Copyright (c) 2015-Present, mandalorien
 * All rights reserved.
 *
 * create 2015 by mandalorien
 */
function getBaseURL()
{
    var url = location.href;
	var cpt = 0;
    var baseURL = url.substring(0, url.indexOf('/', 14)); 
 
	if (baseURL.indexOf('http://localhost') != -1) {
			var pathname = location.pathname;
			var index1 = url.indexOf(pathname);
			var index2 = url.indexOf("/", index1 + 1);
			var baseLocalUrl = url.substr(0, index2);
			var existence = pathname.split("/");
			for(var i = 1;i<=existence.length;i++)
			{
				if(existence[i] != '' && typeof existence[i]!="undefined")
				{
					cpt ++;
				}
			}
			if(cpt >= 2){
				return url.substr(0,url.length - 1);
			}else{
				return baseLocalUrl;
			}
			
	}
	else 
	{
			var pathname = location.pathname;
			var index1 = url.indexOf(pathname);
			var index2 = url.indexOf("/", index1 + 1);
			var baseLocalUrl = url.substr(0, index2);

		return baseURL;
	}
};