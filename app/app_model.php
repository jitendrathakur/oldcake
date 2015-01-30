<?php
/* SVN FILE: $Id$ */

/**
 * Application model for Cake.
 *
 * This file is application-wide model file. You can put all
 * application-wide model-related methods here.
 *
 * PHP versions 4 and 5
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright 2005-2010, Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright 2005-2010, Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       cake
 * @subpackage    cake.app
 * @since         CakePHP(tm) v 0.2.9
 * @version       $Revision: 18 $
 * @modifiedby    $LastChangedBy: root $
 * @lastmodified  $Date$
 * @license       http://www.opensource.org/licenses/mit-license.php The MIT License
 */

/**
 * Application model for Cake.
 *
 * Add your application-wide methods in the class below, your models
 * will inherit them.
 *
 * @package       cake
 * @subpackage    cake.app
 */
class AppModel extends Model {
	#function afterSave()
	#{
	#	$sql	=	"insert into objectselect l.customer_id, count(distinct t.id) as trunkcount,count(distinct s.id) as stationcount, count(distinct g.id) as groupcount,count(distinct m.id) as mediatrixcount, c.onDemand from locations l left join mediatrixes m on m.location_id = l.id left join stations s on s.location_id = l.id left join trunks t on t.location_id = l.id  left join customers c on l.customer_id = c.id left join groups g on g.customer_id = c.id where l.customer_id in ($cids) group by l.customer_id;
	#	";
	#	return	 $this->query($sql);
	#}
}
?>