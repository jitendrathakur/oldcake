<?php 

//echo $javascript->link('/js/jquery-1.10.1.min');
echo $javascript->link('/js/jquery.fancybox');
?>
<script type="text/javascript">
	$(document).ready(function() {
		$('.fancybox').fancybox();
	});
</script>


<div class="block top">
	<br>
	
	
	    <?php 
	    echo $form->create('Group',array('action'=>'add_group','id'=>'add_group','type'=>'POST'));	   ?>				
	    <div class="cb" style="width:540px;">
		
		<div class="form-box">
			<div class="form-left" style="height: 40px;">
					<?php 
					echo '<div style="width:100px; float: left">' . __('Group Type', true). '</div>';
					echo $form->input('Group.type', array('label' => false,'options' => array('madn' => 'MADN',
                   'cpu' => 'CPU','mlh' => 'MLH','dlh' => 'DLH'), 'empty' => '(choose one)','style'=>'width:100px; float: left'));
					
					?>			
					
			</div>
			<div class="form-right" style="height: 40px;">
					<?php 
					echo '<div style="width:100px; float: left">' . __('identifier', true). '</div>';
					
					echo $form->input('Group.identifier', array('label' => false,'style'=>'width:100px;'));	
					
                     echo $html->link( __("(Choose identifier)", true),  array('controller'=> 'groups', 'action'=>'dns_select'),array('class'=>'fancybox fancybox.ajax'));  				
					
					?>		
					
			</div>
			<div class="form-right" style="height: 40px;">
					<?php 
					echo '<div style="width:100px; float: left">' . __('groupName', true). '</div>';
					echo	$form->input('Group.name', array('label' => false,'value'=>$groupDetails['Group']['name'],'style'=>'width:100px;'));	?>		
					
			</div>
			<div class="form-right" style="height: 40px;">
					<?php 
					echo '<div style="width:100px; float: left">' . __('groupDesc', true). '</div>';
					echo	$form->input('Group.desc', array('label' => false,'value'=>$groupDetails['Group']['desc'],'style'=>'width:100px;'));

					echo $form->input('Group.customer_id', array('label' => false,'value'=>$customer_id, 'type'=>'hidden','style'=>'width:100px;'));

					?>		
					
			</div>
			<div class="form-left"></div>
			<div class="form-right">
					<?php 
					
					echo	$form->submit('submit', array('label' => false,'value'=>'submit','style'=>'width:100px;height:30px;float:right'));	?>		
					
			</div>
			
		</div>
		</div>
		<?php echo $form->end();

		?>

	</div>	