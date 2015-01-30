<?php 
class GeneralHelper extends Helper
{
	// get list of already inserted DN records.
	function get_odsentries($scenario_id) {
        App::import("Model","Odsentry");
         $this->Odsentry= new Odsentry;
         $result= $this->Odsentry->find('list', array(
         'conditions' => array('scenario_id'=>$scenario_id),
         'fields' => array('source'),
         'order'=>'id ASC'
		));
         return $result;
    }

	function get_scenarios($odsentry_source){
		App::import("Model","Odsentry");
         $this->Odsentry= new Odsentry;
		if($odsentry_source !=''){
			$result= $this->Odsentry->find('all', array('conditions' => array('Odsentry.source'=>$odsentry_source), 'fields'=>array('Scenario.id', 'Scenario.Name')));		
		} else {
			$result = array($odsentry_source);
		}
		
        return $result;	
	
	}

}
	