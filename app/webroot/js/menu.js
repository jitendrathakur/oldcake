/*******************************************************************************
 * PROJECT : Swisscom/Linkmanager
 * 
 * $Id: menu.js 19644 2009-08-10 08:37:08Z lust $
 ******************************************************************************/

// Holt das Menu des Benutzers beim Linkmanager
// User ist schon bekannt, da der Linkmanager auch unter SSO laeuft
// Die Applikation muss folgende Angaben liefern:
// - eserviceMenuDiv: Das DIV, unter welchem das eService Menu zu finden ist
// - resource: Damit die richtige Stelle ausgespart werden kann


function buildMenu(lang, renderSelected, resource) {
	var strUrl = 'https://'+window.location.host+'/linkmanager/navigation.jsf?res='+resource+'&lang='+lang+'&renderSelected='+renderSelected;
	buildMenuUrl(lang, renderSelected, resource, strUrl);
}
function buildMenuNok(lang, renderSelected, resource) {
	var strUrl = 'https://'+window.location.host+'/linkmanager/navigation-gehtnicht.jsf?res='+resource+'&lang='+lang+'&renderSelected='+renderSelected;
	buildMenuUrl(lang, renderSelected, resource, strUrl);
}

function buildMenuUrl(lang, renderSelected, resource, strUrl) {
	var menuDivCut = "navigation";
	var http_request = false;
	
	var storageKey = "";
	
	/*if(getCookie('managedBsk') != null && getCookie('managedBsk').indexOf(';') > 0){
		storageKey = resource.toLowerCase()+'_'+lang.toLowerCase()+'_'+getCookie('bl').toLowerCase()+'_'+getCookie('managedBsk').split(';')[0];
	}else{
		storageKey = resource.toLowerCase()+'_'+lang.toLowerCase()+'_'+getCookie('bl').toLowerCase();
	}*/
	
	if(localStorage != null || localStorage.getItem(storageKey) == null){
	
		if (window.XMLHttpRequest) { // Mozilla, Safari,...
		 http_request = new XMLHttpRequest();
		 if (http_request.overrideMimeType) {
			// set type accordingly to anticipated content type
			//http_request.overrideMimeType('text/xml');
			http_request.overrideMimeType('text/html');
		 }
		} else if (window.ActiveXObject) { // IE
		 try {
			http_request = new ActiveXObject("Msxml2.XMLHTTP");
		 } catch (e) {
			try {
			   http_request = new ActiveXObject("Microsoft.XMLHTTP");
			} catch (e) {}
		 }
		}
		if (!http_request) {
		 return false;
		}      

		// Lesen der Navigation vom Linkmanager
		try {
		http_request.open('GET', strUrl, true);
		http_request.onreadystatechange = function() {
			if (http_request.readyState == 4) {
				if (http_request.status == 200 || http_request.status == 0) {
					if(http_request.responseText != null && http_request.responseText != ""){
						buildMenuDoIt(http_request.responseText, menuDivCut);
						localStorage.setItem(storageKey, JSON.stringify({result: http_request.responseText, date: new Date().getTime()}));
					}
					
				}
			}         
		}
		} catch (e) {
		// Konnte das Menu nicht lesen
		}

		// Default Navigation aufbauen
		buildMenuDoIt(getDefaultMenu(), menuDivCut);
		try{
		http_request.send(null);
		} catch (e){
		}
	}
	else{
		//alert("im else Cache");
		buildMenuDoIt(JSON.parse(localStorage.getItem(storageKey)).result, menuDivCut);
	}
	
	//setTimeout(removeOldEntries(), 100);
}

// Merge der Navigation
function buildMenuDoIt(str, menuCut, bWithUl){	
	
	var menuPaste = 'eServiceMenu';
	// Pruefen, ob eService spez. Tag vorhanden
	var eServiceElement = document.getElementById(menuPaste);
	if (eServiceElement == null) {
		//Pruefen, ob Defaultmenu da
		eServiceElement = document.getElementById("eServiceMenu");
	}
	
	if (eServiceElement != null && str != null) {
    	var eServiceMenu = eServiceElement.innerHTML;
    	
    	// Menu mit globalem (LM) Menu ersetzen
    	var start = str.indexOf('<div id="generatedMenu">');
    	var ende = str.lastIndexOf('</div>');
   		if(start != -1 && ende != -1){
   			var fullMenu = str.substring(start + 24	, ende);
    		document.getElementById(menuCut).innerHTML = fullMenu;
    		// eService Menu wieder reinkopieren
    		if(document.getElementById("eServiceMenu") != null){
				document.getElementById("eServiceMenu").innerHTML = eServiceMenu;
			}
    	}
    	//alert(document.getElementById(menuCut).innerHTML);
    }
}

// Erstellen der Defaultnavigation, falls der Linkamanger nicht verfuegbar ist
function getDefaultMenu() {
     var menu = '<div id="generatedMenu"><ul><li><a href="https://extranet.swisscom.ch/portal/index.htm" class="top link start">Home Extranet</a></li><li><ul id="eServiceMenu"></ul></li></ul></div>';     
     return menu;
}

function getCookie(c_name){
	var c_value = document.cookie;
	var c_start = c_value.indexOf(" " + c_name + "=");
	if (c_start == -1){
		c_start = c_value.indexOf(c_name + "=");
	}
	if (c_start == -1){
		c_value = null;
	}else{
		c_start = c_value.indexOf("=", c_start) + 1;
		var c_end = c_value.indexOf(";", c_start);
		if (c_end == -1){
			c_end = c_value.length;
		}
		c_value = unescape(c_value.substring(c_start,c_end));
	}
	return c_value;
}

function removeOldEntries(){
	var dateToday = new Date();
	for (i=0; i<=localStorage.length-1; i++)  
    {   
        var key = localStorage.key(i);
        var date = parseInt(JSON.parse(localStorage.getItem(key)).date);
		if((dateToday.getTime() - date) > (24*3600*1000)){
			localStorage.removeItem(key);
		}
    }  
}

