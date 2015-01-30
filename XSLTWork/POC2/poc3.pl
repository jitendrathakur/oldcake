#!/usr/bin/perl
use strict;
use XML::LibXML::PrettyPrint;
use XML::XPath;
use XML::XPath::XMLParser;
my $currentKey;
my $waitingKey;
my ($inContent,$allFeatures,$newFeature,$featureName,$fullNewFeature,@keyset,@notKeyset,$newF,$newFFull,$fullParent,$con,$nDK,$nP,$nS,$nC,$exitFlag,$existingkey,$desiredkey,$index,@notkeyset,$station,$existingFeatures,$currentMatch,$currentName,$currentID,$cstring,$val,$nnDK,$key,$kkey,$extF,$eP,$eS,$eC,$notKeyset,$lk,$llk,%seen,$afullParent,$fullPrt,$feature,$nfeature,$pfname,$id,$newkey,$oldkey,$fname,$achild,$mainkey,$childern,$fid,$updateFeature,$childName,$defval,$ckey,$fid,$stationAttr,$nSN,$nM,$staid,$completeNewFeature,$dstring,$addNF);

my $binDir = '/var/www/html/voipphoneRE3/XSLTWork/POC2';
my $layoutFile = shift(@ARGV);
#my $binDir = 'E:/OD/Craig/Craig/PERLPOC/x/forMAhesh/2410/basic_test';


undef $/;
#Reading configuration file using slurping method, entire file in one variable, the variable would be used at many place where we need config info.
#open (CON, "$binDir/config.xml") or die "could not open config file";
open (CON, "$binDir/$layoutFile") or die "could not open config file";
$con = <CON>; 
close $con;
#replacing xpath in mandatory value
$con = &replaceMandatory (); 
undef $/;
#Reading entire input file and later it will be splitted in memory to be joined in the end
open (IX, "$binDir/input.xml") or die "Can not open input xml input.xml";
$inContent = <IX>;

# Removing all dfeature in the input if parent feature are absent
$inContent = removeOrphan ();
#print "$inContent"; exit;
#Getting station attribute in a variable from config file to be added to output in the end
if ($con =~ /<station([^\>]*)>/){$stationAttr=$1;}

#getting station id in variable to be used later in output xml
if ($inContent=~/\<Station([^\>]*)>/ms){$station=$1;}

