<?php
#-----------------------------------------------------------------#
# $Rev:: 22            $:  Revision of last commit                #
#-----------------------------------------------------------------#

/**
 * Scenarios Controller
 *
 * file: /app/controllers/Groupss_controller.php
 */
	#var $header_string = 'Groups';
class GroupsController extends AppController {
	// good practice to include the name variable


	var $uses 	= array('Group', 'Stationkey', 'Feature', 'Station', 'Dns');
	var $name 	= 'Groups';
	
	var $paginate = array('Paginate' => 15, 'page' => 1);
	var $components = array('RequestHandler');
	#var $paginate = array('Paginate' => 15, 'page' => 1, 'order' => array('Customer.name' => 'asc'));
	
	
	// load any helpers used in the views
	var $helpers = array('Html', 'Form', 'Javascript');
    
	
	function beforeFilter (){
		$this->log('GROUPS CONTROLLER : BEFOREFILTER IN GROUPS CONTROLLER', LOG_DEBUG);
		$this->Session->write('sel_customer','');
		parent::beforeFilter();
		
		if(!$this->Session->read('SELECTED_CUSTOMER')){
			$this->layout='ajax';
			$this->cakeError('sessionExpired'); 
		}
	}
	/**
	 * default action
	 *
	 */

	function index (){
		
		

		$this->pageTitle = 'Group List';
		$this->log('GROUPS CONTROLLER : START INDEX ', LOG_DEBUG);
		
		$this->paginate['Paginate']	=	$this->AutoPaginate->setPaginate();
		
		$customer_id=isset($this->params['url']['customer_id'])?$this->params['url']['customer_id']:(isset($this->params['named']['customer_id'])?$this->params['named']['customer_id']:"");
		
		
		$success_flag=isset($this->params['url']['etype'])?$this->params['url']['etype']:(isset($this->params['named']['etype'])?$this->params['named']['etype']:"");
		#die();
		
		if (isset ($_POST['customer_id']) && $_POST['customer_id']) 
		{
			$customer_id=$_POST['customer_id'];
			$this->passedArgs['customer_id'] = $customer_id;
			
		}
		if($customer_id==''){
			
			$sel_location = $_POST['location'];
			$this->Session->write('sel_location', $sel_location);
			
			$this->log('GROUPS CONTROLLER : VALID CUSTOMER ID NOT SET', LOG_DEBUG);
			//$this->redirect('/customers');
			//exit();
		}
		
		
		if ($customer_id!= '')
			{
				#Find Locations
				$customer = $this->Customer->find('first',array('contain'=>array('Location'),'conditions'=>array('id'=>$customer_id)));
				foreach($customer['Location'] as $key=>$value):
				$locations[$value['id']] =  $value['name'];
				endforeach;
				$this->set('locations', $locations);
				$this->passedArgs['customer_id'] = $customer_id;
			}	
		
		
		

		
		/**********for case of external users********/
		if($this->Session->read('SELECTED_CUSTOMER')!=Configure::read('access_id')){

			#If The user is an external..
			
			$id=$this->Session->read('SELECTED_CUSTOMER');
			$cnt	=	 count($this->_Filter);
			
			if(!$this->Customer->validCustomer ($id,$customer_id)){
				#print_r("not valid");die();
				$this->log('GROUPS CONTROLLER : NOT A VALID CUSTOMER FOR GROUPS PAGE', LOG_DEBUG);
				$this->redirect('/customers');
				exit();
			}
			#print_r("valid checking $id $number");die();
		}
		
		/**********************END*************************/
		/**these for getting the current customer name**/
			
		#User for left hand Menu navigation.
		
		$groupStates = $this->Group->find('all', array(
				'fields'=>array('DISTINCT status'),
				'conditions'=>array('customer_id' => $customer_id)
		));
		$statuses[''] = '';
		$groupStatus = Configure :: read('groupStatus');
		foreach($groupStates as $groupState):
		#$localized_function = __($stationState['Station']['status'], true);
		$statuses[$groupState['Group']['status']] = $groupStatus[$groupState['Group']['status']];
		endforeach;
			
		$this->set('statuses',$statuses);
		
		$functions = $this->Group->find('all', array(
				'fields'=>array('DISTINCT type')
		));
		$func_list[''] = '';
		foreach($functions as $func):
		$localized_function = __($func['Group']['type'], true);
		$func_list[$func['Group']['type']] = "$localized_function";
		endforeach;

		$this->set('func_list',$func_list);
				
				$this->set('SELECTED_CNN',$customer_id);
				$this->set('SELECTED_CUSTOMER_NAME',$customer_id);
                 /*CBM Added for right hand section*/
                $customerInfo = $this->Customer->findById($customer_id);
                if (isset ($customerInfo['Customer']['name'])) {
                        $this->set('selected_customer', $customerInfo['Customer']['name']);
                } else {
                        $this->set('selected_customer', 'UNDEF');

                }


		/**end for getting the current customer name**/
		
		$cond = array('Group.customer_id'=>$customer_id, 'Feature.short_name'=>array('MADN', 'CPU'));

		$id=isset($this->params['url']['id'])?$this->params['url']['id']:(isset($this->params['named']['id'])?$this->params['named']['id']:"");
		if($id!=''){
			$cond = array_merge($cond,array('Group.identifier LIKE'=>'%'.$id.'%'));
			$this->passedArgs['id'] = $id;
		}
		
		
		$status=isset($this->params['url']['status'])?$this->params['url']['status']:(isset($this->params['named']['status'])?$this->params['named']['status']:"");
		if($status!=''){
			$cond = array_merge($cond,array('Group.status' => $status));
			$this->passedArgs['status'] = $status;
		}
		$type=isset($this->params['url']['gtype'])?$this->params['url']['gtype']:(isset($this->params['named']['gtype'])?$this->params['named']['gtype']:"");
		
		if($type!=''){
			
			$cond = array_merge($cond,array('Group.type'=>$type));
			$this->passedArgs['gtype'] = $type;
			
			#$this->Session->write('cond', serialize($cond1));
			#$condition_array=print_r($cond1, true);
			#$this->log("DNS controller : Setting sesion conditions : $condition_array", LOG_DEBUG);
				
		}

		
		$location_id=isset($this->params['url']['location_id'])?$this->params['url']['location_id']:(isset($this->params['named']['location_id'])?$this->params['named']['location_id']:"");
		
		$station_id=isset($this->params['url']['station_id'])?$this->params['url']['station_id']:(isset($this->params['named']['station_id'])?$this->params['named']['station_id']:"");
		


		if($location_id!='') {
			
			$cond = array_merge($cond,array('Station.location_id'=>$location_id));		
			$this->passedArgs['location_id'] = $location_id;
			
			
			
		}
		
		if($station_id!='') {
			
			$cond = array_merge($cond,array('Stationkey.station_id'=>$station_id));
		    $this->passedArgs['station_id'] = $station_id;	
			
		}
		
		
		#ORIG $this->paginate= array('conditions'=>$cond,'limit' => $this->paginate['limit'],'group'=>array('Group.id'),  'order' => array('Group.Name asc'));
		
		#-------------Used for filters
		
		$groupListDetails = $this->Group->find('all',
				array(
						'fields' => array(
								'Group.*',
								'Feature.short_name',
								'Stationkey.station_id',
								'Stationkey.id',
								'Station.location_id',
								'Location.*'
						),
						'joins' => array(
								array(
										'table' => 'features',
										'type' => 'LEFT',
										'alias' => 'Feature',
										'conditions' => array('Group.id = Feature.primary_value')
								),
								array(
										'table' => 'stationkeys',
										'type' => 'LEFT',
										'alias' => 'Stationkey',
										'conditions' => array('Feature.stationkey_id = Stationkey.id')
								),
								array(
										'table' => 'stations',
										'type' => 'LEFT',
										'alias' => 'Station',
										'conditions' => array('Stationkey.station_id = Station.id')
								),
								array(
										'table' => 'locations',
										'type' => 'LEFT',
										'alias' => 'Location',
										'conditions' => array('Station.location_id = Location.id')
								)
						),
						'conditions' => $cond,
						'order' => array('Group.Name asc'),
				)
		);
	
		
		
		$groupstationkeys = array();
		#Generate Station Filter
		
		
		$location= array();
		foreach ($groupListDetails as $group)
		{
			$stationList[$group['Stationkey']['station_id']] = $group['Stationkey']['station_id'];
			if( $group['Location']['name']!=""){
				
				$location = $group;
				
				if($location['Location']['scm_name']=="" && $location['Location']['address']!="" ) {
				$locations[$location['Location']['id']] =$locationstring = $location['Location']['name'] . ' ( ' . $location['Location']['plz'] . ' ,' .$location['Location']['address'].' )';
			}
			elseif($location['Location']['address']=="" && $location['Location']['scm_name']!="") {
				$locations[$location['Location']['id']] =$locationstring = $location['Location']['name'] . ' ( ' . $location['Location']['plz'] . ' ,' .$location['Location']['scm_name'].' )';
			}
			elseif($location['Location']['address']=="" && $location['Location']['scm_name']=="" && $location['Location']['plz']!="") {
            $locations[$location['Location']['id']] = $location['Location']['name'] . ' ( ' . $location['Location']['plz'] .' )';
			}
			elseif($location['Location']['address']=="" && $location['Location']['scm_name']=="" && $location['Location']['plz']=="") {
            $locations[$value['id']] = $location['Location']['name'];
			}
			
			else {
				$locations[$location['Location']['id']] = $location['Location']['name'] . ' ( ' . $location['Location']['plz'] . ' ,' . $location['Location']['scm_name'] . ','.$location['Location']['address'].' )';
			}
				
			//$locations[$location['Location']['id']] = $location['Location']['name'];	
			
			//$locationList[$group['Station']['location_id']] = $group['Location']['name'];
				
			}
			
			
			$allGroupMemCount[$group['Group']['id']] = $allGroupMemCount[$group['Group']['id']] + 1;
			array_push($groupstationkeys, $group['Stationkey']['id']);
			#Get pilot from keys
			if($group['Feature']['type']='MADN')
			{
				#get pilot DISPLAYNAME.
				#$groupnamedetails = $this->Station->getGroupDisplaynameFromDn($group_id);
				#$results_array=print_r($groupname, true);
				#$this->log("Features controller : GROUP DISPLAY : $results_array", LOG_DEBUG);
				#$groupname = $groupnamedetails[0]['features']['primary_value'];
				$groupnamedetails = $this->Station->getGroupDisplaynameFromDn($group['Group']['id']);
				$madn_displaynames[$group['Stationkey']['id']] = $groupnamedetails[0]['features']['primary_value'];
			}
			
				
		}
		
		$this->log("Group controller : GROUP HERE1 : ", LOG_DEBUG);
		# if group name filter is defined.
		
		$name=isset($this->params['url']['name'])?$this->params['url']['name']:(isset($this->params['named']['name'])?$this->params['named']['name']:"");
		if($name!=''){
			
					
				#Get filtereed station ID's based on DISPLAYNMAE for MADN
				
				$MADNFilteredGroupNames = $this->Feature->find('all',
					array(
							'fields' => array(
									'Feature.stationkey_id',
									'Feature.primary_value',
										
							),
								
							'conditions' => array('Feature.short_name' => 'DISPLAYNAME', 'Feature.primary_value like' => '%' .$name .  '%','Feature.stationkey_id' => $groupstationkeys)
								
					)
			);
				
			$madnfilteredkeys = array();
			foreach ($MADNFilteredGroupNames as $MADNFilteredGroupName)
			{
				
				array_push($madnfilteredkeys, $MADNFilteredGroupName['Feature']['stationkey_id']);
				#$this->log("Group controller : ARRAY BUILD 1 :" . $MADNFilteredGroupName['Feature']['stationkey_id'] . ':' . $MADNGroupNameDetail['Feature']['primary_value'], LOG_DEBUG);
				$this->log("Group controller : ARRAY PUSH 1 :" . $MADNFilteredGroupName['Feature']['stationkey_id'] . ':' . $MADNFilteredGroupName['Feature']['primary_value'], LOG_DEBUG);
			}
			
			#Define condition
			
			
			
			$cond = array_merge($cond,
				array(
					'OR' => array(
						array('Feature.stationkey_id'=>$madnfilteredkeys),
						array('Group.name LIKE'=>'%'.$name.'%')
					)
				)
			);
			$this->passedArgs['name'] = $name;
			
			#Now add condition to get the 
		
					
		}
		
		
		
		
		$this->log("Group controller : GROUP HERE2 : ", LOG_DEBUG);
		
		$this->paginate = array(
						'fields' => array(
								'Group.*',
								'Feature.short_name',
								'Stationkey.station_id',
								'Stationkey.id',
								'Station.location_id',
								'Location.name'
						),
						'joins' => array(
								array(
										'table' => 'features',
										'type' => 'LEFT',
										'alias' => 'Feature',
										'conditions' => array('Group.id = Feature.primary_value')
								),
								array(
										'table' => 'stationkeys',
										'type' => 'LEFT',
										'alias' => 'Stationkey',
										'conditions' => array('Feature.stationkey_id = Stationkey.id')
								),
								array(
										'table' => 'stations',
										'type' => 'LEFT',
										'alias' => 'Station',
										'conditions' => array('Stationkey.station_id = Station.id')
								),
								array(
										'table' => 'locations',
										'type' => 'LEFT',
										'alias' => 'Location',
										'conditions' => array('Station.location_id = Location.id')
								)
						),
						'conditions' => $cond,
						'limit' => $this->paginate['limit'],
						'group' => 'Group.id',
						'order' => array('Group.Name asc')
						
						
				
		);
		
		
		$this->set('title_header', __('Swisscom Extranet Corporate Business - Voiphone Selfcare', true));
		$this->Session->write('Customer.Name', 'UNDEF');
		$this->set('cust_for_layout', 'UNDEFINED');
		$groups = $this->paginate('Group');
		
		
		
		$print_array=print_r($groupstationkeys, true);
		$this->log("Group controller : GROUP MEMER KEYS : " . $print_array, LOG_DEBUG);
		
		#Now find the Displayname for the group members.
		
		
		/*
		 
		 $MADNGroupNameDetails = $this->Feature->find('all',
			array(
						'fields' => array(
								'Feature.stationkey_id',
								'Feature.primary_value',
		
						),

						'conditions' => array('Feature.short_name' => 'DISPLAYNAME', 'Feature.stationkey_id' => $groupstationkeys)
		
						)
		);
		
		
		foreach ($MADNGroupNameDetails as $MADNGroupNameDetail)
		{
			$this->log("Group controller : ARRAY BUILD 2 :" . $MADNGroupNameDetail['Feature']['stationkey_id'] . ':' . $MADNGroupNameDetail['Feature']['primary_value'], LOG_DEBUG);
			$madn_displaynames[$MADNGroupNameDetail['Feature']['stationkey_id']] = $MADNGroupNameDetail['Feature']['primary_value'];
		}
		*/
		$this->set('madn_displaynames', $madn_displaynames);
		ksort($stationList);
		asort($locations);
		
		$this->set('stationList', $stationList);
		$this->set('locationList', $locations);
		$this->set('allGroupMemCount', $allGroupMemCount);
		$this->set('groups', $groups);
		
		
		$print_array=print_r($stationList, true);
		$this->log("Group controller : GROUP MEMERBS : $print_array", LOG_DEBUG);
		
				
		$CPUgroupMemberCount = $this->Feature->find('all',
				array(
						'fields' => array(
								'Feature.primary_value',
						'count(Feature.id)'),
						'group' => 'Feature.primary_value',
						'conditions' => array('Feature.short_name' => array('CPU')))
		);
		
		
		
		foreach($CPUgroupMemberCount as $groupMemKey => $groupMemVal)
		{
			#$this->log("Group controller : SETTING CPU  :".$groupMemVal['Feature']['primary_value'] . ':' . $groupMemVal[0]['count(`Feature`.`id`)'], LOG_DEBUG);
			$groupMemCount[$groupMemVal['Feature']['primary_value']] = $groupMemVal[0]['count(`Feature`.`id`)'];
		}
		
		#echo "<pre>";print_r($CPUgroupMemberCount);
		
		$groupMemberCount = $this->Feature->find('all',
				array(
						'fields' => array(
								'Stationkey.dn',
						'count(Feature.id)'),
						'group' => 'Stationkey.dn',
						'conditions'=>array('Feature.short_name'=> array('MADN', 'HNTID')))
		);
		#$grp_members = $this->Group->getGroupMembersFromDn($feat_val['primary_value']);
		
		
		foreach($groupMemberCount as $groupMemKey => $groupMemVal)
		{
		
			#$this->log("Group controller : SETTING  MADN :".$groupMemVal['Stationkey']['dn'] . ':' . $groupMemVal[0]['count(`Feature`.`id`)'], LOG_DEBUG);
			$groupMemCount[$groupMemVal['Stationkey']['dn']] = $groupMemVal[0]['count(`Feature`.`id`)'];
		}
		#$groupMembers = $this->Feature->find('all',array('conditions'=>array('Feature.short_name'=> array('madn'), 'Stationkey.dn'=>$groupDetails['Group']['identifier'])));
			
		
		#$print_array=print_r($groupMemCount, true);
		#$this->log("Group controller : Counts : $print_array", LOG_DEBUG);
		$this->set('groupMemCount', $groupMemCount);
		
		
		
		if($success_flag == 'success')
		{
			$this->set('success', 'script executed successfully');
		}
		elseif($success_flag == 'deleted')
		{
			$this->set('success', 'schedule deleted successfully');
		}
		elseif($success_flag == 'updated')
		{
			$this->set('success', 'Saved successfully');
		}
		elseif($success_flag == 'error')
		{
			$this->set('error', 'ERROR');
		}
		$states = $this->Group->find('all',array('fields' => array('DISTINCT Group.status')));
		$stateList[''] = '';
		foreach($states as $state):
			$localized_state = __($state['Group']['state'], true);
			$stateList[$state['Group']['status']] = $localized_state;
		endforeach;
		$this->set('stateList', $stateList);
		
		$this->Session->write('cond', serialize($cond));
		$condition_array=print_r($cond, true);
		$this->log("Group controller : Setting sesion conditions : $condition_array", LOG_DEBUG);
		
		if($this->RequestHandler->isAjax()){
			$this->layout ='ajax';
			Configure::write('debug',0);
			$this->render('/elements/scanerio');
		}
	}
	
	
	function pickupgroups(){
		
		

		$this->pageTitle = 'cpuGroupHeading';
		$this->log('GROUPS CONTROLLER : START INDEX ', LOG_DEBUG);
		
		$this->paginate['Paginate']	=	$this->AutoPaginate->setPaginate();
		
		$customer_id=isset($this->params['url']['customer_id'])?$this->params['url']['customer_id']:(isset($this->params['named']['customer_id'])?$this->params['named']['customer_id']:"");
		
		
		$success_flag=isset($this->params['url']['etype'])?$this->params['url']['etype']:(isset($this->params['named']['etype'])?$this->params['named']['etype']:"");
		#die();
		
		if (isset ($_POST['customer_id']) && $_POST['customer_id']) 
		{
			$customer_id=$_POST['customer_id'];
			$this->passedArgs['customer_id'] = $customer_id;
			
		}
		if($customer_id==''){
			
			$sel_location = $_POST['location'];
			$this->Session->write('sel_location', $sel_location);
			
			$this->log('GROUPS CONTROLLER : VALID CUSTOMER ID NOT SET', LOG_DEBUG);
			//$this->redirect('/customers');
			//exit();
		}
		
		
		if ($customer_id!= '')
			{
				#Find Locations
				$customer = $this->Customer->find('first',array('contain'=>array('Location'),'conditions'=>array('id'=>$customer_id)));
				foreach($customer['Location'] as $key=>$value):
				$locations[$value['id']] =  $value['name'];
				endforeach;
				$this->set('locations', $locations);
				$this->passedArgs['customer_id'] = $customer_id;
			}	
		
		
		

		
		/**********for case of external users********/
		if($this->Session->read('SELECTED_CUSTOMER')!=Configure::read('access_id')){

			#If The user is an external..
			
			$id=$this->Session->read('SELECTED_CUSTOMER');
			$cnt	=	 count($this->_Filter);
			
			if(!$this->Customer->validCustomer ($id,$customer_id)){
				#print_r("not valid");die();
				$this->log('GROUPS CONTROLLER : NOT A VALID CUSTOMER FOR GROUPS PAGE', LOG_DEBUG);
				$this->redirect('/customers');
				exit();
			}
			#print_r("valid checking $id $number");die();
		}
		
		/**********************END*************************/
		/**these for getting the current customer name**/
			
		#User for left hand Menu navigation.
		
		$groupStates = $this->Group->find('all', array(
				'fields'=>array('DISTINCT status'),
				'conditions'=>array('customer_id' => $customer_id)
		));
		$statuses[''] = '';
		$groupStatus = Configure :: read('groupStatus');
		foreach($groupStates as $groupState):
		#$localized_function = __($stationState['Station']['status'], true);
		$statuses[$groupState['Group']['status']] = $groupStatus[$groupState['Group']['status']];
		endforeach;
			
		$this->set('statuses',$statuses);
		
		$functions = $this->Group->find('all', array(
				'fields'=>array('DISTINCT type'),
				'conditions'=>array('Group.type' => array('CPU'))
		));
		$func_list[''] = '';
		foreach($functions as $func):
		$localized_function = __($func['Group']['type'], true);
		$func_list[$func['Group']['type']] = "$localized_function";
		endforeach;

		$this->set('func_list',$func_list);
				
				$this->set('SELECTED_CNN',$customer_id);
				$this->set('SELECTED_CUSTOMER_NAME',$customer_id);
                 /*CBM Added for right hand section*/
                $customerInfo = $this->Customer->findById($customer_id);
                if (isset ($customerInfo['Customer']['name'])) {
                        $this->set('selected_customer', $customerInfo['Customer']['name']);
                } else {
                        $this->set('selected_customer', 'UNDEF');

                }


		/**end for getting the current customer name**/
		
		$cond = array('Group.customer_id'=>$customer_id, 'Feature.short_name'=>array( 'CPU'));

		$id=isset($this->params['url']['id'])?$this->params['url']['id']:(isset($this->params['named']['id'])?$this->params['named']['id']:"");
		if($id!=''){
			$cond = array_merge($cond,array('Group.identifier LIKE'=>'%'.$id.'%'));
			$this->passedArgs['id'] = $id;
		}
		
		$desc=isset($this->params['url']['desc'])?$this->params['url']['desc']:(isset($this->params['named']['desc'])?$this->params['named']['desc']:"");
		if($desc!=''){
			$cond = array_merge($cond,array('Group.desc LIKE'=>'%'.$desc.'%'));
			$this->passedArgs['desc'] = $desc;
		}
		
		
		$status=isset($this->params['url']['status'])?$this->params['url']['status']:(isset($this->params['named']['status'])?$this->params['named']['status']:"");
		if($status!=''){
			$cond = array_merge($cond,array('Group.status' => $status));
			$this->passedArgs['status'] = $status;
		}
		$type=isset($this->params['url']['gtype'])?$this->params['url']['gtype']:(isset($this->params['named']['gtype'])?$this->params['named']['gtype']:"");
		
		if($type!=''){
			
			$cond = array_merge($cond,array('Group.type'=>$type));
			$this->passedArgs['gtype'] = $type;
			
			#$this->Session->write('cond', serialize($cond1));
			#$condition_array=print_r($cond1, true);
			#$this->log("DNS controller : Setting sesion conditions : $condition_array", LOG_DEBUG);
				
		}

		
		$location_id=isset($this->params['url']['location_id'])?$this->params['url']['location_id']:(isset($this->params['named']['location_id'])?$this->params['named']['location_id']:"");
		
		$station_id=isset($this->params['url']['station_id'])?$this->params['url']['station_id']:(isset($this->params['named']['station_id'])?$this->params['named']['station_id']:"");
		
		
		

		if($location_id!='') {
			
			$cond = array_merge($cond,array('Station.location_id'=>$location_id));		
			$this->passedArgs['location_id'] = $location_id;
			
			
			
		}
		
		if($station_id!='') {
			
			$cond = array_merge($cond,array('Stationkey.station_id'=>$station_id));
		    $this->passedArgs['station_id'] = $station_id;	
			
		}
		
		$name=isset($this->params['url']['name'])?$this->params['url']['name']:(isset($this->params['named']['name'])?$this->params['named']['name']:"");
		if($name!=''){
				
				
			$cond = array_merge($cond,
					array(
							'OR' => array(
									array('Group.name LIKE'=>'%'.$name.'%')
							)
					)
			);
			$this->passedArgs['name'] = $name;
				
			#Now add condition to get the
		
				
		}
		
		#ORIG $this->paginate= array('conditions'=>$cond,'limit' => $this->paginate['limit'],'group'=>array('Group.id'),  'order' => array('Group.Name asc'));
		
		#-------------Used for filters
		
		$groupListDetails = $this->Group->find('all',
				array(
						'fields' => array(
								'Group.*',
								'Feature.short_name',
								'Stationkey.station_id',
								'Stationkey.id',
								'Station.location_id',
								'Location.*'
						),
						'joins' => array(
								array(
										'table' => 'features',
										'type' => 'LEFT',
										'alias' => 'Feature',
										'conditions' => array('Group.id = Feature.primary_value')
								),
								array(
										'table' => 'stationkeys',
										'type' => 'LEFT',
										'alias' => 'Stationkey',
										'conditions' => array('Feature.stationkey_id = Stationkey.id')
								),
								array(
										'table' => 'stations',
										'type' => 'LEFT',
										'alias' => 'Station',
										'conditions' => array('Stationkey.station_id = Station.id')
								),
								array(
										'table' => 'locations',
										'type' => 'LEFT',
										'alias' => 'Location',
										'conditions' => array('Station.location_id = Location.id')
								)
						),
						'conditions' => $cond,
						'order' => array('Group.Name asc'),
				)
		);
	
		
		
		$groupstationkeys = array();
		#Generate Station Filter
	
		
		$location= array();
		foreach ($groupListDetails as $group)
		{
			$stationList[$group['Stationkey']['station_id']] = $group['Stationkey']['station_id'];
			if( ($group['Location']['name']!="") && ($group['Group']['type'] == "CPU")){
				
				$location = $group;
				
				if($location['Location']['scm_name']=="" && $location['Location']['address']!="" ) {
				$locations[$location['Location']['id']] =$locationstring = $location['Location']['name'] . ' ( ' . $location['Location']['plz'] . ' ,' .$location['Location']['address'].' )';
			}
			elseif($location['Location']['address']=="" && $location['Location']['scm_name']!="") {
				$locations[$location['Location']['id']] =$locationstring = $location['Location']['name'] . ' ( ' . $location['Location']['plz'] . ' ,' .$location['Location']['scm_name'].' )';
			}
			elseif($location['Location']['address']=="" && $location['Location']['scm_name']=="" && $location['Location']['plz']!="") {
            $locations[$location['Location']['id']] = $location['Location']['name'] . ' ( ' . $location['Location']['plz'] .' )';
			}
			elseif($location['Location']['address']=="" && $location['Location']['scm_name']=="" && $location['Location']['plz']=="") {
            $locations[$value['id']] = $location['Location']['name'];
			}
			
			else {
				$locations[$location['Location']['id']] = $location['Location']['name'] . ' ( ' . $location['Location']['plz'] . ' ,' . $location['Location']['scm_name'] . ','.$location['Location']['address'].' )';
			}
				
			//$locations[$location['Location']['id']] = $location['Location']['name'];	
			
			//$locationList[$group['Station']['location_id']] = $group['Location']['name'];
				
			}
			
			
			$allGroupMemCount[$group['Group']['id']] = $allGroupMemCount[$group['Group']['id']] + 1;
			array_push($groupstationkeys, $group['Stationkey']['id']);
			
			
				
		}
		
			
		$this->paginate = array(
						'fields' => array(
								'Group.*',
								'Feature.short_name',
								'Stationkey.station_id',
								'Stationkey.id',
								'Station.location_id',
								'Location.name'
						),
						'joins' => array(
								array(
										'table' => 'features',
										'type' => 'LEFT',
										'alias' => 'Feature',
										'conditions' => array('Group.id = Feature.primary_value')
								),
								array(
										'table' => 'stationkeys',
										'type' => 'LEFT',
										'alias' => 'Stationkey',
										'conditions' => array('Feature.stationkey_id = Stationkey.id')
								),
								array(
										'table' => 'stations',
										'type' => 'LEFT',
										'alias' => 'Station',
										'conditions' => array('Stationkey.station_id = Station.id')
								),
								array(
										'table' => 'locations',
										'type' => 'LEFT',
										'alias' => 'Location',
										'conditions' => array('Station.location_id = Location.id')
								)
						),
						'conditions' => $cond,
						'limit' => $this->paginate['limit'],
						'group' => 'Group.id',
						'order' => array('Group.Name asc')
						
						
				
		);
		
		
		$this->set('title_header', __('Swisscom Extranet Corporate Business - Voiphone Selfcare', true));
		$this->Session->write('Customer.Name', 'UNDEF');
		$this->set('cust_for_layout', 'UNDEFINED');
		$groups = $this->paginate('Group');
		
		
		
		$print_array=print_r($groupstationkeys, true);
		$this->log("Group controller : GROUP MEMER KEYS : " . $print_array, LOG_DEBUG);
		
		
		$this->set('madn_displaynames', $madn_displaynames);
		ksort($stationList);
		asort($locations);
		
		$this->set('stationList', $stationList);
		$this->set('locationList', $locations);
		$this->set('allGroupMemCount', $allGroupMemCount);
		$this->set('groups', $groups);
		
		
		$print_array=print_r($stationList, true);
		$this->log("Group controller : GROUP MEMERBS : $print_array", LOG_DEBUG);
		
				
		$CPUgroupMemberCount = $this->Feature->find('all',
				array(
						'fields' => array(
								'Feature.primary_value',
						'count(Feature.id)'),
						'group' => 'Feature.primary_value',
						'conditions' => array('Feature.short_name' => array('CPU')))
		);
		
		
		
		foreach($CPUgroupMemberCount as $groupMemKey => $groupMemVal)
		{
			#$this->log("Group controller : SETTING CPU  :".$groupMemVal['Feature']['primary_value'] . ':' . $groupMemVal[0]['count(`Feature`.`id`)'], LOG_DEBUG);
			$groupMemCount[$groupMemVal['Feature']['primary_value']] = $groupMemVal[0]['count(`Feature`.`id`)'];
		}
		
		#echo "<pre>";print_r($CPUgroupMemberCount);
		
		$groupMemberCount = $this->Feature->find('all',
				array(
						'fields' => array(
								'Stationkey.dn',
						'count(Feature.id)'),
						'group' => 'Stationkey.dn',
						'conditions'=>array('Feature.short_name'=> array('MADN', 'HNTID')))
		);
		#$grp_members = $this->Group->getGroupMembersFromDn($feat_val['primary_value']);
		
		
		foreach($groupMemberCount as $groupMemKey => $groupMemVal)
		{
		
			#$this->log("Group controller : SETTING  MADN :".$groupMemVal['Stationkey']['dn'] . ':' . $groupMemVal[0]['count(`Feature`.`id`)'], LOG_DEBUG);
			$groupMemCount[$groupMemVal['Stationkey']['dn']] = $groupMemVal[0]['count(`Feature`.`id`)'];
		}
		#$groupMembers = $this->Feature->find('all',array('conditions'=>array('Feature.short_name'=> array('madn'), 'Stationkey.dn'=>$groupDetails['Group']['identifier'])));
			
		
		#$print_array=print_r($groupMemCount, true);
		#$this->log("Group controller : Counts : $print_array", LOG_DEBUG);
		$this->set('groupMemCount', $groupMemCount);
		
		
		
		if($success_flag == 'success')
		{
			$this->set('success', 'script executed successfully');
		}
		elseif($success_flag == 'deleted')
		{
			$this->set('success', 'schedule deleted successfully');
		}
		elseif($success_flag == 'updated')
		{
			$this->set('success', 'Saved successfully');
		}
		elseif($success_flag == 'error')
		{
			$this->set('error', 'ERROR');
		}
		$states = $this->Group->find('all',array('fields' => array('DISTINCT Group.status')));
		$stateList[''] = '';
		foreach($states as $state):
			$localized_state = __($state['Group']['state'], true);
			$stateList[$state['Group']['status']] = $localized_state;
		endforeach;
		$this->set('stateList', $stateList);
		
		$this->Session->write('cond', serialize($cond));
		$condition_array=print_r($cond, true);
		$this->log("Group controller : Setting sesion conditions : $condition_array", LOG_DEBUG);
		
		if($this->RequestHandler->isAjax()){
			$this->layout ='ajax';
			Configure::write('debug',0);
			$this->render('/elements/scanerio');
		}
	}
	
