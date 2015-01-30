
<?php

/**
 * Locations Controller
 *
 * file: /app/controllers/Locations_controller.php
 */
class LocationsController extends AppController {

    // good practice to include the name variable
    var $uses = array('Customer', 'Location', 'Dns', 'Mediatrix', 'Trunk', 'Bakom', 'Transaction','Log', 'Bakom', 'Station', 'Stationkey');
    var $name = 'Locations';
    var $paginate = array('Paginate' => 15, 'page' => 1);
    // load any helpers used in the views
    var $helpers = array('Html', 'Form', 'Javascript', 'Js' => array("Jquery"));
    var $components = array (
    		'AlgInterface'
    );
	
	
    function beforeFilter() {
        parent::beforeFilter();
    }

    /**
     * index()
     * main index page of the locaitons page
     * url: /locations/index
     */
    function index($customer_id = NULL) {

        $this->pageTitle = 'Location List';

        
        /**********for case of internal/external users********/
        if ($this->Session->read('SELECTED_CUSTOMER') != Configure :: read('access_id')) {
        	 
        	$id = $this->Session->read('SELECTED_CUSTOMER');
        	 
        	if (!$this->Customer->validCustomer($id,$customer_id)) {
        		$this->log("Locations controller : Index Function: Invalid customer:" . $id . ':' . $customer_id , LOG_DEBUG);
        		$this->redirect('/customers');
        		exit ();
        	}
        	 
        }
        /**********************END*************************/
        
        
     	/*
     	 * 
     	    if ($this->Session->read('SELECTED_CUSTOMER') != Configure::read('access_id')) {
            $id = $this->Session->read('SELECTED_CUSTOMER');
            $cnt = count($this->_Filter);
            $this->_Filter[$cnt] = "Location.customer_id = $id";
        }
        
        */
        $this->paginate['Paginate'] = $this->AutoPaginate->setPaginate();

        // get all formats from database where status = 1
        //$locations = $this->Location->findAll("status=1");
        #User for left hand Menu navigation.

        $this->set('SELECTED_CNN', $customer_id);
        $this->set('SELECTED_CUSTOMER_NAME', $customer_id);

        $this->set('title_header', 'Prototype');


        // Follwoing code use to show delete option.
        #$filter = "Location.id = $id";
        #$results = $this->Dns->find('all',array('conditions'=>array('Location.customer_id'=>$id),'fields'=>array('Dns.*,Location.name'),'order'=>'Location.name asc'));
        //$results = $this->paginate('Dns');
        //pr($results);die;
        #$this->set('dns', $results);

        $Location = $this->Location->findById($customer_id);

        $this->set('title_header', 'Location List');
        $custlabel = $Location['Location']['lbl'];
        $custname = $customer['Location']['name'];
        $custzip = $customer['Location']['plz'];
        $custaddrs = $customer['Location']['address'];
        $custemrgency = $customer['Location']['emer'];
        $this->Session->write('Location.Name', $custName);
        $this->Session->write('Customer.Id', $custId);
        $this->set('cust_for_layout', $custName);
        $this->set('custName', $custName);
		
        $cond = array('Location.status' => 1, 'Location.customer_id' => $customer_id);

        $lbl = isset($this->params['url']['lbl']) ? $this->params['url']['lbl'] : (isset($this->params['named']['lbl']) ? $this->params['named']['lbl'] : "");
        if ($lbl != '') {
            $cond = array_merge($cond, array('Location.lbl LIKE' => '%' . $lbl . '%'));
            $this->passedArgs['lbl'] = $lbl;
        }

        $name = isset($this->params['url']['name']) ? $this->params['url']['name'] : (isset($this->params['named']['name']) ? $this->params['named']['name'] : "");
        if ($name != '') {
            $cond = array_merge($cond, array('Location.name LIKE' => '%' . $name . '%'));
            $this->passedArgs['name'] = $name;
        }
       $zip = isset($this->params['url']['zip']) ? $this->params['url']['zip'] : (isset($this->params['named']['zip']) ? $this->params['named']['zip'] : "");
	   
        if ($zip != '') {
            $cond = array_merge($cond, array('Location.plz LIKE' => '%' . $zip . '%'));
            $this->passedArgs['zip'] = $zip;
			
        }
		
		
		 $plz = isset($this->params['url']['plz']) ? $this->params['url']['plz'] : (isset($this->params['named']['plz']) ? $this->params['named']['plz'] : "");
	   
        if ($plz != '') {
            
            $this->passedArgs['plz'] = $plz;
			
        }
		
		
		
        $Address = isset($this->params['url']['address']) ? $this->params['url']['address'] : (isset($this->params['named']['address']) ? $this->params['named']['address'] : "");
        if ($Address != '') {
            $cond = array_merge($cond, array('Location.address LIKE' => '%' . $Address . '%'));
            $this->passedArgs['address'] = $Address;
        }
		
		
        $emergency = isset($this->params['url'
		]['emergency']) ? $this->params['url']['emergency'] : (isset($this->params['named']['emergency']) ? $this->params['named']['emergency'] : "");
        if ($emergency != '') {
            $cond = array_merge($cond, array('Location.emer LIKE' => '%' . $emergency . '%'));
            $this->passedArgs['emergency'] = $emergency;
        }

        $this->Session->write('cond', serialize($cond));

        $this->paginate = array('conditions' => $cond, 'limit' => $this->paginate['limit'],'order' => array('Location.name asc'));

        $this->set('locations', $this->paginate('Location'));

        $locationDNCount = $this->Dns->find('all', array(
            'contain' => array('Dns', 'Location'),
            'fields' => array(
                'Dns.location_id',
                'count(Dns.location_id)'),
            'group' => 'Dns.location_id',
            'conditions' => array('Location.customer_id' => $customer_id))
        );
        foreach ($locationDNCount as $locationDNCountIndiv) {
            $locationDNMap[$locationDNCountIndiv['Dns'][location_id]] = $locationDNCountIndiv[0]['count(`Dns`.`location_id`)'];
        }
        $this->set('locationDNCount', $locationDNMap);
        $locations_array = print_r($locationDNCount, true);
        $this->log("Locaitons controller : DN Map" . $locations_array, LOG_DEBUG);

        $locationMedCount = $this->Mediatrix->find('all', array(
            'fields' => array(
                'Mediatrix.location_id',
                'count(Mediatrix.location_id)'),
            'group' => 'Mediatrix.location_id',
            'conditions' => array('Location.customer_id' => $customer_id))
        );
        foreach ($locationMedCount as $locationMedCountIndiv) {
            $locationMedMap[$locationMedCountIndiv['Mediatrix'][location_id]] = $locationMedCountIndiv[0]['count(`Mediatrix`.`location_id`)'];
        }
        $this->set('locationMediatrixCount', $locationMedMap);
        $locations_array = print_r($locationMediatrixCount, true);
        $this->log("Locaitons controller : Mediatrix Map" . $locations_array, LOG_DEBUG);

        $locationTrunkCount = $this->Trunk->find('all', array(
            'fields' => array(
                'Trunk.location_id',
                'count(Trunk.location_id)'),
            'group' => 'Trunk.location_id',
            'conditions' => array('Location.customer_id' => $customer_id))
        );
        foreach ($locationTrunkCount as $locationTrunkCountIndiv) {
            $locationTrunkMap[$locationTrunkCountIndiv['Trunk'][location_id]] = $locationTrunkCountIndiv[0]['count(`Trunk`.`location_id`)'];
        }
        $this->set('locationTrunkCount', $locationTrunkMap);
        $locations_array = print_r($locationTrunkCount, true);
        $this->log("Locaitons controller : TrunkMAp" . $locations_array, LOG_DEBUG);

        #Get Customer Name
        $customerInfo = $this->Customer->findById($customer_id);
        if (isset($customerInfo['Customer']['name'])) {
            $this->set('selected_customer', $customerInfo['Customer']['name']);
        } else {
            $this->set('selected_customer', 'UNDEF');
        }
    }

    /**
     * edit()
     * displays a single Location and all related stations
     * url: /formats/view/Location_slug
     */
    /* function edit ($location_id = null) {


      if ($location_id == 'create')
      {
      $customer_id=isset($this->params['url']['customer_id'])?$this->params['url']['customer_id']:(isset($this->params['named']['customer_id'])?$this->params['named']['customer_id']:"");
      $this->log("Locaitons controller : create", LOG_DEBUG);

      }
      else
      {

      $location = $this->Location->find('first',array('conditions'=>array("Location.status"=>'1','Location.id'=>$location_id)));
      $customer_id = 	$location['Location']['customer_id'];
      $cust_id=$this->Session->read('SELECTED_CUSTOMER');

      $locations_array=print_r($location, true);
      $this->log("Locaitons controller : Select LOCATOION" .  $locations_array, LOG_DEBUG);


      $dnsCount =$this->Dns->find('count',
      array(
      'conditions' => array('Location.customer_id' => $customer_id)
      )
      );
      $this->set('dnsCount',$dnsCount);

      $dnsCount_loc =$this->Dns->find('count',
      array(
      'conditions' => array('Dns.location_id' =>$location_id,'Location.customer_id' => $customer_id)
      )
      );
      $this->set('dnsCount_loc',$dnsCount_loc);

      $dnsCount_inwork =$this->Dns->find('count',
      array(
      'conditions' => array('Dns.location_id' =>$location_id, 'Dns.status' => 4 )
      )
      );
      $this->set('dnsCount_inwork',$dnsCount_inwork);


      }


      $this->pageTitle = 'Location Edit';

      #$custName = $this->Session->read('Customer.Name');
      $this->set('cust_for_layout',$customer_id);
      $this->set('SELECTED_CNN',$customer_id);
      $this->set('SELECTED_CUSTOMER_NAME',$customer_id);
      $this->set('selected_customer',$customer_id);
      $this->set('location', $location);

      $this->set('location_id', $location_id);
      $this->log("Locaitons controller : END", LOG_DEBUG);
      //echo"<pre>";
      //print_r($location);


      } */



