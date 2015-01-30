<?php

#-----------------------------------------------------------------#
# $Rev:: 23            $:  Revision of last commit                #
#-----------------------------------------------------------------#

/**
 * file: app/model/customer.php
 *
 * Customer Model
 */
class Customer extends AppModel {
    // good practice to include the name variable
    var $name = 'Customer';
    var $actsAs = 'Containable';
   
    // setup the has many relationships
    var $hasMany = array(
        'Station'=>array(
            'className'=>'Station'
        ),
	'Location'=>array(
	    'className'=>'Location')
    );
    
    function validCustomer ($bsk,$id){
    	$stat	=	array('1,2,3');
    	$sql	=	"SELECT `Customer`.`id` FROM `customers` AS `Customer` WHERE `Customer`.`bsk` ='$bsk' AND `Customer`.`id` ='$id'  AND  `Customer`.`status` IN (1,2,3) ";
		return $this->query($sql);
    	
    }
    function countGen ($cids){
    	
    	$sql	=	"select l.customer_id, c.type, count(distinct t.id) as trunkcount,count(distinct s.id) as stationcount, count(distinct g.id) as groupcount,count(distinct m.id) as mediatrixcount, c.onDemand from locations l left join mediatrixes m on m.location_id = l.id left join stations s on s.location_id = l.id left join trunks t on t.location_id = l.id  left join customers c on l.customer_id = c.id left join groups g on g.customer_id = c.id where l.customer_id in ($cids) group by l.customer_id;
    ";
    	return	 $this->query($sql);
    	 
    }
    
}
?>
