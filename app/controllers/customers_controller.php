<?php

#-----------------------------------------------------------------#
# $Rev:: 22            $:  Revision of last commit                #
#-----------------------------------------------------------------#

/**
 * Customers Controller
 *
 * file: /app/controllers/Customers_controller.php
 */
	#var $header_string = 'Customers';
class CustomersController extends AppController {
	// good practice to include the name variable
	var $uses 	= array('Customer', 'Location', 'Dns', 'Scenario', 'Mediatrix', 'Log', 'Trunk', 'Station', 'Port', 'Feature','Group');
	var $name 	= 'Customers';
	var $paginate = array('Paginate' => 25, 'page' => 1);
	var $components = array (
			'TransferMoh'
	);
	#var $paginate = array('Paginate' => 15, 'page' => 1, 'order' => array('Customer.name' => 'asc'));
	
	
	// load any helpers used in the views
	var $helpers = array('Html', 'Form', 'Javascript');

	
	function beforeFilter (){
		$cameFrom = $this->here;
		$this->log("Customer controller : Start of before_filter, came from : " . $cameFrom, LOG_DEBUG);
		#preg_match("/\/apply\//", $cameFrom, $matches);
		#if ($matches[0]) {
		#	$this->log('STATION CONTROLLER : NOT REDIRECTING CAME FROM ' . $cameFrom, LOG_DEBUG);
		#}
		
		# echo "<pre>"; print_r($this->Session->read());
		
		
		
		$this->log("Customer controller : Start of before_filter", LOG_DEBUG);
		$this->Session->write('sel_customer','');
		parent::beforeFilter();
		if(!$this->Session->read('SELECTED_CUSTOMER')){
			$this->layout='ajax';
			$this->cakeError('sessionExpired'); 
		}
		
	}
	
	
	
	function updatedcounts($SELECTED_CNN = null){
		#$Sess_Array = print_r($_SESSION, true);
		$this->log("Customer controller : counts function for customer " . $SELECTED_CNN, LOG_DEBUG);
		
		$custString = "'" . $SELECTED_CNN . "'";
		$menuCounts =       $this->Customer->countGen($custString);
		
		$g_array=print_r($menuCounts, true);
		$this->log("Customer controller : customer	base array" .  $g_array, LOG_DEBUG);
		foreach ($menuCounts as $menuCount)
		{
			$mCounts[$menuCount['l']['customer_id']]['trunkcount']=$menuCount[0]['trunkcount'];
			$mCounts[$menuCount['l']['customer_id']]['stationcount']=$menuCount[0]['stationcount'];
			$mCounts[$menuCount['l']['customer_id']]['groupcount']=$menuCount[0]['groupcount'];
			$mCounts[$menuCount['l']['customer_id']]['mediatrixcount']=$menuCount[0]['mediatrixcount'];
			$mCounts[$menuCount['l']['customer_id']]['onDemand']=$menuCount['c']['onDemand'];
			$mCounts[$menuCount['l']['customer_id']]['type']=$menuCount['c']['type'];
		}
		#$g_array=print_r($mCounts, true);
		#$this->log("Customer controller : customer	 array" .  $g_array, LOG_DEBUG);
		

			$counts['ODS'][$SELECTED_CNN] = $mCounts[$SELECTED_CNN]['onDemand'];
			$counts['Mediatrix'][$SELECTED_CNN] = $mCounts[$SELECTED_CNN]['mediatrixcount'];
			$counts['Trunks'][$SELECTED_CNN] = $mCounts[$SELECTED_CNN]['trunkcount'];
			$counts['Groups'][$SELECTED_CNN] = $mCounts[$SELECTED_CNN]['groupcount'];
			$counts['Stations'][$SELECTED_CNN] = $mCounts[$SELECTED_CNN]['stationcount'];
			$counts['Stations'][$SELECTED_CNN] = $mCounts[$SELECTED_CNN]['stationcount'];
			$counts['custType'][$SELECTED_CNN] = $mCounts[$SELECTED_CNN]['type'];
		
					#$Counts_Array = print_r($counts, true);
					#$this->log("Customer controller : counts function returning " . $Counts_Array, LOG_DEBUG);
					return $counts;
					#}
	}
	
	function calltoactioncounts($SELECTED_CNN = null){
		#$Sess_Array = print_r($_SESSION, true);
		if($SELECTED_CNN == '')
		{
			$this->log("Customer controller : calltoaction for global " . $SELECTED_CNN, LOG_DEBUG);
			$custFilter = array();
			$statcustFilter= array();
			$loccustFilter= array();
		}
		else
		{
			$this->log("Customer controller : calltoaction for specific customer: " . $SELECTED_CNN, LOG_DEBUG);
			#$custFilter = ;
			$custFilter = array('Scenario.customer_id'=>$SELECTED_CNN);
			$statcustFilter = array('Station.customer_id'=>$SELECTED_CNN);
			$loccustFilter = array('Location.customer_id'=>$SELECTED_CNN);
			
		}
			
			
		$odsValidations = $this->Scenario->find('all',
					array(
						'conditions' => array('Scenario.status'=>array(3),$custFilter),
						'order' => 'Scenario.customer_id'
					)
				);
		

		$calltoAction['ODSValidations'] = $odsValidations;

		$odsExceptions = $this->Scenario->find('all',
					array(
						'conditions' => array('Scenario.status'=>array(7),$custFilter),
							'order' => 'Scenario.customer_id'
					)
				);
		

		$calltoAction['ODSExceptions'] = $odsExceptions;
		
		$stationExceptions = $this->Station->find('all',
				array(
						'conditions' => array('Station.status'=>array(7),$statcustFilter),
						'order' => 'Station.customer_id'
				)
		);
		
		
		$calltoAction['STATIONExceptions'] = $stationExceptions;
		$trunkExceptions = $this->Trunk->find('all',
				array(
						'conditions' => array('Trunk.status'=>array(7),$loccustFilter),
						'order' => 'Location.customer_id'
				)
		);
		
		
		$calltoAction['TRUNKExceptions'] = $trunkExceptions;
		#$condition_array=print_r($calltoAction, true);
		#$this->log("Customer controller : calltoActionArray : $condition_array", LOG_DEBUG);
		
		return $calltoAction;
	}
	
	/**
	 * index()
	 * main index page of the formats page
	 * url: /formats/index
	 */
	function index() {
		$this->log("Customer controller : Start of Index", LOG_DEBUG);
		
		$this->pageTitle = 'Customer List';

		#CBM
		#If the Selected customer is not the same as the internal user (i.e Internal user) then redirect to user to the station index page
		if($this->Session->read('SELECTED_CUSTOMER')!=Configure::read('access_id')){
			//$this->layout='ajax';
			//$this->cakeError('accessDenied'); 
			
			$record =       $this->Customer->find('all', array('conditions'=>array("Customer.status"=>array(1,2,3),'Customer.bsk'=>$this->Session->read('SELECTED_CUSTOMER'))));
			if(empty($record) && Configure::read('access_id')!= $this->Session->read('SELECTED_CUSTOMER')){
			#$this->log("Some one trying to loggin with id ".$value['user_id']);
				$this->log("Invalid SSO data ".$this->Session->read('SELECTED_CUSTOMER'));
				$this->layout='ajax';
				$this->cakeError('accessDenied'); 
			}else{
				
					#Now Check the type of application (Gate/Phone)
					$this->log("Customer controller : Redirecting to DN Index", LOG_DEBUG);
					#$this->redirect('/stations/index/'.$record[0]['Customer']['id']);
					$this->redirect('/customers/edit/customer_id:'.$record[0]['Customer']['id']);
			
				
			}
			
			//$cnt	=	 count($this->_Filter);
			//$this->_Filter[$cnt] 			= "Customer.bsk=".$this->Session->read('SELECTED_CUSTOMER');
		}

		#END CBM



		$this->paginate['Paginate']	=	$this->AutoPaginate->setPaginate();
		$this->set('title_header', __('Swisscom Extranet Corporate Business - Voiphone Selfcare', true));	
		$this->Session->write('Customer.Name', 'UNDEF');
		$this->set('cust_for_layout', 'UNDEFINED');
		#$customerTypes = array(''=>'Select','Phone'=>'Phone', 'Gate'=>'Gate', 'Gate +'=>'Gate +', 'Hybrid'=>'Hybrid');
		#$this->set('customerTypes', $customerTypes);
		$this->Customer->recursive = 0;
		#Orignal working RE1
		#$cond = $this->_Filter;
		#$this->Session->write('cond',serialize($cond));
		#$this->set('customers', $this->paginate(null, $this->_Filter));
		#new for RE2
		
		$cond = array('Customer.status'=>1);
		$name=isset($this->params['url']['name'])?$this->params['url']['name']:(isset($this->params['named']['name'])?$this->params['named']['name']:"");
		if($name!=''){
			$cond = array_merge($cond,array('Customer.name LIKE'=>'%'.$name.'%'));
			$this->passedArgs['name'] = $name;
			
		}
		$id=isset($this->params['url']['cid'])?$this->params['url']['cid']:(isset($this->params['named']['cid'])?$this->params['named']['cid']:"");
		if($id!=''){
			$cond = array_merge($cond,array('Customer.id LIKE'=>'%'.$id.'%'));
			$this->passedArgs['cid'] = $id;
			
		}
		$type=isset($this->params['url']['type'])?$this->params['url']['type']:(isset($this->params['named']['type'])?$this->params['named']['type']:"");
		if($type!=''){
			$cond = array_merge($cond,array('Customer.type'=>$type));
			$this->passedArgs['type'] = $type;
				
		}
		$bsk=isset($this->params['url']['bsk'])?$this->params['url']['bsk']:(isset($this->params['named']['bsk'])?$this->params['named']['bsk']:"");
		if($bsk!=''){
			$cond = array_merge($cond,array('Customer.bsk LIKE'=>'%'.$bsk.'%'));
			$this->passedArgs['bsk'] = $bsk;
		}
		
		
		#Workaround to handle the customer id id being sent as a parameter.
		
		unset($this->_Filter['Customer.cid']);
		
		#-------------------------------------------------------------
		
		
		$this->paginate= array('conditions'=>$cond,'order' => 'Customer.name asc','limit' => $this->paginate['limit']);
		
		$condition_array=print_r($cond, true);
		$this->log("Customer controller : Setting sesion conditions : $condition_array", LOG_DEBUG);

		


		$this->Session->write('cond',serialize($cond));
		$customers_for_view = $this->paginate(null, $this->_Filter);
		$this->set('customers', $customers_for_view);
		
		$ids = array();
		#$g_array=print_r($groupMemberStations, true);
		#$this->log("Station controller : CPU Station array" .  $g_array, LOG_DEBUG);
		#$cids = array();
		foreach ($customers_for_view as $custIds)
		{
			#$g_array=print_r($custIds, true);
			#$this->log("Customer controller : customer	 array" .  $g_array, LOG_DEBUG);
			#$this->log('CUSTOMER CONTROLLER : CUSTOMERS ' . $custIds['Customer']['id'], LOG_DEBUG);
			#array_push($cids, $custIds['Customer']['id']);
			$cids .= "'" . $custIds['Customer']['id'] . "',";
		}
		$cids = rtrim($cids, ",");
		$menuCounts =       $this->Customer->countGen($cids);
		foreach ($menuCounts as $menuCount)
		{
			$mCounts[$menuCount['l']['customer_id']]['trunkcount']=$menuCount[0]['trunkcount'];
			$mCounts[$menuCount['l']['customer_id']]['stationcount']=$menuCount[0]['stationcount'];
			$mCounts[$menuCount['l']['customer_id']]['groupcount']=$menuCount[0]['groupcount'];
			$mCounts[$menuCount['l']['customer_id']]['mediatrixcount']=$menuCount[0]['mediatrixcount'];
			$mCounts[$menuCount['l']['customer_id']]['onDemand']=$menuCount['c']['onDemand'];
			$mCounts[$menuCount['l']['customer_id']]['type']=$menuCount['c']['type'];
		}
		#$g_array=print_r($mCounts, true);
		#$this->log("Customer controller : customer	 array" .  $g_array, LOG_DEBUG);
		$this->set('mCounts', $mCounts);
		
		

		$this->set('apptype', $this->Session->read('APPNAME'));
		
		$customertypes = $this->Customer->find('all', array('conditions' => array("Customer.status" => '1','Customer.type !='=>" "), 'group' => 'Customer.type'));
				
		$options=array();
		foreach($customertypes as $customertype){
			$custype = $customertype['Customer']['type'];
			$options[$custype]=$custype;
		}
						
		$this->set('customerTypes',$options);
		
		
		
	}
	
