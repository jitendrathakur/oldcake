/*******************************************
// Copyright / Urheber Verweise
// Ersteller:	Rainer Rombach
// Beschreibung:		
//
// Referenzen:
//
// History: 13.01.2009: Initial Version
//			27.05.2009: 
*/


function hoverRow(tr, status) {
	(status)?tr.style.backgroundColor="#dddddd":tr.style.backgroundColor="transparent";
	return true;
}


// Popup-Menue Tabelle

var obj = null;

function checkHover() {
	if (obj) {
		obj.find('div').fadeOut('fast');	
	}
}

jQuery(document).ready(function($) {
	
	$('.table-menu').hover(function() {
		if (obj) {
			obj.find('div').fadeOut('fast');
			obj = null;
		}
		
		$(this).find('div').fadeIn('fast');
	}, function() {
		obj = $(this);
		setTimeout(
			"checkHover()",
			1);
	});
						
	$('#myTable-toggle').click( function () {	
		if( $('#myTable').is(':hidden') ) {
			$('#myTable').slideDown(500); 
			$('#myTable-toggle').attr( 'src', '../../images/assets/btn-collapse.gif');
		}
		else {
			$('#myTable').slideUp(500); 
			$('#myTable-toggle').attr( 'src', '../../images/assets/btn-expand.gif');
		}
    });		
 
	$('#myTable-toggle2').click( function () {	
		if( $('#myTable2').is(':hidden') ) {
			$('#myTable2').slideDown(500); 
			$('#myTable-toggle2').attr( 'src', '../../images/assets/btn-collapse.gif');
		}
		else {
			$('#myTable2').slideUp(500); 
			$('#myTable-toggle2').attr( 'src', '../../images/assets/btn-expand.gif');
		}
    });	
 
});

