	<H1>Exception Monitoring Page</H1>

	<?php foreach($odsExceptions as $odsException)
	{
		echo "ODS IN EXCEPTION FOR CUSTOMER : " . $odsException['Scenario']['customer_id'] .  ' : ' ;
		
		?>
		<a href="<?php echo Configure::read('base_url');?>scenarios/edit/scenario_id:<?php echo $odsException['Execution']['scenario_id']?>">EXCEPTION</a>
		<br>
		<?php   
		                              
	}?>
	<?php foreach($stationExceptions as $stationException)
	{
		echo "STATION IN EXCEPTION FOR CUSTOMER : " . $stationException['Station']['customer_id'] .  ' : ' ;
		
		?>
		<a href="<?php echo Configure::read('base_url');?>stations/editstation/<?php echo $stationException['Station']['id']?>"><?php echo $stationException['Station']['id']?></a>
		<br>
		<?php   
		                              
	}?>
