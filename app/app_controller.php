<?php


#-----------------------------------------------------------------#
# $Rev:: 21            $:  Revision of last commit                #
#-----------------------------------------------------------------#

/**
 * class AppController
 *
 */
class AppController extends Controller {

	// class variables
	var $_Filter = array ();

	// setup components
	var $components = array (
		'Filter',
		'AutoPaginate',
		'Authentication',
		'FileUpload'
	);
	// default datetime filter
	var $_Form_options_datetime = array ();
	var $helpers = array (
		'Html',
		'Form',
		'Javascript',
		'Session'
	);
	var $uses = array (
		'Station',
		'Stationkey',
		'Feature',
		'Location',
		'Log',
		'Customer'
	);
	//var $layout = 'default';

	/**
	 * Before any Controller action
	 */
	function beforeFilter() { //echo session_save_path();die();
		$cameFrom = $this->here;
	    $this->log('APP CONTROLLER : Start of before_filter, came from : ' . $cameFrom , LOG_DEBUG);
	    
	    $re3users = Configure :: read('re3users');
            $re3bsks = Configure :: read('re3bsks');
		$userArray = print_r($re3users , true);
		$this->log('APP CONTROLLER : RE3 users array :' .  $userArray , LOG_DEBUG);
	#	$re3users              =       array('TGDGIMA4', 'TAAMACR1', 'TGDWEJU6');
	    

	    #Add a bypass for all of the pages that don't require authenticaiton
	    
	    preg_match("/\/xmlengines\/|\/oams\//", $cameFrom, $matches);
	    if ($matches[0]) {
	    	$this->log('APP CONTROLLER : EXITING BEFORE FILTER FOR URL  ' . $cameFrom, LOG_DEBUG);
	    	#exit;
	    	return;
	    }
	    
	    
	    
	    
	    #Load XML Handler
	    
	    App::import('Vendor', 'array2xml');
	    
	    
	    #--------------Security Check for XSS -------------
	    $sec_uri = $this->params['pass'];
	    #$sec_ul = $this->params['url'];
	    $this->log('APP CONTROLLER : PAssed URI' . $sec_uri[0], LOG_DEBUG);
	    
	    #$secItems = explode('/', $ul['url']);
		#$url_array=print_r($for_sort, true);
		foreach($sec_uri as $uriCheckItem)
	    {
	    	$this->log('APP CONTROLLER : CHECKING URI' . $uriCheckItem, LOG_DEBUG);
	    	if(preg_match('/^[\w-@]+$/', $uriCheckItem) && ( strlen($uriCheckItem) < 15))

	    	{
	    			$this->log('APP CONTROLLER : VALID URI' . $uriCheckItem, LOG_DEBUG);
	    	}	
	    	else
	    	{
	    			$this->log('APP CONTROLLER : INVALID URI' . $uriCheckItem, LOG_DEBUG);
	    			$this->log('INVALID URI : ' . $uriCheckItem);
	    			$this->cakeError('accessDenied');
	    			$this->redirect('/customers');
	    	}
	    }
	    
			#if (isset ($uri[0]))
			#	$url = $uri[0];
			#else
			#	$url = '';
			#if (empty ($url)) {
			#	$url = '/';
			#}
						
   		#----------------End Security Check-----------------
	    

		// keep the debug log in in the debug file
		#foreach ($_SERVER as $key => $value) {

			#$this->params[$key] = $value;
		#}
		#$this->log($this->params, LOG_DEBUG);
		//echo $this->Session->read('SELECTED_CUSTOMER');die();
		//$this->Session->write('SELECTED_CUSTOMER',169572);	die();

		if ((!$this->Session->read('SELECTED_CUSTOMER')) || (!$this->Session->read('APPNAME')) || ($this->Session->read('APPNAME') == '')) {
			$this->log('APP CONTROLLER : NOT SET : SELECTED_CUSTOMER -> ' . $this->Session->read('SELECTED_CUSTOMER') . ' OR  APPNAME -> ' .$this->Session->read('APPNAME') , LOG_DEBUG);

			// check the authentication
			$value = $this->Authentication->authenticate();
			
			#???Hack to switch users to RE2.

			#if(($re3bsks[$value['user_id']] == 'RE3') || ($re3users[$value['ACCOUNTNAME']] == 'RE3'))
                        #{
                                $this->log('APP CONTROLLER : RE3 BSK ->' . $value['user_id'] , LOG_DEBUG);
                        #}
                        #else
                        #{
                                #$this->log('APP CONTROLLER : RE2 BSK ->' . $value['user_id'] , LOG_DEBUG);
                                #$this->redirect('https://extranet.swisscom.ch/voipphoneRE2');
                                #$this->redirect('http://176.28.15.224/voipphoneRE3/customers');

                        #}

		

			/**************activity log*****************/

			#$log_string	= date('Y-m-d H:i:s') .' Activity :'.$value['user_id'].' || '.$value['USERNAME'].' | Logged on ||'	;
			$log_string = $value['user_id'] . ' || ' . $value['USERNAME'] . ' | Logged on ||';

			$this->log($log_string, 'activity');

			/**************activity log*****************/

			//$this->log('Logged by user '. $value['USERNAME'].' and id is '.$value['user_id'], 'activity');	

			$this->Session->write('SELECTED_CUSTOMER', $value['user_id']);
			$this->Session->write('ACCOUNTID', $value['ACCOUNTID']);
			$this->Session->write('ACCOUNTNAME', $value['ACCOUNTNAME']);
			$this->Session->write('USERNAME', $value['USERNAME']);
			$this->Session->write('USERFIRSTNAME', $value['USERFIRSTNAME']);
			$this->Session->write('ORGANIZATION', $value['ORGANIZATION']);
			$this->set('userpermission', $this->Session->read('SELECTED_CUSTOMER'));
			$this->set('userid', $this->Session->read('ACCOUNTNAME'));
			#$_SESSION['Config']['language'] = $value['lang'];
			$_SESSION['Config']['language'] = strtolower($value['lang']);
			$this->Session->write('APPNAME', $value['APPNAME']);
			#$this->log('APP CONTROLLER : SETTING APPNAME -> ' . $value['APPNAME'], LOG_DEBUG);
			$this->log('APP CONTROLLER : SETTING APPNAME ->' . $value['APPNAME'] , LOG_DEBUG);

			#Find all customer records with matching BSK and matching tyoe to the application accessed
			if ($value['user_id']) 
			{
				$record = $this->Customer->find('all', array (
					'conditions' => array (
						"Customer.status" => array (
							1,
							2,
							3
						),
						'Customer.bsk' => $value['user_id']
					)
				));
				#$this->log("vAR HERE0", LOG_DEBUG);	
				if (empty ($record) && Configure :: read('access_id') != $value['user_id']) 
				{
					#$this->log("Some one trying to loggin with id ".$value['user_id']);
					$this->log("APP Controller : Invalid SSO data " . $value['user_id']);
					$this->layout = 'ajax';
					$this->cakeError('accessDenied');
					#$this->log("vAR HERE1", LOG_DEBUG);	
				} else 
				{
					    /**
						* 
						* @var get browser details
						* 
						*/
													 $u_agent = $_SERVER['HTTP_USER_AGENT'];
							    $bname = 'Unknown';
							    $platform = 'Unknown';
							    $version= "";

							    //First get the platform?
							    if (preg_match('/linux/i', $u_agent)) {
							        $platform = 'linux';
							    }
							    elseif (preg_match('/macintosh|mac os x/i', $u_agent)) {
							        $platform = 'mac';
							    }
							    elseif (preg_match('/windows|win32/i', $u_agent)) {
							        $platform = 'windows';
							    }
							   
							    // Next get the name of the useragent yes seperately and for good reason
							    if(preg_match('/MSIE/i',$u_agent) && !preg_match('/Opera/i',$u_agent))
							    {
							        $bname = 'Internet Explorer';
							        $ub = "MSIE";
							    }
								elseif(strpos($_SERVER['HTTP_USER_AGENT'], 'Trident/7.0; rv:11.0') !== false){
									$bname = 'Internet Explorer';
							        $ub = "MSIE";
								}
							    elseif(preg_match('/Firefox/i',$u_agent))
							    {
							        $bname = 'Mozilla Firefox';
							        $ub = "Firefox";
							    }
							    elseif(preg_match('/Chrome/i',$u_agent))
							    {
							        $bname = 'Google Chrome';
							        $ub = "Chrome";
							    }
							    elseif(preg_match('/Safari/i',$u_agent))
							    {
							        $bname = 'Apple Safari';
							        $ub = "Safari";
							    }
							    elseif(preg_match('/Opera/i',$u_agent))
							    {
							        $bname = 'Opera';
							        $ub = "Opera";
							    }
							    elseif(preg_match('/Netscape/i',$u_agent))
							    {
							        $bname = 'Netscape';
							        $ub = "Netscape";
							    }
							   
							    // finally get the correct version number
							    $known = array('Version', $ub, 'other');
							    $pattern = '#(?<browser>' . join('|', $known) .
							    ')[/ ]+(?<version>[0-9.|a-zA-Z.]*)#';
							    if (!preg_match_all($pattern, $u_agent, $matches)) {
							        // we have no matching number just continue
							    }
							   
							    // see how many we have
							    $i = count($matches['browser']);
							    if ($i != 1) {
							        //we will have two since we are not using 'other' argument yet
							        //see if version is before or after the name
							        if (strripos($u_agent,"Version") < strripos($u_agent,$ub)){
							            $version= $matches['version'][0];
							        }
							        else {
							            $version= $matches['version'][1];
							        }
							    }
							    else {
							        $version= $matches['version'][0];
							    }
							   
							    // check if we have a number
								if(strpos($u_agent, 'Trident/7.0; rv:11.0') !== false){
									$bname = 'Internet Explorer';
							        $ub = "MSIE";
									
									$browserString = end(explode(':',$u_agent));
							       $versionString = explode(')', $browserString);
							      $version = $versionString[0];
								}
							    if ($version==null || $version=="") {$version="?";}
								
							   
							   /**  end browserdetails*/
                                
                               $yourbrowser= "browser: " . $bname . " " . $version ;
							  
                       			$insert = array(
                       			'Log' => array(
               		        	'log_entry'   =>    'User logged in',
								'log_details' =>$yourbrowser . ':' . $u_agent,
                       			'slug'   =>    '',
               		        	'created'              =>   date('Y-m-d H:i:s'),
               	        		'modified'              =>   date('Y-m-d H:i:s'),
                       			'status'               =>      1,
                       			'modification_status'               =>      '1',
               	        		'modification_response'               =>      ' ',
                       			'bsk'  =>      $this->Session->read('SELECTED_CUSTOMER'),
               	        		'customer_id'     =>     $record[0]['Customer']['id'],
                       			'affected_obj'     =>      '',
			      		'user'	=>	$this->Session->read('ACCOUNTNAME'),
		         		'app_type'	=> $value['APPNAME']	
		                   
      					)
					);
			
					$this->Log->create();
					$this->Log->save($insert,false);


					if ($value['user_id'] == Configure :: read('access_id')) {
						$this->log("App controller : Internal user redirecting to Customers", LOG_DEBUG);
						$this->redirect('/customers');
						
					} else {
						if ($value['APPNAME'] == 'Phone')
						{
							
						$this->log("App controller : Phone access : no session(selected_customer)", LOG_DEBUG);
						#$this->redirect('/dns/viewdns/customer_id:' . $record[0]['Customer']['id']);
						$this->redirect('/customers/edit/customer_id:' . $record[0]['Customer']['id']);
						}
						elseif ($value['APPNAME'] == 'Gate')			
						{
							$this->log("App controller : Gate access : no session(selected_customer)", LOG_DEBUG);
							$this->redirect('/scenarios/index/customer_id:' . $record[0]['Customer']['id']);
						}
					}
				}
			}
		}
		
		#To get here user should already have a session. To check for users who have 

		 #???Hack to switch users to RE2.
		#if(($re3bsks[$this->Session->read('SELECTED_CUSTOMER')] == 'RE3') || ($re3users[$this->Session->read('ACCOUNTNAME')] == 'RE3'))
                #{
                        $this->log('APP CONTROLLER : RE3 BSK ->' . $this->Session->read('SELECTED_CUSTOMER') , LOG_DEBUG);

                #}
                #else
                #{
                        #$this->log('APP CONTROLLER : RE2 BSK ->' . $this->Session->read('SELECTED_CUSTOMER'), LOG_DEBUG);
                        #$this->redirect('http://176.28.15.224/voipphoneRE3/customers');
                        #$this->redirect('https://extranet.swisscom.ch/voipphoneRE2');

                #}


	
	
		
		$this->log("App controller : Has selected customer session  " . $this->Session->read('APPNAME') . ' APP', LOG_DEBUG);	
		#If There is already a sessio then continue here. 
		$this->set('userpermission', $this->Session->read('SELECTED_CUSTOMER'));
		$this->set('userid', $this->Session->read('ACCOUNTNAME'));
		// for index actions
		if ($this->action == 'index' || $this->action == 'index1' || $this->action == 'viewlog' || $this->action == 'viewdns' || $this->action == 'numbergroups'||$this->action == 'pickupgroups') {
			
			$this->log('App controller : Index action', LOG_DEBUG);

			// setup filter component
			$this->_Filter = $this->Filter->process($this);

			//$url = $this->Filter->url;
			$uri = $this->params['pass'];
			if (isset ($uri[0]))
				$url = $uri[0];
			else
				$url = '';
			if (empty ($url)) {
				$url = '/';
			}
						
		
			$ul = $this->params['url'];
			
			$for_sort = explode('/', $ul['url']);
			#$url_array=print_r($for_sort, true);
			#$this->log('App controller : URL PARAMS ' . $url_array, LOG_DEBUG);

			$this->set('filter_sort', $for_sort);

			/*if(in_array('direction:asc',$for_desc))
			
			
			if(in_array('direction:asc',$for_desc))
			$this->set('filter_options',array('url'=>array($url), 'id'=>'sortlink_asc'));
			elseif (in_array('direction:desc',$for_desc))
			$this->set('filter_options',array('url'=>array($url), 'id'=>'sortlink_desc'));
			else */

			$this->set('filter_options', array (
				'url' => array (
					$url
				),
				'id' => 'sortlink'
			));
			
			$this->set('filter_ur', trim($url, '/'));

			if (isset ($this->data['reset']) || isset ($this->data['cancel'])) {
				$this->log("App controller : redircting to index page.", LOG_DEBUG);
				$this->redirect(array (
					'action' => 'index'
				));
			}
			$this->log("App controller : End before filter  ", LOG_DEBUG);
		}
	}

