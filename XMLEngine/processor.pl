#!/usr/bin/perl
use strict;
use XML::LibXML::PrettyPrint;
use XML::XPath;
use XML::XPath::Function;
use XML::XPath::XMLParser;
use FindBin qw($Bin);
my $binDir = $Bin;
use lib "$Bin/lib";
#use Data::Dumper;
use Config::Any::INI;
use Config::Any::XML;

my $currentKey;
my $waitingKey;
my ($inContent,$allFeatures,$newFeature,$featureName,$fullNewFeature,@keyset,@notKeyset,$newF,$newFFull,$fullParent,$con,$nDK,$nP,$nS,$nC,$exitFlag,$existingkey,$desiredkey,$index,@notkeyset,$station,$existingFeatures,$currentMatch,$currentName,$currentID,$cstring,$val,$nnDK,$key,$kkey,$extF,$eP,$eS,$eC,$notKeyset,$lk,$llk,%seen,$afullParent,$fullPrt,$feature,$nfeature,$pfname,$id,$newkey,$oldkey,$fname,$achild,$mainkey,$childern,$fid,$updateFeature,$childName,$defval,$ckey,$fid,$stationAttr,$nSN,$nM,$staid,$completeNewFeature,$dstring,$addNF);
my $runMode; my $allprevcomm = ""; my $subtranscounter = 0;
#my $binDir = 'E:/work/craig/blank_key';
#my $binDir = '/var/www/html/voipphoneRE3/XSLTWork/POC2/merged_scripts';

#edit mode "feature" for feature Mode and "activation" for activation Mode
#$runMode = 'STUB'# Whether to populate DB or not
chdir ($binDir);

#First delete old file 
unlink("$binDir/output_xml.xml");
#unlink("$binDir/stationOut_originalFormat.xml");

#Now read config settings
my $config_file = 'config.ini';
my $config_path = $binDir . '/etc/' .$config_file;
 #-e "$config_path" or croak "Config file config.ini does not exist\n";

my $config = Config::Any::INI->load("$config_path");
#print Dumper $config;

$runMode = $config->{runMode}; #whether to execute DB updates

my $printDebug = $config->{printDebug}; #whether to print debug

print STDERR "CONFIG mysql server $config->{mysql}->{host}" if ($printDebug == 1);

my $mode ="";
#my $mode = shift(@ARGV);
#my $layoutFile = "CICMconfig.xml";

#provide input file name
#my $inputFileName = "activation.1401985368.input.xml";
#my $inputFileName = "feature.1405326229.input.xml";
my $inputFileName = shift(@ARGV);
my $outputFileName = '';
my $layoutFile = shift(@ARGV);
$layoutFile = 'etc/' . $layoutFile;

if($inputFileName =~ /(\w+).(\d+).input.xml/)
{
	$mode = $1;
	$inputFileName = 'transactions/'.$inputFileName;
	$outputFileName = $inputFileName.'.out';
	
	
}
else
{
	die "INVALID FILE NAME : $inputFileName"
}


print STDERR "PROCESSOR mode => $mode, layout $layoutFile, input $inputFileName\n" if ($printDebug == 1) ;




