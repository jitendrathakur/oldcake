<?php

#-----------------------------------------------------------------#
# $Rev:: 23            $:  Revision of last commit                #
#-----------------------------------------------------------------#

/**
 * Stationkey class
 *
 * @uses          AppModel
 * @package       mi-base
 * @subpackage    mi-base.app.models
 */
class Mediatrix extends AppModel {
/**
 * name property
 *x
 * @var string 'Mediatrix'
 * @access public
 */
	var $name = 'Mediatrix';
	var $actsAs = 'Containable';

/**
 * belongsTo property
 *
 * @var array
 * @access public
 */
		//var $belongsTo = array('Stations.Station');
		var $belongsTo = array('Locations.Location');
		var $hasMany = array(
        	'Port'=>array(
            		'className'=>'Port',
					'order' => 'Port.port_nr ASC'
        	)
    	);
	
	
	//var $belongsTo = array('Stationkey'=>array('conditions' => array('Stationkey.station_id = Station.id')));
}
?>
