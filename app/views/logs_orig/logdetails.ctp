<!--$Rev:: 22            $:  Revision of last commit--> 

<h1 style="width: 535px; text-align: left"><?php  __("Log Details")?></h1>
<hr style="width: 535px" >


<div style="color:#888784;padding:10px 10px 10px 10px;height:300px;">
	<div style="height:100px;">&nbsp;</div>
	<?php 
	if(isset($display)){?>
	
		<div class="fl" style="width:100px;"><?php __('Description') ?></div>
		<div class="fl" style="width:10px;">&nbsp;</div>
		<div class="fl" style="font-weight:bold"><?php echo $display['log_entry']?></div>	

		<div class="cb">&nbsp;</div>
		
		<div class="fl" style="width:100px;"><?php __('Status') ?></div>
		<div class="fl" style="width:10px;">&nbsp;</div>
		<div class="fl" style="font-weight:bold"><?php echo $display['modification_status']?></div>		
		
		<div class="cb">&nbsp;</div>
		
		<div class="fl" style="width:100px;"><?php __('Response') ?></div>
		<div class="fl" style="width:10px;">&nbsp;</div>
		<div class="fl" style="font-weight:bold"><?php echo $display['modification_response']?></div>
		
		<div class="cb">&nbsp;</div>
		
		<div class="fl" style="width:100px;"><?php __('Date') ?></div>
		<div class="fl" style="width:10px;">&nbsp;</div>
		<div class="fl" style="font-weight:bold"><?php echo $display['created']?></div>

	<?php }else{
		
		echo "Sorry not available";
		
	}?>
	<!--	
	<div class="block">
		<div class="button-right">
			<a href="javascript:void(null);"  onclick="javascript:return validate_cancel();" name="validate" value="validate" onmouseover="hoverButtonRight(this)" onmouseout="outButtonRight(this)">Cancel</a>
		</div>
	</div>
	-->
	
	
	
</div>
