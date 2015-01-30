<?php
echo $html->css("tooltip");
?>
<script type="text/javascript">
jQuery(document).ready(function(){ 
    /** code to select all filteres records : start **/
	$('.reset').click(function(){ 
		var checkboxes = $(this).closest('form').find(':checkbox');
		checkboxes.removeAttr('checked');
	});
	$('#addChecked').on("click",function(){  
		var count = 0;
		$('form input[type="search"]').each(function(){
				if($(this).val()!=""){ count++; }
		}); 
		if(count==0){ 
			//var checkboxes = $(this).closest('form').find(':checkbox'); 
			var checkboxes = $(this).closest('form').find('input[type=checkbox]:not(:disabled)'); 
			checkboxes.attr('checked', 'checked');
		}else{  
			/** add script to check all checkbox who does not fall under hidden tr **/
			var checkboxes = $( "table.dataTable tr:visible" ).find('input[type=checkbox]:not(:disabled)');
			//var checkboxes1 = jQuery( tr:(.filtered)).find(':checkbox');
			checkboxes.attr('checked', 'checked');
		}
	});
	  /** code to select all filteres records : ends **/
	
    $('#removeChecked').on("click",function(){ 
		var count = 0;
		$('form input[type="search"]').each(function(){
				if($(this).val()!=""){ count++; }
		}); 
		if(count>0){ 
			var checkboxes = $( "table.dataTable tr:visible" ).find(':checkbox');
			checkboxes.removeAttr('checked');
		}
	});

 });
 function submit_odsentries(id){
    //var trainindIdArray;
    if($('input.selectdnsCheckbox').filter(":checked").length > 0){ 
	    $('.filtersForm').attr('action',base_url+'odsentries/index/');
		$('.filtersForm').attr('method','POST');
		//$('#filters').submit();
		$.ajax({
				type: "POST",
				async : false,
				dataType: 'json',
				url: $('.filtersForm').attr('action'),
				data: $('.filtersForm').serialize(),
				success: function(data){  
					if(data.message=="Success"){
					    alert('Data inserted successfully');
						 $.each(data.selectdnsCheckbox, function(index,key) { 
							$("."+key).closest("tr").addClass("insertedDNStyle"); // add class to change tr background color 
							$("."+key).closest("tr").find('.entryStatus').text("Added"); // add class to change tr background color 
							$("."+key).attr("disabled", true);  // disable checkboxes
						});  
						$('.reset').click();
					} else {
						alert('Some error occured, Please try again');
					} 
				}
			});
	}else{
	 	alert("Please select at least one record");
	}
 }
