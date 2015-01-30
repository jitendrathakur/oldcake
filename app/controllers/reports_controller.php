<?php

#-----------------------------------------------------------------#
# $Rev:: 22            $:  Revision of last commit                #
#-----------------------------------------------------------------#

/**
 * Reports Controller
 *
 * file: /app/controllers/Reports_controller.php
 */

class CustomersController extends AppController {
	// good practice to include the name variable


	var $uses 	= array('Report', 'Customer', 'Location', 'Dns');
	var $name 	= 'Reports';
	
	var $paginate = array('Paginate' => 15, 'page' => 1);
	#var $paginate = array('Paginate' => 15, 'page' => 1, 'order' => array('Customer.name' => 'asc'));
	
	
	// load any helpers used in the views
	var $helpers = array('Html', 'Form', 'Javascript');

	
	function beforeFilter (){
		$this->Session->write('sel_customer','');
		parent::beforeFilter();
		
		if(!$this->Session->read('SELECTED_CUSTOMER')){
			$this->layout='ajax';
			$this->cakeError('sessionExpired'); 
		}
		
	}
	
	
	/**
	 * index()
	 * main index page of the formats page
	 * url: /formats/index
	 */
	function index() {
	
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
		$results = $this->Customer->find('all', array('conditions'=>$conds,'order'=>'created DESC','recursive'=>-1));
	  	$header_row = array("S.No.","Customer Name", "CNN ID", "BSK ID");
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
				$result['Customer']['bsk']
			);
			$i++;
			fputcsv($csv_file,$row,';','"');
		}
	
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
		$this->set('customerIds', $this->Customer->find('all'));
		$this->set('customer_val', $customer_val);
		
			
		
		#REPORTS DEFINITION
		
		
		 if(isset($_POST['customer']) && $_POST['customer'] != 'GLOBAL')
		 {
		 	
		 	#Station statistics - that are not glocal
		 	
			$this->set('stationTypeCount', $this->Station->find('all',
			array(
				'fields' => array(
				'Station.type', 
				'count(Station.type)'),  
				'group' => 'Station.type',
				'conditions' => array('Station.customer_id' => $customer_val))
			));
			
						# DNS.
			
			#$this->set('dnTypeCount', $this->Dn->find('all',
			#		array(
			#			'fields' => array(
			#				'Dn.function', 
			#				'count(Dn.function)'
			#			),  
			#			'group' => 'Dn.function'
			#		)
			#	)
			#);
			
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
			
			
			$this->set('groupTypeCount', $this->Dns->find('all',
			array(
				'fields' => array(
				'Dns.function', 
				'count(Dns.function)'),  
				'group' => 'Dns.function',
				'conditions' => array('Dns.function NOT' => array('INDIVIDUAL', ''), 'Location.customer_id' => $customer_val )
				)
			));
			
			#Analogue/CICM 
			$this->set('stationTypeCount', $this->Station->find('all',
			array(
				'fields' => array(
				'Station.type', 
				'count(Station.type)'),  
				'group' => 'Station.type',
				'conditions' => array('Station.customer_id' => $customer_val))
			));
			
			#Phone type
			$this->set('phoneTypeCount', $this->Station->find('all',
			array(
				'fields' => array(
				'Station.phone_type', 
				'count(Station.phone_type)'),  
				'group' => 'Station.phone_type',
				'conditions' => array('Station.customer_id' => $customer_val))
			));
			
			#SIMRING not ''
			$this->set('simTypeCount', $this->Station->find('all',
			array(
				'fields' => array(
				'Station.SIMRING', 
				'count(Station.SIMRING)'),  
				'group' => 'Station.SIMRING',
				'conditions' => array('Station.SIMRING !' => '', 'Station.customer_id' => $customer_val))
			));
			
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
			
			$this->set('custCount', $this->Customer->find('count',
					array(
						'conditions' => array('type !=' => 'Gate')
					)
				)
			);
			
			# ONB TOTAL.
			
			$this->set('onbCount', $this->Customer->find('count',
					array(
						'conditions' => array('type !=' => 'Gate', 'ONB' => '1')
					)
				)
			);
			
			# NSC TOTAL.
			
			$this->set('nscCount', $this->Customer->find('count',
					array(
						'conditions' => array('type !=' => 'Gate', 'NSC' => '1')
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
				'conditions' => array('Dns.function NOT' => array('INDIVIDUAL', ''))
				)
			));
			
			# DNS.
			
			#$this->set('dnTypeCount', $this->Dn->find('all',
			#		array(
			#			'fields' => array(
			#				'Dn.function', 
			#				'count(Dn.function)'
			#			),  
			#			'group' => 'Dn.function'
			#		)
			#	)
			#);
			
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
			
			#Analogue/CICM 
			$this->set('stationTypeCount', $this->Station->find('all',
			array(
				'fields' => array(
				'Station.type', 
				'count(Station.type)'),  
				'group' => 'Station.type')
			));
			
			#Phone type
			$this->set('phoneTypeCount', $this->Station->find('all',
			array(
				'fields' => array(
				'Station.phone_type', 
				'count(Station.phone_type)'),  
				'group' => 'Station.phone_type')
			));
			
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
			
			$this->set('logonCount', $this->Log->find('all',
			array(
				'fields' => array(
					'Log.customer_id', 
					'count(Log.id)'),  
				'group' => 'Log.customer_id',
				'conditions' => array('Log.log_entry' => 'User Logged In'))
			));
			
			
		 }
	}
}
?>