#Getting all feature that has got keys already, based on status=99
while ($inContent =~ /(<feature.*?<\/feature>)/msg)
{
	$allFeatures = "$1\n";
	
	if ($allFeatures !~ /status=\"(99|66)\"/ms)
	{
		$existingFeatures .= "$allFeatures\n";
	}	
	 
}

#Getting Main feature and child feature in different string at the end child feature will be nested to main feature based on ids
while ($existingFeatures =~ /(<feature id=\"([^\"]*)\".*?<\/feature>)/msg)
{
	$currentMatch = $1;	$currentName=$2;
	$currentID = $2; $currentID =~ s/-.*$//;
	$currentName=~s/[^@]*@?[^\-]*\-//;
	if ($con=~/(<d?feature name="$currentName".*?\/>)/ms)
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
foreach $val (1..54)
{	
	if ( not(grep( /^$val$/, @keyset ))) {push(@notKeyset,$val);}  
}

#get full new feature string for mandatory assignment
while ($inContent =~ /(<feature id=\"([^\"]*)\" key=\"[^\"]*\" status=\"[69]+\".*?<\/feature>)/msg) #example <feature id="123456789-AUD" key="" status="99">
{
	$completeNewFeature .= "$1\n";	
}

#adding mandatory features before any other assignment
$fullParent = &addMandatoryFeatures();
#adding mandatory dependent feature, if parent exists but dependent feature is absent
$completeNewFeature = &addMandatoryDFeatures();
#Getting all features that are new status="99" and posting them to assign key function 
while ($completeNewFeature =~ /(<feature id=\"([^\"]*)\" key=\"[^\"]*\" status=\"[69]+\".*?<\/feature>)/msg) #example <feature id="123456789-AUD" key="" status="99">
{
	$fullNewFeature = $1; #print "$fullNewFeature\n";
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
	$fullParent = &convertTodfeature();
	$fullParent = &editID();
	$fullParent = &addDefaultValue();
	$fullParent = &addStationFeatures(); # adding station features
	$fullParent = &addStationDFeatures(); # adding station dfeatures
	$fullParent = &evaluateXpath();
	$fullParent = &correctChildOccurance();
	$fullParent = &controlDFeatureOccurance();
	
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
	
	if ($con =~ /<d?feature name="$newF" short_name="([^\"]*)" type="[^\"]*" mandatory="([^\"]*)" defaultKey="([^\"]*)" priority="([^\"]*)" shiftable="([^\"]*)" coloc="([^\"]*)" defaultValue="([^\"]*)".*?\/>/ms) #getting various values like priority, shiftable, colocatable from config file for the new feature
	{	
		#it handles situation where there is a desired key with existing key
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
				
				if (($fullParent =~ /<feature id="$nDK\@[0-9]+\-([^\"]*)"/ms) and ($nC="y"))
				{
					my $cofeature = $1;
					if ($con =~ /<[d]?feature name="$cofeature".*?coloc="y"/)
					{
						$newFFull =~ s/id="[0-1][0-9]#/id="\@/;
						if (length($nDK)==1)
						{$newFFull =~ s/<feature id="([^\-]*\-)$newF" key=\"[^\"]*\" status="99"/<feature id="0$nDK$1$newF" key="0$nDK"/;}
						else
						{$newFFull =~ s/<feature id="([^\-]*\-)$newF" key=\"[^\"]*\" status="99"/<feature id="$nDK$1$newF" key="$nDK"/;}
						$fullParent .= "\n$newFFull";
						$exitFlag="y";
					}
				}
				##print "Default key to feature $newF is already assigned, it is an exception, please try again with corrected config.xml"; exit;
			}
		}
		#Check preferred		
		if ($newFFull=~/<feature id="([0-9]+)[#@][^\-]*\-$newF" key=\"([^\"]*)\" status="66"/)
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
					$newFFull =~ s/<feature id="([^\-]*\-)$newF" key=\"[^\"]*\" status="66"/<feature id="$desiredkey$1$newF" key="$desiredkey"/;
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
					$newFFull =~ s/<feature id="([^\-]*\-)$newF" key=\"[^\"]*\" status="66"/<feature id="$desiredkey\@$1$newF" key="$desiredkey"/ms;
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
			foreach $key (1..54) #Comparing the new feature with feature at each assigned key
			{	
				if ($exitFlag eq "n") #exit flag because y if key is assigned and no shifting needed like in case of coloctable being yes for both compared features
				{	
					if (length($key)==1){$kkey = "0$key";} else {$kkey=$key;} #maintaing two digit keys standard
					if ($fullParent =~ /<feature id=\"[^\-]*\-([^\"]*)\" key=\"$kkey\".*?<\/feature>/ms) #getting name of feature on current key		
					{	
						$extF = $1;
						#<feature name="DN_INDIVIDUAL" short_name="DN" mandatory="n" defaultKey="1" priority="15" shiftable="n" coloc="n" defaultValue="123"/>
						if($con =~ /<d?feature name="$extF" short_name="[^\"]*" type="[^\"]*" mandatory="[^\"]*" defaultKey="[^\"]*" priority="([^\"]*)" shiftable="([^\"]*)" coloc="([^\"]*)" defaultValue="[^\"]*".*?\/>/ms)
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
	return "$fullParent";#returing new key assigned XML
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
	
	foreach $key (1..54)	
	{			
		while ($fullParent=~/(<feature id="[^\"]*" key="0?$key">.*?<\/feature>)/msg)
		{	 
			$afullParent .= "$1\n";
		}		
	}
	
	return $afullParent;	
}

#addExistingchild, subroutine reassign child feature that were removed initially from main feature, for key assignment logic application
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
		while ($con =~ /<cfeature name="[^\"]*" short_name="([^\"]*)" defaultValue="([^\"]*)" mandatory="y" occur="[0-9]+" parent="$featureName"\/>/g)
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
			if ($con =~ /<feature name="$featureName" short_name="[^\"]*" type="[^\"]*" mandatory="[^\"]*" defaultKey="[^\"]*" priority="[^\"]*" shiftable="[yn]" coloc="[yn]" defaultValue="([^\"]*)"\/>/g)
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
# converting dfeature to dfeature based of configuration file
sub convertTodfeature
{
	$fullPrt = $fullParent;
	while ($fullParent=~/<feature( id="([^\-]*\-)([^\"]*)\".*?)<\/feature>/msg)
	{		
		$feature = $1; $nfeature=$feature; $featureName=$3; 
		if ($con =~ /<dfeature name="$featureName" short_name="([^\"]*)"/)
		{			
			$nfeature =~ s/<feature/<dfeature/;
			$nfeature =~ s/<\/feature/<\/dfeature/;
			$fullPrt =~ s/$feature/$nfeature/ms;
		}		
	}
	return $fullPrt;
}

#subroutine to use short name instead of feature name in output sN stands for short name
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
#correcting hash character in IDs
	$fullPrt =~ s/id="([0-9]+@)[0-9]+#/id="$1/msg;	
	return $fullPrt;
	
}

#subroutine to add mandatory features
sub addMandatoryFeatures
{	
	$fullPrt = $fullParent;
	if ($station =~ /id=\"([^\"]*)\"/ms) {$staid = $1;}
	while ($con =~ /<feature name="([^\"]*)" short_name="([^\"]*)" type="key" mandatory="y" defaultKey="([^\"]*)" priority="[^\"]*" shiftable="n" coloc="([yn])" defaultValue="([^\"]*)"\/>/msg)
	{	
		my $name = $1; my $defkey = $3; my $defVal = $5; my $coloc=$4;		
		if (($fullParent !~ /<feature id="[^\-]*\-$name"/) and ($completeNewFeature !~ /<feature id="[^\-]*\-$name"/))
		{	
			if (length($defkey)==1){$defkey="0$defkey"; }
			
			if (grep(/^$defkey$/, @notKeyset))
			{
				if (length($defkey)==1){$defkey="0$defkey"; }
				$fullPrt .= "<feature id=\"$defkey\@$staid\-$name\" key=\"$defkey\"><primary_value>$defVal<\/primary_value></feature>";				
			}
			else
			{
				# if ($fullPrt =~ /(<feature id=\"$defkey\@[^\"]*\" key=\"$defkey\">.*?<\/feature>)/)
				# {	my $add = $1;
					# $fullPrt =~ s/$add//;
					# $add =~ s/(<feature id=\"$defkey\@[^\"]*\" key=\"$defkey\")>(.*?<\/feature>)/$1 status="99">$2/;
					# $add =~ s/(<feature id=\"$defkey)\@([^\"]*\" key=\"$defkey\" status="99">)/$1\#$2/;
					# $addNF .= $add;					
				# }
			}
		}		
	}	
	return $fullPrt;
}

#subroutine to add mandatory features
sub addStationFeatures
{	
	
	$fullPrt = $fullParent;
	if ($station =~ /id=\"([^\"]*)\"/ms) {$staid = $1;}
	while ($con =~ /<feature name="([^\"]*)" short_name="([^\"]*)" type="station" mandatory="y" defaultKey="([^\"]*)" priority="[^\"]*" shiftable="n" coloc="([yn])" defaultValue="([^\"]*)"\/>/msg)
	{	
		my $name = $2; my $defkey = $3; my $defVal = $5; my $coloc=$4;
		if (($fullParent !~ /<feature id="[^\-]*\-$name"/) and ($completeNewFeature !~ /<feature id="[^\-]*\-$name"/))
		{	
			if (length($defkey)==1){$defkey="0$defkey"; }			
			
				if (length($defkey)==1){$defkey="0$defkey"; }
				$fullPrt .= "<feature id=\"$defkey\@$staid\-$name\" key=\"$defkey\"><primary_value>$defVal<\/primary_value></feature>";				
			
			
		}
		
	}
	#print "$fullPrt";
	return $fullPrt;
}

#subroutine to add mandatory features
sub addMandatoryDFeatures
{	
	
	$fullPrt = $fullParent;
	
	while ($con =~ /<dfeature name="([^\"]*)" short_name="([^\"]*)" type="[^\"]*" mandatory="y" defaultKey="([^\"]*)" priority="[^\"]*" shiftable="[ny]" coloc="[^\"]*" defaultValue="([^\"]*)" occur="[0-9]+" parent="([^\"]*)"\/>/msg)
	{	
		my $name = $1; my $defkey = $3; my $defVal = $4; my $parent = $5; if (length($defkey)==1){$defkey="0$defkey";}
		
		if (($fullParent =~ /<feature id="[^\@]*\@?([^\-]*)\-$parent"/ms) or ($completeNewFeature =~ /<feature id="[^\@]*\@?([^\-]*)\-$parent"/ms))
		{	
			
			if (($fullParent !~ /<feature id=[^\@]*\@$staid\-$name\"/ms) and ($completeNewFeature !~ /<feature id=[^\@]*\@$staid\-$name\"/ms))
			{	$staid = $1;			
				$completeNewFeature .= "<feature id=\"$defkey\@$staid\-$name\" key=\"$defkey\" status=\"99\"><primary_value>$defVal<\/primary_value></feature>";
			}
		}		
	}

	return $completeNewFeature;
}

#subroutine to add mandatory features
sub addStationDFeatures
{	
	
	$fullPrt = $fullParent;
	
	while ($con =~ /<dfeature name="([^\"]*)" short_name="([^\"]*)" type="station" mandatory="y" defaultKey="([^\"]*)" priority="[^\"]*" shiftable="[ny]" coloc="[^\"]*" defaultValue="([^\"]*)" occur="[0-9]+" parent="([^\"]*)"\/>/msg)
	{	
		my $name = $1; my $defkey = $3; my $defVal = $4; my $parent = $5; if (length($defkey==1)){$defkey="0$defkey";}
		
		if ($fullParent =~ /<feature id="[^\@]*\@?([^\-]*)\-$parent"/ms) 
		{	
			
			if ($fullParent !~ /<feature id=[^\@]*\@$staid\-$name\"/ms)
			{	$staid = $1;			
				$fullPrt .= "<feature id=\"$defkey\@$staid\-$name\" key=\"$defkey\" status=\"99\"><primary_value>$defVal<\/primary_value></feature>";
			}
		}		
	}	
	return $fullPrt;
}

# Handling feature of occurances
sub correctChildOccurance
{	my ($ftname,$ftoccur);
	$fullPrt = $fullParent;
	while ($con =~ /(<cfeature.*?\/>)/msg)
	{
		my $currentCfeature = $1; my $actualOccur;
		if ($currentCfeature =~ /name="([^\"]*)"/){$ftname = $1;}
		if ($currentCfeature =~ /occur="([0-9]+)"/){$ftoccur = $1;}
		
		while ($fullParent =~ /(<cfeature id="[0-9]+\@[0-9]+\-$ftname".*?<\/cfeature>)/msg)
		{	
			my $myCfeature = $1;
			$actualOccur++; 
			if ($actualOccur <= $ftoccur)
			{	
				my $nmyCfeature = $myCfeature;
				$nmyCfeature =~ s/<cfeature/<ccfeature/;
				$fullPrt =~ s/$myCfeature/$nmyCfeature/;
			}
		}		
	}	
	$fullPrt =~ s/<cfeature.*?<\/cfeature>//msg;
	$fullPrt =~ s/<ccfeature/<cfeature/g;
	return $fullPrt;
}
#subroutine to evaluate xpath used in default value
sub evaluateXpath
{	
	$fullPrt = $fullParent;
	my $xp = XML::XPath->new(filename => "$binDir/input.xml");
	while ($fullParent =~ /xpath:([^<]*)/msg)
	{	
		my $xpath = $1; 
		my $nodevalue = $xp->findvalue($xpath);
		$fullPrt =~ s/xpath:[^<]*/$nodevalue/;		
	}
	
	my $string ="";
	 while ($fullParent =~ /function:([^<]*)/msg)
	 {	
		 my $function = $1;
		 $function =~ s/function://;		 
		 $string = &{\&{$function}}();
		$fullPrt =~ s/function:[^<]*/$string/;
	 }
	
	return $fullPrt;
}
# sub controlling occurances of dfeature
sub controlDFeatureOccurance
{	
	$fullPrt = my $cfullParent = $fullParent;
	while ($con =~ /(<dfeature.*?\/>)/msg)
	{	my ($dfname,$dfoccur);
		my $df = $1;
		if ($df =~ /name="([^\"]*)"/){$dfname=$1;}
		if ($df =~ /occur="([0-9]+)"/){$dfoccur=$1;}
		my $dfcount;
		while ($fullParent =~ /(<feature id="[0-9]+\@([^\-])*\-$dfname".*?\/>)/msg)
		{
			$dfcount++;
			my $ddfeat = my $dfeat = $1;
			if ($dfcount <= $dfoccur)
			{
				$ddfeat =~ s/<feature/<kfeature/;
				$fullPrt =~ s/$dfeat/$ddfeat/;
			}
			else
			{
				$ddfeat =~ s/<feature/<dfeature/;
				$fullPrt =~ s/$dfeat/$ddfeat/;
			}			
		}
	}
	$fullPrt =~ s/<dfeature.*?<\/feature>//msg;
	$fullPrt =~ s/<kfeature/<feature/g;
	return $fullPrt;
}
#evaluating xpath in mandatory values and replacing values
sub replaceMandatory
{	
	my $newcon = $con;
	my $xp = XML::XPath->new(filename => "$binDir/input.xml");
	while ($con =~ /mandatory="xpath:([^\"]*)"/msg)
	{	
		my $xpath = $1;
		my $nodevalue = $xp->findvalue($xpath);
		if($nodevalue) {
	        $nodevalue = 'y';
        }
        else
        {
            $nodevalue = 0;
        }
        print "CHECKING $xpath : nodevalue : $nodevalue\n";
		
		if (($nodevalue eq "0") or ($nodevalue eq "") or  ($nodevalue eq "n") or ($nodevalue eq "no") or ($nodevalue eq "N") or ($nodevalue eq "NO"))
		{	
			$newcon =~ s/mandatory="xpath:[^\"]*"/mandatory="n"/;
		}
		else
		{	
			$newcon =~ s/mandatory="xpath:[^\"]*"/mandatory="y"/;
		}
	}
	
	$con = $newcon;
	return $con;
}
#sub remove orphan
sub removeOrphan
{		my $name; my $parent;
		my $cinContent = $inContent; 
		while ($con =~ /(<dfeature(.*?)\/>)/msg)
		{ 	
			my $dfeature = $1;
			if ($dfeature =~ /name="([^\"]+)"/){$name = $1;}
			if ($dfeature =~ /parent="([^\"]+)"/){$parent = $1;} 
			if (($inContent =~ /<feature id="[^-]*-$name"/ms) and ($inContent !~ /<feature id="[^-]*-$parent"/ms))
			{
			 $cinContent =~ s/<feature id="[^-]*-$name".*?<\/feature>//ms;
			}
		}		
		$inContent = $cinContent;
		return $inContent;
}
#sub test function
sub myfunction
{
	return "xyz";
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
