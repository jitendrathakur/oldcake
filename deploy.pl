#!/usr/bin/perl

$deploymode = shift @ARGV;
#copy from Eclipse deploy directory
system("rm -rf /var/www/html/voipphoneRE3");
system("rm -rf /var/www/html/voipphoneRE3HE5");
system("rm -rf /var/www/html/voipphoneRE3HE5.tar");
system("rm -rf /var/www/html/voipphoneRE3HE5.tar.gz");
system("cp -rp /root/workspace/voipphoneRE3 /var/www/html/voipphoneRE3");
system("cp -rf /var/www/html/voipphonebaseconfig/config2.php.test /var/www/html/voipphoneRE3/app/config/config2.php");
system("cp -rf /var/www/html/voipphonebaseconfig/database.php.test /var/www/html/voipphoneRE3/app/config/database.php");
#system("cp -rf /var/www/html/voipphonebaseconfig/default.ctp.test /var/www/html/voipphoneRE3/app/views/layouts/");
system("chmod 777 /var/www/html/voipphoneRE3/app/tmp/logs /var/www/html/voipphoneRE3/app/tmp/logs/* /var/www/html/voipphoneRE3/app/temp_files/* /var/www/html/voipphoneRE3/XSLTWork/POC2/*");
system("rm -rf /var/www/html/voipphoneRE3/app/tmp/cache/*");

if ($deploymode eq 'REMOTE')
{
	print "now transferring remotely\n";
	#including remote server
	system("ssh 176.28.15.224  rm -rf /var/www/html/voipphoneRE3HE5.tar.gz");
	system("ssh 176.28.15.224  rm -rf /var/www/html/voipphoneRE3HE5.tar");
	system("ssh 176.28.15.224  rm -rf /var/www/html/voipphoneRE3HE5.old");
	system("ssh 176.28.15.224  mv /var/www/html/voipphoneRE3 /var/www/html/voipphoneRE3HE5.old");
	
	#copy to deploy directory
	system("cp -r /var/www/html/voipphoneRE3 /var/www/html/voipphoneRE3HE5");
	#edit files
	system("cp -r /var/www/html/voipphonebaseconfig/database.php.he5 /var/www/html/voipphoneRE3HE5/app/config/database.php");
	system("cp -r /var/www/html/voipphonebaseconfig/config2.php.he5 /var/www/html/voipphoneRE3HE5/app/config/config2.php");
	system("cp -r /var/www/html/voipphonebaseconfig/default.ctp.he5 /var/www/html/voipphoneRE3HE5/app/views/layouts/default.ctp.he5");
	#tar and zip
	system("tar cvf /var/www/html/voipphoneRE3HE5.tar /var/www/html/voipphoneRE3HE5");
	system("gzip /var/www/html/voipphoneRE3HE5.tar");
	#transfer to HE5
	system("scp /var/www/html/voipphoneRE3HE5.tar.gz 176.28.15.224:/var/www/html/");
	#unzip
	system("ssh 176.28.15.224 tar -C / -zxvf /var/www/html/voipphoneRE3HE5.tar.gz");
	system("ssh 176.28.15.224  mv /var/www/html/voipphoneRE3HE5 /var/www/html/voipphoneRE3");
}
