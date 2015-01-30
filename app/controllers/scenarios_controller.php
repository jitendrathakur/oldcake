<?php

#-----------------------------------------------------------------#
# $Rev:: 22            $:  Revision of last commit                #
#-----------------------------------------------------------------#

/**
 * Scenarios Controller
 *
 * file: /app/controllers/Scenarioss_controller.php
 */
#var $header_string = 'Scenarios';
class ScenariosController extends AppController {

    // good practice to include the name variable


    var $uses = array('Scenario', 'Execution', 'Logs', 'Odsentry','Transentry', 'Transaction');
    var $name = 'Scenarios';
    var $paginate = array('Paginate' => 15, 'page' => 1);
    var $components = array('RequestHandler', 'AlgInterface');
   
    #var $paginate = array('Paginate' => 15, 'page' => 1, 'order' => array('Customer.name' => 'asc'));
    // load any helpers used in the views
    var $helpers = array('Html', 'Form', 'Javascript');

    function beforeFilter() {
        $this->disableCache();
        $this->log('SCENARIOS CONTROLLER : BEFOREFILTER IN SCENARIOS CONTROLLER', LOG_DEBUG);
        $this->Session->write('sel_customer', '');

        parent::beforeFilter();

        if (!$this->Session->read('SELECTED_CUSTOMER')) {
            $this->layout = 'ajax';
            $this->cakeError('sessionExpired');
        }

        $this->Odsentry->SetScenarioStatus();
    }