jQuery(function() {
	jQuery.extend(jQuery.tablesorter.themes.bootstrap, {
		// these classes are added to the table. To see other table classes available,
		// look here: http://twitter.github.com/bootstrap/base-css.html#tables
		table      : 'table table-bordered',
		header     : 'bootstrap-header', // give the header a gradient background
		footerRow  : '',
		footerCells: '',
		icons      : '', // add "icon-white" to make them white; this icon class is added to the <i> in the header
		sortNone   : 'bootstrap-icon-unsorted',
		sortAsc    : 'icon-chevron-up',
		sortDesc   : 'icon-chevron-down',
		active     : '', // applied when column is sorted
		hover      : '', // use custom css here - bootstrap class may not override it
		filterRow  : '', // filter row class
		even       : '', // odd row zebra striping
		odd        : ''  // even row zebra striping
	});

	// call the tablesorter plugin and apply the uitheme widget
	jQuery(".dataTable").tablesorter({
		// this will apply the bootstrap theme if "uitheme" widget is included
		// the widgetOptions.uitheme is no longer required to be set
		theme : "bootstrap",

		widthFixed: true,

		headerTemplate : '{content} {icon}', // new in v2.7. Needed to add the bootstrap icon!

		// widget code contained in the jquery.tablesorter.widgets.js file
		// use the zebra stripe widget if you plan on hiding any rows (filter widget)
		widgets : [ "uitheme", "filter", "zebra" ],

		widgetOptions : {
			// using the default zebra striping class name, so it actually isn't included in the theme variable above
			// this is ONLY needed for bootstrap theming if you are using the filter widget, because rows are hidden
			zebra : ["even", "odd"],

			// reset filters button
			filter_reset : ".reset"

			// set the uitheme widget to use the bootstrap theme class names
			// this is no longer required, if theme is set
			// ,uitheme : "bootstrap"

		},
		
		headers: { 
		0: {sorter: false,filter: false},
		8: {sorter: false,filter: false}

		} 
	})
	.tablesorterPager({

		// target the pager markup - see the HTML block below
		container: jQuery(".pager"),

		// target the pager page select dropdown - choose a page
		cssGoto  : ".pagenum",

		// remove rows from the table to speed up the sort of large tables.
		// setting this to false, only hides the non-visible rows; needed if you plan to add/remove rows with the pager enabled.
		removeRows: false,

		// output string - default is '{page}/{totalPages}';
		// possible variables: {page}, {totalPages}, {filteredPages}, {startRow}, {endRow}, {filteredRows} and {totalRows}
		output: '{startRow} - {endRow} / {filteredRows} ({totalRows})'

	});

});
</script>
<div class="block top">
	<br>
	
	    <?php 
	    echo $form->create('Dns',array('action'=>'selectdns','id'=>'filters','class'=>'filtersForm','type'=>'GET'));
	    echo $form->input('Location.customer_id', array('type'=>'hidden','value'=>$custId)); 
	   ?>
	    <div class="cb">
			<!--<div id="" class="table-content">
				    <table class="table-content phonekey">
						<thead>
							    <tr class="table-top">
									<th class="table-column table-left-ohne" style="width:20px;">&nbsp;</th>
									<th  class="table-column"style="width:102px;text-align: left;"><?php __("Id");?></th>
									<th  class="table-column"style="width:96px;text-align: left;"><?php __("Location");?></th>
									<th  class="table-column"style="width:88px;text-align: left;"><?php __("Function");?></th>
									<th  class="table-column"style="width:102px;text-align: left;"><?php __("DISPLAYNAME");?></th>
									<th class="table-column" style="width:96px;"><span><?php __("Emergency")?>&nbsp</span></th>
									<th class="table-column" style="width:96px;"></th>
									<th class="table-right-ohne">&nbsp;</th>
							    </tr>
						 	
							    <tr>
									<td class="table-column table-left-ohne">&nbsp;</td>
									<td><?php echo $form->input('id', array('label' => false, 'type'=>'text','class' => 'filter-class onclick','style'=>'width:88px;', 'value'=>(isset($this->params['named']['id'])?$this->params['named']['id']:(isset($this->params['url']['id'])?$this->params['url']['id']:'')))); ?></td>
									<td><?php echo $form->select('location_id', $locations,(isset($this->params['named']['location_id'])?$this->params['named']['location_id']:(isset($this->params['url']['location_id'])?$this->params['url']['location_id']:'')),array('style'=>'width:88px;','onchange'=>"javascript:submi_form('filters');")); ?></td>
									<td><?php echo $form->select('function',$func_list,(isset($this->params['named']['function'])?$this->params['named']['function']:(isset($this->params['url']['function'])?$this->params['url']['function']:'')),array('style'=>'width:78px;','onchange'=>"javascript:submi_form('filters');")); ?></td>
									<td><?php echo $form->input('display', array('label' => false, 'type'=>'text','class' => 'filter-class onclick','style'=>'width:88px;', 'value'=>(isset($this->params['named']['display'])?$this->params['named']['display']:(isset($this->params['url']['display'])?$this->params['url']['display']:'')))); ?></td>
									<td><?php echo $form->select('emer', $emer_list,(isset($this->params['named']['emer'])?$this->params['named']['emer']:(isset($this->params['url']['emer'])?$this->params['url']['emer']:'')),array('style'=>'width:88px;','onchange'=>"javascript:submi_form('filters');")); ?></td>
									<td><?php echo $form->select('ods', $emer_list,(isset($this->params['named']['ods'])?$this->params['named']['ods']:(isset($this->params['url']['ods'])?$this->params['url']['ods']:'')),array('style'=>'width:88px;','onchange'=>"javascript:submi_form('filters');")); ?></td>
									<td><?php echo $form->select('trunk', $emer_list,(isset($this->params['named']['trunk'])?$this->params['named']['trunk']:(isset($this->params['url']['trunk'])?$this->params['url']['trunk']:'')),array('style'=>'width:88px;','onchange'=>"javascript:submi_form('filters');")); ?></td>
									<td>&nbsp;</td>
									<td class="table-right-ohne">&nbsp;</td>
							    </tr>
						</thead>
				    </table>
			</div>-->
			
			<div class="block" style="margin: 0px;">
				<div class="button-right">
				<?php echo $html->link( __("Export Csv", true),  array('controller'=> 'dns', 'action'=>'export'),array('onmouseover'=>'hoverButtonRight(this);','onmouseout'=>'javascript:outButtonRight(this);')); ?>
				</div>
				
				<div class="button-left">
					<?php echo $html->link( __("reset", true),'javascript:void(0);',array('onmouseover'=>'javascript:hoverButtonLeft(this);','onmouseout'=>'javascript:outButtonLeft(this);','class'=>'reset')); ?>
                </div>
				
            </div>
	
	    <?php
	
		
		// check $locations variable exists and is not empty
		if(isset($dns) && !empty($dns)) : 
		?>
		<!--Showing Page <?php //echo $paginator->counter(); ?>-->  
		
		<?php //echo $this->element('pagination/top');?>
	    <div id="" class="table-content">
		<table id="example" class="phonekey dataTable">
				<thead> 	
				<tr class="table-top">
				<th class="table-column table-left-ohne">&nbsp;</th>
				<th class="table-column <?php if(in_array('sort:id',$filter_sort) && in_array('direction:asc',$filter_sort)) echo  'sortlink_asc';elseif((in_array('sort:id',$filter_sort) && in_array('direction:desc',$filter_sort))) echo 'sortlink_desc';else echo 'sortlink';?> "style="width:102px;text-align: left;">
				<?php echo __("Id",true); ?></th>

				<th class="table-column <?php if(in_array('sort:location_id',$filter_sort) && in_array('direction:asc',$filter_sort)) echo  'sortlink_asc';elseif((in_array('sort:location_id',$filter_sort) && in_array('direction:desc',$filter_sort))) echo 'sortlink_desc';else echo 'sortlink';?> "style="width:102px;text-align: left;"><?php echo __("Location",true); ?></th>
	

				<th class="table-column <?php if(in_array('sort:function',$filter_sort) && in_array('direction:asc',$filter_sort)) echo  'sortlink_asc';elseif((in_array('sort:function',$filter_sort) && in_array('direction:desc',$filter_sort))) echo 'sortlink_desc';else echo 'sortlink';?> "style="width:102px;text-align: left;"><?php echo __("Function",true); ?></th>

				<th class="table-column <?php if(in_array('sort:display',$filter_sort) && in_array('direction:asc',$filter_sort)) echo  'sortlink_asc';elseif((in_array('sort:display',$filter_sort) && in_array('direction:desc',$filter_sort))) echo 'sortlink_desc';else echo 'sortlink';?> "style="width:102px;text-align: left;"><?php echo __("DISPLAYNAME",true); ?></th>
	
				<th class="table-column <?php if(in_array('sort:emer',$filter_sort) && in_array('direction:asc',$filter_sort)) echo  'sortlink_asc';elseif((in_array('sort:emer',$filter_sort) && in_array('direction:desc',$filter_sort))) echo 'sortlink_desc';else echo 'sortlink';?> "style="width:102px;text-align: left;"><?php 
				echo __("Emergency",true); ?></th>
				<th class="table-column"><?php echo __("ODS",true); ?></th>
				<th class="table-column"><?php echo __("trunk",true); ?></th>
			
				 <th class="table-right-ohne">&nbsp;</th>
				 </tr>
				</thead>
				<tfoot>
						<th colspan="7" class="pager form-horizontal">
							<button type="button" class="btn first"><i class="icon-step-backward"></i></button>
							<button type="button" class="btn prev"><i class="icon-arrow-left"></i></button>
							<span class="pagedisplay"></span> <!-- this can be any element, including an input -->
							<button type="button" class="btn next"><i class="icon-arrow-right"></i></button>
							<button type="button" class="btn last"><i class="icon-step-forward"></i></button>
							<select class="pagesize input-mini" title="Select page size">
								<option selected="selected" value="10">10</option>
								<option value="20">20</option>
								<option value="30">30</option>
								<option value="40">40</option>
							</select>
							<select class="pagenum input-mini" title="Select page number"></select>
						</th>
					</tr>
				</tfoot>
				 <tbody>
				   <?php
					// initialise a counter for striping the table
					$count = 0; 	
					#$options=$general->get_odsentries($scenario_id); //echo "<pre/>"; print_r($options); die;
		             //echo "<pre>"; print_r($dns);
					  //echo (count($dns));
					// loop through and display format					
					
					$dnsIdsArray = array();										
					foreach($dns as $dn): $insertedDNStyle=""; $disableCheckbox=""; $entryStatus="Available";
						// stripes the table by adding a class to every other row
						$class = ( ($count % 2) ? " class='altrow'": '' );
						// increment count
						$count++; 	
						
						#if (in_array($dn['Dns']['id'], $options)) {
					#		$insertedDNStyle = 'class="insertedDNStyle"';
					#		$disableCheckbox = 'disabled';
					#		$entryStatus = "Added";
					#	}					
						
					/*check for Duplicate Entry of DNS Id. Do not show duplicate entry*/	
					$DnsId = $dn['Dns']['id'];
					if(in_array($DnsId,$dnsIdsArray)){
					//if($DnsId >0){
							//echo $DnsId.'<br />';
							
						} else { 
						
						$dnsIdsArray[] = $dn['Dns']['id'];						
						#$AllScenariosForThisDns=$general->get_scenarios($dn['Dns']['id']);	
						$AllScenariosForThisDns=$scenarioMap[$dn['Dns']['id']];
						
						//echo "<pre>";print_r($AllScenariosForThisDns);  echo $dn['Dns']['id'];
					?>
					
			        <tr onmouseover="hoverRow(this,true);" onmouseout="hoverRow(this,false); " <?php echo $insertedDNStyle; ?>>
	             	  <td class="table-left">&nbsp;</td>
					  <td> 
	            	<?php 
	            		if(($dn['Dns']['function'] != '') && ($dn['Dns']['function'] != 'CFRA') && ($dn['Dns']['function'] != 'UCD') && ($dn['Dns']['function'] != 'INTERNAL'))
	            		{
	            			echo $html->link($dn['Dns']['id'],array('controller'=>'stations', 'action'=>'edit', 'DN-'.$dn['Dns']['id']));
	            			?>	
	            			</td>
							<td class="table-content column-width-100" style="width:125px;">
	                		<?php 
	                		echo $html->link($dn['Location']['name'],array('controller'=>'stations', 'action'=>'edit', 'DN-'.$dn['Dns']['id']),array('class'=>'opencolorbox'));
	                		#echo $dn['Location']['name']; 
	                		?>
							</td>
	                		<td>
	                		<?php 
	                		#echo $dn['Dns']['function'];
	                		echo $html->link(__($dn['Dns']['function'], true),array('controller'=>'stations', 'action'=>'edit', 'DN-'.$dn['Dns']['id'])); 
	                		?>
	                		</td>

	                		<td>
	                		<?php 
	                		#echo $dn['Dns']['display']; 
	                		echo $html->link($dn['Dns']['display'],array('controller'=>'stations', 'action'=>'edit', 'DN-'.$dn['Dns']['id']));
	                		?>
	                		</td>
							<td>
	                		<?php 
	                		#echo $dn['Dns']['emer']; 
	                		echo $html->link($dn['Dns']['emer'],array('controller'=>'stations', 'action'=>'edit', 'DN-'.$dn['Dns']['id']));
	                		?>
	                		</td>
	                		<td height="20px;">
							<?php 
								 if(isset($AllScenariosForThisDns) && !empty($AllScenariosForThisDns)){
								
								?>							
								
									
										<div id="scenario_tip<?php echo $DnsId;?>">
										<?php
											foreach($AllScenariosForThisDns As $key => $scenarioId)
												{								   
													echo "<li style='list-style:none;'>".$html->link($scenarioData[$scenarioId],array('controller'=>'scenarios','action' => 'edit/scenario_id:'.$scenarioId)); 
													echo "</li>";
											 	}
											#echo $html->link( __('TEST', true),array('controller'=>'scenarios','action' => 'edit/scenario_id:'.$scenarioId));
											
											 									
										?>
									</div>
							
							<?php } ?>
	                		</td>
	                		<td>
	                		<?php 
	                		  if(!empty($dn['Trunkentry'])){
								foreach($dn['Trunkentry'] as $trunk){
										$trunk_id = $trunk['trunk_id'];
										$Trunkname = $TrunkDataData[$trunk_id];									

										 echo $html->link($Trunkname,array('controller'=>'trunks','action' => 'edit/trunk_id:'.$trunk_id)); 
										
								 }							  
							  }
	                		?>
	                		</td>

							<td class="table-right-ohne">&nbsp;</td>
	            			<?php
	            		}
	            		else
	            		{
	            			echo $dn['Dns']['id'];
	            			?>
	            			</td>
							<td class="table-content column-width-100" style="width:125px;">
	                		<?php echo $dn['Location']['name']; ?>
							</td>
	                		<td><?php echo $dn['Dns']['emer']; ?></td>
	                		<td><?php echo __($dn['Dns']['function'], true); ?></td>
	                		
	                		<td><?php echo $dn['Dns']['display']; ?></td>
							<td height="20px;">
							<?php 
								 if(isset($AllScenariosForThisDns) && !empty($AllScenariosForThisDns)){
								
								?>							
								
									
										<div id="scenario_tip<?php echo $DnsId;?>">
										<?php
												foreach($AllScenariosForThisDns As $key => $scenarioId)
												{								   
													echo "<li style='list-style:none; '>".$html->link($scenarioData[$scenarioId],array('controller'=>'scenarios','action' => 'edit/scenario_id:'.$scenarioId)); 
													echo "</li>";
											 	}									
										?>
									</div>
								
							<?php } ?>

							</td>
	                	    <td class="table-right-ohne">&nbsp;</td>
							<td class="table-right-ohne">&nbsp;</td>		    				
	            			<?php 
								}
							}
	            		endforeach; ?>
	            	</tr>
					
				
				 </tbody>
				 
		</table>
			<div class="block" style="margin: 0px;">
				<div class="button-right">
					<a href="javascript:void(null)"  onclick="javascript:submit_odsentries('filters');" name="submitForm" value="submitForm" onmouseover="hoverButtonRight(this)" onmouseout="outButtonRight(this)"><?php __("Submit");?></a>
				</div>
           </div>
	    <?php echo $form->end(); ?>
	<?php //echo $this->element('pagination/newpaging'); ?>
	</div>
	    </div>
	   
	    <?php
		else:
			__("No Dns available in DB");
			echo '</div>';
		endif;
		?>
	 
                <div class="button-left">
                	<?php if($userpermission==Configure::read('access_id'))
                	{
						#echo $html->link(__('Back', true),  array('controller'=> 'customers', 'action'=>'index'),array('onmouseover'=>'javascript:hoverButtonLeft(this);','onmouseout'=>'javascript:outButtonLeft(this);')); 
	
                        	#echo $html->link('back',  array('controller'=> 'stations', 'action'=>'edit', $station_number));
                	}
                	?>
                </div>
	</div>
</div>
<!--right hand side starts from here-->
<!--<div id="related-content" style="float: left; margin-left:10px;">
<br/>
        <div class="box start link">
                <a href="http://www.swisscom.ch/grossunternehmen" target="_blank">
                <?php __('Home Swisscom') ?>
                </a>
        </div>
        <div class="box info">
        	 <h3><?php __('DN List') ?></h3>
                 <p>
                  <?php __('DN_blurb') ?>
                 </p>
        </div>

<!--INTERNAL USER OPTIONS -->
        <?php /* if($userpermission==Configure::read('access_id'))
        {?>
                <div class="box info">
                <h3><?php __("Internal User");?></h3>
                <p><?php __("Customer View:");?></p>
                <p><?php echo $selected_customer; ?></p>

                </div>
	<?php } */ ?>

		</div>
<!--ight hand side  ends here-->

