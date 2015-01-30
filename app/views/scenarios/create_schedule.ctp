<?php 

 echo $javascript->link('/js/timepicker');

?>
<!-- <script src="http://code.jquery.com/jquery-migrate-1.0.0.js"></script> -->


<script type="text/javascript">



</script>

<script type="text/javascript">


jQuery( document ).ready(function() {
  jQuery( ".date-pick" ).datepicker({minDate:+0, "seperator":"."});
    jQuery(".timepicker").timepicker({ampm: false, timeFormat:'hh:mm'});
});


function validate_form()
{
	//alert('testing');
	var dateval = $('#ExecutionTargetDate').val();
	var timeval = $('#ExecutionTime').val();
	var options = $('#ExecutionOperation').val();
	if(dateval==''){
	//$('#error_messages').show();
	//$('#error_messages').html('<?php echo __("Please choose schedule date!", true)?>');
	
	$('#overlay-error2 .error .message').text("<?php __('Please choose schedule date!') ?>");
	$('#overlay-error2').removeClass('hide');
	return false;
	}else if(!validate_pastdate(dateval)){
	
		//$('#error_messages').show();
		//$('#error_messages').html('<?php echo __("Please enter future or current date only!", true)?>');
		
		$('#overlay-error2 .error .message').text("<?php __('Please enter future or current date only!') ?>");
	    $('#overlay-error2').removeClass('hide');
		return false;
	
	}else if(timeval ==''){
			//$('#error_messages').show();
			//$('#error_messages').html('<?php echo __("Please enter the time!", true)?>');
			
			$('#overlay-error2 .error .message').text("<?php __('Please enter the time!') ?>");
			$('#overlay-error2').removeClass('hide');
			
		return false;
	}else if(options==''){
		//$('#error_messages').show();
		//$('#error_messages').html('<?php echo __("Please choose operation!", true)?>');
		
		$('#overlay-error2 .error .message').text("<?php __('Please choose operation!') ?>");
	    $('#overlay-error2').removeClass('hide');
	return false;
	}
	else{
		jQuery('#filters').submit();
	}

}

function validate_pastdate(dateCheck)
{
		var splitDate = dateCheck.split(".");
		var refDate = new Date(splitDate[2]+" "+splitDate[1]+" "+splitDate[0]);
		today = new Date();
		today.setHours(0,0,0,0)
		if (refDate < today)
		{
			return false;
		}else{
			return true;
		}
}

function applynow(customer_id, act)
{
	var operation = $('#ExecutionOperation').val();
	var timeval = $('#ExecutionTime').val();
	
	if(operation==''){
	//$('#error_messages').show();
	//$('#error_messages').html('Please choose operation!');
	$('#overlay-error .error .message').text("<?php __('Please choose operation!') ?>");
	$('#overlay-error').removeClass('hide');
	return false;
	}else{
		var ajax_url = "<?php echo Configure::read('base_url');?>";
		var sc_id2 = $('#ExecutionScenarioId').val();
		var execution_id = $('#ExecutionId').val();


		//url:ajax_url+"scenarios/apply_now/",
		//data:"customer_id="+customer_id+"&scenario_id="+$('#ExecutionScenarioId').val()+"&status="+$('#ExecutionOperation').val()+"&date="+$('#ExecutionTargetDate').val()+"&time="+$('#ExecutionTime').val()+"&execution_id="+execution_id+"&act="+act,		

	
		$.ajax({
		   	type:"POST",
		  url:ajax_url+"scenarios/apply_now/",
			data:"customer_id="+customer_id+"&scenario_id="+$('#ExecutionScenarioId').val()+"&status="+$('#ExecutionOperation').val()+"&date="+$('#ExecutionTargetDate').val()+"&time="+$('#ExecutionTime').val()+"&execution_id="+execution_id+"&act="+act,		
		   	
			
			
			
			success: function(msg)
			{	
					//alert(msg);							
				var d1 = msg.split("::");
				var sc_id = d1[0];
				var execution_id = d1[1];
				var customer_id = d1[2];
				var act = d1[3];
				

				sts ='In Progress <img src="<?php echo Configure::read('base_url');?>/images/fancybox_loading.gif">';
		        $('#indexsts_'+sc_id2).html(sts);
				
				$('#progresswh').show();
				$('#progressIn').hide();
				$('#progressOut').show();
				
				check_status(sc_id, execution_id, customer_id,act);
				
			}
		});
		 setTimeout( function() {     
			$('.fancybox-overlay').trigger('click');
		 },200);	
	}
}

