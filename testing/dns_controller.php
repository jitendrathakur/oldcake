
<?php

/**
 * Dns Controller
 *
 * file: /app/controllers/dns_controller.php
 */
class DnsController extends AppController {

    // good practice to include the name variable
    var $uses = array('Dns', 'Scenario', 'Odsentry', 'Station', 'Customer', 'Mediatrix', 'Trunk', 'Trunkentry', 'Transaction', 'Log','Location', 'Bakom', 'Stationkey');
    var $name = 'Dns';
    var $paginate = array('Paginate' => 25, 'page' => 1);
    // load any helpers used in the views
    var $helpers = array('Html', 'Form', 'Javascript', 'General');
    var $components = array (
    		'AlgInterface'
    );

    function beforeFilter() {
        parent::beforeFilter();

        if (!$this->Session->read('SELECTED_CUSTOMER')) {
            $this->layout = 'ajax';
            $this->log('SESSION EXPIRED', LOG_DEBUG);
            $this->cakeError('sessionExpired');
        }
        
    }

    /**
     *
     * index()
     * main index page of the locaitons page
     * url: /locations/index
     */
    function viewdns() {
    	
    	$customer_id = isset($this->params['url']['customer_id']) ? $this->params['url']['customer_id'] : (isset($this->params['named']['customer_id']) ? $this->params['named']['customer_id'] : "");
    	 
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
    	
        $this->paginate['Paginate'] = $this->AutoPaginate->setPaginate();
		#For transaction handling
        if (isset ($_SESSION['success']))
        	$this->set('success', $_SESSION['success']);
        $_SESSION['success'] = '';
        
        if (isset ($_SESSION['error']))
        	$this->set('error', $_SESSION['error']);
        $_SESSION['error'] = '';
        
       
	   $cond2 = array('Scenario.customer_id' => $customer_id);
        if (isset($customer_id) && $customer_id) {
            $this->Session->write('cond2', serialize($cond2));
            $condition_array = print_r($cond2, true);
            $this->log("DNS controller : Setting sesion conditions : $condition_array", LOG_DEBUG);
        }
        
		
		$cond1 = array('Location.customer_id' => $customer_id);
        if (isset($customer_id) && $customer_id) {
            $this->Session->write('cond', serialize($cond1));
            $condition_array = print_r($cond1, true);
            $this->log("DNS controller : Setting sesion conditions : $condition_array", LOG_DEBUG);
        }

        $location_id = isset($this->params['url']['location_id']) ? $this->params['url']['location_id'] : (isset($this->params['named']['location_id']) ? $this->params['named']['location_id'] : "");
        if ($location_id != '') {
            $cond1 = array_merge($cond1, array('Location.id LIKE' => '%' . $this->params['url']['location_id'] . '%'));
            $this->Session->write('cond', serialize($cond1));
            $condition_array = print_r($cond1, true);
            $this->log("DNS controller : Setting sesion conditions : $condition_array", LOG_DEBUG);
        }
        #$cond1 = array();

        $emer = isset($this->params['url']['emer']) ? $this->params['url']['emer'] : (isset($this->params['named']['emer']) ? $this->params['named']['emer'] : "");
        if ($emer != '') {
            $cond1 = array_merge($cond1, array('Dns.emer LIKE' => '%' . $this->params['url']['emer'] . '%'));
            $this->Session->write('cond', serialize($cond1));
            $condition_array = print_r($cond1, true);
            $this->log("DNS controller : Setting sesion conditions : $condition_array", LOG_DEBUG);
        }


        $dns_id = isset($this->params['url']['id']) ? $this->params['url']['id'] : (isset($this->params['named']['id']) ? $this->params['named']['id'] : "");
        if ($dns_id != '') {
            $cond1 = array_merge($cond1, array('Dns.id LIKE' => '%' . $dns_id . '%'));
            $this->Session->write('cond', serialize($cond1));
            $condition_array = print_r($cond1, true);
            $this->log("DNS controller : Setting sesion conditions : $condition_array", LOG_DEBUG);
        }

        $function = isset($this->params['url']['function']) ? $this->params['url']['function'] : (isset($this->params['named']['function']) ? $this->params['named']['function'] : "");

        if ($function != '') {
            if ($function == 'Used') {
                $cond1 = array_merge($cond1, array('Dns.function IS NOT NULL'));
            } elseif ($function == 'Free') {
                $cond1 = array_merge($cond1, array('Dns.function IS NULL'));
            } else {
                $cond1 = array_merge($cond1, array('Dns.function LIKE' => '%' . $function . '%'));
            }
            $this->Session->write('cond', serialize($cond1));
            $condition_array = print_r($cond1, true);
            $this->log("DNS controller : Setting sesion conditions : $condition_array", LOG_DEBUG);
        }

        $emer = isset($this->params['url']['emer']) ? $this->params['url']['emer'] : (isset($this->params['named']['emer']) ? $this->params['named']['emer'] : "");
        if ($emer != '') {
            $cond1 = array_merge($cond1, array('Dns.emer LIKE' => '%' . $emer . '%'));
            $this->Session->write('cond', serialize($cond1));
            $condition_array = print_r($cond1, true);
            $this->log("DNS controller : Setting sesion conditions : $condition_array", LOG_DEBUG);
        }

        $display = isset($this->params['url']['display']) ? $this->params['url']['display'] : (isset($this->params['named']['display']) ? $this->params['named']['display'] : "");
        if ($display != '') {
            $cond1 = array_merge($cond1, array('Dns.display LIKE' => '%' . $display . '%'));
            $this->Session->write('cond', serialize($cond1));
            $condition_array = print_r($cond1, true);
            $this->log("DNS controller : Setting sesion conditions : $condition_array", LOG_DEBUG);
        }


        $this->set('title_header', 'DN List');
        $this->pageTitle = 'DN List';
		
		//New Change Location list dropdown
		$location_source = $this->Location->find('all', array('contain' => false,'conditions' => array('Location.customer_id' => $customer_id),'order'=>'Location.name asc'));
		
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
		        			
        endforeach;
		
		
		

        $customer = $this->Customer->find('first', array('contain' => array('Location'), 'conditions' => array('id' => $customer_id)));
		//Old Location Dropdown value
        /*foreach ($customer['Location'] as $key => $value):
          			
			if($value['scm_name']=="" && $value['address']!="" ) {
				$locations[$value['id']] =$locationstring = $value['name'] . ' ( ' . $value['plz'] . ' ,' .$value['address'].' )';
			}
			elseif($value['address']=="" && $value['scm_name']!="") {
				$locations[$value['id']] =$locationstring = $value['name'] . ' ( ' . $value['plz'] . ' ,' .$value['scm_name'].' )';
			}
			elseif($value['address']=="" && $value['scm_name']=="" && $value['plz']!="") {
            $locations[$value['id']] = $value['name'] . ' ( ' . $value['plz'] .' )';
			}
			elseif($value['address']=="" && $value['scm_name']=="" && $value['plz']=="") {
            $locations[$value['id']] = $value['name'];
			}
			
			else {
				$locations[$value['id']] = $value['name'] . ' ( ' . $value['plz'] . ' ,' . $value['scm_name'] . ','.$value['address'].' )';
			}
        endforeach;*/
		
		
        $custName = $customer['Customer']['name'];
        $custId = $customer['Customer']['id'];
		$info1 = $customer['Customer']['Info1'];
		$onDemand = $customer['Customer']['onDemand'];
        $this->Session->write('Customer.Name', $custName);
        $this->Session->write('Customer.Id', $custId);
        $this->set('custId', $custId);
        $this->set('custType', $customer['Customer']['type']);
        $this->set('SELECTED_CNN', $custId);
        $this->set('cust_for_layout', $custName);
        $this->set('custName', $custName);
        $this->set('selected_customer', $custName);
        $this->set('locations', $locations);
		$this->set('info1',$info1);
		$this->set('onDemand',$onDemand);

        $emers = $this->Dns->find('all', array('fields' => 'DISTINCT emer', 'order' => 'Dns.emer asc', 'conditions' => array('Location.customer_id' => $customer_id)));
        foreach ($emers as $emer):
            $emer_list[$emer['Dns']['emer']] = $emer['Dns']['emer'];
        endforeach;
        $this->set('emer_list', $emer_list);


        #$join_locations = array('table'=>'locations','alias'=>'Location','type'=>'INNER','foreignKey'=>false,'conditions'=>$cond);
        #$this->Dns->recursive=2;			
        #---------------GATE---------------#

       # if ($customer['Customer']['type'] == 'Gate') {
        if (1) {


            $trunktitle = isset($this->params['url']['trunk_id']) ? $this->params['url']['trunk_id'] : (isset($this->params['named']['trunk_id']) ? $this->params['named']['trunk_id'] : "");
            if ($trunktitle != '') {
                $cond1 = array_merge($cond1, array('Trunkentry.trunk_id' => $trunktitle));
                $this->passedArgs['trunk_id'] = $trunktitle;
				$this->Session->write('cond', serialize($cond1));
            	$condition_array = print_r($cond1, true);
            	$this->log("DNS controller : Setting sesion conditions : $condition_array", LOG_DEBUG);
                #$trunkids= $this->Trunk->find('list',array('conditions'=>array('Trunk.name LIKE'=>'%'.$trunktitle.'%'),'fields'=>array('Trunk.id')));
                #$this->loadModel('Trunkentry');
                #$trunkdnsids= $this->Trunkentry->find('list',array('conditions'=>array('Trunkentry.trunk_id'=>$trunkids),'fields'=>array('Trunkentry.dn_id'), 'group'=>'Trunkentry.dn_id'));
            }
								

            $odsscenario_id = isset($this->params['url']['odsscenario_id']) ? $this->params['url']['odsscenario_id'] : (isset($this->params['named']['odsscenario_id']) ? $this->params['named']['odsscenario_id'] : "");
            if ($odsscenario_id != '') {
                $cond1 = array_merge($cond1, array('Odsentry.scenario_id' => $odsscenario_id));
                $this->passedArgs['odsscenario_id'] = $odsscenario_id;
				$this->Session->write('cond', serialize($cond1));
            $condition_array = print_r($cond1, true);
            $this->log("DNS controller : Setting sesion conditions : $condition_array", LOG_DEBUG);
                #$scenarioids= $this->Scenario->find('list',array('conditions'=>array('Scenario.name LIKE'=>'%'.$odsscenario_id.'%', 'Scenario.customer_id'=>$customer_id),'fields'=>array('Scenario.id')));
                #$odsentrysource= $this->Odsentry->find('list',array('conditions'=>array('Odsentry.scenario_id'=>$scenarioids),'fields'=>array('Odsentry.source'), 'group'=>'Odsentry.source'));
            }

            $scenarioData = $this->Scenario->find('all', array(
                'fields' => array('Scenario.id', 'Scenario.Name','Scenario.status'),
                'conditions' => array('Scenario.customer_id' => $customer_id)
            ));
            $scenarioDataArray = array();

            foreach ($scenarioData as $scendata) {
                $scenarioDataArray[$scendata['Scenario']['id']] = $scendata['Scenario']['Name'];
				#$scenarioDataArray[$scendata['Scenario']['id']] = $scendata['Scenario']['status'];
            }
            $dnsArray = print_r($scenarioDataArray, true);
            $this->log("DNS controller : Scenario array : $dnsArray", LOG_DEBUG);
            $this->set('scenarioData', $scenarioDataArray);
			
			
			
			
			
			$scenarioDataStatusArray = array();

            foreach ($scenarioData as $scendatastatus) {
                $scenarioDataStatusArray[$scendata['Scenario']['id']] = $scendatastatus['Scenario']['status'];
				#$scenarioDataArray[$scendata['Scenario']['id']] = $scendata['Scenario']['status'];
            }
            $dnsStatusArray = print_r($scenarioDataStatusArray, true);
            $this->log("DNS controller : Scenariostatus  array : $dnsStatusArray", LOG_DEBUG);
            $this->set('scenarioStatusData', $scenarioDataStatusArray);
			
			
			

            $scenarioRecords = $this->Dns->generateScenarioMap($customer_id);
            if (!empty($scenarioRecords)) {
                foreach ($scenarioRecords as $recordId => $records) {
                    #$recordCount++;
                    $dnsId = $records['d']['id'];
                    $scenarioId = $records['o']['scenario_id'];
                    $scenarioMap[$dnsId][$recordId] = $scenarioId;
                }
                #$dnsArray = print_r($scenarioMap, true);
                #$this->log("DNS controller : Scenario array : $dnsArray", LOG_DEBUG);
                $this->set('scenarioMap', $scenarioMap);
            }


            //Set all Trunks
            $TrunkData = $this->Trunk->find('all', array(
                'fields' => array('Trunk.id', 'Trunk.name'),
                'conditions' => array('Location.customer_id' => $customer_id)));
            $TrunkDataArray = array();

            foreach ($TrunkData as $trdata) {
                $TrunkDataArray[$trdata['Trunk']['id']] = $trdata['Trunk']['name'];
            }

            $this->set('TrunkDataData', $TrunkDataArray);


            $this->paginate = array(
                'limit' => 11000,
                'fields' => array(
                    'Dns.*',
                    'Location.*',
                    'group_concat(Distinct Trunkentry.trunk_id) as trunklist',
                    'group_concat(Distinct Odsentry.scenario_id) as scenlist'
                ),
                'joins' => array(
                    array(
                        'table' => 'trunkentries',
                        'type' => 'LEFT OUTER',
                        'alias' => 'Trunkentry',
                        'conditions' => array('Trunkentry.dn_id = Dns.id')
                    )
                ),
                'conditions' => $cond1,
                'order' => 'Dns.id asc',
                'limit' => $this->paginate['limit'],
                'group' => 'Dns.id'
            );
        } else {


            //$this->paginate = array( 'fields'=>array('DISTINCT Dns.id', 'Dns.*'), 'conditions'=>$cond1,'order'=>'Location.name asc','limit' => $this->paginate['limit']);
            $this->paginate = array('conditions' => $cond1, 'group' => 'Dns.id', 'order' => 'Dns.id asc', 'limit' => $this->paginate['limit']);
            //$this->paginate = array('conditions'=>$cond1,'group'=>'Dns.id','order'=>'Location.name asc','limit' => $this->paginate['limit']);
        }


        #---------------END GATE-------------#			
        //$this->paginate = array( 'fields'=>array('DISTINCT Dns.id', 'Dns.*'), 'conditions'=>$cond1,'order'=>'Location.name asc','limit' => $this->paginate['limit']);
        //$this->paginate = array( 'conditions'=>$cond1,'order'=>'Location.name asc','limit' => $this->paginate['limit']);
        //$this->paginate = array('conditions'=>$cond1,'group'=>'Dns.id','order'=>'Location.name asc','limit' => $this->paginate['limit']);

        $results = $this->paginate('Dns');


        #$dnsArray = print_r($results, true);
        #$this->log("DNS controller : details aray : $dnsArray", LOG_DEBUG);

       #echo "<pre>"; print_r($results);

        $this->set('dns', $results);


        $functions = $this->Dns->find('all', array(
            'fields' => array('DISTINCT function'),
            'conditions' => array('customer_id' => $custId)
        ));
        $func_list[''] = '';
        foreach ($functions as $func):
            $localized_function = __($func['Dns']['function'], true);
            $func_list[$func['Dns']['function']] = "$localized_function";
        endforeach;
        #Add a record for filtering all non-blank
        $func_list['Used'] = __('Used', true);
        $func_list['Free'] = __('free', true);
        $this->set('func_list', $func_list);

        #For export usage

        if (isset($this->params['url']['type']) && $this->params['url']['type'] == 'detail') {
            $this->layout = false;
            $this->render('viewdnsdetail');
        }
    }

    