	function numbergroups (){
	
		$this->pageTitle = 'Group List';
		$this->log('GROUPS CONTROLLER : START INDEX ', LOG_DEBUG);
	
		$this->paginate['Paginate']	=	$this->AutoPaginate->setPaginate();
	
		$customer_id=isset($this->params['url']['customer_id'])?$this->params['url']['customer_id']:(isset($this->params['named']['customer_id'])?$this->params['named']['customer_id']:"");
	
	
		$success_flag=isset($this->params['url']['etype'])?$this->params['url']['etype']:(isset($this->params['named']['etype'])?$this->params['named']['etype']:"");
		#die();
	
		if (isset ($_POST['customer_id']) && $_POST['customer_id'])
		{
			$customer_id=$_POST['customer_id'];
			$this->passedArgs['customer_id'] = $customer_id;
				
		}
		if($customer_id==''){
				
			$sel_location = $_POST['location'];
			$this->Session->write('sel_location', $sel_location);
				
			$this->log('GROUPS CONTROLLER : VALID CUSTOMER ID NOT SET', LOG_DEBUG);
			//$this->redirect('/customers');
			//exit();
		}
	
	
		if ($customer_id!= '')
		{
			#Find Locations
			$customer = $this->Customer->find('first',array('contain'=>array('Location'),'conditions'=>array('id'=>$customer_id)));
			foreach($customer['Location'] as $key=>$value):
				$locations[$value['id']] =  $value['name'];
			endforeach;
			$this->set('locations', $locations);
			$this->passedArgs['customer_id'] = $customer_id;
		}
	
	
	
	
	
		/**********for case of external users********/
		if($this->Session->read('SELECTED_CUSTOMER')!=Configure::read('access_id')){
	
			#If The user is an external..
				
			$id=$this->Session->read('SELECTED_CUSTOMER');
			$cnt	=	 count($this->_Filter);
			
			if(!$this->Customer->validCustomer ($id,$customer_id)){
				#print_r("not valid");die();
				$this->log('GROUPS CONTROLLER : NOT A VALID CUSTOMER FOR GROUPS PAGE', LOG_DEBUG);
						$this->redirect('/customers');
							exit();
			}
			#print_r("valid checking $id $number");die();
		}
	
	/**********************END*************************/
	/**these for getting the current customer name**/
	 	
	#User for left hand Menu navigation.
	
	$groupStates = $this->Group->find('all', array(
			'fields'=>array('DISTINCT status'),
			'conditions'=>array('customer_id' => $customer_id, 'Group.type' => array('MADN', 'XLH'))
		));
	$statuses[''] = '';
	$groupStatus = Configure :: read('groupStatus');
	foreach($groupStates as $groupState):
					#$localized_function = __($stationState['Station']['status'], true);
					$statuses[$groupState['Group']['status']] = $groupStatus[$groupState['Group']['status']];
	endforeach;
								
	$this->set('statuses',$statuses);
	
	$functions = $this->Group->find('all', array(
		'fields'=>array('DISTINCT type'),
		'conditions'=>array('customer_id' => $customer_id, 'Group.type' => array('MADN', 'XLH'))
		));
	$func_list[''] = '';
	foreach($functions as $func):
		$localized_function = __($func['Group']['type'], true);
		$func_list[$func['Group']['type']] = "$localized_function";
	endforeach;
	
	$this->set('func_list',$func_list);
	
	$this->set('SELECTED_CNN',$customer_id);
	$this->set('SELECTED_CUSTOMER_NAME',$customer_id);
					/*CBM Added for right hand section*/
	$customerInfo = $this->Customer->findById($customer_id);
	if (isset ($customerInfo['Customer']['name'])) {
		$this->set('selected_customer', $customerInfo['Customer']['name']);
	} 
	else {
		$this->set('selected_customer', 'UNDEF');
	
	}
	
	
		/**end for getting the current customer name**/
	
	$cond = array('Group.customer_id'=>$customer_id, 'Group.type' => array('MADN', 'XLH'), 'Feature.short_name'=>array('MADN', 'HNTID'));
	
	$id=isset($this->params['url']['id'])?$this->params['url']['id']:(isset($this->params['named']['id'])?$this->params['named']['id']:"");
	if($id!=''){
		$cond = array_merge($cond,array('Group.identifier LIKE'=>'%'.$id.'%'));
		$this->passedArgs['id'] = $id;
	}
	
	
	$status=isset($this->params['url']['status'])?$this->params['url']['status']:(isset($this->params['named']['status'])?$this->params['named']['status']:"");
	if($status!=''){
		$cond = array_merge($cond,array('Group.status' => $status));
		$this->passedArgs['status'] = $status;
	}
	$type=isset($this->params['url']['gtype'])?$this->params['url']['gtype']:(isset($this->params['named']['gtype'])?$this->params['named']['gtype']:"");
	
	if($type!=''){
		
		$cond = array_merge($cond,array('Group.type'=>$type));
		$this->passedArgs['gtype'] = $type;
				
	}
	
	
	$location_id=isset($this->params['url']['location_id'])?$this->params['url']['location_id']:(isset($this->params['named']['location_id'])?$this->params['named']['location_id']:"");
	
	$station_id=isset($this->params['url']['station_id'])?$this->params['url']['station_id']:(isset($this->params['named']['station_id'])?$this->params['named']['station_id']:"");
	
	
	
	if($location_id!='') {
		
			$cond = array_merge($cond,array('Station.location_id'=>$location_id));
			$this->passedArgs['location_id'] = $location_id;
				
		
						
	}
	
	if($station_id!='') {
		
		$cond = array_merge($cond,array('Stationkey.station_id'=>$station_id));
		$this->passedArgs['station_id'] = $station_id;
						
	}
	
	
			#ORIG $this->paginate= array('conditions'=>$cond,'limit' => $this->paginate['limit'],'group'=>array('Group.id'),  'order' => array('Group.Name asc'));
	
			#-------------Used for filters
	
			$groupListDetails = $this->Group->find('all',
			array(
			'fields' => array(
			'Group.*',
			'Feature.short_name',
			'Stationkey.station_id',
			'Stationkey.id',
			'Station.location_id',
			'Location.*'
			),
			'joins' => array(
				array(
					'table' => 'features',
					'type' => 'LEFT',
					'alias' => 'Feature',
					'conditions' => array('Group.id = Feature.primary_value')
				),
				array(
					'table' => 'stationkeys',
					'type' => 'LEFT',
					'alias' => 'Stationkey',
					'conditions' => array('Feature.stationkey_id = Stationkey.id')
				),
				array(
					'table' => 'stations',
					'type' => 'LEFT',
					'alias' => 'Station',
					'conditions' => array('Stationkey.station_id = Station.id')
				),
				array(
					'table' => 'locations',
					'type' => 'LEFT',
					'alias' => 'Location',
					'conditions' => array('Station.location_id = Location.id')
					)
				),
				'conditions' => $cond,
				'order' => array('Group.Name asc'),
				)
		);
	
		#Get all Hunt GRoup name details
		$xlhListDetails = $this->Station->getXlhGroupDisplaynameFromCust($customer_id);
		foreach ($xlhListDetails as $xlhListDetail)
		{
			$xlhgroupnamedetails[$xlhListDetail['s2']['primary_value']] = $xlhListDetail['s3']['primary_value'];
		}
		#create a map of staitonkey -> displayname of 
		#$results_array=print_r($xlhgroupnamedetails, true);
		#$this->log("Features controller : GROUP DISPLAY XLH: $results_array", LOG_DEBUG);
		
		$results_array=print_r($groupListDetails, true);
		$this->log("Group controller : FILTERED LIST: $results_array", LOG_DEBUG);
		
		$groupstationkeys = array();
			#Generate Station Filter
		foreach ($groupListDetails as $group)
		{
				$stationList[$group['Stationkey']['station_id']] = $group['Stationkey']['station_id'];
				if( $group['Location']['name']!=""){
					
					$location = $group;
				
					if($location['Location']['scm_name']=="" && $location['Location']['address']!="" ) {
						$locations[$location['Location']['id']] =$locationstring = $location['Location']['name'] . ' ( ' . $location['Location']['plz'] . ' ,' .$location['Location']['address'].' )';
					}
					elseif($location['Location']['address']=="" && $location['Location']['scm_name']!="") {
						$locations[$location['Location']['id']] =$locationstring = $location['Location']['name'] . ' ( ' . $location['Location']['plz'] . ' ,' .$location['Location']['scm_name'].' )';
					}
					elseif($location['Location']['address']=="" && $location['Location']['scm_name']=="" && $location['Location']['plz']!="") {
	            		$locations[$location['Location']['id']] = $location['Location']['name'] . ' ( ' . $location['Location']['plz'] .' )';
					}
					elseif($location['Location']['address']=="" && $location['Location']['scm_name']=="" && $location['Location']['plz']=="") {
	            		$locations[$value['id']] = $location['Location']['name'];
					}
					else {
						$locations[$location['Location']['id']] = $location['Location']['name'] . ' ( ' . $location['Location']['plz'] . ' ,' . $location['Location']['scm_name'] . ','.$location['Location']['address'].' )';
					}
					
					
					
					//$locationList[$group['Station']['location_id']] = $group['Location']['name'];
				}
			
			
				$allGroupMemCount[$group['Group']['id']] = $allGroupMemCount[$group['Group']['id']] + 1;
				array_push($groupstationkeys, $group['Stationkey']['id']);
				#Get pilot from keys
				if($group['Feature']['type']='MADN')
				{
					#get pilot DISPLAYNAME.
					#$groupnamedetails = $this->Station->getGroupDisplaynameFromDn($group_id);
					#$results_array=print_r($groupname, true);
					#$this->log("Features controller : GROUP DISPLAY : $results_array", LOG_DEBUG);
					#$groupname = $groupnamedetails[0]['features']['primary_value'];
					$groupnamedetails = $this->Station->getGroupDisplaynameFromDn($group['Group']['id']);
					$madn_displaynames[$group['Stationkey']['id']] = $groupnamedetails[0]['features']['primary_value'];
				}
				if($group['Feature']['type']='HNTID')
				{
				#get pilot DISPLAYNAME.
					#$groupnamedetails = $this->Station->getGroupDisplaynameFromDn($group_id);
					#$results_array=print_r($groupname, true);
					#$this->log("Features controller : GROUP DISPLAY : $results_array", LOG_DEBUG);
					#$groupname = $groupnamedetails[0]['features']['primary_value'];
					$groupnamedetails = $this->Station->getGroupDisplaynameFromDn($group['Group']['id']);
					$xlh_displaynames[$group['Stationkey']['id']] = $xlhgroupnamedetails[$group['Group']['id']];
				}
				
				
	
		}
	
			
			# if group name filter is defined.
	
			$name=isset($this->params['url']['name'])?$this->params['url']['name']:(isset($this->params['named']['name'])?$this->params['named']['name']:"");
			if($name!=''){
		
			
					#Get filtereed station ID's based on DISPLAYNMAE for MADN
	
			$MADNFilteredGroupNames = $this->Feature->find('all',
					array(
					'fields' => array(
					'Feature.stationkey_id',
					'Feature.primary_value',
	
					),
	
					'conditions' => array('Feature.short_name' => 'DISPLAYNAME', 'Feature.primary_value like' => '%' .$name .  '%','Feature.stationkey_id' => $groupstationkeys)
	
				)
			);
	
			$madnfilteredkeys = array();
			foreach ($MADNFilteredGroupNames as $MADNFilteredGroupName)
				{
	
				array_push($madnfilteredkeys, $MADNFilteredGroupName['Feature']['stationkey_id']);
				#$this->log("Group controller : ARRAY BUILD 1 :" . $MADNFilteredGroupName['Feature']['stationkey_id'] . ':' . $MADNGroupNameDetail['Feature']['primary_value'], LOG_DEBUG);
				$this->log("Group controller : ARRAY PUSH 1 :" . $MADNFilteredGroupName['Feature']['stationkey_id'] . ':' . $MADNFilteredGroupName['Feature']['primary_value'], LOG_DEBUG);
					}
					
				#Define condition
					
				#For CPU Groups onlyu search the name
					
				$cond = array_merge($cond,
				
				array('Feature.stationkey_id'=>$madnfilteredkeys)	

			);
			$this->passedArgs['name'] = $name;
				
			#Now add condition to get the
	
			
		}
		
		
		#######
		
		#Now Just create Advanced filterered lists
		
		
		$groupListDetails = $this->Group->find('all',
				array(
						'fields' => array(
								'Group.*',
								'Feature.short_name',
								'Stationkey.station_id',
								'Stationkey.id',
								'Station.location_id',
								'Location.*'
						),
						'joins' => array(
								array(
										'table' => 'features',
										'type' => 'LEFT',
										'alias' => 'Feature',
										'conditions' => array('Group.id = Feature.primary_value')
								),
								array(
										'table' => 'stationkeys',
										'type' => 'LEFT',
										'alias' => 'Stationkey',
										'conditions' => array('Feature.stationkey_id = Stationkey.id')
								),
								array(
										'table' => 'stations',
										'type' => 'LEFT',
										'alias' => 'Station',
										'conditions' => array('Stationkey.station_id = Station.id')
								),
								array(
										'table' => 'locations',
										'type' => 'LEFT',
										'alias' => 'Location',
										'conditions' => array('Station.location_id = Location.id')
								)
						),
						'conditions' => $cond,
						'order' => array('Group.Name asc'),
				)
		);
		
		$stationList = array();
		$locations = array();
		foreach ($groupListDetails as $group)
		{
			$stationList[$group['Stationkey']['station_id']] = $group['Stationkey']['station_id'];
			if( $group['Location']['name']!=""){
			
				$location = $group;
		
				if($location['Location']['scm_name']=="" && $location['Location']['address']!="" ) {
					$locations[$location['Location']['id']] =$locationstring = $location['Location']['name'] . ' ( ' . $location['Location']['plz'] . ' ,' .$location['Location']['address'].' )';
				}
				elseif($location['Location']['address']=="" && $location['Location']['scm_name']!="") {
					$locations[$location['Location']['id']] =$locationstring = $location['Location']['name'] . ' ( ' . $location['Location']['plz'] . ' ,' .$location['Location']['scm_name'].' )';
				}
				elseif($location['Location']['address']=="" && $location['Location']['scm_name']=="" && $location['Location']['plz']!="") {
					$locations[$location['Location']['id']] = $location['Location']['name'] . ' ( ' . $location['Location']['plz'] .' )';
				}
				elseif($location['Location']['address']=="" && $location['Location']['scm_name']=="" && $location['Location']['plz']=="") {
					$locations[$value['id']] = $location['Location']['name'];
				}
				else {
						$locations[$location['Location']['id']] = $location['Location']['name'] . ' ( ' . $location['Location']['plz'] . ' ,' . $location['Location']['scm_name'] . ','.$location['Location']['address'].' )';
				}
			
			
			
		//$locationList[$group['Station']['location_id']] = $group['Location']['name'];
			}
		
					
		}
		
		
		#######
	
	
	
	
		
	
		$this->paginate = array(
		'fields' => array(
			'Group.*',
			'Feature.short_name',
			'Stationkey.station_id',
			'Stationkey.id',
			'Station.location_id',
			'Location.name'
			),
			'joins' => array(
				array(
					'table' => 'features',
					'type' => 'LEFT',
					'alias' => 'Feature',
					'conditions' => array('Group.id = Feature.primary_value')
				),
				array(
					'table' => 'stationkeys',
					'type' => 'LEFT',
					'alias' => 'Stationkey',
					'conditions' => array('Feature.stationkey_id = Stationkey.id')
				),
				array(
					'table' => 'stations',
					'type' => 'LEFT',
					'alias' => 'Station',
					'conditions' => array('Stationkey.station_id = Station.id')
				),
				array(
					'table' => 'locations',
					'type' => 'LEFT',
					'alias' => 'Location',
					'conditions' => array('Station.location_id = Location.id')
				)
				),
				'conditions' => $cond,
				'limit' => $this->paginate['limit'],
				'group' => 'Group.id',
				'order' => array('Group.Name asc')
		
		);
	
	
		$this->set('title_header', __('Swisscom Extranet Corporate Business - Voiphone Selfcare', true));
		$this->Session->write('Customer.Name', 'UNDEF');
		$this->set('cust_for_layout', 'UNDEFINED');
		$groups = $this->paginate('Group');
	
	
	
		$print_array=print_r($groupstationkeys, true);
		$this->log("Group controller : GROUP MEMER KEYS : " . $print_array, LOG_DEBUG);
		#Now find the Displayname for the group members.
	
	
		
		$this->set('madn_displaynames', $madn_displaynames);
		$this->set('xlh_displaynames', $xlh_displaynames);
		ksort($stationList);
		asort($locations);
		$this->set('stationList', $stationList);
		$this->set('locationList', $locations);
		$this->set('allGroupMemCount', $allGroupMemCount);
		$this->set('groups', $groups);
		$print_array=print_r($stationList, true);
		$this->log("Group controller : GROUP MEMERBS : $print_array", LOG_DEBUG);
		
		#echo "<pre>";print_r($CPUgroupMemberCount);
		$groupMemberCount = $this->Feature->find('all',
		array(
			'fields' => array(
			'Stationkey.dn',
			'count(Feature.id)'),
			'group' => 'Stationkey.dn',
			'conditions'=>array('Feature.short_name'=> array('MADN', 'HNTID')))
		);
		#$grp_members = $this->Group->getGroupMembersFromDn($feat_val['primary_value']);
	
	
		foreach($groupMemberCount as $groupMemKey => $groupMemVal)
		{
	
			#$this->log("Group controller : SETTING  MADN :".$groupMemVal['Stationkey']['dn'] . ':' . $groupMemVal[0]['count(`Feature`.`id`)'], LOG_DEBUG);
			$groupMemCount[$groupMemVal['Stationkey']['dn']] = $groupMemVal[0]['count(`Feature`.`id`)'];
		}
		#$groupMembers = $this->Feature->find('all',array('conditions'=>array('Feature.short_name'=> array('madn'), 'Stationkey.dn'=>$groupDetails['Group']['identifier'])));
					
	
		#$print_array=print_r($groupMemCount, true);
		#$this->log("Group controller : Counts : $print_array", LOG_DEBUG);
		$this->set('groupMemCount', $groupMemCount);
	
	
	
		if($success_flag == 'success')
		{
			$this->set('success', 'script executed successfully');
		}
		elseif($success_flag == 'deleted')
		{
			$this->set('success', 'schedule deleted successfully');
		}
		elseif($success_flag == 'updated')
			{
			$this->set('success', 'Saved successfully');
		}
		elseif($success_flag == 'error')
		{
			$this->set('error', 'ERROR');
		}
		$states = $this->Group->find('all',array('fields' => array('DISTINCT Group.status')));
		$stateList[''] = '';
		foreach($states as $state):
				$localized_state = __($state['Group']['state'], true);
				$stateList[$state['Group']['status']] = $localized_state;
		endforeach;
		$this->set('stateList', $stateList);
	
		$this->Session->write('cond', serialize($cond));
		$condition_array=print_r($cond, true);
		$this->log("Group controller : Setting sesion conditions : $condition_array", LOG_DEBUG);
	
		if($this->RequestHandler->isAjax()){
				$this->layout ='ajax';
				Configure::write('debug',0);
				$this->render('/elements/scanerio');
		}
	}
	