function check_status(scenario_id, execution_id, customer_id,act)
{
	var ajax_url = "<?php echo Configure::read('base_url');?>";
	var scid = scenario_id;
	$.ajax({
		type:"POST",
		url:ajax_url+"scenarios/check_status/",
		data:"scenario_id="+$('#ExecutionScenarioId').val()+'&execution_id='+execution_id+'&act='+act+'&customer_id='+customer_id,
		success: function(data)

		{
			window.location.reload();
			var d = data.split(":-:");
			var scenario_id = d[1];
			var chk_act = d[4];
			var msg = d[0];
		
			if(chk_act==6) { var sts1 ='Active';
		
			$('#opt_'+scenario_id).html('<a id="deactivateScenario" class="fancybox fancybox.ajax" href="/voipphoneRE3.1/scenarios/create_schedule/'+scenario_id+'/create/'+customer_id+'/0/deactivate"> . </a>');
		
			$('#deactdiv_'+scenario_id).show();
			$('#actdiv_'+scenario_id).hide();
		
			/*$('#deactfly_'+scenario_id).html('De-Activate');
			$('#deactflylabel_'+scenario_id).html('Use this option to de-activate the scenario.');*/
		
		
			$('#Status').val(sts1);
			$('#sts').html('Status :'+sts1);
		
		
		
		
			$('#deactivationdiv').show();
			$('#activationdiv').hide();
		
		 }
		 
		if(chk_act==4) { var sts1 ='Inactive';
		$('#opt1_'+scenario_id).html('<a id="activateScenario" class="fancybox fancybox.ajax" href="/voipphoneRE3.1/scenarios/create_schedule/'+scenario_id+'/create/'+customer_id+'/0/activate"> . </a>');
		
		$('#deactdiv_'+scenario_id).hide();
		$('#actdiv_'+scenario_id).show();
		
		/*$('#actfly_'+scenario_id).html('Activate');
		$('#actflylabel_'+scenario_id).html('Use this option to activate the scenario.');*/
		
		$('#Status').val(sts1);
		$('#sts').html('Status :'+sts1);
		$('#deactivationdiv').hide();
		$('#activationdiv').show();
		
		
		
		}
		
		$('#indexsts_'+scenario_id).html(sts1);
		
			if(msg==1)
			{
			  //  var sts1 ='In Active';
			  //  $('#indexsts_'+scenario_id).html('Active');
			 
				//window.location.href = ajax_url+"scenarios/index/customer_id:"+customer_id+"&etype=success";
				//$('#progressimg').hide();
				//$('#progressOut').html('<div align="center" style="margin-top:100px;">COMPLETED</div>');				

			}else if(msg==2){
			
				$('#progressimg').show();
				// $('#indexsts_'+scenario_id).html('In Active');
				$('#progressOut').html('<div align="center" style="margin-top:10px;"><?php echo __(SCHEDULED, true) ?></div>');
			}else if(msg==4){
			
   			  //  $('#indexsts_'+scenario_id).html('In Active');
				//window.location.href = ajax_url+"scenarios/index/customer_id:"+customer_id+"&etype=error";
				//$('#progressimg').hide();
				//$('#progressOut').html('<div align="center" style="margin-top:100px;">COMPLETED</div>');
			}else{
			
				$('#progressimg').show();
				
				$('#progressOut').html('<div align="center" style="margin-top:10px;"><?php echo __(INPROGRESS, true) ?></div>');
			}
		}
	})
	//window.location.href = ajax_url+"scenarios/index/customer_id:"+customer_id+"&etype=success";
	setTimeout("check_status('"+scenario_id+"', '"+execution_id+"', '"+customer_id+"', '"+act+"');", 2000);

}
</script>
<style type="text/css">

.ui-slider-horizontal .ui-slider-handle{
    margin-left: -0.1em;
    top: -0.3em;
}
.ui-slider .ui-slider-handle {
    cursor: default;
    height: 1.2em;
    position: absolute;
    width: 1.2em;
    z-index: 2;
}
.ui-widget .ui-widget {
    font-size: 1em;
}
.ui-slider-horizontal {
    height: 0.8em;
}
.ui-slider {
    position: relative;
    text-align: left;
}
.ui-corner-all, .ui-corner-bottom, .ui-corner-right, .ui-corner-br {
    border-bottom-right-radius: 4px;
}
.ui-corner-all, .ui-corner-bottom, .ui-corner-left, .ui-corner-bl {
    border-bottom-left-radius: 4px;
}
.ui-corner-all, .ui-corner-top, .ui-corner-right, .ui-corner-tr {
    border-top-right-radius: 4px;
}
.ui-corner-all, .ui-corner-top, .ui-corner-left, .ui-corner-tl {
    border-top-left-radius: 4px;
}
.ui-datepicker-trigger {
    float: none !important;
    margin-left: 3px;

    margin-top: 5px;
}
.text input{
 height: 25px;
 
}
.submit input{
 height: 25px;
 margin: 10px 0px 0px 92px;
}

