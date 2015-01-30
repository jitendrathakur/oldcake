<style>
	.t_Tooltip{
	display:block !important;
}
.fancybox-close {
    cursor: pointer;
    height: 0px!important;
    position: absolute;
    right: -30px;
    top: -20px;
    width: 36px;
    z-index: 8040;
}
.fancybox-inner{
	height: auto !important;
    overflow: auto;
    width: 600px!important;
}
.form-label{
	width: 150px !important;
}
.form-box .form-left{
	width:300px !important;
}	
</style>
<?php //echo "<pre>"; print_r($locationlists);?>
<script type="text/javascript">

 var seldnids = '';
 var dnIdCount = 0;
 var breakWordCheck;
 var dn_id;
   jQuery('#ajax_load input[type="checkbox"]').each(function() { 
         
		if ($(this).is(':checked')) { 
		   dn_id = $(this).val();
		   if(dn_id != "on"){
		   	dnIdCount++;
		   }
			
			breakWordCheck = dnIdCount % 5 ;
			if(breakWordCheck == 0){
				
			dn_id = $(this).val();
			seldnids += dn_id + ','+'</br>';	
			
			
			}
			else{
				
			dn_id = $(this).val();
			
			seldnids += dn_id + ',';
			}
		}
   });
   
	 var sdnid = seldnids.replace(/^,|,$/g,'');
	 sdnid = sdnid.replace("on,", "");
	$("#seldnid").html(sdnid);



//var dnid = '';
function assignlocation(){
	
var location_id = $('select.location_drp option:selected').val();

 if(location_id==""){
		//alert('Please Select at least one Location!');
		$('#overlay-error3 .error .message').text("<?php __('Please Select at least one Location!') ?>");
		    $('#overlay-error3').removeClass('hide');
		return false;   
   }     
 
   // Find all DN Lists to update their location
   var dnsids = '';
   var seldnids = '';
   jQuery('#ajax_load input[type="checkbox"]').each(function() { 
         
		if ($(this).is(':checked')) { 
					
			dn_id = $(this).val();
			
			dnsids += dn_id + '-';
			seldnids += dn_id + ',';
		}
   });
   
   dnsids = dnsids.replace("on-"," ");
  
	$("#seldnid").html(sdnid);
    
	$("#seldnid").val(seldnids);
	var customer_id = jQuery('#customer_id').val();
	var loc_id = jQuery('#loc_id').val();
	$('.black_overlay').css('display', 'block');
	$.fancybox.showLoading()  ;	
	var TargetURL = "<?php echo Configure::read('base_url');?>dns/assignlocation/";
	
	 //checking browser of ajax submit behavoir
		var asyncronation;
	if(browserCheck()=="FIREFOX"){
		 asyncronation = false;
	}
	else{
			asyncronation = true;
	}
	var datastring = 'location_id='+location_id+'&dnsids='+dnsids+'&customer_id='+customer_id;
	$.ajax({
        type: "POST",
        async : asyncronation,
        dataType:'text',
        url: TargetURL,
        data: datastring,
        success: function(result){
       location.reload(false);
        }
    });

	
	
	   
	/*
 		jQuery.post( TargetURL, {'location_id':location_id, 'dnsids':dnsids, 'customer_id':customer_id}, function( data ) {  //alert(data);
 //window.location.reload();
 location.reload(false);
	});	  
	*/
/*var TargetURL = "<?php echo Configure::read('base_url');?>locations/update_location/";
			 
			 jQuery.post( TargetURL, {'location_id':location_id, 'dnsids':dnsids, 'customer_id':customer_id , 'loc_id':loc_id}, function( response ) {			 
				  
						$('#ajax_load').html(response);
						 $('.cnt').html('0: records are selected');
						  alert("Location is Updated Sucessfully");
						
						  	 $('#smsg').html('<div class="notification first" style="width: 534px; margin-left:10px; margin-top:10px;"><div class="ok"><div class="message">Location is Updated Sucessfully</div></div></div>');
						 
						
				 window.location.reload();		  
						});
			  
		  setTimeout( function() {     
			$('.fancybox-overlay').trigger('click');
		 },200);	*/	   	
	

}
 function chngbkcolor(obj) {
			  $(document).ready(function() {
				  jQuery('#buttonlocation').attr("class", "showhighlight_buttonleft");
				 // jQuery('#updatelocation').removeAttr("class");
				  jQuery('#updatelocation').attr("class", "button-right-hover");

			  });
		  }
		  
		  $(document).ready(function(){
		  	var locaionName = $('#LocationName').val();
		  	$('#currentLocation').html(locaionName);
		  });
		  
		  
		  
</script>

<div class="black_overlay" style="display: none;">
        <!--<div id="black_overlay_loading">
            <img alt="" src="../../img/assets/ajax-loader.gif">
        </div>-->
    </div>
	<div id="overlay-error3" class="notification first hide" style="width: 100%" >
	    <div class="error">
	        <div class="message">  </div>
	    </div>
    </div>	
<div id="content" style="height:auto;">
	  <span id="success"></span>	 		
	  <h4 ><?php __('updateMultilaction4Dn')?>
	  	 <div class='demonstrations' >
           <div style="font-size: 18px !important;" ><a href="javascript:;"  style="cursor:pointer;" onMouseOver="Tip('<?php echo __('close_window') ?>', BALLOON, true, ABOVE, false)" onMouseOut="UnTip()" onclick="setTimeout( function() {     
					$('.fancybox-overlay').trigger('click');
					 },5); UnTip();">X</a></div>
	        <div style="font-size: 18px !important;"><a href="javascript:;"  style="cursor:pointer" onclick="Tip('<b><?php echo __('updateMultilaction4Dn_helpTitle') ?></b><br/><?php echo __('updateMultilaction4Dn_helpText') ?>', BALLOON, true, ABOVE, false)" onMouseOut="UnTip()" >?</a></div>	    		
    </div>   	  
	  
	  </h4>
	
	  <h6 id='validate'> </h6>
	  <div style="height: 150px;">
	  <div style="float: left;width: 300px;">
	  
     <div class="form-box">
	  <p style="width: 300px;float: left;" > <?php __('Update Location for DN')?>  <?php //echo $dns_id; ?> <span  id="seldnid"></span></p>
  <div style="clear: both"></div>
	 <div class="form-left">
		<?php 
						echo '<div class="form-label">';
						echo __('currentLocation');
						echo '</div>';
			?>			
		<span id="currentLocation"></span>
		
		</div>
		<div class="form-left">
			<?php 
						echo '<div class="form-label">';
						echo __('SelectLocation');
						echo '</div>';
						$emptyselect = __('Please Select Location',true);
						echo $form->input('d'.$res['Dns']['id'], array('label' => false,'class'=>'location_drp','type'=>'select','onchange'=>'chngbkcolor(this)', 'options'=>array($locations),'empty' => $emptyselect,'style'=>'width:150px !important;'));	
					
			?>
		          <input type="hidden" id="customer_id" value="<?php echo $customer_id;?>" />
                  <input type="hidden" id="loc_id" value="<?php echo $loc_id;?>" />
		
        </div>
		</div>
			
		
		
     </div>
	 <div style="float: right;width: 225px;">
	 	  <div class="form-right" >		
			<p><?php echo __('selectLocation_blurb')?></p>
		</div>	 
	 </div>
	 </div>

	
		<div class="form-right">
		 <div class="button-right" id="updatelocation">
			<a id="buttonlocation" href="javascript:;" onclick="assignlocation();" name="submitForm" value="submitForm" ><?php __("apply");?></a>		
     	 </div>  
        </div>
		
		

	</div>	
	
	