	function edit($customer_id = null) {
	
		$this->pageTitle = 'Customer Home';
       $this->layout = "default";	
	
		$customer_id=isset($this->params['url']['customer_id'])?$this->params['url']['group_id']:(isset($this->params['named']['customer_id'])?$this->params['named']['customer_id']:"");
		
			
		/**********for case of internal/external users********/
		if ($this->Session->read('SELECTED_CUSTOMER') != Configure :: read('access_id')) {
		
			$id = $this->Session->read('SELECTED_CUSTOMER');
		
			if (!$this->Customer->validCustomer($id,$customer_id)) {
				$this->log("Customer controller : Edit Function: Invalid customer:" . $id . ':' . $customer_id , LOG_DEBUG);
				$this->redirect('/customers');
				exit ();
			}
		
		}
		/**********************END*************************/
		
		
		$this->log('CUSTOMER CONTROLLER : EDIT  => GROUP_ID ' . $customer_id, LOG_DEBUG);
	
		#First Check for any updates to save
	
#		if(isset($this->data))
#		{
#			$this->log('CUSTOMER CONTROLLER : EDIT  => CUSTOMER_ID WITH POSTED DATA' . $customer_id, LOG_DEBUG);
#			$custsave['Customer']['id'] = $group_id;
#			$custsave['Customer']['something'] = $this->data['Customer']['something'];

#			$featUpdate = $this->Customer->save($custsave, false,  array('id','something'));
	
#		}
	
			#$grp_pilot = $this->Station->getPilotFromDn($group_id);
	
		$customerDetails = $this->Customer->find('first',array('conditions'=>array('Customer.id'=>$customer_id)));
		
		
		
		#$custDetail_array=print_r($customerDetails, true);
		#$this->log("Customer controller : List Customer Details : $custDetail_array", LOG_DEBUG);
		$this->set('SELECTED_CUSTOMER', $customer_id);
		$this->set('SELECTED_CUSTOMER', $customer_id);
			#User for left hand Menu navigation.
	
		$this->set('SELECTED_CNN',$customer_id);
		$this->set('SELECTED_CUSTOMER_NAME',$customer_id);
		
		$this->set('custdetail',$customerDetails);
	
		#Now send logs
		#$cond ="";
		#$cond = array_merge($cond,array('Log.log_entry LIKE'=>'%'.$desc.'%'));
		$cond = array('Log.customer_id'=>$customer_id, 'Log.log_entry !='=>'User logged in');
		
		
		$this->paginate['Paginate']	= $this->AutoPaginate->setPaginate();
		$this->paginate['limit'] = 5;
		$this->paginate = array('limit' => $this->paginate['limit'],'conditions'=>$cond, 'order'=>'Log.created desc');
		$loginfo = $this->paginate('Log');
		$this->set('loginfo',$loginfo);
	
		$this->log("Group controller :  END EDIT FUNCTION ", LOG_DEBUG);
		
		
		#DNS Total
			$this->set('DNCount', $this->Dns->find('count',
					array(
					'contain'=> array('Dns', 'Location'),
						'conditions' => array('Location.customer_id' => $customer_id )
					)
				)
			);
			
		#location Total
			$this->set('locTotalCount', $this->Location->find('count',
				array(
				
				'conditions' => array('Location.customer_id' => $customer_id )
					)	
				)
			);
			
			#Trunk Total
			$this->set('trunkTotalCount', $this->Trunk->find('count',
				array(
				
				'conditions' => array('Location.customer_id' => $customer_id )
				)
			  )
			);	
		#Mediatrix
				
			#Total
			$this->set('mediatrixTotalCount', $this->Mediatrix->find('count',
			array(
						
						'conditions' => array('Location.customer_id' => $customer_id )
			)
			)
			);
			
			#ODS 	#Total
			$this->set('scenarioTotalCount', $this->Scenario->find('count',
			array(
					'contain' => false,
					'conditions' => array('Scenario.customer_id' => $customer_id )
			)
							)
			);
			
			#ODS 	#Total
			$this->set('stationTotalCount', $this->Station->find('count',
			array(
					'contain' => false,
					'conditions' => array('Station.customer_id' => $customer_id )
			)
							)
			);
			
			#ODS 	#Total
			$this->set('groupMadnTotalCount', $this->Group->find('count',
			array(
					'contain' => false,
					'conditions' => array('Group.type'=>'MADN','Group.customer_id' => $customer_id)
					
				)
							)
			);
			
			#ODS 	#Total
			$this->set('groupCpuTotalCount', $this->Group->find('count',
			array(
					'contain' => false,
					'conditions' => array('Group.type'=>'CPU','Group.customer_id' => $customer_id)
			)
							)
			);
			
			
			#location PrNO
			$this->set('locpro_nr', $this->Location->find('first',
				array(
				
				'conditions' => array('Location.customer_id' => $customer_id )
					)	
				)
			);
			
			
		
		}
	
	function export()
	{
		$this->layout = "";
		$conds = unserialize($this->Session->read('cond'));
		
		//ini_set('max_execution_time', 600); //increase max_execution_time to 10 min if data set is very large
	
		$filename = "export_customer_".date("Y.m.d").".csv";
		$csv_file = fopen('php://output', 'w');
		header('Content-type: application/csv');
		header('Content-Disposition: attachment; filename="'.$filename.'"');
	
		//$results = $this->Customer->query($sql);	// This is your sql query to pull that data you need exported
		//or
		#$results = $this->Customer->find('all', array('conditions'=> array('type' => $conds),'order'=>'created DESC','recursive'=>-1));
		$results = $this->Customer->find('all', array('conditions'=> $conds,'order'=>'created DESC','recursive'=>-1));
	  	$header_row = array(__("Nr", true),__("Name", true), __("CNN", true), __("BSK", true),__("Type", true),__("onDemand", true));
		fputcsv($csv_file,$header_row,';','"');
	
		// Each iteration of this while loop will be a row in your .csv file where each field corresponds to the heading of the column
		$i=1;
		foreach($results as $result)
		{
			// Array indexes correspond to the field names in your db table(s)
			$row = array(
				$result['Customer']['Sno']= $i,
				$result['Customer']['name'],
				$result['Customer']['id'],
				$result['Customer']['bsk'],
                                $result['Customer']['type'],
                                $result['Customer']['onDemand'] 
			);
			$i++;
			fputcsv($csv_file,$row,';','"');
		}
	
		fclose($csv_file);exit();
	}
	
