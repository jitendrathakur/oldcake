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
class Port extends AppModel {
/**
 * name property
 *x
 * @var string 'Port'
 * @access public
 */
	var $name = 'Port';

/**
 * belongsTo property
 *
 * @var array
 * @access public
 */
		//var $belongsTo = array('Stations.Station');
		#var $belongsTo = array('Mediatrixes.Mediatrix', 'Station');
	var $belongsTo = array(
			'Mediatrix'=>array(
					'className'=>'Mediatrix'
			)
	);
	
	
	//var $belongsTo = array('Stationkey'=>array('conditions' => array('Stationkey.station_id = Station.id')));
}
?>
