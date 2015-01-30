	<H1>ODS Monitoring Page</H1>

	<?php foreach($odsRequests as $odsRequest)
	{
		echo "ODS REQUEST VALIDATE FOR CUSTOMER : " . $odsRequest['Log']['customer_id'] .  ' : ' ;
		
		?>
		<a href="<?php echo Configure::read('base_url');?>scenarios/edit/scenario_id:<?php echo $odsRequest['Log']['affected_obj']?>">VALIDATE</a>
		<br>
		<?php   
		                              
	}?>
	<?php foreach($odsExceptions as $odsException)
	{
		echo "ODS IN EXCEPTION FOR CUSTOMER : " . $odsException['Scenario']['customer_id'] .  ' : ' ;
		
		?>
		<a href="<?php echo Configure::read('base_url');?>scenarios/edit/scenario_id:<?php echo $odsException['Execution']['scenario_id']?>">EXCEPTION</a>
		<br>
		<?php   
		                              
	}?>
