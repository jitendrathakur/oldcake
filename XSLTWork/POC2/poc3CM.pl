#!/usr/bin/perl

use strict;
use XML::LibXML::PrettyPrint;
my $currentKey;
my $waitingKey;

my ($inContent,$allFeatures,$newFeature,$featureName,$fullNewFeature,@keyset,@notKeyset,$newF,$newFFull,$fullParent,$con,$nDK,$nP,$nS,$nC,$exitFlag,$existingkey,$desiredkey,$index,@notkeyset,$station,$existingFeatures,$currentMatch,$currentName,$currentID,$cstring,$val,$nnDK,$key,$kkey,$extF,$eP,$eS,$eC,$notKeyset,$lk,$llk,%seen,$afullParent,$fullPrt,$feature,$nfeature,$pfname,$id,$newkey,$oldkey,$fname,$achild,$mainkey,$childern,$fid,$updateFeature,$childName,$defval,$ckey,$fid,$stationAttr,$nSN,$nM,$staid,$completeNewFeature);

my $layoutFile = shift(@ARGV);

my $binDir = '/var/www/html/voipphoneRE3/XSLTWork/POC2';

#my $binDir = 'C:/OD/Craig/PERLPOC/x/forMAhesh/2410/basic_test';

undef $/;
#Reading configuration file using slurping method, entire file in one variable, the variable would be used at many place where we need config info.
open (CON, "$binDir/$layoutFile") or die "could not open config file";
$con = <CON>;
close $con;
undef $/;
#Reading entire file and later it will be splitted in memory to be joined in the end
open (IX, "$binDir/input.xml") or die "Can not open input xml input.xml";
$inContent = <IX>;

#Getting station attribute in a variable from config file to be added to output in the end
if ($con =~ /<station([^\>]*)>/){$stationAttr=$1;}

#getting station id in variable to be used later in output xml
if ($inContent=~/\<Station([^\>]*)>/ms){$station=$1;}