	/**
	 * view()
	 * displays a single Customer and all related stations
	 * url: /formats/view/Customer_slug
	 */
	function view($slug = null) {

	}


	/**
	 * edit()
	 * displays a single Customer and all related stations
	 * url: /formats/view/Customer_slug
	 */
	function edit($group_id = null) {
		
		if (isset ($_SESSION['success']))
		{
			$this->set('success', $_SESSION['success']);
			$_SESSION['success'] = '';
		}

		if (isset ($_SESSION['error']))
		{
			$this->set('error', $_SESSION['error']);
			$_SESSION['error'] = '';
		}
		
				
		$group_id=isset($this->params['url']['group_id'])?$this->params['url']['group_id']:(isset($this->params['named']['group_id'])?$this->params['named']['group_id']:"");
		
		
		
		$this->log('GROUPS CONTROLLER : EDIT  => GROUP_ID ' . $group_id, LOG_DEBUG);
		
		#First Check for any updates to save
		
		if(isset($this->data))
		{
			$this->log('GROUPS CONTROLLER : EDIT  => GROUP_ID WITH POSTED DATA' . $group_id, LOG_DEBUG);
			$groupsave['Group']['id'] = $group_id;
			$groupsave['Group']['name'] = $this->data['Group']['groupName'];
			$groupsave['Group']['identifier'] = $this->data['Group']['identifier'];
			$groupsave['Group']['desc'] = $this->data['Group']['groupDesc'];
			$groupsave['Group']['status'] = 4;
			$featUpdate = $this->Group->save($groupsave, false,  array('id','identifier', 'name', 'desc', 'status'));
			
		}
		
		#$grp_pilot = $this->Station->getPilotFromDn($group_id);
		
		$groupDetails = $this->Group->find('first',array('conditions'=>array('Group.id'=>$group_id)));
		#$groupDetail_array=print_r($groupDetails, true);
		#$this->log("Group controller : List Group Details : $groupDetail_array", LOG_DEBUG);
		
		
		
		/**********for case of internal/external users********/
		if ($this->Session->read('SELECTED_CUSTOMER') != Configure :: read('access_id')) {
			 
			$id = $this->Session->read('SELECTED_CUSTOMER');
			 
			if (!$this->Customer->validCustomer($id,$groupDetails['Group']['customer_id'])) {
				$this->log("Customer controller : Edit Function: Invalid customer:" . $id . ':' . $groupDetails['Group']['customer_id'] , LOG_DEBUG);
				$this->redirect('/customers');
				exit ();
			}
			 
		}
		/**********************END*************************/
		
		
		$this->set('SELECTED_CUSTOMER', $groupDetails['Group']['customer_id']);
		#User for left hand Menu navigation.
				
		$this->set('SELECTED_CNN',$groupDetails['Group']['customer_id']);
		$this->set('SELECTED_CUSTOMER_NAME',$groupDetails['Group']['customer_id']);
		
		

		$this->set('group_id', $group_id);
		
		$groupnamedetails = $this->Station->getGroupDisplaynameFromDn($group_id);
		#$results_array=print_r($groupname, true);
		#$this->log("Features controller : GROUP DISPLAY : $results_array", LOG_DEBUG);
		$groupname = $groupnamedetails[0]['features']['primary_value'];
		$this->set('groupname',$groupname);
	
		$this->set('group_state', $groupDetails['Group']['status']);
		$this->set('groupDetails', $groupDetails);
		

		$stationDetails = $this->Station->find('all',array('conditions'=>array('Station.customer_id'=>$groupDetails['Group']['customer_id'])));
		foreach($stationDetails  as $key => $stationDetail)
		{
			$stationStates[$stationDetail['Station']['id']] = $stationDetail['Station']['status'];
			$stationLocation[$stationDetail['Station']['id']] = $stationDetail['Station']['location_id'];
			#Increment counter
			#$locationCount[$stationDetail['Station']['location_id']]= $locationCount[$stationDetail['Station']['location_id']];
		}		
		
		#$mostcommonLocations = array_keys($locationCount, max($locationCount));
		#$stationLocationid = $mostcommonLocations[0];
		$this->set('stationStates', $stationStates);
		#$this->set('stationLocation', $stationLocation);
		
		
		
		if((empty($groupDetails)) || ($groupDetails['Group']['id'] == ''))
		{
			$this->log('GROUPS CONTROLLER : EDIT  => EMPTY GROUP!! ', LOG_DEBUG);
			//exit;
			$this->redirect('/customers');
		}
		
		$groupModelDetails = $this->Group->find('all',
				array(
						'fields' => array(
								'Group.*',
								'Feature.short_name',
								'Stationkey.station_id',
								'Station.location_id',
								 'Station.id',
								'Location.name'
						),
						'joins' => array(
								array(
										'table' => 'features',
										'type' => 'LEFT',
										'alias' => 'Feature',
										'conditions' => array('Group.id = Feature.primary_value')
								),
								array(
										'table' => 'stationkeys',
										'type' => 'LEFT',
										'alias' => 'Stationkey',
										'conditions' => array('Feature.stationkey_id = Stationkey.id')
								),
								array(
										'table' => 'stations',
										'type' => 'LEFT',
										'alias' => 'Station',
										'conditions' => array('Stationkey.station_id = Station.id')
								),
								array(
										'table' => 'locations',
										'type' => 'LEFT',
										'alias' => 'Location',
										'conditions' => array('Station.location_id = Location.id')
								)
						),
						'conditions' => array('Feature.primary_value'=>$groupDetails['Group']['id']),
						'order' => array('Group.Name asc'),
				)
		);
			
		$stationMemberList = array('dummy', 'strings');
		foreach ($groupModelDetails as $groupModel)
		{
		
			$locationMap[$groupModel['Station']['location_id']] = $groupModel['Location']['name'];
			$locationCount[$groupModel['Station']['location_id']]= $locationCount[$groupModel['Station']['location_id']];
			array_push($stationMemberList, $groupModel['Station']['id']);
		
		}
			
		# now find all displaynames for the stations ion the rgroup.
		
		$StationMemberDisplayNames = $this->Stationkey->find('all',	array(
							'fields' => array(
									'Feature.*',
									'Stationkey.*',
									'Station.*',
							),
							'joins' => array(
									array(
											'table' => 'features',
											'type' => 'LEFT',
											'alias' => 'Feature',
											'conditions' => array('Feature.stationkey_id = Stationkey.id')
									)
									

							),
							'conditions'=>
							array('Station.id'=> $stationMemberList, 
							'Feature.short_name'=> 'DISPLAYNAME','Stationkey.keynumber'=>'01')
					)
			);
			
		foreach ($StationMemberDisplayNames as $StationMemberDisplayName)
		{
			$StationMemberDisplay[$StationMemberDisplayName['Station']['id']] = $StationMemberDisplayName['Feature']['primary_value'];
			
		}
		
		#$groupDetail_array=print_r($StationMemberDisplay, true);
		#$this->log('GROUPS CONTROLLER : EDIT  => STATION DISPLAY NAMES ' . $groupDetail_array, LOG_DEBUG);
		
		$this->set('StationMemberDisplay',$StationMemberDisplay);
		
		$this->set('groupModel',$groupModel);
		
		$mostcommonLocations = array_keys($locationCount, max($locationCount));
		$stationLocationid = $mostcommonLocations[0];
		
		#echo "<pre>";print_r($groupModel);
	
		$this->set('stationLocationid', $stationLocationid);


		if (($groupDetails['Group']['type'] == 'MADN') || ($groupDetails['Group']['type'] == 'madn') )
		{

			
			$groupMembers = $this->Group->find('all',
					array(
							'fields' => array(
									'Group.*',
									'Feature.*',
									'Stationkey.*',
									'Station.*',
									'Location.*'
							),
							'joins' => array(
									array(
											'table' => 'features',
											'type' => 'LEFT',
											'alias' => 'Feature',
											'conditions' => array('Group.id = Feature.primary_value')
									),
									array(
											'table' => 'stationkeys',
											'type' => 'LEFT',
											'alias' => 'Stationkey',
											'conditions' => array('Feature.stationkey_id = Stationkey.id')
									),
									array(
											'table' => 'stations',
											'type' => 'LEFT',
											'alias' => 'Station',
											'conditions' => array('Stationkey.station_id = Station.id')
									),
									array(
											'table' => 'locations',
											'type' => 'LEFT',
											'alias' => 'Location',
											'conditions' => array('Station.location_id = Location.id')
									)
							),
							'conditions' => array('Feature.primary_value'=>$groupDetails['Group']['id'], 'Feature.short_name'=> array('MADN')),
							'order' => array('Group.Name asc'),
					)
			);
			
			
			//echo "<pre>"; echo $odsEntryList[0]['Scenario']['status']; print_r($odsEntryList);
			#$groupMember_array=print_r($groupMembers, true);
			#$this->log("Group controller : List Group Members : $groupMember_array", LOG_DEBUG);
			
			#foreach($groupMembers as $groupMember)
			#{
			#	$statusArray = array_push($group_status,$groupMember['Feature']['status']);
			#}
			#if (in_array('1', $statusArray))
			#{
			#	$groupStatus = 
			#}
			#elseif (in_array('1', $statusArray))
			#{
				
			#}
			
						
			$this->set('groupMembers', $groupMembers);
			$groupMemberscount = count($groupMembers);
			$this->set('groupMemberscount',$groupMemberscount);
			
			$this->pageTitle = 'grpEditMadn';
			
			/*foreach($groupMembers as $groupMember) {
				$stationLocationid=$stationLocation[$groupMember['Stationkey']['station_id']];
				
			}
			*/
			$this->set('stationLocationid',$stationLocationid);
			
			
			$grp_pilot = $this->Station->getPilotFromDn($groupDetails['Group']['identifier']);
			
			#$groupDetail_array=print_r($grp_pilot, true);
			#$this->log('GROUPS CONTROLLER : EDIT  => PILOT ' . $groupDetail_array, LOG_DEBUG);
			 
			
			$this->set('grp_pilot', $grp_pilot);
			
			
			
			if((isset($groupsave['Group']['name'])&&$groupsave['Group']['name']!='')||(isset($groupsave['Group']['desc'])&&$groupsave['Group']['desc']!=''))
			{
				#$this->Session->setFlash('<div id="success">Group updated successfully.</div>');
				$_SESSION['success'] = __('Group Name is updated successfully', true);
				$this->redirect('/groups/edit/group_id:' . $group_id);
				#exit;
			}
			$this->render('edit_madn');
		}
		elseif (($groupDetails['Group']['type'] == 'CPU') || ($groupDetails['Group']['type'] == 'cpu'))
		{
			
			
			
			$groupMemberStations = $this->Feature->find('all',array('fields'=>array('Stationkey.station_id','Stationkey.id', 'Feature.primary_value'),'conditions'=>array('Feature.short_name'=> array('cpu'), 'Feature.primary_value'=>$groupDetails['Group']['id'])));
			
			$groupMemberStationids = array();
			foreach ($groupMemberStations as $groupMemberStation)
			{
				$this->log('GROUPS CONTROLLER : GROUP MEMBER STATION ' . $groupMemberStation['Stationkey']['station_id'], LOG_DEBUG);
				array_push($groupMemberStationids, $groupMemberStation['Stationkey']['station_id']);
				$cpuKeyFeatures[$groupMemberStation['Stationkey']['station_id']] = $groupMemberStation['Stationkey']['id'];
			}
			
			//echo "<pre>";print_r($cpuKeyFeatures);
			
			
			$this->set('cpuKeyFeatures', $cpuKeyFeatures);
			$groupDetail_array=print_r($groupMemberStationids, true);
			$this->log('GROUPS CONTROLLER : GROUP MEMBER STATIONS ' . $groupDetail_array, LOG_DEBUG);
			$groupMembers = $this->Stationkey->find('all',	array(
							'fields' => array(
									'Feature.*',
									'Stationkey.*',
									'Station.*',
							),
							'joins' => array(
									array(
											'table' => 'features',
											'type' => 'LEFT',
											'alias' => 'Feature',
											'conditions' => array('Feature.stationkey_id = Stationkey.id')
									)
									

							),
							'conditions'=>
							array('Feature.short_name'=> array('cpumember'), 
							'Feature.primary_value'=> 1,'Stationkey.station_id'=>$groupMemberStationids)
					)
			);
			
			//echo "<pre>"; echo $odsEntryList[0]['Scenario']['status']; print_r($odsEntryList);
			#$groupMember_array=print_r($groupMembers, true);
			#$this->log("Group controller : List Group Members : $groupMember_array", LOG_DEBUG);
			
			#echo "<pre>";print_r($groupMembers);
			if($groupModel['Station']['location_id']!=""){
				$stationlocationid = $groupModel['Station']['location_id'];
			}else{
				foreach($groupMembers as $groupMember) {
					$stationlocation = $groupMember['Stationkey']['location_id'];
				}
				$stationlocationid = $groupMember['Stationkey']['location_id'];
			}
				
			$this->set('groupMembers', $groupMembers);
			$groupMemberscount = count($groupMembers);
			$this->set('groupMemberscount',$groupMemberscount);
			$this->set('stationLocationid',$stationlocationid);	
			#$grp_pilot = $this->Station->getPilotFromDn($groupDetails['Group']['identifier']);
			#$groupDetail_array=print_r($grp_pilot, true);
			#$this->log('GROUPS CONTROLLER : EDIT  => PILOT ' . $groupDetail_array, LOG_DEBUG);
			#$this->set('grp_pilot', $grp_pilot);
			if((isset($groupsave['Group']['name'])&&$groupsave['Group']['name']!='')||(isset($groupsave['Group']['desc'])&&$groupsave['Group']['desc']!=''))
			{
			
				#$this->Session->setFlash('<div id="success">Group updated successfully.</div>');
				$_SESSION['success'] = __('Group Name is updated successfully', true);
				$this->redirect('/groups/edit/group_id:' . $group_id);
			}
			$this->pageTitle = 'grpEditCpu';
			$this->render('edit_cpu');
		}
		else
		{
			
			#$this->Stationkey->bindModel(
			#		array('belongsTo' => array('Station'))
			#);
			
			/*
			$groupMembers = $this->Feature->find('all',array('recursive'=>'2', 
												'conditions'=>array('Feature.short_name'=> array('HNTID', 'GROUP_PREMEMBER'), 'Stationkey.dn'=>$groupDetails['Group']['identifier'])
												));
			
			*/
			 
			 $groupMembers = $this->Dns->find('all',	array(
					
			 
					'contain' => false,
					'fields' => array(
							'Feature.*',
							'Stationkey.*',
							'Station.*',
							'Location.name',
							'Location.id',
					),
					'joins' => array(
							
							array(
									'table' => 'stationkeys',
									'type' => 'LEFT',
									'alias' => 'Stationkey',
									'conditions' => array('Stationkey.dn = Dns.id')
							),
							array(
									'table' => 'stations',
									'type' => 'LEFT',
									'alias' => 'Station',
									'conditions' => array('Stationkey.station_id = Station.id')
							),
							array(
									'table' => 'locations',
									'type' => 'LEFT',
									'alias' => 'Location',
									'conditions' => array('Station.location_id = Location.id')
							),
							array(
									'table' => 'features',
									'type' => 'LEFT',
									'alias' => 'Feature',
									'conditions' => array('Feature.stationkey_id = Stationkey.id')
							)
							
								
			
					),
					'conditions'=>
					array('Feature.short_name'=> array('HNTID', 'GROUP_PREMEMBER'),
					'Stationkey.dn'=>$groupDetails['Group']['identifier'])
			)
			);
			
			 #$groupMember_array=print_r($groupMembers, true);
			 #$this->log("Group controller : List Group Member MAp : $groupMember_array", LOG_DEBUG);
			
			foreach($groupMembers as $keyfeature)
			{
				#$groupMember_array=print_r($keyfeature, true);
				#$this->log("Group controller : List Group Member MAp : $groupMember_array", LOG_DEBUG);
				$shortName = $keyfeature['Feature']['short_name'];
				$stationKey = $keyfeature['Feature']['stationkey_id'];
				$primaryValue = $keyfeature['Feature']['primary_value'];
				#$station = $keyfeature['Stationkey']['Station']['station_id'];
				/*
				 * 
				$port = $keyfeature['Stationkey']['Station']['port'];
				$status = $keyfeature['Stationkey']['Station']['status'];
				$station = $keyfeature['Stationkey']['Station']['id'];
				*/
				$port = $keyfeature['Station']['port'];
				$status = $keyfeature['Station']['status'];
				$station = $keyfeature['Station']['id'];
				
				$keynumber = $keyfeature['Stationkey']['keynumber'];
				$groupMemberMap[$stationKey][$shortName] = $primaryValue;
				$groupMemberMap[$stationKey]['port'] = $port;
				$groupMemberMap[$stationKey]['station'] = $station;
				$groupMemberMap[$stationKey]['stationkey_id'] = $stationKey;
				$groupMemberMap[$stationKey]['status'] = $status;
				$groupMemberMap[$stationKey]['keynumber'] = $keynumber;
				$groupMemberMap[$stationKey]['location'] = $keyfeature['Location']['name'];
				$groupMemberMap[$stationKey]['location_id'] = $keyfeature['Location']['id'];
				#$groupMemberMap[$stationKey]['stationState'] = 1;
				
			}
			
			#$groupMember_array=print_r($groupMemberMap, true);
			#$this->log("Group controller : List Group MemberMap : $groupMember_array", LOG_DEBUG);
			
			#$groupMember_array=print_r($groupMembers, true);
			#$this->log("Group controller : List Group Members : $groupMember_array", LOG_DEBUG);
			
			#Order initial array by limked list
			
			# FInd first element
			$firstelement = null;
			foreach ($groupMemberMap as $unsortedKey)
			{
				if ($unsortedKey['port'] == $unsortedKey['GROUP_PREMEMBER'])
				{
					$cur_row = $unsortedKey;
					# get the locaito of the pilot for use in staiton selector 
					$stationLocationid = $unsortedKey['location_id'];
					$this->log("Group controller : xLH Group First MEmber: " . $unsortedKey['port'], LOG_DEBUG);
					break;
				}
			}
			
			 
			#loop through linked list
			$sortedMembers = array();
			$sortedMembers[] = $cur_row;
			
			#$curId = $firstelement;
			$counter = 0;
			while($counter < 10)
			{
				
				foreach ($groupMemberMap as $row)
				{
					
					if (($row['GROUP_PREMEMBER'] == $cur_row['port']) && ($row['port'] != $unsortedKey['port']))
					{
						$this->log("Group controller : CHECKING:" . $row['port'], LOG_DEBUG);
						$this->log("Group controller : xLH  MEmber: " . $counter . ' : ' . $row['GROUP_PREMEMBER'] . '==' . $row['port'], LOG_DEBUG);
						$sortedMembers[] = $row;
						$cur_row = $row;
						break;
					}
				}
				

				$counter++;
			}
			
			
			#$groupMember_array=print_r($sortedMembers, true);
			#$this->log("Group controller : List Group Members : $groupMember_array", LOG_DEBUG);
		
			$this->set('groupMembers', $sortedMembers);
			$groupMemberscount = count($sortedMembers);
			$this->set('groupMemberscount',$groupMemberscount);
			$this->set('stationLocationid',$stationLocationid);
			#$this->Session->setFlash('<div id="success">Group updated successfully.</div>');
			$grp_subtype = $groupDetails['Group']['sub_type'];
			$this->pageTitle = 'grpEdit' . $grp_subtype;
			$this->render('edit_xlh');
			
		}
		
		$this->log("Group controller :  END EDIT FUNCTION ", LOG_DEBUG);
	}
	function  deleteGroup($group_id = null){
	
	 	$group_id=isset($this->params['url']['group_id'])?$this->params['url'][		'group_id']:(isset($this->params['named']['group_id'])?$this->params['named']['group_id']:"");
		if($group_id != '')
		{
				
				
			$groups = $this->Group->find('all',array('conditions'=>array('Group.id'=>$group_id)));
			$customer_id = $groups[0]['Group']['customer_id'];
			
			$group_type = $groups[0]['Group']['type'];
			if(($group_type == 'MADN')|| ($group_type == 'madn'))
			{
					
			#Free the dn;
				$dn_id = $groups[0]['Group']['identifier'];
				$dnUpdate = $this->Dns->deleteActiveDn($dn_id);
			}
			$this->log('GROUPS CONTROLLER ' . 'Deleting ' . $group_id. $customer_id, LOG_DEBUG);
				
			$this->Group->delete($group_id)	;
				
		}
		$this->redirect('/groups/numbergroups/customer_id:' . $customer_id);
	}

