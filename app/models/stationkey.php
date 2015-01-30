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
class Stationkey extends AppModel {
/**
 * name property
 *
 * @var string 'Stationkey'
 * @access public
 */
	var $name = 'Stationkey';

/**
 * belongsTo property
 *
 * @var array
 * @access public
 */
		//var $belongsTo = array('Stations.Station');
		var $belongsTo = array('Locations.Location','Stations.Station');
	
	
	//var $belongsTo = array('Stationkey'=>array('conditions' => array('Stationkey.station_id = Station.id')));
}
?>
