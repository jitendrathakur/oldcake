<!--$Rev:: 22            $:  Revision of last commit--> 
<script type="text/javascript">
$.ajaxSetup({ cache: false });
</script>
<script>
	function fancyboxclose(){
		setTimeout( function() { $('.fancybox-overlay').trigger('click'); },5);
		}
</script>
<h4 style="width: 535px; text-align: left"><?php  __("Script Details")?>
	<div class='demonstrations'>           
		   <div style="font-size: 18px !important;"> <a href="javascript:;"  style="cursor:pointer;" onMouseOver="Tip('<?php echo __('close_window') ?>', BALLOON, true, ABOVE, false)" onMouseOut="UnTip()" onclick="UnTip(); return fancyboxclose(); ">X</a></div>		  
	        
			<div style="font-size: 18px !important;"><a href="javascript:;"  style="cursor:pointer" onMouseOver="Tip('<b><?php echo __('scriptSummary_helpTitel') ?></b><br/><?php echo __('scriptSummary_helpText') ?>', BALLOON, true, ABOVE, false)" onMouseOut="UnTip()" >?</a></div>				
    		
 	  </div>
</h4>



<div style="color:#888784;padding:10px 10px 10px 10px;height:300px;">
	<div style="height:20px;">&nbsp;</div>
	<?php 
	if(isset($display)){?>
	
		<div class="fl" style="width:100px;"><?php __('_scenarioName') ?></div>
		<div class="fl" style="width:10px;">&nbsp;</div>
		<div class="fl" style="font-weight:bold"><?php echo $display['Name']?></div>	
		<br>
		<!--
		<div class="cb">&nbsp;</div>
		-->
		
		<div class="fl" style="width:100px;"><?php __('Last Modified') ?></div>
		<div class="fl" style="width:10px;">&nbsp;</div>
		
		<div class="fl" style="font-weight:bold"><?php echo  date('d.m.Y H:i:s',strtotime($display['modified']))?></div>
		
		<br>
		<br>
		
		<?php echo $display['Summary']?>
		
		

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