    function editlocation() {
        $this->layout = false;

        //echo "<pre>";
       

        $locations_array = print_r($_POST, true);
        $this->log("Locaitons controller : EDIT LOCATOION" . $locations_array, LOG_DEBUG);
        #$location_desc = isset($this->params['name']['location_remark']) ? $this->params['url']['location_remark'] : (isset($this->params['named']['location_remark']) ? $this->params['named']['location_remark'] : "");
		$location_desc = $_POST['location_remark']; # has been posted.
        
        
        $location_name = isset($this->params['url']['location_name']) ? $this->params['url']['location_name'] : (isset($this->params['named']['location_name']) ? $this->params['named']['location_name'] : "");

        $location_id = isset($this->params['url']['location_id']) ? $this->params['url']['location_id'] : (isset($this->params['named']['location_id']) ? $this->params['named']['location_id'] : "");
		 $location_address = isset($this->params['url']['location_address']) ? $this->params['url']['location_address'] : (isset($this->params['named']['location_address']) ? $this->params['named']['location_address'] : "");
		 
		 $loctype = isset($this->params['url']['loctype']) ? $this->params['url']['loctype'] : (isset($this->params['named']['loctype']) ? $this->params['named']['loctype'] : "");
		 
		 $location_ort = isset($this->params['url']['location_ort']) ? $this->params['url']['location_ort'] : (isset($this->params['named']['location_ort']) ? $this->params['named']['location_ort'] : "");
		  
		 $location_cer1 = isset($this->params['url']['location_cer1']) ? $this->params['url']['location_cer1'] : (isset($this->params['named']['location_cer1']) ? $this->params['named']['location_cer1'] : "");
		 
		  
		 $location_cer2 = isset($this->params['url']['location_cer2']) ? $this->params['url']['location_cer2'] : (isset($this->params['named']['location_cer2']) ? $this->params['named']['location_cer2'] : "");

        $browser = $this->Location->getBrowser();
		
		#if($browser['name']!='Internet Explorer'){
		$location_name = utf8_decode($location_name);
        $location_desc = utf8_decode($location_desc);
		$location_address = utf8_decode($location_address);
		$loctype = utf8_decode($loctype);
		$location_ort = utf8_decode($location_ort);
		
		#}
		
        $data['Location']['name'] = $location_name;
        $data['Location']['remark'] = $location_desc;
		$data['Location']['address'] = $location_address;
		$data['Location']['loc_type'] = $loctype;
		$data['Location']['ort'] = $location_ort;
		$data['Location']['cer1'] = $location_cer1;
		$data['Location']['cer2'] = $location_cer2;
		
		$updatelocation = $this->Location->query('UPDATE `locations` SET `name`= "' . $location_name . '",`remark`="' . $location_desc . '",`address`="' . $location_address . '",`loc_type`="' . $loctype . '",`ort`="' . $location_ort . '",`cer1`="' . $location_cer1 . '",`cer2`="' . $location_cer2 . '" WHERE `id` =' . $location_id);
       // echo $location_name;
	   #Build transaction manually.
				
				
			  $log = 'Location Update : Location updated';
								
					$insert = array (
					'Log' => array (
					'affected_obj' => $location_id,
					'log_entry' => $log,
					'created' => date('Y-m-d H:i:s'),
					'status' => 1,
					'customer_id' => $locationInfo['0']['Location']['customer_id'],
					'bsk' => $this->Session->read('BSK'),
					'user' => $this->Session->read('ACCOUNTNAME'),
					'app_type' => $this->Session->read('APPNAME'),
					'modified' => '0000-00-00 00:00:00',
					'modification_status' => 1,
					'modification_response' => 1,
					
					)
					);
					
					$this->Log->create();
				   $this->Log->save($insert,false);
						
					$log_id = $this->Log->id;
					
		if($location_name!=""){
       $_SESSION['success'] = __('location updated succesfully', true) ;	
			$link = '<a class="fancybox fancybox.ajax" href="' . Configure::read('base_url') . '/logs/logdetails/' . $log_id . '">' . __("LogEntry", true) . '</a>';
			$_SESSION['success'] .= " ".$link;
			$this->set('success',$_SESSION['success']);

            $location_id = $this->Location->id;
        } else {

            $this->Session->setFlash('Unable to update your location.');
        }


        //$this->redirect(array('action' => 'edit/' . $location_id));
		
    
      exit();  
    }

