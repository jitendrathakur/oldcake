<?php 
	$config['access_id']=99;
	
	$type='local';
	
	
	if($type=='local'){
		$config['base_url']='http://192.168.0.170/selfcare/';
		$config['upload_url']='/var/www/html/selfcare/app/webroot/files/';
		
	}else{
		$config['base_url']='http://selfcare.rainconcert.in/';
		$config['upload_url']='/home/selfcare/public_html/app/webroot/files/';	
	}
	
	
	
	$config['host']='192.168.0.170';
	$config['port']=98462;
	
	$config['NCOS-BARRINGSET']	=	array('no Set'=>'5','Set1'=>'3','Set2'=>'2','Set3'=>'1','Set4'=>'0','Set5'=>'4','Set6'=>'6','Set7'=>'7','Set8'=>'8','Set9'=>'9','Set10'=>'10','Set11'=>'11','Set12'=>'12','Set13'=>'13','Set14'=>'14','Set15'=>'15');
	$config['NCOS-LANGUAGE']	=	array('EN'=>'48','FR'=>'16','DE'=>'0','IT'=>'32');//must use caps alphabets for name eg:DE,FR
	$config['NCOS-LEADING']		=	array('LEADINGZERO'=>64,'no LEADINGZERO'=>0);
	
	$config['status']		=	array(1,2,3);
	
?>