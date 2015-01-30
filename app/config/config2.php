

<?php 

#-----------------------------------------------------------------#
# $Rev:: 26            $:  Revision of last commit                #
#-----------------------------------------------------------------#

	$type='local'; # Change to the current environment.
	
	
	if($type=='local'){
		$config['base_url']='http://localhost/voipphoneRE3/';
		$config['base_path']='/var/www/html/voipphoneRE3/';
		$config['gate_url']='http://192.168.75.130/voipgate/';
		$config['xmlengine_url']='http://176.28.15.224/voipphoneRE3/';
		$config['upload_url']='../webroot/files/upload/';
		$config['access_id']=99;
		$config['host']='176.28.15.224';
		$config['port']=12345;
		$config['activate_mode']='STUB';
	}
	if($type=='test'){
		$config['base_url']='http://176.28.15.224/voipphoneRE3/';
		$config['base_path']='/var/www/html/voipphoneRE3/';
		$config['gate_url']='http://176.28.15.224/voipgateRE3/';
		$config['xmlengine_url']='http://176.28.15.224/voipphoneRE3/';
		$config['upload_url']='../temp/';
		$config['access_id']=99;
		$config['host']='83.169.17.183';
		$config['port']=12345;
		$config['activate_mode']='STUB';
	}
	if($type=='preprod'){
		$config['base_url']='/voipphone/';
		$config['base_path']='/var/www/html/voipphoneRE3/';
		 $config['gate_url']='/voipgate/';
		$config['upload_url']='../temp/';
		$config['access_id']=57397911;
		$config['host']='172.22.26.4';
		$config['port']=12345;
		$config['activate_mode']='LIVE';
	}
	if($type=='preprod_volume'){
		$config['base_url']='/voipphone_volume/';
		$config['base_path']='/var/www/html/voipphone_volume/';
		$config['gate_url']='/voipgate/';
		$config['upload_url']='/var/www/html/voipphone_volume/app/temp_files/';
		$config['access_id']=57397911;
		$config['host']='172.22.26.4';
		$config['port']=12345;
		$config['activate_mode']='LIVE';
	}
	if($type=='prod'){
		$config['base_url']='/voipphone/';
		 $config['gate_url']='/voipgate/';
		$config['upload_url']='/var/www/html/voipphone/app/temp_files/';
		$config['access_id']=57397911;
		$config['host']='172.23.26.4';
		$config['port']=12345;
		$config['activate_mode']='LIVE';
	}
	

	$config['NCOS-BARRINGSET']	=	array('no Set'=>'5','Set1'=>'3','Set2'=>'2','Set3'=>'1','Set4'=>'0','Set5'=>'4','Set6'=>'6','Set7'=>'7','Set8'=>'8','Set9'=>'9','Set10'=>'10','Set11'=>'11','Set12'=>'12','Set13'=>'13','Set14'=>'14','Set15'=>'15');
//	$config['NCOS-LANGUAGE']	=	array('en'=>'48','fr'=>'16','ge'=>'0','IT'=>'32');
	$config['NCOS-LANGUAGE']	=	array('EN'=>'48','FR'=>'16','DE'=>'0','IT'=>'32');//must use caps alphabets for name eg:DE,FR
	//$config['NCOS-LEADING']		=	array('LEADINGZERO'=>64,'no LEADINGZERO'=>0);
	$config['NCOS-LEADING']		=	array('1'=>'64','0'=>'0');
	 $config['status']              =       array(1,2,3);
	$config['stationStatus']              =       array('1'=>'Active', '2'=>'Imported', '3'=>'Discovered', '4'=>'test','5'=>'InWork','6'=>'Added','7'=>'Exception', '8'=>'SpecialConfig'  );
    $config['featureStatus']              =       array('1'=>'Active', '2'=>'Imported', '3'=>'Discovered', '4'=>'InWork', '5'=>'Moved','6'=>'Added', '7'=>'Deleted', '8'=>'Replaced', '9'=>'NotSupported');
    $config['scenarioStatus']              =       array('1'=>'Incomplete', '2'=>'Complete', '3'=>'Validate', '4'=>'Inactive', '5'=>'InProgress','6'=>'Active', '7'=>'Exception', '8'=>'Rejected');
    $config['dnsStatus']              =       array('1'=>'Active', '2'=>'Imported', '3'=>'Discovered', '4'=>'InWork',  '5'=>'InProgress',  '6'=>'InReview');
    $config['groupStatus']              =       array('1'=>'Active', '2'=>'Imported', '3'=>'Discovered', '4'=>'InWork');
   $config['leaveStatus']              =       array('off'); //array('on');array('off');
    
    $config['language'] = array('deu' => 'German', 'eng' => 'English', 'fre' => 'France', 'ita' => 'Italy');
	$config['selectnumber'] = array(20);
	$config['maxDataLimit'] = '10';
	//$config['backEndMode'] = 'REMOTE'; # used in testing to drive changes via HE5
	$config['re3users']              =       array('tgdgima4'=>'RE3', 'taamacr1'=>'RE3');
	$config['activationusers']              =       array('tgdgima4'=>'RE3', 'taamacr1'=>'RE3');
	$config['re3bsks']              =       array('123'=>'RE3', '99'=>'RE3');
	
?>