	function export_report($report_id = null)
	{
		#$report_id='test';
		if (!$report_id) {
			exit ();
		}
		$this->layout = "";
		$conds = unserialize($this->Session->read('cond'));
		//ini_set('max_execution_time', 600); //increase max_execution_time to 10 min if data set is very large
	
		$filename = "export_reort_".$report_id. '_' .date("Y.m.d").".csv";
		$csv_file = fopen('php://output', 'w');
		header('Content-type: application/csv');
		header('Content-Disposition: attachment; filename="'.$filename.'"');
	
		if($report_id == 'activeDN')
		{
			#$results = $this->Customer->find('all', array('conditions'=>$conds,'order'=>'created DESC','recursive'=>-1));
	  		$sql	=	"select id from active_dn where id NOT IN (select id from base_dn);";
	  		$results = $this->Dns->query($sql);
	  		$header_row = array(__("Nr", true),__("DN", true));
			fputcsv($csv_file,$header_row,';','"');
	
			// Each iteration of this while loop will be a row in your .csv file where each field corresponds to the heading of the column
			$i=1;
			foreach($results as $result)
			{
				// Array indexes correspond to the field names in your db table(s)
				$row = array(
				$result['Customer']['Sno']= $i,
				$result['active_dn']['id']
				);
				$i++;
				fputcsv($csv_file,$row,';','"');
			}
	
		fclose($csv_file);exit();
		}
		if($report_id == 'statExport')
		{
			$results = $this->Station->find('all', array('conditions'=>array('Station.status' => 2),'order'=>'Station.id'));
	  		#$sql	=	"select id from stations where id NOT IN (select id from base_dn);";
	  		#$results = $this->Dns->query($sql);
	  		$header_row = array(__("Nr", true),__("Station", true));
			fputcsv($csv_file,$header_row,';','"');
	
			// Each iteration of this while loop will be a row in your .csv file where each field corresponds to the heading of the column
			$i=1;
			foreach($results as $result)
			{
				// Array indexes correspond to the field names in your db table(s)
				$row = array(
				$result['Station']['Sno']= $i,
				$result['Station']['id']
				);
				$i++;
				fputcsv($csv_file,$row,';','"');
			}
	
		fclose($csv_file);exit();
		}
		if($report_id == 'dnUnknownLoc')
		{
			#$results = $this->Dns->find('all', array('conditions'=>array('Location.name' => 'UNKNOWN'),'order'=>'Location.customer_id'));
			$results = $this->Dns->find('all',
					array(
							'fields' => array(
							'Location.customer_id',
							'Location.name',
							'count(Dns.id)'),
							'group' => array('Location.customer_id', 'Location.name'),
							'conditions' => array('Location.scm_name' => 'UNKNOWN'))
			);
			
			
			#$sql	=	"select id from stations where id NOT IN (select id from base_dn);";
			#$results = $this->Dns->query($sql);
			$header_row = array(__("Nr", true),__("CNN", true),__("Location", true),__("DN", true));
			fputcsv($csv_file,$header_row,';','"');
		
			// Each iteration of this while loop will be a row in your .csv file where each field corresponds to the heading of the column
			$i=1;
			foreach($results as $result)
			{
				// Array indexes correspond to the field names in your db table(s)
				$row = array(
						$result['Dns']['Sno']= $i,
						$result['Location']['customer_id'],
						$result['Location']['name'],
						$result[0]['count(`Dns`.`id`)']
				);
				$i++;
				fputcsv($csv_file,$row,';','"');
			}
		
			fclose($csv_file);exit();
		}
	}
	
