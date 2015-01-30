<?php

#-----------------------------------------------------------------#
# $Rev:: 40            $:  Revision of last commit                #
#-----------------------------------------------------------------#

/* Controller for  station
 *	Develeoper	:	Mano
 *	Date		:	05 JULY 2010
 */
class LogsController  extends AppController {
	
	/**
	 * name property
	 * @var string 'Stations'
	 * @access public
	 */
		var $name = 'Logs';
		var $uses = array('Station','Stationkey','Feature','Location','Log','Userlog','Customer', 'Scenario');
	
		// load any helpers used in the views
		var $helpers = array('Html', 'Form', 'Javascript', 'Paginator');
		var $paginate = array('Paginate' => 15, 'page' => 1);
		var $components = array('Authentication','Pagination', 'RequestHandler');

		
	function beforeFilter (){
		
		parent::beforeFilter();
		
		if(!$this->Session->read('SELECTED_CUSTOMER')){
			$this->layout='ajax';
			$this->cakeError('sessionExpired'); 
		}
		#if($this->Session->read('APPNAME') != 'Phone')
		#{
			#$this->log('PHONE USER TRIED TO ACCESS GATE PAGE APP => ' . $this->Session->read('APPNAME'), LOG_DEBUG);
			//$this->layout='ajax';
			//$this->cakeError('accessDenied'); 
			#$this->redirect('/customers');
			#exit();
			
		#}
		
	}
		
	/**
	 * function for viewing the log file
	 *
	 * @param int  $station_id
	 */
	
