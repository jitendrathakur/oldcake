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
class CStationkey extends AppModel {
/**
 * name property
 *
 * @var string 'Stationkey'
 * @access public
 */
	var $name = 'CStationkey';

/**
 * belongsTo property
 *
 * @var array
 * @access public
 */
		//var $belongsTo = array('Stations.Station');
		var $belongsTo = array('CStation' =>array('className'=>'CStation'),'Location' =>array('className'=>'Location'));
	
	
	//var $belongsTo = array('Stationkey'=>array('conditions' => array('Stationkey.station_id = Station.id')));
}
?>