	function export_statistics($customer_val = null)
	{
 		 $blank_row = array(
				 ''
		);

		$this->layout = "";
		#$conds = unserialize($this->Session->read('cond'));
		//ini_set('max_execution_time', 600); //increase max_execution_time to 10 min if data set is very large
	
		$filename = "export_statistics_".$customer_val. '_' .date("Y.m.d").".csv";
		$csv_file = fopen('php://output', 'w');
		header('Content-type: application/csv');
		header('Content-Disposition: attachment; filename="'.$filename.'"');
		$header_row = array(__("Statistic", true),__("Total", true));
		fputcsv($csv_file,$header_row,';','"');
		#-----COpy

		if(!isset($customer_val) || $customer_val == 'GLOBAL')
		 {
		  	$customer_val = 'GLOBAL';
		 
		 
		#-----------------PORTS--------------------------
				$row = array(
				 __('PORT STATISTICS', true)
				);
				fputcsv($csv_file,$blank_row,';','"');
				fputcsv($csv_file,$row,';','"');

			#Total
			$portTypeTotalCount = $this->Station->find('count',
					array(
						'conditions' => array('Station.type'=>array('CICM', 'ANLG'))
					)
				);
			$row = array(
			__('C20TOTAL') ,
			$portTypeTotalCount
			);
			fputcsv($csv_file,$row,';','"');
			
			
			#Analogue/CICM 
			
			$stationTypeCount = $this->Station->find('all',
			array(
				'fields' => array(
				'Station.type', 
				'count(Station.type)'),  
				'group' => 'Station.type',
				'conditions' => array('Station.status !=' => 2))
			);
						
			foreach($stationTypeCount as $statTyp)
			{
					if($statTyp['Station']['type'] == '')
						{
							$row = array(
							__('Blank Terminal Type') ,
							$statTyp[0]['count(`Station`.`type`)']
							);
						}
						else
						{
							$row = array(
							__('T' . $statTyp['Station']['type']) ,
							$statTyp[0]['count(`Station`.`type`)']
							);
						}
					fputcsv($csv_file,$row,';','"');
			}
			
				$row = array(
				 __('STATION STATISTICS', true)
				);
				fputcsv($csv_file,$blank_row,';','"');
				fputcsv($csv_file,$row,';','"');
		
			#Total
			$phoneTypeTotalCount = $this->Station->find('count');
			
			$row = array(
			__('DBSTATIONTOTAL') ,
			$phoneTypeTotalCount
			);
			fputcsv($csv_file,$row,';','"');
						
			#Phone type
			$phoneTypeCount = $this->Station->find('all',
			array(
				'fields' => array(
				'Station.phone_type', 
				'count(Station.phone_type)'),  
				'group' => 'Station.phone_type',
				'conditions' => array('phone_type !=' => ''))
			);
			foreach($phoneTypeCount as $phoneTyp)
			{
					$row = array(
						__('T' . $phoneTyp['Station']['phone_type']) ,
						$phoneTyp[0]['count(`Station`.`phone_type`)']
					);
					fputcsv($csv_file,$row,';','"');
			}
			
			$phoneTypeCountNull = $this->Station->find('count',
			array('conditions' => array('phone_type' => NULL)));
			
			$row = array(
			__('Blank Phone Type') ,
			$phoneTypeCountNull
			);
			fputcsv($csv_file,$row,';','"');
			
			$row = array(
				 __('STATION_OPTION STATISTICS', true)
				);
				fputcsv($csv_file,$blank_row,';','"');
				fputcsv($csv_file,$row,';','"');
				
			#Expansion keys 
			$expTypeCount = $this->Station->find('all',
			array(
				'fields' => array(
				'Station.extensions', 
				'count(Station.extensions)'),  
				'group' => 'Station.extensions'
			)
			);
			foreach($expTypeCount as $expTyp)
			{
					if($expTyp['Station']['extensions'] == 1){
						$row = array(
						__('1 Expansion Module', true),
						$expTyp[0]['count(`Station`.`extensions`)']
					);
					fputcsv($csv_file,$row,';','"');
					}
					elseif ($expTyp['Station']['extensions'] == 2){
						$row = array(
						__('2 Expansion Modules', true),
						$expTyp[0]['count(`Station`.`extensions`)']
					);
					fputcsv($csv_file,$row,';','"');
					}
					
			}

			
			
			#SIMRING not ''
			$simCount = $this->Station->find('count',
					array(
						'conditions' => array('SIMRING !=' => '')
					)
				);
				$row = array(
				 __('SIMRING not null') ,
				 $simCount
				);
				fputcsv($csv_file,$row,';','"');
				
				#CTI
				$ctiCount = $this->Station->find('count',
					array(
						'conditions' => array('Station.CTI' => '1')
					)
				);
				$row = array(
				 __('TCTI') ,
				 $ctiCount
				);
				fputcsv($csv_file,$row,';','"');
				
				#CTI
				$comboxCount = $this->Station->find('count',
					array(
						'conditions' => array('COMBOX' => '1')
					)
				);
				$row = array(
				 __('TCOMBOX') ,
				 $comboxCount
				);
				fputcsv($csv_file,$row,';','"');
				
				#Total
				$statcfraCount = $this->Station->find('count',
					array(
						'conditions' => array('CFRA' => '1')
					)
				);
				
				$row = array(
				 __('TCOMBOX') ,
				 $comboxCount
				);
				fputcsv($csv_file,$row,';','"');
				
				
				
				$row = array(
				 __('GROUP STATISTICS', true)
				);
				fputcsv($csv_file,$blank_row,';','"');
				fputcsv($csv_file,$row,';','"');
				
			#-----------------GROUPS--------------------------
			#Total
			$groupTypeTotalCount =$this->Dns->find('count',
					array(
						'contain' => false,
						'conditions' => array('Dns.function NOT' => array('INDIVIDUAL', '', 'CFRA', 'INTERNAL'))
					)
				);	
			$row = array(
			__('TOTAL') ,
			$groupTypeTotalCount
			);
			fputcsv($csv_file,$row,';','"');
			
			
				
				$groupTypeCount = $this->Dns->find('all',
			array(
				'fields' => array(
				'Dns.function', 
				'count(Dns.function)'),  
				'group' => 'Dns.function',
				'contain' => false,
				'conditions' => array('Dns.function NOT' => array('INDIVIDUAL', '', 'CFRA', 'INTERNAL'))
				)
			);
			foreach($groupTypeCount as $groupTyp)
			{
					$row = array(
						__('T' . $groupTyp['Dns']['function']) ,
						$groupTyp[0]['count(`Dns`.`function`)']
					);
					fputcsv($csv_file,$row,';','"');
			}

			
			#-----------------DN--------------------------
			
			$row = array(
			 __('DN STATISTICS', true)
			);
			fputcsv($csv_file,$blank_row,';','"');
			fputcsv($csv_file,$row,';','"');
			
			#DNS Total
			$DNCount = $this->Dns->find('count');		
			#DNS Total
			$DNAvailCount = $this->Dns->find('count',
					array(
						'conditions' => array('Dns.function' => NULL)
					));
			#DNS Total
			$DNUsedCount = $this->Dns->find('count',
					array(
						'conditions' => array('Dns.function !=' => '')
					)
				);
		
			#!!TOTAL
		
			$row = array(
			__('TOTAL') ,
			$DNCount
			);
			fputcsv($csv_file,$row,';','"');
			$row = array(
			__('TAVAILABLE') ,
			$DNAvailCount
			);
			fputcsv($csv_file,$row,';','"');
			$row = array(
			__('TUSED') ,
			$DNUsedCount
			);
			fputcsv($csv_file,$row,';','"');
			
						
			
			
			#-----------------CUSTOMERS--------------------------
			
			$row = array(
			 __('CUSTOMER STATISTICS', true)
			);
			fputcsv($csv_file,$blank_row,';','"');
			fputcsv($csv_file,$row,';','"');
			
			$custCount = $this->Customer->find('count');
		
			$row = array(
			__('TOTAL') ,
			$custCount
			);
			fputcsv($csv_file,$row,';','"');
				
			# CUSTOMER TYPES
			
			$customerTypeCount = $this->Customer->find('all',
			array(
				'fields' => array('Customer.type', 'count(Customer.type)'),  
				'group' => 'Customer.type'));
			foreach($customerTypeCount as $custTyp)
			{
					$row = array(
						__('T' . $custTyp['Customer']['type']) ,
						 $custTyp[0]['count(`Customer`.`type`)']
					);
					fputcsv($csv_file,$row,';','"');
			}
			
			
			#-----------------CUSTOMER OPTIONS--------------------------
				
				$row = array(
				 __('CUSTOMER_OPTIONS', true)
				);
				fputcsv($csv_file,$blank_row,';','"');
				fputcsv($csv_file,$row,';','"');
			
			# ONB TOTAL.
			
			$onbCount = $this->Customer->find('count',
					array(
						'conditions' => array('ONB' => '1')
					)
				);
			$row = array(
			__('TONB') ,
			$onbCount
			);
			fputcsv($csv_file,$row,';','"');
			
			# NSC TOTAL.
			
			$nscCount = $this->Customer->find('count',
					array(
						'conditions' => array('NSC' => '1')
					)
				);
			$row = array(
			__('TNSC') ,
			$nscCount
			);
			fputcsv($csv_file,$row,';','"');
				
				# CFRA TOTAL.
				$cfraTypeCount = $this->Station->find('all',
					array(
						'fields' => array(
							'customer_id',
							'count(customer_id)'
						),  
						'conditions' => array('CFRA' => '1'),
						'group' => 'customer_id'
					)
				);
				$cfraCount = count($cfraTypeCount);
			
				$row = array(
				__('TCFRA'),
				$cfraCount
				);
				fputcsv($csv_file,$row,';','"');
			

			

			# CD.
			
			$cdTypeCount = $this->Customer->find('count',
					array(
						'conditions' => array('CD' => '1')
					)
				);
			$row = array(
			__('TCD') ,
			$cdTypeCount
			);
			fputcsv($csv_file,$row,';','"');
			
			# CD.
			
			$ocTypeCount = $this->Customer->find('count',
					array(
						'conditions' => array('OC' => '1')
					)
				);
			$row = array(
			__('TOC') ,
			$ocTypeCount
			);
			fputcsv($csv_file,$row,';','"');
			# NSC TOTAL.
			
			$ctiCount = $this->Customer->find('count',
					array(
						'conditions' => array('CTI' => '1')
					)
				);
			$row = array(
			__('TCTI') ,
			$ctiCount
			);
			fputcsv($csv_file,$row,';','"');
			
			
			#-----------------CUSTOMER SLA--------------------------
				
				$row = array(
				 __('CUSTOMER_SLA', true)
				);
				fputcsv($csv_file,$blank_row,';','"');
				fputcsv($csv_file,$row,';','"');
				
			$slaCount = $this->Customer->find('count',
					array(
						'conditions' => array('SLA !=' => '')
					)
				);
				$row = array(
			__('TOTAL') ,
			$slaCount
			);
			fputcsv($csv_file,$row,';','"');
				
			
			#SLA
			$slaTypeCount = $this->Customer->find('all',
			array(
				'fields' => array(
				'Customer.SLA', 
				'count(Customer.SLA)'),  
				'group' => 'Customer.SLA')
			);
			foreach($slaTypeCount as $slaTyp)
			{
					if ($slaTyp['Customer']['SLA'] != '0')
            		{
						$row = array(
						__('T' . $slaTyp['Customer']['SLA']) ,
						$slaTyp[0]['count(`Customer`.`SLA`)']
						);
						fputcsv($csv_file,$row,';','"');
            		}
			}
			
			#-----------------PHONR USAGE--------------------------
			
                $row = array(
				 __('PHONE_USAGE STATISTICS', true)
				);
				fputcsv($csv_file,$blank_row,';','"');
				fputcsv($csv_file,$row,';','"');
			
			
			 $totalPhoneLogonCount = $this->Log->find('count',
                                        array(
                                                'conditions' => array('Log.log_entry' => 'User Logged In', 'Log.app_type' => 'Phone')
                                        )
                        );
			$row = array(
			__('User logged in') ,
			$totalPhoneLogonCount
			);
			fputcsv($csv_file,$row,';','"');

			$phoneLogonCount = $this->Log->find('all',
			array(
				'fields' => array(
					'Log.customer_id', 
					'count(Log.id)'),  
				'group' => 'Log.customer_id',
				'conditions' => array('Log.log_entry' => 'User Logged In', 'Log.app_type' => 'Phone'))
			);
			foreach($phoneLogonCount as $logonTyp)
			{
				#if (($logonTyp['Log']['customer_id'] == '') || ($logonTyp['Log']['customer_id'] == 'SWIV'))
				if ($logonTyp['Log']['customer_id'] == '')
				{
					$row = array(
					__('LOGON_INTERNAL') ,
					$logonTyp[0]['count(`Log`.`id`)']
					);
					fputcsv($csv_file,$row,';','"');
				} 
				else 
				{
					$row = array(
					__('LOGON ') . $logonTyp['Log']['customer_id'],
					$logonTyp[0]['count(`Log`.`id`)']
					);
					fputcsv($csv_file,$row,';','"');
				} 
					
			}
			$phoneUsageCount = $this->Log->find('all',
			array(
				'fields' => array(
					'SUBSTRING_INDEX(log_entry, \':\', \'+1\') as sub', 
					'count(Log.id)'),  
				'group' => 'sub',
				'conditions' => array('Log.app_type' => 'Phone','Log.log_entry !=' => 'User Logged In'))
			);
			foreach($phoneUsageCount as $phoneUsageTyp)
			{
					$row = array(
						__('_' . $phoneUsageTyp[0]['sub']) ,
						$phoneUsageTyp[0]['count(`Log`.`id`)']
					);
					fputcsv($csv_file,$row,';','"');
			}
			
						#-----------------GATE USAGE--------------------------
			
                $row = array(
				 __('GATE_USAGE STATISTICS', true)
				);
				fputcsv($csv_file,$blank_row,';','"');
				fputcsv($csv_file,$row,';','"');
			
			 $totalGateLogonCount = $this->Log->find('count',
                                        array(
                                                'conditions' => array('Log.log_entry' => 'User Logged In', 'Log.app_type' => 'Gate')
                                        )
                        );
			$row = array(
			__('User logged in') ,
			$totalGateLogonCount
			);
			fputcsv($csv_file,$row,';','"');

			$gateLogonCount = $this->Log->find('all',
			array(
				'fields' => array(
					'Log.customer_id', 
					'count(Log.id)'),  
				'group' => 'Log.customer_id',
				'conditions' => array('Log.log_entry' => 'User Logged In', 'Log.app_type' => 'Gate'))
			);
			foreach($gateLogonCount as $logonTyp)
			{
				if ($logonTyp['Log']['customer_id'] == '')
				{
					$row = array(
					__('LOGON_INTERNAL') ,
					$logonTyp[0]['count(`Log`.`id`)']
					);
					fputcsv($csv_file,$row,';','"');
				} 
				else 
				{
					$row = array(
					__('LOGON ') . $logonTyp['Log']['customer_id'],
					$logonTyp[0]['count(`Log`.`id`)']
					);
					fputcsv($csv_file,$row,';','"');
				} 
					
			}
			$gateUsageCount = $this->Log->find('all',
			array(
				'fields' => array(
					'SUBSTRING_INDEX(log_entry, \':\', \'+1\') as sub', 
					'count(Log.id)'),  
				'group' => 'sub',
				'conditions' => array('Log.app_type' => 'Gate','Log.log_entry !=' => 'User Logged In'))
			);
			foreach($gateUsageCount as $phoneUsageTyp)
			{
					$row = array(
						__('_' . $phoneUsageTyp[0]['sub']) ,
						$phoneUsageTyp[0]['count(`Log`.`id`)']
					);
					fputcsv($csv_file,$row,';','"');
			}
			
		#--End Copy
		 }
		 else
		 {
		 	
		 			 
		#-----------------STATIONS--------------------------
#-----------------PORTS--------------------------
				$row = array(
				 __('PORT STATISTICS', true)
				);
				fputcsv($csv_file,$blank_row,';','"');
				fputcsv($csv_file,$row,';','"');

			#Total
			$portTypeTotalCount = $this->Station->find('count',
					array(
						'conditions' => array('Station.type'=>array('CICM', 'ANLG'), 'Station.customer_id' => $customer_val)
					)
				);
			$row = array(
			__('C20TOTAL') ,
			$portTypeTotalCount
			);
			fputcsv($csv_file,$row,';','"');
			
			#Analogue/CICM 
			$stationTypeCount = $this->Station->find('all',
			array(
				'fields' => array(
				'Station.type', 
				'count(Station.type)'),  
				'group' => 'Station.type',
				'conditions' => array('Station.customer_id' => $customer_val, 'Station.status !=' => 2))
			);
			
			foreach($stationTypeCount as $statTyp)
			{

					if($statTyp['Station']['type'] == '')
						{

							$row = array(
							__('Blank Terminal Type') ,
							$statTyp[0]['count(`Station`.`type`)']
							);
						}
						else
						{
							$row = array(
							__('T' . $statTyp['Station']['type']) ,
							$statTyp[0]['count(`Station`.`type`)']
							);
						}
					fputcsv($csv_file,$row,';','"');
			}
		
			$row = array(
				 __('STATION STATISTICS', true)
				);
				fputcsv($csv_file,$blank_row,';','"');
				fputcsv($csv_file,$row,';','"');
		
			#Total
			$phoneTypeTotalCount = $this->Station->find('count', array(
						'conditions' => array('Station.customer_id' => $customer_val)
					));
			
			$row = array(
			__('DBSTATIONTOTAL') ,
			$phoneTypeTotalCount
			);
			fputcsv($csv_file,$row,';','"');
						
			#Phone type
			$phoneTypeCount = $this->Station->find('all',
			array(
				'fields' => array(
				'Station.phone_type', 
				'count(Station.phone_type)'),  
				'group' => 'Station.phone_type',
				'conditions' => array('Station.customer_id' => $customer_val, 'phone_type !=' => ''))
			);
			foreach($phoneTypeCount as $phoneTyp)
			{
					$row = array(
						__('T' . $phoneTyp['Station']['phone_type']) ,
						$phoneTyp[0]['count(`Station`.`phone_type`)']
					);
					fputcsv($csv_file,$row,';','"');
			}
			
			$phoneTypeCountNull = $this->Station->find('count',
			array('conditions' => array('phone_type' => NULL, 'Station.customer_id' => $customer_val)));
			
			$row = array(
			__('Blank Phone Type') ,
			$phoneTypeCountNull
			);
			fputcsv($csv_file,$row,';','"');
			
			$row = array(
				 __('STATION_OPTIONS', true)
				);
				fputcsv($csv_file,$blank_row,';','"');
				fputcsv($csv_file,$row,';','"');
			
			#Expansion keys 
			$expTypeCount = $this->Station->find('all',
			array(
				'fields' => array(
				'Station.extensions', 
				'count(Station.extensions)'),  
				'group' => 'Station.extensions',
				'conditions' => array('Station.customer_id' => $customer_val)
			)
			);
			foreach($expTypeCount as $expTyp)
			{
					if($expTyp['Station']['extensions'] == 1){
						$row = array(
						__('1 Expansion Module', true),
						$expTyp[0]['count(`Station`.`extensions`)']
					);
					fputcsv($csv_file,$row,';','"');
					}
					elseif ($expTyp['Station']['extensions'] == 2){
					$row = array(
						__('2 Expansion Modules', true),
						$expTyp[0]['count(`Station`.`extensions`)']
					);
					fputcsv($csv_file,$row,';','"');
					}
					
			}
			
	

			
			
			#SIMRING not ''
			$simCount = $this->Station->find('count',
					array(
						'conditions' => array('SIMRING !=' => '', 'Station.customer_id' => $customer_val)
					)
				);
				$row = array(
				 __('SIMRING not null') ,
				 $simCount
				);
				fputcsv($csv_file,$row,';','"');
				
								#CTI
				$ctiCount = $this->Station->find('count',
					array(
						'conditions' => array('CTI' => '1', 'Station.customer_id' => $customer_val)
					)
				);
				$row = array(
				 __('TCTI') ,
				 $ctiCount
				);
				fputcsv($csv_file,$row,';','"');
				
				#CTI
				$comboxCount = $this->Station->find('count',
					array(
						'conditions' => array('COMBOX' => '1', 'Station.customer_id' => $customer_val)
					)
				);
				$row = array(
				 __('TCOMBOX') ,
				 $comboxCount
				);
				fputcsv($csv_file,$row,';','"');
				
				#Total
				$statcfraCount = $this->Station->find('count',
					array(
						'conditions' => array('CFRA' => '1', 'Station.customer_id' => $customer_val)
					)
				);
				$row = array(
				 __('TCFRA') ,
				 $statcfraCount
				);
				fputcsv($csv_file,$row,';','"');
				
				
				$row = array(
				 __('GROUP STATISTICS', true)
				);
				fputcsv($csv_file,$blank_row,';','"');
				fputcsv($csv_file,$row,';','"');
				
			#-----------------GROUPS--------------------------
				
			#Total
			$groupTypeTotalCount =$this->Dns->find('count',
					array(
						'contain' => false,
						'conditions' => array('Dns.function NOT' => array('INDIVIDUAL', '', 'CFRA', 'INTERNAL'), 'Location.customer_id' => $customer_val)
					)
				);	
			$row = array(
			__('TOTAL') ,
			$groupTypeTotalCount
			);
			fputcsv($csv_file,$row,';','"');
			
			
			$groupTypeCount = $this->Dns->find('all',
			array(
				'fields' => array(
				'Dns.function', 
				'count(Dns.function)'),  
				'group' => 'Dns.function',
				'contain' => false,
				'conditions' => array('Dns.function NOT' => array('INDIVIDUAL', '', 'CFRA', 'INTERNAL'), 'Location.customer_id' => $customer_val)
				)
			);
			foreach($groupTypeCount as $groupTyp)
			{
					$row = array(
						__('T' . $groupTyp['Dns']['function']) ,
						$groupTyp[0]['count(`Dns`.`function`)']
					);
					fputcsv($csv_file,$row,';','"');
			}
			
			#-----------------DN--------------------------
			$row = array(
			 __('DN STATISTICS', true)
			);
			fputcsv($csv_file,$blank_row,';','"');
			fputcsv($csv_file,$row,';','"');
			
			#DNS Total
			$DNCount = $this->Dns->find('count', array('conditions' => array('Location.customer_id' => $customer_val)));		
			#DNS Total
			$DNAvailCount = $this->Dns->find('count',
					array(
						'conditions' => array('Dns.function' => NULL, 'Location.customer_id' => $customer_val)
					));
			#DNS Total
			$DNUsedCount = $this->Dns->find('count',
					array(
						'conditions' => array('Dns.function !=' => '', 'Location.customer_id' => $customer_val)
					)
				);
		
			#!!TOTAL
		
			$row = array(
			__('TOTAL') ,
			$DNCount
			);
			fputcsv($csv_file,$row,';','"');
			$row = array(
			__('TAVAILABLE') ,
			$DNAvailCount
			);
			fputcsv($csv_file,$row,';','"');
			$row = array(
			__('TUSED') ,
			$DNUsedCount
			);
			fputcsv($csv_file,$row,';','"');
			
			
		 	
		 }
			
		#Close the Report	
	
		fclose($csv_file);exit();
		
	}
	