    function edit() {
        extract($_POST);

        $customer_id = isset($this->params['url']['customer_id']) ? $this->params['url']['customer_id'] : (isset($this->params['named']['customer_id']) ? $this->params['named']['customer_id'] : "");

        $cond = array('Location.customer_id' => $customer_id, 'Dns.function !=' => NULL);

        $rangeMinval = isset($data['rangeMin']['minval']) ? $data['rangeMin']['minval'] : "";
        $rangeMaxval = isset($data['rangeMax']['maxval']) ? $data['rangeMax']['maxval'] : "";

        if ($rangeMinval != '' && $rangeMaxval != '') {
            $cond = array_merge($cond, array('Dns.id >=' => $rangeMinval, 'Dns.id <=' => $rangeMaxval));
            //$cond = array_merge($cond,array('Scenario.source <'=>$rangeMaxval));
            $this->Session->write('cond', serialize($cond));
            $condition_array = print_r($cond, true);
            $this->log("Scenario controller : Setting sesion conditions : $condition_array", LOG_DEBUG);
            #$this->set('station_id',$station_id);
            #Set below for sort/filter problem where filter arguments not passed to sort
            $this->passedArgs['rangeMin'] = $rangeMinval;
            $this->passedArgs['rangeMax'] = $rangeMaxval;
        }

        $results = $this->Dns->find('all', array('conditions' => $cond, 'fields' => array('Dns.*,Location.name,Location.id'), 'group' => 'Dns.id', 'order' => 'Location.name asc'));

        //$results = $this->paginate('Dns');
        //echo "<pre>";print_r($results);die;
        $this->set('dns', $results);


        #$odsEntryList_array=print_r($odsEntryList, true);
        #$this->log("Scenario controller : Setting sesion conditions : $odsEntryList_array", LOG_DEBUG);
        $customer = $this->Customer->find('first', array('contain' => array('Location'), 'conditions' => array('id' => $customer_id)));

        foreach ($customer['Location'] as $key => $value):
            $locations[$value['id']] = $value['name'];
        endforeach;
        #$location_array=print_r($locations, true);
        #$this->log("Mediatrix controller : Location Details : $location_array", LOG_DEBUG);

        $this->set('locations', $locations);
        //echo "<pre>";print_r($locations);


        $this->set('customer_id', $customer_id);
        $this->set('SELECTED_CUSTOMER', $customer_id);
        $this->set('SELECTED_CNN', $customer_id);


        $this->set('rangeMinval', $rangeMinval);
        $this->set('rangeMaxval', $rangeMaxval);
        $this->set('scenario_state', $scenario_status);
        $this->pageTitle = 'DN Edit';

        $this->set('custDNCount', $this->Dns->find('count', array(
                    'conditions' => array('Location.customer_id' => $customer_id, 'Dns.status' => 4)
                        )
                )
        );
    }

