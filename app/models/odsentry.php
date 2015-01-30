<?php

#-----------------------------------------------------------------#
# $Rev:: 23            $:  Revision of last commit                #
#-----------------------------------------------------------------#

/**
 * ODsentry class
 *
 * @uses          AppModel
 * @package       mi-base
 * @subpackage    mi-base.app.models
 */
class odsentry extends AppModel {
/**
 * name property
 *
 * @var string 'Odsentry'
 * @access public
 */
	var $name = 'Odsentry';

/**
 * belongsTo property
 *
 * @var array
 * @access public
 */
 var $belongsTo = array('Scenarios.Scenario');
 	
}
?>
