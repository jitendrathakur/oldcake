<?php $scenarioStatus = Configure :: read('scenarioStatus'); 
?>
<?php

echo $javascript->link('/js/jquery.fancybox');
#echo $javascript->link('/js/modalPopLite1');
#echo $html->css('modalPopLite');
echo $this->element('editable');

$ScenarioStatus = $scenarioDetails[0]['Scenario']['status'];
$PerformDisable = 0;
if ($ScenarioStatus == 5 || $ScenarioStatus == 6 || $ScenarioStatus == 7) {
    $readonlytextbox = "readonly='true'";
    $PerformDisable = 1;
    $class = "button-left-readonly";
} else {
    $readonlytextbox = '';
    $class = "button-left";
}

 $odscount = count($odsEntryList);

?>
<style type="text/css">
/* CSS for modelpopup */
		     
		#clicker	{	cursor:pointer;	}
		
		#popup-wrapper		{
			width:390px;
			height:auto;
			background-color:#F9F9F9;
			padding:10px;		
		}
		#clicker2	{ cursor:pointer;}
		#popup-wrapper2
		{
			width:390px;
			height:auto;
			background-color:#F9F9F9;
			padding:10px;
		
		}
		#clicker3
		{
			
			cursor:pointer;
		}
		#popup-wrapper3
		{
			width:390px;
			height:auto;
			background-color:#F9F9F9;
			padding:10px;
		
		}
		#clicker4
		{	
			cursor:pointer;
		}
		#popup-wrapper4
		{
			width:390px;
			height:auto;
			background-color:#F9F9F9;
			padding:10px;
		
		}
		body
		{
		    padding:10px;
		}
		td { white-space: nowrap; }
.demonstrations1 div {
  float: right;
  width: 20px;
  height: 30px;
  margin: -19px 0 5px!important;
  cursor: pointer;
  font-size: 15px;
  font-weight: bold;
}
.black_overlaysaveOdsentry {
    background-color: #000000;
    height: 100%;
    left: 0;
    opacity: 0.5;
    position: absolute;
    top: 0;
    z-index: 1001;
}		
span a {
 color: #0088cc;
    margin-left: 5px;
    text-decoration: none;
}
.table-content td {
    border: 1px solid #cccccc !important;
    padding: 1px 0 1px 2px !important;
}
	table, td, tr {
    color: #555555;
    font-size: 11px !important;
    font-weight: normal;
    text-align: left;
}
	#myTable7_filter input{
		float:none;
		display: none !important;
	}
    div #myTable7_filter{
		float:none;
		display: none !important;
	}
	#myTable7_length label{
		 margin-bottom: 8px !important;
	}

	#myTable7_processing{
		display: none !important;
	}
	
	.tablesorter-filter-row78 td {
		background: none repeat scroll 0 0 #eee;
		line-height: normal;
		padding: 4px 6px;
		text-align: center;
		transition: line-height 0.1s ease 0s;
		vertical-align: middle;
	}
	
	.customclass{
		border: 1px solid #cccccc;
		display: block;
		float: right;
		height: 24px !important;;
		margin-right: 238px !important;
		margin-top: 0;
		padding: 0;
		width: 139px !important;;
	}
    .tablesorter-filter
    {
        width:100% !important;
		margin: 0 -2px !important;
        padding: 4px 1px !important;
    }
	
	
	#fancybox-loading{
	
		background-repeat: no-repeat !important;
		left: 522px  !important;
		margin-right: 1000px  !important;
		position: absolute  !important;
		
		top: 50%  !important;
		display:none;
	}
	
	.black_overlay_update{	
		background: url("../../images/fancybox_overlay.png") repeat scroll 0 0 rgba(0, 0, 0, 0) !important;
		display: block;
		height: 440px;
		left: 240px;
		position: absolute;
		top: 368px;
		width: 41%;
	}
	
  /*  .space_check
    {
        width:91%;
        height:auto !important;
        margin-bottom:0 !important;
    }*/
    .table th, .table td
    {
        padding: 1px 6px;  
        border:none;
    }
    .tablesorter-bootstrap .tablesorter-pager select
    {
        width:64px;
        margin:0 20px;
    }
    .table-top th, .table-right-ohne th
    {
        height:40px;
        border-top:#CCC 1px solid;

    }
    #example colgroup col:nth-child(3)
    {
        width:40% !important;
    }
    #example colgroup col:nth-child(4)
    {
        width:30% !important;
    }
	
	.ui-state-default {
		    background: url("../../images/assets/bg-table-header.gif") repeat-x scroll left bottom rgba(0, 0, 0, 0) !important;
			border: 1px solid #cccccc  !important;
			font-weight: normal  !important;
			height: 20px  !important;
			padding: 0   !important;
			vertical-align: top  !important;
	}
	
    .table-bordered {
        border-collapse: separate;
        border-image: none;
        border-radius: 0px !important;
        border-style: none !important;
        border-width: 0px !important;
        border-top-right-radius:0px !important;
        border-top-left-radius:0px !important;
    }
    .withdatatablecss {
        border-bottom:#D1D1D1 1px solid !important; border-right: 1px solid #D1D1D1 !important;border-top:#D1D1D1 1px solid !important; border-radius:0px !important;	border-left: 1px solid #D1D1D1!important;
    }
	
.tablesorter-filter-row td
	{
		 border-right: 1px solid #D1D1D1 !important;border-top:#D1D1D1 1px solid !important; border-radius:0px !important;border-left: 1px solid #D1D1D1!important;
	}
    .tablesorter-icon {
        background-image: url("../../images/assets/table-sort-default.gif");
    }
	
	.t_Tooltip{
	display:none !important;
}
.tablesorter-bootstrap .tablesorter-header i {
    background-repeat: no-repeat;
    display: inline-block;
    float: right!important;
    height: 14px;
    left: 2px;
    line-height: 14px;
    margin-top: 10px!important;
    position: absolute; 
    width: 12px;
}
.tablesorter-bootstrap .tablesorter-header-inner {
    font-size: 11px;
    padding: 0px 10px 4px 0!important;
    position: relative;
	margin-left:-3px!important
}
  

/*.tablesorter-bootstrap .tablesorter-filter-row .tablesorter-filter {
  
    margin: 0 -2px !important;
    padding: 4px 1px !important;
   
}*/

.dataTable input[type="radio"], .dataTable input[type="checkbox"] {
    line-height: normal;
    margin: 0 !important;
}
.phonekey select {
    border: 1px solid #cccccc;
    display: block;
    float: right;
    height: 25px;
    line-height: 2px;
    margin-top: 2px;
    padding: 0;
    width: 194px;
}

div.DataTables_sort_wrapper span{
 background: url("../../images/assets/table-sort-default.gif") no-repeat scroll 3% 80% rgba(0, 0, 0, 0) !important;
    color: #555555;
    margin-top: 0px;
    margin-top: -7px;
    

}

div.DataTables_sort_wrapper span.ui-icon-triangle-1-s{
 background: url("../../images/assets/table-sort-asc.gif") no-repeat scroll 3% 80% rgba(0, 0, 0, 0) !important;
    color: #555555;
    margin-top: -7px;

}

div.DataTables_sort_wrapper span.ui-icon-triangle-1-n{
background: url("../../images/assets/table-sort-desc.gif") no-repeat scroll 3% 80% rgba(0, 0, 0, 0) !important;
    color: #555555;
    margin-top: -7px;


}

	</style>
<script type="text/javascript">
//script for modelpopup
		$(function () {

		    $('#popup-wrapper').modalPopLite({  openButton: '.clicker',  closeButton: '#close-btn',  isModal: true });			
			$('#popup-wrapper2').modalPopLite({ openButton: '.clicker2', closeButton: '#close-btn2', isModal: true });
			$('#popup-wrapper3').modalPopLite({ openButton: '.clicker3', closeButton: '#close-btn3', isModal: true });
			$('#popup-wrapper4').modalPopLite({ openButton: '.clicker4', closeButton: '#close-btn4', isModal: true });
			$('#popup-wrapper5').modalPopLite({ openButton: '.clicker5', closeButton: '#close-btn5', isModal: true });

		});
	</script>
	
	<script>
	function fancyboxclose(){
		setTimeout( function() { $('#close-btn').trigger('click'); },5);
	 	}
		function fancyboxclose2(){
		setTimeout( function() { $('#close-btn2').trigger('click'); },5);
	 	}
		function fancyboxclose3(){
		setTimeout( function() { $('#close-btn3').trigger('click'); },5);
	 	}
		function fancyboxclose4(){
		setTimeout( function() { $('#close-btn4').trigger('click'); },5);
	 	}
</script>
	
<script type="text/javascript">
    $(document).ready(function() {
        $('.fancybox').fancybox();
		// Check if Ods value is Zero(0) open SelectDNS Overlay
		var odscount = $("#odscount").val();
		
		if(odscount==0){
			$('#add_numbers').click();
		}

       

        //Disable the buttons if scenario is completed i.e. status=6
<?php
if ($PerformDisable == 1) {
    ?>
            // Disable Add Number buttons
            jQuery('#add_numbers').removeAttr("onmouseout");
            jQuery('#add_numbers').removeAttr("href");
            jQuery('#add_numbers').removeAttr("onmouseover");
            jQuery('#add_numbers').attr("class", "pointer");

            //Disable edit selected and hide pop up over menu
            jQuery('#edit_selected_scenario_popupmenu').hide();
            jQuery('#edit_selected_scenario').removeAttr("onmouseout");
            jQuery('#edit_selected_scenario').removeAttr("href");
            jQuery('#edit_selected_scenario').removeAttr("onmouseover");
            jQuery('#edit_selected_scenario').attr("class", "pointer");

            // Disable All Checkboxes
            jQuery('#reloadwholdpagedata input[type="checkbox"]').each(function() {
                jQuery(this).attr("disabled", true);
            });

            //Disable Delete options
            jQuery('.deleteOdsentry').removeAttr("href");
            jQuery('.deleteOdsentry').attr("class", "deleteOdsentry pointer");


<?php } ?>

    });

    function submenuactivity(obj, action) {
        if (action == 1) {
            //$('.table-menu-popup').show();
			$('#table-popup').show();
        } else if (action == 0) {
           // $('.table-menu-popup').hide();
			$('#table-popup').hide();
        }
    }

    
</script>

<script type="text/javascript">
    $(document).ready(function() {
			
		/**
		* make desttextbox heighlighted with blue color
		*/
		
		var numeric_text=$("input.numeric_check").each(function() {

			var num_val=$(this).val();

			if(num_val=="")
			{
				$(this).addClass("hightlightbox");
				$('#overlay-sucess .ok .message').text("<?php __('Destination should not be empty!') ?>");
		        $('#overlay-sucess').removeClass('hide');
				
			}

		});     

		});



</script>

<script>
function set_visimenu(val)
{
	if(val=='dispmenu') {
			$("#edit_stat_popupmenu").slideToggle("slow");
	}
}

</script>
<?php
/**
* @ Delete function
*/
?>

<script>
  	function deletesource(val){ 
		//alert(val);
		$('.black_overlay').css('display', 'block');
	    $.fancybox.showLoading()  ;			
		var TargetURL = "<?php echo Configure::read('base_url');?>scenarios/deleteScenario/scenario_id:"+val;	
 		jQuery.post( TargetURL,  function( data ) {  //alert(data);			
			window.location.href = "<?php echo Configure::read('base_url'); ?>scenarios/index/customer_id:<?php echo $SELECTED_CUSTOMER; ?>";
	});
	setTimeout( function() {     
			$('#close-btn').trigger('click');
		 },200);
}

  	function submitBlockFilter(){ 
        
        
        
		var block_id = jQuery('#blockSelect').val();
        var scenario_id = '<?php echo $scenario_id; ?>';

        var TargetURL = "<?php echo Configure::read('base_url'); ?>scenarios/edit/scenario_id:" + scenario_id + '&block_id=' + block_id;
		//window.location(TargetURL);
		 window.location.href = TargetURL;
        //jQuery.post(TargetURL, function(data) {
            
            //$("#msg").html(data);


        //});
        //location.reload(true);	
		
    //});
	}
	
function delete_allschedule(val){
	//$('.black_overlay').css('display', 'block');
	   // $.fancybox.showLoading()  ;	
	 var TargetURL = "<?php echo Configure::read('base_url');?>scenarios/delete_allschedule/"+val;
	 jQuery.post( TargetURL, function(data){
	 	$('#close-btn3').click();
	 	$('#add_numbers').click();
	 });
	 setTimeout( function() {     
			$('#close-btn').trigger('click');
		 },200);
}

  </script>
<script type="text/javascript">
    $(document).ready(function() {

    	$("body").on('paste', '.numeric_check', function(e) {
    		// alert("fdfdf");

		    // $("#updateOdsentry").show();    

		     $('#savedestinations').attr("onclick", "javascript:saveOdsentry(this);");
		    // $('#savedestinations').attr("class", "showhighlight_buttonleft");
		    // //jQuery('#destid').val(CurrId);

		    // $('#updateOdsentry').removeAttr("class");
		    // $('#updateOdsentry').attr("class", "button-right-hover");
		    
		    var obj = $(this);
		    chngbkcolor(obj);
		    setTimeout(function () {
		      var str = $(obj).val();
		      if(!str.match(/^\d+$/)) {
		        (obj).val('')
		      }
		    }, 10);
		    //return false;
	  	});



		jQuery('#updateOdsentry').hide();		            
        $('#minus').hide();
        $('#mbtn').hide();

        $('#minus').click(function() {
            $('#pbtn').show();
            $('#minus').hide();
            $('#mbtn').hide();
            $('#plus').show();
        });

        $('#minus_schedule').hide();
        $('#mbtn_schedule').hide();

        $('#minus_schedule').click(function() {
            $('#pbtn_schedule').show();
            $('#minus_schedule').hide();
            $('#mbtn_schedule').hide();
            $('#plus_schedule').show();
        });

        $('#plus_schedule').click(function() {
			
            $('#pbtn_schedule').hide();
            $('#minus_schedule').show();
            $('#mbtn_schedule').show();
            $('#plus_schedule').hide();
        });

        $('#minus_ods').hide();
        $('#mbtn_ods').hide();

        $('#minus_ods').click(function() {
            $('#pbtn_ods').show();
            $('#minus_ods').hide();
            $('#mbtn_ods').hide();
            $('#plus_ods').show();
        });

        $('#plus_ods').click(function() {
            $('#pbtn_ods').hide();
            $('#minus_ods').show();
            $('#mbtn_ods').show();
            $('#plus_ods').hide();
        });
    });

</script>