    function edit($location_id = null) {
		
		
		
        extract($_POST);

        if ($location_id == 'create') {
            $customer_id = isset($this->params['url']['customer_id']) ? $this->params['url']['customer_id'] : (isset($this->params['named']['customer_id']) ? $this->params['named']['customer_id'] : "");
           
            $this->log("Locaitons controller : create", LOG_DEBUG);
        } else {
        	
            $location = $this->Location->find('first', array('conditions' => array("Location.status" => '1', 'Location.id' => $location_id)));
            $customer_id = $location['Location']['customer_id'];
            
            
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
            
            $cust_id = $this->Session->read('SELECTED_CUSTOMER');
            $block_id = isset($this->params['url']['block_id']) ? $this->params['url']['block_id'] : (isset($this->params['named']['block_id']) ? $this->params['named']['block_id'] : "");
            $this->set('block_id', $block_id);

            #$locations_array = print_r($location, true);
            #$this->log("Locaitons controller : Select LOCATOION" . $locations_array, LOG_DEBUG);

            $dnsCount = $this->Dns->find('count', array(
                'conditions' => array('Location.customer_id' => $customer_id)
                    )
            );
            $this->set('dnsCount', $dnsCount);

            $dnsCount_loc = $this->Dns->find('count', array(
                'conditions' => array('Dns.location_id' => $location_id, 'Location.customer_id' => $customer_id)
                    )
            );
            $this->set('dnsCount_loc', $dnsCount_loc);

            $dnsCount_inwork = $this->Dns->find('count', array(
                'conditions' => array('Dns.location_id' => $location_id, 'Dns.status' => 4)
                    )
            );
            $this->set('dnsCount_inwork', $dnsCount_inwork);


            $cond5 = array('Location.customer_id' => $customer_id, 'Dns.location_id' => $location_id);
            
            /*CHECK FOR LARGE DATASETS */
            
            
            
            #if(isset($block_id))
           #use selected block

            	
            
	            $dnsCount = $this->Dns->find('count', array('conditions' => $cond5));
	            $condition_array = print_r($dnsCount, true);
	            $this->log("Locations controller : count array : $condition_array", LOG_DEBUG);
	            if($dnsCount > Configure::read('maxDataLimit'))
	            {
		            $dnsBlockArray = $this->Dns->find('all', 
		            		array('conditions' => $cond5, 
		            		'fields' => array(
		           				  'SUBSTRING(Dns.id,1,5) as sub',
		           				  'count(*)'
		            		), 
		            		'group' => 'sub', 
		            		'order' => 'sub asc'
		            	)
		            );
					
		            
		            
		            $condition_array = print_r($dnsBlockArray, true);
		            $this->log("Locations controller : block array : $condition_array", LOG_DEBUG);
		            
		            foreach ($dnsBlockArray as $dnsBlock)
		            {
		            	$blockStart = $dnsBlock[0]['sub'] . '0000';
		            	$blockEnd = $dnsBlock[0]['sub'] . '9990';
		            	if(!(isset($blockStartFilter))){ 
		            		$blockStartFilter = $blockStart;
		            		$blockEndFilter =$blockEnd;
		            	}
		   
		            	$blockOptions[$dnsBlock[0]['sub']] = $blockStart . '=>' . $blockEnd . ':(' .$dnsBlock[0]['count(*)'] . ')';
		            }
		            
		            
		            
		            $condition_array = print_r($blockOptions, true);
		            $this->log("Locations controller : block array : $condition_array", LOG_DEBUG);
		            $this->log("Locations controller : block start : $blockStart", LOG_DEBUG);
		            $this->log("Locations controller : block end : $blockEnd", LOG_DEBUG);
		            
		            
		            $this->set('blockOptions', $blockOptions);
		            
		            if((isset($block_id)) && ($block_id != ''))
		            {
		            	$this->log("Locations controller : block_id is set : $block_id", LOG_DEBUG);
		            	$blockStartFilter = $block_id . '0000';
		            	$blockEndFilter = $block_id . '9999';
		            	$cond5 = array_merge($cond5, array('Dns.id >=' => $blockStartFilter, 'Dns.id <=' => $blockEndFilter));
		            }
		            else {

			            $cond5 = array_merge($cond5, array('Dns.id >=' => $blockStartFilter, 'Dns.id <=' => $blockEndFilter));
		            
		            }
	            }
            
            
            /* END LARGE DATASET */
            
            $rangeMinval = isset($data['rangeMin']['minval']) ? $data['rangeMin']['minval'] : "";
            $rangeMaxval = isset($data['rangeMax']['maxval']) ? $data['rangeMax']['maxval'] : "";

            if ($rangeMinval != '' && $rangeMaxval != '') {
                $cond5 = array_merge($cond5, array('Dns.id >=' => $rangeMinval, 'Dns.id <=' => $rangeMaxval));
                //$cond = array_merge($cond,array('Scenario.source <'=>$rangeMaxval));
                $this->Session->write('cond5', serialize($cond5));
                $condition_array = print_r($cond5, true);
                $this->log("Scenario controller : Setting sesion conditions : $condition_array", LOG_DEBUG);
                #$this->set('station_id',$station_id);
                #Set below for sort/filter problem where filter arguments not passed to sort
                $this->passedArgs['rangeMin'] = $rangeMinval;
                $this->passedArgs['rangeMax'] = $rangeMaxval;
            }

            
            
            $dnsdetail = $this->Dns->find('all', array('conditions' => $cond5, 'fields' => array('Dns.*,Location.name,Location.id,Location.scm_name'), 'group' => 'Dns.id', 'order' => 'Location.name asc'));
            //$dnsdetail =$this->Dns->find('all',array('conditions' => array('Dns.location_id' =>$location_id,'Location.customer_id' =>$customer_id),'group'=>'Dns.id','order'=>'Location.name asc'));

#echo "<pre>";print_r($dnsdetail);

			/* Making drop */
			
			$locationlist= array();
			foreach($dnsdetail as $key => $details){
				$locationlist[$details['Location']['name']] = $details['Location']['name'];
			}
			$this->set('locationlist',$locationlist);
			
			$locationlist= array();
			foreach($dnsdetail as $key => $details){
				$emerval = $details['Dns']['emer'];
				if($emerval == "" || $emerval == null || $emerval == "undefined"){
					$emerval =  __('empty',true);
				}
			
				$emerlist[$details['Dns']['emer']] = $emerval;
			}
			$this->set('emerlist',$emerlist);
			
			$functionlist= array();
			#$functionlist[__('free',true)] = __('free',true);
			foreach($dnsdetail as $key => $details){
				
				if($details['Dns']['function'] == '')
				{
					$func = __('free',true);
				
				}
				else {
					$func = __($details['Dns']['function'],true);
				}
				
				
				#$func = __($details['Dns']['function'],true);
				#$func_encoded = utf8_encode($func);
				$functionlist[$func] = $func;
			}
			$this->set('functionlist',$functionlist);
			
			/* -------------- */
			
            //$dnsdetail =$this->Dns->find('all',array('conditions' => array('Dns.location_id' =>$location_id,'Location.customer_id' =>$customer_id),'group'=>'Dns.id','order'=>'Location.name asc'));

#echo "<pre>";print_r($dnsdetail);

			//App::import('vendor', 'JSON.php');
			
			App::import('Vendor', 'json', array('file'=>'JSON.php'));
			$json = new Services_JSON();

			// convert a complexe value to JSON notation, and send it to the browser
			//$value = array('foo', 'bar', array(1, 2, 'baz'), array(3, array(4)));
			
			
			foreach($dnsdetail as $key => $details){				
			
			
				$dnsdetail[$key]['Location']['name'] = __($details['Dns']['emer'], true);
				$dnsdetail[$key]['Dns']['emer'] = __($details['Dns']['emer'], true);
				
				if($details['Dns']['function']!=''){
					$func = __($details['Dns']['function'],true);
					$functiond = utf8_encode($func);
					#$functiond  =  __($details['Dns']['function'],true);
				}
				else { 
					$func = __('free',true);
					$functiond = utf8_encode($func);
					#$functiond =  __('free',true);
				} 
				$dnsdetail[$key]['Dns']['function'] = $functiond;
				
			
				$dnsdetail[$key]['Location']['name'] = htmlentities($details['Location']['name']);
			}
			
			$output = $json->encode($dnsdetail);

			//echo $json->utf82utf16('Zürich 01');
            $this->set('jsondnsdetail', $output);
			$this->set('dnsdetail', $dnsdetail);
			
			//print_r($dnsdetail); die;
	


            $this->set('dnsdetail', $dnsdetail);

            $customer = $this->Customer->find('first', array('contain' => array('Location'), 'conditions' => array('id' => $customer_id)));

            foreach ($customer['Location'] as $key => $value):
                $locations[$value['id']] = $value['name'];
            endforeach;
            #$location_array=print_r($locations, true);
            #$this->log("Mediatrix controller : Location Details : $location_array", LOG_DEBUG);

            $this->set('locations', $locations);
        }


        $this->pageTitle = 'Location Edit';

        #$custName = $this->Session->read('Customer.Name');
        $this->set('cust_for_layout', $customer_id);
        $this->set('SELECTED_CNN', $customer_id);
        $this->set('SELECTED_CUSTOMER_NAME', $customer_id);
        //$this->set('selected_customer', $customer_id);
        $this->set('location', $location);

        $this->set('location_id', $location_id);
        $this->log("Locaitons controller : END", LOG_DEBUG);
        $this->set('customer_id',$customer_id);
        
        #Get Customer Name
        $customerInfo = $this->Customer->findById($customer_id);
		
        if (isset($customerInfo['Customer']['name'])) {
            $this->set('selected_customer', $customerInfo['Customer']['name']);
        } else {
            $this->set('selected_customer', 'UNDEF');
        }
		$custtype =  $customerInfo['Customer']['type'];
		$this->set('custtype',$custtype);
		
		if($customerInfo['Customer']['Info1']==1)
		{
			$redirect = '/locations/index/' . $customer_id;
			$this->redirect($redirect);
		}
		
		
			if (isset ($_SESSION['success']))
				$this->set('success', $_SESSION['success']);
			    $_SESSION['success'] = '';
			
			if (isset ($_SESSION['error']))
				$this->set('error', $_SESSION['error']);
			    $_SESSION['error'] = '';
					
        //echo"<pre>";
        //print_r($location);
		/*    query not to show undefined option      */
		/*
		$locationtypes = $this->Location->find('all', array('conditions' => array("Location.status" => '1','Location.loc_type !='=>"undefined"), 'group' => 'Location.loc_type'));
		*/
		$locationtypes = $this->Location->find('all', array('conditions' => array("Location.status" => '1','Location.loc_type !='=>" "), 'group' => 'Location.loc_type'));
		
		
		$options=array();
		foreach($locationtypes as $locationtype){
			$loctype = $locationtype['Location']['loc_type'];
			//$options.='<option value="'.$loctype.'">'.$loctype.'</option>';
			$options[$loctype]=$loctype;
					
		}
		
		
		
		$this->set('loctype',$options);
						
            #$location_array=print_r($locations, true);
            #$this->log("Mediatrix controller : Location Details : $location_array", LOG_DEBUG);

            $this->set('locations', $locations);
        
        $cond =array('Log.customer_id'=>$customer_id);
        
        $this->paginate['Paginate']	= $this->AutoPaginate->setPaginate();
        #$this->paginate['limit'] = 5;
        $this->paginate = array('limit' => $this->paginate['limit'],'conditions'=>$cond, 'order'=>'Log.id desc');
        $loginfo = $this->paginate('Log');
        $this->set('loginfo',$loginfo);
    }
	
	
	function editmode($location_id = null) {
		
		
		//$this->layout = false;
        extract($_POST);

        if ($location_id == 'create') {
            $customer_id = isset($this->params['url']['customer_id']) ? $this->params['url']['customer_id'] : (isset($this->params['named']['customer_id']) ? $this->params['named']['customer_id'] : "");
           
            $this->log("Locaitons controller : create", LOG_DEBUG);
        } else {
        	
            $location = $this->Location->find('first', array('conditions' => array("Location.status" => '1', 'Location.id' => $location_id)));
            $customer_id = $location['Location']['customer_id'];
            
            
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
            
            $cust_id = $this->Session->read('SELECTED_CUSTOMER');
            $block_id = isset($this->params['url']['block_id']) ? $this->params['url']['block_id'] : (isset($this->params['named']['block_id']) ? $this->params['named']['block_id'] : "");
            $this->set('block_id', $block_id);

            #$locations_array = print_r($location, true);
            #$this->log("Locaitons controller : Select LOCATOION" . $locations_array, LOG_DEBUG);

            $dnsCount = $this->Dns->find('count', array(
                'conditions' => array('Location.customer_id' => $customer_id)
                    )
            );
            $this->set('dnsCount', $dnsCount);

            $dnsCount_loc = $this->Dns->find('count', array(
                'conditions' => array('Dns.location_id' => $location_id, 'Location.customer_id' => $customer_id)
                    )
            );
            $this->set('dnsCount_loc', $dnsCount_loc);

            $dnsCount_inwork = $this->Dns->find('count', array(
                'conditions' => array('Dns.location_id' => $location_id, 'Dns.status' => 4)
                    )
            );
            $this->set('dnsCount_inwork', $dnsCount_inwork);


            $cond5 = array('Location.customer_id' => $customer_id, 'Dns.location_id' => $location_id);
            
            /*CHECK FOR LARGE DATASETS */
            
            
            
            #if(isset($block_id))
           #use selected block

            	
            
	            $dnsCount = $this->Dns->find('count', array('conditions' => $cond5));
	            $condition_array = print_r($dnsCount, true);
	            $this->log("Locations controller : count array : $condition_array", LOG_DEBUG);
	            if($dnsCount > Configure::read('maxDataLimit'))
	            {
		            $dnsBlockArray = $this->Dns->find('all', 
		            		array('conditions' => $cond5, 
		            		'fields' => array(
		           				  'SUBSTRING(Dns.id,1,6) as sub',
		           				  'count(*)'
		            		), 
		            		'group' => 'sub', 
		            		'order' => 'sub asc'
		            	)
		            );
					
		            
		            
		            $condition_array = print_r($dnsBlockArray, true);
		            $this->log("Locations controller : block array : $condition_array", LOG_DEBUG);
		            
		            foreach ($dnsBlockArray as $dnsBlock)
		            {
		            	$blockStart = $dnsBlock[0]['sub'] . '000';
		            	$blockEnd = $dnsBlock[0]['sub'] . '999';
		            	if(!(isset($blockStartFilter))){ 
		            		$blockStartFilter = $blockStart;
		            		$blockEndFilter =$blockEnd;
		            	}
		   
		            	$blockOptions[$dnsBlock[0]['sub']] = $blockStart . '=>' . $blockEnd . ':(' .$dnsBlock[0]['count(*)'] . ')';
		            }
		            
		            
		            
		            $condition_array = print_r($blockOptions, true);
		            $this->log("Locations controller : block array : $condition_array", LOG_DEBUG);
		            $this->log("Locations controller : block start : $blockStart", LOG_DEBUG);
		            $this->log("Locations controller : block end : $blockEnd", LOG_DEBUG);
		            
		            
		            $this->set('blockOptions', $blockOptions);
		            
		            if((isset($block_id)) && ($block_id != ''))
		            {
		            	$this->log("Locations controller : block_id is set : $block_id", LOG_DEBUG);
		            	$blockStartFilter = $block_id . '000';
		            	$blockEndFilter = $block_id . '999';
		            	$cond5 = array_merge($cond5, array('Dns.id >=' => $blockStartFilter, 'Dns.id <=' => $blockEndFilter));
		            }
		            else {

			            $cond5 = array_merge($cond5, array('Dns.id >=' => $blockStartFilter, 'Dns.id <=' => $blockEndFilter));
		            
		            }
	            }
            
            
            /* END LARGE DATASET */
            
            $rangeMinval = isset($data['rangeMin']['minval']) ? $data['rangeMin']['minval'] : "";
            $rangeMaxval = isset($data['rangeMax']['maxval']) ? $data['rangeMax']['maxval'] : "";

            if ($rangeMinval != '' && $rangeMaxval != '') {
                $cond5 = array_merge($cond5, array('Dns.id >=' => $rangeMinval, 'Dns.id <=' => $rangeMaxval));
                //$cond = array_merge($cond,array('Scenario.source <'=>$rangeMaxval));
                $this->Session->write('cond5', serialize($cond5));
                $condition_array = print_r($cond5, true);
                $this->log("Scenario controller : Setting sesion conditions : $condition_array", LOG_DEBUG);
                #$this->set('station_id',$station_id);
                #Set below for sort/filter problem where filter arguments not passed to sort
                $this->passedArgs['rangeMin'] = $rangeMinval;
                $this->passedArgs['rangeMax'] = $rangeMaxval;
            }

            
            
            $dnsdetail = $this->Dns->find('all', array('conditions' => $cond5, 'fields' => array('Dns.*,Location.name,Location.id,Location.scm_name'), 'group' => 'Dns.id', 'order' => 'Location.name asc'));
			
			
			/* Making drop */
			
			$locationlist= array();
			foreach($dnsdetail as $key => $details){
				$locationlist[$details['Location']['id']] = $details['Location']['id'];
			}
			$this->set('locationlist',$locationlist);
			
			$functionlist= array();
			foreach($dnsdetail as $key => $details){
				$functionlist[$details['Dns']['function']] = $details['Dns']['function'];
			}
			$this->set('functionlist',$functionlist);
			
			/* -------------- */
			
            //$dnsdetail =$this->Dns->find('all',array('conditions' => array('Dns.location_id' =>$location_id,'Location.customer_id' =>$customer_id),'group'=>'Dns.id','order'=>'Location.name asc'));

#echo "<pre>";print_r($dnsdetail);

			//App::import('vendor', 'JSON.php');
			
			App::import('Vendor', 'json', array('file'=>'JSON.php'));
			$json = new Services_JSON();

			// convert a complexe value to JSON notation, and send it to the browser
			//$value = array('foo', 'bar', array(1, 2, 'baz'), array(3, array(4)));
			$output = $json->encode($dnsdetail);
            $this->set('jsondnsdetail', $output);
			$this->set('dnsdetail', $dnsdetail);

            
			$customer = $this->Customer->find('first', array('contain' => array('Location'), 'conditions' => array('id' => $customer_id)));

            foreach ($customer['Location'] as $key => $value):
                $locations[$value['id']] = $value['name'];
            endforeach;
            #$location_array=print_r($locations, true);
            #$this->log("Mediatrix controller : Location Details : $location_array", LOG_DEBUG);

            $this->set('locations', $locations);
        }


        $this->pageTitle = 'Location Edit';

        #$custName = $this->Session->read('Customer.Name');
        $this->set('cust_for_layout', $customer_id);
        $this->set('SELECTED_CNN', $customer_id);
        $this->set('SELECTED_CUSTOMER_NAME', $customer_id);
        //$this->set('selected_customer', $customer_id);
        $this->set('location', $location);

        $this->set('location_id', $location_id);
        $this->log("Locaitons controller : END", LOG_DEBUG);
        $this->set('customer_id',$customer_id);
        
        #Get Customer Name
        $customerInfo = $this->Customer->findById($customer_id);
		
        if (isset($customerInfo['Customer']['name'])) {
            $this->set('selected_customer', $customerInfo['Customer']['name']);
        } else {
            $this->set('selected_customer', 'UNDEF');
        }
		$custtype =  $customerInfo['Customer']['type'];
		$this->set('custtype',$custtype);
		
		if($customerInfo['Customer']['Info1']==1)
		{
			$redirect = '/locations/index/' . $customer_id;
			$this->redirect($redirect);
		}
		
		
			if (isset ($_SESSION['success']))
				$this->set('success', $_SESSION['success']);
			    $_SESSION['success'] = '';
			
			if (isset ($_SESSION['error']))
				$this->set('error', $_SESSION['error']);
			    $_SESSION['error'] = '';
					
        //echo"<pre>";
        //print_r($location);
		
		$locationtypes = $this->Location->find('all', array('conditions' => array("Location.status" => '1','Location.loc_type !='=>" "), 'group' => 'Location.loc_type'));
		
		
		$options=array();
		foreach($locationtypes as $locationtype){
			$loctype = $locationtype['Location']['loc_type'];
			//$options.='<option value="'.$loctype.'">'.$loctype.'</option>';
			$options[$loctype]=$loctype;
					
		}
		
		
		$this->set('loctype',$options);
						
            #$location_array=print_r($locations, true);
            #$this->log("Mediatrix controller : Location Details : $location_array", LOG_DEBUG);

            $this->set('locations', $locations);
        
        $cond =array('Log.customer_id'=>$customer_id);
        
        $this->paginate['Paginate']	= $this->AutoPaginate->setPaginate();
        #$this->paginate['limit'] = 5;
        $this->paginate = array('limit' => $this->paginate['limit'],'conditions'=>$cond, 'order'=>'Log.id desc');
        $loginfo = $this->paginate('Log');
        $this->set('loginfo',$loginfo);
    }