	function viewlog($customer_id = null){
		
		$this->paginate['Paginate']	= $this->AutoPaginate->setPaginate();
		
		$this->log("Log controller : Start of view_log for customer_id -> $customer_id", LOG_DEBUG);
		$this->pageTitle = 'Logs';
		$this->set('title_header', __('Swisscom Extranet Corporate Business - Voiphone Selfcare', true));
		$cond =array();
		#$station_id=isset($this->params['url']['station_id'])?$this->params['url']['station_id']:(isset($this->params['named']['station_id'])?$this->params['named']['station_id']:"");
		
			#$this->set('station_id',$station_id);
			$id='';
			#if($this->Session->read('SELECTED_CUSTOMER')!=Configure::read('access_id')){
			#	$location	=	$this->Station->find('all',array('conditions'=>array("Station.status"=>Configure::read('status'),'Station.id'=>$station_id)));
			#	$id=$this->Session->read('SELECTED_CUSTOMER');
			#	if($location[0]['Location']['customer_id']!=$id){
			#		$this->layout='ajax';
			#		$this->cakeError('accessDenied');
			#	}
			#}
			
			if($this->Session->read('SELECTED_CUSTOMER')!=Configure::read('access_id')){
				
				$id = $this->Session->read('SELECTED_CUSTOMER');
				$customer_id=isset($this->params['url']['customer_id'])?$this->params['url']['customer_id']:(isset($this->params['named']['customer_id'])?$this->params['named']['customer_id']:"");
				#$customer_id=$this->params['url']['customer_id'];
				$cnt = count($this->_Filter);
				$this->log("Log controller : External User $id - accessing $customer_id", LOG_DEBUG);
				if (!$this->Customer->validCustomer($id, $customer_id)) {
					#print_r("not valid $id -> $customer_id");die();
					#$this->redirect('/customers');
					$this->layout='ajax';
					$this->cakeError('accessDenied');
					exit ();
				}

				$this->set('SELECTED_CNN',$customer_id);
			}
			
			$this->loadModel('Customer');
			
			/*
			if($this->Session->read('APPNAME') != 'Phone')
			{
				$cond = array('Log.status'=>'1', 'Log.app_type'=>'Gate');

				$customer = $this->Customer->find('list', array('conditions'=>array('type'=>array('Gate', 'Hybrid')), 'order'=>'Customer.name'));

			}else{
				$cond = array('Log.status'=>'1', 'Log.app_type'=>'Phone');
							$customer = $this->Customer->find('list', array('conditions'=>array('type'=>array('Phone')), 'order'=>'Customer.name'));
			}
			*/
			$customer = $this->Customer->find('list', array('order'=>'Customer.name'));
			$this->set(compact('customer'));
			
			#$cond = array('Log.status'=>'1',);
			 $customer_id=isset($this->params['url']['customer_id'])?$this->params['url']['customer_id']:(isset($this->params['named']['customer_id'])?$this->params['named']['customer_id']:"");
			
			if($customer_id!=''){
				 
				 $cond = array_merge($cond,array('Log.customer_id LIKE'=>'%'.$customer_id.'%'));
				
				#User for left hand Menu navigation.
				
				$this->set('SELECTED_CNN', $customer_id);
				$this->Session->write('cond', serialize($cond));
				$condition_array=print_r($cond, true);
				$this->log("Log controller : Setting sesion conditions : $condition_array", LOG_DEBUG);
				/**end for getting the current customer name*/
				
				#Set below for sort/filter problem where filter arguments not passed to sort
				$this->passedArgs['customer_id'] = $customer_id;
			}
			$affected_obj=isset($this->params['url']['affected_obj'])?$this->params['url']['affected_obj']:(isset($this->params['named']['affected_obj'])?$this->params['named']['affected_obj']:"");
			if($affected_obj!=''){
				$cond = array_merge($cond,array('Log.affected_obj LIKE'=>'%'.$affected_obj.'%'));
				$this->Session->write('cond', serialize($cond));
				$condition_array=print_r($cond, true);
				$this->log("Log controller : Setting sesion conditions : $condition_array", LOG_DEBUG);
				#$this->set('station_id',$station_id);
				
				#Set below for sort/filter problem where filter arguments not passed to sort
				$this->passedArgs['affected_obj'] = $affected_obj;
			}
			$user=isset($this->params['url']['user'])?$this->params['url']['user']:(isset($this->params['named']['user'])?$this->params['named']['user']:"");
			if($user!=''){
				$cond = array_merge($cond,array('Log.user LIKE'=>'%'.$user.'%'));
				$this->Session->write('cond', serialize($cond));
				$condition_array=print_r($cond, true);
				$this->log("Log controller : Setting sesion conditions : $condition_array", LOG_DEBUG);
				
				#Set below for sort/filter problem where filter arguments not passed to sort
				$this->passedArgs['user'] = $user;
			}
			$desc=isset($this->params['url']['log_entry'])?$this->params['url']['log_entry']:(isset($this->params['named']['log_entry'])?$this->params['named']['log_entry']:"");
			if($desc!=''){
				$cond = array_merge($cond,array('Log.log_entry LIKE'=>'%'.$desc.'%'));
			
				$this->Session->write('cond', serialize($cond));
				$condition_array=print_r($cond, true);
				$this->log("Log controller : Setting sesion conditions : $condition_array", LOG_DEBUG);
				
				#Set below for sort/filter problem where filter arguments not passed to sort
				$this->passedArgs['log_entry'] = $desc;
			}
			$status=isset($this->params['url']['status'])?$this->params['url']['status']:(isset($this->params['named']['status'])?$this->params['named']['status']:"");
			if($status!=''){
				$cond = array_merge($cond,array('Log.modification_status'=>$status));
				
				$this->Session->write('cond', serialize($cond));
				$condition_array=print_r($cond, true);
				$this->log("Log controller : Setting sesion conditions : $condition_array", LOG_DEBUG);
				
				#Set below for sort/filter problem where filter arguments not passed to sort
				$this->passedArgs['status'] = $status;
			}
			$id=isset($this->params['url']['id'])?$this->params['url']['id']:(isset($this->params['named']['id'])?$this->params['named']['id']:"");
			if($id!=''){
				$cond = array_merge($cond,array('Log.id'=>$id));
			
				$this->Session->write('cond', serialize($cond));
				$condition_array=print_r($cond, true);
				$this->log("Log controller : Setting sesion conditions : $condition_array", LOG_DEBUG);
			
				#Set below for sort/filter problem where filter arguments not passed to sort
				$this->passedArgs['id'] = $id;
				$this->set('advancedFlag', '1');
			}
			
			
			$afterdateOrig=isset($this->params['url']['afterdate'])?$this->params['url']['afterdate']:(isset($this->params['named']['afterdate'])?$this->params['named']['afterdate']:"");
			$afterdate = preg_replace('~(\d+)\.(\d+)\.(\d+)~', "$1/$2/$3", $afterdateOrig);
			$beforedateOrig=isset($this->params['url']['beforedate'])?$this->params['url']['beforedate']:(isset($this->params['named']['beforedate'])?$this->params['named']['beforedate']:"");
			$beforedate = preg_replace('~(\d+)\.(\d+)\.(\d+)~', "$1/$2/$3", $beforedateOrig);
			
			$aftertime=isset($this->params['url']['aftertime'])?$this->params['url']['aftertime']:(isset($this->params['named']['aftertime'])?$this->params['named']['aftertime']:"");
			$beforetime=isset($this->params['url']['beforetime'])?$this->params['url']['beforetime']:(isset($this->params['named']['beforetime'])?$this->params['named']['beforetime']:"");
			
			
			if($beforedate=='')
			{
					$beforedateOrig = date("d.m.Y");
					$beforedate = date("d/m/Y");
					#$nowTime = date("H:i");
			}
			else
			{
				$this->passedArgs['beforedate'] = $beforedateOrig;
				if($beforetime=='')
				{	
					$beforetime = '00:00';
					$this->passedArgs['beforetime'] = '00:00';
				}
				
				$this->set('advancedFlag', '1');
			}
						
			if($afterdate=='')
			{
					#$afterdateOrig = date("d.m.Y");
					$afterdate = '01/01/2000';
					#$nowTime = date("H:i");
			}
			else
			{
				$this->passedArgs['afterdate'] = $afterdateOrig;
				if($aftertime=='')
				{	
					$this->passedArgs['aftertime'] = '00:00';
				}
				
				$this->set('advancedFlag', '1');
			}
			if($beforetime=='')
			{
				#Adding 2 minutes to the clock to account for differences in times.
				$beforetime = date("H:i", time()+60*2);
				$tempbeforetime = explode(':', $beforetime);
				$beforetimeh = $tempbeforetime[0];
				$beforetimem = $tempbeforetime[1];
				$beforetimes = 0;
			}
			else
			{
				if($beforedateOrig=='')
				{	
					$beforedateOrig = date("d.m.Y");
					#$beforedate = date("d/m/Y");
					#$nowTime = date("H:i");
				}
				$tempbeforetime = explode(':', $beforetime);
				$beforetimeh = $tempbeforetime[0];
				$beforetimem = $tempbeforetime[1];
				$beforetimes = 0;
				
				$this->passedArgs['beforedate'] = $beforedateOrig;
				$this->passedArgs['beforetime'] = $beforetime;
				
				#$this->log("Log controller : Setting passed args :$this->passedArgs['beforedate'] - $this->passedArgs['beforetime'];", LOG_DEBUG);
				
				$this->set('advancedFlag', '1');
			}
						
			if($aftertime=='')
			{
				$aftertime = '00:00';
				$aftertimeh = 00;
				$aftertimem = 00;
				$aftertimes = 0;
			}
			else
			{
				if($afterdateOrig=='')
				{	
					$afterdateOrig = date("d.m.Y");
					$afterdate = date("d/m/Y");
					#$nowTime = date("H:i");
				}
				$tempaftertime = explode(':', $aftertime);
				$aftertimeh = $tempaftertime[0];
				$aftertimem = $tempaftertime[1];
				$aftertimes = 0;
				
				$this->passedArgs['afterdate'] = $afterdateOrig;
				$this->passedArgs['aftertime'] = $aftertime;
				#$this->log("Log controller : Setting passed args :$this->passedArgs['afterdate'] - $this->passedArgs['aftertime'];", LOG_DEBUG);
				
				
				#$this->passedArgs['afterdate'] = '99.12.9999';
				$this->set('advancedFlag', '1');
			}
			
			
			#if($afterdate!='' && $beforedate!=''){
				$teampbd=explode("/", $beforedate);
				$teampad=explode("/", $afterdate);
				$befordate = date("Y-m-d H:i:s", mktime($beforetimeh, $beforetimem, $beforetimes, $teampbd[1], $teampbd[0], $teampbd[2]));
				$afterdate = date("Y-m-d H:i:s", mktime($aftertimeh, $aftertimem, $aftertimes, $teampad[1], $teampad[0], $teampad[2]));
				$cond = array_merge($cond,array('Log.created BETWEEN ? AND ?'=> array($afterdate , $befordate)));
				$this->Session->write('cond', serialize($cond));
				$condition_array=print_r($cond, true);
				$this->log("Log controller : Setting sesion conditions : $condition_array", LOG_DEBUG);
				#$befordate = date("Y-m-d", mktime(0, 0, 0, $teampbd[1], $teampbd[0], $teampbd[2]));
				#$cond = array_merge($cond,array('Log.created < '=>date('Y-m-d', strtotime($befordate))));
				
				#Set below for sort/filter problem where filter arguments not passed to sort
				
				
				
				
				
			#}else if($beforedate=='' && $afterdate !=''){
			#	$teampad=explode("/", $afterdate);
			#	$aftdate = date("Y-m-d", mktime(0, 0, 0, $teampad[1], $teampad[0], $teampad[2]));
			#	$cond = array_merge($cond,array('Log.created > '=> date('Y-m-d', strtotime($aftdate))));
			#	$this->Session->write('cond', serialize($cond));
			#	$condition_array=print_r($cond, true);
			#	$this->log("Log controller : Setting sesion conditions : $condition_array", LOG_DEBUG);
			#	
			#	#Set below for sort/filter problem where filter arguments not passed to sort
			#	$this->passedArgs['afterdate'] = $afterdate;
			#}
			
		
			if($id){
				#$this->Session->write('cond', serialize($cond));
				#$condition_array=print_r($cond, true);
				#$this->log("Log controller : 1Setting sesion conditions : $condition_array", LOG_DEBUG);
				$this->paginate = array('limit' => $this->paginate['limit'],'conditions'=>$cond, 'order'=>'Log.created desc'); 
			}else{
				#$this->Session->write('cond', serialize($cond));
				#$condition_array=print_r($cond, true);
				#$this->log("Log controller : 2Setting sesion conditions : $condition_array", LOG_DEBUG);
				$this->paginate = array('limit' => $this->paginate['limit'],'conditions'=>$cond, 'order'=>'Log.created desc'); 
			}
			$station = $this->Station->findById($station_id);
			
			
			#$this->Session->write('cond', serialize($cond));
						
			#$this->loadModel('Customer');
			#$customer = $this->Customer->find('list', array=>('conditions'=>array('type'=>array('Gate', 'Hybrid'))));
			#$this->set(compact('customer'));
			
			/**these for getting the current customer name*/
			if(isset($station['Customer']['name']))
				$this->set('SELECTED_CUSTOMER_NAME',$station['Customer']['name']);
			/**end for getting the current customer name*/
			

			$loginfo = $this->paginate('Log');
			
			$this->set('loginfo',$loginfo);
			$this->set('station','');
			$this->set('customerid',$station['Station']['customer_id']);
			#$this->set('SELECTED_CNN',$station['Station']['customer_id']);
			$customerInfo = $this->Customer->findById($customer_id);
            		if(isset($customer_id))
            		{
                   		$this->set('selected_customer',  $customerInfo['Customer']['name']);
            		}
            		else
            		{
                   		$this->set('selected_customer', 'UNDEF');
		
            		}
			#$this->Session->write('cond', serialize($cond));
	
	}
	/**
	 * function for getting the changed values from the log
	 *
	 * @param int $log_id
	 */
	function logdetails ($log_id=null){

	
		$log			=	$this->Log->find('first',array('conditions'=>array('Log.id'=>$log_id)));
		
		$this->loadModel('Transaction');
		
		$transactiondata = $this->Transaction->findById($log['Log']['transaction_id']);
		$log['Transaction'] = $transactiondata['Transaction'];
		
		$this->loadModel('Station');
		$stationID = $log['Log']['affected_obj'];
		$stationdata = $this->Station->findById($stationID);
		$log['Station'] = $stationdata['Station'];
		
		
		$loginfo		=	$log['Log'];
		
		$this->update	=	$log['Log'];
		$this->layout	=	'ajax';
		
	
		#if((isset($log['Log']['affected_obj'])) && (isset($log['Log']['affected_obj_type'])) && (!(isset($log['Log']['affected_obj_name']))))
		#if((isset($log['Log']['affected_obj'])) && (isset($log['Log']['affected_obj_type'])))
		#{
		#	$objDetails = $this->$log['Log']['affected_obj_type']->findById($log['Log']['affected_obj']);
		#	$this->set('affected_obj_name_found',$objDetails[$log['Log']['affected_obj_type']]['affected_obj_name']);
		#}
		#else 
		#{
		#	$this->set('affected_obj_name_found',$log['Log']['affected_obj_name']);
		#}
		$this->set('display',$this->update);
		$this->set('transaction',$log['Transaction']);
		$this->set('stationdata',$log['Station']);

	}
	/**
	 * function for storing the changed values in the xml
	 *
	 */





        
/* start for xml read     */              
	function _read ($action) {
		
			$path=Configure::read('upload_url').$action.'.xml';
	
		    $xml = @simplexml_load_file($path);
			if(empty($xml)){
				return 'empty';
			}
		    $res	=	$this->_xml2array($xml);
		    

		    if($action=='res'){
		   		$record['id']		 = $res['children']['transaction']['attr']['id'];
		   		$record['response']	 = $res['children']['transaction']['attr']['response'];
		   		$record['status']	 = $res['children']['transaction']['attr']['status'];
		   		return $record;
		    }
	   		else 
	   			return $res['children']['transaction']['attr']['id'];
	}
	
	
	//function for export station data in csv format.
	function export()
	{
		
		$this->layout = ""; 
		$conds = unserialize($this->Session->read('cond'));
		$this->log("Log controller : Reading sesion conditions : $conds", LOG_DEBUG);
		$filename = "export_logs_".date("Y.m.d").".csv";
		$csv_file = fopen('php://output', 'w');
		header('Content-type: application/csv');
		header('Content-Disposition: attachment; filename="'.$filename.'"');
		$this->loadModel('Log');
		$results = $this->Log->find('all',array('fields' => array('Log.customer_id', 'Log.bsk', 'Log.affected_obj', 'Log.created', 'Log.user', 'Log.log_entry','Log.status'),'recursive'=>-1, 'order'=>'Log.created DESC','conditions' => $conds)); 
		$header_row = array(__("S.No.", true), __("Customer ID", true), __("BSK", true), __("Affected Object", true), __("Date", true), __("User", true), __("Description", true), __("Status"));
		fputcsv($csv_file,$header_row,';','"');
	
		// Each iteration of this while loop will be a row in your .csv file where each field corresponds to the heading of the column
		$i=1;
		foreach($results as $result)
		{
			$status ='';
			if($result['Log']['status']=='1'){
			$status = 'Success';
			}else{
			$status = 'Failed';
			}
			// Array indexes correspond to the field names in your db table(s)
			$row = array(
				$result['Log']['Sno']= $i,
				$result['Log']['customer_id'],
				$result['Log']['bsk'],
				$result['Log']['affected_obj'],
				$result['Log']['created'],
				$result['Log']['user'],
				$result['Log']['log_entry'],
				$status
			);
			$i++;
			fputcsv($csv_file,$row,';','"');
		}
	
		fclose($csv_file);exit();
	}
	
