
<?php
/**
 * Trunks Controller
 *
 * file: /app/controllers/trunk_controller.php
 */
	#var $header_string = 'Trunks';
class TrunksController extends AppController {

	var $uses 	= array('Trunk','Location','Trunkentry', 'Dns');
	var $name 	= 'Trunks';
	
	var $paginate = array('Paginate' => 15, 'page' => 1);
	var $components = array('RequestHandler');

	// load any helpers used in the views
	var $helpers = array('Html', 'Form', 'Javascript');	
	
	/**
	 * default action
	 *
	 */

	function beforeFilter (){
		$this->log("Trunk controller : Start of before_filter", LOG_DEBUG);

		parent::beforeFilter();
		
		if(!$this->Session->read('SELECTED_CUSTOMER')){
			$this->layout='ajax';
			$this->cakeError('sessionExpired'); 
		}
		
	}	 
	 
	public function index ($customer_id=null){
		$this->log("Trunk controller : Start of Index", LOG_DEBUG);
		
		/**********for case of internal/external users********/
		if ($this->Session->read('SELECTED_CUSTOMER') != Configure :: read('access_id')) {
			 
			$id = $this->Session->read('SELECTED_CUSTOMER');
			 
			if (!$this->Customer->validCustomer($id,$customer_id)) {
				$this->log("Trunks controller : Edit Function: Invalid customer:" . $id . ':' . $customer_id , LOG_DEBUG);
				$this->redirect('/customers');
				exit ();
			}
			 
		}
		/**********************END*************************/
		
		$this->pageTitle = 'Trunk List';

		//Get Customer Id
		//$customer_id=isset($this->params['url']['customer_id'])?$this->params['url']['customer_id']:(isset($this->params['named']['customer_id'])?$this->params['named']['customer_id']:"");
		
		$this->paginate['Paginate']	=	$this->AutoPaginate->setPaginate();
		$this->set('title_header', __('Swisscom Extranet Corporate Business - Voiphone Selfcare', true));	
		$this->Trunk->recursive=1;
		
		$cond = array('Location.customer_id'=>$customer_id);
		//$cond = array('Trunk.status'=>1,'Location.customer_id'=>$customer_id);
		
		$name=isset($this->params['url']['name'])?$this->params['url']['name']:(isset($this->params['named']['name'])?$this->params['named']['name']:"");
		if($name!=''){
			$cond = array_merge($cond,array('Trunk.name LIKE'=>'%'.$name.'%'));
			$this->passedArgs['name'] = $name;			
		}
		
		$location_name=isset($this->params['url']['location_name'])?$this->params['url']['location_name']:(isset($this->params['named']['location_name'])?$this->params['named']['location_name']:"");
		if($location_name!=''){
			$cond = array_merge($cond,array('Location.name LIKE'=>'%'.$location_name.'%'));
			$this->passedArgs['location_name'] = $location_name;			
		}
		
		$gate_type=isset($this->params['url']['gate_type'])?$this->params['url']['gate_type']:(isset($this->params['named']['gate_type'])?$this->params['named']['gate_type']:"");
		if($gate_type!=''){
			$cond = array_merge($cond,array('Trunk.gate_type LIKE'=>'%'.$gate_type.'%'));
			$this->passedArgs['gate_type'] = $gate_type;
			
		}
		$pbx_type=isset($this->params['url']['pbx_type'])?$this->params['url']['pbx_type']:(isset($this->params['named']['pbx_type'])?$this->params['named']['pbx_type']:"");
		if($pbx_type!=''){
			$cond = array_merge($cond,array('Trunk.pbx_type LIKE'=>'%'.$pbx_type.'%'));
			$this->passedArgs['pbx_type'] = $pbx_type;
				
		}
		$remark=isset($this->params['url']['remark'])?$this->params['url']['remark']:(isset($this->params['named']['remark'])?$this->params['named']['remark']:"");
		if($remark!=''){
			$cond = array_merge($cond,array('Trunk.remark LIKE'=>'%'.$remark.'%'));
			$this->passedArgs['remark'] = $remark;
		
		}
		$call_scenario=isset($this->params['url']['call_scenario'])?$this->params['url']['call_scenario']:(isset($this->params['named']['call_scenario'])?$this->params['named']['call_scenario']:"");
		if($call_scenario!=''){
			$cond = array_merge($cond,array('Trunk.call_scenario LIKE'=>'%'.$call_scenario.'%'));
			$this->passedArgs['call_scenario'] = $call_scenario;
		}	
		
		#Following removes server side pagination for overlay and binds the ods model for odsentries
		if(isset($this->params['url']['type']) && $this->params['url']['type']=='detail'){
			$this->paginate['limit'] = 100000;
		}
	
		// GEt distinct gate types of trunks
		$gate_type_list = $this->Trunk->find('all', array(
			'fields'=>array('DISTINCT gate_type'),
			'conditions'=>array('customer_id' => $customer_id)
		));
		
		$gate_type_list_arr[''] = '';
		foreach($gate_type_list as $gatype):
			$localized_gatetype = __($gatype['Trunk']['gate_type'], true);
			$gate_type_list_arr[$gatype['Trunk']['gate_type']] = "$localized_gatetype";
		endforeach;		
		
		$this->set('gate_type_list', $gate_type_list_arr);	
		
		
		$this->paginate = array('conditions'=>$cond,'limit' => $this->paginate['limit']);
		
		$results = $this->paginate('Trunk');
		$this->set('trunks', $results);				
		$this->set('customer_id', $customer_id);	
		$this->set('SELECTED_CNN',$customer_id);
		$this->set('cust_for_layout',$customer_ide);
		$this->set('custName',$customer_id);
		$this->set('selected_customer',  $customer_id);
		
		$locationDNCount = $this->Dns->find('all', array(
            'contain' => array('Dns', 'Trunk','Location'),
            'fields' => array(
                'Dns.location_id',
                'count(Dns.location_id)'),
            'group' => 'Dns.location_id',
            'conditions' => array('Location.customer_id' => $customer_id))
        );
		
		$trunkDNCount = $this->Trunk->find('all', array(
				
				'fields' => array(
						'Trunk.location_id',
						'Trunkentry.trunk_id',
						'count(Trunkentry.trunk_id)'),
				'joins' => array(

						array(
								'table' => 'trunkentries',
								'type' => 'LEFT',
								'alias' => 'Trunkentry',
								'conditions' => array('Trunkentry.trunk_id = Trunk.id'),
								
						)
						
						
				),
				'group' => 'Trunkentry.trunk_id',
				'conditions' => array('Location.customer_id' => $customer_id))
		);
		

				
		
        foreach ($locationDNCount as $locationDNCountIndiv) {
            $locationDNMap[$locationDNCountIndiv['Dns']['location_id']] = $locationDNCountIndiv[0]['count(`Dns`.`location_id`)'];
        }
        $this->set('locationDNCount', $locationDNMap);
        
        foreach ($trunkDNCount as $trunkDNCountIndiv) {
        	$trunkDNMap[$trunkDNCountIndiv['Trunkentry']['trunk_id']] = $trunkDNCountIndiv[0]['count(`Trunkentry`.`trunk_id`)'];
        }
        $this->set('trunkDNCount', $trunkDNMap);
        
        $locations_array = print_r($locationDNCount, true);
        $this->log("Trunks controller : DN Map" . $locations_array, LOG_DEBUG);
				
		if(isset($this->params['url']['type']) && $this->params['url']['type']=='detail'){
			$this->layout = false;
			$this->render('detail');
		}
	}


