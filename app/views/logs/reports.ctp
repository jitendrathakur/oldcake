	<?php
echo $javascript->link('/js/jquery.fancybox');
echo $javascript->link('/js/timepicker');
?>
<script type="text/javascript">
    $(document).ready(function() {
        $('.fancybox').fancybox();
    });
</script>
<script type="text/javascript">
$(function()
	{
		 $( ".date-pick" ).datepicker({"seperator":"."});
		 $(".timepicker").timepicker({ampm: false, timeFormat:'hh:mm'});
	});
	
</script>
<script type="text/javascript">
		
		function toggleAdvanceSearch(){
		//$("#advancesearch").show
		if(document.getElementById('advancesearch').style.display=='none'){
			document.getElementById('advancesearch').style.display='block';
		}else{
			document.getElementById('advancesearch').style.display='none';
		}
	}
		
		function submi_formsss(form_id)
		{	
		   
			$('#'+form_id).submit();
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

.submit input{
 /*height: 25px;*/
 margin: 10px 0px 0px 92px;
}
.table-content .table-right-ohne{
	
	border-right: 1px solid #cccccc !important;;
}
</style>


	
	<!--$Rev:: 22            $:  Revision of last commit-->
	<div class="block top">
	
	<?php 
	echo $form->create('Log',array('action'=>'reports','id'=>'filters','type'=>'GET')); ?>
	<br>
		
		<div class="cb">
			<!--CBM START HERE -->
			<div id="" class="table-content">
				
			</div>
							<div style="margin:10px;">
					<a class="maintopRelatedContentButton" id="maintopContentButton" onclick="return toggleAdvanceSearch();" href="javascript:void(0)"><?php __('Advanced Filter') ?></a>
					</div>
				
			    	<?php
			    	if (isset($advancedFlag))
			    	{
			    		?>	
			    		<div class="table-content" style="display:block">
			    		<?php
			    	
			    	}
			    	else
			    	{
			    		?>
			    		<div id="advancesearch" class="table-content" style="display:none">
			    		<?php
			    	}?>
				    <table class="table-content phonekey">
						<thead>
							    <tr class="table-top">
									<th class="table-right-ohne">&nbsp;</th>	
									<th colspan='2' class="table-column" style="width:88px;text-align: left;" ><?php __("After Date")?></th>		

									<th colspan='2' class="table-column" style="width:88px;text-align: left;"><?php __("Before Date")?></th>		
	
									<th class="table-right-ohne">&nbsp;</th>											
							    </tr>
							    <tr>
							    <td style="height: 10px; border: none; " class="table-column table-left-ohne">&nbsp;</td>
							    <td style="height: 10px; padding:0px 0px 0px 12px;"><?php echo __('Date', true) ?></td>
							    <td style="height: 10px;  padding:0px 0px 0px 12px;"><?php echo __('Time', true) ?></td>
							    <td style="height: 10px; padding:0px 0px 0px 12px;" ><?php echo __('Date', true) ?></td>
							    <td style="height: 10px; padding:0px 0px 0px 12px;"><?php echo __('Time', true) ?></td>
							    <td style="height: 10px; border: none" class="table-right-ohne">&nbsp;</td>
							    </tr>
							    <tr>
									<td class="table-column table-left-ohne">&nbsp;</td>
									<td>
									<?php #echo $form->input('Log.afterdate', array('type'=>'text','class'=>'date-pick', 'style'=>'margin:4px 4px 5px 8px;', 'label'=>false, 'div'=>false, 'value'=>(isset($this->params['named']['afterdate'])?$this->params['named']['afterdate']:(isset($this->params['url']['afterdate'])?$this->params['url']['afterdate']:''))));?>
									<?php echo $form->input('Log.afterdate', array('type'=>'text','class'=>'date-pick', 'style'=>'margin:4px 4px 5px 8px;', 'label'=>false, 'div'=>false, 'value'=>(isset($this->passedArgs['afterdate'])?$this->passedArgs['afterdate']:'')));?>
									</td>
									<td>
									<?php #echo $form->input('Log.aftertime', array('type'=>'text','class'=>'filter-class timepicker', 'style'=>'margin:4px 4px 5px 8px','label'=>false, 'value'=>(isset($this->params['named']['aftertime'])?$this->params['named']['aftertime']:(isset($this->params['url']['aftertime'])?$this->params['url']['aftertime']:'')))) ;?>
									<?php echo $form->input('Log.aftertime', array('type'=>'text','class'=>'filter-class timepicker', 'style'=>'margin:4px 4px 5px 8px','label'=>false, 'value'=>(isset($this->passedArgs['aftertime'])?$this->passedArgs['aftertime']:''))) ;?>
									</td>
									<td>
									<?php #echo $form->input('Log.beforedate', array('type'=>'text','class'=>'date-pick', 'style'=>'margin:4px 4px 5px 8px;', 'label'=>false, 'div'=>false, 'value'=>(isset($this->passedArgs['beforedate'])?$this->passedArgs['beforedate']:isset($this->params['named']['beforedate'])?$this->params['named']['beforedate']:(isset($this->params['url']['beforedate'])?$this->params['url']['beforedate']:''))));?>
									<?php echo $form->input('Log.beforedate', array('type'=>'text','class'=>'date-pick', 'style'=>'margin:4px 4px 5px 8px;', 'label'=>false, 'div'=>false, 'value'=>(isset($this->passedArgs['beforedate'])?$this->passedArgs['beforedate']:'')));?>
									</td>									
									<td>
									<?php #echo $form->input('Log.beforetime', array('type'=>'text','class'=>'filter-class timepicker', 'style'=>'margin:4px 4px 5px 8px','label'=>false, 'value'=>(isset($this->params['named']['beforetime'])?$this->params['named']['beforetime']:(isset($this->params['url']['beforetime'])?$this->params['url']['beforetime']:'')))) ;?>
									<?php echo $form->input('Log.beforetime', array('type'=>'text','class'=>'filter-class timepicker', 'style'=>'margin:4px 4px 5px 8px','label'=>false, 'value'=>(isset($this->passedArgs['beforetime'])?$this->passedArgs['beforetime']:''))) ;?>
									</td>
									<td class="table-right-ohne">&nbsp;</td>
							    </tr>
							   
						</thead>
				    </table>
			</div>
			<!-- ---------------------------------------------------------------------------------------------- -->
			
			<div class="block" style="margin: 0px;">
			<div class="button-right">
				<a href="javascript:void(null)"  onclick="javascript:submi_formsss('filters');" name="data[filter]" value="filter" onmouseover="hoverButtonRight(this)" onmouseout="outButtonRight(this)"><?php __("filter");?></a> 
				</div>
				<div class="button-right">
					<?php echo $html->link( __("Export Csv", true),  array('controller'=> 'customers', 'action'=>'export_statistics', $customer_val),array('onmouseover'=>'hoverButtonRight(this);','onmouseout'=>'javascript:outButtonRight(this);')); ?>
				</div>
			</div>
			
			
			
			
			
			
			<?php
			if ($customer_val == 'GLOBAL')
			{
			?>
			
			
			
			
			<h2><?php __('PHONE_USAGE STATISTICS') ?></h2>
				<div id="" class="table-content">
				
				<table class="table-content phonekey" style="table-layout: fixed; width: 400px">

					<tbody>

					<!-- TOTAL -->
					<tr>
					<td class="table-left">&nbsp;</td>
					<td class= "table-right-ohne" style="width:300px"><?php echo __('User logged in', true); ?></td>
					<td class="table-left-ohne" style="width:50px;"><?php echo $totalPhoneLogonCount;?></td>
					<td class= "table-right-ohne"></td>
					</tr>
					<tr>
	        		<?php
	            		foreach($phoneLogonCount as $logonTyp):
	            		
	            		?>
						<td class="table-left">&nbsp;</td>
						<td class= "table-right-ohne" style="width:300px"><?php 
						if (($logonTyp['Log']['customer_id'] == '') || ($logonTyp['Log']['customer_id'] == 'SWIV'))
						{
							echo __('LOGON_INTERNAL', true);
						} 
						else 
						{
							echo __('LOGON ', true) . $logonTyp['Log']['customer_id'];
						} 
						?></td>
						<td class="table-left-ohne" style="width:50px;"><?php echo $logonTyp[0]['count(`Log`.`id`)']; ?></td>
						<td class= "table-right-ohne"></td>
						</tr>
						<?php endforeach; ?>
						
						</tr>
						<tr>
						
						<?php foreach($phoneUsageCount as $phoneUsageTyp):
	            		
	            		?>
						<td class="table-left">&nbsp;</td>
						<td class= "table-right-ohne" style="width:300px"><?php echo __($phoneUsageTyp[0]['sub']);	?></td>
						<td class="table-left-ohne" style="width:50px;"><?php echo $phoneUsageTyp[0]['count(`Log`.`id`)']; ?></td>
						<td class= "table-right-ohne"></td>
						</tr>
						<?php endforeach; ?>
		        	</tr>
					</tbody>
					</table>
					</div>
	        		<h2><?php __('GATE_USAGE STATISTICS') ?></h2>
					<div id="" class="table-content">
				
					<table class="table-content phonekey" style="table-layout: fixed; width: 400px">

					<tbody>
					<!-- TOTAL -->
					<tr>
					<td class="table-left">&nbsp;</td>
					<td class= "table-right-ohne" style="width:300px"><?php echo __('User logged in', true); ?></td>
					<td class="table-left-ohne" style="width:50px;"><?php echo $totalGateLogonCount;?></td>
					<td class= "table-right-ohne"></td>
					</tr>
					<tr>
	        		<?php
	            		foreach($gateLogonCount as $logonTyp):
	            		
	            		?>
						<td class="table-left">&nbsp;</td>
						<td class= "table-right-ohne" style="width:300px"><?php 
						if (($logonTyp['Log']['customer_id'] == '') || ($logonTyp['Log']['customer_id'] == 'SWIV'))
						{
							echo __('LOGON_INTERNAL', true);
						} 
						else 
						{
							echo __('LOGON ', true) . $logonTyp['Log']['customer_id'];
						} 
						?></td>
						<td class="table-left-ohne" style="width:50px;"><?php echo $logonTyp[0]['count(`Log`.`id`)']; ?></td>
						<td class= "table-right-ohne"></td>
						</tr>
						<?php endforeach; ?>
						
												</tr>
						<tr>
						
						<?php foreach($gateUsageCount as $gateUsageTyp):
	            		
	            		?>
						<td class="table-left">&nbsp;</td>
						<td class= "table-right-ohne" style="width:300px"><?php echo __($gateUsageTyp[0]['sub']);	?></td>
						<td class="table-left-ohne" style="width:50px;"><?php echo $gateUsageTyp[0]['count(`Log`.`id`)']; ?></td>
						<td class= "table-right-ohne"></td>
						</tr>
						<?php endforeach; ?>
		        	</tr>
					</tbody>
					</table>
					</div>
			<?php  } ?>
			
			
				
			<!-- -->
			
			</div>
	<?php echo $form->end(); ?>
	
	<div>
	<h2><?php echo "top 15 activation users";  ?></h2>
	  <table class="table-content phonekey" style="table-layout: fixed; width: 400px" cellpadding="0" cellspacing="0">
	  <tbody>
	  	<tr> 
		<td class="table-left" width="20px">&nbsp;</td>
		<td>Name</td><td>Total count logon</td></tr>
		<?php foreach($activationUser as $activeuser){ ?>
		<tr >
		<td class="table-left"  width="20px"	>&nbsp;</td>
				<td class= "table-right-ohne"><?php echo $activeuser['Log']['user'];   ?></td><td class= "table-right-ohne"><?php echo $activeuser['0']['count(`Log`.`id`)']    ?></td></tr>
		
		
		
		<?php } ?>
		</tbody>
	  </table>
	 
	<h2><?php echo "top 15 logon users";   ?></h2>
	<table class="table-content phonekey" style="table-layout: fixed; width: 400px" cellpadding="0" cellspacing="0">
	  <tbody>
	  	<tr> 
		<td class="table-left" width="20px">&nbsp;</td>
		<td>Name</td><td>Total count logon</td></tr>
		<?php foreach($logonUser as $logUser){ ?>
		<tr >
		<td class="table-left"  width="20px"	>&nbsp;</td>
				<td class= "table-right-ohne"><?php echo $logUser['Log']['user'];   ?></td><td class= "table-right-ohne"><?php echo $logUser['0']['count(`Log`.`id`)']    ?></td></tr>
		
		
		
		<?php } ?>
		</tbody>
	  </table>
	
	 </div>
	
	
	
	</div>
</div>
                <!--right hand side starts from here-->
<div id="related-content">
	<div class="box start link">
        	<a href="http://www.swisscom.ch/<?php __('corporatebusiness') ?>" target="_blank">
			<?php __('Home Swisscom') ?>
                 </a>
         </div>

         <div class="box info">
        	 <h3><?php __('Reports') ?></h3>
                 <p>
                  <?php __('Reports_blurb') ?>
                 </p>
        </div>

</div>
<!--ight hand side  ends here-->
