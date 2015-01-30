
<script type="text/javascript">
jQuery(function() { 
	jQuery.extend(jQuery.tablesorter.themes.bootstrap, {
		// these classes are added to the table. To see other table classes available,
		// look here: http://twitter.github.com/bootstrap/base-css.html#tables	
	});

	// call the tablesorter plugin and apply the uitheme widget
	jQuery(".dataTable").tablesorter({
		// this will apply the bootstrap theme if "uitheme" widget is included
		// the widgetOptions.uitheme is no longer required to be set
		theme : "bootstrap",
		widthFixed: true,
		bFilter: false,
		bInfo: false,

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
		13: {sorter: false,filter: false}
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
<div class="locations index">
	
		<fieldset>
                    <div class="button-right">
						<?php
					echo $html->link(__('Apply Change', true), array(
					'controller' => 'locations',
					'action' => 'view'
				), array(
				'class'=>'fancybox fancybox.ajax'   				 
				));
				?>

        	</div>   

           </fieldset>  
	    <?php
		echo $form->create('Location',array('action'=>'index','id'=>'filters')); 
		// check $locations variable exists and is not empty
		if(isset($locations) && !empty($locations)) :
		?>	 
	   <?php echo $this->element('pagination/top'); ?>
		<div id="" class="table-content">
		    <table class="phonekey dataTable">
		    	<thead>
	                <tr class="table-top" style="height:40px;">
	               		<th class="table-column table-left-ohne">&nbsp;</th>
	                    <th class="table-column"><span><?php __("Standort")?></span></th>
	                    <th class="table-column"><span><?php __("Ort")?></span></th>
	                    <th class="table-column"><span><?php __("PLZ")?></span></th>
	                    <th class="table-column"><span><?php __("Address")?></span></th>
						 <th class="table-column"><span><?php __("Emerg String")?></span></th>
						  <th class="table-column"><span><?php __("Swisscom Name")?></span></th>
						   <th class="table-column"><span><?php __("Type")?></span></th>
						    <th class="table-column"><span><?php __("Bw Order")?></span></th>
							   <th class="table-column"><span><?php __("Channels")?></span></th>
							    <th class="table-column"><span><?php __("MiddleBoxId")?></span></th>
								 <th class="table-column"><span><?php __("CER Name")?></span></th>
								  <th class="table-column"><span><?php __("CER Name2")?></span></th>
									<th class="table-column table-right-ohne column-width-150">&nbsp;</th>
	                </tr>
	            </thead>
		        <tbody>			
		
		        	<?php
					// initialise a counter for striping the table
					$count = 0;
		             //echo "<pre>";print_r($locations);
					// loop through and display format
					foreach($locations as $location):
						// stripes the table by adding a class to every other row
						$class = ( ($count % 2) ? " class='altrow'": '' );
						// increment count
						$count++;
					?>
		            <tr onmouseover="hoverRow(this,true);" onmouseout="hoverRow(this,false);">
		            	
		            	
			<td class="table-right" style="background: url(<?php echo $this->webroot;?>/images/assets/icons/9px/198_angleright_06_cmyk.gif) no-repeat 3px 5px;border-style: none; width:180px !important;" onmouseout="this.className='table-right';" id="<?php	echo $sta_id;?>tdlast">
							<div class="table-menu">
							<div class="table-menu-popup" style="z-index: 1">
							<ul>
							
								<li class="script">
								<?php echo $html->link(__('Edit Location', true), array('controller' => 'locations',					'action' => 'edit',	$location['Location']['id']));
								?>
								</li> 
								<?php 							
								if ($sta_id_key != 1)
								{
									?>
									<li class="last log">
									<?php
										echo $html->link(__('Delete Location', true), array(
										'controller' => 'location',
										'action' => 'edit',
										"$statId&delete_feature=$location_id"
										));
									?>
									</li>
									<li class="last log">
									<?php
									echo $html->link(__('Add DN', true), array(
									'controller' => 'location',
									'action' => 'major_cfeature_change',
									"$statId&delete_feature=$location_id"
									))?>
									</li>
							
								<?php 
								}
						?>
						</ul>
						</div>
						</div>
					</td>
									
		            	<td><?php echo $html->link($location['Location']['lbl'],array('action'=>'edit', $location['Location']['id']));?></td>		            	
		                <td><?php echo $location['Location']['name']; ?></td>
		                <td><?php echo $location['Location']['plz']; ?></td>
						<td><?php echo $location['Location']['address']; ?></td>
						<td><?php echo $location['Location']['emer']; ?></td>
		                <td><?php echo $location['Location']['scm_name']; ?></td>
						<td><?php echo $location['Location']['loc_type']; ?></td>
						<td><?php echo $location['Location']['bw']; ?></td>
						<td><?php echo count($location['Stationkey']); ?></td>
						<td><?php echo $location['Location']['middle_box']; ?></td>
						<td><?php echo $location['Location']['cer1']; ?></td>
						<td><?php echo $location['Location']['cer2']; ?></td>
						<td class="table-left-ohne" style="width:20px;">&nbsp;</td>
		               
		            </tr>
		            <?php endforeach; ?>
		        </tbody>
		    </table>
			
	    </div>
	<?php
	echo $this->element('pagination/bottom');
	
	
	echo $html->link('(Change to global stations view)', array('controller'=>'stations', 'action'=>'index'));?>
	    
	    <?php
		else:
			echo 'There are currently no Locations in the database.';
		endif;
		?>
	 
	</div>
	
<fieldset>
                       
   <div class="button-right">
						<?php
				echo $html->link(__('Close', true), array(
   				 'controller' => 'locations',
					'action' => 'view'
				), array(
				'class'=>'fancybox fancybox.ajax'
   				 
				));
				?>

        	</div>
                       

           </fieldset>





	<div class="locations view">
		
		
	    
	    <?php 
		
		 
if(!empty($location)): ?>
	    <?php echo $this->element('pagination/top'); 
		
		
		?>
	  
	    <?php echo $this->element('pagination/bottom'); ?>
	    <?php endif; ?>
	    
	    <ul class="actions">
	    	<li><?php echo $html->link('Back to Locations', array('action'=>'index', $location[0]['Location']['customer_id']));?></li>
		</ul>
	</div>
</div>
<?php 


exit();
?>