	function reports() {
		if(isset($_POST['customer']))
		{
			$customer_val=$_POST['customer'];
		}
		else
		{
	
			$customer_val='GLOBAL';
		}
	
	
		$this->pageTitle = 'UsageReports';
	
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
	   /****   added by Diwakar */
	   			
			$afterdateOrig=isset($this->params['url']['afterdate'])?$this->params['url']['afterdate']:(isset($this->params['named']['afterdate'])?$this->params['named']['afterdate']:"");
			$afterdate = preg_replace('~(\d+)\.(\d+)\.(\d+)~', "$1/$2/$3", $afterdateOrig);
			$beforedateOrig=isset($this->params['url']['beforedate'])?$this->params['url']['beforedate']:(isset($this->params['named']['beforedate'])?$this->params['named']['beforedate']:"");
			$beforedate = preg_replace('~(\d+)\.(\d+)\.(\d+)~', "$1/$2/$3", $beforedateOrig);
			
			$aftertime=isset($this->params['url']['aftertime'])?$this->params['url']['aftertime']:(isset($this->params['named']['aftertime'])?$this->params['named']['aftertime']:"");
			$beforetime=isset($this->params['url']['beforetime'])?$this->params['url']['beforetime']:(isset($this->params['named']['beforetime'])?$this->params['named']['beforetime']:"");
			
			
			if($beforedate=='')
			{
					$beforedateOrig = date("d.m.Y");
					$beforedate = date("d/m/Y");
					#$nowTime = date("H:i");
			}
			else
			{
				$this->passedArgs['beforedate'] = $beforedateOrig;
				if($beforetime=='')
				{	
					$beforetime = '00:00';
					$this->passedArgs['beforetime'] = '00:00';
				}
				
				$this->set('advancedFlag', '1');
			}
						
			if($afterdate=='')
			{
					#$afterdateOrig = date("d.m.Y");
					$afterdate = '01/01/2000';
					#$nowTime = date("H:i");
			}
			else
			{
				$this->passedArgs['afterdate'] = $afterdateOrig;
				if($aftertime=='')
				{	
					$this->passedArgs['aftertime'] = '00:00';
				}
				
				$this->set('advancedFlag', '1');
			}
			if($beforetime=='')
			{
				#Adding 2 minutes to the clock to account for differences in times.
				$beforetime = date("H:i", time()+60*2);
				$tempbeforetime = explode(':', $beforetime);
				$beforetimeh = $tempbeforetime[0];
				$beforetimem = $tempbeforetime[1];
				$beforetimes = 0;
			}
			else
			{
				if($beforedateOrig=='')
				{	
					$beforedateOrig = date("d.m.Y");
					#$beforedate = date("d/m/Y");
					#$nowTime = date("H:i");
				}
				$tempbeforetime = explode(':', $beforetime);
				$beforetimeh = $tempbeforetime[0];
				$beforetimem = $tempbeforetime[1];
				$beforetimes = 0;
				
				$this->passedArgs['beforedate'] = $beforedateOrig;
				$this->passedArgs['beforetime'] = $beforetime;
				
				#$this->log("Log controller : Setting passed args :$this->passedArgs['beforedate'] - $this->passedArgs['beforetime'];", LOG_DEBUG);
				
				$this->set('advancedFlag', '1');
			}
						
			if($aftertime=='')
			{
				$aftertime = '00:00';
				$aftertimeh = 00;
				$aftertimem = 00;
				$aftertimes = 0;
			}
			else
			{
				if($afterdateOrig=='')
				{	
					$afterdateOrig = date("d.m.Y");
					$afterdate = date("d/m/Y");
					#$nowTime = date("H:i");
				}
				$tempaftertime = explode(':', $aftertime);
				$aftertimeh = $tempaftertime[0];
				$aftertimem = $tempaftertime[1];
				$aftertimes = 0;
				
				$this->passedArgs['afterdate'] = $afterdateOrig;
				$this->passedArgs['aftertime'] = $aftertime;
				#$this->log("Log controller : Setting passed args :$this->passedArgs['afterdate'] - $this->passedArgs['aftertime'];", LOG_DEBUG);
				
				
				#$this->passedArgs['afterdate'] = '99.12.9999';
				$this->set('advancedFlag', '1');
			}
			
			
			#if($afterdate!='' && $beforedate!=''){
				$teampbd=explode("/", $beforedate);
				$teampad=explode("/", $afterdate);
				$befordate = date("Y-m-d H:i:s", mktime($beforetimeh, $beforetimem, $beforetimes, $teampbd[1], $teampbd[0], $teampbd[2]));
				$afterdate = date("Y-m-d H:i:s", mktime($aftertimeh, $aftertimem, $aftertimes, $teampad[1], $teampad[0], $teampad[2]));
				$cond =  array($afterdate , $befordate);
				
				//$cond = array_merge($cond,array('Log.created BETWEEN ? AND ?'=> array($afterdate , $befordate)));
				
				$this->Session->write('cond', serialize($cond));
				$condition_array=print_r($cond, true);
				
				
	     /* end of added by Diwakar  */
	
	
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

								
			 }
		 else
			 {
			 	
				
		
			$this->set('totalGateLogonCount', $this->Log->find('count',
						array(
						'conditions' => array('Log.created BETWEEN ? AND ?'=>$cond ,'Log.log_entry' => 'User Logged In', 'Log.app_type' => 'Gate'), 'limit' => 15
										)
						)
						);
			$this->set('totalPhoneLogonCount', $this->Log->find('count',
						array(
						'conditions' => array('Log.created BETWEEN ? AND ?'=>$cond ,'Log.log_entry' => 'User Logged In', 'Log.app_type' => 'Phone'), 'limit' => 15
				)
				)
				);
		
			$this->set('phoneLogonCount', $this->Log->find('all',
				array(
				'fields' => array(
					'Log.customer_id',
						'count(Log.id)'),
						'group' => 'Log.customer_id',
				'conditions' => array('Log.created BETWEEN ? AND ?'=>$cond ,'Log.log_entry' => 'User Logged In', 'Log.app_type' => 'Phone'), 'limit' => 15)
						));
															
			$this->set('gateLogonCount', $this->Log->find('all',
			array(
																'fields' => array(
					'Log.customer_id',
						'count(Log.id)'),
				'group' => 'Log.customer_id',
				'conditions' => array('Log.created BETWEEN ? AND ?'=>$cond ,'Log.log_entry' => 'User Logged In', 'Log.app_type' => 'Gate'), 'limit' => 15)
							));
		
			$this->set('phoneUsageCount', $this->Log->find('all',
			array(
				'fields' => array(
						'SUBSTRING_INDEX(log_entry, \':\', \'+1\') as sub',
						'count(Log.id)'),
					'group' => 'sub',
					'conditions' => array('Log.created BETWEEN ? AND ?'=>$cond ,'Log.app_type' => 'Phone', 'Log.log_entry !=' => 'User Logged In'), 'limit' => 15)
				));
	
				$this->set('gateUsageCount', $this->Log->find('all',
				array(
					'fields' => array(
						'SUBSTRING_INDEX(log_entry, \':\', \'+1\') as sub',
						'count(Log.id)'),
					'group' => 'sub',
					'conditions' => array('Log.created BETWEEN ? AND ?'=>$cond ,'Log.app_type' => 'Gate', 'Log.log_entry !=' => 'User Logged In'), 'limit' => 15)
				));
			
	           
			   $this->set('activationUser', $this->Log->find('all',
				array(
				'fields' => array(
					'Log.user',
						'count(Log.id)'),
						'group' => 'Log.user',
				        'conditions' => array('Log.created BETWEEN ? AND ?'=>$cond, 'Log.log_entry !=' => 'User Logged In'),
					   'order' => 'count(Log.id) desc',
                        'limit' => 15,
						)
					
						));
						
						$this->set('logonUser', $this->Log->find('all',
				array(
				'fields' => array(
					'Log.user',
						'count(Log.id)'),
						'group' => 'Log.user',
						//'group' => 'Log.customer_id',
				        'conditions' => array('Log.created BETWEEN ? AND ?'=>$cond, 'Log.log_entry ' => 'User Logged In'),
					  // 'order' => array('Log.created' => 'desc'),
					  'order' => array('count(Log.user)' => 'desc'),
                        'limit' => 15,
						)
					
						));
						
						/*
						$this->set('logDetails', $this->Log->find('all',
				array(
				'fields' => array(
					'Log.log_details',
						'group' => 'Log.log_details',
				        'conditions' => array('Log.log_details !=' => NULL),
			             'limit' => 15,
						)
					
						)));
						*/
			   
			   
			   
			   
			 }
		}
		function adminreports() {
			if(isset($_POST['customer']))
			{
				$customer_val=$_POST['customer'];
			}
			else
			{
		
				$customer_val='GLOBAL';
			}
			$report=isset($this->params['url']['report'])?$this->params['url']['report']:(isset($this->params['named']['report'])?$this->params['named']['report']:"");
			if(isset($report) && $report != '')	
			{
				
				#$this->passedArgs['afterdate'] = date(time()-6000000);
				$this->params['url']['afterdate'] = date("01.01.2014");
				$this->set('report', $report);
				$repCond = 'Report:%' . $report . '%';
			}
			else
			{
			
				$customer_val='GLOBAL';
				$repCond = 'Report:%';
			}
			
			$this->pageTitle = 'adminReports';
		
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
			/****   added by Diwakar */
			 
					$afterdateOrig=isset($this->params['url']['afterdate'])?$this->params['url']['afterdate']:(isset($this->params['named']['afterdate'])?$this->params['named']['afterdate']:"");
					$afterdate = preg_replace('~(\d+)\.(\d+)\.(\d+)~', "$1/$2/$3", $afterdateOrig);
							$beforedateOrig=isset($this->params['url']['beforedate'])?$this->params['url']['beforedate']:(isset($this->params['named']['beforedate'])?$this->params['named']['beforedate']:"");
							$beforedate = preg_replace('~(\d+)\.(\d+)\.(\d+)~', "$1/$2/$3", $beforedateOrig);
								
									$aftertime=isset($this->params['url']['aftertime'])?$this->params['url']['aftertime']:(isset($this->params['named']['aftertime'])?$this->params['named']['aftertime']:"");
											$beforetime=isset($this->params['url']['beforetime'])?$this->params['url']['beforetime']:(isset($this->params['named']['beforetime'])?$this->params['named']['beforetime']:"");
		
						
					if($beforedate=='')
							{
							$beforedateOrig = date("d.m.Y");
							$beforedate = date("d/m/Y");
							#$nowTime = date("H:i");
							}
							else
							{
							$this->passedArgs['beforedate'] = $beforedateOrig;
							if($beforetime=='')
							{
								$beforetime = '00:00';
										$this->passedArgs['beforetime'] = '00:00';
								}
		
								$this->set('advancedFlag', '1');
							}
		
							if($afterdate=='')
							{
							#$afterdateOrig = date("d.m.Y");
								#$afterdate = '01/01/2000';
								$afterdate = date("d/m/Y");
										#$nowTime = date("H:i");
							}
							else
							{
								$this->passedArgs['afterdate'] = $afterdateOrig;
								if($aftertime=='')
								{
									$this->passedArgs['aftertime'] = '00:00';
								}
		
								$this->set('advancedFlag', '1');
							}
							if($beforetime=='')
							{
								#Adding 70 minutes to the clock to account for differences in times.
								$beforetime = date("H:i", time()+60*70);
								$tempbeforetime = explode(':', $beforetime);
								$beforetimeh = $tempbeforetime[0];
								$beforetimem = $tempbeforetime[1];
								$beforetimes = 0;
							}
							else
							{
								if($beforedateOrig=='')
								{
									$beforedateOrig = date("d.m.Y");
									#$beforedate = date("d/m/Y");
									#$nowTime = date("H:i");
								}
								$tempbeforetime = explode(':', $beforetime);
								$beforetimeh = $tempbeforetime[0];
								$beforetimem = $tempbeforetime[1];
								$beforetimes = 0;
		
								$this->passedArgs['beforedate'] = $beforedateOrig;
								$this->passedArgs['beforetime'] = $beforetime;
		
								#$this->log("Log controller : Setting passed args :$this->passedArgs['beforedate'] - $this->passedArgs['beforetime'];", LOG_DEBUG);
		
								$this->set('advancedFlag', '1');
							}
		
							if($aftertime=='')
							{
								
								$aftertime = '00:00';
							
									$aftertimeh = 00;
									$aftertimem = 00;
									$aftertimes = 0;
							}
							else
							{
								if($afterdateOrig=='')
								{
									$afterdateOrig = date("d.m.Y");
									$afterdate = date("d/m/Y");
									#$nowTime = date("H:i");
								}
								$tempaftertime = explode(':', $aftertime);
								$aftertimeh = $tempaftertime[0];
								$aftertimem = $tempaftertime[1];
								$aftertimes = 0;
		
								$this->passedArgs['afterdate'] = $afterdateOrig;
								$this->passedArgs['aftertime'] = $aftertime;
								#$this->log("Log controller : Setting passed args :$this->passedArgs['afterdate'] - $this->passedArgs['aftertime'];", LOG_DEBUG);
		
		
								#$this->passedArgs['afterdate'] = '99.12.9999';
								$this->set('advancedFlag', '1');
							}
								
								
							#if($afterdate!='' && $beforedate!=''){
							$teampbd=explode("/", $beforedate);
							$teampad=explode("/", $afterdate);
							$befordate = date("Y-m-d H:i:s", mktime($beforetimeh, $beforetimem, $beforetimes, $teampbd[1], $teampbd[0], $teampbd[2]));
							$afterdate = date("Y-m-d H:i:s", mktime($aftertimeh, $aftertimem, $aftertimes, $teampad[1], $teampad[0], $teampad[2]));
							$cond =  array($afterdate , $befordate);
		
			//$cond = array_merge($cond,array('Log.created BETWEEN ? AND ?'=> array($afterdate , $befordate)));
		
			$this->Session->write('cond', serialize($cond));
			$condition_array=print_r($cond, true);
		
		
			/* end of added by Diwakar  */
		
		
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
		
		
			}
			else
			{
						
		
				
					$reportdata = $this->Log->find('all',
							array(
								'fields' => array(
										'Log.id', 
										"substring(log_entry, '8', 100) as title",
										"extractValue(log_details, 'count(/table/tbody/tr)') as recordcount",
										'Log.created'),
								'conditions' => array(
											'Log.created BETWEEN ? AND ?'=>$cond ,
											'Log.log_entry like' => $repCond, 
											'Log.user' => 'System'),
									'order' => array('title', 'Log.created desc')
									
							)
							
					);
		
					$this->set('reportData',$reportdata);
					
					#Available Reports in DB
					
					$availreportdata = $this->Log->find('all',
							array(
									'fields' => array(
									
											"substring(log_entry, '8', 100) as reportName",
											'count(*) as countReports',
											'Log.created'
										
									),
									'conditions' => array(
											'Log.log_entry like' => 'Report:%',
											'Log.user' => 'System'),
											'group' => 'reportName',
											'order' => 'Log.created desc'
										
							)
								
					);
					
					$this->set('availReports',$availreportdata);
					$condition_array=print_r($availreportdata, true);
					$this->log("Log controller : REport data : $condition_array", LOG_DEBUG);
		
		
		
		
		
			}
		}
		function updateInfotext(){
			
			 $log_id=isset($this->params['url']['log_id'])?$this->params['url']['log_id']:(isset($this->params['named']['log_id'])?$this->params['named']['log_id']:"");
			
		 $infoText=isset($this->params['url']['infoText'])?$this->params['url']['infoText']:(isset($this->params['named']['infoText'])?$this->params['named']['infoText']:"");
		 
		 $this->data['Log']['id']=$log_id;
		 $this->data['Log']['info']=$infoText;
		 
		  $this->Log->save($this->data['Log']);
			
		
			exit;
			
			
		}
		
}

?>