      function dns_select()
	  {
		 $this->loadModel('Dns');
		 $this->layout ='false';
	     $results = $this->Dns->find('all',array('fields'=>array('Dns.*,Location.name'),'order'=>'Location.name asc'));
			print_r($results );
	     $this->set('dns', $results);
	  
	  }
      	  
	  



	/**
	 * function for uploading file
	 *
	 */
	
	
	
	
	/*
	function export()
	{
		$this->layout = ""; 
		
		$conds = unserialize($this->Session->read('cond'));
		
		$filename = "export_groups_".date("Y.m.d").".csv";
		$csv_file = fopen('php://output', 'w');
	    header('Content-type: application/csv');
		header('Content-Disposition: attachment; filename="'.$filename.'"');
		$customer_id = 'HEIN'; # TESTING
		$groupResults = $this->Group->find('all',array('recursive'=>'2', 'fields' => array('Group.id', 'Group.name','Group.type','Group.identifier', 'Group.status' ),'order'=>'Group.id ASC','conditions' => $conds));
		#$executionResults = $this->Execution->find('all',array('fields' => array('Execution.operation', 'Execution.targetDate', ),'conditions' => array('Scenario.customer_id' => $customer_id ))); 
		$header_row = array("S.No.", "Group_Name", "Group_Status", "Group", "Group", "Execution status" );
		
		fputcsv($csv_file,$header_row,';','"');
	
		// Each iteration of this while loop will be a row in your .csv file where each field corresponds to the heading of the column
		$i=1;
		
		foreach($groupResults as $result)
		{
			// Array indexes correspond to the field names in your db table(s)
               
				foreach ($result as $execResult)
				{
					
					#print_r($execResult);
					  
					$row = array(
					$result['Group']['Srno']= $i,					
					$result['Group']['name'],					
					$result['Group']['identifier']				
					);
					$i++;
					fputcsv($csv_file,$row,';','"');
				}

		}
	
		fclose($csv_file);exit();
	}
	*/