#Getting all feature that has got keys already, based on status=99
while ($inContent =~ /(<feature.*?<\/feature>)/msg)
{
	$allFeatures = "$1\n";
	
	if ($allFeatures !~ /(<feature id=\"([^\"]*)\" key=\"[^\"]*\" status=\"99\".*?<\/feature>)/ms)
	{
		$existingFeatures .= "$1\n";
	}	
	 
}

#Getting Main feature and child feature in different string at the end child feature will be nested to main feature based on ids
while ($existingFeatures =~ /(<feature id=\"([^\"]*)\".*?<\/feature>)/msg)
{
	$currentMatch = $1;	$currentName=$2;
	$currentID = $2; $currentID =~ s/-.*$//;
	$currentName=~s/[^@]*@?[^\-]*\-//; 		
	if ($con=~/(<feature name="$currentName" short_name="[^\"]*" mandatory="[^\"]*" defaultKey="[^\"]*" priority="[^\"]*" shiftable="[^\"]*" coloc="[^\"]*" defaultValue="[^\"]*"\/>)/)
	{			
		$currentMatch =~ s/\s*<\/feature>/\n<\/feature>/ms;
		$currentMatch =~ s/\s*<primary_value>/\n\t<primary_value>/ms;
		$currentMatch =~ s/\s*<label>/\n\t<label>/ms;		
		$fullParent .= "$currentMatch\n";
	}
	else
	{	
		$currentMatch =~ s/<(\/?)feature/<$1cfeature/g;
		$currentMatch =~ s/\s*<\/cfeature>/\n<\/cfeature>/ms;
		$currentMatch =~ s/\s*<primary_value>/\n\t<primary_value>/ms;
		$currentMatch =~ s/\s*<label>/\n\t<label>/ms;
		$cstring .= "$currentMatch\n"
	}
	
} 

#Getting array with all key assigned (only unique keys)
my @keyArray = &createKeyArray();

#Creating an array of keys that are available;
foreach $val (1..12)
{	
	if ( not(grep( /^$val$/, @keyset ))) {push(@notKeyset,$val);}  
}

#get full new new feature string for mandatory assignment
while ($inContent =~ /(<feature id=\"([^\"]*)\" key=\"[^\"]*\" status=\"99\".*?<\/feature>)/msg) #example <feature id="123456789-AUD" key="" status="99">
{
	$completeNewFeature .= "$1\n";	
}
#adding mandatory features before any other assignment
$fullParent = &addMandatoryFeatures();
print "$fullParent";
#Getting all features that are new status="99" and posting them to assign key function
while ($inContent =~ /(<feature id=\"([^\"]*)\" key=\"[^\"]*\" status=\"99\".*?<\/feature>)/msg) #example <feature id="123456789-AUD" key="" status="99">
{
	$fullNewFeature = $1;
	$newFeature = $2;
	if($newFeature =~ /-(.*)$/)
	{
		$newFeature = $1;
	}
	 
	$fullParent=&assignkey ($newFeature,$fullNewFeature,$fullParent); 
}


#Keys assigned to feature re-arranging final output	
	$fullParent = &arrangeID();	
	$fullParent = &addExistingChildern();
	$fullParent = &addingMandatoryChildern();
	$fullParent = &editID();
	$fullParent = &addDefaultValue();	
	#$fullParent = &addMandatoryFeatures();
	
#Writing output to external XML file in original input format	
	open (Fout,">$binDir/stationOut_originalFormat.xml") or die "Could not open out XML file";	
	print Fout "<Configuration>\n<Station$station$stationAttr>\n$fullParent\n</Station>\n</Configuration>";
	close Fout;
	# $fullParent = &convertFormat();

##Writing output to external XML file in new format
	# open (Fout,">$binDir/stationOut.xml") or die "Could not open out XML file";
	# print Fout $fullParent;
	# close Fout;
	
# Pretty print final output
	&prettyPrint();
#********************************** End of Program ****************************************


#********************************** Start of Subroutines **********************************

#subroutine that assigns and reshuffles keys, this is core business logic

sub assignkey()
{	
	$desiredkey="";$existingkey=""; #<feature name="DN" defaultKey="1" priority="15" shiftable="n" coloc="n" defaultValue="123"/>
	$newF = $_[0]; $newFFull=$_[1]; $fullParent=$_[2];#get feature in $newF and full feature in $newFFull variable one by one for each feature with status=99
	
	if ($con =~ /<feature name="$newF" short_name="([^\"]*)" mandatory="([^\"]*)" defaultKey="([^\"]*)" priority="([^\"]*)" shiftable="([^\"]*)" coloc="([^\"]*)" defaultValue="([^\"]*)"\/>/ms) #getting various values like priority, shiftable, colocatable from config file for the new feature
	{	
		#it is handle situation where there is a desired key with existing key
		#here n statnd for new feature, DK is default key, P is priority, S is shiftable and C is coloctable so $nDK is default key of new feature.
		#value is obtained from incoming record with status 99
		$nDK = $3; $nP=$4; $nS=$5; $nC=$6; $nSN=$1;$nM=$2;
		$newFFull =~ s/@/#/;
		$exitFlag="n";	
		#Check Compulsory key assignment
		if ($nM eq "y" and $nS eq "n")
		{	
			
			if (grep(/^$nDK$/, @notKeyset))
			{
				$newFFull =~ s/id="[0-1][0-9]#/id="\@/;
				if (length($nDK)==1)
				{$newFFull =~ s/<feature id="([^\-]*\-)$newF" key=\"[^\"]*\" status="99"/<feature id="0$nDK$1$newF" key="0$nDK"/;}
				else
				{$newFFull =~ s/<feature id="([^\-]*\-)$newF" key=\"[^\"]*\" status="99"/<feature id="$nDK$1$newF" key="$nDK"/;}
				$fullParent .= "\n$newFFull";
				$exitFlag="y";
			}
			else
			{
				#print "Default key to feature $newF is already assigned, it is an exception, please try again with corrected config.xml"; exit;
			}
		}
		#Check prefered		
		if ($newFFull=~/<feature id="([0-9]+)[#@][^\-]*\-$newF" key=\"([^\"]*)\" status="99"/)
		{	
			$existingkey = $1;
			if(not(length($existingkey)) == 2){$existingkey="";}
			$desiredkey = $2; $desiredkey =~ s/^0//;
			if ($desiredkey eq ""){$exitFlag="n";} #new feature with no key preference
			elsif ($existingkey eq "")
			{ #new feature with preferred key	
				
				if (grep(/^$desiredkey$/, @notKeyset))
				{	
					if (length($desiredkey)==1){$desiredkey="0$desiredkey";}
					$newFFull =~ s/<feature id="([^\-]*\-)$newF" key=\"[^\"]*\" status="99"/<feature id="$desiredkey$1$newF" key="$desiredkey"/;
					$fullParent .= "\n$newFFull"; 				
					$index = grep { $notkeyset[$_] eq $desiredkey } 0..$#notkeyset;  splice(@notKeyset, $index, 1);
					$exitFlag="y";	
					
				}
			}
			else
			{	
				if (grep(/^$desiredkey$/, @notKeyset))
				{	
					if (length($desiredkey)==1){$desiredkey="0$desiredkey";}
					$newFFull =~ s/<feature id="([^\-]*\-)$newF" key=\"[^\"]*\" status="99"/<feature id="$desiredkey\@$1$newF" key="$desiredkey"/ms;
					$fullParent .= "\n$newFFull"; 
					$exitFlag="y";
					$index = grep { $notkeyset[$_] eq $desiredkey } 0..$#notkeyset;  splice(@notKeyset, $index, 1);
					$exitFlag="y";					
				}
			}
		}
		
		#&checkDefault value and see if the key is available, if available, assign key and exit by setting a flag exit to y	
		if ($exitFlag eq "n")
		{	
			if (grep {$_ eq $nDK} @keyArray) {$exitFlag = "n";}	
			else
			{
			  
			  if (length($nDK)==1){$nnDK = "0$nDK";}
			  $newFFull =~ s/@/#/;
			  $newFFull =~ s/<feature id="([^\-]*\-)$newF" key=\"[^\"]*\" status="99"/<feature id="$nnDK\@$1$newF" key="$nnDK"/;
			  $fullParent .= "\n$newFFull"; 
			  push(@keyArray,$nDK); @keyArray = sort @keyArray; 
			  #Remove this key from notkeyset and sort notkeyset to do this get index first 		 
			  $index = grep { $notkeyset[$_] eq $nDK } 0..$#notkeyset;  splice(@notKeyset, $index, 1); $notKeyset = sort @notKeyset; 
			  $exitFlag = "y"; 
			}
		}
		# if defulat key could not be assigned 
		
		if ($exitFlag eq "n")
		{	
			foreach $key (1..12) #Comparing the new feature with feature at each assigned key
			{	
				if ($exitFlag eq "n") #exit flag because y if key is assigned and no shifting needed like in case of coloctable being yes for both compared features
				{	
					if (length($key)==1){$kkey = "0$key";} else {$kkey=$key;} #maintaing two digit keys standard
					if ($fullParent =~ /<feature id=\"[^\-]*\-([^\"]*)\" key=\"$kkey\".*?<\/feature>/ms) #getting name of feature on current key		
					{	
						$extF = $1;
						#<feature name="DN_INDIVIDUAL" short_name="DN" mandatory="n" defaultKey="1" priority="15" shiftable="n" coloc="n" defaultValue="123"/>
						if($con =~ /<feature name="$extF" short_name="[^\"]*" mandatory="[^\"]*" defaultKey="[^\"]*" priority="([^\"]*)" shiftable="([^\"]*)" coloc="([^\"]*)" defaultValue="[^\"]*"\/>/ms)
						{$eP=$1; $eS=$2; $eC=$3;} #getting value of priority etc for current featue from config.xml e stand for existing so eP is existing priority.
						
						if ($newF ne $extF)	
						{	
							if ($nC eq "y" and $eC eq "y")  # both new feature and existing feature on this key are collocatable
							{	
								#Assign key $key to new record, change fullparent and exitflag=y; #<feature id="123456789-AUD" status="99">	
								$newFFull =~ s/<feature id="([^\-]*\-)$newF" key=\"[^\"]*\" status="99"/<feature id="$key\@$1$newF" key="$kkey"/;						
								$exitFlag = "y";
							}							
							elsif (($nP>$eP) and ($eS eq "y")) #check priority and if new key has high priority check shiftability of existing feature
							{	
								
								#Assign $key to new record in full parent, Assign 99 to current record, shift variable of e to n eg $newF=$extF
								if ($fullParent =~ /<feature id="([^\-]*\-$newF)" key=\"[^\"]*\" status="99"/)
								{
									$fullParent =~ s/<feature id="([^\-]*\-)$newF" key=\"[^\"]*\" status="99"/<feature id="$kkey\@$1$newF" key="$kkey"/;
								}						
								else
								{	
									$newFFull =~ s/<feature id="([^\-]*\-)$newF" key=\"[^\"]*\" status="99"/<feature id="$kkey\@$1$newF" key="$kkey"/;
									$fullParent .= "\n$newFFull"; 
								}						
								$fullParent =~ s/<feature id="$kkey@([^\-]*\-$extF)" key="$kkey"/<feature id="\1" key=\"\" status="99"/;
								$nP=$eP;$nS=$eS;$nC=$eC;$newF=$extF;
							}
						
						}					
					}
				}
			}
				
				#Assigning new key to leftover feature delete $notKeyset[0];
				$lk = $notKeyset[0];  splice(@notKeyset, 0, 1); #Takes the first available key to assign 
				if (length($lk)==1){$llk = "0$lk";} else {$llk=$lk;} 
				
				if ($fullParent =~ /<feature id="([^\"]*)" key=\"[^\"]*\" status="99"/)
				{
					$fullParent =~ s/<feature id=\"([^\-]*\-)[^\"]*\" key=\"[^\"]*\" status="99"/<feature id="$llk\@$1$newF" key="$llk"/;
					push(@keyArray,$lk); @keyArray = sort @keyArray;
				}
				else
				{	
					$newFFull =~ s/<feature id=\"([^\-]*\-)$newF\" key=\"[^\"]*\" status="99"/<feature id="$llk\@$1$newF" key="$llk"/;					
					$fullParent .= "\n$newFFull";
					push(@keyArray,"$lk"); @keyArray = sort @keyArray;
					
				}
		}
	}
	
	return "$fullParent"; #returing new key assigned XML
}

#Creating and array of unique keys found in the input file, the array is intergral part of key assignment and reshuffling
sub createKeyArray
{	
	@keyset="";
	while ($fullParent=~/<feature id="([0-9]{2})@/msg)
	{
		$key = $1;
		$key =~ s/^0//;
		push(@keyset,$key);
	}
	
	@keyset = grep { ! $seen{ $_ }++ } @keyset;
	@keyset = sort {$a <=> $b} @keyset; 	#@sorted = sort { $a <=> $b } @not_sorted
	return @keyset; 	
}

#Arrange IDs of final output, just to arrange feature in order of key assigned by business logic
sub arrangeID
{
	
	foreach $key (1..12)	
	{			
		while ($fullParent=~/(<feature id="[^\"]*" key="0?$key">.*?<\/feature>)/msg)
		{	 
			$afullParent .= "$1\n";
		}		
	}
	
	return $afullParent;	
}

#addExistingchild, subroutine reassign child feature that were removed intially from main feature, for key assignment logic application
sub addExistingChildern
{
	$fullPrt = $fullParent; 
	while ($fullParent=~/(<feature id="([^\-]*)\-([^\"]*)\".*?<\/feature>)/msg)
	{
		$feature = $1; $nfeature=$feature; $pfname = $3; 
		$id = $2;
		if ($id=~/([0-9]+)@([0-9]+#.*)/)
		{
			 
			$newkey=$1; $oldkey=$2; $oldkey=~s/#/@/;
			while ($cstring=~/(<cfeature id="$oldkey\-([^\"]*)" key="[^\"]*">.*?<\/cfeature>)/msg)
			{				
				$achild = $1; 
				$fname = $2;
				if ($con =~ /<cfeature name="$fname".*?parent="$pfname"/ms)				
				{	
					if ($oldkey =~ /[0-9]@(.*)/){$mainkey=$1;}
					$achild =~ s/<cfeature id="[^\"]*" key="[^\"]*"/<cfeature id="$newkey\@$mainkey\-$fname" key="$newkey"/ms;
					$achild =~ s/<\/cfeature>/<\/cfeature>/;
					$childern .= "\n$achild";
				}
			}
		}
		else
		{
			 
			$oldkey = $id;
			while ($cstring=~/(<cfeature id="$oldkey\-([^\"]*)" key="[^\"]*">.*?<\/cfeature>)/msg)
			{	
				$achild = $1; $fname = $2;
				if ($con =~ /<cfeature name="$fname".*?parent="$pfname"/ms)	
				{	
					$achild =~ s/<(\/)?cfeature>/<$1cfeature>/;				
					$childern .= "\n$achild";
				}
			}
		}
		$nfeature =~ s/<\/feature>/$childern\n<\/feature>/;
		$fullPrt =~ s/$feature/$nfeature/;
		$childern="";
	}
	$fullPrt=~s/@[0-9]{2}#/@/msg;
	
	return $fullPrt;
}

#adding Mandatory Childern if absent in their respective parents
sub addingMandatoryChildern
{ 
	$fullPrt = $fullParent;
	while ($fullParent=~/(<feature id="([^\-]*\-)([^\"]*)\".*?<\/feature>)/msg)
	{		
		$feature = $1; $featureName=$3;$fid=$2; 
		$updateFeature = $feature;
		while ($con =~ /<cfeature name="[^\"]*" short_name="([^\"]*)" defaultValue="([^\"]*)" mandatory="y" parent="$featureName"\/>/g)
		 {	$childName=$1;$defval=$2; $ckey=$fid; $ckey=~s/@.*$//; 
			 if ($feature !~ /<cfeature id="[^\-]*\-$childName"/)
			 { $updateFeature=~ s/<\/feature>/\n\t<cfeature id="$fid$childName" key="$ckey">\n\t\t<primary_value>$defval<\/primary_value>\n\t<\/cfeature>\n<\/feature>/ms;}
			
		}
		
		$fullPrt =~ s/$feature/$updateFeature/;
	}
	
	return $fullPrt;
}

#adding default values to main feature and child feature from config file
sub addDefaultValue
{ 
	$fullPrt = $fullParent;
	while ($fullParent=~/(<feature id="([^\-]*\-)([^\"]*)\".*?<\/feature>)/msg)
	{		
		$feature = $1; $featureName=$3;$fid=$2; 
		$updateFeature = $feature;
		if (($feature=~/<primary_value><\/primary_value>/ or $feature=~/<primary_value\/>/) or ($feature!~/<primary_value>/))
		{
			if ($con =~ /<feature name="$featureName" short_name="[^\"]*" mandatory="[^\"]*" defaultKey="[^\"]*" priority="[^\"]*" shiftable="[yn]" coloc="[yn]" defaultValue="([^\"]*)"\/>/g)
			 {	$defval=$1;  
				 if ($feature !~ /<primary_value>/)
				 { 
					$updateFeature=~ s/(<feature[^\>]*>)/$1\n<primary_value>$defval<\/primary_value>\n/ms;
				 }
				else
				{
					$updateFeature=~ s/<primary_value><\/primary_value>/\n<primary_value>$defval<\/primary_value>/ms;
					$updateFeature=~ s/<primary_value\/>/\n<primary_value>$defval<\/primary_value>/ms;
				}
			}
		}
		$fullPrt =~ s/$feature/$updateFeature/;
	}
	
	$fullPrt=~s/[\n\t]//g;
	return $fullPrt;
}

#subroutine to convert input format to output finally, once all keys are assigned
sub convertFormat
{
	$fullPrt = $fullParent;
	while ($fullParent=~/(<feature id="([^\-]*\-)([^\"]*)\".*?<\/feature>)/msg)
	{		
		$feature = $1; $featureName=$3;$fid=$2; 
		$updateFeature = $feature;
		$updateFeature =~ s/<(\/?)feature/<$1$featureName/g;					
		$updateFeature=~ s/<cfeature id=\"[^\-]*\-([^\"]*)\" key="([^\"]*)">(.*?)<\/cfeature>/\<$1 key="$2"\>$3\<\/$1\>/msg;
		$updateFeature =~ s/ id="[^\"]*"//g;
		$updateFeature =~ s/<primary_value>(.*?)<\/primary_value>/$1/g;
		$updateFeature =~ s/<primary_value\/>//g;
		$updateFeature =~ s/<label>(.*?)<\/label>/$1/g;
		$updateFeature =~ s/<label\/>//g;		
		$fullPrt =~ s/$feature/$updateFeature/;
		
	}
	$fullPrt = "<Configuration>\n<Station id=\"$station\" status=\"1\">\n$fullPrt\n</Station>\n</Configuration>";	
	return $fullPrt;
}

#subroutine to convert input format to output finally, once all keys are assigned
sub editID
{
	$fullPrt = $fullParent;
	while ($fullParent=~/(<feature id="([^\-]*\-)([^\"]*)\".*?<\/feature>)/msg)
	{		
		$feature = $1; $featureName=$3;$fid=$2; 
		if ($con =~ /<feature name="$featureName" short_name="([^\"]*)"/)
		{
			$nSN = $1;
			$fullPrt =~ s/\-$featureName/\-$nSN/g;
		}	
	
	}
	while ($fullParent=~/(<cfeature id="([^\-]*\-)([^\"]*)\".*?<\/cfeature>)/msg)
	{		
		$feature = $1; $featureName=$3;$fid=$2; 
		if ($con =~ /<cfeature name="$featureName" short_name="([^\"]*)"/)
		{
			$nSN = $1;
			$fullPrt =~ s/\-$featureName/\-$nSN/g;
		}	
	
	}
		
	return $fullPrt;
}

#subroutine to add mandatory features
sub addMandatoryFeatures
{	
	$fullPrt = $fullParent;
	if ($station =~ /id=\"([^\"]*)\"/ms) {$staid = $1;}
	while ($con =~ /<feature name="([^\"]*)" short_name="([^\"]*)" mandatory="y" defaultKey="([^\"]*)" priority="[^\"]*" shiftable="n" coloc="[^\"]*" defaultValue="([^\"]*)"\/>/msg)
	{	
		my $name = $2; my $defkey = $3; my $defVal = $4;
		if (($fullParent !~ /<feature id="[^\-]*\-$name"/) and ($completeNewFeature !~ /<feature id="[^\-]*\-$name"/))
		{	
			if (grep(/^$defkey$/, @notKeyset))
			{
				if (length($defkey)==1){$defkey="0$defkey"; }
				$fullPrt .= "<feature id=\"$defkey\@$staid\-$name\" key=\"$defkey\"><primary_value>$defVal<\/primary_value></feature>"
			}
		}
		else
		{
			#print "Default key to feature $newF is already assigned, it is an exception, please try again with corrected config.xml"; exit;
		}
	}
	return $fullPrt;
}

#subroutine to pretty print output;
sub prettyPrint
{
	#code to pretty print output xmls, this sub routine pretty print both output generated by this file.
	#Need to install perl package XML::LibXML::PrettyPrint;

	my $document = XML::LibXML->new->parse_file("$binDir/stationOut_originalFormat.xml");
	my $pp = XML::LibXML::PrettyPrint->new(indent_string => "  ");
	$pp->pretty_print($document); # modified in-place
	open (Fout,">$binDir/stationOut_originalFormat.xml");
	my $ppXML = $document->toString;
	print Fout $ppXML;
	close Fout;
	
	my $document = XML::LibXML->new->parse_file("$binDir/stationOut.xml");
	my $pp = XML::LibXML::PrettyPrint->new(indent_string => "  ");
	$pp->pretty_print($document); # modified in-place
	open (Fout,">$binDir/stationOut.xml");
	my $ppXML = $document->toString;
	print Fout $ppXML;
	close Fout;
	
}