<script type="text/javascript">
    function chngbkcolor(obj) {  
        $(document).ready(function() {

            var valueToFind = jQuery(this).val();
            var CurrId = jQuery(obj).attr('id');
			
            CurrId = (typeof CurrId == 'undefined') ? '' : CurrId;

            jQuery('#save' + CurrId).show();
            jQuery('#trick' + CurrId).hide();

            var val = jQuery('#' + CurrId).val();
            var RowId = CurrId.substring(1, CurrId.length);

            //jQuery('#chk' + RowId).removeAttr("class");
            jQuery('#chk' + RowId).attr("class", "changedodsentry");
			
            if (val != '') {
				var edited = "<?php __('Edited'); ?>"
                jQuery('.sc_state_medium' + RowId).html(edited);
            }
           jQuery('#destid').val(CurrId);

// Jquery Validation
           var arr = CurrId.split('d');
		   $("#d"+arr[1]).addClass("form-change");
		   
		        jQuery('#updateOdsentry').show();
            	jQuery('#savedestinations').attr("class", "showhighlight_buttonleft");
				
            	jQuery('#updateOdsentry').removeAttr("class");
            	jQuery('#updateOdsentry').attr("class", "button-right-hover");
		   
		   /*var rowdata = 'd'+arr[1];
		  	   
		   alert(rowdata);
		   validation = {
	    	    // Specify the validation rules
	    	    'rules': {
	    	        rowdata:{
	    	            'min': '9',
	    	            'max': '15',
	    	        }                 
	    	    },                  
	    	    // Specify the validation error messages
	    	    'messages': {  
	    	         rowdata: {
	    	             'min': "<?php __('min9Chars')?>",
	    	             'max': "<?php __('max15Chars')?>",
	    	         }
	    	    },
	    	  };
			
			if (inValidate(validation)) {
	    	$("#d"+arr[1]).attr("class","space_check  numeric_check form-change");
			$('#savedestinations').removeAttr("onclick","");
			$('#updateOdsentry').removeAttr("class");
		    $('#savedestinations').removeAttr("class", "showhighlight_buttonleft");
		    $('#updateOdsentry').attr("class", "button-right-disabled");
	    	    return false;
	    	  } 
			  else{
			  	jQuery('#savedestinations').attr("onclick", "javascript:saveOdsentry(this);");
				jQuery('#savedestination').attr("class", "showhighlight_buttonleft");
            	jQuery('#savedestinations').attr("class", "showhighlight_buttonleft");
            	jQuery('#destid').val(CurrId);

            	jQuery('#updateOdsentry').removeAttr("class");
            	jQuery('#updateOdsentry').attr("class", "button-right-hover");
			  }*/
		   

			 $("input.numeric_check").focus(function(e) {	
			 //make button heightlighted when there is unsaved destination
			 	$('#savedestinations').addClass('showhighlight_buttonleft');
				
				$('#updateOdsentry').removeClass('button-right-disabled');
				$('#updateOdsentry').addClass('button-right-hover');
			 
			 
			 
			 
			 
	 //  if ($("#d"+arr[1]).val().length < 3) {
  //            $('#overlay-error .error .message').text("<?php __('min3Chars') ?>");
  //            $('#overlay-error').removeClass('hide');
             
		// 	$("#d"+arr[1]).addClass("form-changeinvalidate");
		// 	$('#savedestinations').removeAttr("onclick","");
		// 	$('#updateOdsentry').removeAttr("class");
		//     $('#savedestinations').removeAttr("class", "showhighlight_buttonleft");
		//     $('#updateOdsentry').attr("class", "button-right-disabled");
			
		// 	$('#overlay-sucess').addClass('hide');	
			       
  //            return false;  
                   
  //         }
		// else if ($("#d"+arr[1]).val().length > 15) {
  //            $('#overlay-error .error .message').text("<?php __('max15Chars') ?>");
  //            $('#overlay-error').removeClass('hide');     
			 
		// 	 $("#d"+arr[1]).addClass("form-changeinvalidate");
		// 	 $('#savedestinations').removeAttr("onclick","");
		// 	 $('#updateOdsentry').removeAttr("class");
		//      $('#savedestinations').removeAttr("class", "showhighlight_buttonleft");
		//      $('#updateOdsentry').attr("class", "button-right-disabled");        
             
  //           return false;        
  //         }
		  
		
		  
		 //  else{
		 //  	jQuery('#savedestinations').attr("onclick", "javascript:saveOdsentry(this);");
   //          jQuery('#savedestinations').attr("class", "showhighlight_buttonleft");
   //          //jQuery('#destid').val(CurrId);

   //          jQuery('#updateOdsentry').removeAttr("class");
   //          jQuery('#updateOdsentry').attr("class", "button-right-hover");
			// $('#overlay-sucess').addClass('hide');
		 //  }
		  
	  
    });
			
			
			
			
        });
		}
	 $(document).ready(function() {
	//called when key is pressed in textbox
	
	
	
	
    $("input.numeric_check").keydown(function(e) {	
	
	
		//console.log(e.which);

		/*
		 Digits and

·         number pad

·         back and

·         delete and

·         copy pasete (ctrl-v not supported) 
*/
      if( 
      	e.which!=8 && 
      	e.which!=0 && 
      	(e.which<48 || e.which>57) && 
      	e.which!=13 && 
      	e.which!=118 &&
      	(e.which<96 || e.which>106) &&
      	e.which!=37 &&
      	e.which!=39 &&
      	e.which!=17 &&
      	e.which!=67 &&
		e.which!=86 &&
		e.which!=88 &&
      	e.which!=46      	
      	)
      {        
      
		$('#overlay-error .error .message').text("<?php __('digitsOnly') ?>");
        $('#overlay-error').removeClass('hide');
		//$('#savedestinations').removeAttr("onclick","");
			
        return false;
		
      }
	  
	   else {	
	         
      		//$("input").keydown(function() {
	          //inValidate(validation, 'keyup');                    
	        //});
            jQuery('#savedestinations').attr("onclick", "javascript:saveOdsentry(this);");
            jQuery('#savedestinations').attr("class", "showhighlight_buttonleft");
            //jQuery('#destid').val(CurrId);

            jQuery('#updateOdsentry').removeAttr("class");
            jQuery('#updateOdsentry').attr("class", "button-right-hover");
      }
        });
		});

    
    $(document).ready(function() {	
		
        $('.counter').hide();
		
		$('.deldest').hide();
		$('.cntchk_updatemsg2').hide();

		//Omit space character to name field

		// $("#Id").keypress(function(e) {	
		// 	if (e.which == 32) {
		// 		return false;
		// 	}     
		// });

		
	
        $('#savescenariotitle').click(function() {

        	validation = {
	    	    // Specify the validation rules
	    	    'rules': {                     
	    	        'Id':{
	 					'required': true,
	 					'spclChar': true,
	    	            'max': '20',
	    	            'notSpace' : true,
	    	        }	                                  
	    	    },                
	    	    // Specify the validation error messages
	    	    'messages': {  
	    	        'Id': {
						'required': "<?php __('ScenarioNameNotempty')  ?>",
						'spclChar': "<?php __('Special characters are not allowed')  ?>",
	    	            'max': "<?php __('max20Chars')?>",
	    	            'notSpace': "<?php __('spaceNotAllowed')?>",
	    	        }	    	         
	    	    },			
	    	};
	    	
            var scenario_name = jQuery('.scenarios').val();
			var scenario_remark = jQuery('#ScenarioRemark').val();
            
			if (inValidate(validation)) {				
				$('#overlay-sucess').addClass('hide');
				return false;
			}else{							
	            var scenario_id = '<?php echo $scenario_id; ?>';
	            var customer_id = '<?php echo $customer_id; ?>';
				
	            var TargetURL = "<?php echo Configure::read('base_url'); ?>scenarios/update_scname/scenario_id:" + scenario_id + "/customer_id:" + customer_id + "/scenario_name:" + scenario_name+ "/scenario_remark:" + scenario_remark;
	            jQuery.post(TargetURL, function(data) {
	                var msgd = data;
	                               
	                window.location.href = "<?php echo Configure::read('base_url'); ?>scenarios/edit/scenario_id:" + msgd;
					$('#overlay-sucess .ok .message').text("<?php __('Scenario succesfully added') ?>");
			        $('#overlay-sucess').removeClass('hide');
	             	 //$('#add_numbers').click();	
				 
					url = '<?php echo Configure::read('base_url');?>dns/selectdns/scenario_id:' + msgd;
	                //alert(url);
				   //$('#add_numbers').attr('href', url);
				   //$('#add_numbers').click();
				   //$("#add_numbers").trigger("click");
	               //jQuery('#scenariossuccess').html('<font class="scenarioupdatemsg">Scenario updated successfully!</font>');

	            });
           
			}
        });
		
		
		

$(function(){
     $("#Id").keyup(function(e){
          if (e.keyCode === 13) {
               var scenario_name = jQuery('.scenarios').val();
			 //if (inValidate(validation)) {				
				//in$('#overlay-sucess').addClass('hide');
			//	return false;
			//}else{							
            var scenario_id = '<?php echo $scenario_id; ?>';
            var customer_id = '<?php echo $customer_id; ?>';
            var TargetURL = "<?php echo Configure::read('base_url'); ?>scenarios/update_scname/scenario_id:" + scenario_id + "/customer_id:" + customer_id + "/scenario_name:" + scenario_name;
            jQuery.post(TargetURL, function(data) {
                var msgd = data;
                               
                window.location.href = "<?php echo Configure::read('base_url'); ?>scenarios/edit/scenario_id:" + msgd;
				$('#overlay-sucess .ok .message').text("<?php __('Scenario succesfully added') ?>");
		        $('#overlay-sucess').removeClass('hide');
             	 //$('#add_numbers').click();	
			 
				url = '<?php echo Configure::read('base_url');?>dns/selectdns/scenario_id:' + msgd;
                //alert(url);
			   //$('#add_numbers').attr('href', url);
			   //$('#add_numbers').click();
			   //$("#add_numbers").trigger("click");
               //jQuery('#scenariossuccess').html('<font class="scenarioupdatemsg">Scenario updated successfully!</font>');

            });
          }
     });

});

        $('#crm_comment_option').val('');
    });


	validation = {
                // Specify the validation rules
        'rules': {                     
          
            'destname':{
				'leading': '0',	    	            
				'excludeStr': ['084', '0800', '090', '00870', '00881', '00882', '00883', '0039310'],
				'min': '9',
				'max': '20'	    	           
			}   
                              
        },                  
        // Specify the validation error messages
        'messages': {            
            'destname': {
             	'leading' : "<?php __('leadingZeroOds')?>",
                'min': "<?php __('min9Chars')?>",
                'max': "<?php __('max20Chars')?>",
                'excludeStr' : "<?php __('excludeNumber')?>"
            }
        }
    };


    $("body").on('keydown', 'input, textarea', function(e) {  
  		//console.log("inside");
		$(".ok").hide();
	    var form = $(this).parents('form:first');
//	    var invalidate = form.attr("invalidate");
	    var classinvalidate = form.attr("classinvalidate");

	    var oldVal = $(this).val();   
	    
	    var priorVal = $(this).attr('data-value'); 
	    
	    if (priorVal != '' && oldVal != priorVal) {
	        $(this).addClass('form-change');
			$('#overlay-sucess').addClass('hide');
	    }	

		if ((typeof classinvalidate != "undefined")) {     
	
	        classInValidate(validation, 'keyup', $(this), e); 
	  
			$('#overlay-sucess').addClass('hide');   

	    } else {
	      //console.log("no validation");
		  //$('#overlay-sucess').removeClass('hide');
	    }
	});

	
    function saveOdsentry(id) {
        //alert(id);
		
        if (classInValidate(validation)) {        
          return false;
        } else {
        
                    
        var senddata = [];
		var rowdata = [];
		var dstname = [];
        jQuery('.changedodsentry').each(function() {

            var style = jQuery('.saveOdsentry').attr('style');
            var rowid = jQuery(this).attr('id');
            var attrlen = rowid.length;
            var Orowid = rowid.substring(2, attrlen);
            var Dbrowid = rowid.substring(3, attrlen);
            var Destval = jQuery('#d' + Dbrowid).val();
			

			//jQuery("#update"+rowid).text(Destval);
			
            senddata.push(Dbrowid + "=" + Destval);
			rowdata.push(Dbrowid);
			
			//window.location.reload();

        });

        var serialized = senddata.join("&")
		
		//var dstname="'d"+rowdata+"'";
				
        var TargetURL = "<?php echo Configure::read('base_url'); ?>scenarios/updatemultipleodsentry/";
        var ScenarioId = $('#scenario_id').val();
        $('.black_overlaysaveOdsentry').show();
        jQuery.post(TargetURL, {'odsdata': serialized, 'scenario_id': ScenarioId}, function(data) {
			
        	$(".form-change").removeClass("form-change");
        	$(".hightlightbox").removeClass("hightlightbox");        	
            jQuery('#destid').val('');
            jQuery('.saveOdsentry').attr("style", "display:none");
            jQuery(' .trickOdsentry').attr("style", "display:inline");
            jQuery('#updateOdsentry').removeAttr("class");
            jQuery('#savedestinations').removeAttr("class");
            jQuery('#updateOdsentry').attr("class", " button-right-disabled");
			
            jQuery('#savedestinations').removeAttr("onclick");
			
			//make destination field heighlighted
			
			var numeric_text=$("input.numeric_check").each(function() {
			var num_val=$(this).val();
			var customid = $(this).attr('customid');
			//alert(customid);
			if(num_val!="")
			{
				$('#overlay-sucess').addClass('hide');
			}
			//$("#updatechk"+customid).text(num_val);
			//$("#d"+customid).attr('data-value',num_val);
			//$("#d"+customid).attr('value',num_val);
			//window.location.reload();
			//$.ajax({url:"http://localhost:8000/voipphoneRE3/scenarios/edit1/scenario_id:84",success:function(result){
				//$("#updatehtml").html(result);
			  //}});
			//$("#reloadwholdpagedata").html(result);
			
				//$.ajax({url:"<?php echo Configure::read('base_url'); ?>scenarios/tablereload/scenario_id:<?php echo $slug; ?>",success:function(result){
				
				//$("#updatehtml").html(result);
				//$('.black_overlaysaveOdsentry').hide();			
			 // }});
		}); 
			
		
			//return;
		setTimeout(function() {
            // Update Scenario Status
			var scn_status = $('#sts').html();
            var TargetURL = "<?php echo Configure::read('base_url'); ?>scenarios/ScenarioCompletedOrNot/scenario_id:" + ScenarioId+"/status:"+scn_status;
			
			$('.fancybox-loading').hide();	
            jQuery.post(TargetURL, function(response) {
				
				
                jQuery('#Status').val(response);
                var msgd = response.trim();
				if(msgd == "Incomplete")
				{
					var scenarioStatus = "<?php __('Incomplete');?>"
				}
				else if(msgd == "Complete"){
					var scenarioStatus = "<?php __('Complete');?>"
				}
				jQuery('#sts').html(scenarioStatus); 
			
				var scenairoInactive = "<?php echo __($scenarioStatus[$scenarioDetails[0]['Scenario']['status']], true); ?>";
				 
				
                if (msgd != "Incomplete") {
					
					if(msgd == scenairoInactive){

                    //Hide Workflow messages
                    jQuery('#crm_comment_workflow').hide();
                    jQuery('#complete_workflow').hide();
                    jQuery('#reject_workflow').hide();
                    jQuery('#activate_workflow').show();
                    jQuery('#invalid_workflow').hide();
					
				}else{
					
		
					
                    jQuery('#request_validation').show();
                    jQuery('#request_validationdiv').show();
                    //Hide buttons
                    jQuery('#crm_comment_div').hide();
                    jQuery('#activationdiv').hide();
                    jQuery('#deactivationdiv').hide();

                    //Hide Workflow messages
                    jQuery('#crm_comment_workflow').hide();
                    jQuery('#complete_workflow').show();
                    jQuery('#reject_workflow').hide();
                    jQuery('#activate_workflow').hide();
                    jQuery('#invalid_workflow').hide();
					
					}
					

                } 
				 
				else {
                    // Hide buttons
                    jQuery('#request_validation').hide();
                    jQuery('#request_validationdiv').hide();
                    jQuery('#crm_comment_div').hide();
                    jQuery('#activationdiv').hide();
                    jQuery('#deactivationdiv').hide();

                    //Hide Workflow messages
                    jQuery('#crm_comment_workflow').hide();
                    jQuery('#complete_workflow').hide();
                    jQuery('#reject_workflow').hide();
                    jQuery('#activate_workflow').hide();
                    jQuery('#invalid_workflow').show();
                }
				$(".black_overlaysaveOdsentry").hide();
            });
},5); 
            // Change Odsentry state
            jQuery('#reloadme input[type="text"]').each(function() {
                var sid = jQuery(this).attr('id');
                var val = jQuery('#' + sid).val();
                var RowId = sid.substring(1, sid.length);
                if (val != '') {
					var validrec = "<?php __('Valid'); ?>";
                    jQuery('.sc_state_medium' + RowId).html(validrec);
                }
            });

            setTimeout(function() {
				
                //$('.black_overlaysaveOdsentry').hide();
            }, 500);

        });
        }//end validation check else
		$(".message").hide();
		$(".error").hide();
		
    }
    function toggleAdvanceSearch() {
        //$("#advancesearch").show
        if (document.getElementById('advancesearch').style.display == 'none') {
            document.getElementById('advancesearch').style.display = 'block';
        } else {
            document.getElementById('advancesearch').style.display = 'none';
        }

    }
    function toggleShowHistory() {
        //$("#advancesearch").show
        if (document.getElementById('showhistory').style.display == 'none') {
            document.getElementById('showhistory').style.display = 'block';
        } else {
            document.getElementById('showhistory').style.display = 'none';
        }
    }
    function toggleexecutionschedule() {
        //$("#advancesearch").show
        if (document.getElementById('showexecution').style.display == 'none') {
            document.getElementById('showexecution').style.display = 'block';
        } else {
            document.getElementById('showexecution').style.display = 'none';
        }

    }
    function toggleodsentries() {
        //$("#advancesearch").show
        if (document.getElementById('showods').style.display == 'none') {
            document.getElementById('showods').style.display = 'block';
        } else {
            document.getElementById('showods').style.display = 'none';
        }

    }
