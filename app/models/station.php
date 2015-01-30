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
class Station extends AppModel {
/**
 * name property
 *
 * @var string 'Station'
 * @access public
 */
	var $name = 'Station';

/**
 * belongsTo property
 *
 * @var array
 * @access public
 */
	
	var $belongsTo = array('Customer' =>array('className'=>'Customer'));
	
	
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
		$sql	=	"select stations.*, stationkeys.* from stationkeys, features, stations where stationkeys.station_id = stations.id and stationkeys.dn =(select stationkeys.dn from stationkeys, features f where f.stationkey_id = stationkeys.id and (f.short_name = 'MADN') and stationkeys.id ='$Key') and features.stationkey_id = stationkeys.id and features.short_name='PILOT'";
		return $this->query($sql);
	}
	function getGroupMembersFromDn($DN){
	//This function will return the group members of a group (type madn or hunt)	
		$sql	=	"select stationkeys.* from stationkeys, features f where stationkeys.dn = '$DN'  and f.stationkey_id = stationkeys.id and (f.short_name = 'HNTID' OR f.short_name = 'MADN');";
		return $this->query($sql);
	}

	function getGroupDisplaynameFromDn($DN){
		//This function will return the group members of a group (type madn or hunt)
		$sql	=	"select primary_value from features where short_name = 'DISPLAYNAME' and stationkey_id = (select f.stationkey_id from features f, stationkeys sk where f.stationkey_id = sk.id and f.short_name = 'PILOT' and sk.dn = '$DN');";
		return $this->query($sql);
	}
	function getXlhGroupDisplaynameFromCust($cust_id){
		//This function will return the group members of a group (type madn or hunt)
		$sql	=	"select s2.primary_value, s1.id, s3.primary_value from (select sk.id, s.customer_id from features f, stationkeys sk, stations s where short_name = 'GROUP_PREMEMBER' and f.stationkey_id = sk.id and sk.station_id = s.id and f.primary_value = s.port) as s1, (select sk.id, f.primary_value  from features f, stationkeys sk where short_name = 'HNTID' and f.stationkey_id = sk.id) as s2 left outer join (select sk.id, f.primary_value from features f, stationkeys sk where short_name = 'DISPLAYNAME' and f.stationkey_id = sk.id) as s3 on s3.id = s2.id where s1.id = s2.id and s1.customer_id = '$cust_id';";
		return $this->query($sql);
	}
	
	function getGroupMembersFromKey($Key){
	//This function will return the group members of a group (type madn or hunt)	
		$sql	=	"select * from stationkeys where stationkeys.dn = (select stationkeys.dn from stationkeys, features f where f.stationkey_id = stationkeys.id and (f.short_name = 'MADN') and stationkeys.id ='$Key');";
	return $this->query($sql);
	}
	function getStationsWithFreeKey($customer_id){

		//This function will return the group members of a group (type madn or hunt)
		$sql	=	"select T1.station_id, 8-count(*) as remaining from (select distinct f.stationkey_id, sk.station_id from features f, stationkeys sk, stations s where f.stationkey_id = sk.id and f.primary_value != '' and sk.station_id = s.id and s.phone_type = '1120' and s.customer_id = '$customer_id' having f.stationkey_id < 9) as T1 group by T1.station_id having remaining < 1;";
		
		$eleventwenty = $this->query($sql);
		$sql	=	"select T1.station_id, 12-count(*) as remaining from (select distinct f.stationkey_id, sk.station_id from features f, stationkeys sk, stations s where f.stationkey_id = sk.id and f.primary_value != '' and sk.station_id = s.id and s.type = 'CICM' and s.phone_type != '1120' and s.customer_id = '$customer_id' having f.stationkey_id < 13) as T1 group by T1.station_id having remaining < 1;";
		$othercicm = $this->query($sql);
		$nofreekeys = array_merge($eleventwenty,$othercicm );
		return $nofreekeys;
	}
	function createAsisStation($StationId){
		//
		$sql	=	"replace into c_stations select * from stations where id='$StationId';";
		return $this->query($sql);
	}
	function createAsisStationKeys($StationId){
		//

		$sql	=	"replace into c_stationkeys select * from stationkeys where station_id='$StationId';";
		return $this->query($sql);
	}
	function createAsisFeatures($StationId){
		//
		$sql	=	"insert into c_features select features.* from stationkeys,features where features.stationkey_id = stationkeys.id and stationkeys.station_id ='$StationId';";
		return $this->query($sql);
	}
	function deleteAsisFeatures($StationId){
		//
		$sql	=	"delete c_features.* from c_features, c_stationkeys where c_features.stationkey_id = c_stationkeys.id and c_stationkeys.station_id='$StationId';";
		return $this->query($sql);
	}
	function deleteAsisStationkeys($StationId){
		//
		$sql	=	"delete c_stationkeys.* from c_stationkeys where c_stationkeys.station_id='$StationId';";
		return $this->query($sql);
	}
	function deleteAsisStation($StationId){
		//
		$sql	=	"delete c_stations.* from c_stations where c_stations.id='$StationId';";
		return $this->query($sql);
	}
	
	// For recreateing reset
	
	function resetStation($StationId){
		//
		$sql	=	"replace into stations select * from c_stations where id='$StationId';";
		return $this->query($sql);
	}
	function resetStationKeys($StationId){
	//
	
	$sql	=	"replace into stationkeys select * from c_stationkeys where station_id='$StationId';";
	return $this->query($sql);
	}
	function resetFeatures($StationId){
	//
	$sql	=	"insert into features select c_features.* from stationkeys,c_features where c_features.stationkey_id = stationkeys.id and stationkeys.station_id ='$StationId';";
	return $this->query($sql);
	}
	function deleteFeatures($StationId){
	//
	$sql	=	"delete features.* from features, stationkeys where features.stationkey_id = stationkeys.id and stationkeys.station_id='$StationId';";
	return $this->query($sql);
	}
}
?>
