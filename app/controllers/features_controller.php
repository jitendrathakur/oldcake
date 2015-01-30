<?php
#-----------------------------------------------------------------#
# $Rev:: 22            $:  Revision of last commit                #
#-----------------------------------------------------------------#

/**
 * Scenarios Controller
 *
 * file: /app/controllers/Groupss_controller.php
 */


#$Stations = new StationsController;
#$Stations->constructClasses();
	#var $header_string = 'Groups';
class FeaturesController extends AppController {
	// good practice to include the name variable

	//Load the Station controller classess

	

	var $uses 	= array('Feature', 'CFeature', 'Location', 'Station', 'Customer', 'Dns','Group');
	var $name 	= 'Features';
	
	var $paginate = array('Paginate' => 15, 'page' => 1);
	var $components = array('RequestHandler');
	#var $paginate = array('Paginate' => 15, 'page' => 1, 'order' => array('Customer.name' => 'asc'));
	
	
	// load any helpers used in the views
	var $helpers = array('Html', 'Form', 'Javascript');
    
	
	function beforeFilter (){
		$this->log('FEATURES CONTROLLER : BEFOREFILTER IN GROUPS CONTROLLER', LOG_DEBUG);
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
			$this->redirect('/customers');
			exit();
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
		
		$cond = array('Group.customer_id'=>$customer_id);

		$name=isset($this->params['url']['name'])?$this->params['url']['name']:(isset($this->params['named']['name'])?$this->params['named']['name']:"");
		if($name!=''){
			$cond = array_merge($cond,array('Scenario.name LIKE'=>'%'.$name.'%'));
			$this->passedArgs['name'] = $name;
		}
		
		$status=isset($this->params['url']['status'])?$this->params['url']['status']:(isset($this->params['named']['status'])?$this->params['named']['status']:"");
		if($status!=''){
			$cond = array_merge($cond,array('Scenario.state' => $status));
			$this->passedArgs['status'] = $status;
		}


		
		$this->paginate= array('conditions'=>$cond,'limit' => $this->paginate['limit'],  'order' => array('Group.Name asc'));
		$this->set('title_header', __('Swisscom Extranet Corporate Business - Voiphone Selfcare', true));
		$this->Session->write('Customer.Name', 'UNDEF');
		$this->set('cust_for_layout', 'UNDEFINED');
		$this->set('groups', $this->paginate('Group'));
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
	function edit($stationkey_id = null) {
		
		$this->pageTitle = 'Group Edit';
		
	  $stationkey_id=isset($this->params['url']['stationkey_id'])?$this->params['url']['stationkey_id']:(isset($this->params['named']['stationkey_id'])?$this->params['named']['stationkey_id']:"");
		 $dn_id=isset($this->params['url']['dn_id'])?$this->params['url']['dn_id']:(isset($this->params['named']['dn_id'])?$this->params['named']['dn_id']:"");
		$spg=isset($this->params['url']['spg'])?$this->params['url']['spg']:(isset($this->params['named']['spg'])?$this->params['named']['spg']:"");
		 
		$featureType=isset($this->params['url']['featureType'])?$this->params['url']['featureType']:(isset($this->params['named']['featureType'])?$this->params['named']['featureType']:"");
		$this->set('featureType', $featureType);
		$this->log('FEATURES CONTROLLER : EDIT  => STATIONKEY_ID ' . $stationkey_id, LOG_DEBUG);
		$this->set('grpid',$dn_id);
		
		
		$groupDetailsdesc = $this->Group->find('first', array (
					'conditions' => array (
							'Group.id' => $dn_id,
							'Group.type' => array('MADN', 'XLH')
					)
			));
			
			$this->set('groupDetailsdesc',$groupDetailsdesc);
		
		
		#
		
		
		if(isset($spg) && ($spg != ''))
		{
			#if a soruce page is given send to the view.
			$this->set('spg', $spg);
			
		}
		if(isset($dn_id) && ($dn_id != ''))
		{
			#no key supplied. could have come from group edit or come from DN List page!
			
			
			#DEtermin if this number is a group number or not.
			
			$groupDetails = $this->Group->find('first', array (
					'conditions' => array (
							'Group.id' => $dn_id,
							'Group.type' => array('MADN', 'XLH')
					)
			));
			
		
			if(empty($groupDetails))
			{
				#treat as DN individual
				
				$stationkey = $this->Feature->find('first', array (
						'fields'=>'Feature.stationkey_id',
						'conditions' => array (
								'Feature.short_name' => 'DN',
								'Feature.primary_value' => $dn_id
						)
				));
				$stationkey_id = $stationkey['Feature']['stationkey_id'];
				$this->log("Features controller :PILOT KEY IS : $stationkey_id", LOG_DEBUG);
			}
			else 
			{
				#treat as a group
				if($groupDetails['Group']['type'] == 'MADN')
				{
					#Find Pilot 
					$pilotData = $this->Station->getPilotFromDn($dn_id);
					
					#$results_array=print_r($pilotData, true);
					#$this->log("Features controller : Group Details : $results_array", LOG_DEBUG);
					if (count($pilotData) == 0)
					{
						#Get lowest LEN.
						$stationkey_id = $this->calculateMADNLowestLen($dn_id);
					}
					else
					{	
						$stationkey_id = $pilotData[0]['stationkeys']['id'];
					}
					$this->log("Features controller :PILOT KEY : $stationkey_id", LOG_DEBUG);
					
					$groupname = $this->Station->getGroupDisplaynameFromDn($dn_id);
					$this->set('groupname',$groupname);
				}
				elseif ($groupDetails['Group']['type'] == 'XLH')
				{

					#Get all Hunt GRoup name details
					$customer_id = $groupDetails['Customer']['id'];
					$xlhListDetails = $this->Station->getXlhGroupDisplaynameFromCust($customer_id);
					
					
					
					foreach ($xlhListDetails as $xlhListDetail)
					{
						
			           // print_r($xlhListDetail['s2']['primary_value']."==".$dn_id."</br>");
						if ($xlhListDetail['s2']['primary_value'] == $dn_id) {
							
							$stationkey_id = $xlhListDetail['s1']['id'];
							
							$this->log("Features controller :PILOT KEY : $stationkey_id", LOG_DEBUG);
						}
						
					}
								
					
			
				}
				
			}
					
					
			
						
			
			#$results_array=print_r($stationkey, true);
			#$this->log("Features controller : feature results : $results_array", LOG_DEBUG);
			$this->set('returnDNList', 'true');
			$this->log("Features controller : Stationkey : $stationkey_id", LOG_DEBUG);
			
			
			
			#ORIGINAL FROM GROUP.
			#$groupnames = $this->Group->find('first',array('conditions'=>array('Group.id'=>$dn_id,'Group.type'=>'MADN')));
			
			#$grpname = $groupnames['Group']['name'];
			
			#REPLACE WITH DISPLAYNAME FROM PILOT
			
			#Find Pilot data
			
			
			
			
			
			
		}
		
		
		$stationFeaturesSource = $this->Feature->find('all', array (
				'conditions' => array (
						'Feature.stationkey_id' => $stationkey_id
				)
				,'order' => array (
						'Feature.id',
				),
		));
		
		
		
		
		
		#$results_array=print_r($stationFeaturesSource, true);
		#$this->log("Features controller : feature results : $results_array", LOG_DEBUG);
		
		preg_match("/[0-9]+@([0-9]+)/", $stationkey_id, $matches);
		if ($matches[1]) {
			#$this->redirect('/stations/edit/'.$matches[1]);
			$station_id = $matches[1];
			#print "STATION  DETECTED";
			
			
		
		
			$stationDetails = $this->Station->find('all', array (
				'conditions' => array (
						'Station.id' => $station_id
				)
			));
			
			
			
			/**********for case of internal/external users********/
			if ($this->Session->read('SELECTED_CUSTOMER') != Configure :: read('access_id')) {
			
				#If The user is an external..
			
						$id = $this->Session->read('SELECTED_CUSTOMER');
						$cnt = count($this->_Filter);
			
						if (!$this->Customer->validCustomer($id, $stationDetails[0]['Customer']['id'])) {
						#print_r("not valid");die();
							$this->redirect('/customers');
							exit ();
						}
						#print_r("valid checking $id $number");die();
			
			}
			/**********************END*************************/
			
			
			
			$allFeaturesSource = $this->Feature->find('all', array (
					'conditions' => array (
							'Stationkey.station_id' => $station_id
					)
					,'order' => array (
							'Feature.id',
					),
			));
			
			#Loop throught the features and foreach stationeky determine a type for that key
			foreach($allFeaturesSource as $allkeyfeature)
			{
				$shortName = $allkeyfeature['Feature']['short_name'];
			
				$allstationFeatures[$shortName]['short_name'] = $shortName;

			
			}
			
			$this->set('stationfeatures', $allstationFeatures);
						
			#$results_array=print_r($stationDetails, true);
			#$this->log("Features controller : stations results : $results_array", LOG_DEBUG);
		
			if ($stationDetails[0]['Station']['customer_id'] != '')
			{
				$customer_id = $stationDetails[0]['Station']['customer_id'];
				
				#Find Locations
				$customer = $this->Customer->find('first',array('contain'=>array('Location'),'conditions'=>array('id'=>$customer_id)));
				foreach($customer['Location'] as $key=>$value):
				$locations[$value['id']] =  $value['name'];
				endforeach;
				
			}		
		}
		
		#Loop throught the features and foreach stationeky determine a type for that key
		foreach($stationFeaturesSource as $keyfeature)
		{
			$shortName = $keyfeature['Feature']['short_name'];
						
			$stationFeatures[$shortName]['short_name'] = $shortName;
			#$stationFeatures[$shortName]['primary_value'] = $keyfeature['Feature']['short_name'];
			$stationFeatures[$shortName]['primary_value'] = $keyfeature['Feature']['primary_value'];
			$stationFeatures[$shortName]['created'] = $keyfeature['Feature']['created'];
			$stationFeatures[$shortName]['status'] = $keyfeature['Feature']['status'];
			$stationFeatures[$shortName]['location_id'] = $keyfeature['Stationkey']['location_id'];
			$stationFeatures[$shortName]['label'] = $keyfeature['Feature']['label'];

		}
		
		$dnDetails = $this->Dns->find('first', array (
				'conditions' => array (
						'Dns.id' => $stationFeatures['DN']['primary_value'],
				)
		));
		
		#ORIGINAL FROM GROUP.
		#$groupnames = $this->Group->find('first',array('conditions'=>array('Group.id'=>$dn_id,'Group.type'=>'MADN')));
			
		#$grpname = $groupnames['Group']['name'];
			
		#REPLACE WITH DISPLAYNAME FROM PILOT
			
		#Find Pilot data
			
		#$groupnamedetails = $this->Station->getGroupDisplaynameFromDn($stationFeatures['DN']['primary_value']);
		#$results_array=print_r($groupname, true);
		#$this->log("Features controller : GROUP DISPLAY : $results_array", LOG_DEBUG);
		#$groupname = $groupnamedetails[0]['features']['primary_value'];
		#$this->set('groupname',$groupname);
		
		
		$this->set('dnDetails', $dnDetails);
		#Set Options.
		
		#CBM TEST
		
				
		#??? Replace at some point with read from config file.
		$statuses[0] = Inactive;
		$statuses[1] = Active;
		#???Add up to 60 in 4 increments.
		$cfdvtcounter = 12;
		#$cfdvtOptions['0'] = '--';
		
		$cfdvtOptions[$stationFeatures['CFDVT']['primary_value']] = $stationFeatures['CFDVT']['primary_value'];
		
		while ($cfdvtcounter <= 60)
		{
			
			$cfdvtOptions[$cfdvtcounter] = $cfdvtcounter;
			$cfdvtcounter = $cfdvtcounter + 4;
		}
		
		$this->set('cfdvtOptions', $cfdvtOptions);
		#$languageOptions['en'] = 'EN';
		$languageOptions['de'] = 'DE';
		$languageOptions['fr'] = 'FR';
		$languageOptions['it'] = 'IT';
		$this->set('languageOptions', $languageOptions);
		$barringOptions['Set1'] = 'Set1';
		$barringOptions['Set2'] = 'Set2';
		$barringOptions['Set3'] = 'Set3';
		$barringOptions['Set4'] = 'Set4';
		$barringOptions['Set5'] = 'Set5';
		$this->set('barringOptions', $barringOptions);
		
		$this->set('locations', $locations);
		$this->set('location_id', $stationFeatures['DN']['location_id']);
		
		$this->set('porttype', $stationDetails[0]['Station']['type']);
		$this->set('custtype', $stationDetails[0]['Customer']['type']);
		
		
		
		$cond10 = array('Location.id'=>$stationFeatures['DN']['location_id']);
		$loc_name = $this->Location->find('first',array('conditions'=>$cond10,'fields'=>array('Location.name'),'recursive'=>-1));
		$this->set('location_name',$loc_name);
				
		
		#echo "<pre>";print_r($stationFeatures);
		#$results_array=print_r($stationFeatures, true);
		#$this->log("Station controller : feature results : $results_array", LOG_DEBUG);
		#$results_array=print_r($stationFeaturesSource, true);
		#$this->log("Station controller : feature results : $results_array", LOG_DEBUG);
		$this->set('features', $stationFeatures);
		$this->set('statId', $station_id);
		$this->set('customer_id', $customer_id);
		$this->set('statuses', $statuses);
		$this->set('stationkey_id', $stationkey_id);
		$this->set('statStatus',$stationDetails[0]['Station']['status']);
		if($stationDetails[0]['Station']['status'] == 7)
		{
			$this->set('error','stationInException');
		}
			
		$this->log("Group controller :  END EDIT FUNCTION ", LOG_DEBUG);
		//$dnBlf_observers = $this->Feature->returnObservers($station_id);
		$dnIdStation=isset($this->params['url']['dnId'])?$this->params['url']['dnId']:(isset($this->params['named']['dnId'])?$this->params['named']['dnId']:"");
	
	    if($dnIdStation!=""){
			$primaryVal=$dnIdStation;
			
		}else{
			$primaryVal=$station_id;
		}
	
	
	
		$dnBlf_observers = $this->Feature->returnObservers($primaryVal);
		
		
		$this->set('observers', $dnBlf_observers);
		
		if($featureType == 'KEY1_DN'){
			$this->layout ='ajax';
			#Configure::write('debug',0);
			$this->render('/features/individual_dn_edit');
		}
		if(($featureType == 'DN_INDIVIDUAL') || ($featureType == 'DN_MADN_PILOT')|| ($featureType == 'DN_XLH_PILOT')||($featureType == 'DN_MADN')||($featureType == 'DN_XLH')){
			$this->layout ='ajax';
			#Configure::write('debug',0);
			
			$cond1 = array('Location.customer_id' => $customer_id);
			$cond1 = array_merge($cond1, array('Dns.function IS NOT NULL'));
			$results = $this->Dns->find('all', array('order' => 'Dns.id asc', 'conditions' => $cond1, 'group' => 'Dns.id', 'fields' => array('Dns.*,Location.name')));
				
			#echo "<pre>";print_r($results);
				
			$sdnaDns['0'] = '---';
			foreach ($results as $result)
			{
				$sdnaDns[$result['Dns']['id']] = $result['Dns']['id'];
			
			}
			
			$existingDns = $this->Stationkey->find('all', array(
						
						'joins' => array(
						array(
								'table' => 'stations',
								'type' => 'LEFT',
								'alias' => 'Station',
								'conditions' => array('Stationkey.station_id = Station.id')
							),
								array(
										'table' => 'features',
										'type' => 'LEFT',
										'alias' => 'Feature',
										'conditions' => array('Feature.stationkey_id = Stationkey.id')
								)
						
						),		
						'conditions' => array('Station.customer_id' => $customer_id, 'Feature.short_name'=>'SDNA'), 
						'fields' => array('Feature.primary_value')
				)
			);
				
			foreach ($existingDns as $result)
			{
				$sdnaDns[$result['Feature']['primary_value']] = $result['Feature']['primary_value'];
					
			}
			$this->set('sdnaDns', $sdnaDns);
			$this->render('/features/individual_dn_edit');
			
		}
		
		
		if($featureType == 'DN_XLH'){
			$this->layout ='ajax';
			#Configure::write('debug',0);
			#$this->render('/features/madn_edit');
			$this->render('/features/individual_dn_edit');
		}
		if($featureType == 'DN_XLH_PILOT'){
			
			$this->layout ='ajax';
			#Configure::write('debug',0);
			#$this->render('/features/madn_edit');
			$this->render('/features/individual_dn_edit');
		}
		if($featureType == 'DN_MADN'){
			$this->layout ='ajax';
			#Configure::write('debug',0);
			#$this->render('/features/madn_edit');
			$this->render('/features/individual_dn_edit');
		}
		if($featureType == 'DN_MADN_PILOT'){
			
			$this->layout ='ajax';
			#Configure::write('debug',0);
			#$this->render('/features/madn_edit');
			$this->render('/features/individual_dn_edit');
		}
		if($featureType == 'SIMRING'){
			$this->layout ='ajax';
			#Configure::write('debug',0);
			$this->render('/features/simring_edit');
		}
		if($featureType == 'AUD'){
			$cond1 = array('Location.customer_id' => $customer_id);
			$cond1 = array_merge($cond1, array('Dns.function IS NOT NULL'));
			
			#Get a lis tof all blg with 8.
			
			$excludeBlfArray = $this->Feature->excludeObservers($customer_id);
			#$results_array=print_r($excludeBlfArray, true);
			#$this->log("Station controller : BLF : $results_array", LOG_DEBUG);
			$excludeBlfDn = array('12345678987654321', '12345678987654322');
			foreach ($excludeBlfArray as $excludeBlf)
			{
				array_push($excludeBlfDn, $excludeBlf['f']['primary_value']);
			}
			$cond1 = array_merge($cond1, array('Dns.id NOT' => $excludeBlfDn, 'Dns.function' => 'INDIVIDUAL'));
			
			
			
			$results = $this->Dns->find('all', array('order' => 'Dns.id asc', 'conditions' => $cond1, 'group' => 'Dns.id', 'fields' => array('Dns.*,Location.name')));
			
			$statoinLocaton = $this->Dns->find('all', array('order' => 'Dns.id asc', 'conditions' =>array('Location.customer_id' => $customer_id,'Dns.id'=>$station_id), 'group' => 'Dns.id', 'fields' => array('Location.name')));
			
			
			
			#echo "<pre>";print_r($results);
			foreach ($statoinLocaton as $statoinLoc)
			{
				
				$dnsLocationName = $statoinLoc['Location']['name'];
			}
			#echo "<pre>";print_r($statoinLocaton);
			
			$blfDns[''] = '';
			foreach ($results as $result)
			{
				$blfDns[$result['Dns']['id']] = $result['Dns']['id'];
				//$dnsLocationName = $result['Location']['name'];
			}
			
			//$results = $this->paginate('Dns');
			//pr($results);die;
			$this->set('blfDns', $blfDns);
			$this->set('results', $results);			
			$this->set('dnsLocationName', $dnsLocationName);
			
			$this->layout ='ajax';
			#Configure::write('debug',0);
			$this->render('/features/uf_edit');
			
		}
		if($featureType == 'BLF'){
				
				
			$stationinfo = $this->Stationkey->find('all', array (
					'conditions' => array (
							"Stationkey.status" => Configure :: read('status'),
							'Stationkey.station_id' => $station_id
					),
					'order' => 'Stationkey.keynumber'
			));
				
		
			$cond1 = array('Location.customer_id' => $customer_id);
			$cond1 = array_merge($cond1, array('Dns.function IS NOT NULL'));
			
			
			#Get a lis tof all blg with 8.
				
			$excludeBlfArray = $this->Feature->excludeObservers($customer_id);
			#$results_array=print_r($excludeBlfArray, true);
			#$this->log("Station controller : BLF : $results_array", LOG_DEBUG);
			$excludeBlfDn = array('12345678987654321', '12345678987654322');
			foreach ($excludeBlfArray as $excludeBlf)
			{
				array_push($excludeBlfDn, $excludeBlf['f']['primary_value']);
			}
			$cond1 = array_merge($cond1, array('Dns.id NOT' => $excludeBlfDn, 'Dns.function' => 'INDIVIDUAL'));
			
			
			$results = $this->Dns->find('all', array('order' => 'Dns.id asc', 'conditions' => $cond1, 'group' => 'Dns.id', 'fields' => array('Dns.*,Location.name')));
				
				$statoinLocaton = $this->Dns->find('all', array('order' => 'Dns.id asc', 'conditions' =>array('Location.customer_id' => $customer_id,'Dns.id'=>$station_id), 'group' => 'Dns.id', 'fields' => array('Location.name')));
			
			
			#echo "<pre>";print_r($results);
			foreach ($statoinLocaton as $statoinLoc)
			{
				$dnsLocationName = $statoinLoc['Location']['name'];
			}
			#$blfDns[''] = '';
			# $results = $this->Dns->find('all', array('conditions' => $cond, 'fields' => array('Dns.*,Location.name,Location.id'), 'group' => 'Dns.id', 'order' => 'Location.name asc'));
			#foreach ($results as $result)
			#{
			#	$blfDns[$result['Dns']['id']] = $result['Dns']['id'];
			#	$dnsLocationName = $result['Location']['name'];
			#}
			
			//$results = $this->paginate('Dns');
			//pr($results);die;
			#$this->set('blfDns', $blfDns);
			$this->set('results', $results);
			
			#echo "<pre>";print_r($results);
						
			$this->set('dnsLocationName', $dnsLocationName);
			
			
			
			#blf_val contains the stationkeys that actually have BLF enabled.
		
			
			$blf_observers = $this->Feature->returnObservers($stationFeatures['BLF']['primary_value']);
			
          
			
			#$results_array=print_r($blf_val, true);
			#$this->log("Station controller : BLF : $results_array", LOG_DEBUG);
			
			$this->set('observers', $blf_observers);
			$results_array=print_r($observers, true);
			$this->log("Station controller : BLF : $results_array", LOG_DEBUG);
					
				$this->layout ='ajax';
				#Configure::write('debug',0);
				
				$this->render('/features/uf_edit');
		}
		
	}



	/**
	 * edit()
	 * displays a single Customer and all related stations
	 * url: /formats/view/Customer_slug
	 */
	function updateDN($stationkey_id = null) {
		
		$this->autoRender = false;
		   
		#$stationkey_id=isset($this->params['url']['stationkey_id'])?$this->params['url']['stationkey_id']:(isset($this->params['named']['stationkey_id'])?$this->params['named']['stationkey_id']:"");
		$this->log('FEATURES CONTROLLER : UPDATE  => STATIONKEY_ID ' . $stationkey_id, LOG_DEBUG);

	
		$stationkeyDetails = $this->Stationkey->find('all', array (
				'conditions' => array (
						'Stationkey.id' => $stationkey_id
				)
		));
		
		
		$station_id = $stationkeyDetails[0]['Stationkey']['station_id'];
		
		$stationInfo = $this->Station->find('first', array (
				'conditions' => array (
						'Station.id' => $station_id,
		
				),
		
		));
		
		if(($station_id != '') && ($stationInfo['Station']['status'] != 5))
		{
			$this->log('FEATURES CONTROLLER : updateDN : Creating ASIS MODELS ', LOG_DEBUG);
			$createAsis = $this->Station->createAsisStation($station_id);
			$this->log('editstation page ' . 'Attempting top create asis ' . $createAsis, LOG_DEBUG);
			$createAsis = $this->Station->createAsisStationKeys($station_id);
			$this->log('editstation page ' . 'Attempting top create asis ' . $createAsis, LOG_DEBUG);
			$createAsis = $this->Station->deleteAsisFeatures($station_id);
			$this->log('editstation page ' . 'Attempting top create asis ' . $createAsis, LOG_DEBUG);
			$createAsis = $this->Station->createAsisFeatures($station_id);
			$this->log('editstation page ' . 'Attempting top create asis ' . $createAsis, LOG_DEBUG);
		}
		
		#Fid existing features
		$stationFeaturesSource = $this->Feature->find('all', array (
				'conditions' => array (
						'Feature.stationkey_id' => $stationkey_id
				)
				,'order' => array (
						'Feature.id',
				),
		));
		foreach($stationFeaturesSource as $keyfeature)
		{
			$shortName = $keyfeature['Feature']['short_name'];
			$existingFeature[$shortName] = $keyfeature['Feature']['primary_value'];
		
		}

		
		
		$postedFeatures = $this->data['Station'];
		
		$condition_array=print_r($postedFeatures, true);
		$this->log("FEatures controller : posted FEatures : $condition_array", LOG_DEBUG);
		
		#Calcualte NCOS
		$bar_ncos = Configure :: read('NCOS-BARRINGSET');
		$lang_ncos = Configure :: read('NCOS-LANGUAGE');
		$lead_ncos = Configure :: read('NCOS-LEADING');
		$lang = '';
		$barset = '';
		$lead = '';
		
		$this->log('FEATURES CONTROLLER : NCOS VALUES' .$postedFeatures['LANG'] .$postedFeatures['BARRINGSET'] . $postedFeatures['LEADINGZERO']  , LOG_DEBUG);
		
		$lang = $lang_ncos[strtoupper($postedFeatures['LANG'])];
		$barset = $bar_ncos[$postedFeatures['BARRINGSET']];
		$lead = $lead_ncos[$postedFeatures['LEADINGZERO']];
		$this->log('FEATURES CONTROLLER : NCOS VALUES' .$lang . ' + ' . $barset . ' + ' .  $lead  , LOG_DEBUG);
		
		$calculated_ncos = $lang + $barset + $lead;
		#$postedFeatures['NCOS'] = $calculated_ncos;
		$postedFeatures['NCOS'] = strval($calculated_ncos);
		$this->log('FEATURES CONTROLLER : NCOS CALCULATED:' .$calculated_ncos  , LOG_DEBUG);
		
		
		foreach ($postedFeatures as $feat => $val) {
	

		
			$this->log('FEATURES CONTROLLER : UPDATE  FEATURE => VALUE ' . $feat . ' ' . $val, LOG_DEBUG);
			$featureId = $stationkey_id . '-' . $feat;
			if ((substr($feat, 0, 6) != 'IGNORE') && (isset($val)))
			{
						
							$this->log('FEATURES CONTROLLER : FORM VARS' . $feat . 'NEW : ' . $val . 'OLD:' . $existingFeature[$feat] , LOG_DEBUG);
							# Minor Change...
							
							#??? Temporary code to change CFxStatus values from 0/1 to A/I. Check if htis can be replaced in the Cnfig with Xpath replac
							
							
							
							#if the submitted value = '' and does not exist in the DB then ignore.
							if((($val == '') || ($val == '0' )) && (! array_key_exists($feat, $existingFeature)))
							{
										$this->log('FEATURES CONTROLLER : IGNORING : BLANK AND DOES NOT EXIST : ' . $feat . ' : ' . $val, LOG_DEBUG);
					
							}
							else
							{
								
								
								if(($feat == 'CFUSTATUS') || ($feat == 'CFBSTATUS') || ($feat == 'CFNASTATUS'))
								{
									$val = ($val) ? 'A' : 'I';
								}
								if(($val == '') && ($feat == 'DISPLAYNAME'))
								{
									$val = '_';
								}
								
								if($val !==	 $existingFeature[$feat]) 
								{
									$modifiedFlag = 1;
									$this->log('FEATURES CONTROLLER : MODIFIED:' .$val . ':' .  $existingFeature[$feat] . ': UPDATING : ' . $feat . ' : ' . $val, LOG_DEBUG);
										
									
									
									
								#Save to DB
	               
	        	              		$featsave['Feature']['id'] = $featureId;
	            	          		$featsave['Feature']['stationkey_id'] = $stationkey_id;
	                	      		$featsave['Feature']['short_name'] = $feat;
	                    	  		$featsave['Feature']['primary_value'] = $val;
	                      			$featsave['Feature']['status'] = 4;
	                     	 		//$featUpdate = $this->Feature->save($featsave, false,  array('id','primary_value', 'stationkey_id', 'short_name', 'status'));
						  			
	                     	 		if ($featUpdate = $this->Feature->save($featsave, true,  array('id','primary_value', 'stationkey_id', 'short_name', 'status'))) 
	                     	 		{
	 
						       		} else {                      			
						       			$response['failure'] = $this->Feature->validationErrors;
											if (!empty($response['failure']) && is_array($response['failure'])) {
												foreach($response['failure'] as $error) {
													$response['failure'] = $error;
													break;
												}
											}
											//echo "jdhfjhdjfhdjfhjdh";		
											echo "false";
											//return $response['failure'];
											exit;
						       		}
						       		//echo "false";
						       		//exit;
	
	
						  			if($featsave['Feature']['short_name'] == 'DISPLAYNAME')
								 	{								 	
							 		    $dnsave['Dns']['id'] = $postedFeatures['DN'];
	                        	       	$dnsave['Dns']['display'] = $postedFeatures['DISPLAYNAME'];
	                            	   	$dnsave['Dns']['modified'] = false;
	                               		$dnUpdate = $this->Dns->save($dnsave, false,  array('display'));
								    }
								    
								    #Handle blank value based deletes for certain features.
								    								    
								    /*if((array_key_exists('HNTID', $existingFeature) && ($feat == 'CFBSTATUS') || ($feat == 'CFNASTATUS')))
								    {
								    	$this->log('FEATURES CONTROLLER : HUNT GROUP CALL FORWARDING STATUS CHANGE:', LOG_DEBUG);
								    	
								    	if($val == 'I')
								    	{
								    		$this->log('FEATURES CONTROLLER : HUNT GROUP STATUS CHANGE TO INACTIVE:', LOG_DEBUG);
								    		preg_match("/(.*)STATUS/", $feat, $matches);
								    		if ($matches[1]) {
								    			$huntFeat = $stationkey_id . '-' . $matches[1] . 'NUMBER';
								    			$this->log('FEATURES CONTROLLER : HUNT GROUP STATUS = I => ACTUALLY DELETED!:' .$huntFeat, LOG_DEBUG);
								    			$delete = array (
								    				'Feature.id' => $huntFeat
								    		
								    			);
								    		
								    			if($featureId != '')
								    			{
								    				$this->log('FEATURES CONTROLLER : Deleteing Feature :' .$huntFeat, LOG_DEBUG);
								    				$this->Feature->deleteAll($delete);
								    				
								    				$featuresave['CFeature']['status'] = '7';
								    				$featuresave['CFeature']['id'] = $huntFeat;
								    				
								    				$featureres = $this->CFeature->save($featuresave, false,  array('id','status'));
								    			}
								    		}
								    	}
								    	else {
								    		$this->log('FEATURES CONTROLLER : HUNT GROUP HERE:' .  $val, LOG_DEBUG);
								    	}
								    
								    }
								    if((array_key_exists('HNTID', $existingFeature) && ($feat == 'CFBNUMBER') || ($feat == 'CFNANUMBER')))
								    {
								    	$this->log('FEATURES CONTROLLER : HUNT GROUP CALL FORWARDING NUMBER CHANGE:', LOG_DEBUG);
								    		
								    	if($val != '')
								    	{
								    		$this->log('FEATURES CONTROLLER : HUNT GROUP STATUS CHANGE TO INACTIVE:', LOG_DEBUG);
								    		preg_match("/(.*)NUMBER/", $feat, $matches);
								    		if ($matches[1]) {
								    			$huntFeat = $stationkey_id . '-' . $matches[1] . 'STATUS';
								    			$this->log('FEATURES CONTROLLER : HUNT GROUP STATUS = I => ACTUALLY DELETED!:' .$huntFeat, LOG_DEBUG);
								    			$delete = array (
								    					'Feature.id' => $huntFeat
								    
								    			);
								    			$featsave['Feature']['id'] = $huntFeat;
								    			$featsave['Feature']['stationkey_id'] = $stationkey_id;
								    			$featsave['Feature']['short_name'] = $matches[1] . 'STATUS';
								    			$featsave['Feature']['primary_value'] = 1;
								    			$featsave['Feature']['status'] = 4;
								    			
								    		
								    		}
								    	}
								    	else {
								    		$this->log('FEATURES CONTROLLER : HUNT GROUP HERE:' .  $val, LOG_DEBUG);
								    	}
								    
								    }
								    
								    */
								    if(($feat == 'SDNA'))
								    {
								    	if($val == '0')
								    	{
								    		$this->log('FEATURES CONTROLLER : => ACTUALLY DELETED!:' .$val, LOG_DEBUG);
								    		$delete = array (
								    				'Feature.id' => $featureId
								    		);
								    		if($featureId != '')
								    		{
								    			$this->log('FEATURES CONTROLLER : Deleteing Feature :' .$featureId, LOG_DEBUG);
								    			$this->Feature->deleteAll($delete);
								    			
								    			$featuresave['CFeature']['status'] = '7';
								    			$featuresave['CFeature']['id'] = $featureId;
								    			
								    			$featureres = $this->CFeature->save($featuresave, false,  array('id','status'));
								    		}
								    	}
								    }
								    if($feat == 'MSBMEMBER')
								    {
								    		#Count status of all members
											$MEMBER = '%@' . $station_id . '-MSBMEMBER';
											
											$dnCount = $this->Feature->find('count',array('conditions'=>array('Feature.id like' => $MEMBER, 'Feature.id not like' => '01@%', 'Feature.primary_value' => 1)));
											$this->log('FEATURES CONTROLLER :calculateMSBCount : Count of Active MSB Members:' . $dnCount, LOG_DEBUG);
										
											if ($dnCount == 0)
											{
												#If MSB requires a delete then dont generate an update command for MSB Member
												$featsave['Feature']['id'] = $featureId;
												$featsave['Feature']['stationkey_id'] = $stationkey_id;
												$featsave['Feature']['short_name'] = $feat;
												$featsave['Feature']['primary_value'] = $val;
												$featsave['Feature']['status'] = 1;
												//$featUpdate = $this->Feature->save($featsave, false,  array('id','primary_value', 'stationkey_id', 'short_name', 'status'));
													
												$featUpdate = $this->Feature->save($featsave, true,  array('id','primary_value', 'stationkey_id', 'short_name', 'status'));
												
												
												$feature_id = '%@'. $station_id . '-MSB';
													$this->log('FEATURES CONTROLLER :calculateMSBCount : Deleting MSB for station' . $station_id, LOG_DEBUG);
													$this->Feature->updateAll(array('Stationkey.status' =>7), array('Feature.id like' => $feature_id));
													$this->Feature->deleteAll(array('Feature.id like' => $feature_id));
													
											
											}
											
											#For MSB delete the feature rather than only set to 0. This is to make sure when MSB is readded that the 0 is not remembered for sendingkeylist
											if ($val == 0)
											{
												$this->Feature->deleteAll(array('Feature.stationkey_id' => $stationkey_id, 'Feature.short_name' => 'MSBMEMBER'), false);
											}
											
											
											
											
								    }
								    
								}	     
							}
						#}     

					}

            }
            if($modifiedFlag == 1)
            {
            	            
	            $stationsave['Station']['id'] = $stationkeyDetails[0]['Stationkey']['station_id'];

	            $stationsave['Station']['status'] ='5';

	            $stationUpdate = $this->Station->save($stationsave, false,  array('id', 'status'));
	            
	            $this->Session->write('log_entry', 'Station Updated : DN Features ');
	            	
	            //echo "true";
	            
	            
	            #####################----------------------------#######################
	            ###                         CALL APPLY AUTOMATICALLY                 ###
	            ########################################################################
	            
	            
	            $requestAction = 'stations/apply/'.$stationkeyDetails[0]['Stationkey']['station_id'];
	            $this->log('FEATURE CONTROLLER : CALLING : ' . $requestAction, LOG_DEBUG);
	            $activationResponse = $this->requestAction($requestAction);
	            
	            #App::import('Controller', 'Stations');
	            #$this->Stations = new StationsController();
	            #$Stations->constructClasses();
	            #$this->log('FEATURE CONTROLLER : calling Apply ', LOG_DEBUG);
	            #$activationResponse = $this->Stations->apply($stationkeyDetails[0]['Stationkey']['station_id']);
	            
	          #  $this->log('FEATURE CONTROLLER : CALCULATELAYOUT : APPLY RETURNED ' . $activationResponse, LOG_DEBUG);
	            #return($activationResponse);
	            #$activationResponse = $this->Log->field('modification_response', array (
	            #		'id =' => $activationResponse
	            #));
	            
	            
	            $logReapplyData = $this->Log->find('first', array (
	            'conditions' => array (
	            'Log.id' => $activationResponse,
	            
	            ),
	            
	            ));
	            $transactionId = $logReapplyData['Log']['transaction_id'];
	            #If fails and there is REAPPLY in the log then send reapply to the view.
	            preg_match("/REAPPLY/", $logReapplyData['Log']['modification_response'], $matches);
	            if (($logReapplyData['Log']['modification_response'] == 0) && ($matches[0])) {
	            	$this->log('FEATURE CONTROLLER : CALCULATELAYOUT : APPLY RETURNED REAPPLY!! ' . $activationResponse, LOG_DEBUG);
	            	echo "REAPPLY"."-".$transactionId."-".$station_id;
	            }
	            else
	            {
	        
		            $this->log('FEATURE CONTROLLER : CALCULATELAYOUT : APPLY RETURNED OK!! ' . $activationResponse, LOG_DEBUG);
		            #echo "$activationResponse";
					#$transactionId = '0888112532';
		            echo "DONE"."-".$transactionId."-".$station_id;
	            }
            }
            else {
				#echo "REAPPLY";
				$this->set('station_id',$station_id);
				
            	$this->log('FEATURE CONTROLLER : NO MODIFICATIONS!!' . $activationResponse, LOG_DEBUG);
            }
            
            
            exit;
            
                #$returnDNList=isset($this->params['url']['returnDNList'])?$this->params['url']['returnDNList']:(isset($this->params['named']['returnDNList'])?$this->params['named']['returnDNList']:"");
                
                #if($returnDNList == 'true')
                #{
                #	$this->redirect('/customers');
                	
                #}
                #else {
					exit();
            #    }
				
		 
		 
		
		
		
								
	
	}
	
	
	
	/**
	* Update groupDescription
	* 
	* @return
	*/
	
	function updateGroupDescription($groupid = null){
		$this->autoRender = false;
		
		 $groupid = isset($this->params['url']['group_id']) ? $this->params['url']['group_id'] : (isset($this->params['named']['group_id']) ? $this->params['named']['group_id'] : "");
		
		$groupdesc = isset($this->params['url']['groupdesc']) ? $this->params['url']['groupdesc'] : (isset($this->params['named']['groupdesc']) ? $this->params['named']['groupdesc'] : "");
		
				
		$dataarray['Group']['desc'] = $groupdesc;
		$dataarray['Group']['id'] = $groupid;
		
		$update = $this->Group->save($dataarray);		
				
	}
	
	
	
	// new function 1 May 2014 update observer number
	function updateobserver ($numberValue = null){
		 $this->layout = "";
		 
		 //echo $numberValue;
		 	
		/*$stationkeyDetails = $this->Stationkey->find('all', array (
				'conditions' => array (
						'Stationkey.id' => $stationkey_id
		)
		));
		$station_id = $stationkeyDetails[0]['Stationkey']['station_id'];
		
		$stationInfo = $this->Station->find('first', array (
				'conditions' => array (
						'Station.id' => $station_id,
		
				),

		));
		
		#Fid existing features
		$stationFeaturesSource = $this->Feature->find('all', array (
		'conditions' => array (
		'Feature.stationkey_id' => $stationkey_id
		)
		,'order' => array (
		'Feature.id',
		),
		));
		$featureCount = 0;
		foreach($stationFeaturesSource as $keyfeature)
		{
			$shortName = $keyfeature['Feature']['short_name'];
			$existingFeature[$shortName] = $keyfeature['Feature']['primary_value'];
			$featureCount++;
		
		}		
				
		$postedFeatures = $this->data['Station'];
		$featureId = $stationkey_id . '-' . $postedFeatures['TYPE'];
		
		# Minor Change...
		#if features are different

		$numberValue = $postedFeatures['TYPE'] . '_NUMBER';
		$featsave['Feature']['id'] = $featureId;
		$featsave['Feature']['stationkey_id'] = $stationkey_id;
		$featsave['Feature']['short_name'] = $postedFeatures['TYPE'];
		$featsave['Feature']['primary_value'] = $postedFeatures[$numberValue];
		$featsave['Feature']['label'] = $postedFeatures['LABEL'];
		$featsave['Feature']['status'] = $status;
		$featUpdate = $this->Feature->save($featsave, false,  array('id','primary_value', 'stationkey_id', 'short_name','label', 'status'));
				
		$stationsave['Station']['id'] = $stationkeyDetails[0]['Stationkey']['station_id'];
		$stationsave['Station']['status'] = 5;
		$stationUpdate = $this->Station->save($stationsave, false,  array('id', 'status'));*/

	
		$blf_observers = $this->Feature->returnObservers($numberValue);			
	    $this->set('observers', $blf_observers);
		
	}
	
	
	
	
	
	function updateUF($stationkey_id = null) {
	
	
		#$stationkey_id=isset($this->params['url']['stationkey_id'])?$this->params['url']['stationkey_id']:(isset($this->params['named']['stationkey_id'])?$this->params['named']['stationkey_id']:"");
		$this->log('FEATURES CONTROLLER : UPDATE  => STATIONKEY_ID ' . $stationkey_id, LOG_DEBUG);
		
		$stationkeyDetails = $this->Stationkey->find('all', array (
				'conditions' => array (
						'Stationkey.id' => $stationkey_id
		)
		));
		$station_id = $stationkeyDetails[0]['Stationkey']['station_id'];
		
		$stationInfo = $this->Station->find('first', array (
				'conditions' => array (
						'Station.id' => $station_id,
		
				),

		));
		
		#Fid existing features
		$stationFeaturesSource = $this->Feature->find('all', array (
		'conditions' => array (
		'Feature.stationkey_id' => $stationkey_id
		)
		,'order' => array (
		'Feature.id',
		),
		));
		$featureCount = 0;
		foreach($stationFeaturesSource as $keyfeature)
		{
			$shortName = $keyfeature['Feature']['short_name'];
			$existingFeature[$shortName] = $keyfeature['Feature']['primary_value'];
			$featureCount++;
		
		}
		$condition_array=print_r($existingFeature, true);
		$this->log("FEatures controller : existing FEatures : $condition_array", LOG_DEBUG);
		
		
		if(($station_id != '') && ($stationInfo['Station']['status'] != 5))
		{
			
			$createAsis = $this->Station->createAsisStation($station_id);
			$this->log('editstation page ' . 'Attempting top create asis ' . $createAsis, LOG_DEBUG);
			$createAsis = $this->Station->createAsisStationKeys($station_id);
			$this->log('editstation page ' . 'Attempting top create asis ' . $createAsis, LOG_DEBUG);
			$createAsis = $this->Station->deleteAsisFeatures($station_id);
			$this->log('editstation page ' . 'Attempting top create asis ' . $createAsis, LOG_DEBUG);
			$createAsis = $this->Station->createAsisFeatures($station_id);
			$this->log('editstation page ' . 'Attempting top create asis ' . $createAsis, LOG_DEBUG);
		}
		$postedFeatures = $this->data['Station'];
		$posted_print = print_r($postedFeatures, true);
		
		$this->log('FEATURES CONTROLLER : posted features ' . $posted_print, LOG_DEBUG);
		
		$this->log('FEATURES CONTROLLER : UPDATE  FEATURE => VALUE ' . $feat . ' ' . $val, LOG_DEBUG);
		$featureId = $stationkey_id . '-' . $postedFeatures['TYPE'];
		
		# Minor Change...
		#if features are different

		$numberValue = $postedFeatures['TYPE'] . '_NUMBER';
		
		$this->log('FEATURES CONTROLLER : Checking values for :' .$numberValue, LOG_DEBUG);
		
		
		if(!array_key_exists($postedFeatures['TYPE'], $existingFeature))
		{
			if($featureCount == 0)
			{
				$this->log('FEATURES CONTROLLER : ADDED : WITH : ' . $postedFeatures['TYPE'], LOG_DEBUG);
				#Set value for later use in log.
				
				$this->Session->write('log_entry', 'Station Updated : Add ' . $postedFeatures['TYPE']);
				
				$status = '6'; #ADD
				
				#Set stationkey to ADD
					
				$stationkeysave['Stationkey']['id'] = $stationkeyDetails[0]['Stationkey']['id'];
				$stationkeysave['Stationkey']['status'] = 6;
				$stationUpdate = $this->Stationkey->save($stationkeysave, false,  array('id', 'status'));
			}
			else
			{
				$this->log('FEATURES CONTROLLER : REPLACED : WITH : ' . $postedFeatures['TYPE'], LOG_DEBUG);
				
				$this->Session->write('log_entry', 'Station Updated : Add ' . $postedFeatures['TYPE']);
				
				$status = '8'; #REPLACE
			

			
				#Set stationkey to replace
			
				$stationkeysave['Stationkey']['id'] = $stationkeyDetails[0]['Stationkey']['id'];
				$stationkeysave['Stationkey']['status'] = 5;
				$stationUpdate = $this->Stationkey->save($stationkeysave, false,  array('id', 'status'));
				
				$delete = array (
						'Feature.stationkey_id' => $stationkey_id
				);
				if($stationkey_id != '')
				{
					$this->log('FEATURES CONTROLLER : Deleteing all existing features on key :' .$stationkey_id, LOG_DEBUG);
					$this->Feature->deleteAll($delete);
				}
			}
		}	
		else
		{
			
			#???Currently no check to see all values are different or not, just a blind deploy
			$status = '4'; #UPDATE
			$this->log('FEATURES CONTROLLER : VALUE UPDATE FOR: ' . $postedFeatures['TYPE'], LOG_DEBUG);
			
			$this->Session->write('log_entry', 'Station Updated : Update ' . $postedFeatures['TYPE']);
			
		}
		$featsave['Feature']['id'] = $featureId;
		$featsave['Feature']['stationkey_id'] = $stationkey_id;
		$featsave['Feature']['short_name'] = $postedFeatures['TYPE'];
		$featsave['Feature']['primary_value'] = $postedFeatures[$numberValue];
		$featsave['Feature']['label'] = utf8_decode($postedFeatures['LABEL']);
		#$featsave['Feature']['label'] = $postedFeatures['LABEL'];
		$featsave['Feature']['status'] = $status;
		$featUpdate = $this->Feature->save($featsave, false,  array('id','primary_value', 'stationkey_id', 'short_name','label', 'status'));
		
		
		
		$stationsave['Station']['id'] = $stationkeyDetails[0]['Stationkey']['station_id'];
		$stationsave['Station']['status'] = 5;
		$stationUpdate = $this->Station->save($stationsave, false,  array('id', 'status'));

		
		#####################----------------------------#######################
		###                         CALL APPLY AUTOMATICALLY                 ###
		########################################################################
		
		#Call with timestamp used for feature calcualtion
		$requestAction = 'stations/apply/'.$station_id;
		$this->log('FEATURE CONTROLLER : CALLING : ' . $requestAction, LOG_DEBUG);
        $activationResponse = $this->requestAction($requestAction);
		$this->log('FEATURE CONTROLLER : CALCULATELAYOUT : APPLY RETURNED ' . $activationResponse, LOG_DEBUG);
        #return($activationResponse);
        echo "$activationResponse";
		
		exit();
	
	}




	/**
	 * function for uploading file
	 *
	 */
	
	

	
	
	function export()
	{
		$this->layout = ""; 
		
		$conds = unserialize($this->Session->read('cond'));
		
		$filename = "export_scenarios_".date("Y.m.d").".csv";
		$csv_file = fopen('php://output', 'w');
		header('Content-type: application/csv');
		header('Content-Disposition: attachment; filename="'.$filename.'"');
		$customer_id = 'HEIN'; # TESTING
		$scenarioResults = $this->Scenario->find('all',array('recursive'=>'2', 'fields' => array('Scenario.id', 'Scenario.Name', 'Scenario.state' ),'order'=>'Scenario.id ASC','conditions' => $conds));
		
		#$executionResults = $this->Execution->find('all',array('fields' => array('Execution.operation', 'Execution.targetDate', ),'conditions' => array('Scenario.customer_id' => $customer_id ))); 
		$header_row = array("S.No.", "Scenario_Name", "Scenario_Status", "Operation", "TargetDate", "Execution status" );
		fputcsv($csv_file,$header_row,';','"');
	
		// Each iteration of this while loop will be a row in your .csv file where each field corresponds to the heading of the column
		$i=1;
		foreach($scenarioResults as $result)
		{
			
			// Array indexes correspond to the field names in your db table(s)

				foreach ($result['Execution'] as $execResult)
				{
					
					#print_r($execResult);
					
					$row = array(
					$result['Scenario']['Sno']= $i,
					$result['Scenario']['Name'],
					$result['Scenario']['state'],
					$execResult['operation'],
					$execResult['targetDate'],
					$execResult['status'],
					);
					$i++;
					fputcsv($csv_file,$row,';','"');
				}

		}
	
		fclose($csv_file);exit();
	}
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
	
	function calculateMADNLowestLen($groupId) {
		$this->log('STATIONS CONTROLLER :CALCULATE CPULEN ' . $groupId, LOG_DEBUG);
			
		#Find all LEN's for members of group.
	
		#$groupMemberStations = $this->Feature->find('all',array('fields'=>array('Stationkey.station_id','Stationkey.id', 'Feature.primary_value'),'conditions'=>array('Feature.short_name'=> array('cpu'), 'Feature.primary_value'=>$groupDetails['Group']['id'])));
	
		$groupMembers = $this->Group->find('all',
				array(
				'fields' => array(
				'Group.id',
				'Stationkey.id',
				'Station.id',
				'Station.port'
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
								)
						),
						'conditions' => array('Feature.primary_value'=>$groupId, 'Feature.short_name'=> array('MADN'))
	
				)
		);
	
	
	
	
	
			foreach ($groupMembers as $groupMemberStation)
			{
				$this->log('FEATURES CONTROLLER :MADN LOWEST LEN ' . $groupMemberStation['Stationkey']['id'] . ':' . $groupMemberStation['Station']['port'], LOG_DEBUG);
								
				#store in a hash with LEN and stripped LEN.
				$STATIONLENConverted = preg_replace("/[A-Za-z ]/", '', $groupMemberStation['Station']['port']);
				$lenArray[$STATIONLENConverted] = $groupMemberStation['Stationkey']['id'];
								
			}
	
	
			#sort by stripped LEN''s
			ksort($lenArray);
			$condition_array=print_r($lenArray, true);
			$this->log("FEATURE controller : SORTED ARRAY : $condition_array", LOG_DEBUG);
			#return last in array
	
			$madnLen = reset($lenArray);
	
			$this->log('STATIONS CONTROLLER :MADN LEN : LOWEST LEN ' . $madnLen, LOG_DEBUG);
			
			return $madnLen;
		}
		
		

}
?>