</script>



<style>
.tablesorter-filter
{
   width:100% !important;
   margin: 0 -2px !important;
   padding: 4px 1px !important;
}
.space_check
{
   width:91%;
   height:16px !important;
   margin-bottom:0 !important;
}
  
.tablesorter-bootstrap .tablesorter-pager select
{
   width:64px;
   margin:0 20px;
}
.table-top th, .table-right-ohne th
{
   height:35px;
}
#example colgroup col:nth-child(3)
{
   width:40% !important;
}
#example colgroup col:nth-child(4)
{
   width:30% !important;
}

.table-bordered {
   border-collapse: separate;
   border-image: none;
   border-radius: 0px !important;
   border-style: none !important;
   border-width: 0px !important;
   border-top-right-radius:0px !important;
   border-top-left-radius:0px !important;
}
.withdatatablecss {
        border-bottom:#D1D1D1 1px solid !important;
		border-right: 1px solid #D1D1D1 !important;
		border-top:#D1D1D1 1px solid !important;
		border-radius:0px !important;
		border-left: 1px solid #D1D1D1!important;
}
.tablesorter-filter-row td
{
		border-right: 1px solid #D1D1D1 !important;
		border-top:#D1D1D1 1px solid !important;
		border-radius:0px !important;
		border-left: 1px solid #D1D1D1!important;
		padding: 4px 30px 4px 14px  !important;
}
.tablesorter-icon {
        background-image: url("../../images/assets/table-sort-default.gif");
}
#mcTooltipWrapper {
		display:none;
}
.t_Tooltip{
		display:none !important;
}
.tablesorter-bootstrap .tablesorter-header i {
	    background-repeat: no-repeat;
	    display: inline-block;
	    float: right!important;
	    height: 14px;
	    left: 6px;
	    line-height: 14px;
	    margin-top: 10px!important;
	    position: absolute; 
	    width: 12px;
}
.tablesorter-bootstrap .tablesorter-header-inner {
	    font-size: 11px;
	    padding: 0px 10px 4px 0!important;
	    position: relative;
}
.counter {
	    color:#555555;
	    font-size: 11px;
	    margin-left: 5px !important;
	    margin-top: -34px !important;
	    position: absolute;
}

.tablesorter-filter
    {
        width:100% !important;
		margin: 0 -2px !important;
        padding: 4px 1px !important;
		height:26px!important;
    }
	
.tablesorter-bootstrap .tablesorter-filter-row td {
	    background: none repeat scroll 0 0 #EEEEEE;
	    line-height: normal;
	    padding: 4px 3px;
	    text-align: center;
	    transition: line-height 0.1s ease 0s;
	    vertical-align: middle;
}
.table th, .table td {
	    border-top: 1px solid #DDDDDD;
	    line-height: 20px;
		padding: 1px 14px;  
	    border:none;
	    background-color:#fff !important;
		padding-left:3px!important;
	    text-align: left;
	    vertical-align: top;
}	

</style>

<script type="text/javascript">
    function deleteOdsentry(record_id, scid, elem) {
        $.post(base_url + 'odsentries/delete/' + record_id + '/' + scid, {}, function(data) {
            //$('#'+record_id).closest('tr').remove();
            //alert('Record is deleted successfully');
			
			$('#overlay-sucess .ok .message').text("<?php __('Record is deleted successfully') ?>");
		    $('#overlay-sucess').removeClass('hide');
			
            $('#reloadwholdpagedata').html(data);
            /*if(data=="success"){
             $('#'+record_id).closest('tr').remove();
             alert('Record is deleted successfully');
             }*/
        });
    }
    function submit_form(action) {
        //alert(action);
        $('.filtersForm').attr('action', base_url + 'odsentries/index/' + action);
        $('.filtersForm').attr('method', 'POST');
        $.ajax({
            type: "POST",
            async: false,
            dataType: 'json',
            url: $('.filtersForm').attr('action'),
            data: $('.filtersForm').serialize(),
            success: function(data) {  //alert(data);
                if (data.message == "updated") {
                    alert(data.affectedRows + 'Record(s) updated successfully')
                } else {
                    alert('Some error occured, Please try again');
                }
            }
        });
    }

    /* 

    function paginationStyle(totPages,currPage) {
        // $("table").removeClass('table-striped');
        // $("table").removeClass('tablesorter-bootstrap');
        var pageDisplay = $(".cust_tab_pag .pagedisplay").text();
        temp = pageDisplay.split("-");
        temp[0] = $.trim(temp[0]);
        temp[1] = $.trim(temp[1]);
        if (typeof temp[1] != 'undefined') {
            page2 = temp[1].split("/");
            page2[0] = $.trim(page2[0]);
            page2[1] = $.trim(page2[1]);
            page3=page2[1].split("(");
            page3[0] = $.trim(page3[0]);
            page3[1] = $.trim(page3[1]);
            var showrecord = page3[0];
            totalPage = totPages;
        } else {
            return false;
        }
        if(typeof totalPage == "undefined")
        {
            return false;
        }
        $(".pagedisplay").text('');
        box = currPage+1;
        $('.countdisplay').html(showrecord);       
        var newStyle = "<input type='text' name='currpage' value='" + box + "' style='width:25px;text-align:center;float: inherit;' maxlength='3' class='GoOnTargetPage'>";
        newStyle += "<span style='font-weight:bold'> <?php echo __('Of') ?> " + totalPage + "</span>";
        $(".pagedisplay").html(newStyle);
        $('.GoOnTargetPage').keyup(function() {
            //console.log($(this).val());
            $("input[type='text']").keypress(function(e) {
                if (e.which == 13) {

                    $('.pagenum').val($(this).val()).trigger('change');
                    paginationStyle();
                    //return false;
                }

            });
        });

    }//end paginationstyle
	
*/
    jQuery(function() {
		/*
        jQuery.extend(jQuery.tablesorter.themes.bootstrap, {
            // these classes are added to the table. To see other table classes available,
            // look here: http://twitter.github.com/bootstrap/base-css.html#tables	
        });
        // call the tablesorter plugin and apply the uitheme widget
        jQuery(".tablesorterscenario").tablesorter({
            // this will apply the bootstrap theme if "uitheme" widget is included
            // the widgetOptions.uitheme is no longer required to be set
            theme: "bootstrap",
            widthFixed: true,
            bFilter: false,
            bInfo: false,
            icons: '', // add "icon-white" to make them white; this icon class is added to the <i> in the header
            sortNone: 'bootstrap-icon-unsorted',
            sortAsc: 'icon-chevron-up',
            sortDesc: 'icon-chevron-down',
			emptyTo: 'zero',
            headerTemplate: '{content} {icon}', // new in v2.7. Needed to add the bootstrap icon!
			sortList: [[2,0],[1,0]],
            // widget code contained in the jquery.tablesorter.widgets.js file
            // use the zebra stripe widget if you plan on hiding any rows (filter widget)
            widgets: ["uitheme", "filter", "zebra"],
            widgetOptions: {
                // using the default zebra striping class name, so it actually isn't included in the theme variable above
                // this is ONLY needed for bootstrap theming if you are using the filter widget, because rows are hidden
                zebra: ["even", "odd"],
                // reset filters button
                filter_reset: ".reset"

                        // set the uitheme widget to use the bootstrap theme class names
                        // this is no longer required, if theme is set
                        // ,uitheme : "bootstrap"
            },
            headers: {
                0: {sorter: false, filter: false},				
                1: {sorter: true, filter: true},
                2: {sorter: true,filter: true, empty : "top" },
                4: {sorter: false, filter: false},
                6: {sorter: false, filter: false}

            }
        })
	    .tablesorterPager({
	        // target the pager markup - see the HTML block below
	        container: jQuery(".pagerscenarioedit"),
	        // target the pager page select dropdown - choose a page
	        cssGoto: ".pagenum",
	        initWidgets: true,
	        // remove rows from the table to speed up the sort of large tables.
	        // setting this to false, only hides the non-visible rows; needed if you plan to add/remove rows with the pager enabled.
	        removeRows: false,
	        // output string - default is '{page}/{totalPages}';
	        // possible variables: {page}, {totalPages}, {filteredPages}, {startRow}, {endRow}, {filteredRows} and {totalRows}
	       // output: '{startRow} - {endRow} / {filteredRows} ({totalRows})'
	        //  output: 'Page <input type="text" name="currpage" value="{page}" class="pagination_text" maxlength="3"> Of {totalPages}'
			 output: '{startRow} - {endRow} / {filteredRows} ({totalRows})',
			 pagerUpdate:function(totPages,currPage)
	        {
	            paginationStyle(totPages,currPage);
	        }
	    });
			*/
        jQuery(".smallwidth").focus(function() {
            var valueToFind = jQuery(this).val();
            if (valueToFind == 'DN From' || valueToFind == 'DN To') {
                jQuery(this).val('');
            } else {
                jQuery(this).val(valueToFind);
            }
        });

        jQuery(".smallwidth").focusout(function() {
            var valueToFind = jQuery(this).val();
            if (valueToFind == '' || valueToFind == '') {
                var id = jQuery(this).attr('id');
                if (id == 'min')
                    jQuery(this).val('DN From');
                else if (id == 'max')
                    jQuery(this).val('DN To');
            }
        });

        jQuery("#filter_now").click(function() {
            var MinVal = jQuery('#rangeMinMinval').val();
            var MaxVal = jQuery('#rangeMaxMaxval').val();

            if ((MinVal.length < 9 || MinVal.length > 9) && (MaxVal.length < 9 || MaxVal.length > 9)) {
                alert('Filter Range From and To Must Be 9 digits!');
                return false;
            } else {

                if (isNaN(MinVal) || isNaN(MaxVal)) {
                    alert('Filter Range must be numeric only!');
                    return false;
                } else {
                    jQuery("#form2").submit();
                }
            }
        });

        jQuery("#reset_filter").click(function() {
            jQuery('#rangeMinMinval').val('');
            jQuery('#rangeMaxMaxval').val('');
            jQuery("#form2").submit();
        });

        jQuery(".deldest2").click(function() {
			$('.black_overlay').css('display', 'block');
	    $.fancybox.showLoading()  ;
            jQuery('input[type="checkbox"]:checked').each(function() {
                var Odsentryid = jQuery(this).val();
                var TargetURL = "<?php echo Configure::read('base_url'); ?>scenarios/deletedest/dest_id:" + Odsentryid;
                jQuery.post(TargetURL, function(data) {
                    jQuery("#firstchild" + data).parents("tr").hide();
                });
                jQuery("#firstchild" + Odsentryid).parents("tr").hide();
            });

            jQuery('input[type="checkbox"]:checked').each(function() {
                jQuery(this).attr("checked", false);
            });

            setTimeout(function() {
                window.location.reload();
            }, 1000);
        });

		 jQuery("#checkAll").click(function() {
			
			$('.counter').show();
			
			$('.deldest').show();
			$('.cntchk_updatemsg2').show();
			
            if (jQuery("#checkAll").is(':checked')) {
			
				
				jQuery('input[type="checkbox"]').each(function() {
					  jQuery(this).attr("checked", true);
					  var attrid = $(this).attr('id');					
						
						getcheckval = $("#"+attrid).val();
						if(getcheckval == 'on') return;
						
						if ($("#"+attrid).is(':checked')) {
							
							// push a new one on
							//if(jQuery.inArray(getcheckval, myArray ) < 0) return;
							myArray.push(getcheckval);
							noofrecord++;
						}
						else{
							//$("#d"+dataattr[1]).attr("class","space_check  numeric_check  ");
							noofrecord--;
							myArray.splice(myArray.indexOf(getcheckval),1);
						}
				});
				
				myArray = unique(myArray);
				
				
				var margearray = "";
				for(i=0; i<= myArray.length-1; i++){
					margearray += myArray[i] + ",";
				}
				noofrecord = myArray.length;
				$("#getallids").val(margearray);
			
			}else{
				jQuery('input[type="checkbox"]').each(function() {
					  jQuery(this).attr("checked", false);
					  var attrid = $(this).attr('id');					
						
						getcheckval = $("#"+attrid).val();
						if(getcheckval == 'on') return;
						
						//$("#d"+dataattr[1]).attr("class","space_check  numeric_check  ");
						noofrecord--;
						myArray.splice(myArray.indexOf(getcheckval),1);
						
				});
				
				myArray = unique(myArray);
				
				
				var margearray = "";
				for(i=0; i<= myArray.length-1; i++){
					margearray += myArray[i] + ",";
				}
				noofrecord = myArray.length;
				
				var margearray = "";
				for(i=0; i<= myArray.length-1; i++){
					margearray += myArray[i] + ",";
				}	
				$("#getallids").val(margearray);
			}
			
			if (noofrecord < 1)
            {
                $('.counter').hide();
				$('.deldest').hide();
				$('.cntchk_updatemsg2').hide();
										
									
            }
            $('.counter').text(noofrecord + " <?php echo __('records are selected'); ?>");
            });
			
			
        /*Check All / Uncheck All functionality*/
        jQuery("#checkAll12").click(function() {
			
            if (jQuery("#checkAll").is(':checked')) {

                $('.counter').show();
				$('.deldest').show();
				$('.cntchk_updatemsg2').show();
				
				// var arr = CurrId.split('d');
		   
                var noofrecord = 0;
				var scStatus = $("#scenarioStatusId").val();
                jQuery('input[type="checkbox"]').each(function() {

                    var CClass = jQuery(this).parents("tr").attr('class');
                    if (CClass.indexOf("filtered") == -1) {
                        
						
						var attrid = jQuery(this).attr('id');
						var dataattr = attrid.split('chk');
						
						if(scStatus!=3){
							$("#d"+dataattr[1]).attr("class","space_check  numeric_check form-change");
						}
						

                        jQuery('#' + attrid).removeAttr('class');
                        jQuery('#' + attrid).prop("checked", true);
                        noofrecord++;
                    }
                });
                $('.counter').text(noofrecord - 1 + " <?php echo __('records are selected'); ?>");
				//$('.cnt').text("<?php echo __('Update scenario Selected'); ?> : " + (noofrecord - 1 ));

            } else {
                jQuery('input[type="checkbox"]').each(function() {
                    jQuery(this).removeAttr("checked");
                    $('.counter').text("0" + " <?php echo __('records are selected'); ?>");
					$('.cnt').text("");
					$('.cntchk_updatemsg2').hide();
                    $('.counter').hide();
					$('.deldest').hide();
					// when multiple update all dest fields are blue
					   var attrid = jQuery(this).attr('id');						
						var dataattr = attrid.split('chk');						
						$("#d"+dataattr[1]).attr("class","space_check  numeric_check ");
                });
            }
        });

		
			
        //jQuery('.odsentchk').click(function() {
		function odsentchk_check_disable()
		{
            var noofrecord = 0;
            jQuery("#checkAll").removeAttr("checked");
            $('.counter').show();
			
			$('.deldest').show();
			$('.cntchk_updatemsg2').show();
		
			
			var scStatus = $("#scenarioStatusId").val();			
            jQuery('input[type="checkbox"]').each(function() {
			// when multiple update all dest fields are blue
					  var attrid = jQuery(this).attr('id');						
						var dataattr = attrid.split('chk'); 
                 if ($(this).is(':checked')) {
						if(scStatus!=3){										
						//$("#d"+dataattr[1]).attr("class","space_check  numeric_check form-change");
						}
                    noofrecord++;
                }
				else{
					//$("#d"+dataattr[1]).attr("class","space_check  numeric_check  ");
				}
				
            });
			
			
            if (noofrecord < 1)
            {
                $('.counter').hide();
				$('.deldest').hide();
				$('.cntchk_updatemsg2').hide();
										
									
            }
            $('.counter').text(noofrecord + " <?php echo __('records are selected'); ?>");
			//$('.cnt').text("<?php echo __('Update  Selected'); ?> : " + (noofrecord ));

        }//);


        jQuery('.dosorting').click(function() {
            jQuery('input[type="checkbox"]').each(function() {
                jQuery(this).removeAttr("checked");
            });
        });

	});//end jQuery Start
    
