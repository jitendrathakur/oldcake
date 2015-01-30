/*******************************************
// Copyright / Urheber Verweise
// Ersteller:	Rainer Rombach
// Beschreibung: Standardfunktionen f�r Extranet Grosskunden Swisscom		
//
// Referenzen:
//
// History: 17.03.2009: Initial Version
//          27.05.2009: Erg�nzungen flexibler Content 
//			06.07.2009: Neue Funktionen Flyout und Tabellenmen�
//	
*/


// Ein- und Ausklappen von Spalten

function toggleNavigation() {

	

	var widthcontent = 551;
	if( document.getElementById("related-content").style.display == "none" ) widthcontent += 200;

	if( document.getElementById("navigation").style.display == "none" ) {
		document.getElementById("content").style.width = widthcontent + "px";
		document.getElementById("navigation").style.display = "inline";
		document.getElementById("maintopNavigationButton").className = "maintopNavigationButton";
		if( document.getElementById("related-content").style.display == "none" ) {
			document.getElementById("main").className = "mainRight";
			document.getElementById("mainfooter").className = "mainfooterRight";
			parse( document.getElementById("content"), 'flexiblebox flexiblebox-both',  'flexiblebox flexiblebox-right' );		
		}
		else {
			document.getElementById("main").className = "main";
			document.getElementById("mainfooter").className = "mainfooter";
			parse( document.getElementById("content"), 'flexiblebox flexiblebox-left',  'flexiblebox' );
		}
		document.getElementById("maintopNavigationBgLeft").className = "maintopNavigationBgLeft";		
	} 
	else {
		document.getElementById("navigation").style.display = "none";
		widthcontent += 200;
		document.getElementById("content").style.width = widthcontent + "px";
		document.getElementById("maintopNavigationButton").className = "maintopNavigationButtonHidden";
		if( document.getElementById("related-content").style.display == "none" ) {
			document.getElementById("main").className = "mainOpen";
			document.getElementById("mainfooter").className = "mainfooterOpen";
			parse( document.getElementById("content"), 'flexiblebox flexiblebox-right',  'flexiblebox flexiblebox-both' );
		}
		else {
			document.getElementById("main").className = "mainLeft";
			document.getElementById("mainfooter").className = "mainfooterLeft";
			parse( document.getElementById("content"), 'flexiblebox',  'flexiblebox flexiblebox-left' );
		}
		document.getElementById("maintopNavigationBgLeft").className = "maintopNavigationBgLeftSelected";		
	}
	return true;
}

function toggleRelatedContent() {

	var widthcontent = 551;
	if( document.getElementById("navigation").style.display == "none" ) widthcontent += 200;

	if( document.getElementById("related-content").style.display == "none" ) {
		document.getElementById("content").style.width = widthcontent + "px";
		document.getElementById("related-content").style.display = "inline";
		document.getElementById("maintopContentButton").className = "maintopRelatedContentButton";
		if( document.getElementById("navigation").style.display == "none" ) {
			document.getElementById("main").className = "mainLeft";
			document.getElementById("mainfooter").className = "mainfooterLeft";		
			parse( document.getElementById("content"), 'flexiblebox flexiblebox-both',  'flexiblebox flexiblebox-left' );
		}
		else {
			document.getElementById("main").className = "main";
			document.getElementById("mainfooter").className = "mainfooter";
			parse( document.getElementById("content"), 'flexiblebox flexiblebox-right',  'flexiblebox' );
		}
		document.getElementById("maintopRelatedContentBgRight").className = "maintopRelatedContentBgRight";
		
	} 
	else {
		document.getElementById("related-content").style.display = "none";
		widthcontent += 200;
		document.getElementById("content").style.width = widthcontent + "px";
		document.getElementById("maintopContentButton").className = "maintopRelatedContentButtonHidden";
		if( document.getElementById("navigation").style.display == "none" ) {
			document.getElementById("main").className = "mainOpen";
			document.getElementById("mainfooter").className = "mainfooterOpen";
			parse( document.getElementById("content"), 'flexiblebox flexiblebox-left',  'flexiblebox flexiblebox-both' );
		}
		else {
			document.getElementById("main").className = "mainRight";
			document.getElementById("mainfooter").className = "mainfooterRight";
			parse( document.getElementById("content"), 'flexiblebox',  'flexiblebox flexiblebox-right' );
		}
		document.getElementById("maintopRelatedContentBgRight").className = "maintopRelatedContentBgRightSelected";
	}

	return true;
}


// Ein- und Ausklappen von Boxen

function toggleBox(button, element) {

		if( document.getElementById(element + "Content").style.display == "none" ) {
			document.getElementById(element + "Content").style.display = "block";
			button.className = "collapse";
			document.getElementById(element).style.borderBottom = "1px solid #bbbbbb";
			document.getElementById(element).style.paddingBottom = "7px";
		}
		else {
			document.getElementById(element + "Content").style.display = "none";
			button.className = "expand";
			document.getElementById(element).style.borderBottom = "none";
			document.getElementById(element).style.paddingBottom = "0px";		
		}

		return true;
}


