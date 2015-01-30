<?php 

echo $javascript->link('/js/jquery.fancybox');
?>
	
<script type="text/javascript">
	$(document).ready(function () {    
    $("#secondfancybox").fancybox({
        helpers: {
            overlay: null        
        },
        'afterClose': function() { 
            $(".fancybox").fancybox().trigger("click");
        }
    });
});
	
	
</script>
<script>
	
 
  function setlocation(){
  		  
	   var SelectedLocation = $('select.location_drp option:selected').val();
	   var SelectedCpu = $('select.cpu_drp option:selected').val();
	   var SelectedCaption = $('select.location_drp option:selected').text();
	   var customer_id_data = $('#cust_id').val();
	   		if(SelectedLocation!=""){
			
			$('.black_overlay').css('display', 'block');	
			$.fancybox.showLoading()  ;		
			 var TargetURL = "<?php echo Configure::read('base_url');?>stations/update_cpugroup/stationkey_id:<?php echo $stationkey_id;?>"+"&cpu_id="+SelectedCpu;
			 //var TargetURL = "www.google.co.uk";
			   jQuery.post( TargetURL, function(response) {	
							  
		 
						  // $('#loc'+<?php echo $dns_id;?>).html(SelectedCaption);

					  //window.location.reload();	
				   		location.reload(false);
			   		
						});

		 }
		 else {
		 	//alert('Please Select Location');
			$('#overlay-error3 .error .message').text("<?php __('Please Select Location') ?>");
		    $('#overlay-error3').removeClass('hide');
		 }		   

   } 
   
   function chngbkcolor(obj) {
			  $(document).ready(function() {
				  jQuery('#buttonlocation').attr("class", "showhighlight_buttonleft");
				 // jQuery('#updatelocation').removeAttr("class");
				  jQuery('#updatelocation').attr("class", "button-right-hover");

			  });
		  }
 
</script>
<style>
	#black_overlay_loading {
    left: 150px!important;
    position: absolute !important;
    top: 50px!important;
    z-index: 1002;
}
.form-label{
	width: 120px !important;
}
.form-box .form-left{
	width:270px !important;
}
</style>
	 
	<div class="black_overlay" >
        <!--<div id="black_overlay_loading" >
            <img alt="" src="<?php echo Configure::read('base_url');?>img/assets/ajax-loader.gif">
        </div>-->
    </div>	
	<div id="overlay-error3" class="notification first hide" style="width: 100%" >
	    <div class="error">
	        <div class="message">  </div>
	    </div>
    </div>
	<div id="content" class="cb" style="height: 290px;">
		
	
	  <!--<span id="success"></span>-->	  
	  <h4 ><?php __('selectCpu')?>  
	  
	  	<div class='demonstrations'>
           <div style="font-size: 18px !important;"><a href="javascript:;"  style="cursor:pointer;" onMouseOver="Tip('<?php echo __('close_window') ?>', BALLOON, true, ABOVE, false)" onMouseOut="UnTip()" onclick="setTimeout( function() { 	$('.fancybox-overlay').trigger('click'); },5); UnTip();">X</a></div>
	        <div style="font-size: 18px !important;"><a href="javascript:;"  style="cursor:pointer" onMouseOver="Tip('<b><?php echo __('selectCpu_helpTitel') ?></b><br/><?php echo __('selectCpu_helpText') ?>', BALLOON, true, ABOVE, false)" onMouseOut="UnTip()" >?</a></div>		
    		
 		</div>
	  
	  </h4>
	
		
		<div style=" height:140px;">
		<div style="float: left;width: 280px !important;">	
		
	  <div class="form-box">
	  <div class="form-left">
		    	<?php 
						echo '<div class="form-label">';
						echo __('currentCpu').":";
						echo '</div>';
						
						?>
						<?php  echo $cpuGroups[$cpuId];   ?>
		
		</div>
		<div class="form-left">
			<?php 
						echo '<div class="form-label">';
						echo __('selectCpuGroup');
						echo '</div>';
						$default = __('chooseCpu',true);
						echo $form->input('CPU', array('label' => false,'class'=>'cpu_drp','type'=>'select','onchange'=>'chngbkcolor(this)', 'default' => $cpuId, 'options'=>array($cpuGroups),'empty' => $default,'style'=>'border: 1px solid #cccccc;
    width: 150px !important;float:right;'));	
					
			?>
		          <input type="hidden" name="cust_id" id="cust_id" value="<?php echo $customer_id ?>" />
				  
				  <?php 
				  #echo $html->link(__('Change Location', true),array('controller'=>'features', 'action'=>'edit/dn_id:'. $dns_id . '&featureType=DN_INDIVIDUAL'), array('class' => 'fancybox fancybox.ajax','id'=>'secondfancybox'));
				  
				   ?>
	      <!-- <a href="javascript:;" onclick='window.open("<?php echo Configure::read('base_url');?>locations/create_location/customer_id:<?php echo $customer_id .  '/dns_id:' . $dns_id . '/location_id:' . $location_id . '/loc_id:' . $location_id ?>","MsgWindow","width=200,height=100");'  id="secondfancybox">Second Fancy Box</a>-->
        </div>
			
		
	 
		
     </div>
	 </div>
	 <div style="float: right;width: 250px !important;">
	 	<div class="form-right" >
		
			<p><?php echo __('selectCpu_blurb')?></p>
		</div>
	 </div>
	 </div>
	 
	 
	 
	
	 <div class="form-right">
		 <div class="button-right" id="updatelocation" style="margin-top: 50px !important;">
			<a id="buttonlocation" href="javascript:;" onclick="setlocation();" name="submitForm" value="submitForm" ><?php __("apply");?></a>		
     	 </div>  
        </div>	
	</div>
 
	