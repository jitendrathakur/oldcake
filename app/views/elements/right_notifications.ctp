<?php
#$this->log('LEFTMENU ELEMENT :' . $SELECT_CUSTOMER . ' ' . $APP . ' ' . $PAGE_TITLE, LOG_DEBUG);



			#Call to action
			
			$ods = $this->requestAction('customers/calltoactioncounts/' . $SELECT_CUSTOMER);
			if(count($ods['ODSValidations'])  > 0)
			{
				echo '<li><b>';
				__('ODSValidations'); 
				echo '</b></li>';
				foreach($ods['ODSValidations'] as $ODSValidation){
				
					echo '<li>';
				
					echo $html->link($ODSValidation['Scenario']['customer_id'] . ' : ' . $ODSValidation['Scenario']['Name'], array('controller'=>'scenarios', 'action'=>'edit/scenario_id:'.$ODSValidation['Scenario']['id']), array('class'=> $selected['Group']));
					echo '</li>';
				}
			}
			if(count($ods['ODSExceptions'])  > 0)
			{
				
				echo '<li><b>';
				__('ODSExceptions');
				echo '</b></li>';
				foreach($ods['ODSExceptions'] as $ODSException){
				
					echo '<li>';
				
					echo $html->link($ODSException['Scenario']['customer_id'] . ' : ' . $ODSException['Scenario']['Name'], array('controller'=>'scenarios', 'action'=>'index/customer_id:'.$ODSException['Scenario']['customer_id']), array('class'=> $selected['Group'] ));
					echo '</li>';
				}
			}
			
			
			if(count($ods['STATIONExceptions'])  > 0)
			{
			
				echo '<li><b>';
				__('STATIONExceptions');
				echo '</b></li>';
				foreach($ods['STATIONExceptions'] as $STATIONException){
			
					echo '<li>';
			
					echo $html->link($STATIONException['Station']['customer_id'] . ' : ' . $STATIONException['Station']['id'], array('controller'=>'stations', 'action'=>'editstation',$STATIONException['Station']['id']), array('class'=> $selected['Group'] ));
					echo '</li>';
				}
			}
			if(count($ods['TRUNKExceptions'])  > 0)
			{
					
				echo '<li><b>';
				__('EMPTYTrunks');
				echo '</b></li>';
				foreach($ods['TRUNKExceptions'] as $TRUNKException){
						
					echo '<li>';
						
					echo $html->link($TRUNKException['Location']['customer_id'] . ' : ' . $TRUNKException['Trunk']['id'], array('controller'=>'trunks', 'action'=>'index',$TRUNKException['Location']['customer_id']), array('class'=> $selected['Group'] ));
					echo '</li>';
				}
			}
	
			#Call Customer Summary
			#$counts = $this->requestAction('customers/counts/' . $SELECT_CUSTOMER);

			#foreach($counts['InWorkStations'][$SELECT_CUSTOMER] as $inWork){
			
			#	echo '<li>';
			
			#	echo $html->link(__('station', true) . ' : ' . $inWork['Station']['id'], array('controller'=>'stations', 'action'=>'design',$inWork['Station']['id']), array('class'=> $selected['Group']));
			#	echo '</li>';
			#}
			#if($counts['InWorkDns'][$SELECT_CUSTOMER] > 0){
					
			#	echo '<li>';
					
			#	echo $html->link(__('totalDNInWork', true) . ' : ' . $counts['InWorkDns'][$SELECT_CUSTOMER], array('controller'=>'dns', 'action'=>'edit/customer_id:' . $SELECT_CUSTOMER), array('class'=> $selected['Group']));
			#	echo '</li>';
			#}
			
			
			
			
			/*if($counts['InWorkStationCount'][$SELECT_CUSTOMER] > 0){
					
				echo '<li>';
					
				echo $html->link(__('totalStationsInWork', true) . ' : ' . $counts['InWorkStationCount'][$SELECT_CUSTOMER], array('controller'=>'stations', 'action'=>'index/'.$SELECT_CUSTOMER . '&status=5'), array('class'=> $selected['Group']));
				echo '</li>';
			}*/
?>