	 /* function for getting the script details
	 *
	 * @param int $script_id
	 */
	function scriptdetails ($script_id=null){
		$script			=	$this->Scenario->findById($script_id);
		$scriptinfo		=	$script['Scenario'];
		
		$this->update	=	$script['Scenario'];
		$this->layout	=	'ajax';
		
	
		
		$this->set('display',$this->update);

	}
	
	
	// function to add group data to logs	
	function add_group()
	{ 
	   $customer_id=isset($this->params['url']['customer_id'])?$this->params['url']['customer_id']:(isset($this->params['form']['customer_id'])?$this->params['form']['customer_id']:"");

	   #$type=isset($this->params['url']['type'])?$this->params['url']['type']:(isset($this->params['form']['type'])?$this->params['form']['type']:"");
	   $type=isset($this->params['url']['grouptype'])?$this->params['url']['grouptype']:(isset($this->params['form']['grouptype'])?$this->params['form']['grouptype']:"");
	   
	   if(($type == 'mlh') || ($type == 'dlh')){
	   	
	   		$type ='XLH';
	   }
	   
	   
	   $identifier=isset($this->params['url']['identifier'])?$this->params['url']['identifier']:(isset($this->params['form']['identifier'])?$this->params['form']['identifier']:"");
	   
	   $locName=isset($this->params['url']['locName'])?$this->params['url']['locName']:(isset($this->params['form']['locName'])?$this->params['form']['locName']:"");	   
	   
	   $this->log('GROUPS CONTROLLER : ADD GROUP CUST' . $customer_id . ' TYPE ' . $type . ' IDENT ' . $identifier , LOG_DEBUG);
		$this->set('customer_id',$customer_id);	
		$this->set('type',$type);	
		
			
		
			   if(1){
				
					$groupdataArray = array();
					$groupdataArray['Group']['customer_id'] = $customer_id;
					$groupdataArray['Group']['type'] = strtoupper($type);
					$groupdataArray['Group']['identifier'] = $identifier;
		   
					$this->loadModel('Group');
					
					if ($this->Group->save($groupdataArray)) { 
		           		 #$this->Session->setFlash('<div id="success">Group Created successfully.</div>');
						 
						 
						  //$this->Session->setFlash('<div class="notification first" style="width: 534px; margin-left:10px; margin-top:10px;"><div class="ok"><div class="message">Group Created successfully.</div></div></div>');
						  
						  $_SESSION["group_created"]="Group Created successfully";
						  
						 
							$id = $this->Group->id;
					
						if(($type == 'cpu') || ($type == 'CPU'))
						{
							$update['Group']['identifier'] = $id;
                        			$update['Group']['id'] = $id ;
                        			$this->Group->save($update, false,  array('id','identifier'));
							$this->redirect(array('action' => 'edit/group_id:'.$id));
						}
						elseif(($type == 'MADN') || ($type == 'madn'))
						{
							#$update['Group']['identifier'] = $id;
							#$update['Group']['id'] = $identifier ;
							$this->Group->changeId($id, $identifier);
							$this->log('GROUPS CONTROLLER : MADN ADDING ACTIVE_DN' . $identifier , LOG_DEBUG);
							$dnUpdate = $this->Dns->createActiveDn($identifier, $type);
							
							$log = 'Group Added :' . strtoupper($type) . ':' .$id;
							 
							$insert = array (
									'Log' => array (
											'affected_obj' => $id,
											'affected_obj_type' => 'Group',
											'log_entry' => $log,
											'created' => date('Y-m-d H:i:s'),
											'status' => 1,
											'customer_id' => $customer_id,
											'bsk' => $this->Session->read('BSK'),
											'user' => $this->Session->read('ACCOUNTNAME'),
											'app_type' => $this->Session->read('APPNAME'),
											'modified' => '0000-00-00 00:00:00',
											'modification_status' => 1,
											'modification_response' => ''
							
									)
							);
							 
							$this->Log->create();
							$this->Log->save($insert, false);
							
							
							echo $identifier;
							exit();
						}
						elseif(($type == 'XLH') || ($type == 'xlh'))
						{
						#$update['Group']['identifier'] = $id;
							#$update['Group']['id'] = $identifier ;
							$this->Group->changeId($id, $identifier);
							$this->log('GROUPS CONTROLLER : XLH ADDING ACTIVE_DN' . $identifier , LOG_DEBUG);
									$dnUpdate = $this->Dns->createActiveDn($identifier, $type);
									
									
								
								$log = 'Group Added :' . strtoupper($type) . ':' .$id;
                        			
                        			$insert = array (
                        					'Log' => array (
                        							'affected_obj' => $id,
                        							'affected_obj_type' => 'Group',
                        							'log_entry' => $log,
                        							'created' => date('Y-m-d H:i:s'),
                        							'status' => 1,
                        							'customer_id' => $customer_id,
                        							'bsk' => $this->Session->read('BSK'),
                        							'user' => $this->Session->read('ACCOUNTNAME'),
                        							'app_type' => $this->Session->read('APPNAME'),
                        							'modified' => '0000-00-00 00:00:00',
                        							'modification_status' => 1,
                        							'modification_response' => ''
		
                        					)
                        			);
                        			
                        			$this->Log->create();
                        			$this->Log->save($insert, false);
									
									
									echo $identifier;
									exit();
						}
						else 
						{
							echo $id;
							exit();
						}
					//$this->redirect(array('action' => 'edit/group_id:'.$id));
 		      			 } else {
					//$this->redirect(array('action' => '/index/customer_id:'.$customer_id));
		
				}
			  }	
		
	  
		$this->loadModel('Dns');
		$Dnlists = $this->Dns->find('all',array('conditions'=>array('Location.customer_id'=>$customer_id)));	  
	   
	   $this->set('dns', $results);
	   
	    print count($Dnlists);
	   
            
	}
	
