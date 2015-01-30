<?php

#-----------------------------------------------------------------#
# $Rev:: 23            $:  Revision of last commit                #
#-----------------------------------------------------------------#

/**
 * Station class
 *
 * @uses          AppModel
 * @package       mi-base
 * @subpackage    mi-base.app.models
 */
class Log extends AppModel {
/**
 * name property
 *
 * @var string 'Station'
 * @access public
 */
	var $name = 'Log';
	
	
	var $hasOne = array(
			'Transaction'=>array(
					'className'=>'Transaction'
			)
	);
	
	function getLogDetails($key = null,$status=null,$cust_id =null)
	{
		
		if($status == 8)
		{
			$cond =array('Log.affected_obj' =>$key,'Log.customer_id'=>$cust_id,'Log.log_entry like'=>'%Rejected%');
		}
		else {
			$cond =array('Log.affected_obj' =>$key,'Log.customer_id'=>$cust_id,'Log.log_entry like'=>'%Execution finished%', 'Log.modification_status'=>'0');
		}
		$record = $this->find('all',array('conditions'=>$cond,'order'=>'Log.id desc','limit' =>1));
		
		//$record = $this->find('all', array('fields' => array('Log.modification_response'),'conditions' => array('Log.affected_obj' =>$key,'Log.customer_id'=>$cust_id,'Log.log_entry'=>'scenario_rejected' )));
		
		return $record;			
	}	

}
?>