// Ein- und Ausklappen von Text

function toggleText(element) {

		if( document.getElementById(element).style.display == "none" ) {
			document.getElementById(element).style.display = "block";
		}
		else {
			document.getElementById(element).style.display = "none";	
		}

		return true;
}


// Toggle der Flexible Box

function toggleFlexibleBox(button, element) {
	if( document.getElementById(element).style.display == "none" ) {
		document.getElementById(element).style.display = "block";
		button.className = "buttonToggleCollapse";		
	}
	else {
		document.getElementById(element).style.display = "none";
		button.className = "buttonToggleExpand";		
	}
	return true;
}


// Toggle der Box

function toggleBox(button, element) {
	if( document.getElementById(element).style.display == "none" ) {
		document.getElementById(element).style.display = "block";
		button.className = "buttonToggleCollapse";		
	}
	else {
		document.getElementById(element).style.display = "none";
		button.className = "buttonToggleExpand";		
	}
	return true;
}

// Toggle Info-Box

function toggleBoxInfo(button, element) {
	if( document.getElementById(element).style.display == "none" ) {
		document.getElementById(element).style.display = "block";
		button.className = "buttonToggleCollapseInfo";		
		
		document.getElementById(element).parentNode.className = "box collapsible-info";
	}
	else {
		document.getElementById(element).style.display = "none";
		button.className = "buttonToggleExpandInfo";	
		
		document.getElementById(element).parentNode.className = "box collapsible-info box-noborder";
	}
	return true;
}


function openPopUp( url ) {
	var popup = window.open( url, "popup", "width=520, height=400, scrollbars=yes");
}

function openPopUpPDF( url ) {
	var pdf = window.open( url, "popup");
}

function openPopUpPrint( url ) {
	var print = window.open( url, "popup");
}


// "global" helper vars and method for Flyout (fade in/out)

var activeElement = null;
var timeout = null;
 
function fadeOutActive() {
        if (activeElement) {
                clearTimeout(timeout);
                timeout = null;
 
                activeElement.fadeOut('fast');
                activeElement = null;                  
        }
}
 
function hideActive() {
        if (activeElement) {
         
                clearTimeout(timeout);
                timeout = null;
 
                activeElement.hide();
                activeElement = null;                  
        }
}

jQuery(document).ready(function($) {

   // Flyout
	jQuery('.info').live( "mouseover", function() {
			hideActive(); //be sure any old menu is closed

			activeElement = jQuery(this).find("div");
			activeElement.show();          
	});

	jQuery('.info').live( "mouseout", function() {
			timeout = setTimeout("fadeOutActive()", 2);
	});

	//Bind table-right hover
	jQuery(".table-right").live( "mouseover", function() {
			jQuery(this).addClass("table-right-over").removeClass("table-right");

			hideActive(); //be sure any old menu is closed
			activeElement = jQuery(this).find("div");
			activeElement.show();
	} );

	jQuery(".table-right-over").live( "mouseout", function() {
			jQuery(this).addClass("table-right").removeClass("table-right-over");

			timeout = setTimeout("fadeOutActive()", 2);
	} );

	// Hover Kalendericon
	jQuery('.datepick-trigger').hover(function() {
		jQuery('.datepick-trigger').attr('src', '../../images/assets/icons/16px/048_calendar_02_cmyk.gif' );
	}, function() {
		jQuery('.datepick-trigger').attr('src', '../../images/assets/icons/16px/048_calendar_06_cmyk.gif' );
	});
	
	// Ein- und Ausblenden Tabelle mit Slideeffekt
	jQuery('#bt2').click( function () {
		jQuery('#bn2').slideToggle(250);    
	});		 
	
				
});


// Rollovereffekte Buttons


// Ohne Pfeil

function hoverButton(elem) {
	elem.parentNode.className = "button-hover";
}

function outButton(elem) {
	elem.parentNode.className = "button";
}


// Pfeil rechts

function hoverButtonRight(elem) {
	elem.parentNode.className = "button-right-hover";
}

function outButtonRight(elem) {
	elem.parentNode.className = "button-right";
}


// Pfeil links

function hoverButtonLeft(elem) {
	elem.parentNode.className = "button-left-hover";
}

function outButtonLeft(elem) {
	elem.parentNode.className = "button-left";
}


// Pfeil rechts auf grauem Hintergrund

function hoverButtonRightGrey(elem) {
	elem.parentNode.className = "button-right-grey-hover";
}

function outButtonRightGrey(elem) {
	elem.parentNode.className = "button-right-grey";
}


// Hilfsfunktionen

function parse(ele,arg1,arg2) {
	var elem = ele.childNodes;
	for(var i=0; i<elem.length; i++) {
		if(elem[i].nodeName == "DIV" && elem[i].className == arg1) {
			elem[i].className = arg2;
		}
		parse(elem[i],arg1,arg2);
	}
}	





