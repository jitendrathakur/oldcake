
//var dest_url			=	'http://selfcare.rainconcert.in/stations/confirm_change';	 
//var dest_url			=	'http://192.168.0.170/selfcare/stations/confirm_change';
function show_hide (id){
	
	if(document.getElementById('hide').value==0){
		document.getElementById('config_'+id).style.display='block';
		document.getElementById('hide').value=1;
	}else{
		document.getElementById('config_'+id).style.display='none';
		document.getElementById('hide').value=0;
	}
}
function all_show_hide (id){
	
	if(document.getElementById('hide').value==0){
		$('.'+id).toggleClass('class').show();
		document.getElementById('hide').value=1;
		
		if($('#show_link_hide_'+id).val()==0){
			
			$('#btn_all').removeClass('expandButtonHidden');
			$('#btn_all').addClass('expandButton');
		}else{
			$('#btn_all').removeClass('expandButton');
			$('#btn_all').addClass('expandButtonHidden');
		}
		show_exp_link('1');
		
	}else{
		$('#btn_all').removeClass('expandButtonHidden');
		$('#btn_all').addClass('expandButton');
		$('.'+id).toggleClass('class').hide();
		document.getElementById('hide').value=0;
		show_exp_link('1');
	}
}


function clearValuetxt(id_tx){
	$('#'+id_tx).attr("value","");

}
function clearValuetxt_all(id_tx,id_label,id_select){
	$('#'+id_tx).attr("value","");
	$('#'+id_label).attr("value","");
	
	var select_box	=	$('#'+id_select+' :selected').val();
	if(!select_box){
		$('#div_'+id_tx).hide();
		$('#div1_'+id_tx).hide();
	}
	else{
		$('#div_'+id_tx).show();
		$('#div1_'+id_tx).show();
	}

}
function show_exp_link (id){
	
	var extension	=$('#show_link_extension').val();
	
	if($('#show_link_hide_'+id).val()==0){
		 $('#show_expansion_'+id).show();
		$('#show_link_hide_'+id).attr("value","1");
		//$('#btn_'+id).removeClass('expandButton');
		//$('#btn_'+id).addClass('expandButtonHidden');
		
		for(i=id;i<=extension;i++){
			$('#show_expansion_'+i).show();
			$('#show_link_hide_'+i).attr("value","1");
			//$('#btn_'+i).removeClass('expandButton');
			//$('#btn_'+i).addClass('expandButtonHidden');
		}

	}else{
		 $('#show_expansion_'+id).hide();
		 for(i=id;i<=extension;i++){
		 	$('#show_expansion_'+i).hide();
		 }
		 
		$('#show_link_hide_'+id).attr("value","0");		
		//$('#btn_'+id).removeClass('expandButtonHidden');
		//$('#btn_'+id).addClass('expandButton');
	}
}

$('form').submit(function() {
  //alert($('StationEditForm').serialize());
  return false;
});




