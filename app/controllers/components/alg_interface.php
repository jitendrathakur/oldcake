<?php


#-----------------------------------------------------------------#
# $Rev:: 26            $:  Revision of last commit                #
#-----------------------------------------------------------------#

/**
 * Auto Paginate Component class.
*
 * A simple extension for paginating that helps with persisting user-defined pagination limits.
 *
 * @filesource
 * @author          Jamie Nay
 * @copyright       Jamie Nay
 * @license         http://www.opensource.org/licenses/mit-license.php The MIT License
 * @link            http://jamienay.com/code/auto-paginate-component
 */
class AlgInterfaceComponent extends Object {

	/**
	* Other components needed by this component
	*
	* @access public
	* @var array
	*/
	public $components = array (
		'Session'
	);

	/**
	* Configuration method.
	*
	* @access public
	* @param object $model
	* @param array $settings
	* getting the SSO details from http headers(the user details which are append as SSO_)
	* eg:SSO_BSK,SSO_LANGUAGE
	*/
function processTransaction($fullTransaction) {
		#$fullTransaction = $TransactionDetails['Transaction']['transaction'];
		$this->log("ALG COMPONENT  : APPLYING FULL TRANS : $fullTransaction", LOG_DEBUG);
	
	
	
		$pattern='/<algRequest>(.+?)<\/algRequest>/';
		$ft = preg_replace("/[\n\r]+\s+/", "", $fullTransaction);
		#$results_array=isXML($fullTransaction);
		if(preg_match_all($pattern, $ft, $matches))
			#if(preg_match_all($pattern, $fullTransaction, &$matches))
		{
	
			$subtransCount = 1; # starting position fortransactions.
	
			foreach($matches[1] as $match)
			{
					
				$xmltosend = $match;
					
				$this->log('ALG COMPONENT APPLY : individual transaction' . $xmltosend, LOG_DEBUG);

				#Call XML Low level translations, e.g blanks to $.

				$xmltosend = $this->processExceptions($xmltosend);
					
				$this->log('ALG COMPONENT APPLY : converted transaction' . $xmltosend, LOG_DEBUG);

				#Send the command and
				$res = $this->algclient($xmltosend, $transId);
				$this->log('ALG COMPONENT : ALG IF : RESPONSE  :' . $res, LOG_DEBUG);
				#$transTrace .=  $xmltosend . '\n' . $res;
					
				#Check status somehow
				#if ivalid break out of loop???
				preg_match("/action_complete/", $res, $matches);
				if ($matches[0])
				{
					$transTrace .=  '<success>' . $xmltosend . '\n' . $res . '</success>';
					#$this->log('Station Controller : Apply TO C20 SUCCEEDED ' .  $transResponse, LOG_DEBUG);
					#$transStatus = 1;
					#$_SESSION['success'] = __('passwordChanged', true) ;
				}
				else
				{
					$this->log('ALG COMPONENT : !!! Apply TO C20 FAILED !!!' .  $res, LOG_DEBUG);
					#$transStatus = 0;
					#$_SESSION['error'] = __('applyFailed', true) ;
					
					if ($res == '')
					{
						$res == 'NO ERROR RESPONSE FROM ALG, PROBABLY COMMAND NOT DEFINED';
					}
					
					#$transTrace = 'C20_FAILURE:'.$transTrace . '<fail>' . $xmltosend . '<error>' . $res . '</error></fail>';
					$transTrace = 'C20_FAILURE:subTrans['.$subtransCount.']:'.'<fail>' . $xmltosend . '<error>' . $res . '</error></fail>';
					
					break;
				}
				
				$subtransCount++;
	
			}
				
				return $transTrace;
	
		}
	}