    /* Function to update senario name form from Edit scenario page.  */

    function update_dnsdetails() {
        $this->layout = false;
       
        $dns_id = isset($this->params['url']['scenario_id']) ? $this->params['url']['scenario_id'] : (isset($this->params['named']['scenario_id']) ? $this->params['named']['scenario_id'] : "");

        $dns_name = isset($this->params['url']['scenario_name']) ? $this->params['url']['scenario_name'] : (isset($this->params['named']['scenario_name']) ? $this->params['named']['scenario_name'] : "");

        $data['Dns']['Name'] = $scenario_name;
        $data['Dns']['id'] = $scenario_id;

        if ($this->Dns->save($data)) {
            echo $dns_id;
        } else {
            echo "saving error";
        }
        exit();
    }

    /* Function to Open the update destination form from Edit scenario page */

    function activate() {

        $this->layout = false;
        if (isset($_POST['customer_id']) && $_POST['customer_id']) {
            $customer_id = $_POST['customer_id'];
            $this->log("DNS controller : Activated DNS : " . $customer_id, LOG_DEBUG);
            #This means we are receiving confrmation

            $fl = $this->Dns->updateAll(array('Dns.status' => 1, 'Dns.modified' => false), array('Location.customer_id' => $customer_id, 'Dns.status' => 4));
            #Clear the cookies holding the session data
            $this->Session->delete('Counts.InWorkDns.' . $customer_id);
        } else {
            $customer_id = isset($this->params['url']['customer_id']) ? $this->params['url']['customer_id'] : (isset($this->params['named']['customer_id']) ? $this->params['named']['customer_id'] : "");


            $this->set('custDNCount', $this->Dns->find('count', array(
                        'conditions' => array('Location.customer_id' => $customer_id, 'Dns.status' => 4)
                            )
                    )
            );
        }
        $this->set('customer_id', $customer_id);
    }

    /* Function to Open the update destination form from Edit scenario page */

    function openlocationupdateview() {
        $this->layout = false;

        $customer_id = isset($this->params['url']['customer_id']) ? $this->params['url']['customer_id'] : (isset($this->params['named']['customer_id']) ? $this->params['named']['customer_id'] : "");
        $loc_id = isset($this->params['url']['loc_id']) ? $this->params['url']['loc_id'] : (isset($this->params['named']['loc_id']) ? $this->params['named']['loc_id'] : "");

        $this->set('customer_id', $customer_id);
        $this->set('loc_id', $loc_id);

        /*
         * 
         $array1[$loc_id]='';
	    $customer = $this->Customer->find('first', array('contain' => array('Location'), 'conditions' => array('id' => $customer_id)));
        foreach ($customer['Location'] as $key => $value):
            #$locations[$value['id']] = $value['name'];
			$locations1[$value['id']] = $value['name'];		
			
			$result1 = array_keys($array1);			
			$result2 = array_keys($locations1);			
			$result5 = array_diff($result2,$result1);
			
			foreach($result5 as $key => $value2 ) {
				 $locations[$value2]=$locations1[$value2];
			}
        endforeach;
        */
        
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

        $this->set('locations', $locations);

        // Find out all the locations for this customer and show to choose location
        $this->Location->recursive = -1;
        $location_array = $this->Location->find('all', array('conditions' => array('Location.customer_id' => $customer_id)));

        $this->set('locationlists', $location_array);
    }

    /* function to update location id for specific dns */