	// function to save data to logs
	function validates(){
			if($this->RequestHandler->isAjax()==true){ 
			//echo "<pre>"; print_r($this->params); die;
			//echo "<pre>"; print_r($this->params); die;
			$logArray = $this->params['form'];
			if($logArray['log_entry']=='accepted'){
				$log_entry = 'scenario_accepted';
				$state = '5';
			}elseif($logArray['log_entry']=='rejected'){
				$log_entry = 'scenario_rejected';
				$state = '6';
			}
			$datatosave = array();
					$datatosave = array (
							'Log' => array (
							'affected_obj' => $this->params['pass'][0],
							'log_entry' => $log_entry,
							'created' => date('Y-m-d H:i:s'),
							'status' => 1,
							'customer_id' => $logArray['cust_id'],
							'bsk' => $this->Session->read('BSK'),
							'user' => $this->Session->read('ACCOUNTNAME'),
							'app_type' => 'Gate',
							'modified' => '0000-00-00 00:00:00',
							'modification_status' => 1,
							'modification_response' => $logArray['comment']
						)
					);
				$this->Log->create();
				$this->Log->save($datatosave);
				$this->Scenario->updateAll(
							array('Scenario.status' => "'".$state."'"),
							array('Scenario.id' => $this->params['pass'][0])
				);
				echo $log_entry; die;
	
		}
	}
	
