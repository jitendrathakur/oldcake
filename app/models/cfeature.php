<?php

#-----------------------------------------------------------------#
# $Rev:: 23            $:  Revision of last commit                #
#-----------------------------------------------------------------#

/**
 * Feature class
 *
 * @uses          AppModel
 * @package       mi-base
 * @subpackage    mi-base.app.models
 */
class CFeature extends AppModel {
/**
 * name property
 *
 * @var string 'CFeature'
 * @access public
 */
	var $name = 'CFeature';

/**
 * belongsTo property
 *
 * @var array
 * @access public
 */
	var $belongsTo = array('CStationkeys.CStationkey');
	

}
?>