    function assignlocation() {
		
$this->autoRender = false;
        $customer_id = isset($this->params['url']['customer_id']) ? $this->params['url']['customer_id'] : (isset($this->params['form']['customer_id']) ? $this->params['form']['customer_id'] : "");

        $location_id = isset($this->params['url']['location_id']) ? $this->params['url']['location_id'] : (isset($this->params['form']['location_id']) ? $this->params['form']['location_id'] : "");

       $dnsids = isset($this->params['url']['dnsids']) ? $this->params['url']['dnsids'] : (isset($this->params['form']['dnsids']) ? $this->params['form']['dnsids'] : "");
	   
       $this->log('DNS CONTROLLER : DNS IDs: ' . $dnsids, LOG_DEBUG);
        $DnsIdsArray = split('-', $dnsids);		
	        
        ###build a map of DN to current emergency string
        
        $dnsMap = $this->Dns->find('all', 
        		array( 
        			'fields' => 
        				array('Location.name','Dns.id','Dns.emer', 'Dns.function', 'Dns.status'),
        			'conditions' => 
        				array('Location.customer_id' => $customer_id, 'Dns.id' => $DnsIdsArray)
        			)
        		);
      
		
       
        foreach ($dnsMap as $dnMap)
        {
        	$currentEmerMap[$dnMap['Dns']['id']]['emer'] = $dnMap['Dns']['emer'];
        	$currentEmerMap[$dnMap['Dns']['id']]['function'] = $dnMap['Dns']['function'];
        	$currentEmerMap[$dnMap['Dns']['id']]['status'] = $dnMap['Dns']['status'];
        	$currentEmerMap[$dnMap['Dns']['id']]['oldLocation'] = $dnMap['Location']['name'];
        }
		
			#print_r($currentEmerMap);
			
        #$condition_array = print_r($currentEmerMap, true);
       # $this->log("DNS controller : DNS MAP: $condition_array", LOG_DEBUG);
        
        $newLocation = $this->Location->find('first', array( 'conditions' => array('Location.id' => $location_id)));
        $newEmer = $newLocation['Location']['emer'];
        $newName = $newLocation['Location']['name'];
		echo "<pre>";print_r($newEmer);//exit;
        $bakomMapSource = $this->Bakom->find('first', array( 'conditions' => array('Bakom.emer' => $newEmer)));
        $newDnscrn = $bakomMapSource['Bakom']['emer_dnscrn'];
        
        $saveDnIds = array();
        if (!empty($DnsIdsArray)) {
        	
        	$transId = time();
        	$counter = 1;
        	$fullTransaction = '<Activation id="' . $transId . '">';
        	$this->log('DNS CONTROLLER : Generating new timestamp : ' . $transId, LOG_DEBUG);
        	
        	$commands = '<actions>' . "\n";
            foreach ($DnsIdsArray as $dnsId) {
                if ($dnsId != '' && $location_id != '') {
                	$dnsId = intval($dnsId);
                	#($dnsId,$currentEmer) =  split(':', $dnsId); # change to split the DN record when got.
                	$currentEmer = $currentEmerMap[$dnsId]['emer']; 
                	$function = $currentEmerMap[$dnsId]['function'];
                	$status = $currentEmerMap[$dnsId]['status'];
                	$oldLocation = $currentEmerMap[$dnsId]['oldLocation'];
                	$condition_array = print_r($currentEmerMap, true);
               # 	$this->log("debug assign : $condition_array", LOG_DEBUG);
                	
                	
                	$this->log('DNS CONTROLLER : CHECKING DN : ' . $dnsId . ' : ' . $currentEmer . ' : '  . $newEmer, LOG_DEBUG);
                	                	
                	#Only when the emergency strings are different.
                	if($currentEmer != $newEmer)
                	{
                		if($newEmer != '')
                		{
	                		$this->log('DNS CONTROLLER : DIFFERENT EMERGENCIES : function ' . $function  . ' emergencies' . $currentEmer . ' : ' . $newEmer , LOG_DEBUG);
	
		                	$subTrans = $transId .  '-' . $counter;
		                	$fullTransaction .= '<subtransaction id="' . $subTrans . '">';
		                	if($function == 'PBX')
		                	{
		                		
		                		
		                		if($status == 4)
		                		{
		                			$action = 'add';
		                		}
		                		else {
		                			$action = 'update';	
		                		}
			                	$fullTransaction .= '<algRequest><object action="' . $action . '" name="DNSCRNLOC"><message station="NA" key="00"><var value="' . $dnsId . '" name="dn"/><var value="' . $newDnscrn . '" name="emer"/></message></object></algRequest>';
		                		
		                		$fullTransaction .= '</subtransaction>';
			                	$counter++;
			                	$subTrans = $transId .  '-' . $counter;
			                	$fullTransaction .= '<subtransaction id="' . $subTrans . '">';
			                	$fullTransaction .= '<algRequest><object action="update" name="CGPNSCRNLOC"><message station="NA" key="00"><var value="' . $dnsId . '" name="dn"/><var value="' . $newEmer . '" name="emer"/></message></object></algRequest>';
			                	$commands .= '<dn id="' .$dnsId . '" function="'. $function . '" oldLocation="'. $oldLocation . '" newLocation="'. $newName .'">CONFIGURE</dn>' . "\n";
			                	
		                	}
		                	else
		                	{
		                		#check for free numbers.
		                		#if($function == '')
		                		#{
		                		#	$this->log('DNS CONTROLLER : FREE DN ONLY SAVE. : ', LOG_DEBUG);
		                		#	$commands .= '<dn id="' .$dnsId .  '" function="'. $function .'" oldLocation="'. $oldLocation . '" newLocation="'. $newName  .'">DB_UPDATE</dn>' . "\n";
		                			 
		                		#}
		                		#else
		                		#{
		                			$commands .= '<dn id="' .$dnsId . '" function="'. $function . '" oldLocation="'. $oldLocation . '" newLocation="'. $newName .'">CONFIGURE</dn>' . "\n";
		                	 
		                			$fullTransaction .= '<algRequest><object action="update" name="CGPNSCRNLOC"><message station="NA" key="00"><var value="' . $dnsId . '" name="dn"/><var value="' . $newEmer . '" name="emer"/></message></object></algRequest>';
		                		#}
		                	}
		                	
		                	#$fullTransaction .= '<algRequest><object action="update" name="LOCATION"><message station="NA" key="00"><var value="' . $dn_id . '" name="dn"/><var value="' . $location_id . '" name="location"/></message></object></algRequest>';
		                	$fullTransaction .= '</subtransaction>';
		                	#$fullTransaction = '<algRequest><object action="update" name="LOCATION"><message station="NA" key="00"></message><var value="' . $dn_id . '" name="dn"/><var value="' . $location_id . '" name="location"/></message></object></algRequest>';
		                	 $counter++;
		                	 
		                	 
		                	 
                		}
                		else
                		{
                			$this->log('DNS CONTROLLER : BLANK EMER ONLY SAVE. : ', LOG_DEBUG);
                			
                			
                			$commands .= '<dn id="' .$dnsId .  '" function="'. $function .'" oldLocation="'. $oldLocation . '" newLocation="'. $newName  .'">DBUPDATE</dn>' . "\n";
                			
                		}
               	 
                	}
                	else
                	{
						#$transMessage = "location update (no configuration requried)";
						#$fullTransaction .= '<algRequest><object action="update" name="CGPNSCRNLOC" value="' . $transMessage . '"><message >
						#<var value="' . $transMessage . '" name="notransMessage"/>
						#</message></object></algRequest>';
                		$this->log('DNS CONTROLLER : NOT DIFFERENT ONLY SAVE. : ', LOG_DEBUG);
                	
                		$commands .= '<dn id="' .$dnsId . '" function="'. $function .'" oldLocation="'. $oldLocation . '" newLocation="'. $newName  .'">DB_UPDATE</dn>' . "\n";
                		
                		
                	}
                    
               			#Store the ID as an ID to store ???Need to think how to svave only successfull trans ID's
                		#array_push($saveDnIds, $dnsId);
                		$saveDnIds[$dnsId] = $dnsId;
                		
                		
                		/*$log = 'DN Update : Location Change';
                		
                		$insert = array (
                				'Log' => array (
                						'affected_obj' => '',
                						'log_entry' => $log,
                						'created' => date('Y-m-d H:i:s'),
                						'status' => 1,
                						'customer_id' => $customer_id,
                						'bsk' => $this->Session->read('BSK'),
                						'user' => $this->Session->read('ACCOUNTNAME'),
                						'app_type' => $this->Session->read('APPNAME'),
                						'modified' => '0000-00-00 00:00:00',
                						'modification_status' => 1,
                						'modification_response' => '',
                						'transaction_id' => ''
                				)
                		);
                		
                		$this->Log->create();
                		$this->Log->save($insert, false);
                		
                		$log_id = $this->Log->id;
                		*/
                		
                		
                		
						
						//$apply_response1 = $this->apply($dnsId,$location_id, $customer_id);
                }
            }
            $commands .= '</actions>' . "\n";
			
			
			
			
            $fullTransaction .= '</Activation>';
			
			
            

            #Updated with DNS function to send XML command to ALG and change status
            $app_response = $this->apply_trans($fullTransaction, $customer_id, $commands);
			$response = explode(":",$app_response);
				$log_id= $response[0];
				$apply_response= $response[1];
			
			//$apply_response1 = $this->apply($fullTransaction, $customer_id);
			
            #$apply_response = 0;
            $this->log("DNS controller : update_location - apply response : $apply_response", LOG_DEBUG);
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
        			#$this->log("dns controller : staitonkey  :" . $stationkeyId['Stationkey']['id'], LOG_DEBUG);
        			array_push($stationkeyarray, $stationkeyId['Stationkey']['id']);
        		}
        		#$condition_array = print_r($stationkeyarray, true);
        		#$this->log("locations controller : staitonkey array : $condition_array", LOG_DEBUG);
        		$sku = $this->Stationkey->updateAll(array('Stationkey.location_id' => $location_id), array('Stationkey.id' => $stationkeyarray));
        		#$sku = $this->Station->updateAll(array('Station.location_id' => $location_id), array('Station.id' => $stationkeyarray));
				
				
				$fl = $this->Dns->updateAll(array('Dns.emer' => '\'' . $newEmer . '\''), array('Dns.id' => $saveDnIds));
				
            	$fl = $this->Dns->updateAll(array('Dns.status' => 1), array('Dns.id' => $saveDnIds));
            	#Clear the cookies holding the session data
            	$this->Session->delete('Counts.InWorkDns.' . $customer_id);
            	$link = '<a class="fancybox fancybox.ajax" href="' . Configure::read('base_url') . 'logs/logdetails/' . $log_id . '">' . __("LogEntry", true) . '</a>';
            	$_SESSION['success'] .= __('Location Updated Sucessfully', true)."  ".$link;
				
            }
            else
            {
            	$this->log("DNS controller : update_location - Bad response : $apply_response", LOG_DEBUG);
            	$link = '<a class="fancybox fancybox.ajax" href="' . Configure::read('base_url') . 'logs/logdetails/' . $log_id . '">' . __("LogEntry", true) . '</a>';
            	$_SESSION['error'] .= __('Location is not updated', true)."  ".$link;
            }
			