    function select_location() {
        $this->layout = false;
        $this->paginate['Paginate'] = $this->AutoPaginate->setPaginate();

        $customer_id = isset($this->params['url']['customer_id']) ? $this->params['url']['customer_id'] : (isset($this->params['named']['customer_id']) ? $this->params['named']['customer_id'] : "");


        $this->log("LOCATIONS controller : HERE", LOG_DEBUG);
        #$this->set('title_header','DN List');
        #$this->pageTitle = 'DN List';


        $custName = $customer['Customer']['name'];
        $custId = $customer['Customer']['id'];
        $this->Session->write('Customer.Name', $custName);
        $this->Session->write('Customer.Id', $custId);
        $this->set('custId', $custId);
        $this->set('scenario_id', $scenario_id);
        $this->set('SELECTED_CNN', $custId);
        $this->set('cust_for_layout', $custName);
        $this->set('custName', $custName);

        $this->set('selected_customer', $custName);
        $this->set('locations', $locations);

        $results = $this->Location->find('all', array('conditions' => array('Location.customer_id' => $customer_id), 'order' => 'Location.name asc'));

        $this->set('locations', $results);
        $this->log("LOCATIONS controller : HERE2", LOG_DEBUG);
    }

    function change() {

        $this->Session->destroy();
        #$this->Session->write('Customer.Name', '');
        #$this->Session->write('Customer.Id', '');
        // set a flash message
        $this->Session->setFlash('checnged_customer', 'flash_bad');
        // redirect user
        $this->redirect(array('controller' => 'customers', 'action' => 'index'));
    }

    /**
     * function for Location details
     * 
     */
    function view($id = NULL) {

        if ($this->Session->read('SELECTED_CUSTOMER') != Configure::read('access_id')) {
            $id = $this->Session->read('SELECTED_CUSTOMER');
            $cnt = count($this->_Filter);
            $this->_Filter[$cnt] = "Location.customer_id = $id";
        }
        $this->paginate['Paginate'] = $this->AutoPaginate->setPaginate();

        $this->_Filter = "Location.customer_id = $id";
        // get all formats from database where status = 1
        //$locations = $this->Location->findAll("status=1");
        #User for left hand Menu navigation.

        $this->set('SELECTED_CNN', $id);
        $this->set('SELECTED_CUSTOMER_NAME', $id);

        $this->set('title_header', 'Prototype');

        // save the formats in a variable for the view
        $filter = "Location.id = $id";
        $Location = $this->Location->findById($id);

        $custlabel = $Location['Location']['label'];
        $custname = $customer['Location']['name'];
        $custzip = $customer['Location']['plz'];
        $custaddrs = $customer['Location']['address'];
        $custemrgency = $customer['Location']['emer'];
        $this->Session->write('Location.Name', $custName);
        $this->Session->write('Customer.Id', $custId);
        $this->set('cust_for_layout', $custName);
        $this->set('custName', $custName);

        $this->set('locations', $this->paginate('Location', $this->_Filter));
    }

    /**
     * function for edit or add location
     * 
     */
    function add_location() {
        if ($this->Location->save($this->request->data)) { //attempting to save "original" and "concatenated" from the add function in ConcatenatesController
            $this->Session->setFlash('Your post has been saved.');
            $this->redirect(array('action' => 'edit'));
        } else {
            $this->Session->setFlash('Unable to add your post.');
        }
    }

    function update($location_id = null) {
      
				
		
		$bakom = $this->Bakom->find('first', array('conditions' => array('Bakom.PLZ' => $this->data['Location']['plz'])));

        $bakom_array = print_r($bakom, true);

        $this->log("Locations controller : Looking Up" . $bakom_array, LOG_DEBUG);

        # $this->data['Location']['emer'] = $bakom['Bakom']['emer'];
		 $this->data['Location']['emer'];
		
		 $this->data['Location']['loc_source']="SELFCARE";
		 
      # echo "<pre>";print_r($this->data['Location']); 
	   #exit();
	  
	     
	   
	   
        if ($this->Location->save($this->data)) {
			
			
		
           $location_id = $this->Location->getLastInsertId();
			 $locationInfo = $this->Location->find('all', array('conditions' => array('Location.id' => $location_id)));
			
		
					$transStatus = 1;
			  $log = 'Location Update : Location Added : ' .$locationInfo['0']['Location']['name'] ;
								
					$insert = array (
					'Log' => array (
					'affected_obj' => $location_id,
					'log_entry' => $log,
					'created' => date('Y-m-d H:i:s'),
					'status' => 1,
					'customer_id' => $locationInfo['0']['Location']['customer_id'],
					'bsk' => $this->Session->read('BSK'),
					'user' => $this->Session->read('ACCOUNTNAME'),
					'app_type' => $this->Session->read('APPNAME'),
					'modified' => '0000-00-00 00:00:00',
					'modification_status' => $transStatus,
					'modification_response' => $transResponse,
					'transaction_id' => $transId
					)
					);
					
					$this->Log->create();
				   $this->Log->save($insert,false);
						
					$log_id = $this->Log->id;
					
					  //$log_id    = $this->Log->getLastInsertId();
					 
			 
			$_SESSION['success'] = __('location added succesfully', true) ;	
			$link = '<a class="fancybox fancybox.ajax" href="' . Configure::read('base_url') . '/logs/logdetails/' . $log_id . '">' . __("LogEntry", true) . '</a>';
			$_SESSION['success'] .= " ".$link;
			$this->set('success',$_SESSION['success']);

            $location_id = $this->Location->id;
        } else {

            $this->Session->setFlash('Unable to update your location.');
        }


        $this->redirect(array('action' => 'edit/' . $location_id));
        exit();
    }

