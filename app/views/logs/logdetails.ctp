<!--$Rev:: 22            $:  Revision of last commit--> 

<script type="text/javascript">
	function reapply(){
		var url = "<?php echo Configure::read('base_url');?>stations/reapplyTransaction/station_id:<?php echo $display['affected_obj']?>&transaction_id=<?php echo $transaction['id']?>";
		$('.black_overlay').css('display','block');
        $.fancybox.showLoading();
		window.location.href=url;
	}
	
	
	function toggleShowHistory(){
			
         	//$("#advancesearch").show
         	if(document.getElementById('showLoghistory').style.display=='none'){
         		document.getElementById('showLoghistory').style.display='block';
				
				$('.toggleBar #pbtn').hide();
             	$('.toggleBar #mbtn').show();
				
         	}else{
         		document.getElementById('showLoghistory').style.display='none';
				
				$('.toggleBar #pbtn').show();
             	$('.toggleBar #mbtn').hide();
         	}
         }
       
	 
		 
		 $(document).ready(function(){
		 	
			
		//Set default button display for collapsable
		
    	//$('#minus').hide();
     	//$('#mbtn').hide();
     
		
		 $('.toggleBar #minus').click(function() {
            $('.toggleBar #pbtn').show();
            $('.toggleBar #minus').hide();
            $('.toggleBar #mbtn').hide();
            $('.toggleBar #plus').show();
			
        });

       

        $('.toggleBar #plus').click(function() {
            $('.toggleBar #pbtn').hide();
            $('.toggleBar #minus').show();
            $('.toggleBar #mbtn').show();
            $('.toggleBar #plus').hide();
			                 //show expansion image
        });

			
			});
		 
		 function updateInfotext(){
		 	
		if (inValidate(validation)) {   
                //return false;
            }	
			else{
			//$('.black_overlay').css('display','block');
					//$.fancybox.showLoading()  ;
			
			
		var infoText = $('#LogInfoText').val(); 	
      
	$('#updateInfotext').attr('action',base_url+'logs/updateInfotext&log_id=<?php echo $display['id']; ?>&infoText='+infoText );
		$('#updateInfotext').attr('method','POST');
		$.ajax({
				type: "POST",
				async : false,
				dataType: 'text',
				url: $('#updateInfotext').attr('action'),
				success: function(data){
					
					//$('#fancybox-loading').hide();
					//$('.black_overlay').css('display','none');
					// do nothing
					//alert(data);
				}
		});
		
		}
		
	}
		 
		 function chngbkcolor(obj) {
                            $(document).ready(function() {
                                jQuery('#button').attr("class", "showhighlight_buttonleft");

                                jQuery('#updateOdsentry').removeAttr("class");
                                jQuery('#updateOdsentry').attr("class", "button-right-hover");
								$('#button').attr("onclick","updateInfotext()");

                            });
                        } 
						
				$(document).ready(function() {
        validation = {
            // Specify the validation rules
            'rules': {                     
                'LogInfoText':{
                    'required': true,
                    'max': '50'
                    //'max': '30'
                },  
                'LogInfoText':{
                    'max': '150'
                },                       
            },                  
            // Specify the validation error messages
            'messages': {  
                'LogInfoText': {
                     'required': "<?php __('LocationNameNotempty')  ?>",
                     'max': "<?php __('max50')  ?>"
                 }, 
				
	    	         'LogInfoText': {
                         'max': "<?php __('max150')  ?>"
	    	            
	    	         } 
            },
          };
        });		
						
						
		 
</script>
                <?php              
	               $success=$display['info'];
			        if (isset($showHistory) || ((isset($success)) && $success))
			    	{ ?> 
<script type="text/javascript">
	$(document).ready(function(){
		
		    $('.toggleBar #pbtn').hide();
            $('.toggleBar #minus').show();
            $('.toggleBar #mbtn').show();
            $('.toggleBar #plus').hide();
		
		
	});
</script>
 <?php       }  else{      ?> 
       <script type="text/javascript">
	$(document).ready(function(){
		
		  
		      $('.toggleBar #pbtn').show();
            $('.toggleBar #minus').hide();
            $('.toggleBar #mbtn').hide();
            $('.toggleBar #plus').show();
		
		
	});
</script>
 <?php       }       
 
 $activationusers = Configure::read('activationusers');?> 

<div class="black_overlay" style=" display: none;height:560px;width: 600px;">
      
      </div>
<div style="color:#888784;padding:10px 10px 10px 10px;height:300px;">