.form-box .form-left {
    float: left;
    margin: 0;
    padding: 0;
    width: 161px!important;}
	.fancybox-inner{
	 height: auto !important;
    overflow: auto;
    width: 400px !important;
}
</style>
<div class="container" style="width:100% !important;margin:0 !important;padding:0 !important; height:230px;">

<?php
	

if(isset($invalidFlag))
{
	?>
	<h1 style="width: 335px; text-align: left"><?php  __("Invalid Operation")?></h1>
	<hr style="width: 335px" >
	<br>
	<?php
	echo __("$invalidFlag", true);
	?>
	<div class="block" style="margin: 0px;">
		<div class="button-left">
			<?php echo $html->link( __("Reload", true),  array('controller'=> 'scenarios', 'action'=>'index', 'customer_id:' . $customer_id),array('onmouseover'=>'hoverButtonLeft(this);','onmouseout'=>'javascript:outButtonLeft(this);')); ?>
		</div>
	</div>
    <?php        
}
elseif(isset($deleteFlag))
{
	?>
	<h1 style="width: 335px; text-align: left"><?php  __("Delete Confirmation Operation")?></h1>
	<hr style="width: 335px" >
	<br>
	<?php
	echo __("$deleteFlag", true) . ' '  . $execution_id;
	
	#New Post COde
	
	echo $form->create('Scenario',array('action'=>'delete_schedule','id'=>'filters', 'class'=> 'form'));
	echo $form->input('scenario_id', array('type'=>'hidden','value'=>$scenario_id));
	echo $form->input('execution_id', array('type'=>'hidden','value'=>$execution_id));
	echo $form->submit(__('Delete', true), array('onclick'=>'return validate_form();','div'=>false, 'style'=>'height:27px;'));
	echo $form->end();		
	?>
	
	<!-- ORIG GET CODE --
	<div class="block" style="margin: 0px;">
		<div class="button-left">
			<?php #echo $html->link( __("Delete", true),  array('controller'=> 'scenarios', 'action'=>'delete_schedule', 'scenario_id:' . $scenario_id . '&execution_id=' . $execution_id),array('onmouseover'=>'hoverButtonLeft(this);','onmouseout'=>'javascript:outButtonLeft(this);')); ?>
		</div>
	</div>
	
	-->
<?php        
}
else
{
?>

	<div id="progressIn">
	<div id="overlay-error2" class="notification first hide" style="width: 100%" >
		
			<div class="error">
				<div class="message">
					
				</div>
			</div>
		</div>
	<h4 ><?php __('Create Schedule')?>
<div class='demonstrations'>
           <div style="font-size: 18px !important;"><a href="javascript:;"  style="cursor:pointer;" onMouseOver="Tip('<?php echo __('close_window') ?>', BALLOON, true, ABOVE, false)" onMouseOut="UnTip()" onclick="UnTip(); setTimeout( function() { $('.fancybox-overlay').trigger('click'); },5); ">X</a></div>
	        <div style="font-size: 18px !important;"><a href="javascript:;"  style="cursor:pointer" onclick="Tip('<b><?php echo __('createSchedule_helpTitel') ?></b><br/><?php echo __('createSchedule_helpText') ?>', BALLOON, true, ABOVE, false)" onMouseOut="UnTip()" >?</a></div>		
    		
 		</div>	
		</h4>
		
		
   <?php
			echo $form->create('Scenario',array('action'=>'create_schedule','id'=>'filters', 'class'=> 'form'));
			
			$options = array('ACTIVATE'=>__('ACTIVATE',true),'DEACTIVATE'=>__('DEACTIVATE', true));
			echo $form->input('Execution.customer_id', array('type'=>'hidden','value'=>$customer_id));
			if(isset($execution_id)){
				echo $form->input('Execution.id', array('type'=>'hidden','value'=>$execution_id));
				echo $form->input('Execution.status', array('type'=>'hidden','value'=>$this->data['Execution']['status']));
				
			}
			else
			{
				echo $form->input('Execution.status', array('type'=>'hidden','value'=>'SCHEDULED'));
				
			}
			echo $form->input('Execution.scenario_id', array('type'=>'hidden','value'=>$scenario_id)); ?>
            <div style="margin:20px 0px 0px 0px;">
            <?php
			
			if(@$act == 'activate' || @$act == 'deactivate')
			{ 
				echo $form->input('Execution.operation', array('type'=>'hidden','value'=>strtoupper($act)));
				echo $form->input('Execution.targetDate', array('type'=>'hidden','class'=>'date-pick','readonly'=>'readonly', 'style'=>'margin:10px 0px 5px 22px;'));
				echo $form->input('Execution.time', array('type'=>'hidden','class'=>'filter-class timepicker', 'style'=>'margin:0px 0px 5px 60px;', 'readonly'=>'readonly'));
			?>
				
				<div style="margin-left:25px"><?php echo __('Are you sure you want to ' . $act . ' scenario?', true) ?></div>
				<div style="margin-left:50px;">
				<input type='button' name='apply_now' id='apply_now' value="<?php echo strtoupper($act);?>" style="height:27px;" onclick="applynow('<?php echo $customer_id;?>','<?php echo strtoupper($act);?>');"/>
				</div>
				
								
			<?php
			}
			else
			{
				#echo $form->input('Execution.targetDate', array('type'=>'text','class'=>'date-pick','readonly'=>'readonly', 'style'=>'margin:10px 0px 5px 22px;'));
				#echo $form->input('Execution.time', array('type'=>'text','class'=>'filter-class timepicker', 'style'=>'margin:0px 0px 5px 60px;', 'readonly'=>'readonly')); ?>
				<div class="form-box">
				<div class="form-left">
				<div style="float:right">
					<label for="ExecutionOperation" style="vertical-align: top"><?php echo  __('Operation', true)?></label>
					<?php echo $form->input('Execution.operation', array('label' => false, 'div'=>false, 'options' => $options, 'empty'=>__('--Select--', true), 'style'=>'margin:0px 50px 5px 0px;width:105px; height:25px' ,'class'=>'form-change'));?>
					<div class="error">
						<div class="message">
						<span id="error_messages" style="display:none; color:red"></span>
						</div>
					</div>
				 </div>
				 <?php
				if(isset($execution_id)){
				
				echo $form->input('Execution.targetDate', array( 'type'=>'text','class'=>'date-pick form-change', 'style'=>'margin:10px 0px 5px 82px;')) ;
				echo $form->input('Execution.time', array(  'type'=>'text','class'=>'filter-class timepicker form-change', 'style'=>'margin:0px 0px 5px 120px')) ;
				}
				else
				{
					$today = date("d.m.Y");
					$nowTime = date("H:i");
					
				echo '<div style="float:right">';
				echo $form->input('Execution.targetDate', array( 'value' => $today,'type'=>'text','class'=>'date-pick form-change', 'style'=>'margin:0px 50px 5px 0px; vertical-align: middle; width: 98px;')) ;
				echo '</div>';
				echo '<div style="float:right">';
				echo $form->input('Execution.time', array('value' => $nowTime, 'type'=>'text','class'=>'filter-class timepicker form-change', 'style'=>'margin:0px 50px 5px 0px; vertical-align:top; width: 98px')) ;
				echo '</div>';
				
				}
				
				?>
				
				
				</div>
				<div class="form-right" style="width:200px;">
						<?php echo __('blurb_title'); ?>
					</div>
				</div>
				
				 <div style="clear:both;"></div>
				<div style="float:right;margin-top:20px;">
					<div>
					
					<div class="button-right">
                    <?php 
					
					
					
					echo $html->link(__("addActivation", true), 'javascript:void(null)', array('onmouseover' => 'hoverButtonRight(this)', 'onmouseout' => 'outButtonRight(this)', 'id' => 'addActivation',"onclick"=>"return validate_form();")); 
					
					
					?>	

                </div>
					
					
					
					
					
					
					
				     <?php //echo $form->submit(__('Schedule', true), array('onclick'=>'return validate_form();','div'=>false, 'style'=>'height:27px;  margin-left: 126px;')); ?>
					</div>				 
				</div>
			<?php 
			} 
			?></div>
			<?php echo $form->end();?>
			
				
		
			<?php pr($this->params['named']);?>
			</div>
			<div id="progresswh" style="display:none;">
				<div align="center" style="margin-top:100px;" id="progressimg"><?php echo $html->image('spinner1.gif');?></div>
				<div id='progressOut'></div>
			</div>
		<?php

		}

		?>
		

