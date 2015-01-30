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
class AuthenticationComponent extends Object {

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
	public function initialize() {
		$this->headers = array ();
		// echo "<pre>"; print_r($_SERVER);die();
		foreach ($_SERVER as $key => $value) {
			
			#$this->log("AUTHENTICATION :  $key => $value", LOG_DEBUG);
			if ($key == 'HTTP_USER_AGENT')
			{
				$this->log("AUTHENTICATION :  $key => $value", LOG_DEBUG);
			}

						
			if (substr($key, 0, 9) == 'HTTP_SSO_') {
				$this->headers[str_replace(' ', '-', ucwords(str_replace('_', ' ', strtolower(substr($key, 5)))))] = $value;
				
			} 

		}
		#RE3 default to Phone.
		$this->headers['Application-Name'] = 'Phone';
		$this->log("AUTHENTICATION : - APPLICATION PHONE", LOG_DEBUG);
	}

	/**
	 * function getting the values from header
	 *
	 * @return array
	 */
	public function authenticate() {

		$record = array ();
		$record['user_id'] = 0;
		$record['lang'] = '';
		$record['lang_head'] = '';
		$record['ACCOUNTNAME'] = '';
		$record['USERNAME'] = '';
		$record['USERFIRSTNAME'] = '';
		$record['ACCOUNTID'] = '';

		if (!empty ($this->headers)) {
			// print_r($this->headers);die();
			if (isset ($this->headers['Sso-Bsk'])) {
				$record['user_id'] = $this->headers['Sso-Bsk'];

			}
			if (isset ($this->headers['Sso-Language'])) {
				$record['lang'] = $this->headers['Sso-Language'];
			}
			if (isset ($this->headers['Sso-Accountname'])) {
				$record['ACCOUNTNAME'] = $this->headers['Sso-Accountname'];
			}
			if (isset ($this->headers['Sso-Name'])) {
				//$record['USERNAME']	=	 $this->headers['Sso-Name'];
				$record['USERNAME'] = utf8_decode($this->headers['Sso-Name']);
			}
			if (isset ($this->headers['Sso-Prename'])) {
				//$record['USERFIRSTNAME']	=	 $this->headers['Sso-Prename'];
				$record['USERFIRSTNAME'] = utf8_decode($this->headers['Sso-Prename']);
			}
			if (isset ($this->headers['Sso-Organisation'])) {
				//$record['ORGANIZATION']	=	 $this->headers['Sso-Organisation'];
				$record['ORGANIZATION'] = utf8_decode($this->headers['Sso-Organisation']);
			}
			if (isset ($this->headers['Sso-Accountid'])) {
				$record['ACCOUNTID'] = $this->headers['Sso-Accountid'];
			}
			if (isset ($this->headers['Application-Name'])) {
				$record['APPNAME'] = $this->headers['Application-Name'];
			}

		}
		$record['lang_head'] = $record['lang'];

		/**THESE NEED TO BE SET FOR IE TESTING */
		#$record['user_id'] = '123456789';
		$record['user_id'] = '99';
		$record['lang'] = 'de';
		$record['lang_head'] = '1';
		$record['ACCOUNTNAME'] = 'tgdgima4';
		$record['USERNAME'] = 'Ging';
		$record['USERFIRSTNAME'] = 'Marcel';
		$record['ACCOUNTID'] = '2312';
		$record['ORGANIZATION'] = '4-SOL AG';
		/* END IE TESTING */

		//$record['user_id']	=	 0;
		//$this->_authenticate_user();
		return $record;
	}
	/**
	 * function for connecting to the server
	 *
	 */
	public function socket() {
		$XMLServer = Configure :: read('host');
		#$fp = fsockopen('127.0.0.1',12345); # test environment
		$fp = fsockopen($XMLServer, 12345); # scm environment

		if (!is_resource($fp)) {
			$this->log('Xml Server is not responding', 'error');
			return 'not_respond';
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
		
			if (!is_resource($fp)) {
				$this->log('Xml Server is not responding', 'error');
				return 'not_respond';
			} else {
				#$path = Configure :: read('upload_url');
				#$handle = fopen($path . 'update.xml', 'r');
				// header("Content-Type: text/xml");
				#$start = '!#KEY:t26iUGbl7NYoi4jtQjBs!>';
				#fwrite($fp,$start);
				$acknowledge = "";
				$response = "";
						$contents = "";
						$record['ack'] = '';
						$record['resp'] = '';
		
						#while (!feof($handle)) {
						#	$contents .= fread($handle, 2048);
						#}
						fwrite($fp, $xmltosend);
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
						#fclose($handle);
						$path = Configure :: read('upload_url') . 'text123.xml';
						file_put_contents($path, $response, FILE_APPEND);
		
						$path = Configure :: read('upload_url') . 'ack.xml';
						file_put_contents($path, $record['ack']);
		
						$path = Configure :: read('upload_url') . 'res.xml';
						file_put_contents($path, $record['resp']);
						return($record['resp']);
					}
		
				}
}
?>
