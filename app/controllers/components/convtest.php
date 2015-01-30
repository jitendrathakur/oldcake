<?php
        #$fileName = '/var/www/html/voipphone_volume_working/app/webroot/files/file2.wav';
        $fileName = '/var/www/html/voipphone_volume_working/app/webroot/files/file2.WAv';
        $conFileName = $fileName . 'conv';
	$pos = ".wav";
        $conFileName = str_ireplace($pos, 'conv'.$pos ,$fileName);
	echo " $conFileName\n";
	echo "\n";
?>