    function validatezip() {
        $this->layout = false;
        $location_zip = isset($this->params['url']['location_zip']) ? $this->params['url']['location_zip'] : (isset($this->params['named']['location_zip']) ? $this->params['named']['location_zip'] : "");
        
        #$bakom = $this->Bakom->find('count', array('fields'=>array('DISTINCT Bakom.emer'), 'conditions' => array('Bakom.PLZ' => $location_zip)));
		
		 $bakomdetail = $this->Bakom->find('all', array('group'=>'Bakom.emer' ,'conditions' => array('Bakom.PLZ' => $location_zip)));
		$bakom=count($bakomdetail);
		 
        if ($bakom > 1) {
            echo "2";
		 	
			
        } else if ($bakom == 0) {
            echo "0";
        } else {

            $bakom = $this->Bakom->find('first', array('conditions' => array('Bakom.PLZ' => $location_zip)));

            echo '1****' . $bakom['Bakom']['emer'];
        }
        exit();
    }

    function selectzip() {
        $this->layout = false;
        $location_zip = isset($this->params['url']['location_zip']) ? $this->params['url']['location_zip'] : (isset($this->params['named']['location_zip']) ? $this->params['named']['location_zip'] : "");

        $bakomlist = $this->Bakom->find('all', array( 'group'=>'Bakom.emer' ,'conditions' => array('Bakom.PLZ' => $location_zip)));
        $this->set('bakom', $bakomlist);
    }

    function updatedns() {
		
       // $location_id = isset($this->params['url']['location_id']) ? $this->params['url']['location_id'] : (isset($this->params['named']['location_id']) ? $this->params['named']['location_id'] : "");
	   $location_id = isset($this->params['url']['location_id']) ? $this->params['url']['location_id'] : (isset($this->params['form']['location_id']) ? $this->params['form']['location_id'] : "");
	   
        $location = $this->Location->find('first', array('conditions' => array('Location.id' => $location_id)));
        $customer_id = $location['Location']['customer_id'];
		
		 $dnsids = isset($this->params['url']['dnsids']) ? $this->params['url']['dnsids'] : (isset($this->params['form']['dnsids']) ? $this->params['form']['dnsids'] : "");

        $DnsIdsArray = split('&', $dnsids);	

        $newEmer = $location['Location']['emer'];
        $newName = $location['Location']['name'];
        $bakomMapSource = $this->Bakom->find('first', array( 'conditions' => array('Bakom.emer' => $newEmer)));
        $newDnscrn = $bakomMapSource['Bakom']['emer_dnscrn'];
        
        
        #Clear the cookies holding the session data
        $this->Session->delete('Counts.InWorkDns.' . $customer_id);

       // $dnid = $this->params['form']['selectdnsCheckbox'];
        
        $transId = time() . $_SERVER['HTTP_SSO_ACCOUNTUID'];
        $counter = 1;
        $fullTransaction = '<Activation id="' . $transId . '">';
        $this->log('LOCATIONS CONTROLLER : Generating new timestamp : ' . $transId, LOG_DEBUG);
         $saveDnIds = array();
		 $saveDnIds1 = array();
		 
		 
		 $commands = '<actions>' . "\n";
		 
		 $DnsIdsArray1 = array_filter($DnsIdsArray,'strlen');
		 
        //foreach ($dnid as $id) {
        foreach ($DnsIdsArray1 as $id) {	
        	#Each DNS will have it's own emergency string and will need to be determined individually.
        	
        	$currentLocation = $this->Dns->find('first', array( 'conditions' => array('Dns.id' => $id)));        	
        	$currentEmer = $currentLocation['Dns']['emer'];
        	$function = $currentLocation['Dns']['function'];
        	$status = 	$currentLocation['Dns']['status'];
        	$oldLocation = 	$currentLocation['Location']['name'];
        	       	
        	
        	$this->log('LOCATIONS CONTROLLER : CHECKING DN : ' . $id . ' : ' . $currentEmer . ' : '  . $newEmer, LOG_DEBUG);
        	
        	#Only when the emergency strings are different.
        	if($currentEmer != $newEmer)
        	{
        		if($newEmer != '')
        		{
	        	$this->log('LOCATIONS CONTROLLER : DIFFERENT EMERGENCIES : ' . $currentEmer . ' : ' . $newEmer , LOG_DEBUG);
	        	
	        		$subTrans = $transId .  '-' . $counter;
			        $fullTransaction .= '<subtransaction id="' . $subTrans . '">';
	        		if($function == 'PBX')
	        		{
	        	
	        			//$fullTransaction .= '<algRequest><object action="update" name="DNSCRNLOC"><message station="NA" key="00"><var value="' . $id . '" name="dn"/><var value="' . $newDnscrn . '" name="emer"/></message></object></algRequest>';
	        			
	        			if($status == 4)
	        			{
	        				$action = 'add';
	        			}
	        			else {
	        				$action = 'update';
	        			}
	        			$fullTransaction .= '<algRequest><object action="' . $action . '" name="DNSCRNLOC"><message station="NA" key="00"><var value="' . $id . '" name="dn"/><var value="' . $newDnscrn . '" name="emer"/></message></object></algRequest>';
	        			
	        			
	        			$fullTransaction .= '</subtransaction>';
	        			$counter++;
				        $subTrans = $transId .  '-' . $counter;
				        $fullTransaction .= '<subtransaction id="' . $subTrans . '">';
	        			$fullTransaction .= '<algRequest><object action="update" name="CGPNSCRNLOC"><message station="NA" key="00"><var value="' . $id . '" name="dn"/><var value="' . $newEmer . '" name="emer"/></message></object></algRequest>';
	        			$commands .= '<dn id="' .$dnsId . '" function="'. $function . '" oldLocation="'. $oldLocation . '" newLocation="'. $newName .'">CONFIGURE</dn>' . "\n";
	        			
	        		}
	        		else
	        		{
	        			#check for free numbers.
		                	#if($function == '')
		                	#{
		               		#	$this->log('DNS CONTROLLER : FREE DN ONLY SAVE. : ', LOG_DEBUG);
		               		#	$commands .= '<dn id="' .$id .  '" function="'. $function .'" oldLocation="'. $oldLocation . '" newLocation="'. $newName  .'">DB_UPDATE</dn>' . "\n";
		               			 
		               		#}
		               		#else
		               		#{
		                		$commands .= '<dn id="' .$id . '" function="'. $function . '" oldLocation="'. $oldLocation . '" newLocation="'. $newName .'">CONFIGURE</dn>' . "\n";
		                	 	$fullTransaction .= '<algRequest><object action="update" name="CGPNSCRNLOC"><message station="NA" key="00"><var value="' . $id . '" name="dn"/><var value="' . $newEmer . '" name="emer"/></message></object></algRequest>';
		               		#}	 
			        }
			        
	        		#$fullTransaction .= '<algRequest><object action="update" name="LOCATION"><message station="NA" key="00"><var value="' . $dn_id . '" name="dn"/><var value="' . $location_id . '" name="location"/></message></object></algRequest>';
	        		$fullTransaction .= '</subtransaction>';
	        		#$fullTransaction = '<algRequest><object action="update" name="LOCATION"><message station="NA" key="00"></message><var value="' . $dn_id . '" name="dn"/><var value="' . $location_id . '" name="location"/></message></object></algRequest>';
	        		$counter++;
	        	}
	        	else
	        	{
	        		$this->log('LOCATIONS CONTROLLER : BLANK EMER ONLY SAVE. : ', LOG_DEBUG);
	        		$commands .= '<dn id="' .$id . '" function="'. $function . '" oldLocation="'. $oldLocation . '" newLocation="'. $newName .'">CONFIGURE</dn>' . "\n";
	        		
	        	}
        	 
        	}
        	else
        	{
        		$this->log('LOCATIONS CONTROLLER : NOT DIFFERENT ONLY SAVE. : ', LOG_DEBUG);
        		$commands .= '<dn id="' .$id . '" function="'. $function . '" oldLocation="'. $oldLocation . '" newLocation="'. $newName .'">DB_UPDATE</dn>' . "\n";
        		
        	}
        	$saveDnIds[$id] = $id;
			
			
			
        }
        
        	$fullTransaction .= '</Activation>';
        	$commands .= '</actions>' . "\n";
        	
        	#Updated with DNS function to send XML command to ALG and change status
        	$app_response = $this->apply_trans($fullTransaction, $customer_id, $commands);
        	$response = explode(":",$app_response);
        	$log_id= $response[0];
        	$apply_response= $response[1];
        		
        	//$apply_response1 = $this->apply($fullTransaction, $customer_id);
        		
        	#$apply_response = 0;
        	$this->log("LOCATIONS controller : update_location - apply response : $apply_response", LOG_DEBUG);
        	if ($apply_response == 1) {
        	#$fl = $this->Dns->updateAll(array('Dns.location_id' => $location_id), array('Dns.id' => $dnsId));
        		#$fl = $this->Dns->updateAll(array('Dns.status' => 1), array('Dns.id' => $dns_id));
        	
        		#$fl = $this->Dns->updateAll(array('Dns.location_id' => $location_id, 'Dns.emer' => $newEmer), array('Dns.id' => $saveDnIds));
        	
        		$fl = $this->Dns->updateAll(array('Dns.location_id' => $location_id), array('Dns.id' => $saveDnIds));
        		$updatelocation2 = $this->Station->updateAll(array('Station.location_id' => $location_id), array('Station.id' => $saveDnIds));
        		
        		#Update stationkey locaitons
        		$stationkeyIds = $this->Feature->find('all', array (
        		'fields' => 'Stationkey.id',
        		'conditions' => array (
        		'Feature.short_name' => 'DN',
        		'Feature.primary_value' => $saveDnIds
        		)
        		));
        		$stationkeyarray = array();
        		foreach ($stationkeyIds as $stationkeyId)
        		{
        			#$this->log("locations controller : staitonkey  :" . $stationkeyId['Stationkey']['id'], LOG_DEBUG);
        			array_push($stationkeyarray, $stationkeyId['Stationkey']['id']);
        		}
        		#$condition_array = print_r($stationkeyarray, true);
        		#$this->log("locations controller : staitonkey array : $condition_array", LOG_DEBUG);
        		
        		$sku = $this->Stationkey->updateAll(array('Stationkey.location_id' => $location_id), array('Stationkey.id' => $stationkeyarray));
        		
        		$fl = $this->Dns->updateAll(array('Dns.emer' => '\'' . $newEmer . '\''), array('Dns.id' => $saveDnIds));
        	
        		$fl = $this->Dns->updateAll(array('Dns.status' => 1), array('Dns.id' => $saveDnIds));
        		#Clear the cookies holding the session data
        		$this->Session->delete('Counts.InWorkDns.' . $customer_id);
        		
        		$link =__("DN Added Succesfully",true).'&nbsp'.'<a class="fancybox fancybox.ajax" href="' . Configure::read('base_url') . 'logs/logdetails/' . $log_id . '">'  . __("LogEntry", true) . '</a>';
        		$_SESSION['success'] .= __("applySucceeded", true) . $link;
        	
        	}
        	else
        	{
        		$this->log("LOCATION controller : update_location - Bad response : $apply_response", LOG_DEBUG);
        		#$_SESSION['error'] = __('Location is not updated', true) ;
        		#$this->set('error',$_SESSION['error']);
        		
        		$link = '<a class="fancybox fancybox.ajax" href="' . Configure::read('base_url') . 'logs/logdetails/' . $log_id . '">'  . __("LogEntry", true) . '</a>';
        		$_SESSION['error'] .=  __("applyFailed", true) . $link;
        		
        	}
        	
        	
        	/*if($fl>0){
        		$transStatus = 1;
        		$_SESSION['success'] = __('Location Updated Sucessfully', true) ;
        		$this->set('success',$_SESSION['success']);
        	
        	}
        	else {
        		$transStatus = 0;
        		$_SESSION['error'] = __('Location is not updated', true) ;
        		$this->set('error',$_SESSION['error']);
        	
        	}
        	
        	
        	if($transStatus == 1)
        	{
        		$link = '<a class="fancybox fancybox.ajax" href="' . Configure::read('base_url') . 'logs/logdetails/' . $log_id . '">' . __("logEntry", true) . '</a>';
        		$_SESSION['success'] .= $link;
        	}
        	else
        	{
        		$link = '<a class="fancybox fancybox.ajax" href="' . Configure::read('base_url') . 'logs/logdetails/' . $log_id . '">' . __("logEntry", true) . '</a>';
        		$_SESSION['error'] .= $link;
        	}
        	
        	
        	
        	/*
        	
        	$fl = $this->Dns->updateAll(array('Dns.location_id' => $location_id), array('Dns.id' => $id));

            $this->log("Location controller : update_locationz - : " .$loc_id .  ':' . $loc_id1 . ':' .$location_id1, LOG_DEBUG);
            
            #Updated with DNS function to send XML command to ALG and change status
            #$apply_response = $this->apply($id, $location_id, $customer_id);
			$app_response = $this->apply($id, $location_id, $customer_id);
			
				$response = explode(":",$app_response);
				$log_id= $response[0];
				$apply_response= $response[1];
			
           # $apply_response = 0;
            $this->log("Location controller : update_location - apply response : $apply_response", LOG_DEBUG);
            if ($apply_response == 0) {
                $fl = $this->Dns->updateAll(array('Dns.status' => 1), array('Dns.id' => $id));
                #Clear the cookies holding the session data
                $this->Session->delete('Counts.InWorkDns.' . $customer_id);
            } else {
                $fl = $this->Dns->updateAll(array('Dns.status' => 4), array('Dns.id' => $id));
                #Clear the cookies holding the session data
                $this->Session->delete('Counts.InWorkDns.' . $customer_id);
            }

            if ($fl == 1) {
                $fl = $this->Dns->updateAll(array('Dns.status' => 4), array('Dns.id' => $id));
            }
        }

        if ($fl == 1) {

            echo $fl;
			$transStatus=1;
			$_SESSION['success'] = __('DNS Added Sucessfully', true) ;	
			$this->set('success',$_SESSION['success']);
        }else{
			$transStatus=0;
			$_SESSION['error'] = __('DNS is not Added', true) ;
			$this->set('error',$_SESSION['error']);
		}
		if($transStatus == 1)
		    {
			$link = '<a class="fancybox fancybox.ajax" href="' . Configure::read('base_url') . 'logs/logdetails/' . $log_id . '">' . __("logEntry", true) . '</a>';
			$_SESSION['success'] .= $link;	
		   }
		else 
		{
			$link = '<a class="fancybox fancybox.ajax" href="' . Configure::read('base_url') . 'logs/logdetails/' . $log_id . '">' . __("logEntry", true) . '</a>';
			$_SESSION['error'] .= $link;
		}

		*/

		echo 1;
        exit();
    }

