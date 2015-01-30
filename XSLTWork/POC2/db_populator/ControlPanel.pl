#!/usr/bin/perl
use strict;
use warnings;

#PERL packages imported
use ConfigVariable;
use MysqlConnection;
use ExecuteQuery;

my $inputXML = "";my $id = 1; my $log_id = 0; my $transaction = ""; my $status  = 0;
undef $/;

#provide path of directory where code is installed
my $appDir = 'D:/Craig/fresh/to_send/db_populator';

#provide input file name
my $inputFileName = "Input_transaction.xml";

open (INPUTXML, "$appDir/$inputFileName") or die "could not open input file";
$inputXML = <INPUTXML>; 

#CONFIGURATION variables
my ($Platform, $Database, $Host, $Port, $Tablename, $User, $Pw) = ConfigVariable::configVariable();
my $True=0;
my %HashPreDownload;
my %HashPostDownload;

my $Conn = MysqlConnection::connection($Platform,$Database,$Host,$Port,$Tablename,$User,$Pw);
my ($FeedType , $Location , $AsIs , $HalfWay, $IngestDir, $Locationtype) = ExecuteQuery::createTable($Conn,$Tablename);


while($inputXML =~ /(<Object action=\"([^\"]*)\".*?<\/Object>)/msg)
{   
    $transaction = $1;
	if($transaction =~ /transaction-id="(.*?)"/)
	{
		$transaction = $1;
	}
	
	ExecuteQuery::insertIntoTable($Conn,$Tablename, $id, $log_id, $transaction, $status);	
}


