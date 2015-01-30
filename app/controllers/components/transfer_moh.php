<?php

#-----------------------------------------------------------------#
# $Rev:: 22            $:  Revision of last commit                #
#-----------------------------------------------------------------#


// file: /app/controllers/components/transferMoH.php
/**
 * Function to transfer files to MoH server component
 *
 * @Author 4-Sol Ltd
 * @version 0.1
 */
class TransferMohComponent extends Object {
function uploadMoH($fileName, $userID)
{

	$this->log('MOH =>' . 'Uploading file ' . $fileName . 'USer ID' . $userID, LOG_DEBUG);
	#return "$fileName";
    	if(!file_exists($fileName))
	{
		$this->log('MOH =>' . 'FILE NOT FOUND', LOG_DEBUG);
		return "FILE NOT FOUND";
	}

	### Perform Virusscan ####

        exec("/usr/bin/clamscan $fileName 2>&1", $virusOut, $virusRetVal);
        if($virusRetVal > 0) #CBM TEST
        #if($virusRetVal > 100000000000)
        {
		#$this->log('MOH => Infected File : ', LOG_DEBUG);
		$this->log('MOH => Infected File : ' . $fileName . ':' .  $virusRetVal . $virusOut[0] . $virusOut[1] . $virusOut[2] .$virusOut[3] .$virusOut[4] .$virusOut[5] .$virusOut[6], LOG_DEBUG);
                return "Infected File";
        }


        ### Perform conversion ###
	$path_info = pathinfo($fileName); 
	$ext = $path_info['extension']; 

        $pos = '.'.$ext;
        $conFileName = str_ireplace($pos, 'conv.wav',$fileName);
        exec("/usr/local/bin/ffmpeg -y -i $fileName -ar 8000 -ac 1 -acodec pcm_alaw $conFileName", $convOut, $convRetVal);
        if($convRetVal > 0)
        {
		$this->log('MOH =>' . 'File Conversion Failed', LOG_DEBUG);
		return "File Conversion Failed";
        }
        else
        {
                $fileName = $conFileName;
        }



	$transferStatusString = $this->transferMoH($fileName);
	$transferStatus = (int)$transferStatusString;
	
	#If success then perform a prepare or else return with message
	
	if (is_int($transferStatus))
	{
		$this->log('MOH =>' . 'TRANSFER STATUS => ' . $transferStatus, LOG_DEBUG);
		#print "TRANSFER SUCCESS ID => $transferStatus..";
	
		#Now try prepare
		
		$prepareStatus = $this->prepareMoH($transferStatus);
	
		#If success then perform and assign.
	
		if ($prepareStatus == 1)
		{
			#print "PREPARE SUCCESS  => $prepareStatus..";
			$this->log('MOH =>' . 'PREPARE SUCCESS', LOG_DEBUG);
	
			#Now assign the file
			$assignStatus = $this->assignMoH($transferStatus, $userID);
			if ($assignStatus == 1)
			{
				$this->log('MOH =>' . 'ASSIGN SUCCESS', LOG_DEBUG);
				#print "ASSIGN SUCCESS => $assignStatus...\n";
				return 1;
			}
			else
			{
				$this->log('MOH =>' . 'ASSIGN ERROR => ' . $assignStatus, LOG_DEBUG);
				print "ASSIGN FAILED..($assignStatus\n";
				return 0;
				return "File not asigned: : $prepareStatus";
	
			}
		}
		else
		{
			$this->log('MOH =>' . 'PREPARE ERROR => ' . $prepareStatus, LOG_DEBUG);
			print "PREPARE ERROR => $prepareStatus\n";
			return "File not valid : $prepareStatus";
		}
	}
	else
	{
		$this->log('MOH =>' . 'TRANSFER ERROR => ' . $transferStatus, LOG_DEBUG);
		print "STATUS ERROR => $transferStatus";
		#return "$transferStatus";
		return "File transfer failed.";
	}
}
	
function transferMoH ($fileName) {

$reqPayloadString = <<<XML
<ns1:addFile xmlns:ns1="http://application.webservices.engine.application.vas.ctmodule.com/">
<applicationInstanceID>1</applicationInstanceID>
<fileData>
<xop:Include xmlns:xop="http://www.w3.org/2004/08/xop/include" href="cid:myid1">
</fileData>
</ns1:addFile>
XML;

	try {
    	$f = file_get_contents($fileName);
	
    	// here in the attachments option we define the binaries
    	// corresponding to the id defined in the above XML
    	$reqMessage = new WSMessage($reqPayloadString,
                                	array("to" => "http://172.23.4.10/VAS2_Engine/Application",
                                      	"attachments" => array("myid1" => $f)));
	
    	// creating the WSClient
    	// here the option useMTOM will decide whether the
    	// attachment is set MTOM or base64
    	$client = new WSClient(array("useSOAP" => "1.1",
                                 	"useMTOM" => TRUE));
	
    	// sending the message and retrieving the response
    	$resMessage = $client->request($reqMessage);
	
    	#printf("Response = %s \\n", $resMessage->str);
	$fileID =  $resMessage->str;

	$xml = new SimpleXMLElement( $resMessage->str);

	#echo $xml->movie[0]->plot;

	#CBM Modified for debug
	return $xml->return;
	
	} catch (Exception $e) {
	
    		if ($e instanceof WSFault) {
        		printf("Soap Fault: %s\\n", $e->Reason);
			return $e->Reason;
    		} else {
        		printf("Message = %s\\n",$e->getMessage());
			return $e->getMessage();
    		}
	}
}
function prepareMoH ($fileID) {

$reqPayloadString = <<<XML
<ns1:executeOperation xmlns:ns1="http://application.webservices.engine.application.vas.ctmodule.com/">
<applicationInstanceID>1</applicationInstanceID>
<operationName>prepare</operationName>
         <params>
            <key>fileID</key>
            <value>$fileID</value>
         </params>
</ns1:executeOperation>
XML;

	try {
	
 	$reqMessage = new WSMessage($reqPayloadString,
                                	array("to" => "http://172.23.4.10/VAS2_Engine/Application",
                                	));
	
    	// creating the WSClient
    	// here the option useMTOM will decide whether the
    	// attachment is set MTOM or base64
    	$client = new WSClient(array("useSOAP" => "1.1",
                                 	"useMTOM" => TRUE));
	
    	// sending the message and retrieving the response
    	$resMessage = $client->request($reqMessage);
	
	} catch (Exception $e) {
	
    		if ($e instanceof WSFault) {
			$xml = new SimpleXMLElement( $e->Detail);
			return $xml->messageLabel;
        		#printf("Soap Fault: %s\\n", $e->Detail);
        		#printf("Message = %s\\n",$e->getMessage());
			#return $e->Reason;
    		} else {
        		printf("Message = %s\\n",$e->getMessage());
			return $e->getMessage();
    		}
	}
	return 1;
}
function assignMoH ($fileID, $userID) {
$reqPayloadString = <<<XML
<ns1:executeOperation xmlns:ns1="http://application.webservices.engine.application.vas.ctmodule.com/">
<applicationInstanceID>1</applicationInstanceID>
<operationName>assign</operationName>
         <params>
            <key>fileID</key>
            <value>$fileID</value>
         </params>
         <params>
            <key>userID</key>
            <value>$userID</value>
         </params>
         <params>
            <key>label</key>
            <value>UNDEFINED</value>
         </params>
</ns1:executeOperation>
XML;

	#$this->log('MOH =>' . $reqPayloadString, LOG_DEBUG);
	try {
	
 	$reqMessage = new WSMessage($reqPayloadString,
                                	array("to" => "http://172.23.4.10/VAS2_Engine/Application",
                                	));
	
    	// creating the WSClient
    	// here the option useMTOM will decide whether the
    	// attachment is set MTOM or base64
    	$client = new WSClient(array("useSOAP" => "1.1",
                                 	"useMTOM" => TRUE));
	
    	// sending the message and retrieving the response
    	$resMessage = $client->request($reqMessage);
	

	#$xml = new SimpleXMLElement( $resMessage->str);
	#return $xml->return;

	} catch (Exception $e) {
	
    		if ($e instanceof WSFault) {
        		printf("Soap Fault: %s\\n", $e->Reason);
			return $e->Reason;
    		} else {
        		printf("Message = %s\\n",$e->getMessage());
			return $e->getMessage();
    		}
	}
	return 1;
}}
?>
