<?php
	echo $javascript->link('front');
	?>
<!--$Rev:: 22            $:  Revision of last commit-->
	<div class="block top">
	
	<?php
		echo $form->create('Scenario', array (
			'action' => 'index',
			'id' => 'filters',
			'type' => 'GET'
		));
	?>
<?php echo $form->input('customer_id', array('type'=>'hidden','value'=>$SELECTED_CUSTOMER_NAME)); ?>
	<br>
		
		<div class="cb">
			<!--CBM START HERE -->
			<div id="" class="table-content">
				<table class="table-content phonekey">
					<thead>
						<tr class="table-top">
							<th class="table-column table-left-ohne" style="width:20px;">&nbsp;</th>
							<th  class="table-column"style="width:481px;text-align: left;"><?php __("Scenario Name");?></th>
							<th class="table-right-ohne">&nbsp;</th>
						</tr>
						
						<tr>
							<td class="table-column table-left-ohne">&nbsp;</td>
							<td><?php echo $form->input('name', array('label' => false, 'type'=>'text','class' => 'filter-class onclick','style'=>'width:451px;')); ?></td>
							<td class="table-right-ohne">&nbsp;</td>
						</tr>
					</thead>
					<tbody>
				</table>
			</div>
			
			<div class="block" style="margin: 0px;">
				<div class="button-right">
					<?php echo $html->link( __("Export Csv", true),  array('controller'=> 'customers', 'action'=>'export'),array('onmouseover'=>'hoverButtonRight(this);','onmouseout'=>'javascript:outButtonRight(this);')); ?>
					
				</div>
				<div class="button-right">
					<a href="javascript:void(null)"  onclick="javascript:submi_form('filters');" name="data[filter]" value="filter" onmouseover="hoverButtonRight(this)" onmouseout="outButtonRight(this)"><?php __("filter");?></a>
				</div>
				<div class="button-left">
					<a href="javascript:void(null)"  onclick="javascript:submi_reset('customers');" name="data[reset]" value="reset" onmouseover="hoverButtonLeft(this)" onmouseout="outButtonLeft(this)"><?php __("reset");?></a>
				</div>
				
                        </div>

				<!--CBM END HERE -->
			<!--CBM START HERE -->
			<div id="" class="table-content">
				<?php echo $this->element('pagination/newpaging');?>
				<table class="table-content phonekey">
					<thead>
						<tr class="table-top">
							<th class="table-column table-left-ohne" style="width:20px;">&nbsp;</th>
							<th  class="table-column <?php if(in_array('sort:name',$filter_sort) && in_array('direction:asc',$filter_sort)) echo  'sortlink_asc';elseif((in_array('sort:name',$filter_sort) && in_array('direction:desc',$filter_sort))) echo 'sortlink_desc';else echo 'sortlink';?>"style="width:140px;text-align: left;"><?php echo $paginator->sort(__("Scenario Name",true), 'name', $filter_options);?></th>
							<th  class="table-column <?php if(in_array('sort:status',$filter_sort) && in_array('direction:asc',$filter_sort)) echo  'sortlink_asc';elseif((in_array('sort:status',$filter_sort) && in_array('direction:desc',$filter_sort))) echo 'sortlink_desc';else echo 'sortlink';?>" style="width:63px;text-align: left;"><?php echo $paginator->sort(__("Status",true), 'status', $filter_options);?></th>
							<th  class="table-column <?php if(in_array('sort:targetDate',$filter_sort) && in_array('direction:asc',$filter_sort)) echo  'sortlink_asc';elseif((in_array('sort:targetDate',$filter_sort) && in_array('direction:desc',$filter_sort))) echo 'sortlink_desc';else echo 'sortlink';?>" style="width:180px;text-align: left;"><?php echo $paginator->sort(__("Schedule",true), 'targetDate', $filter_options);?></th>
							<th class="table-right-ohne">&nbsp;</th>
						</tr>
					</thead>
					<tbody>

				<!--CBM END HERE -->
				
	        		<?php	
	
	// initialise a counter for striping the table
	$count = 0;

	// loop through and display format
	foreach ($scenarios as $scenario)
		:
		// stripes the table by adding a class to every other row
		$class = (($count % 2) ? " class='altrow'" : '');
	// increment count
	$count++;
?>
		        		<tr onmouseover="hoverRow(this,true);" onmouseout="hoverRow(this,false);">
		        		<td class="table-left">&nbsp;</td>
					<td><?php echo $html->link($scenario['Scenario']['Name'],  array('controller'=> 'stations', 'action'=>'index', $scenario['Scenario']['id'])); ?></td>
					<td><?php echo $html->link($scenario['Scenario']['status'],  array('controller'=> 'stations', 'action'=>'index', $scenario['Scenario']['id'])); ?></td>
					<td>
						<table>
							<?php 
							$iterateExecutions = 0;
							$execRecords = count($scenario['Execution'])-1;
							while ($iterateExecutions <= $execRecords)
							{
								
							?>
							<tr>
								<td>
									<?php echo $html->link($scenario['Execution'][$iterateExecutions]['operation'],  array('controller'=> 'stations', 'action'=>'index', $scenario['Scenario']['id'])); ?>
								</td>
								<td>
									<?php echo $html->link($scenario['Execution'][$iterateExecutions]['targetDate'],  array('controller'=> 'stations', 'action'=>'index', $scenario['Scenario']['id'])); ?>
								</td>
								<td>
									<?php echo $html->link('Edit Schedule',"javascript:void(0)",array('class'=>"ajax_page","rel"=>$scenario['Execution'][$iterateExecutions]['id'],'id'=>"edit",'rel1'=>$SELECTED_CUSTOMER_NAME)); ?>
								</td>
								<td>
									<?php echo $html->link('Delete Schedule',  array('controller'=> 'scenarios', 'action'=>'delete_schedule', $scenario['Scenario']['id'],$scenario['Execution'][$iterateExecutions]['id']),null,'Are you sure to delete?'); ?>
								</td>
								<td align="center">
									<?php
									if($scenario['Execution'][$iterateExecutions]['status']=='SCHEDULED'){
										echo "<span style='color:red'>".$scenario['Execution'][$iterateExecutions]['status']."</span>";
									}elseif($scenario['Execution'][$iterateExecutions]['status']=='INPROGRESS'){
										echo $html->image('spinner1.gif');
									}else{
										echo "<span style='color:green'>".$scenario['Execution'][$iterateExecutions]['status']."</span>";
									}
									?>
								</td>
							</tr>
							<?php
							$iterateExecutions++;
							}
							?>
						
						</table>
					</td>
					<td class="table-right-ohne" style="width:60px;">
					<?php echo $html->link("Create Schedule","javascript:void(0)",array('class'=>'ajax_page','rel'=>$scenario['Scenario']['id'],'rel1'=>$SELECTED_CUSTOMER_NAME))?>
					</td>
		            		<td class="table-right-ohne">&nbsp;</td>
		        		</tr>
	        		<?php endforeach; ?>
				
				
				
					</tbody>
				</table>
			</div>
			</div>
	<?php echo $form->end(); ?>
	<?php echo $this->element('pagination/newpaging');?>
	</div>
	</div>
                <!--right hand side starts from here-->
<!--ight hand side  ends here-->