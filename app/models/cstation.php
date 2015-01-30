<?php

#-----------------------------------------------------------------#
# $Rev:: 23            $:  Revision of last commit                #
#-----------------------------------------------------------------#

/**
 * Station class
 *s
 * @uses          AppModel
 * @package       mi-base
 * @subpackage    mi-base.app.models
 */
class CStation extends AppModel {
/**
 * name property
 *
 * @var string 'CStation'
 * @access public
 */
	var $name = 'CStation';

/**
 * belongsTo property
 *
 * @var array
 * @access public
 */
	var $belongsTo = array('Station' =>array('className'=>'Station'));
	
	
	//var $belongsTo = array('Customer'=>array('conditions' => array('Station.customer_id = Customer.id')));
function station_count($cust_id ,$loc_id){
		
		
		$sql	=	"SELECT COUNT( DISTINCT (
						station_id
								) ) AS `count` 
									FROM `stationkeys` AS `Stationkey` 
									LEFT JOIN `stations` AS `Station` ON ( `Stationkey`.`station_id` = `Station`.`id` ) 
										WHERE `Station`.`customer_id` = '$cust_id'
									AND `Stationkey`.`location_id` = '$loc_id'";
		return $this->query($sql);
			
	}
	
	function getPilotFromDn($DN){
	//This function will return ONLY 1, even if more than 1 pilot is detected.	
		$sql	=	"select stationkeys.* from stationkeys, features where stationkeys.dn = '$DN' and features.stationkey_id = stationkeys.id and features.short_name='PILOT'";
		return $this->query($sql);
	}
	function getPilotFromKey($Key){
	//This function will return ONLY 1, even if more than 1 pilot is detected.	
		$sql	=	"select stationkeys.* from stationkeys, features where stationkeys.dn =(select stationkeys.dn from stationkeys, features f where f.stationkey_id = stationkeys.id and (f.short_name = 'MADN') and stationkeys.id ='$Key') and features.stationkey_id = stationkeys.id and features.short_name='PILOT'";
		return $this->query($sql);
	}
	function getGroupMembersFromDn($DN){
	//This function will return the group members of a group (type madn or hunt)	
		$sql	=	"select stationkeys.* from stationkeys, features f where stationkeys.dn = '$DN'  and f.stationkey_id = stationkeys.id and (f.short_name = 'HNTID' OR f.short_name = 'MADN');";
		return $this->query($sql);
	}
	function getGroupMembersFromKey($Key){
	//This function will return the group members of a group (type madn or hunt)	
		$sql	=	"select * from stationkeys where stationkeys.dn = (select stationkeys.dn from stationkeys, features f where f.stationkey_id = stationkeys.id and (f.short_name = 'MADN') and stationkeys.id ='$Key');";
	return $this->query($sql);
	}
}
?>
