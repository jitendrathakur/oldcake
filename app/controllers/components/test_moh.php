<?php
	$fileName = '/var/www/html/voipphone/app/temp_files/file2.wav';
	exec("/usr/bin/clamscan $fileName", $virusOut, $virusRetVal);
        if($virusRetVal > 0)
        {
		print "INFECTED :" . $fileName . ' ' . $virusRetVal;
        }
	print "NOT INFECTED";


?>
