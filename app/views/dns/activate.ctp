<script>
jQuery(function() { 
		
		setTimeout("jQuery('#destname').focus();", 500);
	    jQuery("#activate").click(function () {
							
			
			var TargetURL = "<?php echo Configure::read('base_url');?>dns/activate/";
			//var customer_id = $('#customer_id').val();
			$('.black_overlay').show();
			
			jQuery.post( TargetURL,{ 'customer_id':'<?php echo $customer_id;?>'}, function( data ) {
			  	 
				$('.black_overlay').hide();
			});				
		     		
		
		jQuery('#success').html('DNS updated successfully');
		
		setTimeout( function() {     
			$('.fancybox-overlay').trigger('click');
		 },200);
		 
		 
       });		
	
	
 });	

</script>

	<div id="content" style="width:400px;height:200px;">
	  <span id="success"></span>
	  <h3>Activate DN Changes to C20: </h3>
	  <h6 id='validate'> </h6>
	  <ul style="width:120px;">	   
			<li>Happy to go ahead?</li>	   
		   <li>
			  <p> Total DN to Update :<?php echo $custDNCount?></p>
			</li>			
			 <li>
				<div class="button-right">
					<a href="javascript:void(0);" id="activate">Activate</a>
				</div>								
			</li>
		</ul>

	</div>
	
	<input type="hidden" name="customer_id" id="customer_id" value="<?php echo $customer_id;?>" />
	
			<div class="black_overlay" style="height: 622px; width: 1366px; display: none;">
			<div id="black_overlay_loading">
			<img alt="" src="../../img/assets/ajax-loader.gif">
			</div>
		</div>
		

		
		 
		
		
		