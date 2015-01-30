
<script>
 
validation = {
	    // Specify the validation rules
	    'rules': {                     
	        'ScenarioComment':{
	            'max': '60',	           
	        }  
                              	
	    },                  
	    // Specify the validation error messages
	    'messages': {  
	        'ScenarioComment': {
	             'max': "<?php __('max60Chars')?>",            
	         }
	         
	    },
	};



function submitForm(){
	
	  if (inValidate(validation)) {
		  
	    //return false;
	  } else {
  	  
		  $('.filtersForm').attr('action',base_url+'scenarios/exceptionoverride/<?php
				  echo $statId;
				  ?>');
				  		//$('.black_overlay').css('display','block');
				  		$('.filtersForm').attr('method','POST');
				  		$.ajax({
				  				type: "POST",
				  				async : false,
				  				url: $('.filtersForm').attr('action'),
				  				data: $('.filtersForm').serialize(),
				  				success: function(data){ 					 
				  						//jQuery('#fancybox').click();
				  						location.reload(); 
				  						//window.reload();					
				  				}
				  		});
				  		jQuery('#cboxClose').click();
	  }   
	              //jQuery('#cboxClose').click();
	        //location.reload();
	}//end submitForm
 
	   
	
	function chngbkcolor(obj) {
			  $(document).ready(function() {
				  $('#button').attr("class", "showhighlight_buttonleft");
				  $('#updateStation').removeAttr("class");
				  $('#updateStation').attr("class", "button-right-hover");

			  });
	
	}	

</script>



<div id="newEdit">
		<div class="form-body">

<?php 

echo $form->create('Scenario', array(
				'action' => 'exceptionoverride',
				'id' => 'Scenario',
				'class' => 'filtersForm',
				'type' => 'POST',
				'invalidate' => 'invalidate'
));

echo $form->input('scenario_id', array('type'=>'hidden','value'=>$scenario_id));


?>
<div class="cb">

 
		<div id="overlay-error2" class="notification first hide" style="width: 100%" >
		
			<div class="error">
				<div class="message">
					
				</div>
			</div>
		</div>
		


<h4 ><?php echo __('exceptionOverride') . $scenariodetails['Scenario']['Name'];?>
 <div class='demonstrations'>
           <div  ><a href="javascript:;"  style="cursor:pointer;font-size:18px !important;" onMouseOver="Tip('<?php echo __('close_window') ?>', BALLOON, true, ABOVE, false)" onMouseOut="UnTip()" onclick=" setTimeout( function() {     
					$('.fancybox-overlay').trigger('click');
					 },5); UnTip();">X</a></div>
	        <div ><a href="javascript:;"  style="cursor:pointer;font-size:18px !important;" onclick="Tip('<?php echo __('exceptionOverride_helpTitel') ?></b><br/><?php echo __('exceptionOverride_helpText') ?>', BALLOON, true, ABOVE, false)" onMouseOut="UnTip()" >?</a></div>		
    		
 		</div></h4>
  
        <div class="form-box">
       	 
				<div class="form-left">

						<?php ;
						echo '<div class="form-label">';
						echo __('Comment');
						echo '</div>';
						#echo $form->input('comment', array('type'=>'text', 'label' => false,'style'=>'width:100px;','onkeyup'=>'chngbkcolor(this)'));
						echo $form->input('comment', array('label' => false,'rows'=>'5','cols'=>'45', 'style' => 'width:140px;', 'onkeyup' => "chngbkcolor(this);"));
						
					?>
					
					<br/>
					<br/>
					<?php 
				
					
					
						echo '<div class="form-label">';
						echo __('State');
						echo '</div>';
						
						
						/*$deactivate =  $scenarioStatus('4');
						$activate =  $scenarioStatus('6');
						#$deactivate =  4;
						#$activate =  6;
						
						$stateOptions = array();
						$stateOptions['5'] = __($deactivate, true);
						$stateOptions['4'] = __('activate', true);
						#	$stateOptions['6'] = __($scenarioStatus('6'), true);
						$stateOptions['6'] = __('activate', true);
						#$stateOptions = array( '4' => $deactivate, '6' => $activate);
						*/
			 			echo $form->select('status', $statuses,'4',array('label'=>false, 'style'=>'width:140px;'));
	
					?>
				</div>
				<div class="form-right">
				<p><?php echo __('exceptionOverride_blurb')?>
				</div>
				
				<br/>
		</div><br/>
		<div class="button-right-disabled" id="updateStation">

					<a id="button" href="javascript:;" onclick="submitForm()" name="submitForm" value="submitForm" ><?php __("exceptionOverride_confirm");	?></a>
		
     	</div>  
		    
     
</div>
</form>
</div>
</div>
				  
		
		 
		
		
		