    /**
     * default action
     *
     */
    function index() {
        $this->pageTitle = 'Scenario List';
        $this->log('SCENARIOS CONTROLLER : START INDEX ', LOG_DEBUG);

        $this->paginate['Paginate'] = $this->AutoPaginate->setPaginate();

        $customer_id = isset($this->params['url']['customer_id']) ? $this->params['url']['customer_id'] : (isset($this->params['named']['customer_id']) ? $this->params['named']['customer_id'] : "");

        $success_flag = isset($this->params['url']['etype']) ? $this->params['url']['etype'] : (isset($this->params['named']['etype']) ? $this->params['named']['etype'] : "");
        
        if (isset ($_SESSION['success']))
        	$this->set('success', $_SESSION['success']);
        	$_SESSION['success'] = '';
        	
        if (isset ($_SESSION['error']))
        	$this->set('error', $_SESSION['error']);
        	$_SESSION['error'] = '';
        #die();

        if (isset($_POST['customer_id']) && $_POST['customer_id']) {
            $customer_id = $_POST['customer_id'];
            $this->passedArgs['customer_id'] = $customer_id;
        }

        if ($customer_id == '') {

            $sel_location = $_POST['location'];
            $this->Session->write('sel_location', $sel_location);

            $this->log('SCENARIOS CONTROLLER : VALID CUSTOMER ID NOT SET', LOG_DEBUG);
            $this->redirect('/customers');
            exit();
        }

        #if($this->Session->read('APPNAME') != 'Gate')
        #{
        #	$this->log('SCENARIOS CONTROLLER : PHONE USER TRIED TO ACCESS GATE PAGE APP => ' . ':' . $this->Session->read('APPNAME') . ':', LOG_DEBUG);
        #	$this->layout='ajax';
        #	$this->cakeError('accessDenied'); 
        #$this->redirect('/customers');
        #	exit();
        #}

        /*         * ********for case of external users******* */
        if ($this->Session->read('SELECTED_CUSTOMER') != Configure::read('access_id')) {

            #If The user is an external..

            $id = $this->Session->read('SELECTED_CUSTOMER');
            $cnt = count($this->_Filter);

            if (!$this->Customer->validCustomer($id, $customer_id)) {
                #print_r("not valid");die();
                $this->log('SCENARIOS CONTROLLER : NOT A VALID CUSTOMER FOR SCENARIOS PAGE', LOG_DEBUG);
                $this->redirect('/customers');
                exit();
            }
            #print_r("valid checking $id $number");die();
        }
        
                /*         * ********************END************************ */
        
        
        /**********Check if user can access ODS********/
        $custDetails = $this->Customer->find('first', array('conditions'=>array('Customer.id'=>$customer_id)));
        	
        
        /* ????? Temporary to allow hans to enable
         * 
         if($custDetails['Customer']['onDemand'] != 1){
        
        	$this->log('SCENARIOS CONTROLLER : NOT A VALID CUSTOMER FOR SCENARIOS PAGE', LOG_DEBUG);
        	$this->redirect('/customers');
        	exit();
        }
		*/        
        /**********************END*************************/
        
        /*         * these for getting the current customer name* */

        #User for left hand Menu navigation.
        $this->set('SELECTED_CNN', $customer_id);
        $this->set('SELECTED_CUSTOMER_NAME', $customer_id);
        /* CBM Added for right hand section */
        $customerInfo = $this->Customer->findById($customer_id);
        if (isset($customerInfo['Customer']['name'])) {
            $this->set('selected_customer', $customerInfo['Customer']['name']);
        } else {
            $this->set('selected_customer', 'UNDEF');
        }


        /*         * end for getting the current customer name* */

        $cond = array('Scenario.customer_id' => $customer_id);

        $name = isset($this->params['url']['name']) ? $this->params['url']['name'] : (isset($this->params['named']['name']) ? $this->params['named']['name'] : "");
        if ($name != '') {
            $cond = array_merge($cond, array('Scenario.name LIKE' => '%' . $name . '%'));
            $this->passedArgs['name'] = $name;
        }

        $status = isset($this->params['url']['status']) ? $this->params['url']['status'] : (isset($this->params['named']['status']) ? $this->params['named']['status'] : "");
        if ($status != '') {
            $cond = array_merge($cond, array('Scenario.state' => $status));
            $this->passedArgs['status'] = $status;
        }

		// Make sure translation has entered for create scenario button		
		$selectedLanguage = $_SESSION['Config']['language'];
		
		$countEntryForButton = $this->Transentry->find('count',array('conditions'=>array('Transentry.language LIKE'=>"%".$selectedLanguage."%",'Tag.tag'=>'createScenario_desc')));

        $this->set('tooltipisonoroff',$countEntryForButton);

        $this->paginate = array('conditions' => $cond, 'limit' => $this->paginate['limit'], 'order' => array('Scenario.status desc'));
        $this->set('title_header', __('Swisscom Extranet Corporate Business - Voiphone Selfcare', true));
        $this->Session->write('Customer.Name', 'UNDEF');
        $this->set('cust_for_layout', 'UNDEFINED');
        $this->set('scenarios', $this->paginate('Scenario'));
        
        
        
        if ($success_flag == 'success') {
            $this->set('success', 'script executed successfully');
        } elseif ($success_flag == 'deleted') {
            $this->set('success', 'schedule deleted successfully');
        } elseif ($success_flag == 'sc_deleted') {
            $this->set('success', 'scenario deleted successfully');
        } elseif ($success_flag == 'updated') {
            $this->set('success', 'Saved successfully');
        } elseif ($success_flag == 'error') {
            $this->set('error', 'ERROR');
        }
        $states = $this->Scenario->find('all', array('fields' => array('DISTINCT Scenario.state')));
        $stateList[''] = '';
        foreach ($states as $state):
            $localized_state = __($state['Scenario']['state'], true);
            $stateList[$state['Scenario']['status']] = $localized_state;
        endforeach;
        $this->set('stateList', $stateList);

        $this->Session->write('cond', serialize($cond));
        $condition_array = print_r($cond, true);
        $this->log("Scenario controller : Setting sesion conditions : $condition_array", LOG_DEBUG);

        $scenarioCounts = $this->Scenario->find('all',
        
        		array(
        				'fields' => array(
        				'Scenario.id',
        				'count(Odsentry.id)'),
        				'group' => 'Scenario.id',
        				'joins' => array(
        						array(
        								'table' => 'odsentries',
        								'type' => 'LEFT',
        								'alias' => 'Odsentry',
        								'conditions' => array('Scenario.id = Odsentry.scenario_id')
        						)
        				),
        				'conditions' => array('Scenario.customer_id' => $customer_id))
        );
        
        $scenarioIds = array();
        foreach ($scenarioCounts as $scenarioCount)
        {
        	$scenarioCountMap[$scenarioCount['Scenario']['id']] = $scenarioCount[0]['count(`Odsentry`.`id`)'];
        	array_push($scenarioIds, $scenarioCount['Scenario']['id']);
        }
        #$result_array=print_r($scenarioCountMap, true);
        #$this->log("Scenario controller : Scenario COunts : $result_array", LOG_DEBUG);
        
        #Log information.
        
        $cond = array( 'Log.customer_id' => $odsEntryList[0]['Scenario']['customer_id']);
        
        $lastLogEntries = $this->Log->find('all',
        
        		array(
        				'fields' => array(
        				'Log.affected_obj',
        				'Log.created',
        				'Log.log_entry'),
        				'group' => 'Log.affected_obj',
        				'order' => 'Log.id desc',
        				'conditions' => array('Log.affected_obj' => $scenarioIds, 'Log.log_entry like' => 'Scenario Applied : Schedule%'))
        );
        
        foreach ($lastLogEntries as $lastLogEntry)
        {
        	
        	preg_match("/\s*Execution started \: (\w+)\s*/", $lastLogEntry['Log']['log_entry'], $matches);
        	if ($matches[0]) {
        		$logDetail = __($matches[1], true);
        		$execDate =  date('d.m.Y',strtotime($lastLogEntry['Log']['created']));
        		
        		$this->log('SCENARIO CONTROLLER ' . 'logmatch: ' .$lastLogEntry['Log']['affected_obj'] . ' '  . $logDetail , LOG_DEBUG);
        	}
        	else
        	{
        		$this->log('SCENARIO CONTROLLER ' . 'no match: ' .$lastLogEntry['Log']['log_entry']. ' '  . $logDetail , LOG_DEBUG);
        	}
        	
        	$loginfo[$lastLogEntry['Log']['affected_obj']] = $logDetail  . ':' . $execDate;
        }
        $result_array=print_r($lastLogEntries, true);
        $this->log("Scenario controller : Last Logs : $result_array", LOG_DEBUG);
        
        
        $this->set('loginfo', $loginfo);
        
        $this->set('scenarioCount', $scenarioCountMap);
        if ($this->RequestHandler->isAjax()) {
            $this->layout = 'ajax';
            Configure::write('debug', 0);
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
    function edit($slug = null) {
		
		
		
        extract($_POST);
		#success handling
        if (isset ($_SESSION['success']))
        	$this->set('success', $_SESSION['success']);
        $_SESSION['success'] = '';
         
        if (isset ($_SESSION['error']))
        	$this->set('error', $_SESSION['error']);
        $_SESSION['error'] = '';
        
		
       $scenario_id = isset($this->params['url']['scenario_id']) ? $this->params['url']['scenario_id'] : (isset($this->params['named']['scenario_id']) ? $this->params['named']['scenario_id'] : "");
       $subsection = isset($this->params['url']['subsection']) ? $this->params['url']['subsection'] : (isset($this->params['named']['subsection']) ? $this->params['named']['subsection'] : "");
       $mode = isset($this->params['url']['mode']) ? $this->params['url']['mode'] : (isset($this->params['named']['mode']) ? $this->params['named']['mode'] : "");
       $createdScenario = isset($this->params['url']['createdScenario']) ? $this->params['url']['createdScenario'] : (isset($this->params['named']['createdScenario']) ? $this->params['named']['createdScenario'] : "");
       $this->set('createdScenario', $createdScenario);
       
       $this->set('subsection', $subsection);
		
        if ($scenario_id == 'createzzz') {
            $customer_id = isset($this->params['url']['customer_id']) ? $this->params['url']['customer_id'] : (isset($this->params['named']['customer_id']) ? $this->params['named']['customer_id'] : "");


            $scenCount = $this->Scenario->find('count', array('conditions' => array('customer_id' => $customer_id)));
            $scenarioName = 'scenario' . $scenCount;
			
			
            
            
            $scenario_number = $this->setScenarioNumber('');
            	
            
            			
            $insert = array(
                'Scenario' => array(
                    'id' => '',
                    'Name' => $scenarioName,
                    'created' => date('Y-m-d H:i:s'),
                    'status' => 1,
                    'customer_id' => $customer_id,
                    'ActScript' => 'unset',
                    'DeActScript' => 'unset',
                    'modified' => '0000-00-00 00:00:00',
                	'number' => $scenario_number
                )
            );

            $this->Scenario->create();
            #$result_array=print_r($result, true);
            #$this->log("Scenario controller : Creating scenario : $result_array", LOG_DEBUG);

            $result = $this->Scenario->save($insert, false);
            $result_array = print_r($result, true);
            $this->log("Scenario controller : Creating scenario : $result_array", LOG_DEBUG);

            $scenario_id = $this->Scenario->id;
            $log = 'Scenario Created';
            $insert = array(
                'Log' => array(
                    'affected_obj' => $scenario_id,
                    'affected_obj_name' => $scenarioName,
                    'affected_obj_type' => 'Scenario',
                    'log_entry' => $log,
                    'created' => date('Y-m-d H:i:s'),
                    'status' => 1,
                    'customer_id' => $odsEntryList[0]['Scenario']['customer_id'],
                    'bsk' => $this->Session->read('BSK'),
                    'user' => $this->Session->read('ACCOUNTNAME'),
                    'app_type' => 'Gate',
                    'modified' => '0000-00-00 00:00:00',
                    'modification_status' => 1,
                    'modification_response' => ''
                )
            );

            $this->Log->create();
            $this->Log->save($insert, false);

            $this->redirect('/scenarios/edit/scenario_id:' . $scenario_id);
        }

        if ($scenario_id == 'create') {
            $customer_id = isset($this->params['url']['customer_id']) ? $this->params['url']['customer_id'] : (isset($this->params['named']['customer_id']) ? $this->params['named']['customer_id'] : "");
            $this->set('SELECTED_CUSTOMER', $customer_id);
            $this->set('SELECTED_CNN', $customer_id);
            $this->set('customer_id', $customer_id);
            $this->log("Scenarios controller : create", LOG_DEBUG);
        } else {




            $this->data = $this->Execution->find('first', array('conditions' => array('id' => $execution_id)));

            $odsEntryDestStatus = $this->Odsentry->find('all', array('fields' => 'Odsentry.*','conditions' => array('scenario_id' => $scenario_id, 'TRIM(dest)' => NULL)));
            $odsEntryList = $this->Odsentry->find('all', array('fields' => array('Odsentry.*','Scenario.status'),'conditions' => array('scenario_id' => $scenario_id)));

            
            $this->set('odsCount', count($odsEntryDestStatus));
            $this->set('odsTotCount', count($odsEntryList));
            
            #----Now Update Scenario status based on Odsentries
            if (count($odsEntryDestStatus) > 0) {
                $setStatus = 1;
				
                /*$transId = time();
                
                $fullTransaction = '<odsUpdate><object action="add" name="numbers"><message station="" key="00">';
                		
                foreach ($odsEntryDestStatus as $odsEntryDestStat)
                {
                		$fullTransaction .= '<var value="' . $odsEntryDestStat['Odsentry']['source'] . '" name="number"/>';
                }
                $fullTransaction .= '</message></object></algRequest>';
                
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
                
                #Will Set the Scenario state and create a log entry
                $log = 'Scenario Updated : ADD-Numbers';

                $insert = array(
                    'Log' => array(
                        'affected_obj' => $scenario_id,
                        'affected_obj_name' => $odsEntryList[0]['Scenario']['Name'],
                        'affected_obj_type' => 'Scenario',
                        'log_entry' => $log,
                        'created' => date('Y-m-d H:i:s'),
                        'status' => 1,
                        'customer_id' => $odsEntryList[0]['Scenario']['customer_id'],
                        'bsk' => $this->Session->read('BSK'),
                        'user' => $this->Session->read('ACCOUNTNAME'),
                        'app_type' => 'Phone',
                        'modified' => '0000-00-00 00:00:00',
                        'modification_status' => 1,
                        'modification_response' => '',
                    	'transaction_id' => $transId
                    )
                );

                $this->Log->create();
                $this->Log->save($insert, false);
                
                */
            } elseif ($odsEntryList[0]['Scenario']['status'] == 1) {
                $setStatus = 2;
            }
            if (isset($setStatus)) {

                #station status update
                $update['Scenario']['status'] = $setStatus;
                $update['Scenario']['id'] = $scenario_id;
                $this->Scenario->save($update, false, array('id', 'status'));
            }

            $odsEntryList = $this->Odsentry->find('all', array('fields' => array('Odsentry.*','Scenario.status'),'conditions' => array('scenario_id' => $scenario_id)));

            $orderbyfield = 'source';
            $orderbyorder = 'ASC';
            if (!empty($odsEntryList)) {
                $Scenario_Status = $odsEntryList[0]['Scenario']['status'];
                if ($Scenario_Status == 1) {
                    $orderbyfield = 'dest';
                    $orderbyorder = 'ASC';
                }
            }


            #$odsEntryList_array=print_r($odsEntryList, true);
            #$this->log("Scenario controller : Setting sesion conditions : $odsEntryList_array", LOG_DEBUG);
            $this->set('odsEntryList', $odsEntryList);

            $scenarioDetails = $this->Scenario->find('all', array('conditions' => array('Scenario.id' => $scenario_id)));
            
            
            
            /**********for case of internal/external users********/
            #????Quite late in the controller. can bringforward
            if ($this->Session->read('SELECTED_CUSTOMER') != Configure :: read('access_id')) {
            
            	$id = $this->Session->read('SELECTED_CUSTOMER');
            
            	if (!$this->Customer->validCustomer($id,$scenarioDetails[0]['Scenario']['customer_id'])) {
            		$this->log("SCenarios controller : Edit Function: Invalid customer:" . $id . ':' . $scenarioDetails[0]['Scenario']['customer_id'] , LOG_DEBUG);
            		$this->redirect('/customers');
            		exit ();
            	}
            
            }
            /**********************END*************************/
            
            
            
            
            
            
            $odsEntryList_array = print_r($scenarioDetails, true);
            $this->log("Scenario controller : scenarioDetail: $odsEntryList_array", LOG_DEBUG);
            $this->set('scenarioDetails', $scenarioDetails);
            $this->set('SELECTED_CUSTOMER', $scenarioDetails[0]['Scenario']['customer_id']);
            $this->set('SELECTED_CNN', $scenarioDetails[0]['Scenario']['customer_id']);
            $this->set('scenario_id', $scenario_id);
            #$this->set('scenario_state', $scenario_status);

            $this->data = $this->Execution->find('first', array('conditions' => array('id' => $execution_id)));


            $cond = array('scenario_id' => $scenario_id);
            
            
            
            /*CHECK FOR LARGE DATASETS */
            
            $block_id = isset($this->params['url']['block_id']) ? $this->params['url']['block_id'] : (isset($this->params['named']['block_id']) ? $this->params['named']['block_id'] : "");
            $this->set('block_id', $block_id);
            
            #if(isset($block_id))
            	#use selected block
            
             
            
           $odsentryCount = $this->Odsentry->find('count', array('conditions' => $cond));
           $condition_array = print_r($dnsCount, true);
           $this->log("Scenario controller : count array : $condition_array", LOG_DEBUG);
           if($odsentryCount > Configure::read('maxDataLimit'))
           {
            	$dnsBlockArray = $this->Odsentry->find('all',
            	array('conditions' => $cond,
            		'fields' => array(
            		'SUBSTRING(Odsentry.source,1,6) as sub',
            		'count(*)'
            		),
            		'group' => 'sub',
            		'order' => 'sub asc'
            		)
           	 );
            	
            
            
	            $condition_array = print_r($dnsBlockArray, true);
	            $this->log("SCenarios controller : block array : $condition_array", LOG_DEBUG);
	            
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
	            		$cond = array_merge($cond, array('Odsentry.source >=' => $blockStartFilter, 'Odsentry.source <=' => $blockEndFilter));
	            }
	            else {
	            
	            		$cond = array_merge($cond, array('Odsentry.source >=' => $blockStartFilter, 'Odsentry.source <=' => $blockEndFilter));
	            
	            }
            }
            
            
            /* END LARGE DATASET */
            

            $rangeMinval = isset($data['rangeMin']['minval']) ? $data['rangeMin']['minval'] : "";
            $rangeMaxval = isset($data['rangeMax']['maxval']) ? $data['rangeMax']['maxval'] : "";

            if ($rangeMinval != '' && $rangeMaxval != '') {
                $cond = array_merge($cond, array('Odsentry.source >=' => $rangeMinval, 'Odsentry.source <=' => $rangeMaxval));
                //$cond = array_merge($cond,array('Scenario.source <'=>$rangeMaxval));
                $this->Session->write('cond', serialize($cond));
                $condition_array = print_r($cond, true);
                $this->log("Scenario controller : Setting sesion conditions : $condition_array", LOG_DEBUG);
                #$this->set('station_id',$station_id);
                #Set below for sort/filter problem where filter arguments not passed to sort
                $this->passedArgs['rangeMin'] = $rangeMinval;
                $this->passedArgs['rangeMax'] = $rangeMaxval;
                $this->set('advancedFlag', '1');
            }
            $this->paginate = array('conditions' => $cond, 'limit' => $this->paginate['limit']);
            $odsEntryList = $this->Odsentry->find('all', array('fields' => array('Odsentry.*','Scenario.status'),'conditions' => $cond, 'order' => array("Odsentry." . $orderbyfield . " " . $orderbyorder . "")));
			
			$valid = __('Valid',true);
			$validd = utf8_encode($valid);
            $invalid = __('Invalid',true);
            $invalidd = utf8_encode($invalid);
			foreach($odsEntryList as $key => $list){
			
				$odsEntryList[$key]['Odsentry']['config'] = __($list['Odsentry']['config'],true);
				$odsEntryList[$key]['Odsentry']['dest1'] = __($list['Odsentry']['dest'],true) ? $validd : $invalidd;
				
			}
			
			$odscount = count($odsEntryList);
			$this->set('odsTotalrecord', $odscount);
			
			App::import('Vendor', 'json', array('file'=>'JSON.php'));
			$json = new Services_JSON();
			
            $this->set('odsEntryList', $odsEntryList);
			
			$output = $json->encode($odsEntryList);

			//echo $json->utf82utf16('Zürich 01');
			//print_r($output); die;
			
            $this->set('jsonodsEntryList', $output);
			
            $this->set('SELECTED_CUSTOMER', $scenarioDetails[0]['Scenario']['customer_id']);
            $this->set('scenario_id', $scenario_id);
            $this->set('rangeMinval', $rangeMinval);
            $this->set('rangeMaxval', $rangeMaxval);
            $this->set('scenario_state', $scenario_status);
            

            #Log data for hsitory
            #Now send logs
           // $cond = array('Log.affected_obj' => $scenario_id, 'Log.customer_id' => $odsEntryList[0]['Scenario']['customer_id']); changed because this  show only scenario log prevent to show all log
			
			$cond = array( 'Log.affected_obj' => $scenario_id);
            #$cond = array_merge($cond,array('Log.affected_obj'=>$scenario_id));
            #$cond = array_merge($cond,array('Log.customer_id'=>$customer_id));
            $this->paginate['Paginate'] = $this->AutoPaginate->setPaginate();
            #$this->paginate['limit'] = 5;
            $this->paginate = array('limit' => $this->paginate['limit'], 'conditions' => $cond, 'order' => 'Log.id desc');
            $loginfo = $this->paginate('Log');
            $this->set('loginfo', $loginfo);

            #Get Customer Name
            $customerInfo = $this->Customer->findById($scenarioDetails[0]['Scenario']['customer_id']);
            if (isset($customerInfo['Customer']['name'])) {
                $this->set('selected_customer', $customerInfo['Customer']['name']);
            } else {
                $this->set('selected_customer', 'UNDEF');
            }
        }
        
        
        if($mode == 'operate')
        {
        	$this->pageTitle = 'Scenario Operate';
        	$this->render('/scenarios/operate');
        	
        }
        else {
        	$this->pageTitle = 'Scenario Edit';
        }
        
        $this->set('slug',$scenario_id);
    }
    
     function tablereload($slug = null) {
		
		
		
        extract($_POST);
	
		
       $scenario_id = isset($this->params['url']['scenario_id']) ? $this->params['url']['scenario_id'] : (isset($this->params['named']['scenario_id']) ? $this->params['named']['scenario_id'] : "");
       $subsection = isset($this->params['url']['subsection']) ? $this->params['url']['subsection'] : (isset($this->params['named']['subsection']) ? $this->params['named']['subsection'] : "");
       $mode = isset($this->params['url']['mode']) ? $this->params['url']['mode'] : (isset($this->params['named']['mode']) ? $this->params['named']['mode'] : "");
       $createdScenario = isset($this->params['url']['createdScenario']) ? $this->params['url']['createdScenario'] : (isset($this->params['named']['createdScenario']) ? $this->params['named']['createdScenario'] : "");
       $this->set('createdScenario', $createdScenario);
       
       $this->set('subsection', $subsection);


            $this->data = $this->Execution->find('first', array('conditions' => array('id' => $execution_id)));

            $odsEntryDestStatus = $this->Odsentry->find('all', array('fields' => 'Odsentry.*','conditions' => array('scenario_id' => $scenario_id, 'TRIM(dest)' => NULL)));
            $odsEntryList = $this->Odsentry->find('all', array('fields' => array('Odsentry.*','Scenario.status'),'conditions' => array('scenario_id' => $scenario_id)));

            
            $this->set('odsCount', count($odsEntryDestStatus));
            $this->set('odsTotCount', count($odsEntryList));
            
            #----Now Update Scenario status based on Odsentries
            if (count($odsEntryDestStatus) > 0) {
                $setStatus = 1;
				
 
            } elseif ($odsEntryList[0]['Scenario']['status'] == 1) {
                $setStatus = 2;
            }
            if (isset($setStatus)) {

                #station status update
                $update['Scenario']['status'] = $setStatus;
                $update['Scenario']['id'] = $scenario_id;
                $this->Scenario->save($update, false, array('id', 'status'));
            }

            $odsEntryList = $this->Odsentry->find('all', array('fields' => array('Odsentry.*','Scenario.status'),'conditions' => array('scenario_id' => $scenario_id)));

            $orderbyfield = 'source';
            $orderbyorder = 'ASC';
            if (!empty($odsEntryList)) {
                $Scenario_Status = $odsEntryList[0]['Scenario']['status'];
                if ($Scenario_Status == 1) {
                    $orderbyfield = 'dest';
                    $orderbyorder = 'ASC';
                }
            }


            #$odsEntryList_array=print_r($odsEntryList, true);
            #$this->log("Scenario controller : Setting sesion conditions : $odsEntryList_array", LOG_DEBUG);
            $this->set('odsEntryList', $odsEntryList);

            $scenarioDetails = $this->Scenario->find('all', array('conditions' => array('Scenario.id' => $scenario_id)));
            
                    
            $odsEntryList_array = print_r($scenarioDetails, true);
            $this->log("Scenario controller : scenarioDetail: $odsEntryList_array", LOG_DEBUG);
            $this->set('scenarioDetails', $scenarioDetails);
            $this->set('SELECTED_CUSTOMER', $scenarioDetails[0]['Scenario']['customer_id']);
            $this->set('SELECTED_CNN', $scenarioDetails[0]['Scenario']['customer_id']);
            $this->set('scenario_id', $scenario_id);
            #$this->set('scenario_state', $scenario_status);

            $this->data = $this->Execution->find('first', array('conditions' => array('id' => $execution_id)));


            $cond = array('scenario_id' => $scenario_id);
            
            
            
            /*CHECK FOR LARGE DATASETS */
            
            $block_id = isset($this->params['url']['block_id']) ? $this->params['url']['block_id'] : (isset($this->params['named']['block_id']) ? $this->params['named']['block_id'] : "");
            $this->set('block_id', $block_id);
            
            #if(isset($block_id))
            	#use selected block
                         
            
           $odsentryCount = $this->Odsentry->find('count', array('conditions' => $cond));
           $condition_array = print_r($dnsCount, true);
           $this->log("Scenario controller : count array : $condition_array", LOG_DEBUG);
           if($odsentryCount > Configure::read('maxDataLimit'))
           {
            	$dnsBlockArray = $this->Odsentry->find('all',
            	array('conditions' => $cond,
            		'fields' => array(
            		'SUBSTRING(Odsentry.source,1,6) as sub',
            		'count(*)'
            		),
            		'group' => 'sub',
            		'order' => 'sub asc'
            		)
           	 );
            	
            
            
	            $condition_array = print_r($dnsBlockArray, true);
	            $this->log("SCenarios controller : block array : $condition_array", LOG_DEBUG);
	            
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
	            		$cond = array_merge($cond, array('Odsentry.source >=' => $blockStartFilter, 'Odsentry.source <=' => $blockEndFilter));
	            }
	            else {
	            
	            		$cond = array_merge($cond, array('Odsentry.source >=' => $blockStartFilter, 'Odsentry.source <=' => $blockEndFilter));
	            
	            }
            }
            
            
            /* END LARGE DATASET */
            

            $rangeMinval = isset($data['rangeMin']['minval']) ? $data['rangeMin']['minval'] : "";
            $rangeMaxval = isset($data['rangeMax']['maxval']) ? $data['rangeMax']['maxval'] : "";

            if ($rangeMinval != '' && $rangeMaxval != '') {
                $cond = array_merge($cond, array('Odsentry.source >=' => $rangeMinval, 'Odsentry.source <=' => $rangeMaxval));
                //$cond = array_merge($cond,array('Scenario.source <'=>$rangeMaxval));
                $this->Session->write('cond', serialize($cond));
                $condition_array = print_r($cond, true);
                $this->log("Scenario controller : Setting sesion conditions : $condition_array", LOG_DEBUG);
                #$this->set('station_id',$station_id);
                #Set below for sort/filter problem where filter arguments not passed to sort
                $this->passedArgs['rangeMin'] = $rangeMinval;
                $this->passedArgs['rangeMax'] = $rangeMaxval;
                $this->set('advancedFlag', '1');
            }
            $this->paginate = array('conditions' => $cond, 'limit' => $this->paginate['limit']);
            $odsEntryList = $this->Odsentry->find('all', array('fields' => array('Odsentry.*','Scenario.status'),'conditions' => $cond, 'order' => array("Odsentry." . $orderbyfield . " " . $orderbyorder . "")));
			
			$valid = __('Valid',true);
			$validd = utf8_encode($valid);
            $invalid = __('Invalid',true);
            $invalidd = utf8_encode($invalid);
			foreach($odsEntryList as $key => $list){
			
				$odsEntryList[$key]['Odsentry']['config'] = __($list['Odsentry']['config'],true);
				$odsEntryList[$key]['Odsentry']['dest1'] = __($list['Odsentry']['dest'],true) ? $validd : $invalidd;
				
			}
			
			$odscount = count($odsEntryList);
			$this->set('odsTotalrecord', $odscount);
			
			App::import('Vendor', 'json', array('file'=>'JSON.php'));
			$json = new Services_JSON();
			
            $this->set('odsEntryList', $odsEntryList);
			
			$output = $json->encode($odsEntryList);

			//echo $json->utf82utf16('Zürich 01');
			//print_r($output); die;
			
            $this->set('jsonodsEntryList', $output);
			
            $this->set('SELECTED_CUSTOMER', $scenarioDetails[0]['Scenario']['customer_id']);
            $this->set('scenario_id', $scenario_id);
            $this->set('rangeMinval', $rangeMinval);
            $this->set('rangeMaxval', $rangeMaxval);
            $this->set('scenario_state', $scenario_status);
            

            #Log data for hsitory
            #Now send logs
           // $cond = array('Log.affected_obj' => $scenario_id, 'Log.customer_id' => $odsEntryList[0]['Scenario']['customer_id']); changed because this  show only scenario log prevent to show all log
			
			$cond = array( 'Log.affected_obj' => $scenario_id);
            #$cond = array_merge($cond,array('Log.affected_obj'=>$scenario_id));
            #$cond = array_merge($cond,array('Log.customer_id'=>$customer_id));
            $this->paginate['Paginate'] = $this->AutoPaginate->setPaginate();
            #$this->paginate['limit'] = 5;
            $this->paginate = array('limit' => $this->paginate['limit'], 'conditions' => $cond, 'order' => 'Log.id desc');
            $loginfo = $this->paginate('Log');
            $this->set('loginfo', $loginfo);

            
        
        
      
        
    }

