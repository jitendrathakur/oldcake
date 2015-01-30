<div>
	<?php 
		if(!empty($blf_list)){
			foreach($blf_list as $list){?>
			<div class="cb"><?php echo $list['Stationkey']['id'];?></div>
		<?php }
		}else{?>
			<div class="cb" style="color:red"> No observers</div>
	<?php	}
	?>
</div>