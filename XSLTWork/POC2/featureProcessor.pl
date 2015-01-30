#!/usr/bin/perl

use warnings;
use strict;


#------------------Read the configuration file-----------------------#

#loads the variables into the hash array %Config.
#my %Config;
#&parse_config_file ('config.ini', \%Config);

our $execPath='/var/www/html/voipphoneRE3/XSLTWork/POC2';
my $layoutFile = shift(@ARGV);

chdir ($execPath);

#First delete old file 
unlink("$execPath/stationOut_originalFormat.xml");
#Call the PRocessor
#print "Finished the extract now calling scripts";
#system('/usr/bin/perl $execPath/poc2.pl');
system("/usr/bin/perl $execPath/poc3.pl $layoutFile");
#require 'poc3.pl';
system("/usr/bin/perl $execPath/2BPopulator_v2.pl");
#require  '2BPopulator_v1.pl'