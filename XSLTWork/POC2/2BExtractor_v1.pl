#!/usr/bin/perl

use warnings;
use strict;

use XML::Generator::DBI;
use XML::Handler::YAWriter;
use DBI;
use XML::LibXML::PrettyPrint;

#------------------Read the configuration file-----------------------#

#loads the variables into the hash array %Config.
#my %Config;
#&parse_config_file ('config.ini', \%Config);
our $dbUser='dev4';
our $dbPasswd='dev123';
our $dbPath='sadb_RE3:176.28.15.224:3306';
our $execPath='/var/www/html/voipphoneRE3/XSLTWork/POC2';

my $ya = XML::Handler::YAWriter->new(AsFile => "$execPath/in.xml"); #XML saved as in.xml

my $statId = shift(@ARGV);

my $dbh = DBI->connect("dbi:mysql:$dbPath", "$dbUser", "$dbPasswd");
my $generator = XML::Generator::DBI->new(
                               Handler => $ya,
                               dbh => $dbh
                               );	
#my $sql = "select * from features where id like '%997772413%'";
#my $sql = "select * from features where id like '%997778000%'";
#my $sql = "select * from features where id like '%997772407%'";
my $sql = "select * from features where id like '%$statId%'";

$generator->execute($sql);

#Getting content of in.xml and modifying it to match it to desired format
undef $/;
open (IN,"$execPath/in.xml") or die "could not open in.xml";
my $xml = <IN>;
my ($station,$id,$fname,$pval,$lbl,$status,$key,$sid);
if ($xml =~ /<stationkey_id>(.*?)<\/stationkey_id>/ms){$station=$1; $station=~s/^[0-9]{2}@//;}
my $outXML = "<Configuration><Station id=\"$station\" status=\"1\">\n";
while ($xml =~ /<row>(.*?)<\/row>/msg)
{
	my $feature = $1; $status="";
	if ($feature=~/<id>(.*?)<\/id>/ms){$id=$1; if($id=~/^([0-9]{2})@/){$key=$1;}}
	if ($feature=~/<stationkey_id>(.*?)<\/stationkey_id>/ms){$sid=$1; if($sid=~/^([0-9]{2})@/){$key=$1;}}
	if ($feature=~/<short_name>(.*?)<\/short_name>/ms){$fname=$1;}
	if ($feature=~/<primary_value>(.*?)<\/primary_value>/){$pval=$1;}
	if ($feature=~/<label>(.*?)<\/label>/ms){$lbl=$1;}
	if ($feature=~/<status>99<\/status>/ms){$status="99";}
	if ($status eq "99")
		{$outXML .= "<feature id=\"$id\" key=\"$key\" status=\"99\"><primary_value>$pval<\/primary_value><label>$lbl<\/label><\/feature>\n";}
	else
		{$outXML .= "<feature id=\"$id\" key=\"$key\"><primary_value>$pval<\/primary_value><label>$lbl<\/label><\/feature>\n";}
}
$outXML .= "</Station></Configuration>\n";
open (OUT,">$execPath/input.xml")	or die "can not open file input.xml";
print OUT "$outXML";
close OUT;

#code to pretty print input xml
#Need to install perl package XML::LibXML::PrettyPrint;

my $document = XML::LibXML->new->parse_file("$execPath/input.xml");
my $pp = XML::LibXML::PrettyPrint->new(indent_string => "  ");
$pp->pretty_print($document); # modified in-place
open (OUT,">$execPath/input.xml");
 my $ppXML = $document->toString;
print OUT $ppXML;


#sub parse_config_file()
#{

##This subroutine is used to read the INI file

    #local ($config_line, $Name, $Value, $Config);

#    ($File, $Config) = @_;

 #   if (!open (CONFIG, "$File")) {
 #       print "ERROR: Config file not found : $File";
 #       exit(0);
 #   }

  #  while (<CONFIG>) {
  #      $config_line=$_;
  #      chop ($config_line);          # Get rid of the trailling \n
  #      $config_line =~ s/^\s*//;     # Remove spaces at the start of the line
  #      $config_line =~ s/\s*$//;     # Remove spaces at the end of the line
  #      if ( ($config_line !~ /^#/) && ($config_line ne "") ){    # Ignore lines starting with # and blank lines
  #          ($Name, $Value) = split (/=/, $config_line);          # Split each line into name value pairs
  #          $$Config{$Name} = $Value;                             # Create a hash of the name value pairs
  #      }
  #  }

   # close(CONFIG);

#}

#Call the PRocessor
print "Finished the extract now calling scripts";
#system('/usr/bin/perl $execPath/poc2.pl');
system("/usr/bin/perl $execPath/poc3.pl");
#require 'poc3.pl';
system("/usr/bin/perl $execPath/2BPopulator_v1.pl");
#require  '2BPopulator_v1.pl'