	/*
     * **************************************************
      Function Name   : edit_group_via_ajax
      Description     : This function is use for Update Group Title.
      Parameter       : NA
      Return       	  : NA
      Created Date    : 29/01/2014.
     * **************************************************
     */

	
	 function edit_group_via_ajax() {
	 	 $this->layout=false;	
	  $group_name=trim($this->params['form']['value']);
		$group_id=isset($this->params['url']['group_id'])?$this->params['url']['group_id']:(isset($this->params['named']['group_id'])?$this->params['named']['group_id']:"");
			$this->Group->updateAll(
							array('Group.name' => "'".$group_name."'"),
							array('Group.id' => $group_id)
				);
				echo $group_name;
		exit();		
   } 


    function export()
    {
        $this->layout = "";
        $conds = unserialize($this->Session->read('cond'));

        unset($conds['Feature.short_name']);
        
        //ini_set('max_execution_time', 600); //increase max_execution_time to 10 min if data set is very large
    
        $filename = "export_groups_".date("Y.m.d").".csv";
        $csv_file = fopen('php://output', 'w');
        header('Content-type: application/csv');
        header('Content-Disposition: attachment; filename="'.$filename.'"');
    
        //$results = $this->Customer->query($sql);  // This is your sql query to pull that data you need exported
        //or
        #$results = $this->Customer->find('all', array('conditions'=> array('type' => $conds),'order'=>'created DESC','recursive'=>-1));
        $results = $this->Group->find('all', array('conditions'=> $conds,'order'=>'created DESC','recursive'=>-1));
        //print_r($results);
        //print_r($conds);
        //exit;
        $header_row = array(__("Nr", true),__("Name", true), __("identifier", true));
        fputcsv($csv_file,$header_row,';','"');
    
        // Each iteration of this while loop will be a row in your .csv file where each field corresponds to the heading of the column
        $i=1;
        foreach($results as $result)
        {
            // Array indexes correspond to the field names in your db table(s)
            $row = array(
                $result['Group']['Sno']= $i,
                $result['Group']['name'],
                $result['Group']['identifier']                
            );
            $i++;
            fputcsv($csv_file,$row,';','"');
        }
    
        fclose($csv_file);exit();
    }

/**
* 
* @Create editcpuname function open overlay and update groupName ,groupDescription For CPU
*
*/

