<style>
	.opendestTable td{
		white-space: normal !important;
	}
	
	
	
</style>
<script>
$(document).ready(function(){
	
	var scenaroio_status = $('#sts').html();
	$('#scn_status').val(scenaroio_status);
});


jQuery(function() { 
		
		//setTimeout("jQuery('#destname').focus();", 500);
	    jQuery("#savedestination").click(function () {
				
			validation = {
	    	    // Specify the validation rules
	    	    'rules': {                     
	    	      
	    	        'destname':{
	    	        	'leading': '0',	    	
	    	        	'required': true,
	                	'spclChar': true,         
	    	            'excludeStr': ['084', '0800', '090', '00870', '00881', '00882', '00883', '0039310'],
	    	            'min': '9',
	    	            'max': '20'	    	           
	    	        }  
	                                  
	    	    },                  
	    	    // Specify the validation error messages
	    	    'messages': {  
	    	        
	    	        'destname': {
	    	         	'leading' : "<?php __('leadingZeroOds')?>",
	    	         	'required': "<?php __('destNotempty')  ?>",
	                 	'spclChar': "<?php __('Special characters are not allowed')  ?>",
	    	         	'excludeStr' : "<?php __('excludeNumber')?>",
	    	            'min': "<?php __('min9Chars')?>",
	    	            'max': "<?php __('max20Chars')?>"             
	    	        }
	    	    },
	    	};
			
			if (inValidate(validation)) {
	    		  
	    	    //return false;
	    	  } else {
			
				/*var destval=$('#destname').val();
				if(destval!='')
				{
				if($.isNumeric(destval))
				{*/
				var senddata = []; 
				
				getallids = $("#getallids").val();
				//alert(getallids); return;
				getallId_arr = getallids.split(',');
				//alert(getallId_arr[0]);
				//alert(getallId_arr[1]); return;
				$('#checkAll').removeAttr('checked');
				
				//jQuery('input[type="checkbox"]:checked').each(function() { 
				for(i=0; i<getallId_arr.length-1; i++)
				{
					var enteredDest = jQuery('#destname').val();
					
					var Odsentryid = getallId_arr[i]; //jQuery(this).val();
					jQuery(this).removeAttr('checked');
					//alert(Odsentryid);
					jQuery('#d'+Odsentryid).val(enteredDest);
					jQuery('#chk' + Odsentryid).attr("class", "changedodsentry");
					var validrec = "<?php __('Valid'); ?>"
                   
					jQuery('.sc_state_medium'+Odsentryid).html(validrec);	

					senddata.push(Odsentryid+"="+enteredDest);				
				}
				//});	 
				//return;
				var serialized = senddata.join("&") 
				
				
				var TargetURL = "<?php echo Configure::read('base_url');?>scenarios/updatescenarioviajquery/";
				var ScenarioId = $('#scenario_id').val();
				$('.black_overlay').show();
				
				jQuery.post( TargetURL,{ 'odsdata': serialized, 'scenario_id':ScenarioId}, function( data ) {
									 
					 
					 jQuery(".update_message").html(data);
					 jQuery('#overlay-sucess').addClass('hide');
					 				  
	                 //jQuery(".message").html(data+":record updated susscessfully");
					  jQuery('#updateOdsentry').removeAttr("class");	
					  jQuery('.saveOdsentry').attr("style","display:none");	
			          jQuery(' .trickOdsentry').attr("style","display:inline");
					 
					   jQuery('#savedestinations').removeAttr("class");	
					  jQuery('#updateOdsentry').attr("class"," button-right-disabled");	
	                   jQuery('#savedestinations').removeAttr("onclick");				  
	                				 
					$('.black_overlay').hide();
					$('.cntchk_updatemsg2').hide();
					$("#getallids").val("");
					$('.counter').hide();
					$('.deldest').hide();
				});

				scenario_id = $("#scenario_id").val();
				//$.ajax({url:"<?php echo Configure::read('base_url'); ?>scenarios/tablereload/scenario_id:"+scenario_id,success:function(result){
			
				//$("#updatehtml").html(result);
				//$('.black_overlaysaveOdsentry').hide();			
			  //}});				
			     //Updated the Scenario status i.e. Complete or Incomplete
				 setTimeout(function() {
				var ScenarioId = $('#scenario_id').val();
				
				var TargetURL = "<?php echo Configure::read('base_url');?>scenarios/ScenarioCompletedOrNot/scenario_id:"+ScenarioId;
				
				jQuery.post( TargetURL, function( response ) {
					
					//alert(response);
					
				jQuery('#Status').val(response);
					
	              
				 var msgd=response.trim();
				 if(msgd == "Incomplete")
				 {
					var scenarioStatus = "<?php __('Incomplete');?>"
				 }
				else if(msgd == "Complete"){
					var scenarioStatus = "<?php __('Complete');?>"
				}
				jQuery('#sts').html(scenarioStatus);
							 
							if(msgd=="Complete"){ 
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
								
							 } else {						 
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


						$.ajax({url:"<?php echo Configure::read('base_url'); ?>scenarios/tablereload/scenario_id:"+scenario_id,success:function(result){
			
						$("#updatehtml").html(result);
						$('.black_overlaysaveOdsentry').hide();			
					  }});
					
				});			
				},5);  
				
				for(i=0; i<getallId_arr.length-1; i++)
				{
					var Odsentryid = getallId_arr[i]; //jQuery(this).val();
				//jQuery('input[type="checkbox"]:checked').each(function() { 
					jQuery("#chk"+Odsentryid).attr("checked", false);				
				}		
			
			jQuery('#success').html('Dest. Number Added Successfully!');
			
			
			setTimeout( function() {     
				$('.fancybox-overlay').trigger('click');
			 },200);
		 }
		 
		 
		  
		 /*else{
		    $('#validate').text('Dest. Number should be only numeric');
		 
		 }
		    }
			else
			{
			$('#validate').text('Dest. Number should not be empty');
			}*/
       });		
	
	
 });
 
 /*function chngbkcolor(obj) {
			  $(document).ready(function() {
				  jQuery('#savedestination').attr("class", "showhighlight_buttonleft");
				  jQuery('#updateStation').removeAttr("class");
				  jQuery('#updateStation').attr("class", "button-right-hover");
				  alert("kk");
				  
				jQuery('#updateOdsentry').show();
            	jQuery('#savedestinations').attr("class", "showhighlight_buttonleft");
            	jQuery('#updateOdsentry').removeAttr("class");
            	jQuery('#updateOdsentry').attr("class", "button-right-hover");
				jQuery('#savedestinations').attr("onclick", "javascript:saveOdsentry(this);");

			  });
			  //called when key is pressed in textbox
    $("#destname").keydown(function(e) {

    	//console.log(e.which);
      if( e.which!=8 && e.which!=0 && (e.which<48 || e.which>57) && e.which!=13 && (e.which<96 || e.which>105))
      {        
        $('#overlay-error2 .error .message').text("<?php __('digitsOnly') ?>");
        $('#overlay-error2').removeClass('hide');
        return false;
      } else {
      	inValidate(validation, 'keyup', null, e);
      }
    });
}*/	







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
				jQuery('#savedestinations').attr("onclick", "javascript:saveOdsentry(this);");
            	jQuery('#updateOdsentry').removeAttr("class");
            	jQuery('#updateOdsentry').attr("class", "button-right-hover");
		 
			 $("input.numeric_check").focus(function(e) {	
			 //make button heightlighted when there is unsaved destination
			 	$('#savedestinations').addClass('showhighlight_buttonleft');
				$('#updateOdsentry').removeClass('button-right-disabled');
				$('#updateOdsentry').addClass('button-right-hover');
	  
    });
			
 });
			
					  //called when key is pressed in textbox
					  
    
	
	

}

