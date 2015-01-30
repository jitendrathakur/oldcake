<?php

#-----------------------------------------------------------------#
# $Rev:: 23            $:  Revision of last commit                #
#-----------------------------------------------------------------#

/**
 * file: app/model/dns.php
 *
 * Customer Model
 */
class Dns extends AppModel {
    // good practice to include the name variable
    var $name = 'Dns';
    var $actsAs = 'Containable';
	
    // setup the has many relationships
    	var $belongsTo = array('Location'=>array('className'=>'Location'));
		
		var $hasOne  = array(
				'Odsentry' => array(
					'className' => 'odsentry',
					'foreignKey' => 'source',
				)
			);			
				
    	function createActiveDn($StationId, $function){
    		//
    		$function = strtoupper($function);
    		$sql	=	"insert into active_dn values ('$StationId', '$function', '', '', '','', 1, '');";
    		return $this->query($sql);
    	}
    	function deleteActiveDn($StationId){
    		//
    			$sql	=	"delete from active_dn where id = '$StationId';";
    			return $this->query($sql);
    	}
    	function generateScenarioMap($customerId){
    		//
    			$sql	=	"select d.id, o.scenario_id from dns d, odsentries o, scenarios s where d.id=o.source and o.scenario_id = s.id and s.customer_id = '$customerId';";
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