	function editcpuname($group_id = null){
		$this->layout="";
		
		$groupid = isset($this->params['url']['group_id']) ? $this->params['url']['group_id'] : (isset($this->params['named']['group_id']) ? $this->params['named']['group_id'] : "");
		$groupname = isset($this->params['url']['group_name']) ? $this->params['url']['group_name'] : (isset($this->params['named']['group_name']) ? $this->params['named']['group_name'] : "");
		
		$groupdesc = isset($this->params['url']['groupdesc']) ? $this->params['url']['groupdesc'] : (isset($this->params['named']['groupdesc']) ? $this->params['named']['groupdesc'] : "");
		
		$this->set('group_id',$groupid);
		
		$groupname = utf8_decode($groupname);
		$groupdesc = utf8_decode($groupdesc);
		
		
		$groupDetails = $this->Group->find('first', array (
					'conditions' => array (
							'Group.id' => $groupid,
							'Group.type' => 'CPU'
					)
			));
			
			
			$this->set('groupDetails',$groupDetails);
			$groupcustomer_id = $groupDetails['Group']['customer_id'];
			$id = $groupDetails['Group']['id'];
	
		if($groupname!=""){
				$dataarray['Group']['name'] = $groupname;
		        $dataarray['Group']['desc'] = $groupdesc;
		        $dataarray['Group']['id'] = $groupid;
		
		        $update = $this->Group->save($dataarray); 
				$_SESSION['success'] = __('Group Name is updated successfully', true);
				
				$log = 'Group Updated : Details Modified:' . $groupname;
									 
									$insert = array (
											'Log' => array (
													'affected_obj' => $id,
													'affected_obj_type' => 'Group/CPU',
													'log_entry' => $log,
													'created' => date('Y-m-d H:i:s'),
													'status' => 1,
													'customer_id' => $groupcustomer_id,
													'bsk' => $this->Session->read('BSK'),
													'user' => $this->Session->read('ACCOUNTNAME'),
													'app_type' => $this->Session->read('APPNAME'),
													'modified' => '0000-00-00 00:00:00',
													'modification_status' => 1,
													'modification_response' => ''
									
											)
									);
									 
									$this->Log->create();
									$this->Log->save($insert, false);
									
									
									$log_id = $this->Log->id;
		           
			
		$this->Session->write('log_entry', 'Group Updated : Details Modified:' . $station_id);
$link = '<a class="fancybox fancybox.ajax" href="' . Configure::read('base_url') . '/logs/logdetails/' . $log_id . '">' . __("LogEntry", true) . '</a>';         
            
			$_SESSION['success'] .= $link;
				
				
				
				
				
			//exit();	
		}
		//exit();	
	
	}
/**
* 
* create New CPU Group
* @return
*/	
	function addcpugroup(){
		
		$this->layout = false;
		
		 $grouptype = isset($this->params['url']['grouptype']) ? $this->params['url']['grouptype'] : (isset($this->params['named']['grouptype']) ? $this->params['named']['grouptype'] : "");
		 $groupcustomer_id = isset($this->params['url']['customer_id']) ? $this->params['url']['customer_id'] : (isset($this->params['named']['location_id']) ? $this->params['named']['customer_id'] : "");
		 
		  $groupLocationId = isset($this->params['url']['groupLocationId']) ? $this->params['url']['groupLocationId'] : (isset($this->params['named']['groupLocationId']) ? $this->params['named']['groupLocationId'] : "");
		 $groupname = isset($this->params['url']['group_name']) ? $this->params['url']['group_name'] : (isset($this->params['named']['group_name']) ? $this->params['named']['group_name'] : "");
		
		$groupdesc = isset($this->params['url']['groupdesc']) ? $this->params['url']['groupdesc'] : (isset($this->params['named']['groupdesc']) ? $this->params['named']['groupdesc'] : "");
		 
		$groupname = utf8_decode($groupname);
		$groupdesc = utf8_decode($groupdesc);
		
		 $this->set('SELECTED_CNN',$groupcustomer_id);
		 $this->set('stationLocationid',$groupLocationId);
		 if ($groupcustomer_id!= '')
			{
				#Find Locations
				$customer = $this->Customer->find('first',array('contain'=>array('Location'),'conditions'=>array('id'=>$groupcustomer_id)));		
				
				
				
				
				
				foreach($customer['Location'] as $key=>$value):
				$location['Location'] = $value;
				
				if($location['Location']['scm_name']=="" && $location['Location']['address']!="" ) {
				$locations[$location['Location']['id']] =$locationstring = $location['Location']['name'] . ' ( ' . $location['Location']['plz'] . ' ,' .$location['Location']['address'].' )';
			}
			elseif($location['Location']['address']=="" && $location['Location']['scm_name']!="") {
				$locations[$location['Location']['id']] =$locationstring = $location['Location']['name'] . ' ( ' . $location['Location']['plz'] . ' ,' .$location['Location']['scm_name'].' )';
			}
			elseif($location['Location']['address']=="" && $location['Location']['scm_name']=="" && $location['Location']['plz']!="") {
            $locations[$location['Location']['id']] = $location['Location']['name'] . ' ( ' . $location['Location']['plz'] .' )';
			}
			elseif($location['Location']['address']=="" && $location['Location']['scm_name']=="" && $location['Location']['plz']=="") {
            $locations[$value['id']] = $location['Location']['name'];
			}
			
			else {
				$locations[$location['Location']['id']] = $location['Location']['name'] . ' ( ' . $location['Location']['plz'] . ' ,' . $location['Location']['scm_name'] . ','.$location['Location']['address'].' )';
			}
		        	
				
				
				
				
				//$locations[$location['Location']['id']] = $location['Location']['name'];
				
				//$locations[$value['id']] =  $value['name'];
				endforeach;
				asort($locations);
				
				$this->set('locations', $locations);				
			}
						
				if($groupname!=""){
					$groupdataArray = array();
					$groupdataArray['Group']['customer_id'] = $groupcustomer_id;
					$groupdataArray['Group']['name'] = $groupname;
					$groupdataArray['Group']['desc'] = $groupdesc;
					$groupdataArray['Group']['type'] = strtoupper($grouptype);
					
		   
					$this->loadModel('Group');
					
					if ($this->Group->save($groupdataArray)) {
							$id = $this->Group->id;
						if(($grouptype == 'cpu') || ($grouptype == 'CPU'))
						{
							$update['Group']['identifier'] = $id;
                        			$update['Group']['id'] = $id ;
                        			$this->Group->save($update, false,  array('id','identifier'));
									
									$_SESSION['location_id']=$groupLocationId;
									$this->set('stationLocationid', $_SESSION['success']);
									
									$log = 'Group Added : CPU :' . $groupname;
									 
									$insert = array (
											'Log' => array (
													'affected_obj' => $id,
													'affected_obj_type' => 'Group',
													'log_entry' => $log,
													'created' => date('Y-m-d H:i:s'),
													'status' => 1,
													'customer_id' => $groupcustomer_id,
													'bsk' => $this->Session->read('BSK'),
													'user' => $this->Session->read('ACCOUNTNAME'),
													'app_type' => $this->Session->read('APPNAME'),
													'modified' => '0000-00-00 00:00:00',
													'modification_status' => 1,
													'modification_response' => ''
									
											)
									);
									 
									$this->Log->create();
									$this->Log->save($insert, false);
									
									echo $id.':'.$groupLocationId;
									exit();
									
							//$this->redirect(array('action' => 'edit/group_id:'.$id));
						}
				}
			}			
				
								
			  
				
	
	}

}
?>