    function deletelocation($id = null) {
		
	
        $location = $this->Location->find('first', array('conditions' => array('Location.id' => $id)));
        $customer_id = $location['Location']['customer_id'];
        if ($this->Location->deleteAll(array('Location.id' => $id))) {
            //$this->Session->setFlash('<div id="success">Your location has been deleted successfully.</div>');
			$_SESSION['success_msg'] = "Location Deleted Successfuly";
			
			
			
        } else {
			
			$_SESSION['success']=__('Location Not Deleted');
			$this->set('success',$_SESSION['success']);
			
            //$this->Session->setFlash('Unable to delete your location.');
        }
		
        $this->redirect(array('action' => 'index', $customer_id));
        exit();
    }

    // If no form data, find the recipe to be edited
    // and hand it to the view.
    //  $this->set('Location', $this->Location->findById($id));

    /**
     * function for uploading file
     *
     */
    function upload() {
        if ($_FILES["file"]["error"] > 0) {
            $this->set('msg', $_FILES["file"]["error"]);
        } else {
            if ($_FILES["file"]["type"] == 'audio/x-wav') {// ALLOW ONLY WAV FILE
                if (file_exists(Configure::read('upload_url') . $_FILES["file"]["name"])) {
                    $this->set('msg', $_FILES["file"]["name"] . " already exists. ");
                } else {
                    move_uploaded_file($_FILES["file"]["tmp_name"], Configure::read('upload_url') . $_FILES["file"]["name"]);
                    $this->set('msg', $_FILES["file"]["name"] . " uploaded Succesfully. ");
                }
            } else {
                $this->set('msg', 'only Wav file is allowed');
            }
        }

        $this->layout = 'ajax';
        $this->set('title_header', 'Prototype');
    }

    /*
     * **************************************************
      Function Name   : filterdnslocation
      Description     : This function is use for Filter DNS Details  in Location.
      Parameter       : NA
      Return       	  : NA
      Created Date    : 24/01/2014.
     * **************************************************
     */

    function filterdnslocation() {
        $this->layout = false;

        $location_id = isset($this->params['url']['location_id']) ? $this->params['url']['location_id'] : (isset($this->params['named']['location_id']) ? $this->params['named']['location_id'] : "");

        $rangeMinval = isset($this->params['url']['MinVal']) ? $this->params['url']['MinVal'] : (isset($this->params['named']['MinVal']) ? $this->params['named']['MinVal'] : "");
        $rangeMaxval = isset($this->params['url']['MaxVal']) ? $this->params['url']['MaxVal'] : (isset($this->params['named']['MaxVal']) ? $this->params['named']['MaxVal'] : "");

        $location = $this->Location->find('first', array('conditions' => array("Location.status" => '1', 'Location.id' => $location_id)));
        $customer_id = $location['Location']['customer_id'];
        $cust_id = $this->Session->read('SELECTED_CUSTOMER');

        $cond5 = array('Location.customer_id' => $customer_id, 'Dns.location_id' => $location_id);

        if ($rangeMinval != '' && $rangeMaxval != '') {
            $cond5 = array_merge($cond5, array('Dns.id >=' => $rangeMinval, 'Dns.id <=' => $rangeMaxval));
            $this->Session->write('cond5', serialize($cond5));
            $condition_array = print_r($cond5, true);
            $this->log("Scenario controller : Setting sesion conditions : $condition_array", LOG_DEBUG);

            $this->passedArgs['rangeMin'] = $rangeMinval;
            $this->passedArgs['rangeMax'] = $rangeMaxval;
        }

        $dnsdetail = $this->Dns->find('all', array('conditions' => $cond5, 'fields' => array('Dns.*,Location.name,Location.id,Location.scm_name'), 'group' => 'Dns.id', 'order' => 'Location.name asc'));
        $this->set('dnsdetail', $dnsdetail);
        $this->set('customer_id', $customer_id);
		$this->set('location_id', $location_id);
        $this->set('selected_customer', $customer_id);
		 $customerInfo = $this->Customer->findById($customer_id);
				
		$custtype =  $customerInfo['Customer']['type'];
		$this->set('custtype',$custtype);
		
    }

    /*
     * **************************************************
      Function Name   : create_location
      Description     : This function is use for Update Location in Dns.
      Parameter       : NA
      Return       	  : NA
      Created Date    : 25/01/2014.
     * **************************************************
     */