	function edit() { 

		$this->pageTitle = 'Trunk Edit';
		
		$trunk_id=isset($this->params['url']['trunk_id'])?$this->params['url']['trunk_id']:(isset($this->params['named']['trunk_id'])?$this->params['named']['trunk_id']:"");
		
		if(!empty($this->data)){
			$this->Trunk->save($this->data);
		}
		
		$trunkDetails = $this->Trunk->find('all',array('conditions'=>array('Trunk.id'=>$trunk_id)));
		$customer_id = $trunkDetails[0]['Location']['customer_id'];
		
		$possibleTrunks = $this->Trunk->getPossibleTrunks($customer_id); # 
		$locations_array = print_r($possibleTrunks, true);
		$this->log("Trunks controller : Trunk Map" . $locations_array, LOG_DEBUG);
		$possTrunks = array();
		foreach($possibleTrunks as $possibleTrunk)
		{
			array_push($possTrunks, $possibleTrunk['tr']['trunk_id']);
		}
		$this->set('possibleTrunks', $possTrunks);
		/**********for case of internal/external users********/
		if ($this->Session->read('SELECTED_CUSTOMER') != Configure :: read('access_id')) {
		
			$id = $this->Session->read('SELECTED_CUSTOMER');
		
			if (!$this->Customer->validCustomer($id,$customer_id)) {
				$this->log("Trunks controller : Edit Function: Invalid customer:" . $id . ':' . $customer_id , LOG_DEBUG);
				$this->redirect('/customers');
				exit ();
			}
		
		}
		/**********************END*************************/
		
		
		$this->set('trunkDetails', $trunkDetails);
		$this->set('trunk_id', $trunk_id);
		
		$this->set('customer_id', $customer_id);
		$this->set('SELECTED_CNN',$customer_id);
		$this->set('cust_for_layout',$customer_id);
		$this->set('custName',$customer_id);
		$this->set('selected_customer',  $customer_id);
		
		$dnsCount =$this->Dns->find('count',
				array(
						'contain'=> array('Dns', 'Location'),
						'conditions' => array('Location.customer_id' => $customer_id)
				)
		);
		$this->set('dnsCount',$dnsCount);
		
		$this->Dns->bindModel(
				array('hasMany' => array(
						'Trunkentry' => array(
								'className' => 'Trunkentry',
								'fields'=>'Trunkentry.*',
								'foreignKey'=>'dn_id'
						)
				)
				), false
		);
		$dnsCount_trunk =$this->Dns->find('count',
				array(
						'contain'=> array('Dns', 'Location', 'Trunkentry'),
						'joins' => array(
        						array(
        								'table' => 'trunkentries',
        								'type' => 'LEFT',
        								'alias' => 'Trunkentry',
        								'conditions' => array('Dns.id = Trunkentry.dn_id')
        						)
        				),
						'conditions' => array('Trunkentry.trunk_id' => $trunk_id)
				)
		);
		$this->set('dnsCount_trunk',$dnsCount_trunk);
		
	  }		
	  function update($id=null)
	  {
	  
	  	$this->log("Trunks controller : saving changes", LOG_DEBUG);
	  
	  	
	  	 
	  	if ($this->Trunk->save($this->data)) {
	  		$this->Session->setFlash('<div id="success">Your Trunk has been saved successfully.</div>');
	  	} else {
	  		$this->Session->setFlash('Unable to update your Trunk data.');
	  	}
	  	$id = $this->Trunk->id;
	  	$this->redirect(array('action' => 'edit/'.$id));
	  	#exit();
	  }
	  
	  
	 /*
     * **************************************************
      Function Name   : edit_trunk_via_ajax
      Description     : This function is use for Update Location Title.
      Parameter       : NA
      Return       	  : NA
      Created Date    : 29/01/2014.
     * **************************************************
     */

	
	 function edit_trunk_via_ajax() {
	 	 $this->layout=false;	
	  	$trunk_name=trim($this->params['form']['value']);
		$trunk_id=isset($this->params['url']['trunk_id'])?$this->params['url']['trunk_id']:(isset($this->params['named']['trunk_id'])?$this->params['named']['trunk_id']:"");
			$this->Trunk->updateAll(
							array('Trunk.name' => "'".$trunk_name."'"),
							array('Trunk.id' => $trunk_id)
				);
		exit();		
   } 

