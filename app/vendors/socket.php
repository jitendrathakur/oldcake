<?php
 /**
  * function for connecting to the server
  *
  */
 
 class Socket{
	 public  function socket(){die('123');
		$host = Configure::read('host');// from config/config2.php
		$port = Configure::read('port');
		$timeout = 10;
		$xml = file_get_contents(Configure::read('upload_url').'update.xml');
		$length = strlen($xml);
		$socket = fsockopen($host, $port);
		
		//fputs($socket, "Content-Type: text/xml\n");
		//fputs($socket, "Content-Length: $length\n");
		//fputs($socket, "\n");
		fputs($socket, $xml);
		$out = '';
		while (!feof($socket)) {
		    $out .= fgets($socket, 1024);
		}
		fclose($socket);
		//if($out=='fine')
	 }	
 }
 ?>