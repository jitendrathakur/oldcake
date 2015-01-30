#!/usr/bin/perl
use strict;
use XML::XPath;
use XML::XPath::XMLParser;

#provide path of directory where code is installed
my $appDir = 'E:/work/craig/xmlprocessingbaseinformation/new_files/updated_code/updated_code';

#provide input file name
my $inputFileName = "input.xml";

#provide config file name
my $configFileName = "CICMconfig.xml";

#output file will be created by name output_xml.xml
my $outputFileName = "output_xml.xml";
my $config = ""; my $inputXML = ""; my $currentMatch = ""; my $currentName="";	my $currentID = "";	my $xPath = ""; my $parse = ""; my $nodeValue = ""; my $varName = ""; my $action = "";my $key = "";
my $startKey=""; my $endKey=""; my $transactionId=""; my $transactionIdCounter = 1;my $primary_value = "";
undef $/;

#creating handler for config file
open (CONFIG, "$appDir/$configFileName") or die "could not open config file";
$config = <CONFIG>; 

$config = &ReplaceRequired (); 

#creating handler for input file
open (INPUTXML, "$appDir/$inputFileName") or die "could not open input file";
$inputXML = <INPUTXML>; 

#extracting the value of start key, end key and transaction ID
if($inputXML =~ /\<Activations start-key=\"(\d+)\" end-key=\"(\d+)\" transaction-id=\"(\d+)\"/)
{
	$startKey = $1;
	$endKey = $2;
	$transactionId = $3;
}

#creating handler for output file
open (OUTPUT,">$appDir/$outputFileName") or die "Could not open out XML file";	
print OUTPUT "<Activation>";

my $parse = XML::XPath->new($inputXML);
while($inputXML =~ /(<feature id=\"([^\"]*)\".*?<\/feature>)/msg)
{   
    
    $primary_value = $1;
    $key = $1;
	$currentMatch = $1;	$currentName=$2;
	$currentID = $2; $currentID =~ s/-.*$//;
	
	#creating name of feature from its id
	$currentName=~s/[^@]*@?[^\-]*\-//;
	
	#extracting key of feature
	if($key =~ /key="(.*?)"/)
	{
		$key = $1;
	}	
	
	
	
	
	#evaluating the xpaths of each activation element	
	while($config =~ /(\<(\w*)Command.*?\>)/msg)
	{   
	    $action = $2;
	    my $addCommand = $1;	
		#putting condition for a valid activation command such as its activation command present in config, required and key value lies between start key and end key
		if($addCommand =~ /linkto=\"$currentName\"/ and $addCommand =~ /required=\"y\"/ and $key >= $startKey and $key <= $endKey)
		{				
			print OUTPUT "\n\t<Object action=\"$action\" id=\"$currentID\" name=\"$currentName\" key=\"$key\" transaction-id=\"$transactionId-$transactionIdCounter\">";		
			while($addCommand =~ /(var-.*?\s)/msg)
			{   			    
			    $varName = $1;
				$xPath = $1;
				$xPath =~ s/.*\"(.*)\".*/$1/;								
				$varName =~ s/=.*//;
				$varName =~ s/var-//;		
				my $nodeValue = "";				
                if($xPath =~ /xpath:/)				
				{				    
					$xPath =~ s/.*xpath:|\"//msg;	
					$nodeValue = $parse->findvalue($xPath);					
				}				
				elsif($xPath =~ /element:/)				
				{ 
				      $xPath =~ s/element\://;
					  if($primary_value =~ /\<$xPath\>(.*?)\<\/$xPath\>/)
                      {
					     $nodeValue = $1;
					  }					  
				}
			    elsif($xPath =~ /attribute:/)				
				{ 
				      $xPath =~ s/attribute\://;
					  if($primary_value =~ /$xPath\=\"(.*?)\"/)
                      {
					     $nodeValue = $1;
					  }					  
				}
				
				print OUTPUT "\n\t\t<var value=\"$nodeValue\" name=\"$varName\"/>";
			
			}
	            		 
			print OUTPUT "\n\t</Object>";
			$transactionIdCounter++;
		}
		
	}
}
print OUTPUT "\n</Activation>";


sub ReplaceRequired
{	
	my $newConfig = $config;
	my $parser = XML::XPath->new(filename => "$appDir/$inputFileName");
	
	while ($config =~ /required="xpath:([^\"]*)"/msg)
	{	
	    my $xpath = $1;		
		my $nodevalue = $parser->findvalue($xpath);		
	    if (($nodevalue eq "0") or ($nodevalue eq "") or  ($nodevalue eq "n") or ($nodevalue eq "no") or ($nodevalue eq "N") or ($nodevalue eq "NO"))
		{	
		     $newConfig =~ s/required="xpath:[^\"]*"/required="n"/;
		}
		else
		{	
			 $newConfig =~ s/required="xpath:[^\"]*"/required="y"/;
		}
	}
	
	$config = $newConfig;
	return $config;
}