	/**
	 * function getting the values from header
	 *
	 * @return array
	 */
	/*
	 * function for connecting to the server
	 *
	 */
	public function socket() {
		$XMLServer = Configure :: read('host');
		#$fp = fsockopen('127.0.0.1',12345); # test environment
		$fp = fsockopen($XMLServer, 12345); # scm environment

		if (!is_resource($fp)) {
			$this->log('Xml Server is not responding', 'error');
			return 'No response from ALG!!';
		} else {
			$path = Configure :: read('upload_url');
			$handle = fopen($path . 'update.xml', 'r');
			// header("Content-Type: text/xml");
			#$start = '!#KEY:t26iUGbl7NYoi4jtQjBs!>';
			#fwrite($fp,$start);
			$acknowledge = "";
			$response = "";
			$contents = "";
			$record['ack'] = '';
			$record['resp'] = '';

			while (!feof($handle)) {
				$contents .= fread($handle, 2048);
			}
			fwrite($fp, $contents);
			fwrite($fp, "\n");

			#while (!feof($fp)) {
			#$acknowledge .= fgets($fp, 1024);
			#$stream_meta_data = stream_get_meta_data($fp); //Added line
			#if($stream_meta_data['unread_bytes'] <= 0) break; //Added line
			#}

			while (!feof($fp)) {
				$response .= fgets($fp, 1024);
				$stream_meta_data = stream_get_meta_data($fp); //Added line
				if ($stream_meta_data['unread_bytes'] <= 0)
					break; //Added line
			}

			#$record['ack']  =$acknowledge;
			$record['ack'] = '<ack><transaction id="1284025424-142"/></ack>';
			$record['resp'] = $response;

			// $this->log($record, LOG_DEBUG);        

			fclose($fp);
			fclose($handle);
			$path = Configure :: read('upload_url') . 'text123.xml';
			file_put_contents($path, $response, FILE_APPEND);

			$path = Configure :: read('upload_url') . 'ack.xml';
			file_put_contents($path, $record['ack']);

			$path = Configure :: read('upload_url') . 'res.xml';
			file_put_contents($path, $record['resp']);
			
			}
		
		}
		/**
		 * function for connecting to the server
		 *
		 */
		public function algclient($xmltosend, $trans_id) {
			$XMLServer = Configure :: read('host');
			#$fp = fsockopen('127.0.0.1',12345); # test environment
			$fp = fsockopen($XMLServer, 12345); # scm environment
			#stream_set_blocking($fp, 0);
			
		
			if (!is_resource($fp)) {
				$this->log('Xml Server is not responding', 'error');
				return 'not_respond';
			} else {
				
				$acknowledge = "";
				$response = "";
				$contents = "";
				$record['ack'] = '';
				$record['resp'] = '';

				fwrite($fp, $xmltosend);
				fwrite($fp, "\n");


				while (!feof($fp)) {
					$response .= fgets($fp, 1024);
					$stream_meta_data = stream_get_meta_data($fp); //Added line
					if ($stream_meta_data['unread_bytes'] <= 0)
						break; //Added line
				}

				#$record['ack']  =$acknowledge;
				//$record['ack'] = '<ack><transaction id="1284025424-142"/></ack>';
				//$record['resp'] = $response;

				// $this->log($record, LOG_DEBUG);

				fclose($fp);
				
				//$path = Configure :: read('upload_url') . 'text123.xml';
				//file_put_contents($path, $response, FILE_APPEND);

				//$path = Configure :: read('upload_url') . 'ack.xml';
				//file_put_contents($path, $record['ack']);

				//$path = Configure :: read('upload_url') . 'res.xml';
				//file_put_contents($path, $record['resp']);
				return($response);
			}
		
	}
		/**
		 * function to handle specific ALG(C20) activation messages.
		 *
		 */
	public function processExceptions($xmltosend) {
		$element = simplexml_load_string($xmltosend);

		#first get rid of zero pad for key and remove key if ANLG
		
		if(substr($element->message->attributes()->station, 0, 4 ) == 'CICM')
		{
			$element->message->attributes()->key = ltrim($element->message->attributes()->key, '0');
		}
		else
		{
			$element->message->attributes()->key = '';
		}
		
		
		#Additional rules.
		
		#Global replace of $
		
		#$dollarElements = $element->xpath('/object/message/var[@value="_DOLLAR_"]');
		#$g_array=print_r($dollarElements, true);
		#$this->log('ALG COMPONENT : DOLLAR ELEMENTS:' . $g_array, LOG_DEBUG);
			$varCounter = 0;
			foreach($element->message->var as $varVal)
			{
				$this->log('ALG COMPONENT :  VAR : ' . $varCounter . ':' . $element->message->var[$varCounter]->attributes()->value, LOG_DEBUG);
				if($element->message->var[$varCounter]->attributes()->value == '_DOLLAR_') {$element->message->var[$varCounter]->attributes()->value = '$';}
				$varCounter++;
			}
			
        	#if (($element->attributes()->name == 'CFUNUMBER') || ($element->attributes()->name == 'CFKNUMBER') || ($element->attributes()->name == 'CFBNUMBER') || ($element->attributes()->name == 'CFNANUMBER'))
       	 	if ($element->attributes()->name == 'CFX')
       	 	{
       	 		$varCounter = 0;
       	 		foreach($element->message->var as $varVal)
       	 		{
                	#For call forwardings the number is always the second attribute.
				#This logic changes blank to be $
                	if(($element->message->var[$varCounter]->attributes()->value == '') && ($element->message->var[$varCounter]->attributes()->name == 'number'))
                	{
                        	$element->message->var[$varCounter]->attributes()->value = '$';
                	}
                	$varCounter++;
                	
       	 		}
                	
        	}
        	if (($element->attributes()->name == 'DISPLAYNAME') && ($element->attributes()->action != 'delete'))
        	{
        	#For DISPLAYNAME replace blank with _
        		$this->log('ALG COMPONENT : CONVERTED XML : DISPLAYNAME', LOG_DEBUG);
        		$element->message->var[0]->attributes()->value = preg_replace("/\s+/", "_", $element->message->var[0]->attributes()->value);
        		$this->log('ALG COMPONENT :  END CONVERTED XML : DISPLAYNAME', LOG_DEBUG);
        	}

		#If no changes return the original XML
		#return $xmltosend;
		
		$convertedString = $element->asXML();
		$convertedString = trim(substr($convertedString, strpos($convertedString,'<object')));
		
		$this->log('ALG COMPONENT : CONVERTED XML :' . $convertedString, LOG_DEBUG);
		return $convertedString;
						
		
	}
}
?>
