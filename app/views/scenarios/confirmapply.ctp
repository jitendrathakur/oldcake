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
jQuery(function() { 
 jQuery(".status<?php echo $scenario_id; ?>").html('Edited');	  
 });	
 
  function applyScenario(){
  		  
	  
	   		
			
			$('.black_overlayConfirmapply').css('display', 'block');	
			$.fancybox.showLoading()  ;		
			 var TargetURL = "<?php echo Configure::read('base_url');?>scenarios/applyscenario?scenario_id=<?php echo $scenario_id;?>"+"&operation=<?php echo $operation; ?>";
			 
			   jQuery.post( TargetURL, function(response) {	
							 //alert(response);
						// $('#ajax_load').html(response);			 
						  // $("#loc<?php echo $scenario_id;?>").html(SelectedCaption);
		
					  window.location.reload();	
						});
			 
		  // setTimeout( function() {     
			//$('.fancybox-overlay').trigger('click');
		// },200);
   

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
.black_overlayConfirmapply{
	background-color: #000000;
    display: none;
    height: 100%;
    left: 0;
    opacity: 0.5;
    position: absolute;
    top: 0;
    width: 100%;
    z-index: 1001;
}
</style>
	 
	<div class="black_overlayConfirmapply" >
        <!--<div id="black_overlay_loading" >
           <img alt="" src="<?php echo Configure::read('base_url');?>img/assets/ajax-loader.gif">
        </div>-->
    </div>	
	<div id="content" class="cb" style="height: 160px;">	
	
	  <!--<span id="success"></span>-->	  
	  <h4 ><?php 
	  $title = 'confirmScenario' . $operation . 'Title';
	  echo __($title)?>  <?php echo $scenario_name; ?> 
	  
	  	<div class='demonstrations'>
           <div style="font-size: 18px !important;"><a href="javascript:;"  style="cursor:pointer;" onMouseOver="Tip('<?php echo __('close_window') ?>', BALLOON, true, ABOVE, false)" onMouseOut="UnTip()" onclick="UnTip(); setTimeout( function() { 	$('.fancybox-overlay').trigger('click'); },5); ">X</a></div>
	        <div style="font-size: 18px !important;"><a href="javascript:;"  style="cursor:pointer" onMouseOver="Tip('<b><?php echo __('confirmApplyScenario_helpTitel') ?></b><br/><?php echo __('confirmApplyScenario_helpText') ?>', BALLOON, true, ABOVE, false)" onMouseOut="UnTip()" >?</a></div>		
    		
 		</div>
	  
	  </h4>
	 
	  <div class="form-box">
		<div class="form-left">

	      <!-- <a href="javascript:;" onclick='window.open("<?php echo Configure::read('base_url');?>locations/create_location/customer_id:<?php echo $customer_id .  '/dns_id:' . $dns_id . '/location_id:' . $location_id . '/loc_id:' . $location_id ?>","MsgWindow","width=200,height=100");'  id="secondfancybox">Second Fancy Box</a>-->
        </div>
			
		<div class="form-right" >
			
			<p><?php 
			if($valid == 1)
			{
				$operationBlurb = 'confirmApply' . $operation . '_blurb'; echo __($operationBlurb);
			}
			else {
				$operationBlurb = 'confirmApplyBlocked_blurb'; echo __($operationBlurb);
			}?></p>
			
		</div>
	 
		
     </div>
	
	 <div class="form-right">
	 	<?php if($valid == 1)
			{?>
		 <div class="button-right" id="updatelocation">
			<a id="buttonlocation" href="javascript:;" onclick="applyScenario();" name="submitForm" value="submitForm" ><?php __("confirmApplyScenario");?></a>		
     	 </div>  
     	 <?php }?>
        </div>	
	</div>
 
	