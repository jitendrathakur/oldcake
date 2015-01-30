<?php

#-----------------------------------------------------------------#
# $Rev:: 23            $:  Revision of last commit                #
#-----------------------------------------------------------------#

/**
 * trunkentry class
 *
 * @uses          AppModel
 * @package       mi-base
 * @subpackage    mi-base.app.models
 */
class Trunkentry extends AppModel {
/**
 * name property
 *
 * @var string 'Trunkentry'
 * @access public
 */
	var $name = 'Trunkentry';

/**
 * belongsTo property
 *
 * @var array
 * @access public
 */
 var $belongsTo = array('Trunks.Trunk');
 	
}
?>
