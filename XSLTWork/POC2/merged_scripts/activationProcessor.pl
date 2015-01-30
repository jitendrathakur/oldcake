#!/usr/bin/perl

use warnings;
use strict;


#------------------Read the configuration file-----------------------#

#loads the variables into the hash array %Config.
#my %Config;
#&parse_config_file ('config.ini', \%Config);

our $execPath='/var/www/html/voipphoneRE3/XSLTWork/POC2/merged_scripts';
my $mode = shift(@ARGV);
my $layoutFile = shift(@ARGV);
my $trans = shift(@ARGV);

my $inputFile = $trans . 'input.xml';


chdir ($execPath);

#First delete old file 
unlink("$execPath/output_xml.xml");
unlink("$execPath/stationOut_originalFormat.xml");
#Call the PRocessor
#print "Finished the extract now calling scripts";
#system('/usr/bin/perl $execPath/poc2.pl');
system("/usr/bin/perl $execPath/poc3_merged_scripts.pl $mode $layoutFile $inputFile");
#require 'poc3.pl';
if($mode eq 'activation')
{
	system("/usr/bin/perl $execPath/transPopulator_v1.pl");
}
elsif($mode eq 'feature')
{
	system("/usr/bin/perl $execPath/2BPopulator_v2.pl");
}