var noofrecord = 0;
var myArray = new Array(); 
		function odsentchk_check(vid)
		{
            
            //jQuery("#checkAll").removeAttr("checked");
            $('.counter').show();
			
			$('.deldest').show();
			$('.cntchk_updatemsg2').show();
		
			
			// another quick way to define an array
			

			


			///var scStatus = $("#scenarioStatusId").val();			
            //jQuery('input[type="checkbox"]').each(function() {
			// when multiple update all dest fields are blue
					  var attrid = vid.id;					
						//ar dataattr = attrid.split('chk'); 
						//alert(attrid);
				 getcheckval = $("#"+attrid).val();
                 if ($("#"+attrid).is(':checked')) {
						//if(scStatus!=3){										
						//$("#d"+dataattr[1]).attr("class","space_check  numeric_check form-change");
						//}
						// remove an item by value:
						//myArray.splice(myArray.indexOf('MenuB'),1);
						
						// push a new one on
						myArray.push(getcheckval);
                    noofrecord++;
                }
				else{
					//$("#d"+dataattr[1]).attr("class","space_check  numeric_check  ");
					noofrecord--;
					myArray.splice(myArray.indexOf(getcheckval),1);
				}
				
            //});
			
			myArray = unique(myArray);
			noofrecord = myArray.length;
				
			var margearray = "";
			for(i=0; i<= myArray.length-1; i++){
				margearray += myArray[i] + ",";
			}	
			$("#getallids").val(margearray);
            if (noofrecord < 1)
            {
                $('.counter').hide();
				$('.deldest').hide();
				$('.cntchk_updatemsg2').hide();
										
									
            }
            $('.counter').text(noofrecord + " <?php echo __('records are selected'); ?>");
			//$('.cnt').text("<?php echo __('Update  Selected'); ?> : " + (noofrecord ));

        }//);
    function saveToLog(action) {
			
        var comment = $('#crm_comment_option').val();
        var scenario_id = '<?php echo $scenario_id; ?>';
        var cust_id = '<?php echo $SELECTED_CUSTOMER; ?>';
        $.post(base_url + "scenarios/validates/" + scenario_id, {'log_entry': action, 'comment': comment, 'cust_id': cust_id}, function(data) { //alert(data);
            if (data) {
                //alert("Scenario "+action);
                if (data == "scenario_accepted") {
                    $('#sc_state').text('5');
                    //window.location.reload();
                } else if (data == "scenario_rejected") {
                    $('#sc_state').text('6');
                    //window.location.reload();

                } else if (data == "scenario_validate_requested") {
                    $('#sc_state').text('3');
                    //alert("scenario_validate_requested");
                    //window.location.href = base_url + "scenarios/index/" + cust_id;
                    //window.location.href = "<?php echo Configure::read('base_url'); ?>scenarios/index/<?php echo $SELECTED_CUSTOMER; ?>";
					window.location.href = "<?php echo Configure::read('base_url'); ?>scenarios/index/customer_id:<?php echo $SELECTED_CUSTOMER; ?>";
                    
                }
                url = "<?php echo Configure::read('base_url'); ?>scenarios/index/customer_id:<?php echo $SELECTED_CUSTOMER; ?>";
                //alert(url);
                window.location.href = url;
                
                //window.location.reload();
            }
        });

    }
	function unique(list) {
				var result = [];
				$.each(list, function(i, e) {
					if ($.inArray(e, result) == -1) result.push(e);
				});
				return result;
		}
</script>

<script type="text/javascript">
    function selectAll(x) {
        for (var i = 0, l = x.form.length; i < l; i++)
            if (x.form[i].type == 'checkbox' && x.form[i].name != 'sAll')
                x.form[i].checked = x.form[i].checked ? false : true
    }
</script>
<script>
    function dispinput(val) {
        if (val == "nm") {
            jQuery('#inpt').fadeIn();
            jQuery('#nm').fadeOut();
        }
    }
</script>
<script>
    jQuery(document).ready(function() {
        jQuery('input#inpt').keypress(function(e) {
            if (e.which == '13') {

                var scenerio_name = jQuery('#inpt').val();
                var scenerio_id = '<?php echo $scenario_id; ?>';
                var TargetURL = "<?php echo Configure::read('base_url'); ?>scenarios/edittitles/scenerio_id:" + scenerio_id + "/scenerio_name:" + scenerio_name;

                jQuery.post(TargetURL, function(data) {

                    jQuery("#nm").html(data);
                    jQuery('#nm').fadeIn();
                    jQuery('#inpt').fadeOut();
                    jQuery('#Id').val(data);

                });
            }
        });
    });

function chngbkcolor2(obj) {
			  $(document).ready(function() {
				  $('#savescenariotitle').attr("class", "showhighlight_buttonleft");
				  $('#updatescenario').removeAttr("class");
				  $('#updatescenario').attr("class", "button-right-hover");

			  });
		  }
		  
		  $(".destname").keyup(function(e) {
    	console.log(e.which);
		//$("#destname").trigger('keydown');
				
      //if( e.which!=8 && e.which!=0 && (e.which<48 || e.which>57) && e.which!=13 && (e.which<96 || e.which>105))
    	  if( 
    		      	e.which!=8 && 
    		      	e.which!=0 && 
    		      	(e.which<48 || e.which>57) && 
    		      	e.which!=13 && 
    		      	e.which!=118 &&
    		      	(e.which<96 || e.which>106) &&
    		      	e.which!=37 &&
    		      	e.which!=39 &&
    		      	e.which!=17 &&
    		      	e.which!=67 &&
    				e.which!=86 &&
    				e.which!=88 &&
    		      	e.which!=46      	
    		      	)

          {      

            
        $('#overlay-error2 .error .message').text("<?php __('digitsOnly') ?>");
        $('#overlay-error2').removeClass('hide');
        return false;
      } 


      

      // else {
      // 	inValidate(validation, 'keyup', null, e);
      // }
	  
    });
</script>


<!--######## Start  Save Leave Page Event #################-->
<?php $leaveStatus = Configure :: read('leaveStatus'); ?>
<?php if ($leaveStatus[0] == "on") { ?>
    <script language="JavaScript">
        var ids = new Array('destid');
        var values = new Array('');

        function populateArrays()
        {
            // assign the default values to the items in the values array
            for (var i = 0; i < ids.length; i++)
            {
                var elem = document.getElementById(ids[i]);
                if (elem)
                    if (elem.type == 'checkbox' || elem.type == 'radio')
                        values[i] = elem.checked;
                    else
                        values[i] = elem.value;
            }
        }
        var needToConfirm = true;
        window.onbeforeunload = confirmExit;
        function confirmExit()
        {
            if (needToConfirm)
            {
                // check to see if any changes to the data entry fields have been made
                for (var i = 0; i < values.length; i++)
                {
                    var elem = document.getElementById(ids[i]);
                    if (elem)
                        if ((elem.type == 'checkbox' || elem.type == 'radio')
                                && values[i] != elem.checked)
                            return "You have attempted to leave this page.  If you have made any changes to the fields without clicking the Save button, your changes will be lost.  Are you sure you want to exit this page?";
                        else if (!(elem.type == 'checkbox' || elem.type == 'radio') &&
                                elem.value != values[i])
                            return "You have attempted to leave this page.  If you have made any changes to the fields without clicking the Save button, your changes will be lost.  Are you sure you want to exit this page?";
                }

                // no changes - return nothing      
            }
        }
    </script>
<?php } ?>

<?php  $selectedLanguage = $_SESSION['Config']['language'];
						if($selectedLanguage=='de'){
							 $popwidth = 230;
							 }
						else if($selectedLanguage=='fr') {
							 $popwidth = 110;
							 }
						else if($selectedLanguage=='it'){
							$popwidth = 110;
						}
						else if($selectedLanguage=='en'){
							 $popwidth = 110;
						}
					?>


<input type="hidden" name="odscount" id="odscount" value="<?php echo $odscount; ?>">
<input type="hidden" name="customer_id" id="customer_id" value="<?php echo $customer_id; ?>">
<input type="hidden" name="scenarioStatusId" id="scenarioStatusId" value="<?php echo $scenarioDetails[0]['Scenario']['status']; ?>"/>

<div class="update_message"></div>


<div id="overlay-error" class="notification first hide validate_msg" style="width: 98%; margin-left:5px;margin-right:5px;" >    
    <div class="error">
        <div class="message">            
        </div>
    </div>
</div>



<?php
#-----------------------------------------------------------------#
# $Rev:: 22            $:  Revision of last commit                #
#-----------------------------------------------------------------#
//echo $form->create(null, array('id' => 'LocationEditForm', 'url' => array('controller' => 'locations', 'action' => 'update/'.$location_id),'accept-charset'=>'ISO-8859-1'));


if((isset($success)) && $success){?>
	
		<div class="notification first" style="width: 534px" >		
			<div class="ok">
				<div class="message">
					<?php echo $success;?>
				</div>
			</div>
		</div>
		
	<?php }elseif(isset($error) && $error){?>
		<div class="notification first" >
			<div class="error">
				<div class="message">
					<?php 
						#echo $error;
						if($error=='xml_not_respond')
							_("Xml Server is not responding");
						else
							__("There was a problem in applying the changes.");
					?>
				</div>
			</div>
		</div>
	<?php }
		else { ?> 
		
		<div id="overlay-sucess" class="notification first hide" style="width: 98%; margin-left:5px;margin-right:5px;" >    
	    <div class="ok">
	        <div class="message">            
	        </div>
	    </div>
	</div>
		
		
		<?php  }