	/**
	 * view()
	 * displays a single Customer and all related stations
	 * url: /formats/view/Customer_slug
	 */
	function view($slug = null) {

	}
	/**
	 * function for uploading file
	 *
	 */
	function upload(){

		if ($_FILES["file"]["error"] > 0)
		  {
		  $this->set('msg' ,$_FILES["file"]["error"]);
		  }
		else
		  {
		  	
		  	if($_FILES["file"]["type"]=='audio/x-wav'){
		  		
		  		if (file_exists(Configure::read('upload_url') . $_FILES["file"]["name"]))
			      {
			     	 $this->set('msg' ,$_FILES["file"]["name"] . " already exists. ");
			      }
			    else
			      {
			      move_uploaded_file($_FILES["file"]["tmp_name"],Configure::read('upload_url').$_FILES["file"]["name"]);
			      $this->set('msg' ,$_FILES["file"]["name"] . " uploaded Succesfully. ");
			      
			      }

		  	}else{
		  		 $this->set('msg' ,__('only Wav file is allowed'));
		  	}
		  }

		$this->layout='ajax';
		$this->set('title_header','Prototype');	
		
	}
	/**
	 * index()
	 * main index page of the formats page
	 * url: /formats/index
	 */
	function reports() {
		
		if(isset($_POST['customer']))
		 {
		  $customer_val=$_POST['customer'];
		 }
		 else
		 {

		    $customer_val='GLOBAL';
		 }
		
		
		$this->pageTitle = 'Reports';

		#CBM
		#If the Selected customer is not the same as the internal user (i.e Internal user) then redirect to user to the station index page
		if($this->Session->read('SELECTED_CUSTOMER')!=Configure::read('access_id')){
			//$this->layout='ajax';
			//$this->cakeError('accessDenied'); 
			
			$record =       $this->Customer->find('all', array('conditions'=>array("Customer.status"=>array(1,2,3),'Customer.bsk'=>$this->Session->read('SELECTED_CUSTOMER'))));
			
			if(empty($record) && Configure::read('access_id')!= $this->Session->read('SELECTED_CUSTOMER')){
			#$this->log("Some one trying to loggin with id ".$value['user_id']);
				$this->log("Invalid SSO data ".$this->Session->read('SELECTED_CUSTOMER'));
				$this->layout='ajax';
				$this->cakeError('accessDenied'); 
			}else{
			
				#Now Check the type of application (Gate/Phone)
				#$this->redirect('/stations/index/'.$record[0]['Customer']['id']);
				
			}
			
			//$cnt	=	 count($this->_Filter);
			//$this->_Filter[$cnt] 			= "Customer.bsk=".$this->Session->read('SELECTED_CUSTOMER');
		}

		#END CBM


	
		$this->paginate['Paginate']	=	$this->AutoPaginate->setPaginate();
		$this->set('title_header', __('Swisscom Extranet Corporate Business - Voiphone Selfcare', true));	
		$this->Session->write('Customer.Name', 'UNDEF');
		$this->set('cust_for_layout', 'UNDEFINED');
		$this->Customer->recursive = 0;
		#Orignal working RE1
		#$cond = $this->_Filter;
		#$this->Session->write('cond',serialize($cond));
		#$this->set('customers', $this->paginate(null, $this->_Filter));
		#new for RE2
		#$this->set('phoneCount', $this->Customer->find('count', 
		#array('conditions' => array('Customer.type' => 'Phone'))
		#));
		$this->set('customerIds', $this->Customer->find('all', array('order' => 'name ASC')));
		$this->set('customer_val', $customer_val);
		
			
		
		#REPORTS DEFINITION
		
		
		 if(isset($_POST['customer']) && $_POST['customer'] != 'GLOBAL')
		 {
		 	
		 	#Station statistics - that are not glocal
		 	
		 	#Station types that are not status 2 (meaning not exported from 4voip and not matched)
		 	
			$this->set('stationTypeCount', $this->Station->find('all',
			array(
				'fields' => array(
				'Station.type', 
				'count(Station.type)'),  
				'group' => 'Station.type',
				'conditions' => array('Station.customer_id' => $customer_val, 'Station.status !=' => 2))
			));
			
			#Total
			$this->set('portTypeTotalCount', $this->Station->find('count',
					array(
						'conditions' => array('Station.customer_id' => $customer_val, 'Station.type'=>array('CICM', 'ANLG'))
					)
				)
			);
			
			# CFRA.
			
			$this->set('cfraTypeCount', $this->Station->find('all',
					array(
						'fields' => array(
							'customer_id',
							'count(customer_id)'
						),  
						'conditions' => array('CFRA' => '1', 'Station.customer_id' => $customer_val),
						'group' => 'customer_id'
					)
				)
			);
			
			#Total
			$this->set('statcfraCount', $this->Station->find('count',
					array(
						'conditions' => array('CFRA' => '1', 'Station.customer_id' => $customer_val)
					)
				)
			);
			
			
			$this->set('groupTypeCount', $this->Dns->find('all',
			array(
				'fields' => array(
				'Dns.function', 
				'count(Dns.function)'),  
				'group' => 'Dns.function',
				'contain' => false,
				'conditions' => array('Dns.function NOT' => array('INDIVIDUAL', '', 'CFRA', 'INTERNAL'), 'Location.customer_id' => $customer_val )
				)
			));
			
						####ADDED RE3 #############
			
			#location
			
			
			#Total
			$this->set('locTotalCount', $this->Location->find('count',
			array(
			
			'conditions' => array('Location.customer_id' => $customer_val )
			)
			)
			);
			
			#Trunk
			
			#Total
			$this->set('trunkTotalCount', $this->Trunk->find('count',
			array(
			
			'conditions' => array('Location.customer_id' => $customer_val )
			)
			)
			);
			
			#$this->set('trunkTypeCount', $this->Trunk->find('all',
			#array(
			#'fields' => array(
			#'Location.id',
			#'Trunk.gate_type',
			#'SUM(Trunk.channel)',
			#'group' => 'Trunk.gate_type',
			#'conditions' => array('Location.customer_id' => $customer_val )
			
			#	)
			#)));
			
			
			$trunk_type = $this->Trunk->find('all',
			array(
				'fields' => array(
				'Location.id',
				'Trunk.gate_type',
				'count(Trunk.gate_type)',
				'sum(Trunk.channel)'),  
				'group' => 'Trunk.gate_type',
				'conditions' => array('Location.customer_id' => $customer_val )
				)
			);
			
			#$trunk_Array = print_r($trunk_type, true);
			#$this->log("Customer controller : TRunk stats " . $trunk_Array, LOG_DEBUG);
			
			$this->set('trunkTypeCount',$trunk_type);
			
			#Mediatrix
				
			#Total
			$this->set('mediatrixTotalCount', $this->Mediatrix->find('count',
			array(
						
						'conditions' => array('Location.customer_id' => $customer_val )
			)
			)
			);
			$this->set('mediatrixTypeCount', $this->Mediatrix->find('all',
					array(
							'fields' => array(
									'Mediatrix.type',
									'count(Mediatrix.type)'),
									'group' => 'Mediatrix.type',
							
							'conditions' => array('Location.customer_id' => $customer_val )
										
							)
					));
			
			
			#Mediatrix Port Total
	
			$this->set('portCount', $this->Port->find('count',
					array(
			
							'conditions' => array('Location.customer_id' => $customer_val )
					)
			)
			);
			
			$this->set('portAvailCount', $this->Port->find('count',
					array(
								

							'conditions' => array('Port.station_id' => '','Location.customer_id' => $customer_val)
										)
			)
			);
			
			$this->set('portUsedCount', $this->Port->find('count',
			array(
			
			'conditions' => array('Port.station_id !=' => '','Location.customer_id' => $customer_val)
					)
			)
			);
			
			#ODS
			
			#Total
			$this->set('scenarioTotalCount', $this->Scenario->find('count',
			array(
					'contain' => false,
					'conditions' => array('Scenario.customer_id' => $customer_val )
			)
							)
			);
			$this->set('scenarioTypeCount', $this->Scenario->find('all',
					array(
							'fields' => array(
									'Scenario.status',
									'count(Scenario.status)'),
					'group' => 'Scenario.status',
					'contain' => false,
					'conditions' => array('Scenario.customer_id' => $customer_val )
			
							)
			));
			
			#Features
				
			
			$this->set('featureTypeCount', $this->Feature->find('all',
					array(
							'fields' => array(
									'Feature.short_name',
									'count(Feature.short_name)'),
									'group' => 'Feature.short_name',
									'contain' => false,
									'conditions' => array('Location.customer_id' => $customer_val )
		
							)
					));
				
				
			#### END ADDED RE3 #############
			
			#DNS Total
			$this->set('DNCount', $this->Dns->find('count',
					array(
						'conditions' => array('Location.customer_id' => $customer_val )
					)
				)
			);
			
			#DNS Total
			$this->set('DNAvailCount', $this->Dns->find('count',
					array(
						'conditions' => array('Dns.function' => NULL, 'Location.customer_id' => $customer_val )
					)
				)
			);
			#DNS Total
			$this->set('DNUsedCount', $this->Dns->find('count',
					array(
						'conditions' => array('Dns.function !=' => '', 'Location.customer_id' => $customer_val )
					)
				)
			);
			
			#Total
			$this->set('groupTypeTotalCount', $this->Dns->find('count',
					array(
						'contain' => false,
						'conditions' => array('Dns.function NOT' => array('INDIVIDUAL', '', 'CFRA', 'INTERNAL'), 'Location.customer_id' => $customer_val )
					)
				)
			);
			
			#Analogue/CICM 
			#$this->set('stationTypeCount', $this->Station->find('all',
			#array(
			#	'fields' => array(
			#	'Station.type', 
			#	'count(Station.type)'),  
			#	'group' => 'Station.type',
			#	'conditions' => array('Station.customer_id' => $customer_val))
			#));
			
			#Phone type
			$this->set('phoneTypeCount', $this->Station->find('all',
			array(
				'fields' => array(
				'Station.phone_type', 
				'count(Station.phone_type)'),  
				'group' => 'Station.phone_type',
				'conditions' => array('Station.customer_id' => $customer_val))
			));
			
			#Total
			$this->set('phoneTypeTotalCount', $this->Station->find('count',
					array(
						'conditions' => array('Station.customer_id' => $customer_val)
					)
				)
			);
			
			$this->set('phoneTypeCountNull', $this->Station->find('count',
			array('conditions' => array('phone_type' => NULL, 'Station.customer_id' => $customer_val))));
			
			#SIMRING not ''
			$this->set('simCount', $this->Station->find('count',
					array(
						'conditions' => array('Station.customer_id' => $customer_val, 'SIMRING !=' => '')
					)
				)
			);
			
			# CTI.
			
			$this->set('ctiTypeCount', $this->Station->find('count',
					array(
						'conditions' => array('Station.customer_id' => $customer_val, 'Station.CTI' => '1')
					)
				)
			);
			
			# COMBOX.
			
			$this->set('comboxTypeCount', $this->Station->find('count',
					array(
						'conditions' => array('Station.customer_id' => $customer_val, 'COMBOX' => '1')
					)
				)
			);
			#Expansion keys 
			$this->set('expTypeCount', $this->Station->find('all',
			array(
				'fields' => array(
				'Station.extensions', 
				'count(Station.extensions)'),  
				'group' => 'Station.extensions',
				'conditions' => array('Station.customer_id' => $customer_val))
			));
		 }
		 else
		 {
			
			# CUST TOTAL.
			
			$this->set('custCount', $this->Customer->find('count'));
			
			# ONB TOTAL.
			
			$this->set('onbCount', $this->Customer->find('count',
					array(
						'conditions' => array('ONB' => '1')
					)
				)
			);
			
			# cTI TOTAL.
			
			$this->set('ctiCustCount', $this->Customer->find('count',
					array(
						'conditions' => array('CTI' => '1')
					)
				)
			);
			
			# NSC TOTAL.
			
			$this->set('nscCount', $this->Customer->find('count',
					array(
						'conditions' => array('NSC' => '1')
					)
				)
			);
			
			# CUSTOMER TYPES
			
			$this->set('customerTypeCount', $this->Customer->find('all',
			array(
				'fields' => array('Customer.type', 'count(Customer.type)'),  
				'group' => 'Customer.type')));
				
				

			# CD.
			
			$this->set('cdTypeCount', $this->Customer->find('count',
					array(
						'conditions' => array('CD' => '1')
					)
				)
			);
			
			# OC.
			
			$this->set('ocTypeCount', $this->Customer->find('count',
					array(
						'conditions' => array('OC' => '1')
					)
				)
			);
			
			# CTI.
			
			$this->set('ctiTypeCount', $this->Station->find('count',
					array(
						'conditions' => array('Station.CTI' => '1')
					)
				)
			);
			
			# COMBOX.
			
			$this->set('comboxTypeCount', $this->Station->find('count',
					array(
						'conditions' => array('COMBOX' => '1')
					)
				)
			);
			
			$this->set('slaCount', $this->Customer->find('count',
					array(
						'conditions' => array('SLA !=' => '')
					)
				)
			);
			
			#SLA
			$this->set('slaTypeCount', $this->Customer->find('all',
			array(
				'fields' => array(
				'Customer.SLA', 
				'count(Customer.SLA)'),  
				'group' => 'Customer.SLA')
			));
			

			$this->set('groupTypeCount', $this->Dns->find('all',
			array(
				'fields' => array(
				'Dns.function', 
				'count(Dns.function)'),  
				'group' => 'Dns.function',
				'contain' => false,
				'conditions' => array('Dns.function NOT' => array('INDIVIDUAL', '', 'INTERNAL', 'CFRA'))
				)
			));
			
			####ADDED RE3 #############
			
			#location
			
			
			#Total
			$this->set('locTotalCount', $this->Location->find('count',
			array(
			'contain' => false,
			)
			)
			);
			
			#Trunk
			
			#Total
			$this->set('trunkTotalCount', $this->Trunk->find('count',
			array(
			'contain' => false,
			)
			)
			);
			#$this->set('trunkTypeCount', $this->Trunk->find('all',
			#array(
			#'fields' => array(
			#'Trunk.gate_type',
			#'Trunk.channel',
			#'count(Trunk.gate_type)'
			#),
			#'group' => array('Trunk.gate_type','Trunk.channel'),
			#'contain' => false,
			
			#)
			#));
			
			$trunk_type = $this->Trunk->find('all',
					array(
							'fields' => array(
									'Location.id',
									'Trunk.gate_type',
									'count(Trunk.gate_type)',
							'sum(Trunk.channel)'),
							'group' => 'Trunk.gate_type'
					)
			);
				
			#$trunk_Array = print_r($trunk_type, true);
			#$this->log("Customer controller : TRunk stats " . $trunk_Array, LOG_DEBUG);
				
			$this->set('trunkTypeCount',$trunk_type);
			
			#Mediatrix
				
			#Total
			$this->set('mediatrixTotalCount', $this->Mediatrix->find('count',
			array(
						'contain' => false,
			)
			)
			);
			$this->set('mediatrixTypeCount', $this->Mediatrix->find('all',
					array(
							'fields' => array(
									'Mediatrix.type',
									'count(Mediatrix.type)'),
									'group' => 'Mediatrix.type',
							'contain' => false,
										
							)
					));
			
			
			#Mediatrix Port Total
			$this->set('portCount', $this->Port->find('count', array('contain' => false)));
			
			$this->set('portAvailCount', $this->Port->find('count',
					array(
								'contain' => false,
								'conditions' => array('Port.station_id' => '')
										)
			)
			);
			
			$this->set('portUsedCount', $this->Port->find('count',
			array(
			'contain' => false,
			'conditions' => array('Port.station_id !=' => '')
					)
			)
			);
			
			#ODS
			
			#Total
			$this->set('scenarioTotalCount', $this->Scenario->find('count',
			array(
					'contain' => false,
			)
							)
			);
			$this->set('scenarioTypeCount', $this->Scenario->find('all',
					array(
							'fields' => array(
									'Scenario.status',
									'count(Scenario.status)'),
					'group' => 'Scenario.status',
					'contain' => false,
			
							)
			));
			
			#Features
				
			
			$this->set('featureTypeCount', $this->Feature->find('all',
					array(
							'fields' => array(
									'Feature.short_name',
									'count(Feature.short_name)'),
									'group' => 'Feature.short_name',
									'contain' => false,
		
							)
					));
				
				
			#### END ADDED RE3 #############
			
			#Total
			$this->set('groupTypeTotalCount', $this->Dns->find('count',
					array(
						'contain' => false,
						'conditions' => array('Dns.function NOT' => array('INDIVIDUAL', '', 'CFRA', 'INTERNAL'))
					)
				)
			);
			
			#Expansion keys 
			$this->set('expTypeCount', $this->Station->find('all',
			array(
				'fields' => array(
				'Station.extensions', 
				'count(Station.extensions)'),  
				'group' => 'Station.extensions'
			)
			));
			
			#DNS Total
			$this->set('DNCount', $this->Dns->find('count', array('contain' => false)));		
			#DNS Total
			$this->set('DNAvailCount', $this->Dns->find('count',
					array(
						'contain' => false,
						'conditions' => array('Dns.function' => NULL)
					)
				)
			);
			#DNS Total
			$this->set('DNUsedCount', $this->Dns->find('count',
					array(
						'contain' => false,
						'conditions' => array('Dns.function !=' => '')
					)
				)
			);
			
			# CFRA.
			
			$this->set('cfraTypeCount', $this->Station->find('all',
					array(
						'fields' => array(
							'customer_id',
							'count(customer_id)'
						),  
						'conditions' => array('CFRA' => '1'),
						'group' => 'customer_id'
					)
				)
			);
			
						#Total
			$this->set('statcfraCount', $this->Station->find('count',
					array(
						'conditions' => array('CFRA' => '1')
					)
				)
			);
			
			#Analogue/CICM 
			$this->set('stationTypeCount', $this->Station->find('all',
			array(
				'fields' => array(
				'Station.type', 
				'count(Station.type)'),  
				'group' => 'Station.type',
				'conditions' => array('Station.status !=' => 2))
			));
			
			#Total
			$this->set('portTypeTotalCount', $this->Station->find('count',
					array(
						'conditions' => array('Station.type'=>array('CICM', 'ANLG'))
					)
				)
			);
			
			#Phone type
			#$this->set('phoneTypeCount', $this->Station->find('all',
			#array(
			#	'fields' => array(
			#	'COALESCE(Station.phone_type, \'lank\') AS phone_type', 
			#	'count(COALESCE(Station.phone_type)) AS count'),  
			#	'group' => 'COALESCE(Station.phone_type)')
			#));
			#$this->set('phoneTypeCount', $this->Station->find('all',
			#array(
			#	'fields' => array(
			#	'Station.phone_type','count(Station.phone_type)'
			#	),  
			#	'conditions' => array('phone_type !=' => ''),
			#	'group' => 'Station.phone_type')
			#));
			

			$this->set('phoneTypeCount',  $this->Station->find('all',
			array(
				'fields' => array(
				'Station.phone_type','count(Station.phone_type)'
				),  
				'conditions' => array('phone_type !=' => ''),
				'group' => 'Station.phone_type')
			));
			$this->set('phoneTypeCountNull', $this->Station->find('count',
			array('conditions' => array('phone_type' => NULL))));
			
						#Total
			$this->set('phoneTypeTotalCount', $this->Station->find('count'));
			
			#SIMRING not ''
			$this->set('simCount', $this->Station->find('count',
					array(
						'conditions' => array('SIMRING !=' => '')
					)
				)
			);
			
			################Usage################
			
			#
			#$this->set('intLogonCount', $this->Log->find('count',
			#		array(
			#			'conditions' => array('customer' => '')
			#		)
			#	)
			#);
			#$this->set('extLogonCount', $this->Log->find('count',
			#		array(
			#			'conditions' => array('customer' => '')
			#		)
			#	)
			#);
#			$this->set('totalGateLogonCount', $this->Log->find('count',
#					array(
#						'conditions' => array('Log.log_entry' => 'User Logged In', 'Log.app_type' => 'Gate')
#					)
#				)
#			);
#			$this->set('totalPhoneLogonCount', $this->Log->find('count',
#					array(
#						'conditions' => array('Log.log_entry' => 'User Logged In', 'Log.app_type' => 'Phone')
#					)
#				)
#			);
#			
#			$this->set('phoneLogonCount', $this->Log->find('all',
#			array(
#				'fields' => array(
#					'Log.customer_id', 
#					'count(Log.id)'),  
#				'group' => 'Log.customer_id',
#				'conditions' => array('Log.log_entry' => 'User Logged In', 'Log.app_type' => 'Phone'))
#			));
#			
#			$this->set('gateLogonCount', $this->Log->find('all',
#			array(
#				'fields' => array(
#					'Log.customer_id', 
#					'count(Log.id)'),  
#				'group' => 'Log.customer_id',
#				'conditions' => array('Log.log_entry' => 'User Logged In', 'Log.app_type' => 'Gate'))
#			));
#			
#			$this->set('phoneUsageCount', $this->Log->find('all',
#			array(
#				'fields' => array(
#					'SUBSTRING_INDEX(log_entry, \':\', \'+1\') as sub', 
#					'count(Log.id)'),  
#				'group' => 'sub',
#				'conditions' => array('Log.app_type' => 'Phone', 'Log.log_entry !=' => 'User Logged In'))
#			));
#						
#			$this->set('gateUsageCount', $this->Log->find('all',
#			array(
#				'fields' => array(
#					'SUBSTRING_INDEX(log_entry, \':\', \'+1\') as sub', 
#					'count(Log.id)'),  
#				'group' => 'sub',
#				'conditions' => array('Log.app_type' => 'Gate', 'Log.log_entry !=' => 'User Logged In'))
#			));
#			
#						
#			
		 }
	}
	