    function create_location($dns_id = null) {

        $this->layout = 'ajax';
        //echo $execution_id;
        //Configure::write("debug",2);

        $dns_id = isset($this->params['url']['dns_id']) ? $this->params['url']['dns_id'] : (isset($this->params['named']['dns_id']) ? $this->params['named']['dns_id'] : "");
        $customer_id = isset($this->params['url']['customer_id']) ? $this->params['url']['customer_id'] : (isset($this->params['named']['customer_id']) ? $this->params['named']['customer_id'] : "");

        $location_id = isset($this->params['url']['location_id']) ? $this->params['url']['location_id'] : (isset($this->params['named']['location_id']) ? $this->params['named']['location_id'] : "");

        $loc_id = isset($this->params['url']['loc_id']) ? $this->params['url']['loc_id'] : (isset($this->params['named']['loc_id']) ? $this->params['named']['loc_id'] : "");

        $cond = array('Location.customer_id' => $customer_id);
        $results = $this->Dns->find('all', array('conditions' => $cond, 'fields' => array('Dns.*,Location.name'), 'order' => 'Location.name asc'));


        $this->set('dns', $results);
		
		$cond10 = array('Location.id'=>$location_id);
		$loc_name = $this->Location->find('first',array('conditions'=>$cond10,'fields'=>array('Location.name'),'recursive'=>-1));
		$this->set('location_name',$loc_name);
        
        #$odsEntryList_array=print_r($odsEntryList, true);
        #$this->log("Scenario controller : Setting sesion conditions : $odsEntryList_array", LOG_DEBUG);
		
		
		
		$array1[$loc_id]='';
        $customer = $this->Customer->find('first', array('contain' => array('Location'), 'conditions' => array('id' => $customer_id)));
        $location_source = $this->Location->find('all', array('contain' => false,'conditions' => array('Location.customer_id' => $customer_id, 'Location.scm_name !=' => 'UNKNOWN', 'Location.id !=' => $loc_id),'order'=>'Location.name asc'));
		
        
        foreach ($location_source as $location):
		
		
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
		        	
		
            #$locations1[$value['id']] = $value['name'];
			#$result1 = array_keys($array1);
			#$result2 = array_keys($locations1);
			#$result5 = array_diff($result2,$result1);
			
			#foreach($result5 as $key => $value2 ) {
			#	 $locations[$value2]=$locations1[$value2];
			#}
			
			//$locations[$location['Location']['id']] = $location['Location']['name'];
			
			
        endforeach;
        /*
        
        foreach ($customer['Location'] as $key => $value):
        
        $locations1[$value['id']] = $value['name'];
         $result1 = array_keys($array1);
        $result2 = array_keys($locations1);
        $result5 = array_diff($result2,$result1);
        	
        foreach($result5 as $key => $value2 ) {
        $locations[$value2]=$locations1[$value2];
        }
        
        #$locations[$location['id']] = $location['name'];
        	
        	
        endforeach;
        
        */
        $location_array=print_r($locations, true);
        $this->log("Mediatrix controller : Location Details : $location_array", LOG_DEBUG);
		
		
        $this->set('locations', $locations);
        $this->set('dns_id', $dns_id);
        $this->set('customer_id', $customer_id);
        $this->set('selected_customer', $customer_id);
        $this->set('location_id', $location_id);
        $this->set('loc_id', $loc_id);
    }

    function update_location() {

        $this->layout = false;
        
        $dns_id = isset($this->params['url']['dns_id']) ? $this->params['url']['dns_id'] : (isset($this->params['named']['dns_id']) ? $this->params['named']['dns_id'] : "");
        $customer_id = isset($this->params['url']['customer_id']) ? $this->params['url']['customer_id'] : (isset($this->params['named']['customer_id']) ? $this->params['named']['customer_id'] : "");
        $hitdirect = isset($this->params['url']['hitdirect']) ? $this->params['url']['hitdirect'] : (isset($this->params['named']['hitdirect']) ? $this->params['named']['hitdirect'] : "");
        $location_id = isset($this->params['url']['location_id']) ? $this->params['url']['location_id'] : (isset($this->params['named']['location_id']) ? $this->params['named']['location_id'] : "");

        $loc_id = isset($this->params['url']['loc_id']) ? $this->params['url']['loc_id'] : (isset($this->params['named']['loc_id']) ? $this->params['named']['loc_id'] : "");

        $loc_id1 = $_POST['loc_id'];
        $location_id1 = $_POST['location_id'];
        $customer_id1 = $_POST['customer_id'];

        if ($hitdirect == '1') {
			
        	$currentLocation = $this->Dns->find('first', array( 'conditions' => array('Dns.id' => $dns_id)));
			
        	$origLoc = $currentLocation['Location']['id'];
        	$origEmer = $currentLocation['Location']['emer'];
        	
        	$newLocation = $this->Location->find('first', array( 'conditions' => array('Location.id' => $location_id)));
        	$newEmer = $newLocation['Location']['emer'];
        	
        	$this->log("Location controller : update_location - : " .$location_id .  ':' . $newEmer . ':' . $origLoc . ':' .$origEmer, LOG_DEBUG);
        	#Find the current EMER associated itht he Location for the DN
        	#Find the emer for the new location. compare.      	
        	
            
            
            if(($newEmer !=  $origEmer) && ($newEmer != ''))
            {
            	#Updated with DNS function to send XML command to ALG and change status
            	$app_response = $this->apply($dns_id,$location_id, $newEmer, $customer_id1);
				$response = explode(":",$app_response);
				$log_id= $response[0];
				$apply_response= $response[1];
            
            }
            else {
            	$this->log("Location controller : emergencies the same  or new emer is blank: $origEmer", LOG_DEBUG);
            	$apply_response = 1;
            }
            #$apply_response = 0;
            $this->log("Location controller : update_location - apply response : $apply_response", LOG_DEBUG);
			
									
            if ($apply_response == 1) {
                $updatelocation = $this->Dns->updateAll(array('Dns.location_id' => $location_id), array('Dns.id' => $dns_id));
                $updatelocation2 = $this->Station->updateAll(array('Station.location_id' => $location_id), array('Station.id' => $dns_id));
		
                #Update stationkey locaitons
                $stationkeyIds = $this->Feature->find('all', array (
                'fields' => 'Stationkey.id',
                'conditions' => array (
                'Feature.short_name' => 'DN',
                'Feature.primary_value' => $dns_id
                )
                ));
                $stationkeyarray = array();
                foreach ($stationkeyIds as $stationkeyId)
        		{
        			#$this->log("locations controller : staitonkey  :" . $stationkeyId['Stationkey']['id'], LOG_DEBUG);
        			array_push($stationkeyarray, $stationkeyId['Stationkey']['id']);
        		}
        		#$condition_array = print_r($stationkeyarray, true);
        		#$this->log("locations controller : staitonkey array : $condition_array", LOG_DEBUG);
        		$sku = $this->Stationkey->updateAll(array('Stationkey.location_id' => $location_id), array('Stationkey.id' => $stationkeyarray));
                
                
                $updatemr = $this->Dns->updateAll(array('Dns.emer' => '\'' . $newEmer . '\''), array('Dns.id' => $dns_id));
		    	$fl = $this->Dns->updateAll(array('Dns.status' => 1), array('Dns.id' => $dns_id));
                #Clear the cookies holding the session data
                #$this->Session->delete('Counts.InWorkDns.' . $customer_id);
                $link = '<a class="fancybox fancybox.ajax" href="' . Configure::read('base_url') . 'logs/logdetails/' . $log_id . '">'  . __("LogEntry", true) . '</a>';
                $_SESSION['success'] .= __("applySucceeded", true) . $link;
            } else {
                $fl = $this->Dns->updateAll(array('Dns.status' => 4), array('Dns.id' => $dns_id));
                #Clear the cookies holding the session data
                #$this->Session->delete('Counts.InWorkDns.' . $customer_id);
                $link = '<a class="fancybox fancybox.ajax" href="' . Configure::read('base_url') . 'logs/logdetails/' . $log_id . '">'  . __("LogEntry", true) . '</a>';
                $_SESSION['error'] .= __("applyFailed", true) . $link;
            }

		
			
        }
        else {


            $this->log("Location controller : update_location!", LOG_DEBUG);
            $cond5 = array('Location.customer_id' => $customer_id1, 'Dns.location_id' => $loc_id1);
            $dnsdetail = $this->Dns->find('all', array('conditions' => $cond5, 'fields' => array('Dns.*,Location.name,Location.id'), 'group' => 'Dns.id', 'order' => 'Location.name asc'));
            $this->set('dnsdetail', $dnsdetail);
            $customer = $this->Customer->find('first', array('contain' => array('Location'), 'conditions' => array('id' => $customer_id1)));

            foreach ($customer['Location'] as $key => $value):
                $locations[$value['id']] = $value['name'];
            endforeach;
            #$location_array=print_r($locations, true);
            #$this->log("Mediatrix controller : Location Details : $location_array", LOG_DEBUG);

            $this->set('locations', $locations);
            $this->set('customer_id', $customer_id1);
            $this->set('selected_customer', $customer_id1);
            $this->set('location_id', $loc_id1);
			
					
			
        }
    }