    /**
     * function for uploading file
     *
     */
    function create_schedule($scenario_id = null, $type = 'create', $customer_id = null, $execution_id = null, $act = null) {

        $this->layout = 'ajax';
        //echo $execution_id;
        //Configure::write("debug",2);
        if (isset($this->data)) {


            /*             * ********Security check for case of external users******* */
            if ($this->Session->read('SELECTED_CUSTOMER') != Configure :: read('access_id')) {

                #If The user is an external..

                $id = $this->Session->read('SELECTED_CUSTOMER');

                #For external users Perform a check tosee that the users BSK matches 
                # the customer id that is supplied as page argumen or derived from operation.
                $this->log('SCENARIOS CONTROLLER : Checking valid customer => BSK' . $id . ' : customer => ' . $this->data['Execution']['customer_id'], LOG_DEBUG);

                if (!$this->Customer->validCustomer($id, $this->data['Execution']['customer_id'])) {
                    $this->log('SCENARIOS CONTROLLER : invalid customer => BSK' . $id . ' : customer => ' . $this->data['Execution']['customer_id'], LOG_DEBUG);

                    #print_r("not valid");die();
                    $this->redirect('/customers');
                    exit();
                }
                #print_r("valid checking $id $number");die();
            }
            /*             * ********************END************************ */
            $scenarioData = $this->Scenario->find('first', array('conditions' => array('Scenario.id' => $this->data['Execution']['scenario_id'])));
            $this->createVfcScript($scenarioData['Scenario']['id']); # Call function to create VFC script.

            //pr($this->data);
            //die;
            App::import("model", "Execution");
            $this->Execution = new Execution();
            $db = $this->Execution->getDataSource();
            $data = $this->data;

            $this->data['Execution']['targetDate'] = preg_replace('~(\d+)\.(\d+)\.(\d+)~', "$1/$2/$3", $this->data['Execution']['targetDate']);
            #$this->log('SCENARIOS CONTROLLER : targetDate :' . $this->data['Execution']['targetDate'] , LOG_DEBUG);
            $data['Execution']['targetDate'] = $this->convertToSystemDate($this->data['Execution']['targetDate']) . " " . $this->data['Execution']['time'];
            $data['Execution']['targetDate'] = date('Y-m-d G:i:s', strtotime($data['Execution']['targetDate']));
            $data['Execution']['applyDate'] = $db->expression("NOW()");
            $data['Execution']['type'] = 'odsScehduled';
            $data['Execution']['scenario_id'] = $this->data['Execution']['scenario_id'];
            #$data['Execution']['customer_id'] = $this->data['Execution']['customer_id'];
            $data['Execution']['user_id'] = $this->Session->read('ACCOUNTNAME');
            if ($this->Execution->save($data)) {
                #$this->Session->setFlash('Saved Successfully');
                #$log = $data['Execution']['operation'] . ' onDemand script scheduled : ' . date('d.m.Y H:i', strtotime($data['Execution']['targetDate']));
                $execId = $this->Execution->id;
                $log = 'Scenario Updated : Schedule Created : ' . strtolower($data['Execution']['operation']) . ' ' . date('d.m.Y H:i', strtotime($data['Execution']['targetDate'])) . ' [ID ' . $execId . ']';

                $insert = array(
                    'Log' => array(
                        'affected_obj' => $scenarioData['Scenario']['id'],
                        'affected_obj_name' => $scenarioData['Scenario']['Name'],
                        'affected_obj_type' => 'Scenario',
                        'log_entry' => $log,
                        'created' => date('Y-m-d H:i:s'),
                        'status' => 1,
                        'customer_id' => $data['Execution']['customer_id'],
                        'bsk' => $this->Session->read('BSK'),
                        'user' => $this->Session->read('ACCOUNTNAME'),
                        'app_type' => 'Gate',
                        'modified' => '0000-00-00 00:00:00',
                        'modification_status' => 1,
                        'modification_response' => ''
                    )
                );

                $this->Log->create();
                $this->Log->save($insert, false);
                $log_id = $this->Log->id;
                #$this->redirect(array('controller'=>'scenarios','action'=>'index','customer_id:'.$data['Execution']['customer_id'].'&etype=updated'));
                
                $link = __('scheduleAdded', true) .'&nbsp'.'<a class="fancybox fancybox.ajax" href="' . Configure::read('base_url') . 'logs/logdetails/' . $log_id . '">' . __("LogEntry", true) . '</a>';
                $_SESSION['success'] .= $link;
                
                $this->redirect(array('controller' => 'scenarios', 'action' => 'edit', 'scenario_id:' . $scenarioData['Scenario']['id'] . '&etype=updated&mode=operate'));
            } else {
                #$this->Session->setFlash('Saved Unsuccessfully');
                $this->redirect(array('controller' => 'scenarios', 'action' => 'index', 'customer_id:' . $data['Execution']['customer_id'] . '&etype=error'));
            }
        }
        if ($type == 'edit') {

            $this->data = $this->Execution->find('first', array('conditions' => array('id' => $execution_id)));

            if ($this->data['Execution']['status'] == 'INPROGRESS' || $this->data['Execution']['status'] == 'COMPLETED') {
                $this->set("invalidFlag", 'Selected Schedule has already been executed');
                #$this->Session->setFlash('You can not edit a schedule after it has been applied.');
                #$this->redirect(array('controller'=>'scenarios','action'=>'create_schedule','customer_id:'.$customer_id));
            } else {
                $date = date('d/m/Y', strtotime($this->data['Execution']['targetDate']));
                $time = substr($this->data['Execution']['targetDate'], 11, 8);
                $this->data['Execution']['targetDate'] = $this->convertToJQueryDate($date);
                $this->data['Execution']['time'] = date('G:i', strtotime($time));
                $this->set('execution_id', $execution_id);
                $this->set("scenario_id", $this->data['Execution']['scenario_id']);
            }
        } elseif ($type == 'delete') {

            $this->data = $this->Execution->find('first', array('conditions' => array('id' => $execution_id)));

            if ($this->data['Execution']['status'] == 'INPROGRESS' || $this->data['Execution']['status'] == 'COMPLETED') {
                $this->set("invalidFlag", 'Selected Schedule has already been executed');
                #$this->Session->setFlash('You can not edit a schedule after it has been applied.');
                #$this->redirect(array('controller'=>'scenarios','action'=>'create_schedule','customer_id:'.$customer_id));
            } else {
                $this->log('SCENARIOS CONTROLLER : create_scehdule : Deleteing SCenarion => ' . $scenario_id . ' : execution => ' . $execution_id, LOG_DEBUG);
                $this->set("deleteFlag", 'Are you sure you want to delete schedule');
                $this->set('execution_id', $execution_id);
                $this->set("scenario_id", $this->data['Execution']['scenario_id']);
                #$this->Execution->delete($execution_id);
                #$this->Session->setFlash('Schedule has been deleted successfully');
                #$this->redirect(array('controller'=>'scenarios','action'=>'index','customer_id:'.$customer_id));
            }
        } else {
            $this->set("scenario_id", $scenario_id);
        }

        if (isset($act) && $act != 'undefined') {
            $this->set("act", $act);
        }
        $this->set('customer_id', $customer_id);
    }

    
    function confirmapply() {
    
    	$this->layout = 'ajax';
    	//echo $execution_id;
    	//Configure::write("debug",2);
    	$scenario_id = isset($this->params['url']['scenario_id']) ? $this->params['url']['scenario_id'] : (isset($this->params['form']['scenario_id']) ? $this->params['form']['scenario_id'] : "");
    	$operation = isset($this->params['url']['operation']) ? $this->params['url']['operation'] : (isset($this->params['form']['operation']) ? $this->params['form']['operation'] : "");
    	 
    	$scenarioDetails = $this->Scenario->findById($scenario_id);
    	$scenario_name = $scenarioDetails['Scenario']['Name'];
    	$customer_id = $scenarioDetails['Scenario']['customer_id'];
    	
    	$canApply = $this->Scenario->getCountDNinScenarios($scenario_id, $customer_id);
    	$result_array=print_r($canApply, true);
    	$this->log("Scenario controller : Deleting scenario : $result_array", LOG_DEBUG);
    	$canApply = $canApply[0][0]['count(*)'];
    	if($canApply > 0)
    	{
    		$this->log('SCENARIOS CONTROLLER : configrmApply : canApply NO' . $canApply, LOG_DEBUG);
    		
    		
    	}
    	else
    	{
    		$this->log('SCENARIOS CONTROLLER : configrmApply : canApply YES' . $canApply, LOG_DEBUG);
    		$this->set('valid', '1');
    		
    	}
    	$this->log("SCENARIO controller : confirmApply  :" . $scenario_id . " " . $operation, LOG_DEBUG);
    	$this->set('scenario_id', $scenario_id);
    	$this->set('scenario_name', $scenario_name);
    	$this->set('operation', $operation);

    }
    
