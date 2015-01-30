<script>
jQuery(function() { 
 jQuery('.status'+<?php echo $dns_id; ?>).html('Edited');	  
 });	
 
  function setlocation(){	  
	   var SelectedLocation = $('select.location_drp option:selected').val();
	   var SelectedCaption = $('select.location_drp option:selected').text();
	   var customer_id_data = $('#cust_id').val();
				
	    jQuery('#lkname_'+<?php echo $dns_id; ?>).html('<a id="" class="fancybox fancybox.ajax" href="/voipphoneRE3.1/dns/create_location/customer_id:'+customer_id_data+'/dns_id:<?php echo $dns_id; ?>">'+SelectedCaption+'</a>');
	   
	         serialized = <?php echo $dns_id; ?>+"="+SelectedLocation;
			
			var TargetURL = "<?php echo Configure::read('base_url');?>dns/update_location/";
			  jQuery.post( TargetURL, {serialized:serialized, customer_id:customer_id_data}, function( data ) {	
			  
				 var responsedata = data.split('@#');
					for(var i=0; i < responsedata.length; i++){
					  
						var thislist = responsedata[i];
						var selectedrow = thislist.split('**');
						var Id = selectedrow[0];

						var status = selectedrow[1];
						jQuery('.status'+Id).html(status);
						jQuery('#hh_'+Id).hide();	
						
								
					}
				});
				jQuery('#hh_'+<?php echo $dns_id; ?>).hide();		
		   setTimeout( function() {     
			$('.fancybox-overlay').trigger('click');
		 },200);		   

   } 
 
</script>
	<div id="content" style="width:400px;height:200px;">
	  <span id="success"></span>
	  <h3>Update Location. Number for Selected DNS Entries : </h3>
	  <h6 id='validate'> </h6>
	  <ul style="width:120px;">	 

            <li>Slect Location</li>	   	
            <li>
            
            	 <?php
					echo $form->input('d'.$res['Dns']['id'], array('label' => false,'class'=>'location_drp','onchange'=>'setlocation();' ,'type'=>'select', 'options'=>array($locations),'default'=>$location_id));				 
				  ?>
                  <input type="hidden" name="cust_id" id="cust_id" value="<?php echo $customer_id ?>" />
            </li>		
		</ul>
<div class="form-box">
	<div class="form-right-inactive">
		<p><?php echo __('inactiveFeature')?></p>
	</div>		
</div>
	</div>		