	function customeredit($customer_id = null) {
		$this->layout = 'ajax';
		$this->pageTitle = 'Customer Edit';		
		$this->paginate['Paginate']	=	$this->AutoPaginate->setPaginate();	
		$this->Customer->recursive = -1;		
		$cond = array('Customer.status'=>1);
		$customer_id=isset($this->params['url']['customer_id'])?$this->params['url']['customer_id']:(isset($this->params['named']['customer_id'])?$this->params['named']['customer_id']:"");
		if($customer_id!=''){
			$cond = array_merge($cond,array('Customer.id'=>$customer_id));
			$this->passedArgs['customerid'] = $customer_id;
			
		}
		
		#Workaround to handle the customer id id being sent as a parameter.
		
		unset($this->_Filter['Customer.cid']);		
		#-------------------------------------------------------------
				
		$this->paginate= array('conditions'=>$cond, 'fields'=>array('*'),'limit' => $this->paginate['limit']);		
		$condition_array=print_r($cond, true);
		$this->log("Customer controller : Setting sesion conditions : $condition_array", LOG_DEBUG);

		$this->Session->write('cond',serialize($cond));
		$customers_for_view = $this->paginate(null, $this->_Filter);		
		
		#echo "<pre>";print_r($customers_for_view);		
		$this->set('customers', $customers_for_view);				
		foreach($customers_for_view as $custdata)
		{
						
			       /* $custIds['Customer']['id'];			
                    $custIds['Customer']['name'];
                    $custIds['Customer']['bsk'];
                    $custIds['Customer']['type'];
										
                    $custdata['Customer']['status'];                    
                    $custdata['Customer']['moh_id'];
                    $custdata['Customer']['presentation_group'];
                    $custdata['Customer']['onDemand'];
                    $custdata['Customer']['SLA'];
                    $custdata['Customer']['CTI'];
                    $custdata['Customer']['NSC'];
                    $custdata['Customer']['ONB'];
                    $custdata['Customer']['CD'];
                    $custdata['Customer']['OC'];
                    $custdata['Customer']['Info1'];
                    $custdata['Customer']['Info2'];
                    $custdata['Customer']['Info3'];
                    $custdata['Customer']['cicm'];
                    $custdata['Customer']['free_ports'];
                    $custdata['Customer']['netcgid'];
                    $custdata['Customer']['adnumid'];
                    $custdata['Customer']['netnameid'];
					$custdata['Customer']['created'];
                    $custdata['Customer']['modified'];*/
			
		}
		
	
		
		
		$customertypes = $this->Customer->find('all', array('conditions' => array("Customer.status" => '1','Customer.type !='=>" "), 'group' => 'Customer.type'));
				
		$options=array();
		foreach($customertypes as $customertype){
			$custype = $customertype['Customer']['type'];
			$options[$custype]=$custype;
		}
						
		$this->set('customerTypes',$options);
		
		$this->set('custdata',$custdata);
		$this->set('customerid',$customer_id);
			
		
	}
	
	
	function updatecustomer($customer_id = null) {
		
		
	   $this->autoRender = false;
	   $this->Customer->create();
	   $this->Customer->save($this->data['Customer']);
	 
	 
	  
	
	}
	
