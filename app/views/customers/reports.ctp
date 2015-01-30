	<!--$Rev:: 22            $:  Revision of last commit-->
	<div class="block top">
	
	<?php 
	echo $form->create('Customer',array('action'=>'reports','id'=>'filters')); ?>
	<br>
		
		<div class="cb">
			<!--CBM START HERE -->
			<div id="" class="table-content">
				<table class="table-content phonekey">
					<thead>
						<tr class="table-top">
							<th class="table-column table-left-ohne" style="width:20px;">&nbsp;</th>
							<th  class="table-column" style="width:63px;text-align: left;"><?php echo __("CUSTOMER", true);?></th>
							<th class="table-right-ohne">&nbsp;</th>
						</tr>
						
						<tr>
							<td class="table-column table-left-ohne">&nbsp;</td>
							<td>
							<select name="customer" style="width:351px;"  onchange="javascript:submi_form('filters');">
								<option value="GLOBAL" <?php if ($customer_val == 'GLOBAL'){ echo ' SELECTED';}?>><?php __("Global Statistics") ?></option>
									<?php foreach($customerIds  as $customerId){
										if($customerId['Customer']['name']!=""){
										?>
										<option value="<?php echo $customerId['Customer']['id'];?>"<?php if ($customer_val == $customerId['Customer']['id']){ echo ' SELECTED';}?>><column><?php echo $customerId['Customer']['id'];?></column>&nbsp(<column><?php echo $customerId['Customer']['name'];?></column>)&nbsp</option>
									<?php
									}
									 }?>
									</select>
								</td>
							<td class="table-right-ohne">&nbsp;</td>
						</tr>
					</thead>
					<tbody>
				</table>
			</div>
			<div class="block" style="margin: 0px;">
				<div class="button-right">
					<?php echo $html->link( __("Export Csv", true),  array('controller'=> 'customers', 'action'=>'export_statistics', $customer_val),array('onmouseover'=>'hoverButtonRight(this);','onmouseout'=>'javascript:outButtonRight(this);')); ?>
				</div>
			</div>
			
			
			
			
			<h2><?php __('PORT STATISTICS') ?></h2>
			<div id="" class="table-content">
				
				<table class="table-content phonekey" style="table-layout: fixed; width: 400px">

					<tbody>

				 <!--STAITON TYPE -->

						<tr>	

		        		<td class="table-left">&nbsp;</td>
		        		<td class= "table-right-ohne" style="width:300px"><div style="word-wrap: break-word"><?php echo __('C20TOTAL', true); ?></div></td>
						<td class="table-left-ohne" style="width:50px;"><?php echo $portTypeTotalCount;?></td>
						<td class= "table-right-ohne"></td>
						
		        		</tr>
		        		<tr>
					
					
	        		<?php

	            		foreach($stationTypeCount as $statTyp):
	            		
	            		?>
		        		<td class="table-left">&nbsp;</td>
						<td class= "table-right-ohne" style="width:300px"><?php 
						if($statTyp['Station']['type'] == '')
						{
							echo __('Blank Terminal Type', true); 
						}
						else
						{
							echo __('T' . $statTyp['Station']['type'], true); 
						}
						?></td>
						<td class="table-left-ohne" style="width:50px;"><?php echo $statTyp[0]['count(`Station`.`type`)']; ?></td>
						<td class= "table-right-ohne"></td>
						
		        		</tr>
		        		
		        		
	        		<?php endforeach; ?>
	        	</tbody>
				</table>
				</div>
				
				<?php if($phoneTypeTotalCount > 0){?>
				
	        	<h2><?php __('STATION STATISTICS') ?></h2>
				<div id="" class="table-content">
				
				<table class="table-content phonekey" style="table-layout: fixed; width: 400px">

					<tbody>
	        		
	        		
	        		<!--PHONE TYPE -->
						<tr>	

		        		<td class="table-left">&nbsp;</td>
		        		<td class= "table-right-ohne" style="width:300px"><?php echo __('DBSTATIONTOTAL', true); ?></td>
						<td class="table-left-ohne" style="width:50px;"><?php echo $phoneTypeTotalCount;?></td>
		
						<td class= "table-right-ohne"></td>
						
		        		</tr>
					<tr>
	        		<?php
						#print_r($phoneTypeCount);
						#die();
	            		foreach($phoneTypeCount as $phoneTyp):
	            		$phoneTypeString = 'T' . $phoneTyp['Station']['phone_type'];
	            		?>
		        		<td class="table-left">&nbsp;</td>
						<td class= "table-right-ohne" style="width:300px"><?php echo __($phoneTypeString, true); ?></td>
						<td class="table-left-ohne" style="width:50px;"><?php echo $phoneTyp[0]['count(`Station`.`phone_type`)']; ?></td>
						<td class= "table-right-ohne"></td>
					</tr>

		        	
	        		<?php endforeach; ?>
	        		<!-- TOTAL NULL PHONE TYPE -->
					<tr>
						<td class="table-left">&nbsp;</td>
						<td class= "table-right-ohne" style="width:300px"><?php echo __('Blank Phone Type', true); ?></td>
						<td class="table-left-ohne" style="width:50px;"><?php echo $phoneTypeCountNull;?></td>
						<td class= "table-right-ohne"></td>
					</tr>
	        		
	
	        		</tbody>
				</table>
				</div>
	        	<h2><?php __('STATION_OPTION STATISTICS') ?></h2>
				<div id="" class="table-content">
				
					<table class="table-content phonekey" style="table-layout: fixed; width: 400px">

					<tbody>
	        
	        			<!--Expansion module TYPE -->

					
	        		<?php

	            		foreach($expTypeCount as $expTyp):
	            		if( $expTyp['Station']['extensions'] == 1 || $expTyp['Station']['extensions'] == 2 )
	            		{
	            			?>
		        			<td class="table-left">&nbsp;</td>
		        		
							<td class= "table-right-ohne" style="width:300px">
							<?php 
							if($expTyp['Station']['extensions'] == 1){
								echo __('1 Expansion Module', true);
							}
							elseif ($expTyp['Station']['extensions'] == 2){
								echo __('2 Expansion Modules', true);
							}
							?>
							</td>
							<td class="table-left-ohne" style="width:50px;"><?php echo $expTyp[0]['count(`Station`.`extensions`)']; ?></td>
							<td class= "table-right-ohne"></td>
	            		<?php 
	            		} 
	            		?>
		        		</tr>
	        		<?php endforeach; ?>
	        		
	        			<tr>	

		        		<td class="table-left">&nbsp;</td>
		        		<td class= "table-right-ohne" style="width:300px"><?php echo __('TSIMRING', true); ?></td>
						<td class="table-left-ohne" style="width:50px;"><?php echo $simCount;?></td>
		
						<td class= "table-right-ohne"></td>
						
		        		</tr>
		        		
		        							
					<!-- CTI -->
					<tr>
					<td class="table-left">&nbsp;</td>
					<td class= "table-right-ohne" style="width:300px"><?php echo __('TCTI', true); ?></td>
					<td class="table-left-ohne" style="width:50px;"><?php echo $ctiTypeCount;?></td>
					<td class= "table-right-ohne"></td>
					</tr>
					
					<!-- COMBOX -->
					<tr>
					<td class="table-left">&nbsp;</td>
					<td class= "table-right-ohne" style="width:300px"><?php echo __('TCOMBOX', true); ?></td>
					<td class="table-left-ohne" style="width:50px;"><?php echo $comboxTypeCount;?></td>
					<td class= "table-right-ohne"></td>
					</tr>
					
					<!-- CFRA -->
	        		
	        	
						
					<tr>
					<td class="table-left">&nbsp;</td>
					<td class= "table-right-ohne" style="width:300px"><?php echo __('TCFRA', true); ?></td>
					<td class="table-left-ohne" style="width:50px;"><?php echo $statcfraCount;?></td>
					<td class= "table-right-ohne"></td>
					</tr>
	        		
					</tbody>
				</table>
			</div>
			
			<?php }?>

			<?php if($groupTypeTotalCount > 0){?>
			<h2><?php __('GROUP STATISTICS') ?></h2>
			<div id="" class="table-content">
				
				<table class="table-content phonekey" style="table-layout: fixed; width: 400px">

					<tbody>

				<!--CBM END HERE -->
						<tr>	

		        		<td class="table-left">&nbsp;</td>
		        		<td class= "table-right-ohne" style="width:300px"><?php echo __('TOTAL', true); ?></td>
						<td class="table-left-ohne" style="width:50px;"><?php echo $groupTypeTotalCount;?></td>
		
						<td class= "table-right-ohne"></td>
						
		        		</tr>
		        		<tr>
	        		    <?php

	            		foreach($groupTypeCount as $groupTyp):
	            		?>
		        		<td class="table-left">&nbsp;</td>
						<td class= "table-right-ohne" style="width:300px"><?php echo __('T' . $groupTyp['Dns']['function'], true); ?></td>
						<td class="table-left-ohne" style="width:50px;"><?php echo $groupTyp[0]['count(`Dns`.`function`)']; ?></td>
						<td class= "table-right-ohne"></td>
						
		        		</tr>
	        			<?php endforeach; ?>
	    
					</tbody>
				</table>
			</div>
			
			<?php }?>
			<?php if($DNCount > 0){?>
			<h2><?php __('DN STATISTICS') ?></h2>
			<div id="" class="table-content">
				
				<table class="table-content phonekey" style="table-layout: fixed; width: 400px">

					<tbody>

				<!--CBM END HERE -->
						<tr>	

		        		<td class="table-left">&nbsp;</td>
		        		<td class= "table-right-ohne" style="width:300px"><?php echo __('TOTAL', true); ?></td>
						<td class="table-left-ohne" style="width:50px;"><?php echo $DNCount;?></td>
		
						<td class= "table-right-ohne"></td>
						
		        		</tr>
		        		<tr>	

		        		<td class="table-left">&nbsp;</td>
		        		<td class= "table-right-ohne" style="width:300px"><?php echo __('TAVAILABLE', true); ?></td>
						<td class="table-left-ohne" style="width:50px;"><?php echo $DNAvailCount;?></td>
		
						<td class= "table-right-ohne"></td>
						
		        		</tr>
		        		<tr>	

		        		<td class="table-left">&nbsp;</td>
		        		<td class= "table-right-ohne" style="width:300px"><?php echo __('TUSED', true); ?></td>
						<td class="table-left-ohne" style="width:50px;"><?php echo $DNUsedCount;?></td>
		
						<td class= "table-right-ohne"></td>
						
		        		</tr>
	    
					</tbody>
				</table>
			</div>
			<?php }?>
			<?php if($locTotalCount > 0){?>
			<h2><?php __('LOCATION STATISTICS') ?></h2>
				<div id="" class="table-content">
				
				<table class="table-content phonekey" style="table-layout: fixed; width: 400px">

					<tbody>
	        		<!--LOCATION -->
						<tr>	

		        		<td class="table-left">&nbsp;</td>
		        		<td class= "table-right-ohne" style="width:300px"><?php echo __('TOTAL', true); ?></td>
						<td class="table-left-ohne" style="width:50px;"><?php echo $locTotalCount;?></td>
		
						<td class= "table-right-ohne"></td>
						
		        		</tr>

	        		</tbody>
				</table>
				</div>
				
				<?php }?>
				<?php if($trunkTotalCount > 0){?>
			
				<h2><?php __('TRUNK STATISTICS') ?></h2>
				<div id="" class="table-content">
				
				<table class="table-content phonekey" style="table-layout: fixed; width: 400px">

					<tbody>
	        	
						<tr>	

		        		<td class="table-left">&nbsp;</td>
		        		<td class= "table-right-ohne" style="width:300px"><?php echo __('TOTAL ', true); echo '('; echo __('CHANNEL ', true); echo ')';?></td>
						<td class="table-left-ohne" style="width:50px;"><?php echo $trunkTotalCount;?></td>
		
						<td class= "table-right-ohne"></td>
						
		        		</tr>
		        		<tr>
	        		    <?php

	            		foreach($trunkTypeCount as $trunkTyp):
	            		?>
		        		<td class="table-left">&nbsp;</td>
						<td class= "table-right-ohne" style="width:300px"><?php echo __($trunkTyp['Trunk']['gate_type'], true); ?></td>
						<td class="table-left-ohne" style="width:50px;"><?php echo $trunkTyp[0]['count(`Trunk`.`gate_type`)']; ?></td>
						<td class= "table-right-ohne"></td>
						
		        		</tr>
		        		<tr>
		        		<td class="table-left">&nbsp;</td>
						<td class= "table-right-ohne" style="width:300px">&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp(<?php echo __('totalChannels', true); ?>)</td>
						<td class="table-left-ohne" style="width:50px;"><?php echo $trunkTyp[0]['sum(`Trunk`.`channel`)']; ?></td>
						<td class= "table-right-ohne"></td>
						
		        		</tr>
	        			<?php endforeach; ?>
	        		</tbody>
				</table>
				</div>
				
				<?php }?>
				<?php if($mediatrixTotalCount > 0){?>
				
				<h2><?php __('MEDIATRIX STATISTICS') ?></h2>
				<div id="" class="table-content">
				
				<table class="table-content phonekey" style="table-layout: fixed; width: 400px">

					<tbody>
	        	
						<tr>	

		        		<td class="table-left">&nbsp;</td>
		        		<td class= "table-right-ohne" style="width:300px"><?php echo __('TOTAL', true); ?></td>
						<td class="table-left-ohne" style="width:50px;"><?php echo $mediatrixTotalCount;?></td>
		
						<td class= "table-right-ohne"></td>
						
		        		</tr>
		        		<tr>
	        		    <?php

	            		foreach($mediatrixTypeCount as $medTyp):
	            		?>
		        		<td class="table-left">&nbsp;</td>
						<td class= "table-right-ohne" style="width:300px"><?php echo __('T' . $medTyp['Mediatrix']['type'], true); ?></td>
						<td class="table-left-ohne" style="width:50px;"><?php echo $medTyp[0]['count(`Mediatrix`.`type`)']; ?></td>
						<td class= "table-right-ohne"></td>
						
		        		</tr>
	        			<?php endforeach; ?>
	    

	        		</tbody>
				</table>
				</div>
				
				<h2><?php __('MEDIATRIX PORT STATISTICS') ?></h2>
				<div id="" class="table-content">
				
				<table class="table-content phonekey" style="table-layout: fixed; width: 400px">

					<tbody>
	        	
						<tr>	

		        		<td class="table-left">&nbsp;</td>
		        		<td class= "table-right-ohne" style="width:300px"><?php echo __('TOTAL', true); ?></td>
						<td class="table-left-ohne" style="width:50px;"><?php echo $portCount;?></td>
		
						<td class= "table-right-ohne"></td>
						
		        		</tr>
		
	        		    <tr>	

		        		<td class="table-left">&nbsp;</td>
		        		<td class= "table-right-ohne" style="width:300px"><?php echo __('TOTALAVAIL', true); ?></td>
						<td class="table-left-ohne" style="width:50px;"><?php echo $portAvailCount;?></td>
		
						<td class= "table-right-ohne"></td>
						
		        		</tr>
		        		
	 				   <tr>	

		        		<td class="table-left">&nbsp;</td>
		        		<td class= "table-right-ohne" style="width:300px"><?php echo __('TOTALUSED', true); ?></td>
						<td class="table-left-ohne" style="width:50px;"><?php echo $portUsedCount;?></td>
		
						<td class= "table-right-ohne"></td>
						
		        		</tr>
		        		

	        		</tbody>
				</table>
				</div>
			
				<?php }?>
				<?php if($scenarioTotalCount > 0){?>
				
				<h2><?php __('ODS STATISTICS') ?></h2>
				<div id="" class="table-content">
				
				<table class="table-content phonekey" style="table-layout: fixed; width: 400px">

					<tbody>
	        	
						<tr>	

		        		<td class="table-left">&nbsp;</td>
		        		<td class= "table-right-ohne" style="width:300px"><?php echo __('TOTAL', true); ?></td>
						<td class="table-left-ohne" style="width:50px;"><?php echo $scenarioTotalCount;?></td>
		
						<td class= "table-right-ohne"></td>
						
		        		</tr>
		        		<tr>
	        		    <?php
	        		    $scenarioStatus = Configure :: read('scenarioStatus');
	            		foreach($scenarioTypeCount as $scTyp):
	            		?>
		        		<td class="table-left">&nbsp;</td>
						<td class= "table-right-ohne" style="width:300px"><?php echo __('T' . $scenarioStatus[$scTyp['Scenario']['status']], true); ?></td>
						<td class="table-left-ohne" style="width:50px;"><?php echo $scTyp[0]['count(`Scenario`.`status`)']; ?></td>
						<td class= "table-right-ohne"></td>
						
		        		</tr>
	        			<?php endforeach; ?>
	    

	        		</tbody>
				</table>
				</div>
				<?php }?>
	
				<h2><?php __('FEATURE STATISTICS') ?></h2>
				<div id="" class="table-content">
				
				<table class="table-content phonekey" style="table-layout: fixed; width: 400px">

					<tbody>
	        	
				
		        		<tr>
	        		    <?php
	        		    
	            		foreach($featureTypeCount as $featTyp):
	            		?>
	            		
		        		<td class="table-left">&nbsp;</td>
						<td class= "table-right-ohne" style="width:300px"><?php echo __($featTyp['Feature']['short_name'], true); ?></td>
						<td class="table-left-ohne" style="width:50px;"><?php echo $featTyp[0]['count(`Feature`.`short_name`)']; ?></td>
						<td class= "table-right-ohne"></td>
						
		        		</tr>
	        			<?php endforeach; ?>
	    

	        		</tbody>
				</table>
				</div>
			
			
			
			
			<?php
			if ($customer_val == 'GLOBAL')
			{
			?>
			
			<h2><?php __('CUSTOMER STATISTICS') ?></h2>
			<div id="" class="table-content">
				
				<table class="table-content phonekey" style="table-layout: fixed; width: 400px">

					<tbody>

				<!--CBM END HERE -->
						<!-- OC -->
						<tr>
						<td class="table-left">&nbsp;</td>
						<td class= "table-right-ohne" style="width:300px"><?php echo __('TOTAL', true); ?></td>
						<td class="table-left-ohne" style="width:50px;"><?php echo $custCount;?></td>
						<td class= "table-right-ohne"></td>
						</tr>
						
						<!-- TOTAL CUSOTMER TYPES -->
						<tr>
	        		<?php

	            		foreach($customerTypeCount as $custTyp):

	            		?>
		        		
						<td class="table-left">&nbsp;</td>
						<td class= "table-right-ohne" style="width:300px"><?php echo __('T' . $custTyp['Customer']['type'], true); ?></td>
						<td class="table-left-ohne" style="width:50px;"><?php echo $custTyp[0]['count(`Customer`.`type`)']; ?></td>
						<td class= "table-right-ohne"></td>
						
		        		</tr>
	        		<?php endforeach; ?>
	        		
	        		</tbody>
					</table>
					</div>
	        		<h2><?php __('CUSTOMER_OPTION STATISTICS') ?></h2>
					<div id="" class="table-content">
				
					<table class="table-content phonekey" style="table-layout: fixed; width: 400px">

					<tbody>
	        		
	        		<!-- TOTAL ONB -->
					<tr>
						<td class="table-left">&nbsp;</td>
						<td class= "table-right-ohne" style="width:300px"><?php echo __('TONB', true); ?></td>
						<td class="table-left-ohne" style="width:50px;"><?php echo $onbCount;?></td>
						<td class= "table-right-ohne"></td>
					</tr>
										
					<!-- TOTAL NSC -->
					<tr>
					<td class="table-left">&nbsp;</td>
					<td class= "table-right-ohne" style="width:300px"><?php echo __('TNSC', true); ?></td>
					<td class="table-left-ohne" style="width:50px;"><?php echo $nscCount;?></td>
					<td class= "table-right-ohne"></td>
					</tr>
					
						
	        		<!-- CFRA -->
	        		
	        		<?php 		$cfraCount = count($cfraTypeCount); ?>
						
					<tr>
					<td class="table-left">&nbsp;</td>
					<td class= "table-right-ohne" style="width:300px"><?php echo __('TCFRA', true); ?></td>
					<td class="table-left-ohne" style="width:50px;"><?php echo $cfraCount;?></td>
					<td class= "table-right-ohne"></td>
					</tr>
					
						
					<!-- CD -->
					<tr>
					<td class="table-left">&nbsp;</td>
					<td class= "table-right-ohne" style="width:300px"><?php echo __('TCD', true); ?></td>
					<td class="table-left-ohne" style="width:50px;"><?php echo $cdTypeCount;?></td>
					<td class= "table-right-ohne"></td>
					</tr>

					<!-- OC -->
					<tr>
					<td class="table-left">&nbsp;</td>
					<td class= "table-right-ohne" style="width:300px"><?php echo __('TOC', true); ?></td>
					<td class="table-left-ohne" style="width:50px;"><?php echo $ocTypeCount;?></td>
					<td class= "table-right-ohne"></td>
					</tr>
					
					<!-- OC -->
					<tr>
					<td class="table-left">&nbsp;</td>
					<td class= "table-right-ohne" style="width:300px"><?php echo __('TCTI', true); ?></td>
					<td class="table-left-ohne" style="width:50px;"><?php echo $ctiCustCount;?></td>
					<td class= "table-right-ohne"></td>
					</tr>
					
					</tbody>
					</table>
					</div>
	        		<h2><?php __('CUSTOMER_SLA STATISTICS') ?></h2>
					<div id="" class="table-content">
				
					<table class="table-content phonekey" style="table-layout: fixed; width: 400px">

					<tbody>
					
					<!-- TOTAL -->
					<tr>
					<td class="table-left">&nbsp;</td>
					<td class= "table-right-ohne" style="width:300px"><?php echo __('TOTAL', true); ?></td>
					<td class="table-left-ohne" style="width:50px;"><?php echo $slaCount;?></td>
					<td class= "table-right-ohne"></td>
					</tr>
					
				    <tr>
	       		    <?php
            		foreach($slaTypeCount as $slaTyp):
            		if ($slaTyp['Customer']['SLA'] == '0')
            		{
            		?>
            			<td class="table-left">&nbsp;</td>
	   					<td class= "table-right-ohne" style="width:300px"><?php echo __('Blank SLA', true); ?></td>
						<td class="table-left-ohne" style="width:50px;"><?php echo $slaTyp[0]['count(`Customer`.`SLA`)']; ?></td>
						<td class= "table-right-ohne"></td>
            		<?php
            		}
            		else
            		{
            			
            		?>
	   				<td class="table-left">&nbsp;</td>
	   				<td class= "table-right-ohne" style="width:300px"><?php echo __($slaTyp['Customer']['SLA'], true); ?></td>
					<td class="table-left-ohne" style="width:50px;"><?php echo $slaTyp[0]['count(`Customer`.`SLA`)']; ?></td>
					<td class= "table-right-ohne"></td>
					<?php
            		}
            		?>
	        		</tr>
        		    <?php endforeach; ?>
	        		
					</tbody>
				</table>
			</div>
			
			<?php  } ?>
			
			<h2><?php __('FIXED REPORTS') ?></h2>
			<div id="" class="table-content">
				
				<table class="table-content phonekey" style="table-layout: fixed; width: 400px">

					<tbody>
						<tr>
							<td class="table-left">&nbsp;</td>
							<td class= "table-right-ohne" style="width:300px"><?php echo __('DN Disovered in network and not in range'); ?></td>
							<td class="table-left-ohne" style="width:50px;"><?php echo $html->link(__('Report', true),  array('controller'=> 'customers', 'action'=>'export_report', 'activeDN')); ?></td>
		        			<td class= "table-right-ohne"></td>
		        		</tr>
		        		<tr>
							<td class="table-left">&nbsp;</td>
							<td class= "table-right-ohne" style="width:300px"><?php echo __('Stations Exported from 4Voip without match on C20'); ?></td>
							<td class="table-left-ohne" style="width:50px;"><?php echo $html->link(__('Report', true),  array('controller'=> 'customers', 'action'=>'export_report', 'statExport')); ?></td>
		        			<td class= "table-right-ohne"></td>
		        		</tr>
		        		<tr>
							<td class="table-left">&nbsp;</td>
							<td class= "table-right-ohne" style="width:300px"><?php echo __('dnAssocationToUnknownLocation'); ?></td>
							<td class="table-left-ohne" style="width:50px;"><?php echo $html->link(__('Report', true),  array('controller'=> 'customers', 'action'=>'export_report', 'dnUnknownLoc')); ?></td>
		        			<td class= "table-right-ohne"></td>
		        		</tr>
			
					</tbody>
				</table>
			</div>
				
			<!-- -->
			
			</div>
	<?php echo $form->end(); ?>
	
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
