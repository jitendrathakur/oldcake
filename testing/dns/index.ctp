	<div class="block top">
	<br>
	
		<?php 
	echo $form->create('Dns',array('action'=>'index','id'=>'filters')); ?>
	<div class="cb">
		    <div id="" class="table-content">
				<table class="table-content phonekey">
					<thead>
						<tr class="table-top">
							<th class="table-column table-left-ohne" style="width:20px;">&nbsp;</th>
							<th  class="table-column"style="width:338px;text-align: left;"><?php __("Name");?></th>
							<th  class="table-column" style="width:63px;text-align: left;"><?php __("CNN");?></th>
							<th  class="table-column" style="width:80px;text-align: left;"><?php __("BSK");?></th>
							<th class="table-right-ohne">&nbsp;</th>
						</tr>
						
						<tr>
							<td class="table-column table-left-ohne">&nbsp;</td>
							<td><?php echo $form->input('name', array('label' => false, 'type'=>'text','class' => 'filter-class onclick','style'=>'width:328px;')); ?></td>
							<td><?php echo $form->input('id',  array('label' => false,'type'=>'text','class' => 'filter-class onclick', 'style'=>'width:53px;')); ?></td>
							<td><?php echo $form->input('bsk',  array('label' => false,'type'=>'text','class' => 'filter-class onclick', 'style'=>'width:70px;')); ?></td>
							<td class="table-right-ohne">&nbsp;</td>
						</tr>
					</thead>
					<tbody>
				</table>
			</div>
			
			<div class="block" style="margin: 0px;">
				<div class="button-right">
					<a href="javascript:void(null)"  onclick="javascript:submi_form('filters');" name="data[filter]" value="filter" onmouseover="hoverButtonRight(this)" onmouseout="outButtonRight(this)"><?php __("filter");?></a>
				</div>
				
				
				<div class="button-left">
					<a href="javascript:void(null)"  onclick="javascript:submi_reset('dns');" name="data[reset]" value="reset" onmouseover="hoverButtonLeft(this)" onmouseout="outButtonLeft(this)"><?php __("reset");?></a>
				</div>
				
                        </div>
	
	    <?php
	
		
		// check $locations variable exists and is not empty
		if(isset($dns) && !empty($dns)) :
		?>
		<!--Showing Page <?php //echo $paginator->counter(); ?>-->  
		
		<?php //echo $this->element('pagination/top'); ?>
	    <div id="" class="table-content">
		<table class="phonekey">
	    	<?php
echo $this->element('pagination/newpaging');
?>
	    	<thead>
	        	<tr class="table-top">
	        	<th class="table-column table-left-ohne">&nbsp;</th>
			
			<th class="table-column <?php if(in_array('sort:name',$filter_sort) && in_array('direction:asc',$filter_sort)) echo  'sortlink_asc';elseif((in_array('sort:name',$filter_sort) && in_array('direction:desc',$filter_sort))) echo 'sortlink_desc';else echo 'sortlink';?>"style="width:140px;text-align: left;"><?php echo $paginator->sort(__(dnId",true), 'id', $filter_options);?></th>
			<th class="table-column <?php if(in_array('sort:name',$filter_sort) && in_array('direction:asc',$filter_sort)) echo  'sortlink_asc';elseif((in_array('sort:name',$filter_sort) && in_array('direction:desc',$filter_sort))) echo 'sortlink_desc';else echo 'sortlink';?>"style="width:140px;text-align: left;"><?php echo $paginator->sort(__("Range Name",true), 'rangeName', $filter_options);?></th>
			<th class="table-column" style="width:200px;text-align: left;">Location Name</th>
			<th class="table-column <?php if(in_array('sort:name',$filter_sort) && in_array('direction:asc',$filter_sort)) echo  'sortlink_asc';elseif((in_array('sort:name',$filter_sort) && in_array('direction:desc',$filter_sort))) echo 'sortlink_desc';else echo 'sortlink';?>"style="width:60px;text-align: left;"><?php echo $paginator->sort(__("Status",true), 'status', $filter_options);?></th>
	            </tr>
	        </thead>
		<?php //echo $this->element('pagination/top'); ?>
	        <tbody>
	        	<?php
				// initialise a counter for striping the table
				$count = 0;
	
				// loop through and display format
				foreach($dns as $dn):
					// stripes the table by adding a class to every other row
					$class = ( ($count % 2) ? " class='altrow'": '' );
					// increment count
					$count++;
				?>
	            <tr onmouseover="hoverRow(this,true);" onmouseout="hoverRow(this,false);">
	             	<td class="table-left">&nbsp;</td>
	            	<td> <?php echo $html->link($dn['Dns']['id'],array('controller'=>'stations', 'action'=>'edit', $stations['Station']['id']));?>
	                <td class="table-content column-width-100" style="width:125px;">
	                <?php echo $dn['Dns']['rangeName']; ?>
			</td>
			<td class="table-content column-width-100" style="width:125px;">
	                <?php echo $dn['Location']['name']; ?>
			</td>
	                <td><?php echo $dn['Dns']['status']; ?></td>
		    </tr>
	            <?php endforeach; ?>
	        </tbody>

	    </table>
	    <?php echo $form->end(); ?>
	<?php echo $this->element('pagination/newpaging'); ?>
	</div>
	    </div>
	   
	    <?php
		else:
			__("No Dns available in DB");
		endif;
		?>
	 
                <div class="button-left">
                	<?php if($userpermission==Configure::read('access_id'))
                	{
				echo $html->link(__('Back', true),  array('controller'=> 'customers', 'action'=>'index'),array('onmouseover'=>'javascript:hoverButtonLeft(this);','onmouseout'=>'javascript:outButtonLeft(this);')); 
	
                        	#echo $html->link('back',  array('controller'=> 'stations', 'action'=>'edit', $station_number));
                	}
                	?>
                </div>
	</div>
</div>
<!--right hand side starts from here-->
<div id="related-content">
        <div class="box start link">
                <a href="http://www.swisscom.ch/grossunternehmen" target="_blank">
                <?php __('Home Swisscom') ?>
                </a>
        </div>

<!--INTERNAL USER OPTIONS -->
        <?php if($userpermission==Configure::read('access_id'))
        {?>
                <div class="box info">
                <h3><?php __("Internal User");?></h3>
                <p><?php __("Customer View:");?></p>
                <p><?php echo $selected_customer; ?></p>

                </div>
	<?php } ?>

		</div>
<!--ight hand side  ends here-->