/*
 * Add New Scenario Page
*/
if (empty($scenarioDetails)) {
    ?>
	<script>
		$(document).ready(function() {
		$('#overlay-sucess .ok .message').text("<?php __('please add Scenario details') ?>");
		$('#overlay-sucess').removeClass('hide');
      });
	</script>
    <h4 style="margin-left:10px!important;"><?php echo __('scenarioName'); ?><?php echo $scenarioDetails[0]['Scenario']['Name'] ?>
		
		
	</h4>
    <p style="margin-left:10px;"><?php echo __('createText', true) ?>
	
    <form id="form1" class="filtersForm" action="<?php echo Configure::read('base_url'); ?>scenarios/edit/scenario_id:<?php echo $scenario_id; ?>" enctype="multipart/form-data" method="POST" invalidate="invalidate" >    
        <input type="hidden" name="scenario_id" id="scenario_id" value="<?php echo $scenario_id; ?>" />
        <br>
		<div class="black_overlay" style="height: 800px; width: 1366px; display: none;">
    </div>
        <div class="form-box">
            <div class="form-left">
                <?php
                echo '<div style="width:100px; float: left;margin-left:10px;margin-bottom:10px;">' . __('scenarioName', true) . '</div>';
                echo $form->input('Id', array('label' => false, 'value' => $scenarioDetails[0]['Scenario']['Name'], 'class' => 'scenarios form-changevalidate', 'style' => 'width:140px;','onkeyup'=>'chngbkcolor2(this)'));
                ?>
				</div>
				<div style="clear: both"></div>	
				<div class="form-left">
				<?php
				 echo '<div style="width:100px; float: left;margin-left:10px;">' . __('Remark', true) . '</div>';
                 echo $form->input('Scenario.remark', array('label' => false,'rows'=>'5','cols'=>'45', 'value' => $scenarioDetails[0]['Scenario']['remark'], 'style' => 'width:140px;', 'onkeyup' => "chngbkcolor2(this);"));
				
				
				?>	
                <div id="scenariossuccess"></div>					
            </div>
            <div class="form-box" style="margin-right: 10px;" >
                <div class="button-right" id="updatescenario">
                    
                    <a id="savescenariotitle"  href="javascript:void(0);"><?php echo __('next1NewScenario') ?></a>
                </div>

            </div>	
					            				
                    		
        </div>
    </div>
    <?php
} else {
    ?>


    <?php $scenarioStatus = Configure :: read('scenarioStatus'); ?>

    <!--   <div id="content"> -->
    <h4 style="margin-left:10px!important;margin-right:10px!important;"><?php echo __('scenarioName'); ?>  <?php echo trim($scenarioDetails[0]['Scenario']['Name']); ?>
	

        <span style="float:right;" ><?php echo __('scenarioState');?> <span id="sts"><?php echo __($scenarioStatus[$scenarioDetails[0]['Scenario']['status']], true); ?>		
        </span></span>

    </h4>

    <form id="form2" classinvalidate='classinvalidate' class="filtersForm" action="<?php echo Configure::read('base_url'); ?>scenarios/edit/scenario_id:<?php echo $scenario_id; ?>" enctype="multipart/form-data" method="POST">    
        <input type="hidden" name="scenario_id" id="scenario_id" value="<?php echo $scenario_id; ?>" />
        <br>
        <!-- 
        <div class="form-box">
               <div class="form-left">
                       
    <?php
    echo '<div style="width:100px; float: left">' . __('scenarioName', true) . '</div>';
    echo $form->input('Id', array('label' => false, 'value' => $scenarioDetails[0]['Scenario']['Name'], 'class' => 'scenarios', 'style' => 'width:150px;'));
    ?>		
                               <div id="scenariossuccess"></div>					
               </div>
               <div class="form-right">
        <?php
        echo '<div style="width:100px; float: left">' . __('Status', true) . '</div>';
        echo $form->input('Status', array('label' => false, 'value' => $scenarioStatus[$scenarioDetails[0]['Scenario']['status']], 'style' => 'width:150px;', 'readonly' => 'true'));
        ?>		
                               
               </div>				
       </div>
       
        -->
	
        <div class="form-box">
		   
               
                <div class="form-left" id="edit_stat_popupmenu" style="display: block">
                
                <div>	<span  id="edit_stat" style="margin-left:15px; float:left;cursor:default;font-weight: bold;"   <?php echo $readonly; ?>><?php __("ScenarioEditOptions"); ?> </span></div>
				<br>
	      				   <ul style="margin: 0 0 0 14px">
      
                                <?php
                                if(($userpermission == Configure::read('access_id')) && ($_SESSION['VIEWMODE'] != 'EXTERNAL') && ($scenarioDetails[0]['Scenario']['status'] >3))
                                {?>
								
								<?php 
                                if($scenarioDetails[0]['Scenario']['status'] == 4)#inactive
                                {?>	
                                <li class="schedule">
                                <?php #echo $html->link(__('addCombox', true),'');?>
                                <a href="<?php echo Configure::read('base_url');?>scenarios/edit/scenario_id:<?php echo $scenarioDetails[0]['Scenario']['id']?>&mode=operate" onMouseOver="Tip('<?php echo __('operate') ?>', BALLOON, true, ABOVE, false);" onMouseOut="UnTip(); "><?php echo __("operate", true); ?></a>    
                                </li>
                                <?php } ?>
								
                                <!--<li class="schedule">
                                
                                <a href="<?php echo Configure::read('base_url');?>scenarios/edit/scenario_id:<?php echo $scenarioDetails[0]['Scenario']['id']?>&mode=operate" onMouseOver="Tip('<?php echo __('operate') ?>', BALLOON, true, ABOVE, false);" onMouseOut="UnTip(); "><?php echo __("operate", true); ?></a>    
                                </li>-->
                                <li class="schedule">
                                	<?php #echo $html->link(__('addCombox', true),'');?>
                                	<a href="<?php echo Configure::read('base_url');?>scenarios/scriptdetails/<?php echo $scenarioDetails[0]['Scenario']['id']?>" onMouseOver="Tip('<?php echo __('viewScript') ?>', BALLOON, true, ABOVE, false);" class="fancybox fancybox.ajax" onMouseOut="UnTip(); " ><?php echo __("viewScript", true); ?></a>    
                                </li>
                                <!-- <li class="schedule">
                                	<?php #echo $html->link(__('addCombox', true),'');?>
                                	<a href="<?php echo Configure::read('base_url');?>scenarios/scriptsummary/<?php echo $scenarioDetails[0]['Scenario']['id']?>" onMouseOver="Tip('<?php echo __('viewSummary') ?>', BALLOON, true, ABOVE, false);" class="fancybox fancybox.ajax" onMouseOut="UnTip(); " ><?php echo __("viewSummary", true); ?></a>    
                                  	</li>
                                -->
                     			<?php 
                                }
                                
                                if(($scenarioDetails[0]['Scenario']['status'] == 1) ||
                                ($scenarioDetails[0]['Scenario']['status'] == 2)||
                                ($scenarioDetails[0]['Scenario']['status'] == 4)||
                                ($scenarioDetails[0]['Scenario']['status'] == 7))
                                {?>
                                <li class="schedule">
                               		<?php #echo $html->link(__('addCombox', true),'');?>
									<a class="clicker2" href="<?php echo Configure::read('base_url');?>scenarios/deleteScenario/scenario_id:<?php echo $scenarioDetails[0]['Scenario']['id']?>" onMouseOver="Tip('<?php echo __('deleteScenarioToolTip') ?>', BALLOON, true, ABOVE, false);" onMouseOut="UnTip(); " ><?php echo __("deleteScenario", true); ?></a>    
                                </li>
                               <?php } ?>
							   
							   <li class="schedule">
							   	<div style="display: none;">
								<?php
								
								
 								echo $html->link(__("addSourceDns", true), array('controller' => 'dns', 'action' => 'selectdns', "scenario_id:$scenario_id/scenario_name:$scenario_name"), array('class' => $selected['DN List'] . " fancybox fancybox.ajax", 'escape' => $readonly, 'id' => 'add_numbers','onMouseOver'=>"Tip('addSourceDns_toolTip', BALLOON, true, ABOVE, false);",'onMouseOut'=>'UnTip()'));
													
								 ?>	</div>	
								 
								  <?php 
							    if (($scenarioDetails[0]['Scenario']['status'] != '3')){    #Validate?>	
								 <?php if($scenarioDetails[0]['Scenario']['status'] == 4){ #inactive ?>
								 
								 
								 
								 <a href="javascript:;" id="addSourceDns" class="clicker3" onMouseOver="Tip('addSourceDns_toolTip', BALLOON, true, ABOVE, false);" onMouseOut="UnTip(); "><?php echo __("addSourceDns", true); ?></a>
								 <?php  } else { 
								 echo $html->link(__("addSourceDns", true), array('controller' => 'dns', 'action' => 'selectdns', "scenario_id:$scenario_id/scenario_name:$scenario_name"), array('class' => $selected['DN List'] . " fancybox fancybox.ajax", 'escape' => $readonly, 'id' => 'add_numbers','onMouseOver'=>"Tip('addSourceDns_toolTip', BALLOON, true, ABOVE, false);",'onMouseOut'=>'UnTip()'));
								 } }?>
							   </li>
							   
							   <li><?php echo $html->link( __('editScenarioName',true),array('div'=>false, 'controller'=>'scenarios', 'action'=>'editscenarioname/scenario_id:'. $scenarioDetails[0]['Scenario']['id']), array('class' => 'fancybox fancybox.ajax')); ?></li>
							   
							   
							   <?php 
							    if (($scenarioDetails[0]['Scenario']['status'] == '1') || ($scenarioDetails[0]['Scenario']['status'] == '2') || ($scenarioDetails[0]['Scenario']['status'] == '3')){    #Incomplete , Complete , Ready for Acceptance ?>
							   <li class="schedule">
							   <a href="<?php echo Configure::read('base_url');?>logs/viewlog?customer_id=&affected_obj=<?php echo $scenarioDetails[0]['Scenario']['id']; ?>&user=&log_entry=&status=&afterdate=&aftertime=&beforedate=&beforetime=&currpage=1"><?php echo __('viewScenarioHistory',true) ?></a>
							   </li>
							   <?php } else { ?>
							   <li class="schedule">
                                <?php echo $html->link(__('viewScenarioHistory', true),  array('controller'=> 'scenarios', 'action'=>'edit', 'scenario_id:'.$scenarioDetails[0]['Scenario']['id'] . '&mode=operate&view=log'));?>
                                </li>
							   <?php } ?>
                               <li>&nbsp;</li>
                            </ul>
							
<?php
/**
* 
* @Start addSourceDns Confirmation Overlay 
* 
*/
?>							
<div>		

	<div id="modalPopLite-mask" style="width:100%" class="modalPopLite-mask"></div>
	<div id="modalPopLite-wrapper" style="left: -10000px;z-index: 1;" class="modalPopLite-wrapper">
		<div class="modalPopLite-child" id="popup-wrapper3">
		<h4><?php echo __('Confirmation',true); ?>
		<div class='demonstrations1'>           
		   <div style="font-size: 18px !important;"> <a href="javascript:;"  style="cursor:pointer;" onMouseOver="Tip('<?php echo __('close_window') ?>', BALLOON, true, ABOVE, false)" onMouseOut="UnTip()" onclick="return fancyboxclose3(); UnTip();">X</a></div>		  
	        
			<div style="font-size: 18px !important;"><a href="javascript:;"  style="cursor:pointer" onMouseOver="Tip('<b><?php echo __('confirmToChangeScenario_helpTitel') ?></b><br/><?php echo __('confirmToChangeScenario_helpText') ?>', BALLOON, true, ABOVE, false)" onMouseOut="UnTip()" >?</a></div>				
    		
 </div>	
 </h4>
			<div style="width:388px; height:150px;margin:15px auto;  ">
			<h6><?php echo __('confirmToChangeScenarioTitle');?></h6> <br>
				<div class="button-left" style="margin:2px 230px 11px !important;">
				<?php echo $html->link( __("Cancle", true),'javascript:void(null)',array('id' => 'close-btn3')); ?>
				</div>
				<a href="#" id="close-btn">	</a>
					
				<div  class="button-right" style="margin:-35px 2px 10px !important">
				
				<?php echo $html->link(__("confirmToChangeScenarioInfo", true), 'javascript:void(null)', array('onclick'=>'javascript:delete_allschedule('.$scenarioDetails[0]['Scenario']['id'].')', 'id' => 'addSourceDns','class'=>'clicker3')); ?>
				</div>
							
			</div>		
		</div>
			
	</div>

</div>
							
							
							
							
	<div>
					

	<div id="modalPopLite-mask" style="width:100%" class="modalPopLite-mask"></div>
	<div id="modalPopLite-wrapper" style="left: -10000px;z-index: 1;" class="modalPopLite-wrapper">
<div class="modalPopLite-child" id="popup-wrapper2">
<h4><?php echo __('Confirmation',true); ?>
<div class='demonstrations1'>           
		   <div style="font-size: 18px !important;"> <a href="javascript:;"  style="cursor:pointer;" onMouseOver="Tip('<?php echo __('close_window') ?>', BALLOON, true, ABOVE, false)" onMouseOut="UnTip()" onclick="return fancyboxclose2(); UnTip();">X</a></div>		  
	        
			<div style="font-size: 18px !important;"><a href="javascript:;"  style="cursor:pointer" onMouseOver="Tip('<b><?php echo __('deleteScenario_helpTitel') ?></b><br/><?php echo __('deleteScenario_helpText') ?>', BALLOON, true, ABOVE, false)" onMouseOut="UnTip()" >?</a></div>				
    		
 </div></h4>	
         <div style="width:388px; height:120px;margin:15px 0px;  ">
		<h6><?php #echo __("ConfirmDeleteScenario")?>
			<?php echo __('scenarioNameToDelete') ?> <?php echo __($scenarioDetails[0]['Scenario']['Name']); ?>

		</h6> <br>
		<a href="#" id="close-btn2">
		</a>
		 <div class="button-left" style="margin:2px 230px 11px !important">
		 <?php echo $html->link( __("Cancle", true),'javascript:void(null)',array('id' => 'close-btn2')); ?>
		 
		
		</div>
		
		
		<div  class="button-right" style="margin:-35px 2px 10px !important">
			<?php echo $html->link(__("Ok", true), 'javascript:void(null)', array('onclick'=>'javascript:deletesource('.$scenarioDetails[0]['Scenario']['id'].')', 'id' => 'request_validation','class'=>'clicker')); ?>		
         </div>
				
		</div>		
	</div>
	
	
	</div>

	</div>
							
							
                </div>
				
                <div class="form-right" >
        
       		 <!--  <p><?php __('Workflow') ?></p> 
                <div>	<span  id="edit_stat" style="float:left;cursor:default;font-weight: bold;"   <?php echo $readonly; ?>><?php __("Workflow"); ?> </span></div>
				<br>
			-->
               <?php
                   $ActivateWorkflowDisplay = ($scenarioDetails[0]['Scenario']['status'] == 4) ? 'display:block;' : 'display:none;';
                   $DeActivateworkflowDisplay = ($scenarioDetails[0]['Scenario']['status'] == 6) ? 'display:block;' : 'display:none;';
                   $CRMCommentWorkflowDisplay = ($scenarioDetails[0]['Scenario']['status'] == 3) ? 'height:40px;display:block;' : 'height:40px;display:none;';
                   $CompleteWorkflowDisplay = ($scenarioDetails[0]['Scenario']['status'] == 2) ? 'display:block;' : 'display:none;';
                   $RejectWorkflowDisplay = ($scenarioDetails[0]['Scenario']['status'] == 8) ? 'display:block;' : 'display:none;';
                   $InvalidWorkflowDisplay = ($scenarioDetails[0]['Scenario']['status'] == 1) ? 'display:block;' : 'display:none;';
               ?>				
                   <p id="crm_comment_workflow" style="<?php echo $CRMCommentWorkflowDisplay; ?>"><?php __(scenarioEditWorkflowText_3) ?> </p>                           
                   <p id="complete_workflow" style="<?php echo $CompleteWorkflowDisplay; ?>"><?php __(scenarioEditWorkflowText_2) ?></p>
                   <p id="reject_workflow" style="<?php echo $RejectWorkflowDisplay; ?>"><?php __(scenarioEditWorkflowText_8) ?></p>
                   <p id="activate_workflow" style="<?php echo $ActivateWorkflowDisplay; ?>"><?php __(scenarioEditWorkflowText_4) ?></p>
                   <p id="deactivate_workflow" style="<?php echo $DeActivateworkflowDisplay; ?>"><?php __(scenarioEditWorkflowText_6) ?></p>
                   <p id="invalid_workflow" style="<?php echo $InvalidWorkflowDisplay; ?>">
				   <?php $scenarioInfo =  __('scenarioEditWorkflowText_1',true);
				   		 echo  substr($scenarioInfo, 0, 475);
						 if(strlen($scenarioInfo)>475) { 
							$scenarioInfo2 = str_replace('"','',$scenarioInfo);
							$scenarioInfo2 = substr($scenarioInfo2, 470, strlen($scenarioInfo2));
							$scenarioInfo2 = wordwrap($scenarioInfo2,40,"<br>");

?>
           <?php ?>
						<a href="javascript:;" onclick="Tip('<?php echo __($scenarioInfo2); ?>', BALLOON, true, ABOVE, false);" onMouseOut="UnTip(); " >...</a>
						 
						<?php  } ?>
				    
				   	
					
				   </p>	            
			</div>
				
				<?php /* ?>
                <div class="form-right">
        
       			 <!--  <p><?php __('Workflow') ?></p> -->

               <?php
                   $ActivateWorkflowDisplay = ($scenarioDetails[0]['Scenario']['status'] == 4) ? 'display:block;' : 'display:none;';
                   $DeActivateworkflowDisplay = ($scenarioDetails[0]['Scenario']['status'] == 6) ? 'display:block;' : 'display:none;';
                   $CRMCommentWorkflowDisplay = ($scenarioDetails[0]['Scenario']['status'] == 3) ? 'height:120px;display:block;' : 'height:120px;display:none;';
                   $CompleteWorkflowDisplay = ($scenarioDetails[0]['Scenario']['status'] == 2) ? 'display:block;' : 'display:none;';
                   $RejectWorkflowDisplay = ($scenarioDetails[0]['Scenario']['status'] == 8) ? 'display:block;' : 'display:none;';
                   $InvalidWorkflowDisplay = ($scenarioDetails[0]['Scenario']['status'] == 1) ? 'display:block;' : 'display:none;';
               ?>				
                   <p id="crm_comment_workflow" style="<?php echo $CRMCommentWorkflowDisplay; ?>"><?php __(scenarioEditWorkflowText_3) ?></p>                           
                   <p id="complete_workflow" style="<?php echo $CompleteWorkflowDisplay; ?>"><?php __(scenarioEditWorkflowText_2) ?></p>
                   <p id="reject_workflow" style="<?php echo $RejectWorkflowDisplay; ?>"><?php __(scenarioEditWorkflowText_8) ?></p>
                   <p id="activate_workflow" style="<?php echo $ActivateWorkflowDisplay; ?>"><?php __(scenarioEditWorkflowText_4) ?></p>
                   <p id="deactivate_workflow" style="<?php echo $DeActivateworkflowDisplay; ?>"><?php __(scenarioEditWorkflowText_6) ?></p>
                   <p id="invalid_workflow" style="<?php echo $InvalidWorkflowDisplay; ?>"><?php __(scenarioEditWorkflowText_1) ?></p>	            
			</div>
			<?php */ ?>
		</div>

        <!-- Display buttons for actions -->
        <?php
        #$ActivateButtonDisplay = ($scenarioDetails[0]['Scenario']['status'] == 4) ? 'display:block;' : 'display:none;';
        #$DeActivateButtonDisplay = ($scenarioDetails[0]['Scenario']['status'] == 6) ? 'display:block;' : 'display:none;';
        $ActivateButtonDisplay ='display:none;';
        $DeActivateButtonDisplay = 'display:none;';
        
        $CRMCommentDisplay = ($scenarioDetails[0]['Scenario']['status'] == 3) ? 'height:120px;display:block;' : 'height:120px;display:none;';
        $RequestForValidateButtonDisplay = (($scenarioDetails[0]['Scenario']['status'] == 2) || ( $scenarioDetails[0]['Scenario']['status'] == 8)) ? 'display:block;' : 'display:none;';
        ?>					
        <div class="form-box" style="<?php echo $CRMCommentDisplay; ?>" id="crm_comment_div">
            <?php if (($userpermission == Configure::read('access_id')) &&  ($_SESSION['VIEWMODE'] != 'EXTERNAL')) {
                ?>
                <div class="form-left">

                    <?php echo '<div style="width:200px; float: left; margin-left:15px;">' . __('SCM Comment', true) . '</div>';
                    echo $form->input('Log.modification_response', array('type' => 'textarea', 'class' => 'date-pick', 'style' => 'margin:4px 4px 5px 20px;width:220px;', 'label' => false, 'div' => false, 'id' => 'crm_comment_option', 'value' => '', 'default' => ''));
                    ?>
					
					<div style="float:left!important;margin-left:10px;">
					<div class="button-right" >
                        <?php echo $html->link(__("Accept", true), 'javascript:saveToLog("accepted")', array('onmouseover' => 'hoverButtonRight(this)', 'onmouseout' => 'outButtonRight(this)')); ?>
                    </div>

                    <div class="button-right">
                        <?php echo $html->link(__("Reject", true), 'javascript:saveToLog("rejected")', array('onmouseover' => 'hoverButtonRight(this)', 'onmouseout' => 'outButtonRight(this)')); ?>
                    </div>
					</div>
					
                </div>
               <!-- <div class="form-right">
                    <div class="button-right">
                        <?php echo $html->link(__("Accept", true), 'javascript:saveToLog("accepted")', array('onmouseover' => 'hoverButtonRight(this)', 'onmouseout' => 'outButtonRight(this)')); ?>
                    </div>

                    <div class="button-right">
                        <?php echo $html->link(__("Reject", true), 'javascript:saveToLog("rejected")', array('onmouseover' => 'hoverButtonRight(this)', 'onmouseout' => 'outButtonRight(this)')); ?>
                    </div>
                </div>-->
                <?php }
            ?>
        </div>   
        <div id="request_validationdiv" class="form-box" style="<?php echo $RequestForValidateButtonDisplay; ?>" >
            <div class="form-left">
                <div class="button-right">
                    <?php echo '' ?>
                </div>
            </div>
            <div class="form-right">
                <div class="button-right">
                    <?php //echo $html->link(__("Request Validation", true), 'javascript:saveToLog("validate_request")', array('onmouseover' => 'hoverButtonRight(this)', 'onclick'=>"return confirm('Are you sure want to request validation');",'onmouseout' => 'outButtonRight(this)', 'id' => 'request_validation')); ?>	
     				<?php echo $html->link(__("Request Validation", true), 'javascript:void(null)', array('onmouseover' => 'hoverButtonRight(this)','onmouseout' => 'outButtonRight(this)','class'=>'clicker')); ?>	
                </div>
				<div>
					<div id="modalPopLite-mask" style="width:100%" class="modalPopLite-mask"></div>
					<div id="modalPopLite-wrapper" style="left: -10000px;z-index: 1;" class="modalPopLite-wrapper">
						<div class="modalPopLite-child" id="popup-wrapper">
						  <h4><?php echo __('Confirmation',true); ?>
							<div class='demonstrations1'>           
		   						<div style="font-size: 18px !important;"> <a href="javascript:;"  style="cursor:pointer;" onMouseOver="Tip('<?php echo __('close_window') ?>', BALLOON, true, ABOVE, false)" onMouseOut="UnTip()" onclick="return fancyboxclose(); UnTip();">X</a></div>		  
								<div style="font-size: 18px !important;"><a href="javascript:;"  style="cursor:pointer" onMouseOver="Tip('<b><?php echo __('confirmDeleteScenario_helpTitel') ?></b><br/><?php echo __('confirmDeleteScenario_helpText') ?>', BALLOON, true, ABOVE, false)" onMouseOut="UnTip()" >?</a></div>				
  							</div>
  						  </h4>
         				<div style="width:388px; height:190px;margin:15px 0px;">
							<p><?php echo __("Are you sure want to request validation ?", true);?></p> <br>
		 					<a href="#" id="close-btn"></a>
							<div class="button-left" style="margin:2px 230px 11px !important">
								
							<?php echo $html->link( __("Cancle", true),'javascript:void(null)',array('id' => 'close-btn')); ?>
							</div>
								
							<div  class="button-right" style="margin:-35px 2px 10px !important" >
								<?php echo $html->link(__("Ok", true), 'javascript:void(null)', array('onclick'=>'javascript:saveToLog("validate_request")', 'id' => 'request_validation','class'=>'clicker')); ?>
        					</div>
						</div>		
					</div>
				</div>
			 </div>
            </div>
        </div>					  	
        <div class="form-box" style="<?php echo $ActivateButtonDisplay; ?>" id="activationdiv">
            <div class="form-left">
                <p></p>	
            </div>
            <div class="form-right">
                <div class="button-right">
                    <?php 
                    #echo $html->link(__("Activate", true), array('controller' => 'scenarios', 'action' => 'create_schedule/' . $scenario_id . '/create/' . $SELECTED_CUSTOMER . '/0/activate'), array('class' => "fancybox fancybox.ajax", 'onmouseover' => 'hoverButtonRight(this)', 'onmouseout' => 'outButtonRight(this)')); 	
					echo $html->link( __("Activate", true),array('controller'=>'scenarios', 'action'=>'confirmapply?scenario_id='.$scenario['Scenario']['id'].'&operation=activate'), array('class'=>"fancybox fancybox.ajax",'id'=>'activateScenario'));
					?>		
                </div>
                <div class="button-right">
                    <?php 
                    echo $html->link(__("View Script", true), array('controller' => 'scenarios', 'action' => 'scriptdetails/' . $scenarioDetails[0]['Scenario']['id']), array('class' => "fancybox fancybox.ajax")); 
                    ?>									  
                </div>	

            </div>
        </div>

        <div class="form-box" style="<?php echo $DeActivateButtonDisplay; ?>" id="deactivationdiv">
            <div class="form-left">
                <p></p>	
            </div>
            <div class="form-right">
                <div class="button-right">
                    <?php 
                    #echo $html->link(__("De-activate", true), array('controller' => 'scenarios', 'action' => 'create_schedule/' . $scenario_id . '/create/' . $SELECTED_CUSTOMER . '/0/deactivate'), array('class' => "fancybox fancybox.ajax", 'onmouseover' => 'hoverButtonRight(this)', 'onmouseout' => 'outButtonRight(this)')); 
                    echo $html->link( __("De-activate", true),array('controller'=>'scenarios', 'action'=>'confirmapply?scenario_id='.$scenario['Scenario']['id'].'&operation=deactivate'), array('class'=>"fancybox fancybox.ajax",'id'=>'deactivateScenario'));
                
                    ?>	
                </div>
            </div>
        </div>	

        <!-- <div class="form-box" >
        <div class="button-right">
                <a id="savescenariotitle" onmouseout="outButtonRight(this)" onmouseover="hoverButtonRight(this)" href="javascript:void(0);">Save</a>
        </div>
    </div>	
        -->	
        <!-- End of Display buttons for actions -->

          <div style="display:block">
            <h4 style="margin-left:10px!important;margin-right:10px!important;"> <?php echo __('scenarioDetail'); ?> <a class="maintopRelatedContentButton" id="maintopContentButton" onclick="return toggleodsentries();" href="javascript:void(0)" style="float:right;">
                    <div style="width:20px;background:#eee; height:20px;" id="pbtn_ods">
                        <div id="plus_ods"></div>
                    </div>
                    <div style="width:20px;background:#eee; height:20px;" id="mbtn_ods">
                        <div id="minus_ods"></div>
                    </div>
                </a>	</h4> 					

        </div>	 	       	
        <?php
        #Check to see whether can edit ODS entries or not.
        #if(($scenarioDetails[0]['Scenario']['status'] == 3) || ($scenarioDetails[0]['Scenario']['status'] == 6) || ($scenarioDetails[0]['Scenario']['status'] == 7)){
        $show = 'block';
        #if (($scenarioDetails[0]['Scenario']['status'] == 1) || ($scenarioDetails[0]['Scenario']['status'] == 2) || ($scenarioDetails[0]['Scenario']['status'] == 3)) {

         #   $show = 'block';
        #}
        if (($scenarioDetails[0]['Scenario']['status'] == 5) || ($scenarioDetails[0]['Scenario']['status'] == 6) || ($scenarioDetails[0]['Scenario']['status'] == 7)) {
            $readonly = 'true';
        }
        ?>		<!--   -->

        <div id="showods" style="display:<?php echo $show; ?>">
            <div style="margin:10px;">
                <a class="maintopRelatedContentButton" id="maintopContentButton" onclick="return toggleAdvanceSearch();" href="javascript:void(0)"><?php //__('Advanced Filter') ?></a>
            </div>


<?php $odscount = count($odsEntryList); 
		if($odscount >0){
	 ?>



    <?php
    if (isset($advancedFlag)) {
        ?>	
                <div class="form-box" style="display:block">
                <?php
            } else {
                ?>
                   <div id="advancesearch" class="form-box" style="display:non;margin-left:5px;">
                <?php }
            ?>
<?php  $selectedLanguage = $_SESSION['Config']['language'];
						if($selectedLanguage=='de'){
							 $width = 220;
							 $rangeminwidth = 181;
							 $rangemaxwidth = 145;
							 $filterwidth = 77;
							 
							 $tablewidth=70;
							 
							 }
						else if($selectedLanguage=='fr') {
							 $width = 183;
							 $rangeminwidth = 181;
							 $rangemaxwidth = 145;
							 $filterwidth = 77;
							 
							 $tablewidth=60;
							 }
						else if($selectedLanguage=='it'){
							$width = 146;
							 $rangeminwidth = 181;
							 $rangemaxwidth = 145;
							 $filterwidth = 77;
							 
							 $tablewidth=60;
							 
						}
						else if($selectedLanguage=='en'){
							 $width = 146;
							 $rangeminwidth = 181;
							 $rangemaxwidth = 145;
							 $filterwidth = 77;
							 
							 $tablewidth=60;
						}
					?>

			
			
			<!-- 
               <div class="form-left" style="margin-left: 0px;width:<?php echo $rangeminwidth;  ?>px !important">
                <?php
                echo '<div style="width:85px; float: left">' . __('rangeMin', true) . '</div>';
                echo $form->input('rangeMin.minval', array('style' => 'margin:1px 4px 5px 8px; width:70px !important;', 'label' => false, 'class' => 'filter_range_textbox', 'div' => false, 'maxlength' => '9', 'value' => $rangeMinval));
                ?>
                    </div>						
                    <div class="form-right" style="margin-left: 0px;width:<?php echo $rangemaxwidth; ?>px !important">
                        <?php
                        echo '<div style="width:56px; float: left">' . __('rangeMax', true) . '</div>';
                        echo $form->input('rangeMax.maxval', array('style' => 'margin:1px 4px 5px 8px; width:70px !important;', 'label' => false, 'class' => 'filter_range_textbox', 'div' => false, 'maxlength' => '9', 'value' => $rangeMaxval));
                        ?>		

                    </div>
				<div class="form-left" style="width: <?php echo $width; ?>px !important; margin-top: -9px!important" >
                    <div class="button-right" id="reset_filter">
                        <a id="reset_filter" href="javascript:void(0);" onmouseout="outButtonRight(this)" onmouseover="hoverButtonRight(this)"><?php __('Clear') ?></a>
                    </div>	
					<div class="button-right" id="filter_now">
                        <a id="filter_now" href="javascript:void(0);" onmouseout="outButtonRight(this)" onmouseover="hoverButtonRight(this)"><?php echo __('filter'); ?></a>
                    </div>												
                    
				</div>
				
				-->
				
                </div>
                   <div id="edit_stat_popupmenu" style="display:non ">
                      <div id="shortcontloc" class="scontloc" style="display: ;margin-left: 5px;">
					 
					  
					  	<?php if(isset($blockOptions))
					  	{
					  	echo __('DN Range Filter');?>
					    <div class="form-box">
 							<div class="form-left">
                                <?php echo $form->input('block_id', array('label' => false,'type'=>'select', 'options'=>$blockOptions, 'id' => 'blockSelect', 'default'=>$block_id,'style'=>'width:206px; float: left','onchange'=>"javascript:submitBlockFilter();")); ?>
					
                            </div>
                            <div style="width:206px" class="form-right">
                               <p><?php echo __('largeDataSet_blurb')?></p>	
                            </div>
 							
 													
 						 </div>	
 						 <?php } # end large dataset?>
 						 
                        </div>
						
 					  </div>	                       

                <div class="block" style="margin: 0px;">
                 <?php $scenario_name = $scenarioDetails[0]['Scenario']['Name']; ?>
  
                </div>		
                <div class="clear"></div>
                <!-- <div class="button-left"> -->
                <!-- <div style="float:left"> -->
                <div style="padding-left: 5px">
                   <!-- <a href="javascript:void(null)" id="edit_selected_scenario"  onclick="submenuactivity(this, 1)"  <?php echo $readonly; ?>><?php __("editSelected"); ?> </a>	-->				
                    <div class="table-menu" id="edit_selected_scenario_popupmenu">
                        <div class="table-menu-popup" id="table-popup" style="z-index: 1">
                            <ul>
                                <li class="schedule">										
                                   <?php echo $html->link(__("Edit", true), array('controller' => 'scenarios', 'action' => 'opendestupdateview?scenario_id:' . $scenario_id), array('class' => "fancybox fancybox.ajax")); ?>
                                </li>
                                <li class="activate">												
                                    <a class="deldest" href="javascript:void(0);">Delete Selected</a>										
                                </li>
                            </ul>
                        </div>
                    </div>				

                </div>
                <ul class="search_btn_area">
                </ul>
                <div class="clear"></div>	
                <!--<div class="counter" style="font-weight:bold">0: records are selected</div>-->	<br/>

						
						<?php echo $javascript->link('/js/jquery.dataTables.min'); ?>
							<div id="updatehtml">
							<div id="reloadwholdpagedata" style="margin-left: 10px!important;margin-right: 10px!important;">
							
							<div class="clear"></div>
							<div id="" class="table-content">
							<table id="myTable7" class="dataTable phonekey" cellpadding="0" cellspacing="0" style="width:98%; border:1px solid #ccc !important; margin-left:5px; border-top-color:#CCC">
					
							  <thead>
							  
								<tr class="tablesorter-filter-row78">
										<td>&nbsp;</td>
										<td><input style="width:93%;" type="text" id="search_source" ></td>
										<td><input style="width:93%;" type="text" id="search_dest" ></td>
										<td>
										
											<select id="search_state" style="width:93%; !important;margin-left:5px;float:left;margin-right:4px;">
												<option></option>
												<option value="<?php echo __('Valid',true); ?>"><?php echo __('Valid',true); ?></option>
												<option value="<?php echo __('Invalid',true); ?>"><?php echo __('Invalid',true); ?></option>
											</select>
										</td>
									</tr>
									
								<tr class="table-top" style=" border:1px solid #ccc !important; border-bottom:#D1D1D1 1px solid; border-right: 1px solid #D1D1D1;border-top:#D1D1D1 1px solid;">
								  <!--<th class="table-column table-left-ohne withdatatablecss">&nbsp;</th>-->
								  <th align="left" style=" width: 10px !important;border-right: 1px solid rgb(209, 209, 209) ! important;"  class="table-left-ohne" ><input type="checkbox" name="sAll" id="checkAll" class="showselect" style=" margin-top: 6px !important;margin-left:10px !important; width: 20px!important"></th>
								  <th style="width:95px !important;border-right: 1px solid rgb(209, 209, 209) ! important;" align="left"  class="table-column dosorting " style="margin-top: -2px;"><a href="javascript:void(0);"><?php echo __('Source'); ?></a></th>
								  <th style="width:120px !important;border-right: 1px solid rgb(209, 209, 209) ! important;" align="left"  class="table-column filter-select filter-parsed  dosorting" data-placeholder=""><a href="javascript:void(0);"><?php echo __('Dest'); ?></a></th>
									<?php
								   if ($scenarioDetails[0]['Scenario']['status'] == 3){?>
								  
								  
								  <th width="129px !important" align="left" class="table-column filter-select filter-exact dosorting" data-placeholder=""><a href="javascript:void(0);"><?php echo __('odsConfig'); ?></a></th>
									 <?php }else{?>
								   <th width="129px !important" align="left" class="table-column filter-select filter-exact dosorting" data-placeholder=""><a href="javascript:void(0);"><?php echo __('State'); ?></a></th>
								 <?php } ?>
								 
								  
								  <!--   <th class="table-column table-right-ohne withdatatablecss" style="width:50px!important;">&nbsp;</th> -->
								  <!--<th class="table-column table-right-ohne" style="border-bottom:#CCCCCC 1px solid;border-top:#CCCCCC 1px solid;">&nbsp;</th>-->
								</tr>
							  </thead>
                    
							<tbody id="reloadme" >
							</tbody>
							</table>
							</div>
							
							<!-- Badal Singh -->
							<script>
							
							//$(document).ready(function() {
							
							//});
							
							
							var indext = 3;
							populate();
							//alert('dddd');
							function populate()
							{
								//alert('dddd');
								
								$.fancybox.showLoading();
								//$('.black_overlay_update').show();
								
								
								
								console.time('populate');
								var t = $('#myTable7').dataTable({
								
								'bDestroy': true,
									"bInfo": true,
									"bFilter": true,
									"sDom":"lrtip",
									"bProcessing": true,
									"bDeferRender": true,
									"search" : false,
									'iDisplayLength': 10,
									'sPaginationType': 'full_numbers',
									'sDom': '<"top"i> T<"clear">lfrtip',
									'sPageButtonActive': "paginate_active",
									'sPageButtonStaticDisabled': "paginate_button",
									
									"bJQueryUI": true,
									"bAutoWidth": false , 
									"columns": [
										null,
										{ "orderDataType": "dom-text-numeric" },
										{ "orderDataType": "dom-text", type: 'string' },
										{ "orderDataType": "dom-select" }
									],
									"oLanguage": {
										"sZeroRecords":"<?php echo __("noMatching"); ?>",
										"sSearch": "Futher Filter Search results:",
										"sInfo": "Got a total of _TOTAL_ results to show (_START_ to _END_)",
										"sLengthMenu": '<div style="float:left;margin-left:5px;"><?php echo __("totalEntries")?>&nbsp;</div> <div id="counter" style="float:left;"></div> '+
										'<div style="float:left;margin-left:5px;"><?php echo __("entriesPerPage"); ?>' +
										'<select style="margin-top:-1px;width:53px;">' +


										'<option value="10">10</option>' +
										'<option value="25">25</option>' +
										'<option value="50">50</option>' +
										'<option value="100">100</option>' +
										'</select></div><br />'
											},
											"bSort": true,
										
									'fnDrawCallback': function(oSettings) {
									
										if ($("#checkAll").is(':checked')) {
											$('.odsentchk').prop("checked", "checked");
											
												
										}
									},
									"fnFooterCallback": function (nRow, aaData, iStart, iEnd, aiDisplay) {
									
										var total = 0;
										 var seldnids = '';
										 var dnIdCount = 0;
										 var breakWordCheck;
										 var dn_id;
										 var functiondropdown = [];
										 
										var selectedval = $('#msds-select-function').val();
										//alert(selectedval);
										
										for (var i = 0; i < aiDisplay.length; i++) {
											
											
											//functiondropdown += "<option value='"+aaData[aiDisplay[i]][3]+"'>"+aaData[aiDisplay[i]][3]+"</option>";
											
											functiondropdown.push(aaData[aiDisplay[i]][3]);
											
											var getId = aaData[aiDisplay[i]][1] * 1;												
											
											
											breakWordCheck = dnIdCount % 5 ;
											if(breakWordCheck == 0){										
												dn_id = getId;
												seldnids += dn_id + ','+'</br>';								
											}
											else{										
												dn_id = getId;						
												seldnids += dn_id + ',';	
											}
											
											dnIdCount++;
									
										
											//total += number;
										}
										
										if (functiondropdown instanceof Array) 
										{
										
											var uniqueNames = [];
											$.each(functiondropdown, function(i, el){
												if($.inArray(el, uniqueNames) === -1) uniqueNames.push(el);
											});
											
											functionuniquearray = "<option></option>";
											
											for(i=0; i<= uniqueNames.length; i++){	
												
												if(!uniqueNames[i]) continue;
												
												selected = "";
												if(uniqueNames[i] == selectedval) selected = "selected"; 
												//alert(uniqueNames[i]);
												functionuniquearray += "<option "+selected+" value='"+uniqueNames[i]+"'>"+uniqueNames[i]+"</option>";
											}
											
											//alert(functionuniquearray);
											
											//$("#msds-select-function").html(functionuniquearray);
											//$("#msds-select-function").val("");
										}
										
										
										
										//alert(uniqueNames);

										$("#IDS").val(seldnids);
										$("#IDSSAVE").val(seldnids);
										
									},
									"fnInfoCallback": function( oSettings, iStart, iEnd, iMax, iTotal, sPre ) {
									   									   
									    iPage = oSettings._iDisplayLength === -1 ? 1: Math.ceil( oSettings._iDisplayStart / oSettings._iDisplayLength );
										
										iTotalPages =  oSettings._iDisplayLength === -1 ?  1 : Math.ceil( oSettings.fnRecordsDisplay() / oSettings._iDisplayLength );
;
									    $('#myTable7_paginate span').html(' <?php __('Page'); ?> <input class="GoOnTargetPage12" id="pagenumber" maxlength="maxlength" style="width:25px;text-align:center;float: inherit;" type="text" value="' + (iPage+1) + '" /> <?php echo __('Of') ?> ' + iTotalPages);
									  
									    $('div#counter').html(iTotal);
										//$("#chknumber").val(iTotal);
										
										count = 0;
										$('.odsentchk').each(function() {
											if ($(this).is(':checked')) {
												count++;
											}
										});
										
										//alert('ddd');
										
										$("#chknumber").val(count);
										
										if ($("#checkAll").is(':checked')) {
											
											//$('.odsentchk').bind('click', function() {  });
											getval = $("#chknumber").val();
											//if(iTotal == getval)
											//$('.cnt').text("<?php echo __('Update Selected'); ?> : " + (iTotal));
										}
										
										$('.cnt').text("<?php echo __('Update Selected'); ?> : " + (count));
										
									   /*
									   perPage = iEnd - iStart + 1;
									   
									   //alert(perPage);
									   totalRatio = iTotal/perPage;
									   intTotalRatio = parseInt(totalRatio, 10);
									   totalPages = totalRatio > intTotalRatio ? intTotalRatio + 1 : intTotalRatio;
									   currentRatio = iStart/perPage;
									   intCurrentRatio = parseInt(currentRatio, 10);
									   currentPage = currentRatio > intCurrentRatio ? intCurrentRatio + 1 : intCurrentRatio;
									   //alert('Displaying ' + currentPage + ' of ' + totalPages + ' pages');
									   
									   if(iEnd == iTotal){
										//totalPages--;
									   }
									   
									  // alert(totalPages);
									   
									   $('#myTable7_paginate span').html(' Page <input class="GoOnTargetPage12" id="pagenumber" maxlength="maxlength" style="width:25px;text-align:center;float: inherit;" type="text" value="' + currentPage + '" /> of ' + totalPages);
									  
									    $('div#counter').html(iTotal);
										
										$('.cnt').text("<?php echo __('Update Selected'); ?> : " + (iTotal));
										$("#chknumber").val(iTotal);
										*/
										//$('#myTable7_paginate span').html(" Paging ");
										
										
										$("#myTable7_first").removeClass("ui-state-default");	
										$("#myTable7_previous").removeClass("ui-state-default");	
										
										$("#myTable7_next").removeClass("ui-state-default");	
										$("#myTable7_last").removeClass("ui-state-default");	
									}
									
								}
								) ;								
								

								
								var jArray = <?php echo $jsonodsEntryList; ?>;
								var IDS = "";
								var countlength = "<?php echo count($odsEntryList ); ?>";
								
								
								 var seldnids = '';
								 var dnIdCount = 0;
								 var breakWordCheck;
								 var dn_id;
							
								for (var irow = 0; irow < countlength; irow++)   
								{
									indext = 3;
									var cells = new Array();
									//var r = jQuery('<tr  id=' + irow + '>');
									//for (var icol = 0; icol < 1; icol ++)
									
									odsentry_id = jArray[irow]['Odsentry']['id'];
									source =  jArray[irow]['Odsentry']['source'];
									dest =  jArray[irow]['Odsentry']['dest'];
									PerformDisable = '<?php echo $PerformDisable; ?>';
									readonlytextbox =  '<?php echo $readonlytextbox; ?>';
									
									cells[0] = '<input type="checkbox" onclick="odsentchk_check(this)" name="a'+odsentry_id+'" value="'+odsentry_id+'" id="chk'+odsentry_id+'" style="margin-left:10px !important;margin-bottom: 3px!important;" />';
									cells[1] = source;
									
									if (PerformDisable == 1) 
									{
										if(dest == null){
											dest = "";
										}
										cells[2] = '<input class="space_check  numeric_check destname"  autocomplete="off" customid="'+odsentry_id+'"  id="d'+odsentry_id+'" name="'+source+'" type="text" value="'+dest+'" style="vertical-align: middle;padding-bottom:3px;  " size="13" '+readonlytextbox+' ><span style="display:none;" id="updatechk'+odsentry_id+'" >'+dest+'</span>';
        								
									} 
									else {
											if(dest == null){
												dest = "";
											}
										
                                          cells[2] = '<input  onkeyup="chngbkcolor(this);" class="space_check  numeric_check destname" customid="'+odsentry_id+'" onkeyup="chngbkcolor(this);"  autocomplete="off" id="d'+odsentry_id+'" name="'+source+'" style="vertical-align: middle;padding-bottom:3px;" type="text" value="'+dest+'" size="13" '+readonlytextbox+'><span id="updatechk'+odsentry_id+'" style="display:none;">'+dest+'</span>';
                                    }
									
									
								    valid = '<?php __('Valid',true); ?>';
                                    invalid = '<?php __('Invalid',true); ?>';
									
									if (jArray[0]['Scenario']['status'] == 3){
										cells[3] = '<span class="sc_state_medium'+odsentry_id+'" >'+jArray[irow]['Odsentry']['config']+'</span>';
									}
									else{
										cells[3] = '<span class="sc_state_medium'+odsentry_id+'" >'+jArray[irow]['Odsentry']['dest1']+'</span>';
									}
									 
									var ai = t.fnAddData(cells,false);
								}
							
							//alert(t.fnGetData().length);
								t.fnDraw();
								console.timeEnd('populate');
								
								
								//$.fancybox.hideLoading();
								//$('.black_overlay_update').hide();

								//$.fancybox.hideLoading();
								
								
								setTimeout(function(){
									$('#fancybox-loading').hide();
									$('.black_overlay_update').hide();								
								}, 2000);
								
								
							}
							
							  var oTable;
							  oTable = $('#myTable7').dataTable();
							  
							$('#search_source').keyup( function() { 									
									oTable.fnFilter( $(this).val(),1); 
									
									//checkboxall();
									oTable.fnDraw();
							});
							$('#search_dest').keyup( function() { 									
								oTable.fnFilter( $(this).val(),2); 
								
								//checkboxall();
								oTable.fnDraw();
						   });  
							$('#search_state').change( function() { 
									//alert($(this).val());'=' + filterValue + '='
									filterValue = $(this).val();
									if(filterValue != ""){
										oTable.fnFilter("^"+$(this).val()+"$",3, true); 
									}else{
										oTable.fnFilter($(this).val(),3); 
									}
									//checkboxall();
									oTable.fnDraw();
							 });   
							 
							 $("#myTable7_filter").hide();
							
							$("#myTable7_first").text("<<");	
							$("#myTable7_previous").text(" <");	
							
							$("#myTable7_next").text(" >");	
							$("#myTable7_last").text(" >>");
							
							
							
							</script>
							
							<!-- End of script Badal Singh -->
						</div>
						</div>
						
                            <?php }  ?>
							
							
							<?php 
							if($scenarioDetails[0]['Scenario']['status'] != 6)
							{
							?>
							<div class="button-right-hover" style="margin-top: 2px;!important;">
            				<?php
 								//echo $html->link(__("addSourceDns", true), array('controller' => 'dns', 'action' => 'selectdns', "scenario_id:$scenario_id/scenario_name:$scenario_name"), array('class' => $selected['DN List'] . " fancybox fancybox.ajax showhighlight_buttonleft", 'escape' => $readonly, 'id' => 'add_numbers')); ?>		
                    		</div>
                    		<?php 
							}
							?>
					<input type="hidden" name="getallIDS"  id = "getallids"/>
					<div class="" style="margin-top:35px;" >
						<!--<div class="cnt" style="display: inline;margin-left:5px; margin-top: -20px;"></div>-->
						<div class="counter" style="font-weight:normal">0: records are selected</div>
							<?php if ($scenarioDetails[0]['Scenario']['status'] == 3){?>
							<div id="updateselected" class="button-left-hover" style="margin: -12px 2px 11px !important;">
                            <?php echo $html->link(__("editConfigEntries", true), array('controller' => 'scenarios', 'action' => 'openconfigupdateview?scenario_id:' . $scenario_id), array('class' => $selected['DN List'] . " fancybox fancybox.ajax cntchk_updatemsg2 showhighlight_buttonright")); ?> 
							</div>
							<?php }  //if ($scenarioDetails[0]['Scenario']['status'] != 2){?> 
							<div id="updateselected" class="button-left-hover" style="margin: -12px 2px 11px !important;">
                            <?php echo $html->link(__("editSelectedOdsEntries", true), array('controller' => 'scenarios', 'action' => 'opendestupdateview?scenario_id:' . $scenario_id), array('class' => $selected['DN List'] . " fancybox fancybox.ajax cntchk_updatemsg2 showhighlight_buttonright")); ?> 
							</div>
                             <?php //} ?>
							 <div id="updateselected" class="button-left-hover" style="margin: -12px 2px 11px !important;">
                            <?php echo $html->link(__("deleteSelectedOdsEntries", true), 'javascript:void(0)', array('class' => $selected['DN List'] . "  deldest showhighlight_buttonright clicker4")); ?> 
							</div>
							 
							 <div class="button-right-disabled" id="updateOdsentry" style="margin: -11px 5px 10px !important;">
                        <a id="savedestinations" href="javascript:void(0);"><?php echo __('saveNewScenario'); ?></a>										
                    </div>
							 
							 
                        </div><br/>
<?php
/**
* 
* @ Start Multiple delete confirmation Overlay (#deleteSelectedOdsEntries)
* 
*/
?>						
  <div>				
	<div id="modalPopLite-mask" style="width:100%" class="modalPopLite-mask"></div>
	<div id="modalPopLite-wrapper" style="left: -10000px; z-index: 1;" class="modalPopLite-wrapper">
		<div class="modalPopLite-child" id="popup-wrapper4">
			<h4><?php echo __('Confirmation',true); ?>
			<div class='demonstrations1'>           
		   		<div style="font-size: 18px !important;"> <a href="javascript:;"  style="cursor:pointer;" onMouseOver="Tip('<?php echo __('close_window') ?>', BALLOON, true, ABOVE, false)" onMouseOut="UnTip()" onclick="return fancyboxclose4(); UnTip();">X</a></div>		  
				<div style="font-size: 18px !important;"><a href="javascript:;"  style="cursor:pointer" onMouseOver="Tip('<b><?php echo __('confirmDeleteScenario_helpTitel') ?></b><br/><?php echo __('confirmDeleteScenario_helpText') ?>', BALLOON, true, ABOVE, false)" onMouseOut="UnTip()" >?</a></div>				
  			</div></h4>
	         <div style="width:385px; height:110px;margin:15px 0px;  ">
				<h6><?php echo __("confirmDelete", true);?></h6> <br>
			 	<div class="button-left" style="margin:2px 230px 11px !important">
					<?php echo $html->link( __("Cancle", true),'javascript:void(null)',array('id' => 'close-btn4')); ?>
				</div>
				<a href="#" id="close-btn4"></a>
				<div  class="button-right" style="margin:-35px 2px 10px !important;" >
					
					<?php echo $html->link(__("Ok", true), 'javascript:void(null)', array('id' => 'deleteSelectedOdsEntries','class'=>'clicker4 deldest2')); ?>
		        </div>
			</div>		
		</div>
	</div>
  </div>					
</div>
            <!-- START OPERATE SECTION  -->
            <!-- DELETED -->
            <!-- END COMMENTED OPERATE SECTION -->
</div>
         <?php } # End of new sceanrio filter ?>
        <div class="black_overlaysaveOdsentry" style="height:1220px; width: 1366px; display: none;">
            <div id="black_overlay_loading">
                <img alt="" src="../../img/assets/ajax-loader.gif">
            </div>
        </div>
        <div id="related-content">
            <div class="box start link">
                <a href="#">
                   <?php __('Home Swisscom') ?>
                </a>
            </div>
            <!-- mgi 30.5. temp
            <div class="box info">
                <h3><?php __('Scenario Edit') ?></h3>
                <p><?php __('This page is a Scenario Edit page allowing users to edit specific scenarios') ?></p>
            </div>
            -->
            <div class="box">
        	   <h3><?php __('Scenario Edit'); ?></h3>
                 <p><?php __('This page is a Scenario Edit page allowing users to edit specific scenarios') ?></p>
			   <div id="shortcont"><a href="javascript:;" style="cursor:pointer" onclick="set_visi('fullcont')"  title=""><?php echo __('moreStart') ?></a></div>
               <div style="display:none;" id="fullcont_type"  >
                 <p><?php echo __('scenarioEdit_helpText') ?></p>
                 <a href="javascript:;" style="cursor:pointer" onclick="set_visi('shortcont')"  title=""><?php echo __('moreEnd') ?></a>      
			  </div>
           </div> <?php
            if (($odscount == 0)) { ?>
				<a href="javascript:;"  style="cursor:pointer;" onMouseOver="Tip('<?php echo __('scenarioEdit_helpText0') ?>', BALLOON, true, ABOVE, false)" onMouseOut="UnTip()" onclick="return fancyboxclose4(); UnTip();"><h3><?php __('ScenarioEditStates0') ?></h3></a>
				<img id="statemodel"  src="<?php echo Configure::read('base_url');?>images/scenario_edit0.png" style="height: 382px !important;"><?php } ?> <?php
            if (($odscount > 0)&&($scenarioDetails[0]['Scenario']['status'] == 1)) { ?>
            	<a href="javascript:;"  style="cursor:pointer;" onMouseOver="Tip('<?php echo __('scenarioEdit_helpText1') ?>', BALLOON, true, ABOVE, false)" onMouseOut="UnTip()" onclick="return fancyboxclose4(); UnTip();"><h3><?php __('ScenarioEditStates1') ?></h3></a>
				<img id="statemodel"  src="<?php echo Configure::read('base_url');?>images/scenario_edit1.png" style="height: 382px !important;"> <?php } ?><?php
            if (($odscount > 0)&&($scenarioDetails[0]['Scenario']['status'] == 2)) { ?>
            	<a href="javascript:;"  style="cursor:pointer;" onMouseOver="Tip('<?php echo __('scenarioEdit_helpText2') ?>', BALLOON, true, ABOVE, false)" onMouseOut="UnTip()" onclick="return fancyboxclose4(); UnTip();"><h3><?php __('ScenarioEditStates2') ?></h3></a>
				<img id="statemodel"  src="<?php echo Configure::read('base_url');?>images/scenario_edit2.png" style="height: 382px !important;"><?php } ?> <?php
            if (($odscount > 0)&&($scenarioDetails[0]['Scenario']['status'] == 3)) { ?>
            	<a href="javascript:;"  style="cursor:pointer;" onMouseOver="Tip('<?php echo __('scenarioEdit_helpText3') ?>', BALLOON, true, ABOVE, false)" onMouseOut="UnTip()" onclick="return fancyboxclose4(); UnTip();"><h3><?php __('ScenarioEditStates3') ?></h3></a>
				<img id="statemodel"  src="<?php echo Configure::read('base_url');?>images/scenario_edit3.png" style="height: 382px !important;"><?php } ?> <?php
            if (($odscount > 0)&&($scenarioDetails[0]['Scenario']['status'] == 4)) { ?>
            	<a href="javascript:;"  style="cursor:pointer;" onMouseOver="Tip('<?php echo __('scenarioEdit_helpText4') ?>', BALLOON, true, ABOVE, false)" onMouseOut="UnTip()" onclick="return fancyboxclose4(); UnTip();"><h3><?php __('ScenarioEditStates4') ?></h3></a>
				<img id="statemodel"  src="<?php echo Configure::read('base_url');?>images/scenario_edit4.png" style="height: 382px !important;"><?php } ?>
            <div class="box">
                <h3 class="red"><?php # __("_infoBox"); ?></h3>
                <div class="red">
                   <?php # __('_UpdateInfo'); ?>
                </div>
            </div> <?php 
            if ($userpermission == Configure::read('access_id'))  { ?>
                <div class="box info">
                    <h3><?php __("Internal User"); ?></h3>
                    <p><?php echo $selected_customer; ?></p>
                    <p><?php __("customerId"); ?><?php echo $SELECTED_CNN; ?></p>
                </div>
                <?php 
            if ($_SESSION['VIEWMODE'] == 'EXTERNAL') {
                echo $html->link(__("scmView", true), array('controller' => 'scenarios', 'action' => 'toggleView?customer_id=' . $SELECTED_CNN . '&view=INTERNAL')); }
            else {
                echo $html->link(__("userView", true), array('controller' => 'scenarios', 'action' => 'toggleView?customer_id=' . $SELECTED_CNN . '&view=EXTERNAL')); }
                } ?>
        </div>				
    </div>
    <!--right hand side starts from here-->
    <!--ight hand side  ends here-->
	
	<script type="text/javascript">
	
	


	
	
   		$(document).ready(function() {
		
		/*
		var filterRow = $(".dataTable thead").children().eq(1).html();
		  $(".dataTable thead").prepend('<tr class="tablesorter-filter-row">'+filterRow+'</tr>');
		  $(".dataTable thead ").children().eq(2).remove();
		  */
		  
		$("#withdatatablecss").css('width','20px');
          var check_schedule="<?php echo $this->params['pass']['0'];  ?>";
		  if(check_schedule=="sch_edit") {
			document.getElementById('showexecution').style.display = 'block';
			document.getElementById('showods').style.display = 'none'; } } );
	 </script>			  
     <script type="text/javascript">
        function toggleAdvanceSearch() {
            //$("#advancesearch").show
            if (document.getElementById('advancesearch').style.display == 'none') {
                document.getElementById('advancesearch').style.display = 'block'; } 
            else {
                document.getElementById('advancesearch').style.display = 'none'; } }
    </script> <?php 
	if ($leaveStatus[0] == "on") { ?>
    <script language="JavaScript">
        populateArrays();
    </script>
  <?php } ?>  