undef $/;
#Reading configuration file using slurping method, entire file in one variable, the variable would be used at many place where we need config info.
#open (CON, "$binDir/config.xml") or die "could not open config file";
open (CON, "$binDir/$layoutFile") or die "could not open config file";
if($mode eq 'feature')
{
    $con = <CON>; 
    close $con;
    #replacing xpath in mandatory value
    $con = &replaceMandatory (); 
	
    undef $/;
    #Reading entire input file and later it will be splitted in memory to be joined in the end
    open (IX, "$binDir/$inputFileName") or die "Can not open input xml input.xml";
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
    #???Change to 14?
    foreach $val (1..14)
    {	
    	if ( not(grep( /^$val$/, @keyset ))) 
    	{
    		print STDERR "AVAILABLE KEY FOR ASSIGNMENT : $val\n" if ($printDebug == 1);
			#if (length($val)==1){$val="0$val"; }
    		push(@notKeyset,$val);
    	}  
    }
    
    print STDERR "AVALAILABLE KEYS  : @notKeyset\n" if ($printDebug == 1);
    #get full new feature string for mandatory assignment
    while ($inContent =~ /(<feature id=\"([^\"]*)\" key=\"[^\"]*\" status=\"[69]+\".*?<\/feature>)/msg) #example <feature id="123456789-AUD" key="" status="99">
    {
    	$completeNewFeature .= "$1\n";	
    }
    
    
	#adding attribute old="" to save the value of old key
	
    $fullParent = &addMandatoryFeatures();
    #adding mandatory features before any other assignment
	#???Check why
	while ($fullParent =~ /(<feature id=\"([^\"]*)\" key=\"[^\"]*\" status=\"[69]+\".*?<\/feature>)/msg) #example <feature id="123456789-AUD" key="" status="99">
    {
    	$completeNewFeature .= "$1\n";	
    }	
    $fullParent = &oldkey;	
    #end ???
    print STDERR $fullParent if ($printDebug == 1);
    #adding mandatory dependent feature, if parent exists but dependent feature is absent
    $completeNewFeature = &addMandatoryDFeatures();
    #Getting all features that are new status="99" and posting them to assign key function 
	
    while ($completeNewFeature =~ /(<feature id=\"([^\"]*)\" key=\"[^\"]*\" status=\"[69]+\".*?<\/feature>)/msg) #example <feature id="123456789-AUD" key="" status="99">
    {
    	$fullNewFeature = $1;	
    	$newFeature = $2;
		
    	if($newFeature =~ /-(.*)$/)
    	{
    		$newFeature = $1;
    	}
    	print STDERR "Assigining key for : $newFeature\n" if ($printDebug == 1);
    	$fullNewFeature = &addDefaultValue($fullNewFeature);		
    	$fullParent=&assignkey ($newFeature,$fullNewFeature,$fullParent); 
    }
   
    
    #Keys assigned to feature re-arranging final output	
		#$fullParent = &reassurekey;        
		#$fullParent = &checkkeyassign(); # should this be used ???
    	$fullParent = &arrangeID();        	
    	$fullParent = &addExistingChildern();		
    	$fullParent = &addingMandatoryChildern();
    	$fullParent = &convertTodfeature();
    	$fullParent = &editID();	
    	#print STDERR "FULL PARENT : $fullParent\n" if ($printDebug == 1);	
		$fullParent	=  &replaceParentRef($fullParent);	
    	#$fullParent = &addDefaultValue();
    	$fullParent = &addStationFeatures(); # adding station features
    	$fullParent = &addStationDFeatures(); # adding station dfeatures
    	$fullParent = &evaluateXpath();
    	$fullParent = &correctChildOccurance();
    	$fullParent = &controlDFeatureOccurance();
    	
    	
    	
    	
    #Writing output to external XML file in original input format	
    	open (Fout,">$binDir/$outputFileName") or die "Could not open out XML file";	
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
    
	#subroutine to create the old attribute for each feature
	sub oldkey()
	{
	  my $nnPar = ""; my $nnFeat = ""; my $nnkey =""; my $featInfo = "";
	  #looping over each feature
	  while($fullParent =~ /(<feature id=\"([^\"]*)\".*?<\/feature>)/msg)
	  {
	    $nnFeat = $1;
		if($nnFeat =~ /key="(.*?)"/ms)
		{
			$nnkey = $1;
		}
		if($nnFeat =~ /<feature(.*?)>/)
		{
			$featInfo = $1;
		}
		$nnFeat =~ s/<feature(.*?)>/<feature$featInfo old="$nnkey">/;
		$nnFeat =~ s/old=".*?" old=".*?"/old="$nnkey"/;		
		$nnPar .= $nnFeat;		
	  }
	  return $nnPar; #returning all features
	}
	
	
	
    #subroutine that assigns and reshuffles keys, this is core business logic.
    #This routine only works on features.
    
    sub assignkey()
    {	
    	print STDERR "ASSIGNING KEYS\n" if ($printDebug == 1);
    	$desiredkey="";$existingkey=""; #<feature name="DN" defaultKey="1" priority="15" shiftable="n" coloc="n" defaultValue="123"/>
    	$newF = $_[0]; $newFFull=$_[1]; $fullParent=$_[2];#get feature in $newF and full feature in $newFFull variable one by one for each feature with status=99
    	
    	if ($con =~ /<d?feature name="$newF" short_name="([^\"]*)" type="[^\"]*" mandatory="([^\"]*)" defaultKey="([^\"]*)" priority="([^\"]*)" shiftable="([^\"]*)" coloc="([^\"]*)" defaultValue="([^\"]*)".*?\/>/ms) #getting various values like priority, shiftable, colocatable from config file for the new feature
    	{	
    		#it handles situation where there is a desired key with existing key
    		#here n statnd for new feature, DK is default key, P is priority, S is shiftable and C is coloctable so $nDK is default key of new feature.
    		#value is obtained from incoming record with status 99
    		
    		#nDK = Default key;
    		#nP = Priority;
    		#nS = Shiftable;
    		#nC = Coloc;
    		#nSN = short_name;
    		#nM = mandatory;

    		$nDK = $3; $nP=$4; $nS=$5; $nC=$6; $nSN=$1;$nM=$2;		
    		$newFFull =~ s/@/#/;
    		$exitFlag="n";		
			
    		#Check Compulsory key assignment
    		if ($nM eq "y" and $nS eq "n")
    		{	
    			print STDERR "\tCOMPULSARY KEY FEATURE : $newF\n" if ($printDebug == 1);
    			if (grep(/^$nDK$/, @notKeyset))
    			{
    				print STDERR "\t\tDEFAULT KEY AVAILABLE : $nDK\n" if ($printDebug == 1);
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
    				print STDERR "\t\tDEFAULT KEY NOT AVAILABLE : $nDK\n" if ($printDebug == 1);
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
    			print STDERR "\tDESIRED KEY FEATURE (STATUS 66) : $newF\n" if ($printDebug == 1);
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
    			
    			print STDERR "\tNOT COMPULSARY OR DESIRED : $newF\n" if ($printDebug == 1);	
			    if (grep {$_ eq $nDK} @keyArray) {
			    	$exitFlag = "n";
			    	print STDERR "\t\tDEFAULT KEY NOT AVAILABLE : $nDK\n" if ($printDebug == 1);
			    }	
    			else
    			{
    			  print STDERR "\t\tDEFAULT KEY AVAILABLE : $nDK\n" if ($printDebug == 1);
    			  if (length($nDK)==1){$nnDK = "0$nDK";}
    			  $newFFull =~ s/@/#/;
    			  $newFFull =~ s/<feature id="([^\-]*\-)$newF" key=\"[^\"]*\" status="99"/<feature id="$nnDK\@$1$newF" key="$nnDK"/;
				  $newFFull =~ s/<stationkey_id>(.*?)#(.*?)<\/stationkey_id>/<stationkey_id>$1\@$2<\/stationkey_id>/ms;
    			  $fullParent .= "\n$newFFull"; 
    			  push(@keyArray,$nDK); @keyArray = sort @keyArray; 
    			  #Remove this key from notkeyset and sort notkeyset to do this get index first 		 
    			  $index = grep { $notkeyset[$_] eq $nDK } 0..$#notkeyset;  splice(@notKeyset, $index, 1); $notKeyset = sort @notKeyset; 
    			  $exitFlag = "y"; 
    			}
    		}
    		# if defualt key could not be assigned 
    		
    		if ($exitFlag eq "n")
    		{	my $noassign = 'no'; my $noassignkey = "";
    			foreach $key (1..14) #Comparing the new feature with feature at each assigned key
    			{	
    				if ($exitFlag eq "n") #exit flag because y if key is assigned and no shifting needed like in case of coloctable being yes for both compared features
    				{	
    					if (length($key)==1){$kkey = "0$key";} else {$kkey=$key;} #maintaing two digit keys standard
    					if ($fullParent =~ /<feature id=\"[^\-]*\-([^\"]*)\" key=\"$kkey\".*?<\/feature>/ms) #getting name of feature on current key		
    					{	
    						$extF = $1;		
    						
    						print STDERR "\t\t\tCURRENT FEATURE ON KEY : $key : $extF\n" if ($printDebug == 1);
    											
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
									   
										    print STDERR "\t\t\t1) SETTING NEW FEATURE $newF => CHANGE KEY TO $kkey STATUS TO 99\n" if ($printDebug == 1);
										    #print $newF."   ".$kkey."\n\n";
											$fullParent =~ s/<feature id="([^\-]*\-)$newF" key=\"[^\"]*\" status="99"/<feature id="$kkey\@$1$newF" key="$kkey"/;
										
    								}						
    								else
    								{	
									    print STDERR "\t\t\t2) SETTING NEW FEATURE $newF => CHANGE KEY TO $kkey STATUS TO 99\n" if ($printDebug == 1);
    									$newFFull =~ s/<feature id="([^\-]*\-)$newF" key=\"[^\"]*\" status="99"/<feature id="$kkey\@$1$newF" key="$kkey"/;
    									$fullParent .= "\n$newFFull"; 		
										
																			
    								}	
									     
										 print STDERR "\t\t\t3) UNSETTING CURRENT FEATURE ON KEY : $key : $extF => KEY $kkey : STATUS TO 99\n" if ($printDebug == 1);
										 $fullParent =~ s/<feature id="$kkey@([^\-]*\-$extF)" key="$kkey"/<feature id="\1" key=\"\" status="99"/;												 
										 $nP=$eP;$nS=$eS;$nC=$eC;$newF=$extF; $noassign = 'no';	
									    					
    								
    							}
    						
    						}					
    					}
                        else 
                        { 
                        	#$noassign = 'yes'; $noassignkey = $kkey;
                        	#ADDED BY CBM 
                        	print STDERR "\t\t\tNO CURRENT FEATURE ON KEY : $key (KKEY $kkey) : ASSIGNING\n" if ($printDebug == 1);
                        	$newFFull =~ s/<feature id="([^\-]*\-)$newF" key=\"[^\"]*\" status="99"/<feature id="$kkey\@$1$newF" key="$kkey"/;						
    						$exitFlag = "y";
    						#$index = grep { $notkeyset[$_] eq $kkey } 0..$#notkeyset;  splice(@notKeyset, $index, 1); #Check???
    						
    						#END ADDED
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
    	
    	foreach $key (1..14)	
    	{			
    		while ($fullParent=~/(<feature id="[^\"]*" key="0?$key".*?<\/feature>)/msg)
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
    		
			my $ok ="";
    		$feature = $1; $nfeature=$feature; $pfname = $3;$id = $2; 
			
			print STDERR "CHECKING CHILD FEATURES FOR $feature, pfeature = $pfname \n" if ($printDebug == 1);
			
			if($feature =~ /old="(.*?)"/ms)
			{
				$ok = $1;		
				print STDERR "FEAT1 YES"  if ($printDebug == 1);		
			}
    		
    		if ($id=~/([0-9]+)@([0-9]+#.*)/)
    		{
    			print STDERR "FEAT2 ID : $id"  if ($printDebug == 1);
    			$newkey=$1; $oldkey=$2; $oldkey=~s/#/@/;
				
				#$oldkey =~ s/.*@/$ok@/ms;
				
    			while ($cstring=~/(<cfeature id="$oldkey\-([^\"]*)" key="[^\"]*".*?<\/cfeature>)/msg)
    			{
					
    				$achild = $1; 
    				$fname = $2;
    				
    				#print STDERR "FEAT2b achild : $achild\n"  if ($printDebug == 1);
    				#print STDERR "FEAT2c fname : $fname\n"  if ($printDebug == 1);
    				
    				#if ($con =~ /(<cfeature name="$fname".*?parent="$pfname"\/>)/ms)		
    				#if ($con =~ /(<cfeature name="$fname"[\w\d\s\"\=_-:\[\]\(\)]*?parent="$pfname"\/>)/ms)		
    				#loop through the individual cfeature definitions
    				while ($con=~/(<cfeature.*?\/>)/msg)
					{
        				my $individual_cfeature_definition = $1;
        				#Check if there is a match of parent and child in config.
        				if ($individual_cfeature_definition =~ /(<cfeature name="$fname".*parent="$pfname"\/>)/ms)
        				{
    				    				
							#print STDERR "FEAT2d yes $1\n"  if ($printDebug == 1);
	    					if ($oldkey =~ /[0-9]@(.*)/){$mainkey=$1;}
	    					$achild =~ s/<cfeature id="[^\"]*" key="[^\"]*"/<cfeature id="$newkey\@$mainkey\-$fname" key="$newkey"/ms;
	    					$achild =~ s/<\/cfeature>/<\/cfeature>/;
	    					$childern .= "\n$achild";
        				}
    				}
    			}
    		}
    		else
    		{
    			print STDERR "FEAT3 YES"  if ($printDebug == 1);
    			my $nnk = "";
    			$oldkey = $id;
				#extracting the original key of parent feature
				if($oldkey =~ /(.*)@.*/)
				{
					$nnk = $1;
				}				
				#manipulating the key with according to original key
				$oldkey =~ s/.*@/$ok@/ms;	
				
				#looping according to the new key generated
    			while ($cstring=~/(<cfeature id="$oldkey\-([^\"]*)" key="[^\"]*".*?<\/cfeature>)/msg)
    			{	
    				$achild = $1; $fname = $2;
					
    				if ($con =~ /<cfeature name="$fname".*?parent="$pfname"/ms)	
    				{	
    					$achild =~ s/<(\/)?cfeature>/<$1cfeature>/;				
    					$childern .= "\n$achild";
						#replacing key of existing child feature in input with the new key of moved parent
						$childern =~ s/key="$ok"/key="$nnk"/ms;
						#replacing the key portion of id of existing child feature in input with the new key of moved parent
						$childern =~ s/id="$ok@/id="$nnk@/ms;
						#replacing the key portion of stationkey_id of existing child feature in input with the new key of moved parent
						$childern =~ s/\<stationkey_id\>(.*)$ok\@(.*?)\<\/stationkey_id\>/\<stationkey_id\>$1$nnk\@$2<\/stationkey_id\>/ms;
						
    				}
    			}
    		}
    		$nfeature =~ s/<\/feature>/$childern\n<\/feature>/;
    		
    		print STDERR "FEATURE WITH CHILDREN : $nfeature"  if ($printDebug == 1);
    		$fullPrt =~ s/$feature/$nfeature/;
    		$childern="";
    	}
    	$fullPrt=~s/@[0-9]{2}#/@/msg;
    	$fullPrt =~ s/old=".*?"//msg;
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
    	#Add support for dfeature as well
    	
    	while ($fullParent=~/(<dfeature id="([^\-]*\-)([^\"]*)\".*?<\/dfeature>)/msg)
    	{		
    		$feature = $1; $featureName=$3;$fid=$2; 
    		$updateFeature = $feature;
    		while ($con =~ /<cfeature name="[^\"]*" short_name="([^\"]*)" defaultValue="([^\"]*)" mandatory="y" occur="[0-9]+" parent="$featureName"\/>/g)
    		 {	$childName=$1;$defval=$2; $ckey=$fid; $ckey=~s/@.*$//;
    			 if ($feature !~ /<cfeature id="[^\-]*\-$childName"/)
    			 { $updateFeature=~ s/<\/dfeature>/\n\t<cfeature id="$fid$childName" key="$ckey">\n\t\t<primary_value>$defval<\/primary_value>\n\t<\/cfeature>\n<\/dfeature>/ms;}
    			
    		}
    		
    		$fullPrt =~ s/$feature/$updateFeature/;
    	}	
    	
    	
    	
    	
    	return $fullPrt; 
    }
    
    #adding default values to main feature and child feature from config file
    sub addDefaultValue
    { 
	    my $fullParent = "";
          ($fullParent) = (@_);
		
    	$fullPrt = $fullParent;
		
    	while ($fullParent=~/(<feature id="([^\-]*\-)([^\"]*)\".*?<\/feature>)/msg)
    	{	
    		$feature = $1; $featureName=$3;$fid=$2; 
    		$updateFeature = $feature;
			my $parentValue = "";
			
			
    		if (($feature=~/<primary_value><\/primary_value>/ or $feature=~/<primary_value\/>/) or ($feature!~/<primary_value>/))
    		{ 
			     
    			if ($con =~ /<feature name="$featureName" short_name="[^\"]*" type="[^\"]*" mandatory="[^\"]*" defaultKey="[^\"]*" priority="[^\"]*" shiftable="[yn]" coloc="[yn]" defaultValue="([^\"]*)"\/>/ms)
    			 {	$defval=$1;		
			 
    				 if ($feature !~ /\<primary_value/ms)
    				 { 
    					$updateFeature=~ s/(<feature[^\>]*>)/$1\n<primary_value>$defval<\/primary_value>\n/ms;
    				 }
    				else
    				{  
					    
						if($feature =~ /status="99"/ms)
						{
    					$updateFeature=~ s/<primary_value><\/primary_value>/\n<primary_value>$defval<\/primary_value>/ms;
    					$updateFeature=~ s/<primary_value\/>/\n<primary_value>$defval<\/primary_value>/ms;
						}
    				}
    			}
    		}
    		$fullPrt =~ s/$feature/$updateFeature/;
    	}
    	
    	$fullPrt=~s/[\n\t]//g;
		my $featIter = ""; my $cfeatIter = ""; my $featval = ""; my $subval = ""; my $comval = "";
		while($fullPrt =~ /(<feature id="([^\-]*\-)([^\"]*)\".*?<\/feature>)/msg)
		{   
		   $featIter = $1; 
			while($featIter =~ /(<cfeature id="([^\-]*\-)([^\"]*)\".*?<\/cfeature>)/msg)
			{
			    $cfeatIter = $1;
				if($cfeatIter =~ /<primary_value>parent:(.*?)<\/primary_value>/)
				{  
				   $featval = $1;
		   
				   if($featIter =~ /$featval(.*?)$featval/ms)
				   {
				     $subval = $1; 
					 $subval =~ s/\>|<\///msg;
				   }
				$featIter =~ s/<primary_value>parent:(.*?)<\/primary_value>/<primary_value>$subval<\/primary_value>/;   
				
				}
				
			}
			$comval .= $featIter;
			
		}
		$fullPrt = $comval;
    	return $fullPrt;
    }
	
	sub replaceParentRef
	{
		my $fullParent = "";
          ($fullParent) = (@_);
		
    	$fullPrt = $fullParent;
		
		my $featIter = ""; my $cfeatIter = ""; my $featval = ""; my $subval = ""; my $comval = "";
		while($fullPrt =~ /(<feature id="([^\-]*\-)([^\"]*)\".*?<\/feature>)/msg)
		{   
		   $featIter = $1; 		   
			while($featIter =~ /(<cfeature id="([^\-]*\-)([^\"]*)\".*?<\/cfeature>)/msg)
			{
			    $cfeatIter = $1;
				if($cfeatIter =~ /<primary_value>parent:(.*?)<\/primary_value>/)
				{  
				   $featval = $1;
				   
				   if($featIter =~ /$featval(.*?)$featval/ms)
				   {
				     $subval = $1; 
					 $subval =~ s/\>|<\///msg;
				   }
				$featIter =~ s/<primary_value>parent:(.*?)<\/primary_value>/<primary_value>$subval<\/primary_value>/;   
				
				}
				
			}
			$comval .= $featIter;
			
		}
		$fullPrt = $comval;
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
    			
    		
    			#cbm : added trailing " to handle where there is a madn and madn_pilot
    			$fullPrt =~ s/\-$featureName\"/\-$nSN\"/g;
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
    	
    	
    	#feature name="CXR" short_name="CXR" type="key" mandatory="y" defaultKey="2" priority="75" shiftable="y" coloc="n" defaultValue="1"
    	while ($con =~ /<feature name="([^\"]*)" short_name="([^\"]*)" type="key" mandatory="y" defaultKey="([^\"]*)" priority="[^\"]*" shiftable="([yn])" coloc="([yn])" defaultValue="([^\"]*)"\/>/msg)
    	{	
    		my $name = $1; my $defkey = $3;  my $shiftable=$4;  my $coloc=$5; my $defVal = $6;		
    		
    		print STDERR "==>MANDATORY FEATURE: $name with default key $defkey" if ($printDebug == 1);
    		if (($fullParent !~ /<feature id="[^\-]*\-$name"/) and ($completeNewFeature !~ /<feature id="[^\-]*\-$name"/))
    		{	
    			print STDERR "==> MISSING GOING TO ADD" if ($printDebug == 1);
				
    			#if (length($defkey)==1){$defkey="0$defkey"; }
				
    			if (grep(/^$defkey$/, @notKeyset))
    			{	
    				print STDERR "NOTKEYSET : @notKeyset"  if ($printDebug == 1);
    				
					if (length($defkey)==1){$defkey="0$defkey"; }
					$index = grep { $notkeyset[$_] eq $defkey } 0..$#notkeyset;  splice(@notKeyset, $index, 1);
    				$fullPrt .= "<feature id=\"$defkey\@$staid\-$name\" key=\"$defkey\"><primary_value>$defVal<\/primary_value></feature>";
    				print STDERR "==>DEFAULT KEY AVAILABLE : $defkey\n"  if ($printDebug == 1);	
    							
    			}
    			else
    			{
    				print STDERR "==>DEFAULT KEY NOT AVAILABLE : $defkey\n"  if ($printDebug == 1);					
    				$fullPrt .= "<feature id=\"99\@$staid\-$name\" key=\"99\" status=\"99\"><primary_value>$defVal<\/primary_value></feature>";					
    				
    			}
    		}		
    	}			
    	return $fullPrt;
    }
    
    #subroutine to add mandatory features
    sub addStationFeatures
    {	
    	#my $tempfullprt = ""; 
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
    	#putting all station feature at the top
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
    	my $xp = XML::XPath->new(filename => "$binDir/$inputFileName");
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
    	my $xp = XML::XPath->new(filename => "$binDir/$inputFileName");
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
        #print "CHECKING $xpath : nodevalue : $nodevalue\n";
		
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
    {		my $name; my $parent; my $mandatory;
    		my $cinContent = $inContent; 
    		while ($con =~ /(<dfeature(.*?)\/>)/msg)
    		{	 	
    			my $dfeature = $1;
    			if ($dfeature =~ /name="([^\"]+)"/){$name = $1;}
    			if ($dfeature =~ /parent="([^\"]+)"/){$parent = $1;} 
    			
    			# $mandatory has already been replaced. here just check what the value was.
    			if ($dfeature =~ /mandatory="([^\"]+)"/){$mandatory = $1;} # added to remove dfeatures that are not valid.
    			
    			#If parent doesn't exist remove dfeature
    			if (($inContent =~ /<feature id="[^-]*-$name"/ms) and ($inContent !~ /<feature id="[^-]*-$parent"/ms))
    			{
    			 $cinContent =~ s/<feature id="[^-]*-$name".*?<\/feature>//ms;
    			}
    			
    			#if mandatory not y then remove # CBM
    			
    			print STDERR "CHECKING DFEATURE MANDATORY FLAG: $parent - $name : MANDATORY : $mandatory : \t" if ($printDebug == 1);
				if($mandatory eq 'y') {
	 		      # Keep it in the output.
	 		      print STDERR "\n" if ($printDebug == 1);
    		    }
    		    else
    		    {
    		    	print STDERR ": DELETING\n" if ($printDebug == 1);
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
    
    	my $document = XML::LibXML->new->parse_file("$binDir/$outputFileName");
    	my $pp = XML::LibXML::PrettyPrint->new(indent_string => "  ");
    	$pp->pretty_print($document); # modified in-place
    	open (Fout,">$binDir/$outputFileName");
    	my $ppXML = $document->toString;
    	print Fout $ppXML;
    	close Fout;
    	
    	#my $document = XML::LibXML->new->parse_file("$binDir/stationOut.xml");
    	#my $pp = XML::LibXML::PrettyPrint->new(indent_string => "  ");
    	#$pp->pretty_print($document); # modified in-place
    	#open (Fout,">$binDir/stationOut.xml");
    	#my $ppXML = $document->toString;
    	#print Fout $ppXML;
    	#close Fout;
    	
    }

	sub uniq {
	  my %seen;
	  return grep { !$seen{$_}++ } @_;
	}

#Executue the Db Populator
#Executre DB Populator
	if($runMode ne 'STUB')
	{
		print STDERR "EXECUTING /usr/bin/perl $binDir/2BPopulator_v2.pl $outputFileName\n" if ($printDebug == 1);
		system("/usr/bin/perl $binDir/2BPopulator_v2.pl $outputFileName");
	}


}
elsif($mode eq 'activation')
{        
    
#provide path of directory where code is installed
#my $appDir = 'E:/work/craig/sample';



#provide config file name
#my $configFileName = "CICMconfig.xml";

#output file will be created by name output_xml.xml
#output file now created from input file with transaction id
my $outputFileName = "$outputFileName";
my $config = ""; my $inputXML = ""; my $currentMatch = ""; my $currentName="";	my $currentID = "";	my $xPath = ""; my $parse = ""; my $nodeValue = ""; my $varName = ""; my $action = "";my $key = "";
my $startKey=""; my $endKey=""; my $transactionId=""; my $transactionIdCounter = 1;my $primary_value = ""; my $allActions = ""; my $addKey = ""; my $deleteKey = ""; my $replaceKey = "";  my $updateKey = "";
my $updateFeatureID = ""; my $addFeatureID = ""; my $deleteFeatureID = ""; my $replaceFeatureID = ""; my $completeID = ""; my $tobePort = ""; my $asisPort = "";
my $tobe = ""; my $asis =""; my $parentKey = ""; my $parentName = ""; my $tobeList = ""; my $asisList = ""; my $altTobe = "";
undef $/;

#creating handler for config file
open (CONFIG, "$binDir/$layoutFile") or die "could not open config file";
$config = <CONFIG>; 

#$config = &ReplaceRequired (); 

#creating handler for input file
open (INPUTXML, "$binDir/$inputFileName") or die "could not open input file";
$inputXML = <INPUTXML>; 


#extracting the value of start key, end key and transaction ID
if($inputXML =~ /Activations transaction-id="(.*?)"/ms)
{
    
	$transactionId = $1;
}

#creating handler for output file
open (OUTPUT,">$binDir/$outputFileName") or die "Could not open out XML file";	
print OUTPUT "<Activation id=\"$transactionId\">";


if($inputXML =~ /(\<actions.*<\/actions\>)/msg)
{    
	$allActions = $1;
	while($allActions =~ /<key id="(.*?)"( featureId="(.*?)")?(.*?)<\/key>/msg)
	{   
	    my $actvelement = $4;
		$addKey = $1;		
		$addFeatureID = $3;
	    if($actvelement =~ /ADD/)
		{	
			print STDERR "\n\nADD COMAMAND => $addKey $addFeatureID\n\n" if ($printDebug == 1);
		    &StartProcess($addKey,'','','',$addFeatureID,'','','');
		}
		
	}
	while($allActions =~ /<key id="(.*?)"( featureId="(.*?)")?(.*?)<\/key>/msg)
	{
		my $actvelement = $4;
		$deleteKey = $1;		
		$deleteFeatureID = $3;
		if($actvelement =~ /DELETE/)
		{
			print STDERR "\n\nDELETE COMAMAND => $deleteKey $deleteFeatureID\n\n" if ($printDebug == 1);
			&StartProcess('',$deleteKey,'','','',$deleteFeatureID,'','');
		}
	}
	while($allActions =~ /<key id="(.*?)"( featureId="(.*?)")?(.*?)<\/key>/msg)
	{
		my $actvelement = $4;
		$replaceKey = $1;
		$replaceFeatureID = $3;
	    if($actvelement =~ /REPLACE/)
		{		
			print STDERR "\n\nREPLACE COMAMAND => $replaceKey $replaceFeatureID\n\n" if ($printDebug == 1);
			&StartProcess('','',$replaceKey,'','','',$replaceFeatureID,'');
		}			
				
	}
	while($allActions =~ /<key id="(.*?)"( featureId="(.*?)")?(.*?)<\/key>/msg)
	{
		my $actvelement = $4;
		$updateKey = $1;
		$updateFeatureID = $3;		
		if($actvelement =~ /UPDATE/)
		{		
			print STDERR "\n\nUPDATE COMAMAND => $updateKey $updateFeatureID\n\n" if ($printDebug == 1);
		    &StartProcess('','','',$updateKey,'','','',$updateFeatureID);
		}
		
	}
}
		
my $eachloop = "";
my $ordk = "";
my $command = "";
my $counter = 1;


my @actprior = "";
my $actpriority = "";

#Find all relevant priorities

foreach $eachloop(0..100)
{
   
   if (length($eachloop)==1){$ordk = "0$eachloop";} else {$ordk=$eachloop;}
   
   while($allprevcomm =~ /(<subtransaction.*?<\/subtransaction\>)/msg)
   {
      $command = $1;
	  if($command =~ /action="delete"/ms and $command =~ /key="$ordk"/ms)
	  {
	     if($command =~ /priority="(.*?)"/ms)
		 {
			#$actpriority = $1; # original 
			$actpriority = $1 . '.' . $ordk; # Add the key to priority. this will be used only in delete to reverse order by key afer priority.							
		 }
	     
		 push(@actprior,"$actpriority");
		 @actprior = reverse sort {$a <=> $b} @actprior;	
		 
		 print STDERR "DELETE ARRAY =>" if ($printDebug == 1);
		 #print join(",",@actprior) if ($printDebug == 1);;
	  }
   }   
}

#Loop through allprevcomm subtransactions and only output when priority is matched.

my $newval = "";
my $distinct = "";
foreach $newval(@actprior)
{
	my $searchKey = "";
	#$newval = int($newval / 1000);
	print STDERR "\n\nPROCESS PRIORITY  : $newval, $searchKey\n" if ($printDebug == 1);
	($newval, $searchKey) = split(/\./, $newval); # Get priority and Key from sorted array
	print STDERR "\n\nPROCESS PRIORITY  : $newval,  $searchKey\n" if ($printDebug == 1);
	while($allprevcomm =~ /(<subtransaction.*?<\/subtransaction\>)/msg)
   {
      $command = $1;
      
      print STDERR "\n\nACTIVATION SUBTRANS => $command\n" if ($printDebug == 1);
      
	  #if($command =~ /action="delete"/ms and $command =~ /priority="$newval"/ms)
	  if($command =~ /action="delete"/ms and $command =~ /priority="$newval"/ms and $command =~ /key="$searchKey"/ms)
	  {
	  	 
	     if($distinct =~ /$command/ms)
		 {
		 		#It has already been processed.
		 }
		 else
		 {
		 	print STDERR "YES : COMMAND HAS RIGHT PRIO : $newval\n" if ($printDebug == 1);	
		     if (length($counter)==1){$counter = "0$counter";} else {}
			 $distinct .= $command;
			 $command =~ s/priority=\".*?\"//;	
             if($command =~ /subtransaction id="(.*?)"/)
             {
			   my $nID = $1.'-'.$counter;
			   $command =~ s/subtransaction id="(.*?)"/subtransaction id="$nID"/;
			 }			 
			 print OUTPUT $command;
			 $counter++;			 
		 }
	  }
   }
}






my @actprior = "";
my $actpriority = "";
foreach $eachloop(0..100)
{
   
   if (length($eachloop)==1){$ordk = "0$eachloop";} else {$ordk=$eachloop;}
   
   while($allprevcomm =~ /(<subtransaction.*?<\/subtransaction\>)/msg)
   {
      $command = $1;
	  if($command =~ /action="add"/ms and $command =~ /key="$ordk"/ms)
	  {
	     if($command =~ /priority="(.*?)"/ms)
		 {
			$actpriority = $1;			
		 }
	     
		 push(@actprior,"$actpriority");
		 @actprior = reverse sort {$a <=> $b} @actprior;		 
	  }
   }   
}

my $newval = "";
my $distinct = "";
foreach $newval(@actprior)
{
	while($allprevcomm =~ /(<subtransaction.*?<\/subtransaction\>)/msg)
   {
      $command = $1;
	  if($command =~ /action="add"/ms and $command =~ /priority="$newval"/ms)
	  {
	     if($distinct =~ /$command/ms)
		 {
		 }
		 else
		 {
		     if (length($counter)==1){$counter = "0$counter";} else {}
			 $distinct .= $command;
			 $command =~ s/priority=\".*?\"//;	
             if($command =~ /subtransaction id="(.*?)"/)
             {
			   my $nID = $1.'-'.$counter;
			   $command =~ s/subtransaction id="(.*?)"/subtransaction id="$nID"/;
			 }			 
			 print OUTPUT $command;
			 $counter++;			 
		 }
	  }
   }
}

foreach $eachloop(0..100)
{
   
   if (length($eachloop)==1){$ordk = "0$eachloop";} else {$ordk=$eachloop;}
   
   while($allprevcomm =~ /(<subtransaction.*?<\/subtransaction\>)/msg)
   {
      $command = $1;
	  if($command =~ /action="update"/ms and $command =~ /key="$ordk"/ms)
	  {  
	     if (length($counter)==1){$counter = "0$counter";} else {}
		 $command =~ s/priority=\"\"//;
		 if($command =~ /subtransaction id="(.*?)"/)
		 {
		  my $nID = $1.'-'.$counter;
	      $command =~ s/subtransaction id="(.*?)"/subtransaction id="$nID"/;
		 }		 
		 print OUTPUT $command;
		 $counter++;
	  }
   }
   
}	
		
print OUTPUT "\n</Activation>";

sub StartProcess
{
	

my ($addKey,$deleteKey,$replaceKey,$updateKey,$addFeatureID,$deleteFeatureID,$replaceFeatureID,$updateFeatureID) = (@_);
my $parse = XML::XPath->new($inputXML);

if($inputXML =~ /<TOBEConfiguration(.*)TOBEConfiguration>/msg)
{
	$tobe = $1;
	$altTobe = $1;
}
if($inputXML =~ /<ASISConfiguration(.*)ASISConfiguration>/ms)
{
	$asis = $1;
}

if($tobe =~ /port="(.*?)"/)
{
	$tobePort = $1;
}

if($asis =~ /port="(.*?)"/)
{
	$asisPort = $1;
}
while($asis =~ /-(.*?)" key="(.*?)"/msg)
{
	$asisList = $asisList."\n".$1.":".$2;
}

while($asis =~ /(<feature id=\"([^\"]*)\".*?<\/feature>)/msg)
{   
	
    $completeID = $2;
    $primary_value = $1;
    $key = $1;
	$currentMatch = $1;	$currentName=$2;
	$currentID = $2; $currentID =~ s/-.*$//;
	
	
	
	#creating name of feature from its id
	$currentName=~s/[^@]*@?[^\-]*\-//;
	print STDERR "CURRENTNAME : $currentName \n" if ($printDebug == 1);
	
	#extracting key of feature
	if($key =~ /key="(.*?)"/)
	{
		$key = $1;
	}	
	my $finalParent = "";
	
	#print STDERR "\n\n  CONFIG : $config \n ENDCONFIG" if ($printDebug == 1);
	
	while($config =~ /\<.?feature name="$currentName".*?parent="(.*?)\>/msg)
	{
		$parentName = $1;
		$parentName =~ s/"\///;
		
		#print STDERR "\tLOOKING FOR RELATIONSHIP : $parentName -> $currentName \n" if ($printDebug == 1);
		
		if($tobeList =~ /$parentName:$key/)
		{ 
		   $finalParent = $parentName;
		   
		   #Parent and Child relationship
		   
		   #print STDERR "\tFOUND RELATIONSHIP (TOBE DATA) : finalPArent : $finalParent $currentName \n" if ($printDebug == 1);
		   
		}
		#elsif($asisList =~ /$parentName:$key/msg)
		elsif($asisList =~ /$parentName:$key/)
		{ 
		   $finalParent = $parentName;
		   
		   #Parent and Child relationship
		   
		  # print STDERR "\tFOUND RELATIONSHIP (ASIS DATA) : finalPArent : $finalParent $currentName \n" if ($printDebug == 1);
		   
		}
		#For debug only
		#else
		#{
		#	print STDERR "\tNOT FOUND :$parentName:$key: in : $asisList \n" if ($printDebug == 1);
		#}
		
	}
	
	#evaluating the xpaths of each activation element	
	while($config =~ /(\<(delete)Command.*?\>)/msg)
	{   
	    $action = $2;
	    
	   # print STDERR "\n\n!!CONFIG DELETES\n" if ($printDebug == 1);
		
	    my $addCommand = $1; my $outreq = "";
		$outreq = &ReplaceRequired($addCommand, $primary_value, $parse, $currentName);
		$addCommand =~ s/required=\"(.*?)\"/required="$outreq"/;
		#print STDERR "ALL AFTER REPLACE REQUIRED: addCOmmand : $addCommand finalPArent : $finalParent currentName : $currentName : required : $outreq key : $key \n" if ($printDebug == 1);
		print STDERR "1addCommand $addCommand \n" if ($printDebug == 1);
		
		#$addCommand =~ s/required=\"(.*?)\"/required="$outreq"/;
		print STDERR "2addCommand $addCommand \n" if ($printDebug == 1);
		
		
		#putting condition for a valid activation command such as its activation command present in config, required and key value lies between start key and end key
		if ($addCommand =~ /linkto=\"$finalParent:$currentName\"/ or $addCommand =~ /linkto=\"$currentName\"/)
		{	  
			print STDERR "MAtched COMAND $addCommand ($key,$deleteKey,$replaceKey)\n" if ($printDebug == 1);
			if($addCommand =~ /required=\"y\"/	  and   (($key == $deleteKey) or ($key == $replaceKey)) )
			{
					print STDERR "MAtched key $key\n" if ($printDebug == 1);
					#print STDERR "\tASIS 1 : action : $action\n addCommand : $addCommand\n transCOunt : $transactionIdCounter\n transId : $transactionId\n parse : $parse\n primary_value : $primary_value\n curretId : $currentID\n currentName : $currentName\n key : $key\n asisPort : $asisPort\n" if ($printDebug == 1);
						  
				    
				    if($key == $deleteKey)
					{
					  if($deleteFeatureID != '')
	                  {
					    if($deleteFeatureID eq $completeID)
						{
						  print STDERR "ASIS 2 : $action, $addCommand, $transactionIdCounter, $transactionId, $parse, $primary_value, $currentID, $currentName, $key, $asisPort\n" if ($printDebug == 1);
						  &GenerateCommand($action, $addCommand, $transactionIdCounter, $transactionId, $parse, $primary_value, $currentID, $currentName, $key, $asisPort, $completeID);
						  $transactionIdCounter++;
						}
	                  }
	                  else
					  {
					  	print STDERR "ASIS 3 : $action, $addCommand, $transactionIdCounter, $transactionId, $parse, $primary_value, $currentID, $currentName, $key, $asisPort\n" if ($printDebug == 1);
						  &GenerateCommand($action, $addCommand, $transactionIdCounter, $transactionId, $parse, $primary_value, $currentID, $currentName, $key, $asisPort, $completeID);
						  $transactionIdCounter++;
					  }				  
					}
					elsif($key == $replaceKey)
					{
					  if($replaceFeatureID != '')
	                  {
					    if($replaceFeatureID eq $completeID)
						{
						print STDERR "ASIS 4 : $action, $addCommand, $transactionIdCounter, $transactionId, $parse, $primary_value, $currentID, $currentName, $key, $asisPort\n" if ($printDebug == 1);
						    &GenerateCommand($action, $addCommand, $transactionIdCounter, $transactionId, $parse, $primary_value, $currentID, $currentName, $key, $asisPort, $completeID);
						  $transactionIdCounter++;
						}
	                  }
	                  else
					  {
					  print STDERR "ASIS 5 : $action, $addCommand, $transactionIdCounter, $transactionId, $parse, $primary_value, $currentID, $currentName, $key, $asisPort\n" if ($printDebug == 1);
						     &GenerateCommand($action, $addCommand, $transactionIdCounter, $transactionId, $parse, $primary_value, $currentID, $currentName, $key, $asisPort, $completeID);
						  $transactionIdCounter++;
					  }				  
					}
					
				}
			
			}
			else
			{
				#print STDERR " \t\t NOT IN : $addCommand\n" if ($printDebug == 1);
			}#
		
		
	}
}
while($tobe =~ /-(.*?)" key="(.*?)"/msg)
{
	$tobeList = $tobeList."\n".$1.":".$2;
}

while($tobe =~ /(<feature id=\"([^\"]*)\".*?<\/feature>)/msg)
{   
    $completeID = $2;
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
	my $finalParent = "";
	while($config =~ /\<.?feature name="$currentName".*?parent="(.*?)\>/msg)
	{
		$parentName = $1;
		$parentName =~ s/"\///;
		if($tobeList =~ /$parentName:$key/ms)
		{
		   $finalParent = $parentName;
		}
	}
	
	#evaluating the xpaths of each activation element	
	while($config =~ /(\<(add|update)Command.*?\>)/msg)
	{   
	    $action = $2;
	   
		#print STDERR "\n\n!!CONFIG ADD/UPDATES\n" if ($printDebug == 1);	   
	    my $addCommand = $1;	
		my $outreq = "";
			
		$outreq = &ReplaceRequired($addCommand, $primary_value, $parse, $currentName);
		
		#print STDERR "ALL AFTER REPLACE REQUIRED: finalPArent : $finalParent currentName : $currentName : required : $outreq key : $key \n" if ($printDebug == 1);
		
		$addCommand =~ s/required=\"(.*?)\"/required="$outreq"/;
			
		
		#putting condition for a valid activation command such as its activation command present in config, required and key value lies between start key and end key
		if( ($addCommand =~ /linkto=\"$finalParent:$currentName\"/ or $addCommand =~ /linkto=\"$currentName\"/)	  and	  $addCommand =~ /required=\"y\"/	  and   (($key == $addKey  and $action eq 'add')	or	($key == $replaceKey  and $action eq 'add')	or  ($key == $updateKey  and $action eq 'update')) )
		{  
		    
            if($key == $addKey)
			{
			  if($addFeatureID != '')
			  {  
			    if($addFeatureID eq $completeID)
				{
				  &GenerateCommand($action, $addCommand, $transactionIdCounter, $transactionId, $parse, $primary_value, $currentID, $currentName, $key, $tobePort,$completeID);
				  $transactionIdCounter++;
				}
			  }
			  else
			  {
				  &GenerateCommand($action, $addCommand, $transactionIdCounter, $transactionId, $parse, $primary_value, $currentID, $currentName, $key, $tobePort,$completeID);
				  $transactionIdCounter++;
			  }				  
			}
            elsif($key == $replaceKey)
			{
			  if($replaceFeatureID != '')
			  {
				if($replaceFeatureID eq $completeID)
				{
				  &GenerateCommand($action, $addCommand, $transactionIdCounter, $transactionId, $parse, $primary_value, $currentID, $currentName, $key, $tobePort, $completeID);
				  $transactionIdCounter++;
				}
			  }
			  else
			  {
				  &GenerateCommand($action, $addCommand, $transactionIdCounter, $transactionId, $parse, $primary_value, $currentID, $currentName, $key, $tobePort, $completeID);
				  $transactionIdCounter++;
			  }				  
			}
			elsif($key == $updateKey)
			{ 
			   
			  if($updateFeatureID != '')
			  {  
				if($updateFeatureID eq $completeID)
				{ 
				  &GenerateCommand($action, $addCommand, $transactionIdCounter, $transactionId, $parse, $primary_value, $currentID, $currentName, $key, $tobePort, $completeID);
				  $transactionIdCounter++;
				}
			  }
			  else
			  {
				  &GenerateCommand($action, $addCommand, $transactionIdCounter, $transactionId, $parse, $primary_value, $currentID, $currentName, $key, $tobePort, $completeID);
				  $transactionIdCounter++;
			  }				  
			}
			
		}
		
	}
}




}

sub ReplaceRequired
{	
    my $newXpath = ""; my $primaryv = ""; my $cName = "";
	($newXpath, $primaryv, $parse, $cName) = (@_);
	#my $newConfig = $config;
	
	#print STDERR  "REPLACE REQUIRED\n newXpath $newXpath\n  primaryv $primaryv\n parse $parse\n cName $cName\n" if ($printDebug == 1);
	while ($newXpath =~ /required="(.*?)\"\s+linkto=\"(.*:)?$cName\"/msg)
	#while ($newXpath =~ /required="(.*?)"/msg)
	{	
	    my $xpath = $1;				
		my $repReq = ""; my $newNode = ""; my $val = "";
		
		my $nodevalue = "";		
		
		if($xpath =~ /xpath:/)
			{
				
				$nodeValue = "";
				$xpath =~ s/xpath://ms;				
				
					if($xpath =~ /(element:.*?)-.*/)
				{
					my $xpath1 = $1;
					my $tempnode = "";
					$xpath1 =~ s/element\://;
					#extracting the value of element from current feature
                    if($primary_value =~ /\<$xpath1\>(.*?)\<\/$xpath1\>/) 
					{
					  $tempnode = $1; 
					}
					#print  "XPATH-PRE  $xpath\n" if ($printDebug == 1);
					
					#need to substitute element correctly for multiple occurances
					#count the occurrances of element and then run the process for that amount.
					
					my @element_count = $xpath =~ /(element)/g;
					my $ecount = @element_count;
					#print STDERR  "XPATH COUNT : element occurs $ecount\n" if ($printDebug == 1);
					for (my $ei = 1;  $ei <= $ecount; $ei++ )
					{
						$xpath =~ s/(element:.*?)(-.*)/$tempnode$2/;
					}
					#$xpath =~ s/(element:.*?)(-.*)/$tempnode$2/;										
					
				}
				#print STDERR  "XPATH  $xpath\n" if ($printDebug == 1);
				$nodevalue = $parse->findvalue($xpath);
				
			}
			
		
		elsif($xpath =~ /(element:.*?=(.*))/ms)
		{
			$repReq = $1;
			$val = $2;		
            $val =~ s/\'//msg;
			$repReq =~ s/element\://;
			$repReq =~ s/!?=.*//;
			
				  if($primaryv =~ /\<$repReq\>(.*?)\<\/$repReq\>/ms) 
				  {
				  $newNode = $1; 
				  }	
				  
                  $newNode =~ s/\n//msg;
				  $newNode =~ s/(.*)/\'$1\'/;
			
			$xpath =~ s/element:.*?(!?=.*)/$newNode$1/g;
			
			#print STDERR  "XPATH2 $newXpath : $xpath\n" if ($printDebug == 1);
			
			$nodevalue = $parse->findvalue($xpath);
			
          
		
		}
		else
		{
		$nodevalue = $xpath;		
		}
		
		#changing the boolean value to atomic value
		if($nodevalue) {
	        $nodevalue = 'y';
        }
        else
        {
            $nodevalue = 0;
        }

	    if (($nodevalue eq "0") or ($nodevalue eq "") or  ($nodevalue eq "n") or ($nodevalue eq "no") or ($nodevalue eq "N") or ($nodevalue eq "NO"))
		{	
				
				 return 'n';
		}
		else
		{	
			     return 'y';
				
		}
	
	}		
	
}

	#Executre DB Populator
	if($runMode ne 'STUB')
	{
		print STDERR "EXECUTING usr/bin/perl $binDir/transPopulator_v1.pl $outputFileName\n" if ($printDebug == 1);
		system("/usr/bin/perl $binDir/transPopulator_v1.pl $outputFileName");
	}
}

sub GenerateCommand
{
		my ($action, $addCommand, $transactionIdCounter, $transactionId, $parse, $primary_value, $currentID, $currentName, $key, $tobePort,$completeID) = (@_);
		my $varName = "";
		my $xPath = "";		
		my $actObject = "";
		my $actCommand = "";
		my $currCommand = "";
		#my $stid = "";
		#e.g <deleteCommand name="delete-AUD_FEATURE"
		print STDERR "START OF GenerateCommand\n" if ($printDebug == 1);
		if($addCommand =~ /.*Command\s+name=\"(\w+)-([\w_]+)\"/)
		{
			$actObject = $2;
			$actCommand = $1;
			print STDERR "LINE : $addCommand \n actObj $actObject actCommand $actCommand\n" if ($printDebug == 1);
		}
		
		my $priority = "";
		if($addCommand =~ /addCommand/ms or $addCommand =~ /deleteCommand/ms)
		{
			if($addCommand =~ /priority="(.*?)"/)
			{
				$priority = $1;
			}
			else
			{
				$priority = 1;
			}
		}
			
		$currCommand .= "\n\t<subtransaction id=\"$transactionId\">\n\t\t<algRequest>\n\t\t\t<object action=\"$actCommand\" name=\"$actObject\" priority=\"$priority\">\n\t\t\t\t<message station=\"$tobePort\" key=\"$key\">";
		#print OUTPUT $currCommand;		
		
		while($addCommand =~ /(var-.*?\"\s)/msg)
		{   			    
			$varName = $1;
			$xPath = $1;			
			
			$xPath =~ s/.*\"(.*)\".*/$1/;								
			
			$varName =~ s/=.*//;
			$varName =~ s/var-//;		
			my $nodeValue = "";	
			
			
			if($xPath =~ /xpath:find-value/)
			{
				$nodeValue = "";
				$xPath =~ s/.*xpath:find-value\(|\"|\)$//msg;	
				
				#print  "XPATH FINDVALUE $action $actObject $currentID : $xPath	" if ($printDebug == 1);
							
				if($xPath =~ /(element:.*?)-.*/)
				{
					my $xpath1 = $1;
					my $tempnode = "";
					$xpath1 =~ s/element\://;
					#extracting the value of element from current feature
                    if($primary_value =~ /\<$xpath1\>(.*?)\<\/$xpath1\>/) 
					{
					  $tempnode = $1; 
					}
					
					$xPath =~ s/(element:.*?)(-.*)/$tempnode$2/;										
					
				}
				$nodeValue = $parse->findvalue($xPath);
				
			}
			elsif($xPath =~ /xpath:/)
			{ 
			    $nodeValue = "";
				$xPath =~ s/.*xpath:|\"//msg;	
				
				#print  "XPATH FIND $action $actObject $currentID : $xPath	" if ($printDebug == 1);
							
				if($xPath =~ /(element:.*?)-.*/)
				{
					my $xpath1 = $1;
					my $tempnode = "";
					$xpath1 =~ s/element\://;
					#extracting the value of element from current feature
                    if($primary_value =~ /\<$xpath1\>(.*?)\<\/$xpath1\>/) 
					{
					  $tempnode = $1; 
					}
					
					$xPath =~ s/(element:.*?)(-.*)/$tempnode$2/;										
					
				}		
				
				
				my $newnode = "";
				my $newnodevalue = "";
				#find() to extract the node from XML
				$newnodevalue = $parse->find($xPath);
				
				#$newnodevalue =~ s/(.*)/<a>$1<\/a>/;
				#$newnodevalue = XML::LibXML->load_xml(
				#								  string => $newnodevalue
												  # parser options ...
				#								);
				#$newnodevalue = $newnodevalue->find('/a/node()');
				
				
				
                #looping over each node such that a delimter can be used to separate the values				
				foreach my $node ($newnodevalue->get_nodelist)
				{
					$newnode = XML::XPath::XMLParser::as_string($node);
					#Checking if extracted node is an element
					
					if($newnode =~ /<.*?>(.*)<\/.*?>/ms)
					{
						$nodeValue .= $1." ";
					}
					elsif($newnode =~ /<.*?\/>/ms)
					{
						$nodeValue = "";
					}
					#Checking if extracted node is an attribute
					elsif($newnode =~ /\"(.*)\"/)
					{
						$nodeValue .= $1." ";						
					}
					#Otherwise the node is text node
					else
					{
						$nodeValue .= $newnode." ";
					}
				}
				$nodeValue =~ s/\n|\s+$//msg;
				
			}				
			elsif($xPath =~ /element:/)	
			{ 
				  $xPath =~ s/element\://;
				  if($primary_value =~ /\<$xPath\>(.*?)\<\/$xPath\>/ms) 
				  {
				  $nodeValue = $1; 
				  }	
                  $nodeValue =~ s/\n//msg;				  
            				  
	       }
			elsif($xPath =~ /attribute:/) {  $xPath =~ s/attribute\://;
				  if($primary_value =~ /$xPath\=\"(.*?)\"/) { $nodeValue = $1;  }					  
										  }
			elsif($xPath =~ /default:/)	{ $xPath =~ s/.*default:|\"//msg;	$nodeValue = $xPath;}
			
			$currCommand .= "\n\t\t\t\t<var value=\"$nodeValue\" name=\"$varName\"/>";
			#print OUTPUT $currCommand;
		
		}
		$currCommand .=  "\n\t\t\t\t</message>\n\t\t\t</object>\n\t\t</algRequest>\n\t</subtransaction>";
		#checking if activation command already created or not
		if($allprevcomm =~ /$currCommand/ms){}
		else
		{
			$allprevcomm .= $currCommand;			
			$subtranscounter++;
			if($currCommand =~ /\<subtransaction id=\"($transactionId)\"\>/)
			{
			  #adding counter to subtransaction ID
			  $currCommand =~ s/\<subtransaction id=\"$transactionId\"\>/\<subtransaction id=\"$transactionId-$subtranscounter\"\>/
			}
			#print OUTPUT $currCommand;			
		} 
		
}