	/**
	 * Builds up a selected datetime for the form helper
	 * @param string $fieldname
	 * @return null|string
	 */
	function process_datetime($fieldname) {
		$selected = null;
		if (isset ($this->params['named'][$fieldname])) {
			$exploded = explode('-', $this->params['named'][$fieldname]);
			if (!empty ($exploded)) {
				$selected = '';
				foreach ($exploded as $k => $e) {
					if (empty ($e)) {
						$selected .= (($k == 0) ? '0000' : '00');
					} else {
						$selected .= $e;
					}
					if ($k != 2) {
						$selected .= '-';
					}
				}
			}
		}
		return $selected;
	}
	
	
	function convertToJQueryDate($str){
	  
	  if($str!=""){
	    $strArr=explode("-",$str);
	    if(count($strArr)==3){
		$strArr[2] = "0".$strArr[2];
	      return $strArr[2]."/".$strArr[1]."/".$strArr[0];
	    }
	  }
	  return $str;

	}
	
	
	/*_____________________________________________________________________________
	Function:	covertToSystemDate
	*	@param:	$date  dd/MM/YYYY
	*/
	function convertToSystemDate($date){
	  $dateArr=explode("/",$date);
	  $newDate="";
	  if(in_array("",$dateArr)){
	    return $newDate;
	  }
	  if(count($dateArr)==3){
	    return $newDate=$dateArr[2]."-".$dateArr[1]."-".$dateArr[0];
	  }
	  return $newDate;

      
	}
	/**
	 * ***********fucntion to get browser details begins
	 *
	 * @return
	 */
	function getBrowser()
	{
		$u_agent = $_SERVER['HTTP_USER_AGENT'];
		$bname = 'Unknown';
		$platform = 'Unknown';
		$version= "";
	
		//First get the platform?
		if (preg_match('/linux/i', $u_agent)) {
			$platform = 'linux';
		}
		elseif (preg_match('/macintosh|mac os x/i', $u_agent)) {
			$platform = 'mac';
		}
		elseif (preg_match('/windows|win32/i', $u_agent)) {
			$platform = 'windows';
		}
		 
		// Next get the name of the useragent yes seperately and for good reason
		if(preg_match('/MSIE/i',$u_agent) && !preg_match('/Opera/i',$u_agent))
		{
			$bname = 'Internet Explorer';
			$ub = "MSIE";
		}
		elseif(preg_match('/Firefox/i',$u_agent))
		{
			$bname = 'Mozilla Firefox';
			$ub = "Firefox";
		}
		elseif(preg_match('/Chrome/i',$u_agent))
		{
			$bname = 'Google Chrome';
			$ub = "Chrome";
		}
		elseif(preg_match('/Safari/i',$u_agent))
		{
			$bname = 'Apple Safari';
			$ub = "Safari";
		}
		elseif(preg_match('/Opera/i',$u_agent))
		{
			$bname = 'Opera';
			$ub = "Opera";
		}
		elseif(preg_match('/Netscape/i',$u_agent))
		{
			$bname = 'Netscape';
			$ub = "Netscape";
		}
		 
		// finally get the correct version number
		$known = array('Version', $ub, 'other');
		$pattern = '#(?<browser>' . join('|', $known) .
		')[/ ]+(?<version>[0-9.|a-zA-Z.]*)#';
		if (!preg_match_all($pattern, $u_agent, $matches)) {
			// we have no matching number just continue
		}
		 
		// see how many we have
		$i = count($matches['browser']);
		if ($i != 1) {
			//we will have two since we are not using 'other' argument yet
			//see if version is before or after the name
			if (strripos($u_agent,"Version") < strripos($u_agent,$ub)){
				$version= $matches['version'][0];
			}
			else {
				$version= $matches['version'][1];
			}
		}
		else {
			$version= $matches['version'][0];
		}
		 
		// check if we have a number
		if ($version==null || $version=="") {$version="?";}
		 
		return array(
				'userAgent' => $u_agent,
				'name'      => $bname,
				'version'   => $version,
				'platform'  => $platform,
				'pattern'    => $pattern
		);
	}
	
	// now try it
	//$ua1=$this->getBrowser();
	//$yourbrowser= "Your browser: " . $ua['name'] . " " . $ua['version'] . " on " .$ua['platform'] . " reports: <br >" . $ua['userAgent'];
	//$yourbrowser= "browser: " . $ua['name'] . " " . $ua['version'] ;
	//print_r($yourbrowser);
	
	/**
	 * ***********fucntion to get browser details Ends Here
	 *
	 * @return
	 */
	
	
	/**
	 * Before any Controller action
	 */

}
?>
