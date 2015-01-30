<?php
/**
 * file: app/model/group.php
 *
 * Group Model
 */
class Group extends AppModel {
    // good practice to include the name variable
    var $name = 'Group';


	var $belongsTo = array(
        	'Customer'=>array(
			    'className'=>'Customer'
			),/*

                'Stationkey' => array(
				'className'=>'Stationkey',
							'foreignKey' => false,
							'type'=>'RIGHT',
							'conditions' => array('Group.id = Stationkey.dn')
                                )*/
                            
			
    	);
	function getCPUStationsFromLocation($cust_id, $loc_id){
		//This function will return the group members of a group (type madn or hunt)
		$sql	=	"select statId from (select f.primary_value as cpuIdent, sk2.station_id as statId from features f, stationkeys sk2 where f.stationkey_id = sk2.id and sk2.station_id and short_name = 'cpu') t2 left join  (select s1.id as t1sid, s1.customer_id as custId, l1.name as loc_name,l1.id as loc_id from stationkeys sk1, locations l1, stations s1  where sk1.location_id = l1.id and sk1.id like '01%' and sk1.station_id = s1.id) t1 on t1.t1sid = t2.statId where custId='$cust_id' and loc_id = '$loc_id'";
		return $this->query($sql);
	}
	function changeId($id, $identifier){
		//This function will return the group members of a group (type madn or hunt)
		$sql	=	"update groups set id='$identifier' where id = '$id'";
		return $this->query($sql);
	}
	public function paginateCount($conditions = null, $recursive = 0, $extra = array()) {
		$conditions = compact('conditions');
		if ($recursive != $this->recursive) {
			$conditions['recursive'] = $recursive;
		}
	
		unset( $extra['contain'] );
	
		$count = $this->find('count', array_merge($conditions, $extra));
	
		if (isset($extra['group'])) {
			$count = $this->getAffectedRows();
		}
		return $count;
		 
		 
	}
		
}
?>
