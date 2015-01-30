<?php
/**
 * file: app/model/scenarion_execution.php
 *
 * Scenario_Execution Model
 */
class Execution extends AppModel {
    // good practice to include the name variable
    var $name = 'Execution';
    // setup the has many relationships

	var $belongsTo = array(
        	'Scenario'=>array(
			    'className'=>'Scenario'
			)
    	);
}
?>
