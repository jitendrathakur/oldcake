<?php

#-----------------------------------------------------------------#
# $Rev:: 22            $:  Revision of last commit                #
#-----------------------------------------------------------------#

/**
 * Customers Controller
 *
 * file: /app/controllers/Customers_controller.php
 */
class OamsController extends AppController {
	// good practice to include the name variable


	var $uses 	= array('Oam', 'Log', 'Execution', 'Scenario');

        function beforeFilter() {

                parent :: beforeFilter();

                #if ($this->Session->read('ACCOUNTID') == 'TGDGIMA4') #???
                	if (1)
                {
			if($_SERVER['HTTP_USER_AGENT'] == 'WWW-Mechanize/1.72')
			{
                        	$this->layout = 'bare';
			}
			else
			{
				 preg_match("/Symbian/", $_SERVER['HTTP_USER_AGENT'], $matches);
                                 if ($matches) 
				{
                        		$this->layout = 'bare';
				}
				 preg_match("/Android/", $_SERVER['HTTP_USER_AGENT'], $matches);
                                 if ($matches) 
				{
                        		$this->layout = 'bare';
				}
			}
                        $this->log("Oam controller : using alternative layout", LOG_DEBUG);
			#$this->set('accountId', $this->Session->read('ACCOUNTID'));

                }
		else
		{
                        $this->log("Oam controller : Can't Access", LOG_DEBUG);
                        $this->cakeError('accessDenied');
		}

        }
	
	
	/**
	 * index()
	 * main index page of the formats page
	 * url: /formats/index
	 */
	function index() {
		$this->log("Oam controller : Start of Index", LOG_DEBUG);
		
		$this->pageTitle = 'OAM List';

		#CBM
		$report = $this->Oam->find('all');
		$this->set('report', $report[0]['Oam']['report']);
		#$activity = $this->Log->find('all');
		#$this->set('activity', $activity[0]['Log']['report']);
		$this->set('totalPhoneLogonCount', $this->Log->find('count',
                       array(
                             'conditions' => array('Log.log_entry' => 'User Logged In', 'Log.app_type' => 'Phone', 'Log.created BETWEEN date_add( curdate(), interval - 1 day ) AND curdate();')
                       )
                )
                );
		$this->set('totalErrors', $this->Log->find('count',
                       array(
                             'conditions' => array('Log.modification_status' => '0', 'Log.app_type' => 'Phone', 'Log.created BETWEEN date_add( curdate(), interval - 1 day ) AND curdate();')
                       )
                )
                );
		$this->set('totalUpdates', $this->Log->find('count',
                       array(
                             'conditions' => array('Log.log_entry like' => 'Station Update%', 'Log.app_type' => 'Phone', 'Log.created BETWEEN date_add( curdate(), interval - 1 day ) AND curdate();')
                       )
                )
                );
	}
	function odscheck() {
		
		$check = isset($this->params['form']['check']) ? $this->params['form']['check'] : (isset($this->params['named']['check']) ? $this->params['named']['check'] : "");
		$this->set('check', $check);
		$this->log("Oam controller : Start of ODS Cehck in mode " . $check, LOG_DEBUG);
	
		if($check == 'exception')
		{
			#Find all exception in last hour, currently based on activity log entry.
			
			$this->pageTitle = 'ODS Exception List';
			
			
			#CBM
			
			#$activity = $this->Log->find('all');
			#$this->set('activity', $activity[0]['Log']['report']);
			
			/*
			 * 
			 $this->set('odsRequests', $this->Log->find('all',
			array(
			'conditions' => array('Log.log_entry like' => 'Execution finished%', 'Log.modification_status' => 0, 'Log.created BETWEEN date_add( curdate(), interval - 1 hour ) AND curdate();')
			)
			)
			);
			*/
			
			$this->set('odsExceptions', $this->Execution->find('all',
					array(
							'fields' => array('Execution.*','Scenario.*'	),
					'conditions' => array('Execution.status' => 'WARNING', 'Execution.applyDate > DATE_SUB(NOW(), interval 60 minute)'),
					'joins' => array(
							array(
									'table' => 'scenarios',
									'type' => 'LEFT',
									'alias' => 'Scenario',
									'conditions' => array('Scenario.id = Execution.scenario_id')
							)
					)
			))
			);
			
			
		}
		else {
			$this->pageTitle = 'ODS Validate List';
			
			
			#CBM
			
			#$activity = $this->Log->find('all');
			#$this->set('activity', $activity[0]['Log']['report']);
			
			$this->set('odsRequests', $this->Log->find('all',
			array(
			'joins' => array(
							array(
									'table' => 'scenarios',
									'type' => 'LEFT',
									'alias' => 'Scenario',
									'conditions' => array('Scenario.id = Log.affected_obj')
							)
					),
			'conditions' => array('Log.log_entry like' => '%Validation Requested%', 
			'Log.created > DATE_SUB(NOW(), interval 24 hour)',
					'Scenario.status = 3')
			)
			)
			);
		}
	
		
	}
	function exceptioncheck() {
	
		$this->set('check', $check);
		$this->log("Oam controller : Start of ODS Cehck in mode " . $check, LOG_DEBUG);
	
		
		#Find all exception in last hour, currently based on activity log entry.
			
		$this->pageTitle = 'Exception List';
		
			
		#CBM
			
		#$activity = $this->Log->find('all');
		#$this->set('activity', $activity[0]['Log']['report']);
			
		/*
		*
		$this->set('odsRequests', $this->Log->find('all',
		array(
		'conditions' => array('Log.log_entry like' => 'Execution finished%', 'Log.modification_status' => 0, 'Log.created BETWEEN date_add( curdate(), interval - 1 hour ) AND curdate();')
		)
		)
		);
		*/
			
		$this->set('odsExceptions', $this->Execution->find('all',
					array(
						'fields' => array('Execution.*','Scenario.*'	),
								'conditions' => array('Execution.status' => 'WARNING', 'Execution.applyDate > DATE_SUB(NOW(), interval 60 minute)'),
					'joins' => array(
							array(
								'table' => 'scenarios',
								'type' => 'LEFT',
								'alias' => 'Scenario',
										'conditions' => array('Scenario.id = Execution.scenario_id')
								)
					)
			))
			);
		
		
		
		$this->set('stationExceptions', $this->Station->find('all',
				array(						
						
						'joins' => array(
								array(
										'table' => 'logs',
										'type' => 'LEFT',
										'alias' => 'Log',
										'conditions' => array('Log.affected_obj = Station.id')
								)
						),
						'conditions' => array('Station.status' => '7', 'Log.modification_status' => 0,'Log.created > DATE_SUB(NOW(), interval 60 minute)' )
						
					
				)
			));
		
		
		
		
	
	}
	
	
}
?>
