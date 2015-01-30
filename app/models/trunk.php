<?php
class Trunk extends AppModel {
	var $name = 'Trunk';
    var $actsAs = 'Containable';	

	var $belongsTo = array(
        	'Location'=>array(
			    'className'=>'Location'
			)
    	);
	
function getPossibleTrunks($cust_id){
		//This function will return the group members of a group (type madn or hunt)
		$sql	=	"select distinct(trunk_id) from trunkentries tr, dns d, locations l where tr.dn_id = d.id and d.location_id = l.id and l.customer_id = '$cust_id' and trunk_id not in (select distinct(id) from trunks);";
		return $this->query($sql);
	}
}
?>
