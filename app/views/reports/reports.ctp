	<!--$Rev:: 22            $:  Revision of last commit-->
	<div class="block top">
	
	<?php 
	echo $form->create('Report',array('action'=>'reports','id'=>'filters')); ?>
	<br>
		
		<div class="cb">
			<!--CBM START HERE -->
			<div id="" class="table-content">
				<table class="table-content phonekey">
					<thead>
						<tr class="table-top">
							<th class="table-column table-left-ohne" style="width:20px;">&nbsp;</th>
							<th  class="table-column" style="width:63px;text-align: left;"><?php __("CNN");?></th>
							<th class="table-right-ohne">&nbsp;</th>
						</tr>
						
						<tr>
							<td class="table-column table-left-ohne">&nbsp;</td>
							<td>
							<select name="customer" style="width:156px;"  onchange="javascript:submi_form('filters');">
								<option value="GLOBAL" <?php if ($customer_val == 'GLOBAL'){ echo ' SELECTED';}?>><?php __("Global Statistics") ?></option>
									<?php foreach($customerIds  as $customerId){?>
										<option value="<?php echo $customerId['Customer']['id'];?>"<?php if ($customer_val == $customerId['Customer']['id']){ echo ' SELECTED';}?>><?php echo $customerId['Customer']['id'];?></option>
									<?php }?>
									</select>
								</td>
							<td class="table-right-ohne">&nbsp;</td>
						</tr>
					</thead>
					<tbody>
				</table>
			</div>
			
			
			
			
			
			<h2>STATION STATISTICS</h2>
			<div id="" class="table-content">
				
				<table class="table-content phonekey">
					<thead>
						<tr class="table-top">
							<th class="table-column table-left-ohne" style="width:20px;">&nbsp;</th>
							<th style="width:100px;">Statistic </th>
							<th style="width:50px;">Count</th>
							<th class="table-right-ohne">&nbsp;</th>
						</tr>
						
					</thead>
					<tbody>

				 <!--STAITON TYPE -->

					<tr>
	        		<?php

	            		foreach($stationTypeCount as $statTyp):
	            		?>
		        		<td class="table-left">&nbsp;</td>
						<td><?php echo 'Total ' . $statTyp['Station']['type']; ?></td>
						<td><?php echo $statTyp[0]['count(`Station`.`type`)']; ?></td>
						<td class= "table-right-ohne"></td>
						
		        		</tr>
	        		<?php endforeach; ?>
	        		
	        		
	        		<!--PHONE TYPE -->

					<tr>
	        		<?php

	            		foreach($phoneTypeCount as $phoneTyp):
	            		?>
		        		<td class="table-left">&nbsp;</td>
						<td><?php echo 'Total ' . $phoneTyp['Station']['phone_type']; ?></td>
						<td><?php echo $phoneTyp[0]['count(`Station`.`phone_type`)']; ?></td>
						<td class= "table-right-ohne"></td>
						
		        		</tr>
	        		<?php endforeach; ?>
	        		
	        			<!--Expansion module TYPE -->

					<tr>
	        		<?php

	            		foreach($expTypeCount as $expTyp):
	            		?>
		        		<td class="table-left">&nbsp;</td>
						<td><?php echo 'With ' . $expTyp['Station']['extensions'] . ' Extensions'; ?></td>
						<td><?php echo $expTyp[0]['count(`Station`.`extensions`)']; ?></td>
						<td class= "table-right-ohne"></td>
						
		        		</tr>
	        		<?php endforeach; ?>
	        		
	        			<tr>	

		        		<td class="table-left">&nbsp;</td>
		        		<td>Simring not null</td>
						<td><?php echo $simCount;?></td>
		
						<td class= "table-right-ohne"></td>
						
		        		</tr>
	        		
					</tbody>
				</table>
			</div>

			
			<h2>GROUP STATISTICS</h2>
			<div id="" class="table-content">
				
				<table class="table-content phonekey">
					<thead>
						<tr class="table-top">
							<th class="table-column table-left-ohne" style="width:20px;">&nbsp;</th>
							<th style="width:100px;">Statistic </th>
							<th style="width:50px;">Count</th>
							<th class="table-right-ohne">&nbsp;</th>
						</tr>
						
					</thead>
					<tbody>

				<!--CBM END HERE -->

	        		    <?php

	            		foreach($groupTypeCount as $groupTyp):
	            		?>
		        		<td class="table-left">&nbsp;</td>
						<td><?php echo 'Total ' . $groupTyp['Dns']['function']; ?></td>
						<td><?php echo $groupTyp[0]['count(`Dns`.`function`)']; ?></td>
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
			
			<h2>CUSTOMER STATISTICS</h2>
			<div id="" class="table-content">
				
				<table class="table-content phonekey">
					<thead>
						<tr class="table-top">
							<th class="table-column table-left-ohne" style="width:20px;">&nbsp;</th>
							<th style="width:100px;">Statistic </th>
							<th style="width:50px;">Count</th>
							<th class="table-right-ohne">&nbsp;</th>
						</tr>
						
					</thead>
					<tbody>

				<!--CBM END HERE -->
				
						
						<!-- TOTAL CUSOTMER TYPES -->
						<tr>
	        		<?php

	            		foreach($customerTypeCount as $custTyp):

	            		?>
		        		
						<td class="table-left">&nbsp;</td>
						<td><?php echo 'Total ' . $custTyp['Customer']['type']; ?></td>
						<td><?php echo $custTyp[0]['count(`Customer`.`type`)']; ?></td>
						<td class= "table-right-ohne"></td>
						
		        		</tr>
	        		<?php endforeach; ?>
	        		
	        		<!-- TOTAL ONB -->
					<tr>
						<td class="table-left">&nbsp;</td>
						<td>Total ONB Customers</td>
						<td><?php echo $onbCount;?></td>
						<td class= "table-right-ohne"></td>
					</tr>
										
					<!-- TOTAL NSC -->
					<tr>
					<td class="table-left">&nbsp;</td>
					<td>Total NSC Customers</td>
					<td><?php echo $nscCount;?></td>
					<td class= "table-right-ohne"></td>
					</tr>
					
						
	        		<!-- CFRA -->
	        		
	        		<?php 		$cfraCount = count($cfraTypeCount); ?>
						
					<tr>
					<td class="table-left">&nbsp;</td>
					<td>Total CFRA Customers</td>
					<td><?php echo $cfraCount;?></td>
					<td class= "table-right-ohne"></td>
					</tr>
					
						
					<!-- CD -->
					<tr>
					<td class="table-left">&nbsp;</td>
					<td>Total Customers with CD</td>
					<td><?php echo $cdTypeCount;?></td>
					<td class= "table-right-ohne"></td>
					</tr>
					
					
				    <tr>
	       		    <?php
            		foreach($slaTypeCount as $slaTyp):
            		?>
	   				<td class="table-left">&nbsp;</td>
	   				<td><?php echo 'Total ' . $slaTyp['Customer']['SLA']; ?></td>
					<td><?php echo $slaTyp[0]['count(`Customer`.`SLA`)']; ?></td>
					<td class= "table-right-ohne"></td>
					
	        		</tr>
        		    <?php endforeach; ?>
	        		
					</tbody>
				</table>
			</div>
			
			
			<h2>USAGE STATISTICS</h2>
				<div id="" class="table-content">
				
				<table class="table-content phonekey">
					<thead>
						<tr class="table-top">
							<th class="table-column table-left-ohne" style="width:20px;">&nbsp;</th>
							<th style="width:100px;">Statistic </th>
							<th style="width:50px;">Count</th>
							<th class="table-right-ohne">&nbsp;</th>
						</tr>
						
					</thead>
					<tbody>

					<tr>
	        		<?php
	            		foreach($logonCount as $logonTyp):
	            		
	            		?>
						<td class="table-left">&nbsp;</td>
						<td><?php 
						if ($logonTyp['Log']['customer_id'] == '')
						{
							echo 'INTERNAL';
						} 
						else 
						{
							echo $logonTyp['Log']['customer_id'];
						} 
						?></td>
						<td><?php echo $logonTyp[0]['count(`Log`.`id`)']; ?></td>
						<td class= "table-right-ohne"></td>
						<?php endforeach; ?>
		        	</tr>
		        	</tbody>
				</table>
			</div>
			
			<?php  } ?>
			
			
			
				
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
        	 <h3><?php __('Customer List') ?></h3>
                 <p>
                  <?php __('info_ReportsPage') ?>
                 </p>
        </div>

</div>
<!--ight hand side  ends here-->