	/**
	* function toggleView()
	* 
	* @return
	*/
	
	function toggleView() {
   
        $this->layout = false;
        
        $customer_id = isset($this->params['url']['customer_id']) ? $this->params['url']['customer_id'] : (isset($this->params['named']['customer_id']) ? $this->params['named']['customer_id'] : "");
        
        $view = isset($this->params['url']['view']) ? $this->params['url']['view'] : (isset($this->params['named']['view']) ? $this->params['named']['view'] : "");
       
        $this->Session->delete('VIEWMODE');
        if($view == 'EXTERNAL')
        {
        	$this->Session->write('VIEWMODE', 'EXTERNAL');
        }
       
     
        $this->redirect('edit/customer_id:' . $customer_id );
        
    }	
	
	function uploadf() {
		
		
		$imageName = $this->data['Customers']['image_name']["name"];
		
		if (strpos($imageName,'prodUpload') !== false) {
			   
			}
			
					
		
		
		 $customer_id = isset($this->params['url']['customer_id']) ? $this->params['url']['customer_id'] : (isset($this->params['named']['customer_id']) ? $this->params['named']['customer_id'] : "");
		 
		 $this->set('customer_id',$customer_id);
		 if($this->data[Customers][CustomerId]!=""){
		 	 $customer_id= $this->data['Customers']['CustomerId'];
		 }
		
		
		
	
		$this->layout = 'ajax';
		
		#new upload mechanism
		$log_string = $customer_id . ' || ' . $this->Session->read('USERNAME') . ' | MoH File Upload ||';
		$this->log($log_string, 'activity');
		$log = 'MoH File Update : ';
		$insert = array (
			'Log' => array (
			'affected_obj' => '',
			'log_entry' => $log,
			'created' => date('Y-m-d H:i:s'),
			'status' => 1,
			'customer_id' => $customer_id ,
			'bsk' => $this->Session->read('BSK'),
			'user' => $this->Session->read('ACCOUNTNAME'),
			'app_type' => $this->Session->read('APPNAME'),
			'modified' => '0000-00-00 00:00:00',
			'modification_status' => '1',
			'modification_response' => 'na'
		)
		);
		
		
		$this->Log->create();
		$this->Log->save($insert, false);
		/**************activity log*****************/
		$this->set('status', 0);
		if(empty($this->params['named']['customer_id'])){
	
			if(!empty($this->data['Customers']['image_name']["name"])){
		
				if ($this->data['Customers']['image_name']["error"] > 0) {
					//CBM $this->set('msg' ,'Error in upload');
					$this->set('msg', __('Error in upload', true));
				} else {
					
					#!Handle prod uploads
				   if (strpos($imageName,'prodUpload') !== false) {
				   	
						//Get Music on hold ID from DB
						$mohId = $this->Customer->field('moh_id', array (
						'id =' => $_POST['customerID']
						));
				 
						// call webserver
						
						$result = move_uploaded_file($this->data['Customers']['image_name']["tmp_name"], Configure :: read('upload_url') . str_replace(' ', '-', strtolower($this->data['Customers']['image_name']["name"])));
						
						$this->set('status', 1);
						if ($result == 1) {
							$_SESSION['success_msg1'] = 'File Transferred Successfully' ;
							$this->set('success','File Transferred Successfully');
							$this->set('success', __('File Transferred Successfully', true));
							 echo '<div class="notification first" style="width: 100%" >		
						<div class="ok"><div class="message">'.__('File Transferred Successfully',true).'</div></div></div>';
							exit;
						}else {
					           echo '<div class="notification first" ><div class="error"><div class="message">'.__('File Not Transferred',true).'</div></div></div>';
						     $_SESSION['success_msg2'] = 'Maximum file size => 10M' ;
							$this->set('error', $_SESSION['error']);
							 exit;
						}
					
					}
					else
					{
				  
						#if($_FILES["file"]["type"]=='audio/x-wav'){// ALLOW ONLY WAV FILE
						if (($this->data['Customers']['image_name']["type"] == 'audio/x-wav') || ($this->data['Customers']['image_name']["type"] == 'audio/wav') || ($this->data['Customers']['image_name']["type"] == 'audio/mpeg'||$this->data['Customers']['image_name']["type"] =='image/jpeg')) 
						
						{ // ALLOW ONLY WAV OR MP3 FILE
						
							#Check file does not exceed the maximum
							if ($this->data['Customers']['image_name']["size"]/1024  < 10240) {
													
								//Get Music on hold ID from DB
								$mohId = $this->Customer->field('moh_id', array (
								'id =' => $customer_id
								));
						 
								// call webserver
								$result = move_uploaded_file($this->data['Customers']['image_name']["tmp_name"], Configure :: read('upload_url') . str_replace(' ', '-', strtolower($this->data['Customers']['image_name']["name"])));
								//$result = $this->TransferMoh->uploadMoH($_FILES["file"]["tmp_name"],$this->Session->read('SELECTED_CUSTOMER'));
								$result = $this->TransferMoh->uploadMoH(Configure :: read('upload_url') . str_replace(' ', '-', strtolower($this->data['Customers']['image_name']["name"])),$mohId);
								
								$this->set('status', 1);
								if ($result == 1) 
								{
									$_SESSION['success_msg1'] = 'File Transferred Successfully' ;
									$this->set('success','File Transferred Successfully');
									$this->set('success', __('File Transferred Successfully', true));
									 echo '<div class="notification first" style="width: 100%" >		
									<div class="ok"><div class="message">'.__('File Transferred Successfully',true).'</div></div></div>';
									exit;
									
								} 
								else 
								{
									echo '<div class="notification first" >
									<div class="error">
									<div class="message">'.__('File Not Transferred',true).'</div>
									</div>
									</div>';
									
									$_SESSION['success_msg2'] = 'Maximum file size => 10M' ;
									
									$this->set('error', $_SESSION['error']);
									
									 //$this->redirect('edit/customer_id:' . $customer_id );
									 exit;
								}
							} 
							else 
							{
								   
								 
								echo '<div class="notification first" >
								<div class="error">
								<div class="message">'.__('Maximum file size => 10M',true).'</div>
								</div>
								</div>'; 
			
								 $_SESSION['success_msg2'] = 'Maximum file size => 10M' ;
			
								$this->set('error', $_SESSION['error']);
			
								exit;
								
							}
						} 
						else 
						{
							
							echo '<div class="notification first" >
							<div class="error">
							<div class="message">'.__('only .wav and .mp3 files are allowed',true).'</div>
							</div>
							</div>'; 
					
							exit;
							
						}
					}
				#delete file after upload
				//unlink(Configure :: read('upload_url') . str_replace(' ', '-', strtolower($this->data['Station']['image_name']["name"])));
				
				
				}
			}
			else
			{
				
				echo '<div class="notification first" style="width:100%" >
					<div class="error">
						<div class="message">'.__('no file selected',true).'</div>
					</div>
				</div>'; 
				//$this->redirect('edit/customer_id:' . $customer_id );
							exit;
			}
		}
	
		$this->set('title_header', __('Swisscom Extranet Corporate Business - Voiphone Selfcare', true));
		
	}//end uploadf
	
}
?>