<h4><?php echo __('logDetails') .'&nbsp;'. $display['id']; ?>
		
		 <div class='demonstrations'>
           <div  style="font-size: 18px !important;"><a href="javascript:;"  style="cursor:pointer;" onMouseOver="Tip('<?php echo __('close_window') ?>', BALLOON, true, ABOVE, false)" onMouseOut="UnTip()" onclick="UnTip(); setTimeout( function() {     
					$('.fancybox-overlay').trigger('click');
					 },5); ">X</a></div>
	        <div style="font-size: 18px !important;"><a href="javascript:;"  style="cursor:pointer" onclick="Tip('<b><?php echo __('logDetailsForm_helpTitel') ?></b><br/><?php echo __('logDetailsForm_helpText') ?>', BALLOON, true, ABOVE, false)" onMouseOut="UnTip()" >?</a></div>		
    		
 		</div>
		
		 </h4>

	
	<h5><?php echo __('UI Request')?></h5>
	<?php 
	if(isset($display)){?>
	 <div class="form-body">
            <div class="form-box">
                 <div class="form-left">
                 <?php
                 echo '<div style="width:100px; float: left">' . __('User', true) . '</div>';
                 echo $form->input('User', array('label' => false, 'type' => 'text', 'value' => $display['user'], 'style' => 'width:100px;', 'onkeyup' => "chngbkcolor(this);", 'readonly' => 'true'));

                 ?>
                </div>

                <div class="form-right">
                 <?php
          
                 echo '<div style="width:100px; float: left">' . __('Status', true) . '</div>';
                 echo $form->input('status', array('label' => false, 'type' => 'text', 'value' => $display['modification_status']?'Success':'Failed', 'style' => 'width:100px;', 'onkeyup' => "chngbkcolor(this);", 'readonly' => 'true'));

                 ?>	

                 </div>
                 <div class="form-left">
                 <?php
                 echo '<div style="width:100px; float: left">' . __('affectedObj', true) . '</div>';
                 echo $form->input('affectedObj', array('label' => false, 'type' => 'text', 'value' => $display['affected_obj'], 'style' => 'width:100px;', 'onkeyup' => "chngbkcolor(this);", 'readonly' => 'true'));
                  
                 
                 ?>
                </div>

                
                  <div class="form-right">
                 <?php
                 echo '<div style="width:100px; float: left">' . __('Date', true) . '</div>';
                 echo $form->input('Location.name', array('label' => false, 'type' => 'text', 'value' => date('d.m.Y H:i:s',strtotime($display['created'])), 'style' => 'width:100px;', 'onkeyup' => "chngbkcolor(this);", 'readonly' => 'true'));
                                 
                 ?>
                </div>
                <div class="form-left">
                 <?php
                 echo '<div style="width:100px; float: left">' . __('affectedObjName', true) . '</div>';
                 echo $form->input('affectedObj', array('label' => false, 'type' => 'text', 'value' => $display['affected_obj_name'], 'style' => 'width:100px;', 'onkeyup' => "chngbkcolor(this);", 'readonly' => 'true'));
                  
                 
                 ?>
                </div>
                <div class="form-left">
                 <?php
                 echo '<div style="width:100px; float: left">' . __('affectedObjType', true) . '</div>';
                 echo $form->input('affectedObj', array('label' => false, 'type' => 'text', 'value' => $display['affected_obj_type'], 'style' => 'width:100px;', 'onkeyup' => "chngbkcolor(this);", 'readonly' => 'true'));
                  
                 
                 ?>
                </div>

                
            </div>
            
             <?php 
                	
            if(substr($display['log_entry'], 0, 9) == '<actions>')
            { 
            ?> <h5><?php echo __('Request')?></h5> <?php 
                      	      
                 $element = simplexml_load_string($display['log_entry']);

		         foreach ($element->key as  $a)
		         {

		               echo $a . ' => ';
		               $atts = $a->attributes();
		
		               echo ' Key ' . $atts['id'];
		               echo ' Feature ' . $atts['featureId'];
		               echo '<br>';
		         }
            }
            elseif(substr($display['log_details'], 0, 7) == '<table>')
            {     
                ?> <h5><?php echo __('reportTitle')?></h5> <?php
                     	echo $display['log_entry'];
                 		$element = simplexml_load_string($display['log_details']);

                 		echo 'Count:' . $element->count;
		                foreach ($element->record as  $record)
		                {

		                	echo $record ;
		                			
		                	echo '<br>';
		                }
            }
            else
            {
                   ?> <h5><?php echo __('Request')?></h5> <?php
                   echo $display['log_entry'];
            }

                	
            if(substr($display['log_details'], 0, 9) == '<actions>')
            {     
                 ?> <h5><?php echo __('Consequences')?></h5> <?php 
                 $element = simplexml_load_string($display['log_details']);

		         foreach ($element->key as  $a)
		         {

		               echo $a . ' => ';
		               $atts = $a->attributes();
		
		               echo ' Key ' . $atts['id'];
		               echo ' Feature ' . $atts['featureId'];
		               echo '<br>';
		         }
		         #For location changes
		         foreach ($element->dn as  $dn)
		         {
		               #$action = $keyElement
		               echo $dn . ' => ';
		               $atts = $dn->attributes();

		               echo $atts['id'];
		               echo '[' .$atts['function'] . '] : ';
		               echo $atts['oldLocation'] . '=>' . $atts['newLocation'];
		            	echo '<br>';
		         }
            }
            elseif(substr($display['log_details'], 0, 7) == '<table>')
            {     
                 ?> <h5><?php echo __('reportDetails')?></h5> 
                 <?php echo __('reportSummary') . ':' . $display['info'];?>
				 <br />
                 <div id="" class="table-content">
                 <?php
							$imagepath = '../images/assets/bg-table-header.gif';
				$tabletag = "<table style='table-layout: fixed;width: 400px;border-collapse: collapse;clear: both;margin-left: 1px;' >";
				$thtag = "<th style='background: url($imagepath) repeat-x scroll left bottom rgba(0, 0, 0, 0);border: 1px solid #cccccc;font-weight: normal;height: 20px;padding: 0;vertical-align: top;text-align:left;font-size: 14px;'>";
				$tdtag = "<th style='align:left;'>";
				$html = $display['log_details'];
				$html = str_replace("<th>",  $thtag, $html);
	
				echo $html = str_replace("<table>",  $tabletag, $html);
		        ?>
		        </div>
		        <?php 
            }         
            else
            {
                  ?> <h5><?php echo __('Consequences')?></h5> <?php
                  echo $display['log_details'];
            }

             
             
          if(substr($display['log_details'], 0, 9) == '<actions>')
          {
          ?>
                     <h5><?php echo __('Transaction') . ':' . $transaction['id']?></h5>
          
          <p>
          <?php 
          }
          
         
          
          $element = simplexml_load_string($transaction['transaction']);

          #For Full Transactions.
            
			 
		  $count = count( $element->subtransaction); 
		  
		   if($count == 0){
			foreach ($element as  $sub)
          {
          
          	$objatts = $sub->attributes();
          	$objatts = $sub->object->attributes();
          	echo  $objatts['value'] ;
          	
          }
		   	}
		  
           foreach ($element->subtransaction as  $sub)
          {
          #$action = $keyElement
           
          	$subatts = $sub->attributes();
        
          	#echo $subatts['id'];
          	#echo ' => ';
          	$objatts = $sub->algRequest->object->attributes();
          	echo $objatts['action'] . ' '  . $objatts['name'] ;
          	echo $sub->algRequest->object->message->attributes('station');
          	$msgatts = $sub->algRequest->object->message->attributes();
          	echo ' 	[' . $msgatts['station'];
          	echo ' (' . $msgatts['key'] . ')] : Vars: ';
          	foreach ($sub->algRequest->object->message->var as  $vars)
          	{
          		$varatts = $vars->attributes();
          		echo $varatts['name'] . '=' . $varatts['value'] . ';';
          	}
          	
          	
       
          	
          	echo '<br>';
          }
          
          /*foreach ($element as  $sub)
          {
          #$action = $keyElement
          	//print_r($sub);
          	$objatts = $sub->attributes();
          
          	foreach ($sub->message->var as  $vars)
          	{
          			$varatts = $vars->attributes();
          			echo $varatts['value'] ;
          			echo '<br>';
          	}
           
           
          }
          */
          echo '<br></p>';
          
          if(($display['modification_status'] == 0 ) && ($activationusers[$_SESSION['ACCOUNTNAME']] == 'RE3'))
          {
	
		  $reapplyText = 'reaaply'.$display['affected_obj_type'].'Transaction';
		  ?>
          <h5><?php echo __('Errors')?></h5>
          
		  <?php
			if($stationdata['status']  == 7)
			{
		  ?>
          <a href="javascript:void()" onMouseOver="Tip('<?php echo __($reapplyText) ?>', BALLOON, true, ABOVE, false);" onMouseOut="UnTip(); " onclick="reapply();" ><?php echo __($reapplyText, true); ?></a> <br /> <?php
		  
		  } ?>
          <p>
          
                    <?php 

          
          $element = simplexml_load_string($display['modification_response']);
          #print_r($element);
   
           /*
            * 
            foreach ($element->success as  $sub)
          {


          	$subatts = $sub->attributes();
          
          	#echo $subatts['id'];
          	#echo ' => ';
          	$objatts = $sub->object->attributes();
          	echo $objatts['action'] . ' '  . $objatts['name'] ;
          	echo $sub->algRequest->object->message->attributes('station');
          	$msgatts = $sub->algRequest->object->message->attributes();
          	echo ' 	[' . $msgatts['station'];
          	echo ' (' . $msgatts['key'] . ')] : Vars: ';
          	foreach ($sub->algRequest->object->message->var as  $vars)
          	{
          		$varatts = $vars->attributes();
          		echo $varatts['name'] . '=' . $varatts['value'] . ';';
          	}
          	echo '<br>';
          }
          */
          	foreach ($element->fail as  $sub)
          	{
          	
          		echo htmlspecialchars($sub);
          	
          		$subatts = $sub->attributes();
          	
          		#echo $subatts['id'];
          		#echo ' => ';
          		$objatts = $sub->object->attributes();
          		echo $objatts['action'] . ' '  . $objatts['name'] ;
          		echo $sub->algRequest->object->message->attributes('station');
          		$msgatts = $sub->algRequest->object->message->attributes();
          		echo ' 	[' . $msgatts['station'];
          		echo ' (' . $msgatts['key'] . ')] : Vars: ';
          		foreach ($sub->algRequest->object->message->var as  $vars)
          		{
          		$varatts = $vars->attributes();
          		echo $varatts['name'] . '=' . $varatts['value'] . ';';
          	}
          	
          	
          	echo '<br>';
          }
          
          
          ?>
          <?php 
          	preg_match("/C20_FAILURE/", $display['modification_response'], $matches);
			if ($matches[0]){
				echo htmlspecialchars($display['modification_response']);
			}
			
          #For non-XML responses
			preg_match("/<fail/", $display['modification_response'], $matches);
			if (!$matches[0]){
				#echo htmlspecialchars($display['modification_response']);
				$resp = str_replace(array("\n","\r"), '', $display['modification_response']);
				echo __($resp,true);
				
			}
				
			?>
 		</p>
 		<?php }?>
          </div>

	<?php	
	 
	}else{
		
		echo "Sorry not available";
		
	}?>
	<!--	
	<div class="block">
		<div class="button-right">
			<a href="javascript:void(null);"  onclick="javascript:return validate_cancel();" name="validate" value="validate" onmouseover="hoverButtonRight(this)" onmouseout="outButtonRight(this)">Cancel</a>
		</div>
	</div>
	-->
	
	<?php if(($display['modification_status'] == 0 ) && ($userpermission==Configure::read('access_id')))
          {
          
    ?>
	
	<h4 style="display:block;float:left;width: 100%;"><?php echo __('comments'); ?> <a class="maintopRelatedContentButton" id="maintopContentButton" onclick="return toggleShowHistory();" href="javascript:void(0)" style="float:right;">
					<div class="toggleBar">
					<div style="width:20px;" id="pbtn">
					<div id="plus"></div>
					</div>
					<div style="width:20px;" id="mbtn">
					<div id="minus"></div>
					</div>
					</div>
					</a>
					
					</h4>
					</div>

			    	<?php
					$success=$display['info'];
			    	if (isset($showHistory) || ((isset($success)) && $success))
			    	{
			    		?>
			    		<div id="showLoghistory" class="table-content" style="display:block">
			    		<?php

			    	}
			    	else
			    	{
			    		?>
			    		<div id="showLoghistory" class="table-content" style="display:none">
			    		<?php
			    	}?>
					
					
					
				<?php
				echo "<div class='form-left' style='margin-left:15px;'>";
			 	  echo $form->create('Log',array('action'=>'updateInfotext','id'=>'updateInfotext','type'=>'POST', 'invalidate' => 'invalidate'));
				  echo '<div style="width:100px; float: left">' . __('comment', true) . '</div>';
			      echo $form->input('Log.info_text', array('label' => false,'rows'=>'5','cols'=>'45', 'value' => $display['info'], 'style' => 'width:70%;', 'onkeyup' => "chngbkcolor(this);"));
				  echo $form->end();
				  echo "</div>";
				  
				?>	
				<div class="button-right-disabled"  id="updateOdsentry" style="clear: both;">
								<a href="javascript:void(null);" id="button"  name="validate" class="buttonvalid" onclick="" value="validate" ><?php __('submit') ?></a>
			                </div>
							 
						 </div>
						 
				</div>
	<?php } ?>
	
	
	
</div>

<!--<div class="black_overlay" style="height: auto!important; width: 100%; display: none;"></div>-->