    function apply($dn_id, $location_id,$newEmer, $customer_id) {
        

        $dnDetails = $this->Dns->find('first',array('conditions'=>array('Dns.id' => $dn_id)));
        $function = 	$dnDetails['Dns']['function'];
        $status = 	$dnDetails['Dns']['status'];
		$customer_id = $dnDetails['Location']['customer_id'];
        
       # $locations_array = print_r($dnDetails, true);
       # $this->log("Locaitons controller : DN Map" . $locations_array, LOG_DEBUG);
        
        $bakomMapSource = $this->Bakom->find('first', array( 'conditions' => array('Bakom.emer' => $newEmer)));
        $newDnscrn = $bakomMapSource['Bakom']['emer_dnscrn'];
        
        $this->log("Location controller : Apply  TYPE :" . $function . 	' '  . $dn_id . " " . $newEmer, LOG_DEBUG);
       	#Build transaction manually.
       	$transId = time() . $_SERVER['HTTP_SSO_ACCOUNTUID'];
       	$fullTransaction = '<Activation id="' . $transId . '">';
       	$counter = 1;
       	$subTrans = $transId .  '-' . $counter;
       	$fullTransaction .= '<subtransaction id="' . $subTrans . '">';
       	$oldLocation = 	$dnDetails['Location']['name'];
       	$location = $this->Location->find('first', array('conditions' => array('Location.id' => $location_id)));
       	$newName = $location['Location']['name'];
       	$commands = '<actions>' . "\n";
       	$commands .= '<dn id="' .$dn_id . '" function="'. $function . '" oldLocation="'. $oldLocation . '" newLocation="'. $newName .'">CONFIGURE</dn>' . "\n";
       	$commands .= '</actions>' . "\n";
       	
       	if($function == 'PBX')
       	{
	       	//$fullTransaction .= '<algRequest><object action="update" name="DNSCRNLOC"><message station="NA" key="00"><var value="' . $dn_id . '" name="dn"/><var value="' . $newDnscrn . '" name="emer"/></message></object></algRequest>';
	       	
	       	if($status == 4)
	       	{
	       		$action = 'add';
	       	}
	       	else {
	       		$action = 'update';
	       	}
	       	$fullTransaction .= '<algRequest><object action="' . $action . '" name="DNSCRNLOC"><message station="NA" key="00"><var value="' . $dn_id . '" name="dn"/><var value="' . $newDnscrn . '" name="emer"/></message></object></algRequest>';
	       	
	       	$fullTransaction .= '</subtransaction>';
	       	$counter++;
	       	$subTrans = $transId .  '-' . $counter;
	       	$fullTransaction .= '<subtransaction id="' . $subTrans . '">';
	       	$fullTransaction .= '<algRequest><object action="update" name="CGPNSCRNLOC"><message station="NA" key="00"><var value="' . $dn_id . '" name="dn"/><var value="' . $newEmer . '" name="emer"/></message></object></algRequest>';
	                		 
       	}
       	else
       	{
       		$fullTransaction .= '<algRequest><object action="update" name="CGPNSCRNLOC"><message station="NA" key="00"><var value="' . $dn_id . '" name="dn"/><var value="' . $newEmer . '" name="emer"/></message></object></algRequest>';
                	
       	}
                	
       	#$fullTransaction .= '<algRequest><object action="update" name="LOCATION"><message station="NA" key="00"><var value="' . $dn_id . '" name="dn"/><var value="' . $location_id . '" name="location"/></message></object></algRequest>';
       	$fullTransaction .= '</subtransaction>';
        #$fullTransaction = '<algRequest><object action="update" name="LOCATION"><message station="NA" key="00"></message><var value="' . $dn_id . '" name="dn"/><var value="' . $location_id . '" name="location"/></message></object></algRequest>';
       	$fullTransaction .= '</Activation>';
        	
		#Save transaction
		$insert = array (
    	   	'Transaction' => array (
        	'id' => $transId,
        	'log_id' => '',
        	'transaction' => $fullTransaction,
        	'status' => 1,
        	'created' => 'NOW()'
        	)
        	);
        		
        	$this->Transaction->create();
        	$this->Transaction->save($insert, false);
        		
        	$this->log('LOCATION CONTROLLER ' . 'DN LOCAIOTN REQUEST' . $password , LOG_DEBUG);
        	$transResponse = $this->AlgInterface->processTransaction($fullTransaction);
               			#Now Create the Log entry with status and associate the transaction.
               			
        	
        	preg_match("/C20_FAILURE/", $transResponse, $matches);
        	if ($matches[0])
        	{
        	#???vIf ther was an error then it is possible to save the correctly applied features with active state but not the remaining.
        		#This can be handled by looping through the subtransactions in sequence
        		$this->log('LOCATIONS Controller : Apply TO C20 FAILED ' .  $transResponse, LOG_DEBUG);
        		$transStatus = 0;
        	}
        	else
        	{
        		$transStatus = 1;
        	}
        	
        	
        	$log = 'DN Update : Location Change';
        
        	$insert = array (
        			'Log' => array (
        			'affected_obj' => $dn_id,
        			'log_entry' => $log,
        			'log_details' => $commands,
					'created' => date('Y-m-d H:i:s'),
        			'status' => 1,
        			'customer_id' => $customer_id,
        			'bsk' => $this->Session->read('BSK'),
        			'user' => $this->Session->read('ACCOUNTNAME'),
        			'app_type' => $this->Session->read('APPNAME'),
        			'modified' => '0000-00-00 00:00:00',
        			'modification_status' => $transStatus,
        			'modification_response' => $transResponse,
					'transaction_id' => $transId
        					)
				);
        
				$this->Log->create();
			$logsave =	$this->Log->save($insert, false);
        
        		$log_id = $this->Log->id;
        
        		$transUpdate = array (
        					'Transaction' => array (
        							'id' => $transId,
        							'log_id' => $log_id,
        
        			)
        		);
        
        		$this->Transaction->save($transUpdate, false);
        
				//return 0;
				return $log_id.':'.$transStatus;
				
				
        }
        
        function apply_trans($fullTransaction, $customer_id, $commands) {
        	$this->log("DNS controller : Apply  :" . $dn_id . " " . $location_id, LOG_DEBUG);
        
        	#grab the transaction
        	preg_match("/Activation id=\"(\d+)\"/", $fullTransaction, $matches);
        	if ($matches[0]) {
        	$transId = $matches[1];
        	$this->log('LOCATIONS CONTROLLER ' . 'DN APPLY TRANSACTION: ' . $transId , LOG_DEBUG);
        	}
        	 
        	#Build transaction manually.
        	#$transId = time();
        	#$fullTransaction = '<algRequest><object action="update" name="LOCATION"><message station="NA" key="00"></message><var value="' . $dn_id . '" name="dn"/><var value="' . $location_id . '" name="location"/></message></object></algRequest>';
        
        	#Save transaction
        	$insert = array (
        	'Transaction' => array (
        	'id' => $transId,
        	'log_id' => '',
            'transaction' => $fullTransaction,
                    'status' => 1,
                    'created' => 'NOW()'
        	)
        	);
        
        	$this->Transaction->create();
        			$this->Transaction->save($insert, false);
        
			$this->log('LOCATIONS CONTROLLER ' . 'DN LOCAIOTN REQUEST' . $password , LOG_DEBUG);
        	$transResponse = $this->AlgInterface->processTransaction($fullTransaction);
        	
        	preg_match("/C20_FAILURE/", $transResponse, $matches);
        	if ($matches[0])
        	{
        	#???vIf ther was an error then it is possible to save the correctly applied features with active state but not the remaining.
        		#This can be handled by looping through the subtransactions in sequence
        		$this->log('LOCATIONS Controller : Apply TO C20 FAILED ' .  $transResponse, LOG_DEBUG);
        		$transStatus = 0;
			}
			else
			{
				$transStatus = 1;
			}
        
			#Now Create the Log entry with status and associate the transaction.
        
        			$log = 'DN Update : Location Change';
        
        		$insert = array (
        			'Log' => array (
        			'affected_obj' => $dn_id,
        			'log_entry' => $log,
        			'log_details' => $commands,
        			'created' => date('Y-m-d H:i:s'),
        			'status' => 1,
        			'customer_id' => $customer_id,
					'bsk' => $this->Session->read('BSK'),
        			'user' => $this->Session->read('ACCOUNTNAME'),
        			'app_type' => $this->Session->read('APPNAME'),
        			'modified' => '0000-00-00 00:00:00',
        			'modification_status' => $transStatus,
        			'modification_response' => $transResponse,
        			'transaction_id' => $transId
        			)
				);
        
				$this->Log->create();
				$this->Log->save($insert, false);
        
				$log_id = $this->Log->id;
        
        					$transUpdate = array (
        					'Transaction' => array (
        					'id' => $transId,
        					'log_id' => $log_id,
        
        			)
        		);
        
        		$this->Transaction->save($transUpdate, false);
        
        		//return 0;
                return $log_id.':'.$transStatus;
    } 
        

    /*
     * **************************************************
      Function Name   : edit_locations_via_ajax
      Description     : This function is use for Update Location Title.
      Parameter       : NA
      Return       	  : NA
      Created Date    : 29/01/2014.
     * **************************************************
     */
        
       

    function edit_location_via_ajax() {
		
		
		
        $this->layout = false;
        $location_name = trim($this->params['form']['value']);
        $location_id = isset($this->params['url']['location_id']) ? $this->params['url']['location_id'] : (isset($this->params['named']['location_id']) ? $this->params['named']['location_id'] : "");
        $this->Location->updateAll(
                
				array('Location.name' => "'" . htmlentities($location_name,ENT_QUOTES,"UTF-8") . "'"), array('Location.id' => $location_id)
        );
        echo $location_name;
        exit();
    }


    function export()
    {
        $this->layout = "";
        $conds = unserialize($this->Session->read('cond'));
        
        //ini_set('max_execution_time', 600); //increase max_execution_time to 10 min if data set is very large
    
        $filename = "export_location_".date("Y.m.d").".csv";
        $csv_file = fopen('php://output', 'w');
        header('Content-type: application/csv');
        header('Content-Disposition: attachment; filename="'.$filename.'"');
    
        //$results = $this->Customer->query($sql);  // This is your sql query to pull that data you need exported
        //or
        #$results = $this->Customer->find('all', array('conditions'=> array('type' => $conds),'order'=>'created DESC','recursive'=>-1));
        $results = $this->Location->find('all', array('conditions'=> $conds,'order'=>'created DESC','recursive'=>-1));
        $header_row = array(__("Nr", true),__("Name", true), __("Address", true), __("Emer", true), __("Loc Type", true),__("Lbl", true),__("Cer1", true),__("Cer2", true), __("Ort", true),__("Plz", true),__("Pro Nr", true));
        fputcsv($csv_file,$header_row,';','"');
    
        // Each iteration of this while loop will be a row in your .csv file where each field corresponds to the heading of the column
        $i=1;
        foreach($results as $result)
        {
            // Array indexes correspond to the field names in your db table(s)
            $row = array(
                $result['Location']['Sno']= $i,
                $result['Location']['name'],
                $result['Location']['address'],
                $result['Location']['emer'],
                $result['Location']['loc_type'],
                $result['Location']['lbl'],
                $result['Location']['cer1'],
                $result['Location']['cer2'],
                $result['Location']['ort'],
                $result['Location']['plz'],
                $result['Location']['pro_nr'] 
            );
            $i++;
            fputcsv($csv_file,$row,';','"');
        }
    
        fclose($csv_file);exit();
    }
	
	/**
	* function toggleView()
	* 
	* @return
	*/
	
	function toggleView() {
   
        $this->layout = false;
        $location_id = isset($this->params['url']['location_id']) ? $this->params['url']['location_id'] : (isset($this->params['named']['location_id']) ? $this->params['named']['location_id'] : "");
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

}
?>

