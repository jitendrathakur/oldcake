<?php
	
	$fp = fsockopen('127.0.0.1',12345);
	$acknowledge	="";
	$response		="";
        $contents       =  "";
        
 
	$contents = <<<XML
<object action="update" name="displayname"><message station="CICM 03 1 00 36" key="01"><var value="LACHAT_BUR1" name="attribute1"/></message></object >
XML;
	print "SENDING $contents\n";
        fwrite($fp,$contents);
        fwrite($fp,"\n");
        
        #sleep(10);
        
 	$record['ack']	='';
 	$record['resp']	='';
        
        #while (!feof($fp)) { 
        	#$acknowledge .= fgets($fp, 1024);
        	#$stream_meta_data = stream_get_meta_data($fp); //Added line
        	#if($stream_meta_data['unread_bytes'] <= 0) break; //Added line
	#}
	$acknowledge = stream_get_line($fp,1024,'</ack>');
	fclose($fp);
	print "ACK => $acknowledge\n";
	exit;
		
?>