	/**
	* function toggleView()
	* 
	* @return
	*/
	
	function toggleView() {
   
        $this->layout = false;
        $location_id = isset($this->params['url']['trunk_id']) ? $this->params['url']['trunk_id'] : (isset($this->params['named']['trunk_id']) ? $this->params['named']['trunk_id'] : "");
        $customer_id = isset($this->params['url']['customer_id']) ? $this->params['url']['customer_id'] : (isset($this->params['named']['customer_id']) ? $this->params['named']['customer_id'] : "");
        #$mode = isset($this->params['url']['mode']) ? $this->params['url']['mode'] : (isset($this->params['named']['mode']) ? $this->params['named']['mode'] : "");
        $view = isset($this->params['url']['view']) ? $this->params['url']['view'] : (isset($this->params['named']['view']) ? $this->params['named']['view'] : "");
        #$scenariodetails = $this->Scenario->find('first', array('conditions' => array('Scenario.id' => $_POST['data']['Scenario']['id'])));
        $this->Session->delete('VIEWMODE');
        if($view == 'EXTERNAL')
        {
        	$this->Session->write('VIEWMODE', 'EXTERNAL');
        }
       
     
        $this->redirect('index/' . $customer_id );
        
    }
   
   
   function deleteTrunk($trunkId=null){
   	
   	 $customer_id = isset($this->params['url']['customer_id']) ? $this->params['url']['customer_id'] : (isset($this->params['named']['customer_id']) ? $this->params['named']['customer_id'] : "");
   	
	$trunk_id = isset($this->params['url']['trunk_id']) ? $this->params['url']['trunk_id'] : (isset($this->params['named']['trunk_id']) ? $this->params['named']['trunk_id'] : "");
	
	
	$trunk_name = isset($this->params['url']['trunk_name']) ? $this->params['url']['trunk_name'] : (isset($this->params['named']['trunk_name']) ? $this->params['named']['trunk_name'] : "");
	
	   
    $deleteFlag=$this->Trunk->deleteAll(array('Trunk.id' => $trunk_id), false);
	
	if ($deleteFlag) {
		
		$transStatus = 1;
				$log_entry = "trunk deleted :".$trunkid;
				
				$insert = array (
						'Log' => array (
								'affected_obj' => $trunk_id,
								'affected_obj_name'=>$trunk_name,
								'affected_obj_type' => 'Trunk',
								'log_entry' => $log_entry,
								'log_details' => 'trunk deleted:' . $transaction_id,
								'created' => date('Y-m-d H:i:s'),
								'status' => 1,
								'customer_id' => $customer_id,
								'bsk' => $this->Session->read('BSK'),
								'user' => $this->Session->read('ACCOUNTNAME'),
								'app_type' => $this->Session->read('APPNAME'),
								'modified' => '0000-00-00 00:00:00',
								'modification_status' => $transStatus,
								'modification_response' => $transResponse,
								'transaction_id' => $transaction_id
						)
				);
					
				$this->Log->create();
				$this->Log->save($insert, false);
					
				$log_id = $this->Log->id;
				
				
				//$_SESSION['success'] = __('applySucceeded', true) ;
				$link = '<a class="fancybox fancybox.ajax" href="' . Configure::read('base_url') . '/logs/logdetails/' . $log_id . '">' . __("LogEntry", true) . '</a>';
				//$_SESSION['success'].= $link;	
				
				
				 $this->Session->setFlash('<div class="notification first" style="width: 100%" >		
						<div class="ok"><div class="message">'.__('Trunk Deleted Successfully',true).$link.'</div></div></div>');
						
	  		
	  	} else {
			
			$transStatus = 0;
				$log_entry = "trunk deleted :".$trunkid;
				
				$insert = array (
						'Log' => array (
								'affected_obj' => $trunk_id,
								'affected_obj_type' => 'Trunk',
								'log_entry' => $log_entry,
								'log_details' => 'trunk deleted:' . $transaction_id,
								'created' => date('Y-m-d H:i:s'),
								'status' => 1,
								'customer_id' => $customer_id,
								'bsk' => $this->Session->read('BSK'),
								'user' => $this->Session->read('ACCOUNTNAME'),
								'app_type' => $this->Session->read('APPNAME'),
								'modified' => '0000-00-00 00:00:00',
								'modification_status' => $transStatus,
								'modification_response' => $transResponse,
								'transaction_id' => $transaction_id
						)
				);
					
				$this->Log->create();
				$this->Log->save($insert, false);
					
				$log_id = $this->Log->id;
				
				
				
				//$_SESSION['error'] = __('applyFailed', true) ;
				$link = '<a class="fancybox fancybox.ajax" href="' . Configure::read('base_url') . '/logs/logdetails/' . $log_id . '">' . __("LogEntry", true) . '</a>';
				//$_SESSION['error'] .= $link;
				
				 $this->Session->setFlash('<div class="notification first" ><div class="error"><div class="message">'.__('Trunk Not Deleted  ',true).$link.'</div></div></div>');
				
				
	  		
	  	}
	
	
     $this->redirect('index/' . $customer_id );
   	
   }

}
?>