    function applyscenario() {
    
    	
    	$this->layout = 'ajax';
    	// $location_id = isset($this->params['url']['location_id']) ? $this->params['url']['location_id'] : (isset($this->params['named']['location_id']) ? $this->params['named']['location_id'] : "");
    	$scenario_id = isset($this->params['url']['scenario_id']) ? $this->params['url']['scenario_id'] : (isset($this->params['form']['scenario_id']) ? $this->params['form']['scenario_id'] : "");
    	$operation = isset($this->params['url']['operation']) ? $this->params['url']['operation'] : (isset($this->params['form']['operation']) ? $this->params['form']['operation'] : "");
    	
    	$this->log('SCENARIO CONTROLLER : applyscenairo : ' . $scenario_id, LOG_DEBUG);
    	
    	
    	$script = $this->Scenario->findById($scenario_id);    	
    	
    	#Set Scenario number for activation
    	if($script['Scenario']['number'] == '')
    	{
    		$scenario_number = $this->setScenarioNumber($scenario_id);
    		$fl = $this->Scenario->updateAll(array('Scenario.number' => $scenario_number), array('Scenario.id' => $scenario_id));
    	}
    	else
    	{
    		$scenario_number = $script['Scenario']['number'];
    	}
    	
    	
    	$this->createVfcScript($scenario_id); # Call function to create VFC script.
        
            

        #$script1= $script['Scenario']['ActScript'];
        #$script2= $script['Scenario']['ActScript'];
        $script1='test';
        $script1='test';
       
        $customer_id = $script['Scenario']['customer_id'];
        
        
        
        $this->log('SCENARIO CONTROLLER : applyscenairo : SCenario Number' . $scenario_number, LOG_DEBUG);
    
        #Create Execution Record
        
        App::import("model", "Execution");
        $this->Execution = new Execution();
        $db = $this->Execution->getDataSource();
            
        $this->data['Execution']['targetDate'] = '0000-00-00 00:00:00';
        #$this->log('SCENARIOS CONTROLLER : targetDate :' . $this->data['Execution']['targetDate'] , LOG_DEBUG);
        $data['Execution']['targetDate'] = $db->expression("NOW()");
        $data['Execution']['operation'] = strtoupper($operation);
        $data['Execution']['applyDate'] = $db->expression("NOW()");
        $data['Execution']['type'] = 'odsOnDemand';
        $data['Execution']['scenario_id'] = $scenario_id;
        #$data['Execution']['customer_id'] = $this->data['Execution']['customer_id'];
        $data['Execution']['user_id'] = $this->Session->read('ACCOUNTNAME');
        if ($this->Execution->save($data)) {
        	#$this->Session->setFlash('Saved Successfully');
        	#$log = $data['Execution']['operation'] . ' onDemand script scheduled : ' . date('d.m.Y H:i', strtotime($data['Execution']['targetDate']));
        	$execId = $this->Execution->id;
        }


    	$transId = time() . $_SERVER['HTTP_SSO_ACCOUNTUID'];
    	$counter = 1;
    	$fullTransaction = '<Activation id="' . $transId . '">';
    	$this->log('SCENARIO CONTROLLER : Generating new timestamp : ' . $transId, LOG_DEBUG);
         
    
        $subTrans = $transId .  '-' . $counter;
		$fullTransaction .= '<subtransaction id="' . $subTrans . '">';
    	$fullTransaction .= '<algRequest><object action="update" name="ODS"><message station="NA" key="00"><var value="' . $execId . '" name="execution_id"/></message></object></algRequest>';
	    $fullTransaction .= '</subtransaction>';
    	#$fullTransaction = '<algRequest><object action="update" name="LOCATION"><message station="NA" key="00"></message><var value="' . $dn_id . '" name="dn"/><var value="' . $location_id . '" name="location"/></message></object></algRequest>';
    	$counter++;
            	
    	$fullTransaction .= '</Activation>';
     
        #Updated with DNS function to send XML command to ALG and change status
        $app_response = $this->apply_trans($fullTransaction, $scenario_id, $operation,$customer_id);
       	$response = explode(":",$app_response);
    	$log_id= $response[0];
    	$apply_response= $response[1];

    	$this->log("SCENARIOS controller :  apply response : $apply_response", LOG_DEBUG);
    	if ($apply_response == 1) {
    		 
    		 if($operation == 'activate')
    		 {
    		 	$fl = $this->Scenario->updateAll(array('Scenario.status' => 6), array('Scenario.id' => $scenario_id));
    		 }
    		 if($operation == 'deactivate')
    		 {
    		 	$fl = $this->Scenario->updateAll(array('Scenario.status' => 4), array('Scenario.id' => $scenario_id));
    		 }
    		 $link = __('applySuccess', true) .'&nbsp'.'<a class="fancybox fancybox.ajax" href="' . Configure::read('base_url') . 'logs/logdetails/' . $log_id . '">' . __("LogEntry", true) . '</a>';
    		 $_SESSION['success'] .= $link;
    		 			 
        }
    	else
    	{
		 		$this->log("SCENARIOS controller : apply - Bad response : $apply_response", LOG_DEBUG);
    		 	$link = '<a class="fancybox fancybox.ajax" href="' . Configure::read('base_url') . 'logs/logdetails/' . $log_id . '">' . __("LogEntry", true) . '</a>';
    		 	$_SESSION['error'] .= $link;
    
   		}
    		 	 
    		 	 
    		 	
    
     	echo 1;
     	exit();
   	}
    
    
    function apply_trans($fullTransaction, $scenario_id, $operation,$customer_id) {
    	$this->log("SCENARIO controller : Apply  :" . $dn_id . " " . $location_id, LOG_DEBUG);
    
    	#grab the transaction
    	preg_match("/Activation id=\"(\d+)\"/", $fullTransaction, $matches);
    	if ($matches[0]) {
    	$transId = $matches[1];
    	$this->log('SCENARIO CONTROLLER ' . 'APPLY TRANSACTION: ' . $transId , LOG_DEBUG);
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
    
    					$this->log('SCENARIO CONTROLLER ' . 'ODS REQUEST' . $password , LOG_DEBUG);
    					$transResponse = $this->AlgInterface->processTransaction($fullTransaction);
    					 
    					preg_match("/C20_FAILURE/", $transResponse, $matches);
    							if ($matches[0])
    							{
    							#???vIf ther was an error then it is possible to save the correctly applied features with active state but not the remaining.
    							#This can be handled by looping through the subtransactions in sequence
    							$this->log('SCenario Controller : Apply TO C20 FAILED ' .  $transResponse, LOG_DEBUG);
    								$transStatus = 0;
    							}
    							else
    							{
    							$transStatus = 1;
    }
    
    							#Now Create the Log entry with status and associate the transaction.
    
        			$log = 'Scenario Applied : ' . $operation . ' : onDemand';
    
            			$insert = array (
    							'Log' => array (
    							'affected_obj' => $scenario_id,
    							'log_entry' => $log,
    							'created' => date('Y-m-d H:i:s'),
    							'status' => 1,
    							'customer_id' => $customer_id,
								'bsk' => $this->Session->read('BSK'),
    							'user' => $this->Session->read('ACCOUNTNAME'),
        						'app_type' => 'Gate',
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
    
    function apply_now() {
        if (!empty($_POST)) {


            /*             * ********Security check for case of external users******* */
            if ($this->Session->read('SELECTED_CUSTOMER') != Configure :: read('access_id')) {

                #If The user is an external..

                $id = $this->Session->read('SELECTED_CUSTOMER');

                #For external users Perform a check to see that the users BSK matches 
                # the customer id that is supplied as page argumen or derived from operation.
                $this->log('SCENARIOS CONTROLLER : Checking valid customer => BSK' . $id . ' : customer => ' . $_POST['customer_id'], LOG_DEBUG);

                if (!$this->Customer->validCustomer($id, $_POST['customer_id'])) {
                    $this->log('SCENARIOS CONTROLLER : invalid customer => BSK' . $id . ' : customer => ' . $_POST['customer_id'], LOG_DEBUG);

                    print_r("not valid");die();
                    $this->redirect('/customers');
                    exit();
                }
                #print_r("valid checking $id $number");die();
            }
            /*             * ********************END************************ */
            #Check user can access this function.

            $scenarioData = $this->Scenario->find('first', array('conditions' => array('Scenario.id' => $_POST['scenario_id'])));
              
           
            $this->loadModel('Execution');
            $this->Execution = new Execution();
            $db = $this->Execution->getDataSource();
            $data = $this->data;
            //if($_POST['time']!=''){
            //$data['Execution']['targetDate'] = date('Y-m-d')." ".$_POST['time'].':00';
            //}else
            //{
            $data['Execution']['targetDate'] = date('Y-m-d G:i:s');
            //}
            $data['Execution']['applyDate'] = $db->expression("NOW()");
            $data['Execution']['scenario_id'] = $_POST['scenario_id'];
            $data['Execution']['status'] = 'SCHEDULED';
            $data['Execution']['operation'] = $_POST['status'];
            #$data['Execution']['customer_id'] = $_POST['customer_id'];
            $data['Execution']['user_id'] = $this->Session->read('ACCOUNTNAME');

            if ($_POST['execution_id'] != 'undefined') {
                $data['Execution']['id'] = $_POST['execution_id'];
            }
            
                $execId = $this->Execution->id;


                $log = 'Scenario Applied : Execution finished : ' . strtolower($data['Execution']['operation']) ;

                $insert = array(
                    'Log' => array(
                        'affected_obj' => $scenarioData['Scenario']['id'],
                        'affected_obj_name' => $scenarioData['Scenario']['Name'],
                        'affected_obj_type' => 'Scenario',
                        'log_entry' => $log,
                        'created' => date('Y-m-d H:i:s'),
                        'status' => 1,
                        'customer_id' => $_POST['customer_id'],
                        'bsk' => $this->Session->read('BSK'),
                        'user' => $this->Session->read('ACCOUNTNAME'),
                        'app_type' => 'Gate',
                        'modified' => '0000-00-00 00:00:00',
                        'modification_status' => 1,
                        'modification_response' => ''
                    )
                );
                
				
				
                $this->Log->create();
              $checklogentry=$this->Log->save($insert, false);
			  
			 
            

            //$this->Execution->id;

            $act = $_POST['act'];
            $scenario_id = $_POST['scenario_id'];

            if ($act == "ACTIVATE") {
                $cstatus = 6;
            } else if ($act == "DEACTIVATE") {
                $cstatus = 4;
            }

            $this->Scenario->updateAll(
                    array('Scenario.status' => "'" . $cstatus . "'"), array('Scenario.id' => $scenario_id)
            );

            $customer_id = $_POST['customer_id'];


            echo $scenario_id . "::" . $execId . "::" . $customer_id . "::" . $act;
        }
		
        die;
    }

    function check_status() {


        if (!empty($_POST)) {

            #??????ADDED FOR DEBUGGING ?????
            #echo 1;
            #die;
            #??????ADDED FOR DEBUGGING ?????


            $scenario_id = $_POST['scenario_id'];
            $customer_id = $_POST['customer_id'];
            $execId = $_POST['execution_id'];
            $act = $_POST['act'];

            $this->loadModel('Execution');
            $this->Execution = new Execution();
            $db = $this->Execution->getDataSource();
            if ($_POST['execution_id'] != 'undefined') {

                $status = $this->Execution->find('first', array('conditions' => array('id' => $_POST['execution_id']), 'fields' => array('status'), 'order' => array('id' => 'DESC')));
            } else {
                $status = $this->Execution->find('first', array('conditions' => array('scenario_id' => $scenario_id), 'fields' => array('status'), 'order' => array('id' => 'DESC')));
            }

            $currunt_status = $status['Execution']['status'];

            if ($currunt_status == 'COMPLETED') {
                Configure::write('debug', 0);
                echo 1;
            } else if ($currunt_status == 'SCHEDULED') {
                Configure::write('debug', 0);
                echo 2;
            } else if ($currunt_status == 'INPROGRESS') {
                Configure::write('debug', 0);
                echo 3;
            } else if ($currunt_status == 'WARNING') {
                Configure::write('debug', 0);
                echo 4;
            } else {
                echo $currunt_status;
            }


            if ($act == "ACTIVATE") {
                $cstatus = 6;
            } else if ($act == "DEACTIVATE") {
                $cstatus = 4;
            }

            /* $this->Scenario->updateAll(
              array('Scenario.status' => "'".$cstatus."'"),
              array('Scenario.id' => $scenario_id)
              ); */

            echo ":-:";
            echo $scenario_id . ":-:" . $execId . ":-:" . $customer_id . ":-:" . $cstatus;
        }

        die;
    }

    function deleteScenario($scenario_id = null) {

    	$scenario_id=isset($this->params['url']['scenario_id'])?$this->params['url']['scenario_id']:(isset($this->params['named']['scenario_id'])?$this->params['named']['scenario_id']:"");
    	
    	
        if ($scenario_id != '') {

            $scenarioDetails = $this->Scenario->find('all', array('conditions' => array('Scenario.id' => $scenario_id)));
            #$result_array=print_r($scenarioDetails, true);
            #$this->log("Scenario controller : Deleting scenario : $result_array", LOG_DEBUG);

            $this->log("Scenario controller : Deleting scenario : $scenario_id", LOG_DEBUG);
            
            $this->Scenario->delete($scenario_id);

            $this->Odsentry->deleteAll(array('Odsentry.scenario_id' => $scenario_id));
            $this->Execution->deleteAll(array('Execution.scenario_id' => $scenario_id));


            $log = 'Scenario Deleted';
            $insert = array(
                'Log' => array(
                    'affected_obj' => $scenario_id,
                    'affected_obj_name' => $scenarioDetails[0]['Scenario']['Name'],
                    'affected_obj_type' => 'Scenario',
                    'log_entry' => $log,
                    'created' => date('Y-m-d H:i:s'),
                    'status' => 1,
                    'customer_id' => $scenarioDetails[0]['Scenario']['customer_id'],
                    'bsk' => $this->Session->read('BSK'),
                    'user' => $this->Session->read('ACCOUNTNAME'),
                    'app_type' => 'Gate',
                    'modified' => '0000-00-00 00:00:00',
                    'modification_status' => 1,
                    'modification_response' => ''
                )
            );

            $this->Log->create();
            $this->Log->save($insert, false);
            $log_id = $this->Log->id;
        }
        else {
        	$this->log("Scenario controller : Deleting scenario Scenarion not set : $scenario_id", LOG_DEBUG);
        }

        	$link = __("scenarioDeleted", true );
        	$link .= '<a class="fancybox fancybox.ajax" href="' . Configure::read('base_url') . '/logs/logdetails/' . $log_id . '">' . __("LogEntry", true) . '</a>';
        	$_SESSION['success'] .= $link;

exit();

        //$this->redirect('/scenarios/index/customer_id:' . $scenarioDetails[0]['Scenario']['customer_id']);
    }



    function delete_schedule($scenario_id, $execution_id) {

        #Orig GET
        #$scenario_id=isset($this->params['url']['scenario_id'])?$this->params['url']['scenario_id']:(isset($this->params['named']['scenario_id'])?$this->params['named']['scenario_id']:"");
        #$execution_id=isset($this->params['url']['execution_id'])?$this->params['url']['execution_id']:(isset($this->params['named']['execution_id'])?$this->params['named']['execution_id']:"");
        #New POST
        #$scenario_id=$this->data['Scenario']['scenario_id'];
        #$execution_id=$this->data['Scenario']['execution_id'];

        $this->log('SCENARIOS CONTROLLER : Deleteing SCenarion => ' . $scenario_id . ' : execution => ' . $execution_id, LOG_DEBUG);

        $data = $this->Scenario->find('first', array('conditions' => array('Scenario.id' => $scenario_id)));
        $this->loadModel('Execution');
        $this->Execution = new Execution();
        $db = $this->Execution->getDataSource();
        $ExecutionResult = $this->Execution->find('first', array('conditions' => array('Execution.id' => $execution_id), 'fields' => array('targetDate', 'operation')));
        $customer_id = $data['Scenario']['customer_id'];


        /*         * ********Security check for case of external users******* */
        if ($this->Session->read('SELECTED_CUSTOMER') != Configure :: read('access_id')) {

            #If The user is an external..

            $id = $this->Session->read('SELECTED_CUSTOMER');

            #For external users Perform a check to see that the users BSK matches 
            # the customer id that is supplied as page argumen or derived from operation.
            $this->log('SCENARIOS CONTROLLER : Checking valid customer => BSK' . $id . ' : customer => ' . $customer_id, LOG_DEBUG);

            if (!$this->Customer->validCustomer($id, $customer_id)) {
                $this->log('SCENARIOS CONTROLLER : invalid customer => BSK' . $id . ' : customer => ' . $customer_id, LOG_DEBUG);

                #print_r("not valid");die();
                $this->redirect('/customers');
                exit();
            }
            #print_r("valid checking $id $number");die();
        }
        /*         * ********************END************************ */



        $this->Execution->delete($execution_id);
        #$this->Session->setFlash('Schedule has been deleted successfully');
        #$this->set('success', 'Schedule Deleted');

        $log = 'Scenario Updated : Schedule Deleted : ' . strtolower($ExecutionResult['Execution']['operation']) . ' ' . date('d.m.Y H:i', strtotime($ExecutionResult['Execution']['targetDate'])) . ' [ID ' . $execution_id . ']';

        $insert = array(
            'Log' => array(
                'affected_obj' => $data['Scenario']['id'],
                'affected_obj_name' => $data['Scenario']['Name'],
                'affected_obj_type' => 'Scenario',
                'log_entry' => $log,
                'created' => date('Y-m-d H:i:s'),
                'status' => 1,
                'customer_id' => $customer_id,
                'bsk' => $this->Session->read('BSK'),
                'user' => $this->Session->read('ACCOUNTNAME'),
                'app_type' => 'Gate',
                'modified' => '0000-00-00 00:00:00',
                'modification_status' => 1,
                'modification_response' => ''
            )
        );

        $this->Log->create();
        $this->Log->save($insert, false);

        #$this->redirect(array('controller' => 'scenarios', 'action' => 'edit', 'scenario_id:' . $data['Scenario']['id'] . '&etype=deleted'));
		
		echo $data['Scenario']['id'];
		exit();

        #$this->Session->setFlash('Saved Unsuccessfully');
        #$this->redirect(array('controller'=>'scenarios','action'=>'index','customer_id:'.$data['Execution']['customer_id']));
    }
	
	
	
	
	 function delete_allschedule($scenario_id) {
        

        $this->log('SCENARIOS CONTROLLER : Deleteing SCenarion => ' . $scenario_id . ' : execution => ' . $execution_id, LOG_DEBUG);

        $data = $this->Scenario->find('first', array('conditions' => array('Scenario.id' => $scenario_id)));
        $this->loadModel('Execution');
        $this->Execution = new Execution();
        $db = $this->Execution->getDataSource();
        $ExecutionResult = $this->Execution->find('first', array('conditions' => array('Execution.id' => $execution_id), 'fields' => array('targetDate', 'operation')));
        $customer_id = $data['Scenario']['customer_id'];


        /*         * ********Security check for case of external users******* */
        if ($this->Session->read('SELECTED_CUSTOMER') != Configure :: read('access_id')) {

            #If The user is an external..

            $id = $this->Session->read('SELECTED_CUSTOMER');

            #For external users Perform a check to see that the users BSK matches 
            # the customer id that is supplied as page argumen or derived from operation.
            $this->log('SCENARIOS CONTROLLER : Checking valid customer => BSK' . $id . ' : customer => ' . $customer_id, LOG_DEBUG);

            if (!$this->Customer->validCustomer($id, $customer_id)) {
                $this->log('SCENARIOS CONTROLLER : invalid customer => BSK' . $id . ' : customer => ' . $customer_id, LOG_DEBUG);

                #print_r("not valid");die();
                $this->redirect('/customers');
                exit();
            }
           
        }
        /*         * ********************END************************ */



        $this->Execution->deleteAll($scenario_id);
        

        $log = 'Scenario Updated : Schedule Deleted : ' . strtolower($ExecutionResult['Execution']['operation']) . ' ' . date('d.m.Y H:i', strtotime($ExecutionResult['Execution']['targetDate'])) . ' [ID ' . $execution_id . ']';

        $insert = array(
            'Log' => array(
                'affected_obj' => $data['Scenario']['id'],
                'affected_obj_name' => $data['Scenario']['Name'],
                'affected_obj_type' => 'Scenario',
                'log_entry' => $log,
                'created' => date('Y-m-d H:i:s'),
                'status' => 1,
                'customer_id' => $customer_id,
                'bsk' => $this->Session->read('BSK'),
                'user' => $this->Session->read('ACCOUNTNAME'),
                'app_type' => 'Gate',
                'modified' => '0000-00-00 00:00:00',
                'modification_status' => 1,
                'modification_response' => ''
            )
        );

        $this->Log->create();
        $this->Log->save($insert, false);
        #$this->redirect(array('controller' => 'scenarios', 'action' => 'edit', 'scenario_id:' . $data['Scenario']['id'] . '&etype=deleted'));		
		echo $data['Scenario']['id'];
		exit();

    }
	
	
	

    function export() {
        $this->layout = "";

        //echo $conds = unserialize($this->Session->read('cond'));

        $scenario_id = isset($this->params['url']['scenario_id']) ? $this->params['url']['scenario_id'] : (isset($this->params['named']['scenario_id']) ? $this->params['named']['scenario_id'] : "");

        $filename = "export_scenarios_" . date("Y.m.d") . ".csv";
        $csv_file = fopen('php://output', 'w');
        header('Content-type: application/csv');
        header('Content-Disposition: attachment; filename="' . $filename . '"');
        $customer_id = 'HEIN'; # TESTING
        //$scenarioResults = $this->Scenario->find('all',array('recursive'=>'2', 'fields' => array('Scenario.id', 'Scenario.Name', 'Scenario.status' 	
        $scenarioResults = $this->Scenario->find('all');


        #$executionResults = $this->Execution->find('all',array('fields' => array('Execution.operation', 'Execution.targetDate', ),'conditions' => array('Scenario.customer_id' => $customer_id ))); 
        //$header_row = array("S.No.", "Scenario Name", "Scenario Status", "Operation", "TargetDate", "Execution status" );
        $header_row = array("S.No.", "Scenario Name", "Scenario Status");

        fputcsv($csv_file, $header_row, ';', '"');

        // Each iteration of this while loop will be a row in your .csv file where each field corresponds to the heading of the column
        $i = 1;
        foreach ($scenarioResults as $result) {

            // Array indexes correspond to the field names in your db table(s)

            foreach ($result['Execution'] as $execResult) {

                #print_r($execResult);

                $status = ($result['Scenario']['state'] == 1) ? 'Valid' : 'Invalid';

                $row = array(
                    $result['Scenario']['Sno'] = $i,
                    $result['Scenario']['Name'],
                    $status,
                    $execResult['operation'],
                    $execResult['targetDate'],
                    $execResult['status'],
                );
                $i++;
                fputcsv($csv_file, $row, ';    ', '"');
            }
        }

        fclose($csv_file);
        exit();
    }

    /* function for getting the script details
     *
     * @param int $script_id
     */

    function scriptdetails($script_id = null) {


        #$this->createscript($script_id); # Call function to create original script.
        
    	$script = $this->Scenario->findById($script_id);
    	 
    	
    	
    	#Set Scenario number for activation
    	if($script['Scenario']['number'] == '')
    	{
    			$scenario_number = $this->setScenarioNumber($scenario_id);
    			$fl = $this->Scenario->updateAll(array('Scenario.number' => $scenario_number), array('Scenario.id' => $scenario_id));
    	}
    	else
    	{
    			$scenario_number = $script['Scenario']['number'];
    	}
        $this->createVfcScript($script_id); # Call function to create VFC script.
        
                
        $script = $this->Scenario->findById($script_id);
        
        $scriptinfo = $script['Scenario'];

        $this->update = $script['Scenario'];
        $this->layout = 'ajax';



        $this->set('display', $this->update);
    }
    
    function scriptsummary($script_id = null) {
    
    
    	//$this->createscript($script_id); # Call function to create script.
    	$this->createVfcScript($script_id); # Call function to create VFC script.
    
    	$script = $this->Scenario->findById($script_id);
    
    	$scriptinfo = $script['Scenario'];
    
    	$this->update = $script['Scenario'];
    	$this->layout = 'ajax';
    
    
    
    	$this->set('display', $this->update);
    }
function confirmvalidate() {
	
    
    	$this->layout = 'ajax';
    	//echo $execution_id;
    	//Configure::write("debug",2);
    	$scenario_id = isset($this->params['url']['scenario_id']) ? $this->params['url']['scenario_id'] : (isset($this->params['form']['scenario_id']) ? $this->params['form']['scenario_id'] : "");
    	$operation = isset($this->params['url']['operation']) ? $this->params['url']['operation'] : (isset($this->params['form']['operation']) ? $this->params['form']['operation'] : "");
    	 
    	$scenarioDetails = $this->Scenario->findById($scenario_id);
    	$scenario_name = $scenarioDetails['Scenario']['Name'];
    	
    	$this->log("SCENARIO controller : confirmValidate  :" . $scenario_id . " " . $operation, LOG_DEBUG);
    	$this->set('scenario_id', $scenario_id);
    	$this->set('scenario_name', $scenario_name);
    	$this->set('operation', $operation);

    }

    // function to save data to logs
    function validates() {

        if ($this->RequestHandler->isAjax() == true) {
            //echo "<pre>"; print_r($this->params); die;
            //echo "<pre>"; print_r($this->params); die;
            $logArray = $this->params['form'];
            if ($logArray['log_entry'] == 'accepted') {
                $log_entry = 'Scenario Updated : Accepted';
                #$log_entry = 'scenario_accepted';
                $state = '4';
            } elseif ($logArray['log_entry'] == 'rejected') {
                $log_entry = 'Scenario Updated : Rejected';
                #$log_entry = 'scenario_rejected';
                #$modification_response = 'log_entry';
                $state = '8';
            } elseif ($logArray['log_entry'] == 'validate_request') {
                $log_entry = 'Scenario Updated : Validation Requested';
                #$log_entry = 'scenario_validate_requested';
                $state = '3';
            }
            $scenario_id = $this->params['pass'][0];

            $scenarioDetails = $this->Scenario->find('first', array('conditions' => array('Scenario.id' => $scenario_id)));

            $datatosave = array();
            $datatosave = array(
                'Log' => array(
                    'affected_obj' => $scenario_id,
                    'affected_obj_name' => $scenarioDetails[0]['Scenario']['Name'],
                    'affected_obj_type' => 'Scenario',
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
            $log_id = $this->Log->id;
            
            $this->Scenario->updateAll(
                    array('Scenario.status' => "'" . $state . "'"), array('Scenario.id' => $this->params['pass'][0])
            );

            if($logArray['log_entry'] == 'validate_request')
            {
            	$link = __('validationRequested', true) .'&nbsp'.'<a class="fancybox fancybox.ajax" href="' . Configure::read('base_url') . 'logs/logdetails/' . $log_id . '">' . __("LogEntry", true) . '</a>';
            	$_SESSION['success'] .= $link;
				$this->set('success', $_SESSION['success']);
            	#$this->redirect(array('controller'=>'scenarios','action'=>'index','customer_id:'.$logArray['cust_id']));
            	
           }
		   
		   if($logArray['log_entry'] == 'rejected')
            {
            	$link = __('Rejected', true) .'&nbsp'.'<a class="fancybox fancybox.ajax" href="' . Configure::read('base_url') . 'logs/logdetails/' . $log_id . '">' . __("LogEntry", true) . '</a>';
            	$_SESSION['success'] .= $link;
				$this->set('success', $_SESSION['success']);
            	#$this->redirect(array('controller'=>'scenarios','action'=>'index','customer_id:'.$logArray['cust_id']));
            	
           }
		   
		   if($logArray['log_entry'] == 'accepted')
            {
            	$link = __('Accepted', true) .'&nbsp'.'<a class="fancybox fancybox.ajax" href="' . Configure::read('base_url') . 'logs/logdetails/' . $log_id . '">' . __("LogEntry", true) . '</a>';
            	$_SESSION['success'] .= $link;
				$this->set('success', $_SESSION['success']);
            	#$this->redirect(array('controller'=>'scenarios','action'=>'index','customer_id:'.$logArray['cust_id']));
            	
           }
            
            echo $log_entry;
           exit();
        }
    }



 // function request validate
    function validates_request() {
        if ($this->RequestHandler->isAjax() == true) {   
            $logArray = $this->params['form'];
			$state = '3';
            $scenario_id = $this->params['url']['scenario_id'] ;
			$log_entry = 'Scenario Updated : Validation Requested';
            $scenarioDetails = $this->Scenario->find('first', array('conditions' => array('Scenario.id' => $scenario_id)));

            $datatosave = array();
            $datatosave = array(
                'Log' => array(
                    'affected_obj' => $scenario_id,
                    'affected_obj_name' => $scenarioDetails[0]['Scenario']['Name'],
                    'affected_obj_type' => 'Scenario',
                    'log_entry' => $log_entry,
                    'created' => date('Y-m-d H:i:s'),
                    'status' => 1,
                    'customer_id' => $this->params['url']['customer_id'],
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
			
			
			
            $log_id = $this->Log->id;
 
            $this->Scenario->updateAll(
                    array('Scenario.status' => "'" . $state . "'"), array('Scenario.id' => $this->params['url']['scenario_id'] )
            );

       
            if($log_entry == 'scenario_validate_requested')
            {
            	$link = __('validationRequested', true) .'&nbsp'.'<a class="fancybox fancybox.ajax" href="' . Configure::read('base_url') . 'logs/logdetails/' . $log_id . '">' . __("LogEntry", true) . '</a>';
            	$_SESSION['success'] .= $link;
            	$this->render(array('controller'=>'scenarios','action'=>'index','customer_id:'.$this->params['url']['customer_id']));
            	
            }
            
            echo $log_entry;
            die;
        }
    }













    /* Function to Open the update destination form from Edit scenario page */

    function opendestupdateview() {
        $this->layout = false;

        $scenario_id = isset($this->params['url']['scenario_id']) ? $this->params['url']['scenario_id'] : (isset($this->params['named']['scenario_id']) ? $this->params['named']['scenario_id'] : "");
		
        $this->log("Scenario controller : scenario_id : $scenario_id", LOG_DEBUG);
        $scenariodetails = $this->Scenario->find('first', array('conditions' => array('Scenario.id' => $scenario_id)));
        
        $this->set('scenario_id', $scenario_id);
        
        $condition_array = print_r($scenariodetails, true);
        $this->log("Scenario controller : Cusotmer Details : $condition_array", LOG_DEBUG);
        $this->set('scenariodetails', $scenariodetails);
		$this->set('slug', $scenario_id);
    }
    
    function openconfigupdateview() {
    	$this->layout = false;
    	
    	
    
    	$scenario_id = isset($this->params['url']['scenario_id']) ? $this->params['url']['scenario_id'] : (isset($this->params['named']['scenario_id']) ? $this->params['named']['scenario_id'] : "");
    
    	$this->log("Scenario controller : scenario_id : $scenario_id", LOG_DEBUG);
    	$scenariodetails = $this->Scenario->find('first', array('conditions' => array('Scenario.id' => $scenario_id)));
    
    	$this->set('scenario_id', $scenario_id);
    
    	$condition_array = print_r($scenariodetails, true);
    	$this->log("Scenario controller : Cusotmer Details : $condition_array", LOG_DEBUG);
    	$this->set('scenariodetails', $scenariodetails);
    }

    /* Function to update destination value form from Edit scenario page. This function is calling recursively via jQuery to update the destination. */

    function updateviajquery() {
        $this->layout = false;
        $dest_id = isset($this->params['url']['dest_id']) ? $this->params['url']['dest_id'] : (isset($this->params['named']['dest_id']) ? $this->params['named']['dest_id'] : "");

        $dest_code = isset($this->params['url']['dest_code']) ? $this->params['url']['dest_code'] : (isset($this->params['named']['dest_code']) ? $this->params['named']['dest_code'] : "");
        $dest_code = "'" . $dest_code . "'";
        if ($this->Odsentry->updateAll(array('Odsentry.dest' => $dest_code), array('Odsentry.id' => $dest_id))) {

            //$odsEntryList=$this->Odsentry->findAll( array('Odsentry.id' => $dest_id));
            $this->set('odsEntryList', $this->paginate('Odsentry'));
        } else {
            echo "saving error";
        }
    }

    
    function exceptionoverride() {
    	$this->layout = false;
    
    	if (!(empty($_POST)))
    	{
    		$condition_array = print_r($_POST, true);
    		$this->log("Scenario controller : exceptionoverride POSTED DATA: $condition_array", LOG_DEBUG);
    		
    		$scenariodetails = $this->Scenario->find('first', array('conditions' => array('Scenario.id' => $_POST['data']['Scenario']['id'])));
    		
    		$data['Scenario']['id'] = $_POST['data']['Scenario']['scenario_id'];
    		$data['Scenario']['status'] = $_POST['data']['Scenario']['status'];
    		$this->Scenario->save($data);
    		
    		#Now create Log record.
    		
    		$scenario_id = $this->Scenario->id;
    		$log = 'Scenario Updated : manual override';
    		$insert = array(
    				'Log' => array(
    						'affected_obj' => $_POST['data']['Scenario']['id'],
    						'affected_obj_name' => $scenariodetails['Scenario']['Name'],
    						'affected_obj_type' => 'Scenario',
    						'log_entry' => $log,
    						'created' => date('Y-m-d H:i:s'),
    						'status' => 1,
    						'customer_id' => $scenariodetails['Scenario']['customer_id'],
    						'bsk' => $this->Session->read('BSK'),
    						'user' => $this->Session->read('ACCOUNTNAME'),
    						'app_type' => 'Phone',
    						'modified' => '0000-00-00 00:00:00',
    						'modification_status' => 1,
    						'modification_response' => $_POST['data']['Scenario']['comment']
    				)
    		);
    		
    		$this->Log->create();
    		$this->Log->save($insert, false);
    		$log_id = $this->Log->id;
    		
    		
    		$link = __("scenarioUpdated", true );
    		$link .= '<a class="fancybox fancybox.ajax" href="' . Configure::read('base_url') . '/logs/logdetails/' . $log_id . '">' . __("LogEntry", true) . '</a>';
    		$_SESSION['success'] .= $link;
    		
    	}
    	else {
    	 
    	
    		$scenario_id = isset($this->params['url']['scenario_id']) ? $this->params['url']['scenario_id'] : (isset($this->params['named']['scenario_id']) ? $this->params['named']['scenario_id'] : "");
    
    		$this->log("Scenario controller : exception override : scenario_id : $scenario_id", LOG_DEBUG);
    		$scenariodetails = $this->Scenario->find('first', array('conditions' => array('Scenario.id' => $scenario_id)));
    
    		$this->set('scenario_id', $scenario_id);
    
    		$condition_array = print_r($scenariodetails, true);
    		$this->log("Scenario controller : Cusotmer Details : $condition_array", LOG_DEBUG);
    		$this->set('scenariodetails', $scenariodetails);
    		
    		$scenarioStates = Configure :: read('scenarioStatus');
    		
    		$statuses['4'] = __($scenarioStates['4'],true);
    		$statuses['6'] =__($scenarioStates['6'],true);
    		$this->set('statuses', $statuses);
    		
    		$condition_array = print_r($statuses, true);
    		$this->log("Scenario controller : EXCEPTION OVERRIDE : STATUS ARAY : $condition_array", LOG_DEBUG);
    	}
    }
    /* Function to update senario name form from Edit scenario page.  */
    
    function toggleView() {
   
        $this->layout = false;
        $scenario_id = isset($this->params['url']['scenario_id']) ? $this->params['url']['scenario_id'] : (isset($this->params['named']['scenario_id']) ? $this->params['named']['scenario_id'] : "");
        $customer_id = isset($this->params['url']['customer_id']) ? $this->params['url']['customer_id'] : (isset($this->params['named']['customer_id']) ? $this->params['named']['customer_id'] : "");
        #$mode = isset($this->params['url']['mode']) ? $this->params['url']['mode'] : (isset($this->params['named']['mode']) ? $this->params['named']['mode'] : "");
        $view = isset($this->params['url']['view']) ? $this->params['url']['view'] : (isset($this->params['named']['view']) ? $this->params['named']['view'] : "");
        #$scenariodetails = $this->Scenario->find('first', array('conditions' => array('Scenario.id' => $_POST['data']['Scenario']['id'])));
        $this->Session->delete('VIEWMODE');
        if($view == 'EXTERNAL')
        {
        	$this->Session->write('VIEWMODE', 'EXTERNAL');
        }
        
     
        $this->redirect('index/customer_id:' . $customer_id );
        
    }
    			/* Function to update senario name form from Edit scenario page.  */

    function update_scname() {
        $this->layout = false;
        $scenario_id = isset($this->params['url']['scenario_id']) ? $this->params['url']['scenario_id'] : (isset($this->params['named']['scenario_id']) ? $this->params['named']['scenario_id'] : "");
        $customer_id = isset($this->params['url']['customer_id']) ? $this->params['url']['customer_id'] : (isset($this->params['named']['customer_id']) ? $this->params['named']['customer_id'] : "");

        $scenario_name = isset($this->params['url']['scenario_name']) ? $this->params['url']['scenario_name'] : (isset($this->params['named']['scenario_name']) ? $this->params['named']['scenario_name'] : "");

        $data['Scenario']['Name'] = trim($scenario_name);

         $scenario_remark = isset($this->params['url']['scenario_remark']) ? $this->params['url']['scenario_remark'] : (isset($this->params['named']['scenario_remark']) ? $this->params['named']['scenario_remark'] : "");

        $data['Scenario']['remark'] = trim($scenario_remark);






        if ($scenario_id == '') {
            #This is a new scenario
            $data['Scenario']['customer_id'] = $customer_id;
            $data['Scenario']['status'] = 1;
            
            $scenario_number = $this->setScenarioNumber('');
            
            $data['Scenario']['number'] = $scenario_number;
            
            $this->Scenario->save($data);
            $id = $this->Scenario->id;
            $this->set('createdScenario', 'true');
            $this->log('SCENARIOS CONTROLLER : Scenario created, redirecting to /edit/scenario_id' . $id, LOG_DEBUG);
            #$this->redirect('/edit/scenario_id:' . $id);
            echo $id;
            exit();
        } else {

            $data['Scenario']['id'] = $scenario_id;
            $this->log('SCENARIOS CONTROLLER : Scenario updated ' . $scenario_id, LOG_DEBUG);
            if ($this->Scenario->save($data)) {
                #echo $scenario_name;  
                echo $scenario_id;
            } else {
                echo "saving error";
            }
            exit();
        }
    }

    /* function to update Ods entry and reload the scenario data via Ajax */

    function updatescenarioviajquery() {
        $this->layout = false;
        $odsdata = isset($this->params['form']['odsdata']) ? $this->params['form']['odsdata'] : (isset($this->params['named']['odsdata']) ? $this->params['named']['odsdata'] : "");
		
        $scenario_id = isset($this->params['form']['scenario_id']) ? $this->params['form']['scenario_id'] : (isset($this->params['named']['scenario_id']) ? $this->params['named']['scenario_id'] : "");



        $TotalRecords = split("&", $odsdata);
		
		

        if (!empty($TotalRecords)) {
             $updated_record_count=0;
            foreach ($TotalRecords as $EachOdsEntry) {

                $EachOdsData = split("=", $EachOdsEntry);

                if (!empty($EachOdsData) && count($EachOdsData) == 2) {

                    $OdsEntryId = $EachOdsData[0];
                    $DestinationData = $EachOdsData[1];
                    #Destination data can hold destination data OR confif
                    
                    $this->log('SCENARIOS CONTROLLER : UPDATEVIAJQUERY ODS AND VALUE' . $OdsEntryId . ':' . $DestinationData, LOG_DEBUG);
                    
                    if ($DestinationData != '') {

                    	
                    	if (($DestinationData == 'OFCLOC') || ($DestinationData == 'OFCLOC2'))
                    	{
                    		$DestinationData = '"' . $DestinationData . '"';
                    		#This is a config update
                    		
                    		
                    		$updated_record= $this->Odsentry->updateAll(array('Odsentry.config' => $DestinationData), array('Odsentry.id' => $OdsEntryId));
                    		if($updated_record==1){
                    		
                    			$updated_record_count++;
                    		}
                    	}
                    	else {
                    		
                    		$DestinationData = '"' . $DestinationData . '"';
                    		#This is a config update
                    		
                    		
                    		$updated_record= $this->Odsentry->updateAll(array('Odsentry.dest' => $DestinationData), array('Odsentry.id' => $OdsEntryId));
                    		if($updated_record==1){
                    		
                    			$updated_record_count++;
                    		}
                    		
                    	}

                      
					
					 
					 
                    }
                }
            }
        }

        $this->paginate['Paginate'] = $this->AutoPaginate->setPaginate();

        $this->paginate = array('conditions' => array('scenario_id' => $scenario_id), 'limit' => $this->paginate['limit'], 'order' => array("dest" => 'ASC'));

        $Odsentries = $this->Odsentry->find('all', array('conditions' => array('scenario_id' => $scenario_id), 'order' => array("dest" => 'ASC')));
        $odscount = count($Odsentries);
		$this->set('odsTotalrecord', $odscount);
        $this->set('odsEntryList', $Odsentries);
		unset($_SESSION['success']);
		  $success_msg = __($updated_record_count.':records were updated successfully', true) ;	
		  		  
		echo  '<div class="notification first" style="width: 534px" ><div class="ok"><div class="message">'.$success_msg.'</div></div></div>';
		  
		//$this->set('success_msg',$_SESSION['success']);
		//echo $updated_record_count;
		exit();
				
    }

    // Function to save multiple odsentries
    function updatemultipleodsentry() {
        $this->layout = false;
        $odsdata = isset($this->params['form']['odsdata']) ? $this->params['form']['odsdata'] : (isset($this->params['named']['odsdata']) ? $this->params['named']['odsdata'] : "");

        $scenario_id = isset($this->params['form']['scenario_id']) ? $this->params['form']['scenario_id'] : (isset($this->params['named']['scenario_id']) ? $this->params['named']['scenario_id'] : "");

        $TotalRecords = split("&", $odsdata);
        if (!empty($TotalRecords)) {

            foreach ($TotalRecords as $EachOdsEntry) {

                $EachOdsData = split("=", $EachOdsEntry);

                if (!empty($EachOdsData) && count($EachOdsData) == 2) {

                    $OdsEntryId = $EachOdsData[0];
                    $DestinationData = $EachOdsData[1];
                    if ($DestinationData != '') {
                    	
                    	$DestinationData = "'" . $DestinationData . "'";

                        $this->Odsentry->updateAll(array('Odsentry.dest' => $DestinationData), array('Odsentry.id' => $OdsEntryId));
                    }
                }
            }
        }

		/* COMMENTED OUT DATA RETRIEVAL CBM
		 * 
        $this->paginate['Paginate'] = $this->AutoPaginate->setPaginate();

        $this->paginate = array('conditions' => array('scenario_id' => $scenario_id), 'limit' => $this->paginate['limit']);

        $odsEntryList = $this->Odsentry->find('all', array('fields' => array('Odsentry.*','Scenario.status'),'conditions' => array('scenario_id' => $scenario_id)));

        $orderbyfield = 'source';
        $orderbyorder = 'ASC';
        if (!empty($odsEntryList)) {
            $Scenario_Status = $odsEntryList[0]['Scenario']['status'];
            if ($Scenario_Status == 1) {
                $orderbyfield = 'dest';
                $orderbyorder = 'ASC';
            }
        }

        $Odsentries = $this->Odsentry->find('all', array('conditions' => array('Odsentry.*','Scenario.status'), 'order' => array("Odsentry." . $orderbyfield . " " . $orderbyorder . "")));


        $this->set('odsEntryList', $Odsentries);

        //$this->render('updatescenarioviajquery');
		
		
		$getScenarioStatus = $this->Scenario->find('first', array('conditions' => array('Scenario.id' => $scenario_id), 'fields' => 'status'));

        $scenarioStatus = Configure :: read('scenarioStatus');

        $ScenarioCurrnetStatus = $scenarioStatus[$getScenarioStatus['Scenario']['status']];

        $odsEntryDestStatus = $this->Odsentry->find('all', array('conditions' => array('scenario_id' => $scenario_id, 'dest IS NULL')));   //$scenario_status = (count($odsEntryDestStatus) > 0) ? 'Incomplete' : $ScenarioCurrnetStatus;

        
        */ # END COMMENTED OUT DATA RETRIEVAL

        $scenario_status = (count($odsEntryDestStatus) == 0) ? 'Complete' : 'Incomplete';

        echo $scenario_status;
		
		exit();
		
		
		
    }

    /* Function to update destination value form from Edit scenario page. This function is calling recursively via jQuery to update the destination. */

    function deletedest() {
        $this->layout = false;
        $dest_id = isset($this->params['url']['dest_id']) ? $this->params['url']['dest_id'] : (isset($this->params['named']['dest_id']) ? $this->params['named']['dest_id'] : "");

        $this->Odsentry->delete($dest_id);

        echo $dest_id;

        exit(); // Exit applied here due to this function is calling via jQuery and there is not view for this function.
    }

    /* Function to create form to add Source Destination */

    function adddest() {
        $this->layout = false;
        $scenario_id = isset($this->params['url']['scenario_id']) ? $this->params['url']['scenario_id'] : (isset($this->params['named']['scenario_id']) ? $this->params['named']['scenario_id'] : "");
        $this->set('scenario_id', $scenario_id);
    }

    /* Function to save Source Destination in Odsentry table for specific Scenario */

    function addviajQuery() {
        $this->layout = false;

        $source_cod = isset($this->params['url']['source_cod']) ? $this->params['url']['source_cod'] : (isset($this->params['named']['source_cod']) ? $this->params['named']['source_cod'] : "");

        $dest_code = isset($this->params['url']['dest_code']) ? $this->params['url']['dest_code'] : (isset($this->params['named']['dest_code']) ? $this->params['named']['dest_code'] : "");
        $dest_code = "'" . $dest_code . "'";
        $state_code = isset($this->params['url']['state_code']) ? $this->params['url']['state_code'] : (isset($this->params['named']['state_code']) ? $this->params['named']['state_code'] : "");

        $scenario_id = isset($this->params['url']['scenario_id']) ? $this->params['url']['scenario_id'] : (isset($this->params['named']['scenario_id']) ? $this->params['named']['scenario_id'] : "");

        if ($this->Odsentry->save(array('Odsentry.source' => $source_cod, 'Odsentry.dest' => $dest_code, 'Odsentry.scenario_id' => $scenario_id, 'Odsentry.created' => date('Y-m-d H:i:s'), 'Odsentry.status' => $state_code))) {
            
        } else {

            echo "failed";
        }

        exit();
    }

    /* Function to create ActScript and update the database table Scenarios with field status=99 and ActScript= dynamically created code */

    
    function createVfcScript($scenario_id) {
    	$this->layout = false;
    	$scenariodetails = $this->Scenario->find('first', array('conditions' => array('Scenario.id' => $scenario_id)));
    	
    	
    	$condition_array = print_r($scenariodetails, true);
        $this->log("Scenario controller : Cusotmer Details : $condition_array", LOG_DEBUG);
        $adNumid = $scenariodetails['Customer']['adnumid']; # ??? wrong field becasue of import
    	preg_match("/^(\w+)\.([\d]+)/", $adNumid, $matches);
    	$scenario_number = str_pad($scenariodetails['Scenario']['number'],2,"0", STR_PAD_LEFT);
    	#$scenario_number = $scenariodetails['Scenario']['number'];
    	if ($matches[0]) {
    		$adNum = $matches[2];
    		$adNumPadded = str_pad($adNum, 4, "0", STR_PAD_LEFT);
    		#$adNumFirst = $adNumFirstDig;
    		$adNumFirst = str_pad($adNumFirstDig, 4, "0", STR_PAD_LEFT); #??? hardcodede for test
    		$adNumFirstDig = substr($adNumPadded,0,1);
    		$adNumSecondLastDig = substr($adNumPadded,1,3);
    		
    		#to catch case where value = 000
    		if($adNumSecondLastDig < 1)
    		{
    			$adNumSecondLastDig = '1000';
    		}
    		#$adNumSecondLast = str_pad($adNumSecondLastDig, 4, "0", STR_PAD_LEFT);; #??? hardcodede for test
    		#$adNumSecondLastDig = substr($adNum,-2,1);
    		
    	}
    	else 
    	{
    		$adNum = $adNumid; 
    		
    		 		
    		$adNumFirst = str_pad($adNum, 4, "0", STR_PAD_LEFT); #??? hardcodede for test
    		$adNumSecondLast = str_pad($adNum, 4, "0", STR_PAD_LEFT);; #??? hardcodede for test
    	}
    	
    	
    	$this->log('SCENARIOS CONTROLLER : Creating SCript : ' . $scenario_id, LOG_DEBUG);
    
    	#$scenario_id=isset($this->params['url']['scenario_id'])?$this->params['url']['scenario_id']:(isset($this->params['named']['scenario_id'])?$this->params['named']['scenario_id']:"");
    	$this->Scenario->recursive = 0;
    
    
    	$odsentrylist = $this->Odsentry->find('all', 
    				array(
    						'fields' => 'Odsentry.*',
    						'conditions' => array('Odsentry.scenario_id' => $scenario_id)));
    	
    
    
    	$ActScriptString = <<< END
\$config = '
% SCEN_ON <br>
TAB PNINFO <br>
END;
    
$ActScriptString.='PUT 99' . $adNumPadded . $scenario_number . ' PX NAT_SS7 NPBILL XLA $';		

$ActScriptString .= <<< END
<br>
QUI <br>
TAB PNSCRN <br>
END;
    
$DeActScriptString = <<< END
\$config = '
% Scenario_OFF <br>
TAB PXCODE <br>
END;

        foreach ($odsentrylist as $post) {
            $source = $post['Odsentry']['source'];
            $dest = $post['Odsentry']['dest'];
            $config = $post['Odsentry']['config'];
    
            $sriptSummary.= $source . ' => ' . $dest  . "<br>";
            #$ActScriptString.='PUT ' . $source . ' SERVICENO  99' . $adNumFirst . $scenario_id . ' REPLACE 9 0' . $dest . ' $ <br>';
            $ActScriptString.='PUT ' . $source . ' SERVICENO  99' . $adNumPadded . $scenario_number . ' REPLACE 9 ' . $dest . ' $ <br>';
            if($config == 'OFCLOC2')
            {
            	$DeActScriptString.='PUT VPNG ' . $source . ' ' . $source . ' CONT MM 9 9 CLASS NATL AMAXLAID +<br>VPNAMA CONSUME 0 XLT OFC OFCLOC2 $ <br>';
            }
            else {
            	$DeActScriptString.='PUT VPNG ' . $source . ' ' . $source . ' CONT MM 9 9 CLASS NATL AMAXLAID +<br>VPNAMA CONSUME 0 XLT OFC OFCLOC $ <br>';
            	 
            }
    
        }
    
    
$ActScriptString .= <<< END
QUI <br>
TAB PXCODE <br>
END;
    
    $DeActScriptString .= <<< END
QUI <br>
TAB PNSCRN <br>
END;
    
    
foreach ($odsentrylist as $post) {
    $source = $post['Odsentry']['source'];
    	$dest = $post['Odsentry']['dest'];
    
    	#$SriptString.='Source ID :' . $source . '   Dest ID : ' . $dest . ' / ';
    	$ActScriptString.= 'PUT VPNG ' . $source . ' ' . $source . ' RTE MM 9 9 TERM OVR2' . $adNumFirstDig .' ' . $adNumSecondLastDig . ' + <br>CLASS NATL AMAXLAID VPNAMA CONSUME 0 $ $ <br>';
		$DeActScriptString.='DEL ' . $source . '<br>';
    }
    
    
   $ActScriptString .= <<< END
	QUI <br>
    ';
    
    #---------------load wrapper script----------------------#<br>
require 'onDemandWrapper.pm';
END;
    
$DeActScriptString .= <<< END
QUI <br>
TAB PNINFO <br>

END;
   
   $DeActScriptString .= 'DEL 99' . $adNumPadded . $scenario_number . '<br>';
   
$DeActScriptString .= <<< END
QUI <br>';
   
#---------------load wrapper script----------------------#<br>
require 'onDemandWrapper.pm';
END;
    
    
    
        $this->Scenario->unBindModel(array('belongsTo' => array('Customer')));
    
            $dataarray = array();
    
            		$dataarray['Scenario']['id'] = $scenario_id;
            		$dataarray['Scenario']['Summary'] = $sriptSummary;
        #$dataarray['Scenario']['status'] = '99';
            		$dataarray['Scenario']['ActScript'] = $ActScriptString;
            				$dataarray['Scenario']['DeActScript'] = $DeActScriptString;
    
            						$this->Scenario->save($dataarray);
    
            						$scenariodetails = $this->Scenario->find('first', array('Conditions' => array('Scenario.id' => $scenario_id)));
    }
    

    //Function to check if Scenario is completed for not
    function ScenarioCompletedOrNot() {
        $this->layout = false;
        $scenario_id = isset($this->params['url']['scenario_id']) ? $this->params['url']['scenario_id'] : (isset($this->params['named']['scenario_id']) ? $this->params['named']['scenario_id'] : "");

        $getScenarioStatus = $this->Scenario->find('first', array('conditions' => array('Scenario.id' => $scenario_id), 'fields' => 'status'));

        $scenarioStatus = Configure :: read('scenarioStatus');

        $ScenarioCurrnetStatus = $scenarioStatus[$getScenarioStatus['Scenario']['status']];

        $odsEntryDestStatus = $this->Odsentry->find('all', array('conditions' => array('scenario_id' => $scenario_id, 'dest IS NULL')));   //$scenario_status = (count($odsEntryDestStatus) > 0) ? 'Incomplete' : $ScenarioCurrnetStatus;
					

        $scenario_status = (count($odsEntryDestStatus) == 0) ? 'Complete' : 'Incomplete';
		
		 $scenarionInactiveStatus = __($scenarioStatus['4'], true);
		
		if( $scenario_status=='Complete'){
			
			if($this->params['named']['status']== $scenarionInactiveStatus){
				
				echo $this->params['named']['status'] ;
			}
			else{
				echo $scenario_status;
			}
			
		}
		else{
			echo $scenario_status;
		}

        
        exit();
    }

    // Change Scenario Table scenario Status
    function SetScenarioStatus() {
        $this->layout = false;
        $scenario_id = isset($this->params['url']['scenario_id']) ? $this->params['url']['scenario_id'] : (isset($this->params['named']['scenario_id']) ? $this->params['named']['scenario_id'] : "");

        $odsEntryDestStatus = $this->Odsentry->find('all', array('fields' => 'Odsentry.*','conditions' => array('scenario_id' => $scenario_id, 'dest' => '')));
        $scenario_status = (count($odsEntryDestStatus) > 0) ? '1' : '2';
        
        //if()

        $DataArray = array();
        $DataArray['Scenario']['status'] = $scenario_status;
        $DataArray['Scenario']['id'] = $scenario_id;
        $this->Scenario->save($DataArray);
		echo $scenario_status;
        exit();
    }
    
    
    // Change Scenario Table scenario Status
    function setScenarioNumber($scenario_id) {
    	$this->layout = false;
    	#$scenario_id = isset($this->params['url']['scenario_id']) ? $this->params['url']['scenario_id'] : (isset($this->params['named']['scenario_id']) ? $this->params['named']['scenario_id'] : "");
    	$scenarioDetails = $this->Scenario->find('first', array('conditions' => array('Scenario.id' => $scenario_id)));
    	$customer_id= $scenarioDetails['Scenario']['customer_id'];
    	 
    	#Find count of all scenarios for customer.
    	 
    	$ScenarioNumbers = $this->Scenario->find('all',
    					array(
    						'fields' => array('Scenario.number'),
    						'conditions'=>array('Scenario.customer_id' => $customer_id, 
    											'Scenario.id !=' => $scenario_id, 
    											'NOT' => array('Scenario.number' => NULL))));
    	 
    	$scenNumbers = array();
    	$scenCount = count($ScenarioNumbers);
    	if($scenCount > 0)
    	{
    		foreach($ScenarioNumbers as $ScenarioNumber)
    		{
    			array_push($scenNumbers, $ScenarioNumber['Scenario']['number']);
    	
    		}
    		sort($scenNumbers);
    		$maxNumber = array_pop($scenNumbers);
    		$scenarioNumber = $maxNumber + 1;
    	}
    	else 
    	{
  
    		$scenarioNumber = 1;
    	}
    	 
    	
    	$this->log('SCENARIOS CONTROLLER : setScenarioNumber : MAX NUMBER : ' . $customer_id . ':' . $maxNumber, LOG_DEBUG);
    	
    	
    	$DataArray = array();
    	$DataArray['Scenario']['number'] = $scenarioNumber;
    	$DataArray['Scenario']['id'] = $scenario_id;
    	$this->Scenario->save($DataArray);
    	return($scenarioNumber);
    }

    function edittitles() {
        $this->layout = false;


        $scenerio_name = isset($this->params['name']['scenerio_name']) ? $this->params['url']['scenerio_name'] : (isset($this->params['named']['scenerio_name']) ? $this->params['named']['scenerio_name'] : "");

        $scenerio_id = isset($this->params['url']['scenerio_id']) ? $this->params['url']['scenerio_id'] : (isset($this->params['named']['scenerio_id']) ? $this->params['named']['scenerio_id'] : "");

         $this->Scenario->updateAll(
                array('Scenario.name' => "'" . $scenerio_name . "'"), array('Scenario.id' => $scenerio_id)
        );
        echo $scenerio_name;

        exit();
    }

    function edit_scenario_via_ajax() {
        $this->layout = false;
        $scenerio_name = trim($this->params['form']['value']);
        $scenerio_id = isset($this->params['url']['scenerio_id']) ? $this->params['url']['scenerio_id'] : (isset($this->params['named']['scenerio_id']) ? $this->params['named']['scenerio_id'] : "");

        $this->Scenario->updateAll(
                array('Scenario.name' => "'" . $scenerio_name . "'"), array('Scenario.id' => $scenerio_id)
        );
		

        exit();
    }
	
	
	
	/**
* 
* @Create editscenarioname function open overlay and update scenario Name ,groupDescription For Scenario
*
*/

	function editscenarioname($scenario_id = null){
		
		$this->layout="";
		$scenario_id = isset($this->params['url']['scenario_id']) ? $this->params['url']['scenario_id'] : (isset($this->params['named']['scenario_id']) ? $this->params['named']['scenario_id'] : "");
		
		$scenarioname = isset($this->params['url']['scenario_name']) ? $this->params['url']['scenario_name'] : (isset($this->params['named']['scenario_name']) ? $this->params['named']['scenario_name'] : "");
		
		$scenariodesc = isset($this->params['url']['scenariodesc']) ? $this->params['url']['scenariodesc'] : (isset($this->params['named']['scenariodesc']) ? $this->params['named']['scenariodesc'] : "");
		
		$this->set('scenario_id',$scenario_id);
		
		$scenarioname = utf8_decode($scenarioname);
		$scenariodesc = utf8_decode($scenariodesc);
		
		
		$scenarioDetails = $this->Scenario->find('first', array (
					'conditions' => array (
							'Scenario.id' => $scenario_id
							
					)
			));
			
			$this->set('scenarioDetails',$scenarioDetails);
	      
		if($scenarioname!=""){
				
				
		      echo $this->Scenario->updateAll(
                array('Scenario.name' => "'" . $scenarioname . "'",'Scenario.remark' => "'" . $scenariodesc . "'"), array('Scenario.id' => $scenario_id)
        );
		        
				$_SESSION['success'] = __('Scenario Name is updated successfully', true);
			//exit();	
		}
		//exit();	
	
	}

}

// End of Scenario Class
?>