function validate_form (){
	var error			= 0;
	var err_string		= '';
	$('#StationEditForm input.numeric_check[type=text]').each(function(n,element){ 
	
		var  sel		=	'sel_'+element.id;
     	var select_box	=	$('#'+sel+' :selected').val();
     	if(select_box=='AUD' || select_box=='BLF')
			var text_input	=	trim($(element).val());
	    var key 		=	$('#key_'+element.id).val();
	    if(select_box=='AUD' || select_box=='BLF'){
	    	var number_id	=	element.id;
	    	var label_id	=	number_id.substring(10,number_id.length);
	    	var label		=	trim($('#input_label_'+label_id).val());
	    }

	    
		if(select_box=='BLF'){
				
			
			if(select_box  && text_input==''){
				
				err_string	+=	UTF8.decode(msg_lang['Please input a value for the'])+select_box+UTF8.decode(msg_lang['in key'])+key+"<br>";
				
				error=1;
			}else if(text_input!='' && select_box==''){
				err_string	+=	UTF8.decode(msg_lang['Please select a value for input text value'])+text_input+UTF8.decode(msg_lang['in key'])+key+"<br>";
		
				error=1;
			}else if(text_input && (text_input.length!=9)){
				err_string	+=	UTF8.decode(msg_lang['BLF Supports 9 digits (0-9) only for'])+key+"<br>";
				
				error=1;
			}
			if(label!=''){
				if((label.length>10)){
					err_string	+=	UTF8.decode(msg_lang['maximum 10 digits for label'])+key+"<br>";
					error=1;
				}
			}
		}
		if(select_box=='AUD'){
			if(text_input && (text_input.length<2 || text_input.length>15)){
				err_string	+=	UTF8.decode(msg_lang['digits only (0-9) between 2 and 15 digits for'])+key+"<br>";
					//alert('Please enter a number of length ranges from 7 to 9');
				error=1;
			}if(label!=''){
				if((label.length>10)){
					err_string	+=	UTF8.decode(msg_lang['maximum 10 digits for label'])+key+"<br>";
					error=1;
				}
			}
		}
		
	
	});
	
	$('#StationEditForm input.display[type=text]').each(function(n,element){ 
		
		var display			=	trim($(element).val());
		var key1			=	'key'+element.id;
		var key_display 	=	$('#'+key1).val();
		if(display!=''){
			if((display.length>12)){
					err_string	+=	UTF8.decode(msg_lang['maximum 10 digits for Display'])+key_display+"<br>";
					error=1;
			}else{
				if(!isSplChar(display)){
					err_string	+=	UTF8.decode(msg_lang['Special charcters not allowed  for Display'])+key_display+"<br>";
					error=1;
				}
			}
		}
	}
	);
	if($('#password_type').val()!='ANLG'){
		var password	=	$('#password').val();
		
			if(password.length<3 || password.length>12){
				
				err_string	+=	UTF8.decode(msg_lang['Password must have greater than 3 digits and less than 12 digits']);
				error=1;
			}
		
	}
  	if(error){
  		$.fn.colorbox({overlayClose:false,opacity:'0.3',inline:true,width:'600px',height:'280px', href:"#upload_photo",oncloseprocess:'location.href=location.href'});
		$("#error_report_js").html(err_string).show();
         return false;
  	}
	var dest_url			=	base_url+'stations/confirm_change';		
	
	var data 	=	$('#StationEditForm').serialize();
	$.ajax({
	  type: 'POST',
	  url: dest_url,
	  data: data,
	  success: success
	});
}



/*Check for a special character'***/
function isSplCharOrig(str)
{	
	var spchar, getChar, SpecialChar;	
	spchar="`()(\\~!@^&*+\"|%:=,<>";
	getChar='Empty';
	SpecialChar='No';
	var spchars =" ` ( )  \\ ~ ! @ ^ & * + \" | : =  , < > "; 
	for(var i=0; i<str.length;i++)
	{
		for(var j=0; j<spchar.length;j++)
		{			
			if(str.charAt(i)== spchar.charAt(j))
			{			
				SpecialChar='Yes';
				break;
			}
			else
			{
				if (str.charAt(i)!=' ')
				getChar='Normal';
			}
		}		
	}
	if (SpecialChar == 'Yes')
	{
			
		return false;
	}
	else if (SpecialChar == 'No')
	{
		return true;
	}
}

/*Check for a special character'***/
function isSplChar(str)
{	
	var spchar, getChar, SpecialChar;	
	spchar ="AaBbCcDdEeFfGgHhIiJjKkLlMmNnOoPpQqRrSsTtUuVvWwXxYyZz0123456789_"; 
	getChar='Empty';
	SpecialChar='No';
	for(var i=0; i<str.length;i++)
	{
		for(var j=0; j<spchar.length;j++)
		{			
			if(str.charAt(i)== spchar.charAt(j))
			{			
					SpecialChar='No';
					break;
			}
			else
			{
				SpecialChar='Yes';
			}
		}		
		if (SpecialChar == 'Yes')
		{
			break;
		}
	}
	if (SpecialChar == 'Yes')
	{
		return false;
	}
	else if (SpecialChar == 'No')
	{
		return true;
	}
}

function trim(str) {
	if(str!='')
		return str.replace(/^\s*|\s*$|\n|\r/g,"");
	else
		return '';
}


