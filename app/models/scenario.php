<?php
/**
 * file: app/model/scenario.php
 *
 * Scenario Model
 */
class Scenario extends AppModel {
    // good practice to include the name variable
    var $name = 'Scenario';
    // setup the has many relationships
    	var $hasMany = array(
        	'Execution'=>array(
            	'className'=>'Execution'
        	)
    	);
	var $belongsTo = array(
        	'Customer'=>array(
			    'className'=>'Customer'
			)
    	);
	function getCountDNinScenarios($scenario_id, $customer_id){
		//This function will return the group members of a group (type madn or hunt)
		$sql	=	"select count(*) from odsentries o1, scenarios s1 where o1.scenario_id = s1.id and s1.id = '$scenario_id' and o1.source in (select o.source from odsentries o, scenarios s where o.scenario_id = s.id and s.status = 6 and s.customer_id = '$customer_id' and s.id != '$scenario_id')";
		return $this->query($sql);
	}
}
?>