            /*
			if($fl>0){
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
            	$link = '<a class="fancybox fancybox.ajax" href="' . Configure::read('base_url') . 'logs/logdetails/' . $log_id . '">' . __("LogEntry", true) . '</a>';
            	$_SESSION['success'] .= $link;
            }
            else
            {
            	$link = '<a class="fancybox fancybox.ajax" href="' . Configure::read('base_url') . 'logs/logdetails/' . $log_id . '">' . __("LogEntry", true) . '</a>';
            	$_SESSION['error'] .= $link;
            }
            */
            
            
           // echo $customer_id;
        }

        exit();
    }

    function apply($dn_id, $location_id, $customer_id) {
        $this->log("DNS controller : Apply  :" . $dn_id . " " . $location_id, LOG_DEBUG);


        	#Build transaction manually.
        	$transId = time();
        	$fullTransaction = '<algRequest><object action="update" name="LOCATION"><message station="NA" key="00"></message><var value="' . $dn_id . '" name="dn"/><var value="' . $location_id . '" name="location"/></message></object></algRequest>';
        
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
        
        			$log = 'DN Update : Location Change';
        
        			$insert = array (
        			'Log' => array (
        			'affected_obj' => $dn_id,
        			'log_entry' => $log,
					'created' => date('Y-m-d H:i:s'),
        			'status' => 1,
        			'customer_id' => $customer_id,
        			'bsk' => $this->Session->read('BSK'),
        			'user' => $this->Session->read('ACCOUNTNAME'),
        			'app_type' => $this->Session->read('APPNAME'),
        			'modified' => '0000-00-00 00:00:00',
        			'modification_status' => 1,
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
        
					return 0;
    }

    
    function apply_trans($fullTransaction, $customer_id, $commands) {
    	$this->log("DNS controller : Apply  :" . $dn_id . " " . $location_id, LOG_DEBUG);
    
    	#grab the transaction
    	preg_match("/Activation id=\"(\d+)\"/", $fullTransaction, $matches);
    	if ($matches[0]) {
    		$transId = $matches[1];
    		$this->log('DNS CONTROLLER ' . 'DN APPLY TRANSACTION: ' . $transId , LOG_DEBUG);
    	}
    	else {
    		//For future, maybe add something when no transaction generated.
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
    
			$this->log('DNS CONTROLLER ' . 'DN LOCAIOTN REQUEST' . $password , LOG_DEBUG);
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
    /* Function to update destination value form from Edit scenario page. This function is calling recursively via jQuery to update the destination. */

    function updateviajQuery() {
        $this->layout = false;
        $dns_id = isset($this->params['url']['dns_id']) ? $this->params['url']['dns_id'] : (isset($this->params['named']['dns_id']) ? $this->params['named']['dns_id'] : "");

        $loc_id = isset($this->params['url']['loc_id']) ? $this->params['url']['loc_id'] : (isset($this->params['named']['loc_id']) ? $this->params['named']['loc_id'] : "");

        if ($this->Dns->updateAll(array('Dns.location_id' => $loc_id), array('Dns.id' => $loc_id))) {
            
        } else {
            echo "saving error";
        }

        exit(); // Exit applied here due to this function is calling via jQuery and there is not view for this function.
    }

    function savedns() {
        
    }

    /**
     *
     * selectdns()
     * main selectdns page of the locaitons page
     * url: /locations/index
     */
    function selectdns() {
        $this->layout = false;
        $this->paginate['Paginate'] = $this->AutoPaginate->setPaginate();
        #Check to see what type of usage
        #for odsentries
        //echo "<pre>"; print_r($this->params); die;
        $scenario_id = isset($this->params['url']['scenario_id']) ? $this->params['url']['scenario_id'] : (isset($this->params['named']['scenario_id']) ? $this->params['named']['scenario_id'] : "");


        #$scenario_name=isset($this->params['url']['scenario_name'])?$this->params['url']['scenario_name']:(isset($this->params['named']['scenario_name'])?$this->params['named']['scenario_name']:"");


        $station_id = isset($this->params['url']['station_id']) ? $this->params['url']['station_id'] : (isset($this->params['named']['station_id']) ? $this->params['named']['station_id'] : "");
        $port_id = isset($this->params['url']['port_id']) ? $this->params['url']['port_id'] : (isset($this->params['named']['port_id']) ? $this->params['named']['port_id'] : "");
        $location_id = isset($this->params['url']['location_id']) ? $this->params['url']['location_id'] : (isset($this->params['named']['location_id']) ? $this->params['named']['location_id'] : "");

        /* This variable is being sent from Group list for Add Group functionality */
        $grouptype = isset($this->params['url']['grouptype']) ? $this->params['url']['grouptype'] : (isset($this->params['named']['grouptype']) ? $this->params['named']['grouptype'] : "");

        $type = isset($this->params['url']['type']) ? $this->params['url']['type'] : (isset($this->params['named']['type']) ? $this->params['named']['type'] : "");

        $groupcustomer_id = isset($this->params['url']['customer_id']) ? $this->params['url']['customer_id'] : (isset($this->params['named']['location_id']) ? $this->params['named']['customer_id'] : "");

        $odsentryIds = array();
        
        if ($grouptype != '') {
            $this->set('groupcustomer_id', $groupcustomer_id);
            $this->set('grouptype', $grouptype);
        }

        $this->set('type', $type);


        /* End of gating parameters value for Add Group functionality */
        #$customer_id=isset($this->params['url']['customer_id'])?$this->params['url']['customer_id']:(isset($this->params['named']['customer_id'])?$this->params['named']['customer_id']:"");
        if ($scenario_id != '') {
            $customer_array = $this->Scenario->find('all', array('fields' => array('DISTINCT customer_id', 'Name'), 'conditions' => array('id' => $scenario_id)));
            $customer_id = $customer_array[0]['Scenario']['customer_id'];
            $scenario_name = $customer_array[0]['Scenario']['Name'];
            #$scenario_id = $customer_array[0]['Scenario']['id'];
            $this->set('scenario_name', $scenario_name);
            $this->set('scenario_id', $scenario_id);
            
            $Odsentries = $this->Odsentry->find('all', array('fields' => array('Odsentry.*'),'conditions' => array('scenario_id' => $scenario_id), 'order' => array("dest" => 'ASC')));
            $odsCount = count($Odsentries);

            $this->set('odsCount', $odsCount);
             
            
            
        } elseif ($station_id != '') {
            $customer_array = $this->Station->find('all', array('fields' => 'DISTINCT customer_id', 'conditions' => array('Station.id' => $station_id)));
            $customer_id = $customer_array[0]['Station']['customer_id'];
        } elseif ($location_id != '') {

            #If launched in context of a location then exclude all DNS from that view and show all NULL
            $location_array = $this->Location->find('all', array('fields' => array('customer_id', 'name'), 'conditions' => array('Location.id' => $location_id)));
            $customer_id = $location_array[0]['Location']['customer_id'];

            $this->set('location_id', $location_id);
            $this->set('location_name', $location_array[0]['Location']['name']);
        } else {
            $customer_id = isset($this->params['url']['customer_id']) ? $this->params['url']['customer_id'] : (isset($this->params['named']['customer_id']) ? $this->params['named']['customer_id'] : "");
            $this->log("DNS controller : CustomerId : $customer_id", LOG_DEBUG);
        }
        if ($port_id != '') {
            $this->set('portId', $port_id);
        }

        $station_id = ($station_id) ? $station_id : 0;

        $custArray = print_r($customer_id, true);
        $this->log("DNS controller : CustomerId : $custArray", LOG_DEBUG);
        $cond1 = array('Location.customer_id' => $customer_id);
        if (isset($customer_id) && $customer_id) {
            $this->Session->write('cond', serialize($cond1));
            $condition_array = print_r($cond1, true);
            $this->log("DNS controller : Setting sesion conditions : $condition_array", LOG_DEBUG);
        }
        if ($location_id != '') {

            #If launched in context of a location then exclude all DNS from that view and show all NULL
            $cond1 = array_merge($cond1, array('Dns.location_id !=' => $location_id));
		     #$cond1 = array_merge($cond1, array('Dns.location_id' => $location_id));
            $this->Session->write('cond', serialize($cond1));
            $condition_array = print_r($cond1, true);
            $this->log("DNS controller : Setting sesion conditions : $condition_array", LOG_DEBUG);
        }

        if ($scenario_id != '') {
        
        	foreach($Odsentries as $odsentry_record)
        	{
        		array_push($odsentryIds, $odsentry_record['Odsentry']['source']);
        	}
        
        	#$cond1 = array_merge($cond1, array('Dns.id not' => $odsentryIds));
        	$cond1 = array_merge($cond1, array('NOT' => array('Dns.id' => $odsentryIds)));
        }
        
        
       

        if (isset($this->params['url']['type']) && $this->params['url']['type'] == 'singleLogic') {
            $cond1 = array_merge($cond1, array('Dns.function IS NULL'));
        }
        
        $block_id = isset($this->params['url']['block_id']) ? $this->params['url']['block_id'] : (isset($this->params['named']['block_id']) ? $this->params['named']['block_id'] : "");
        $this->set('block_id', $block_id);
		
		$dnval = isset($this->params['url']['dnval']) ? $this->params['url']['dnval'] : (isset($this->params['named']['dnval']) ? $this->params['named']['dnval'] : "");
		
		//$dndata = explode('(',$dnval);
        $this->set('dnval', $dnval);

        
        $dnsCount = $this->Dns->find('count', array('conditions' => $cond1));
        $condition_array = print_r($dnsCount, true);
        $this->log("Locations controller : count array : $condition_array", LOG_DEBUG);
        if($dnsCount > Configure::read('maxDataLimit'))
        {
        	$dnsBlockArray = $this->Dns->find('all',
        			array('conditions' => $cond1,
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
        		$cond1 = array_merge($cond1, array('Dns.id >=' => $blockStartFilter, 'Dns.id <=' => $blockEndFilter));
        	}
        	else {
        
        		$cond1 = array_merge($cond1, array('Dns.id >=' => $blockStartFilter, 'Dns.id <=' => $blockEndFilter));
        
        	}
        }
        


        $this->log("DNS controller : HERE", LOG_DEBUG);
        $this->set('title_header', 'DN List');
        $this->pageTitle = 'DN List';

        $customer = $this->Customer->find('first', array('contain' => array('Location'), 'conditions' => array('id' => $customer_id)));
		//New Change Location list dropdown
		$location_source = $this->Location->find('all', array('contain' => false,'conditions' => array('Location.customer_id' => $customer_id),'order'=>'Location.name asc'));
		
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
		        			
        endforeach;
       
	   /*
	    foreach ($customer['Location'] as $key => $value):
            $locations[$value['id']] = $value['name'];
        endforeach;
		
		*/
		
		
        $custName = $customer['Customer']['name'];
        $custId = $customer['Customer']['id'];
        $this->Session->write('Customer.Name', $custName);
        $this->Session->write('Customer.Id', $custId);
        $this->set('custId', $custId);
        $this->set('scenario_id', $scenario_id);
        $this->set('SELECTED_CNN', $custId);
        $this->set('cust_for_layout', $custName);
        $this->set('custName', $custName);
        $this->set('station_id', $station_id);
        $this->set('selected_customer', $custName);
        $this->set('locations', $locations);
        $this->log("DNS controller : HERE2", LOG_DEBUG);
        
        
        
        
        
        
        if ($customer['Customer']['type'] == 'Gate') {
        
		
        
        	$trunktitle = isset($this->params['url']['trunk_id']) ? $this->params['url']['trunk_id'] : (isset($this->params['named']['trunk_id']) ? $this->params['named']['trunk_id'] : "");
        	if ($trunktitle != '') {
        		$cond1 = array_merge($cond1, array('Trunkentry.trunk_id' => $trunktitle));
        		$this->passedArgs['trunk_id'] = $trunktitle;
        		#$trunkids= $this->Trunk->find('list',array('conditions'=>array('Trunk.name LIKE'=>'%'.$trunktitle.'%'),'fields'=>array('Trunk.id')));
        		#$this->loadModel('Trunkentry');
        		#$trunkdnsids= $this->Trunkentry->find('list',array('conditions'=>array('Trunkentry.trunk_id'=>$trunkids),'fields'=>array('Trunkentry.dn_id'), 'group'=>'Trunkentry.dn_id'));
        	}
        
        	$odsscenario_id = isset($this->params['url']['odsscenario_id']) ? $this->params['url']['odsscenario_id'] : (isset($this->params['named']['odsscenario_id']) ? $this->params['named']['odsscenario_id'] : "");
        	if ($odsscenario_id != '') {
        		$cond1 = array_merge($cond1, array('Odsentry.scenario_id' => $odsscenario_id));
        		$this->passedArgs['odsscenario_id'] = $odsscenario_id;
        		#$scenarioids= $this->Scenario->find('list',array('conditions'=>array('Scenario.name LIKE'=>'%'.$odsscenario_id.'%', 'Scenario.customer_id'=>$customer_id),'fields'=>array('Scenario.id')));
        		#$odsentrysource= $this->Odsentry->find('list',array('conditions'=>array('Odsentry.scenario_id'=>$scenarioids),'fields'=>array('Odsentry.source'), 'group'=>'Odsentry.source'));
        	
        		$Odsentries = $this->Odsentry->find('all', array('fields' => array('Odsentry.*'), 'conditions' => array('scenario_id' => $odsscenario_id), 'order' => array("dest" => 'ASC')));
        		$this->set('odsCount', count($Odsentries));
        		#$odscount = count($Odsentries);
        	}
        	
        	
        
        	$scenarioData = $this->Scenario->find('all', array(
        			'fields' => array('Scenario.id', 'Scenario.Name'),
        			'conditions' => array('Scenario.customer_id' => $customer_id)
        	));
        	$scenarioDataArray = array();
        
        	foreach ($scenarioData as $scendata) {
        		$scenarioDataArray[$scendata['Scenario']['id']] = $scendata['Scenario']['Name'];
        	}
        	$dnsArray = print_r($scenarioDataArray, true);
			
			App::import('Vendor', 'json', array('file'=>'JSON.php'));
			$json = new Services_JSON();		
			
			$scenarioDataoutput = $json->encode($scenarioDataArray);
			$this->set('scenarioDataoutput', $scenarioDataoutput);
			
        	$this->log("DNS controller : Scenario array : $dnsArray", LOG_DEBUG);
        	$this->set('scenarioData', $scenarioDataArray);
        
        	
        	/*
        	$scenarioRecords = $this->Dns->generateScenarioMap($customer_id);
        	if (!empty($scenarioRecords)) {
        		foreach ($scenarioRecords as $recordId => $records) {
        			#$recordCount++;
        			$dnsId = $records['d']['id'];
        			$scenarioId = $records['o']['scenario_id'];
        			$scenarioMap[$dnsId][$recordId] = $scenarioId;
        		}
        		#$dnsArray = print_r($scenarioMap, true);
        		#$this->log("DNS controller : Scenario array : $dnsArray", LOG_DEBUG);
        		$this->set('scenarioMap', $scenarioMap);
        	}
        	*/
        
        	//Set all Trunks
        	$TrunkData = $this->Trunk->find('all', array(
        	'fields' => array('Trunk.id', 'Trunk.name'),
        	'conditions' => array('Location.customer_id' => $customer_id)));
        			$TrunkDataArray = array();
        
        					foreach ($TrunkData as $trdata) {
        					$TrunkDataArray[$trdata['Trunk']['id']] = $trdata['Trunk']['name'];
        }
         App::import('Vendor', 'json', array('file'=>'JSON.php'));
			$json = new Services_JSON();		
			
			$TrunkDataoutput = $json->encode($TrunkDataArray);
			$this->set('TrunkDataoutput', $TrunkDataoutput);
        $this->set('TrunkDataData', $TrunkDataArray);
        
		
        
        $this->paginate = array(	
        						'limit' => 11000,
        						'fields' => array(
        						'Dns.*',
        						'Location.id',
        						'Location.name',
        						'group_concat(Distinct Trunkentry.trunk_id) as trunklist',
        						'group_concat(Distinct Odsentry.scenario_id) as scenlist'
        						),
        						'joins' => array(
        									array(
        											'table' => 'trunkentries',
        											'type' => 'LEFT OUTER',
                        							'alias' => 'Trunkentry',
                        							'conditions' => array('Trunkentry.dn_id = Dns.id')
        										)
        						),
        						'conditions' => $cond1,
        						'order' => 'Dns.id asc',
        						'group' => 'Dns.id'
        					);
										
        } else {
            //echo "<pre>";print_r($cond1);
        		//$this->paginate = array( 'fields'=>array('DISTINCT Dns.id', 'Dns.*'), 'conditions'=>$cond1,'order'=>'Location.name asc','limit' => $this->paginate['limit']);
        		$this->paginate = array('conditions' => $cond1, 'group' => 'Dns.id', 'order' => 'Location.name asc', 'limit' => '11000');
        				//$this->paginate = array('conditions'=>$cond1,'group'=>'Dns.id','order'=>'Location.name asc','limit' => $this->paginate['limit']);
        	}
			
			
			
			
			
        
        	$results = $this->paginate('Dns');
					
			
			$locationlist= array();
			foreach($results as $key => $details){
				$locationlist[$details['Location']['name']] = htmlentities($details['Location']['name']);
			}
			$this->set('locationlist',$locationlist);
			
			$functionlist= array();
			foreach($results as $key => $details){
				$functionlist[__($details['Dns']['function'],true)] = __($details['Dns']['function'],true);
			}
			$this->set('functionlist',$functionlist);
			
			foreach($results as $key => $details){				
			
			
				$results[$key]['Location']['name'] = __($details['Dns']['name'], true);
				$results[$key]['Location']['emer'] = __($details['Location']['emer'], true);
				$results[$key]['Dns']['function'] = __($details['Dns']['function'], true);
				
				$results[$key]['Location']['display'] = htmlentities($details['Location']['display']);
				$results[$key]['Location']['name'] = htmlentities($details['Location']['name']);
			}
			
			App::import('Vendor', 'json', array('file'=>'JSON.php'));
			$json = new Services_JSON();		
			
			$this->set('results', $results);
			
			$output = $json->encode($results);
			
			#echo count($this->paginate('Dns'));
        	$this->set('dns2', $results);
			$this->set('dns3', $output);
			
			               
			$this->set('cst_type',$customer['Customer']['type']);
			$this->set('cst_id',$customer_id);
			#echo "<pre>";print_r($results);
        	
        ########---------END NEW FIND------
        
        
        

       /* $this->Dns->bindModel(
                array('hasMany' => array(
                'Trunkentry' => array(
                    'className' => 'Trunkentry',
                    'fields' => 'Distinct Trunkentry.trunk_id',
                    'foreignKey' => 'dn_id'
                )
            )
                ), false
        );*/

        $this->log("DNS controller : HERE4", LOG_DEBUG);
        $emers = $this->Dns->find('all', array('fields' => 'DISTINCT emer', 'order' => 'Dns.emer asc', 'conditions' => array('Location.customer_id' => $customer_id)));
        foreach ($emers as $emer):
            $emer_list[$emer['Dns']['emer']] = $emer['Dns']['emer'];
        endforeach;
        $this->set('emer_list', $emer_list);

        /* List out all ports for this customer to show port list to choose for type CPU */
        if (isset($grouptype) && $grouptype == 'cpu') {
            $this->loadModel('Port');
            $portresult = $this->Port->find('all', array('conditions' => array('Station.customer_id' => $customer_id)));
            $this->set('ports', $portresult);
        }


        #$join_locations = array('table'=>'locations','alias'=>'Location','type'=>'INNER','foreignKey'=>false,'conditions'=>$cond);
        /* $this->paginate = array('conditions'=>$cond1,'fields'=>array('Dns.*,Location.name'),'order'=>'Location.name asc','limit' => $this->paginate['limit']);  // commented by neel */
		/*
        $this->log("DNS controller : HERE5", LOG_DEBUG);
        $results = $this->Dns->find('all', array('order' => 'Dns.id asc', 'conditions' => $cond1, 'group' => 'Dns.id', 'fields' => array('Dns.*,Location.name')));
		
		# $results = $this->Dns->find('all', array('conditions' => $cond, 'fields' => array('Dns.*,Location.name,Location.id'), 'group' => 'Dns.id', 'order' => 'Location.name asc'));

        //$results = $this->paginate('Dns');
        //pr($results);die;
        $this->set('dns', $results);
        
        */
		$dnscount = count($results);
        $this->set('dnsTotalrecord', $dnscount);
        $functions = $this->Dns->find('all', array(
            'fields' => array('DISTINCT function'),
            'conditions' => array('customer_id' => $custId)
        ));
		
		$locationresults = $this->Dns->find('first', array('order' => 'Dns.id asc', 'conditions' => $cond1, 'group' => 'Dns.id', 'fields' => array('Dns.*,Location.name')));
			$dnslocationName = $locationresults['Location']['name'];
		$this->set('dnsLocationName',$dnslocationName);
		
		
        $func_list[''] = '';
        foreach ($functions as $func):
            $localized_function = __($func['Dns']['function'], true);
            $func_list[$func['Dns']['function']] = "$localized_function";
        endforeach;
        #Add a record for filtering all non-blank
        $func_list['Used'] = __('Used', true);
        $func_list['Free'] = __('free', true);
        $this->set('func_list', $func_list);

        #For export usage
        //pr($this->params);die;
        if (isset($this->params['url']['update'])) {
            $this->set('referred_from', $this->params['url']['update']);
        } elseif (isset($this->params['url']['add'])) {
            $this->set('addabove', $this->params['url']['add']);
        } elseif (isset($this->params['url']['replace'])) {
            $this->set('replaceabove', $this->params['url']['replace']);
        }
        if (isset($this->params['url']['type']) && $this->params['url']['type'] == 'single') {
            $this->render('select_dn');
        }
		
		//print_r($this->params); die;
		
		if (isset($this->params['named']['location_id'])) {
            $this->render('selectdns_copy');
        }
		
        if (isset($this->params['url']['type']) && $this->params['url']['type'] == 'singleLogic') {
			
			/****     start   changed date 27/06/2014                  *** */
			$this->set("page",$this->params['url']['page']);
			$loc_id=$this->params['url']['loc_id'];
			$stationlocationsname = $this->Location->find('all',array('conditions'=>array('Location.id'=> $loc_id,'Location.customer_id'=>$customer_id)));
			
			//$stationlocationsname = $this->Dns->find('first',array('conditions' => $cond1, 'group' => 'Dns.id', 'order' => 'Location.name asc', 'limit' => '300'));
			
			
			$prelocation=$stationlocationsname['0']['Location']['name'];
			
			
			$this->set("prelocation",$prelocation);
			
			
				/****       end changed date 27/06/2014                  *** */
			
            $this->render('select_dn_logic');
        }
        $this->log("DNS controller : HERE6", LOG_DEBUG);
    }

    //function for filter dns selectdns

    function filterdns() {
        $this->layout = false;
        $rangeMinval = isset($this->params['url']['MinVal']) ? $this->params['url']['MinVal'] : (isset($this->params['named']['MinVal']) ? $this->params['named']['MinVal'] : "");
        $rangeMaxval = isset($this->params['url']['MaxVal']) ? $this->params['url']['MaxVal'] : (isset($this->params['named']['MaxVal']) ? $this->params['named']['MaxVal'] : "");
		$locid = isset($this->params['url']['location_id']) ? $this->params['url']['location_id'] : (isset($this->params['named']['location_id']) ? $this->params['named']['location_id'] : "");
		$scenario_id = isset($this->params['url']['scenario_id']) ? $this->params['url']['scenario_id'] : (isset($this->params['named']['scenario_id']) ? $this->params['named']['scenario_id'] : "");
		
		$customer_id = isset($this->params['url']['customer_id']) ? $this->params['url']['customer_id'] : (isset($this->params['named']['customer_id']) ? $this->params['named']['customer_id'] : "");
		
		#echo $rangeName = $customer_id.'-'.$rangeMinval.'-'.$rangeMaxval;
		
		#RLIKE \"[[:<:]]$_REQUEST[sid][[:>:]]\" "; 
		
		#$cond1 = array('Dns.rangeName' => $rangeName);

        if ($rangeMinval != '' && $rangeMaxval != '') {


            $cond1 = array('Dns.id >=' => $rangeMinval, 'Dns.id <=' => $rangeMaxval , 'Dns.rangeName LIKE'=>'%'.$customer_id.'%' );
        }
		#echo "<pre>";print_r($cond1);
		
        $results1 = $this->Dns->find('all', array('order' => 'Dns.id asc', 'conditions' => $cond1, 'fields' => array('Dns.*,Location.name')));

        $this->set('dns', $results1);
		$this->set('location_id', $locid);
		$this->set('scenario_id',$scenario_id);
		
		 $customer = $this->Customer->find('first', array('contain' => array('Location'), 'conditions' => array('id' => $customer_id)));
		 
		 if ($customer['Customer']['type'] == 'Gate') {
        
        
        	$trunktitle = isset($this->params['url']['trunk_id']) ? $this->params['url']['trunk_id'] : (isset($this->params['named']['trunk_id']) ? $this->params['named']['trunk_id'] : "");
        	if ($trunktitle != '') {
        		$cond1 = array_merge($cond1, array('Trunkentry.trunk_id' => $trunktitle));
        		$this->passedArgs['trunk_id'] = $trunktitle;
        		#$trunkids= $this->Trunk->find('list',array('conditions'=>array('Trunk.name LIKE'=>'%'.$trunktitle.'%'),'fields'=>array('Trunk.id')));
        		#$this->loadModel('Trunkentry');
        		#$trunkdnsids= $this->Trunkentry->find('list',array('conditions'=>array('Trunkentry.trunk_id'=>$trunkids),'fields'=>array('Trunkentry.dn_id'), 'group'=>'Trunkentry.dn_id'));
        	}
        
        	$odsscenario_id = isset($this->params['url']['odsscenario_id']) ? $this->params['url']['odsscenario_id'] : (isset($this->params['named']['odsscenario_id']) ? $this->params['named']['odsscenario_id'] : "");
        	if ($odsscenario_id != '') {
        		$cond1 = array_merge($cond1, array('Odsentry.scenario_id' => $odsscenario_id));
        		$this->passedArgs['odsscenario_id'] = $odsscenario_id;
        		#$scenarioids= $this->Scenario->find('list',array('conditions'=>array('Scenario.name LIKE'=>'%'.$odsscenario_id.'%', 'Scenario.customer_id'=>$customer_id),'fields'=>array('Scenario.id')));
        		#$odsentrysource= $this->Odsentry->find('list',array('conditions'=>array('Odsentry.scenario_id'=>$scenarioids),'fields'=>array('Odsentry.source'), 'group'=>'Odsentry.source'));
        	}
        
        	$scenarioData = $this->Scenario->find('all', array(
        			'fields' => array('Scenario.id', 'Scenario.Name'),
        			'conditions' => array('Scenario.customer_id' => $customer_id)
        	));
        	$scenarioDataArray = array();
        
        	foreach ($scenarioData as $scendata) {
        		$scenarioDataArray[$scendata['Scenario']['id']] = $scendata['Scenario']['Name'];
        	}
        	$dnsArray = print_r($scenarioDataArray, true);
        	$this->log("DNS controller : Scenario array : $dnsArray", LOG_DEBUG);
        	$this->set('scenarioData', $scenarioDataArray);
        
        	
        	/*
        	$scenarioRecords = $this->Dns->generateScenarioMap($customer_id);
        	if (!empty($scenarioRecords)) {
        		foreach ($scenarioRecords as $recordId => $records) {
        			#$recordCount++;
        			$dnsId = $records['d']['id'];
        			$scenarioId = $records['o']['scenario_id'];
        			$scenarioMap[$dnsId][$recordId] = $scenarioId;
        		}
        		#$dnsArray = print_r($scenarioMap, true);
        		#$this->log("DNS controller : Scenario array : $dnsArray", LOG_DEBUG);
        		$this->set('scenarioMap', $scenarioMap);
        	}
        	*/
        
        	//Set all Trunks
        	$TrunkData = $this->Trunk->find('all', array(
        	'fields' => array('Trunk.id', 'Trunk.name'),
        	'conditions' => array('Location.customer_id' => $customer_id)));
        			$TrunkDataArray = array();
        
        					foreach ($TrunkData as $trdata) {
        					$TrunkDataArray[$trdata['Trunk']['id']] = $trdata['Trunk']['name'];
        }
        
        $this->set('TrunkDataData', $TrunkDataArray);
        
        
        $this->paginate = array(
        						'limit' => 11000,
        						'fields' => array(
        						'Dns.*',
        						'Location.id',
        						'Location.name',
        						'group_concat(Distinct Trunkentry.trunk_id) as trunklist',
        						'group_concat(Distinct Odsentry.scenario_id) as scenlist'
        						),
        										'joins' => array(
        												array(
        														'table' => 'trunkentries',
        														'type' => 'LEFT OUTER',
                        'alias' => 'Trunkentry',
                        'conditions' => array('Trunkentry.dn_id = Dns.id')
        										)
        						),
        												'conditions' => $cond1,
        												'order' => 'Dns.id asc',
        												'group' => 'Dns.id'
        								);
										
										
        } else {
        
        
        		//$this->paginate = array( 'fields'=>array('DISTINCT Dns.id', 'Dns.*'), 'conditions'=>$cond1,'order'=>'Location.name asc','limit' => $this->paginate['limit']);
        		#$this->paginate = array('conditions' => $cond1, 'group' => 'Dns.id', 'order' => 'Location.name asc', 'limit' => '300');
        				$this->paginate = array('conditions'=>$cond1,'group'=>'Dns.id','order'=>'Location.name asc','limit' => $this->paginate['limit']);
        	}
        
        	$results = $this->paginate('Dns');
			#echo count($this->paginate('Dns'));
        	$this->set('dns2', $results);
		$this->set('customers',$customer);
		$dnscount = count($results);
        $this->set('dnsTotalrecord', $dnscount);
    }

    //function for export station data in csv format.
    function export() {
        $this->layout = "";

        $conds = unserialize($this->Session->read('cond'));
		
		$conds2 = unserialize($this->Session->read('cond2'));
					
		$scenarioData = $this->Scenario->find('all', array(
        			'fields' => array('Scenario.id', 'Scenario.Name'),
        			'conditions' => $conds2
        	));
			
			
			
        	$scenarioDataArray = array();
        
        	foreach ($scenarioData as $scendata) {
        		$scenarioDataArray[$scendata['Scenario']['id']] = $scendata['Scenario']['Name'];
        	}
        	$dnsArray = print_r($scenarioDataArray, true);
        	$this->log("DNS controller : Scenario array : $dnsArray", LOG_DEBUG);
        	$this->set('scenarioData', $scenarioDataArray);
		
		
        $filename = "export_dns_" . date("Y.m.d") . ".csv";
        $csv_file = fopen('php://output', 'w');
        header('Content-type: application/csv');
        header('Content-Disposition: attachment; filename="' . $filename . '"');
        $this->loadModel('Dns');
       # $results = $this->Dns->find('all', array('fields' => array('Dns.id', 'Location.name', 'Dns.emer', 'Dns.function', 'Dns.display','Odsentry.scenario_id'), 'order' => 'Dns.id ASC','group'=>'Dns.id', 'conditions' => $conds));
		
		$results = $this->Dns->find('all',array(
               
                'fields' => array(
                    'Dns.id',
					'Dns.emer',
					'Dns.function',
					'Dns.display',
                    'Location.name',
					'Trunkentry.trunk_id',
					'Odsentry.scenario_id'
                    
                ),
                'joins' => array(
                    array(
                        'table' => 'trunkentries',
                        'type' => 'LEFT OUTER',
                        'alias' => 'Trunkentry',
                        'conditions' => array('Trunkentry.dn_id = Dns.id')
                    )
                ),
                 'order' => 'Dns.id asc',
				 'group' => 'Dns.id',
				 'conditions' => $conds
           )
		    );
			
						
		
        $header_row = array(__("S.No.", true),  __("ID", true),  __("Location", true),  __("Emergency", true),  __("Function", true),  __("DISPLAYNAME", true),  __("Trunk", true),  __("Odesentry", true));
        fputcsv($csv_file, $header_row, ';', '"');

        // Each iteration of this while loop will be a row in your .csv file where each field corresponds to the heading of the column
        $i = 1;
        foreach ($results as $result) {
			
			
			$scenarioId = $result['Odsentry']['scenario_id'];
			$linkName = $scenarioDataArray[$scenarioId];

            // Array indexes correspond to the field names in your db table(s)
            $row = array(
                $result['Dns']['Sno'] = $i,
                $result['Dns']['id'],
                $result['Location']['name'],
                $result['Dns']['emer'],
                __($result['Dns']['function'], true),
                $result['Dns']['display'],
				$result['Trunkentry']['trunk_id'],
				$linkName
            );
            $i++;
            fputcsv($csv_file, $row, ';', '"');
        }

        fclose($csv_file);
        exit();
    }

    // Update Location id in dns table using Jquery
    function update_location() {
        $this->layout = false;

        $serializeddata = isset($this->params['form']['serialized']) ? $this->params['form']['serialized'] : (isset($this->params['named']['serialized']) ? $this->params['named']['serialized'] : "");

        $customer_id = isset($this->params['form']['customer_id']) ? $this->params['form']['customer_id'] : (isset($this->params['named']['customer_id']) ? $this->params['named']['customer_id'] : "");

        $TotalRecords = split("&", $serializeddata);


        $updated = 0;
        $responsearray = '';
        if (!empty($TotalRecords)) {


            foreach ($TotalRecords as $EachDnsDatalist) {

                $EachOdsData = split("=", $EachDnsDatalist);

                //echo "<pre>";print_r($EachOdsData);

                if (!empty($EachOdsData) && count($EachOdsData) == 2) {

                    $dns_id = $EachOdsData[0];
                    $location_id = $EachOdsData[1];


                    if ($dns_id != '') {

                        if ($updatelocation = $this->Dns->updateAll(array('Dns.location_id' => $location_id), array('Dns.id' => $dns_id))) {
                            //$updatestatus=$this->Dns->updateAll(array('Dns.status' =>4),array('Dns.id' => $dns_id1));
                            $d = explode("*", $dns_id);
                            $dns_id1 = $d[0];
                            $updatestatus = $this->Dns->updateAll(array('Dns.status' => 4), array('Dns.id' => $dns_id1));


                            $updated++;


                            // Find DNS status and return in form of json to update the div
                            $currentstatus = $this->Dns->find('first', array('conditions' => array('Dns.id' => $dns_id), 'fields' => array('Dns.status')));

                            $dnsStatus = Configure::read('dnsStatus');

                            if ($currentstatus['Dns']['status'])
                                $status = $dnsStatus[$currentstatus['Dns']['status']];
                            else
                                $status = '';

                            $responsearray .=$dns_id . '**' . $status . '@#';
                        }
                    }
                }
            }
        }


        if ($updated > 0) {
            echo substr($responsearray, 0, strlen($responsearray) - 2);
        } else {
            echo "fail";
        }

        exit();
    }

    /*
     * **************************************************
      Function Name   : create_location
      Description     : This function is use for Update Location in Dns.
      Parameter       : dns id
      Return       	  : NA
      Created Date    : 15/01/2014.
     * **************************************************
     */

    function create_location($dns_id = null) {

        $this->layout = 'ajax';
        //echo $execution_id;
        //Configure::write("debug",2);

        $dns_id = isset($this->params['url']['dns_id']) ? $this->params['url']['dns_id'] : (isset($this->params['named']['dns_id']) ? $this->params['named']['dns_id'] : "");
        $customer_id = isset($this->params['url']['customer_id']) ? $this->params['url']['customer_id'] : (isset($this->params['named']['customer_id']) ? $this->params['named']['customer_id'] : "");

        $location_id = isset($this->params['url']['location_id']) ? $this->params['url']['location_id'] : (isset($this->params['named']['location_id']) ? $this->params['named']['location_id'] : "");


        $cond = array('Location.customer_id' => $customer_id);
        $results = $this->Dns->find('all', array('conditions' => $cond, 'fields' => array('Dns.*,Location.name'), 'order' => 'Location.name asc'));

        //$results = $this->paginate('Dns');
        //echo "<pre>";print_r($results);die;
        $this->set('dns', $results);


        #$odsEntryList_array=print_r($odsEntryList, true);
        #$this->log("Scenario controller : Setting sesion conditions : $odsEntryList_array", LOG_DEBUG);
        $customer = $this->Customer->find('first', array('contain' => array('Location'), 'conditions' => array('id' => $customer_id)));

        foreach ($customer['Location'] as $key => $value):
            $locations[$value['id']] = $value['name'];
        endforeach;
        #$location_array=print_r($locations, true);
        #$this->log("Mediatrix controller : Location Details : $location_array", LOG_DEBUG);

        $this->set('locations', $locations);
        $this->set('dns_id', $dns_id);
        $this->set('customer_id', $customer_id);
        $this->set('location_id', $location_id);
    }
	
	function setDnsFree(){
		
		$station_id = isset($this->params['url']['station_id']) ? $this->params['url']['station_id'] : (isset($this->params['named']['station_id']) ? $this->params['named']['station_id'] : "");
		
		   
			$this->Station->deleteAll(array('Station.id' => $station_id), false);
			$fl=$this->Feature->deleteAll(array('Feature.id like' => '%@'.$station_id . '%'));
				
			$fl=$this->Stationkey->deleteAll(array('Stationkey.id like' => '%@'.$station_id));
			
		
  	$this->Dns->deleteActiveDn($station_id);
	$this->Session->setFlash('<div class="notification first" style="width: 100%" >		
			<div class="ok"><div class="message">'.__('Station Added Cancle',true).'</div></div></div>');
			
			exit;	
		
	}
	

}
?>