function success(retStr){
	$.colorbox({html:retStr});	
}
function validate_cancel(){
	$.fn.colorbox.close();
	return false;
}
function validate_submit(){
	 $('.hide_button').hide();
	 $('#spinner').show();
	$('#StationEditForm').submit();
}
$(document).ready(function(){
    //called when key is pressed in textbox
	$(".numeric_check").keypress(function (e)  
	{ 
	  //if the letter is not digit then display error and don't type anything
	  if( e.which!=8 && e.which!=0 && (e.which<48 || e.which>57))
	  {
		//display error message
		//$("#errmsg").html("Digits Only").show().fadeOut("slow"); 
	    return false;
      }	
	});

	
	$('.space_check').keypress(function(e){
		
		if(e.which==32)
		  {
			//display error message
			//$("#errmsg").html("Digits Only").show().fadeOut("slow"); 
		    return false;
	      }	
		
	});
	
	
	
	$('#st_profile_photo').click(function(){
		$('#upload_status').html('');
		$('#file').val('');
		
		$.fn.colorbox({overlayClose:false,opacity:.3,inline:true,width:'600px',height:'380px', href:"#upload_photo",oncloseprocess:'location.href=location.href'});
	});
	$('#upload_student_photo').click(function(){
		$('#form').submit();
    	//$('#upload_status').html("uploading file...");
    	$("#upload_button").hide();
    	$('#upload_status').html( UTF8.decode(msg_lang['uploading file']));
    	return true;
	});
$('.onclick').keydown(function(e){
		if(e.which==13){
			$('#filters').submit();
		}
	});	
	

	
  });
  
 function change_record(){
 	$('#filters').submit();
 }
 function logview (id){
 	var dest_url			=	base_url+'stations/logdetails/'+id;	
 	$.fn.colorbox({
				href:dest_url,
				transition:'fade',
				overlayClose:false, 
				speed:350,width:600,height:550,
				onClosed:$.fn.colorbox.init()})	
				return false;
 }
 function submi_form (form_id){	
 	$('#'+form_id).submit();
 	
 } 
 function submi_reset (page){
 	var dest_url			=	base_url+page;
 	window.location			=	dest_url;
 	
 }
 
 function blfList (name,id){
 	var dest_url			=	base_url+'stations/ajax_blf_list';	
 	//$('#hid_blf').attr("value",id);
 	
 	document.getElementById('hid_blf').value=id;
 	
 	var val	=document.getElementById('show_'+id).value;
 	
 	if(val==0){
		//$('#show_'+id).attr("value",1);
		document.getElementById('show_'+id).value=id;
		
 	}
	else{
		//$('#show_'+id).attr("value",0);
		document.getElementById('show_'+id).value=0;
		//$("#list_blf_"+id).hide();
		//$("#list_blf_"+id).hide();
		document.getElementById('list_blf_'+id).style.display='none';
		return false;
	}
		
 	//$('#hid_blf').attr("value",id);
 	
	$.ajax({
	  type: 'POST',
	  url: dest_url,
	  data: 'data='+name,
	  success: successListBlf
	 
	});
 }
function successListBlf (retStr){
	//name	=	$('#hid_blf').val();
	name	=	document.getElementById('hid_blf').value;

	//$("#list_blf_"+name).html(retStr).show();
	document.getElementById("list_blf_"+name).innerHTML=retStr;
	document.getElementById("list_blf_"+name).style.display='block';
}
function show_main(){
	if($("#show_main_val").val()==0){
		$("#show_main").show();
		$('#show_main_val').attr("value",1);
	}
	else{
		$("#show_main").hide();
		$('#show_main_val').attr("value",0);
	}
}
function showImage (id){
	//id=	$('#station_type :selected').val();
	$("#"+id+"_image").show();
		if(id==1120){
			
			$.fn.colorbox({overlayClose:false,opacity:.3,inline:true,width:'550px',height:'460px', href:"#"+id+"_image",oncloseprocess:'location.href=location.href'});
		}else{
			
			$.fn.colorbox({overlayClose:false,opacity:.3,inline:true,width:'550px',height:'460px', href:"#"+id+"_image",oncloseprocess:'location.href=location.href'});
	
		}
	}
	
	function upload_xml(){
		var msg			=	"Are you sure that you want to perform an upload?";
		
		var station_id	=	$('#stationname').val();
		
		if(confirm(msg)){
	 			window.location			= base_url+'stations/upload_xml/'+station_id;
 		}else{
			return false;
		}
		
	}
function clearMe(formfield){
  if (formfield.defaultValue==formfield.value)
   formfield.value = ""
 }