$("#destname").keyup(function(e) {
    	//console.log(e.which);
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
<input type="hidden" value="" id="scn_status"/>
<?php
echo $form->create('Station', array(
                                'action' => 'updateDest',
                                'id' => 'Station',
                                'class' => 'ufForm',
                                'type' => 'POST',
								'invalidate' => 'invalidate'
));
?>

	<div id="content" style="width:500px;height:auto;">
	<div style="height: 55px">
		<div id="overlay-error2" class="notification first hide" style="width: 100%" >
		
			<div class="error">
				<div class="message">
					
				</div>
			</div>
		</div>
	</div>
		
	  <!--<span id="success"></span>-->
	  
	  <h4 style="border-bottom: 1px solid #333; "><?php __('scenarioDestUpdate_titel')?> 
	  	<div class='demonstrations'>
           <div style="font-size: 18px !important;"><a href="javascript:;"  style="cursor:pointer;" onMouseOver="Tip('<?php echo __('close_window') ?>', BALLOON, true, ABOVE, false)" onMouseOut="UnTip()" onclick="setTimeout( function() {     
					$('.fancybox-overlay').trigger('click');
					 },5); UnTip();">X</a></div>
	        <div style="font-size: 18px !important;">
			<!--<a href="javascript:;"  style="cursor:pointer" onMouseOver="Tip('<b><?php echo __('selectDnsToScenario_helpTitel') ?></b><br/><?php echo __('selectDnsToScenario_helpText') ?>', BALLOON, true, ABOVE, false)" onMouseOut="UnTip()" >?</a>-->
			
			
			<a href="javascript:;"  style="cursor:pointer" onMouseOver="Tip('<b><?php echo __('updateDestinationNumber_helpTitel') ?></b><br/><?php echo __('updateDestinationNumber_helpText') ?>', BALLOON, true, ABOVE, false)" onMouseOut="UnTip()" >?</a>
			
			</div>		
    		
 		</div>

	  </h4>
	  <h6 id='validate'> </h6>
	  <ul style="width:200px;">	 
	  
	  
	    
			<!--<li><?php echo __('updateDestination_title') ?></li>-->	   
		   <li>

		     <table style="width:450px;" class="opendestTable">
				<tr>
				  <td style="vertical-align: top;height: 10px;width:150px;" ><?php echo __('updateDestination_title') ?></td>
				  <td width="210" rowspan="2" valign="top"  style="padding-left: 15px; text-align: justify;" ><?php   echo __('updateDestination_blurb') ?></td>
  </tr>
				<tr>
		 			<td style="vertical-align: top;" > <input   type="text" name="destname" style="width: 130px" id="destname" class="numeric_check destname" tabindex=1 value="" onKeyUp="chngbkcolor(this)";>
		 			</td>
				</tr>
			
			</table>

			</li>			
			 <li style="padding-left: 260px;">
											
			</li>
			
		</ul>
       <div class="button-right-hover" id="updateStation">
					<a  href="javascript:void(0);"  id="savedestination" class="showhighlight_buttonleft"><?php __('save')?></a>
				</div>	
	</div>
	
	<input type="hidden" name="scenario_id" id="scenario_id" value="<?php echo $scenario_id;?>" />
	
			<div class="black_overlay" style="height: 622px; width: 1366px; display: none;">
			<div id="black_overlay_loading">
			<img alt="" src="../../img/assets/ajax-loader.gif">
			</div>
		</div>
		
</form>
		
		 
		
		
		