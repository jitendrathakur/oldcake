#!/usr/bin/perl
use strict;
use XML::LibXML::PrettyPrint;
use XML::XPath;
use XML::XPath::XMLParser;

my $currentKey;
my $waitingKey;
my ($inContent,$allFeatures,$newFeature,$featureName,$fullNewFeature,@keyset,@notKeyset,$newF,$newFFull,$fullParent,$con,$nDK,$nP,$nS,$nC,$exitFlag,$existingkey,$desiredkey,$index,@notkeyset,$station,$existingFeatures,$currentMatch,$currentName,$currentID,$cstring,$val,$nnDK,$key,$kkey,$extF,$eP,$eS,$eC,$notKeyset,$lk,$llk,%seen,$afullParent,$fullPrt,$feature,$nfeature,$pfname,$id,$newkey,$oldkey,$fname,$achild,$mainkey,$childern,$fid,$updateFeature,$childName,$defval,$ckey,$fid,$stationAttr,$nSN,$nM,$staid,$completeNewFeature,$dstring,$addNF);

my $binDir = 'E:/work/craig/blank_key';
#my $binDir = '/var/www/html/voipphoneRE3/XSLTWork/POC2/merged_scripts';

#edit mode "feature" for feature Mode and "activation" for activation Mode
my $mode ="feature";
#my $mode = shift(@ARGV);
my $layoutFile = "CICMconfig.xml";
#my $layoutFile = shift(@ARGV);
#provide input file name
my $inputFileName = "pos2.input.xml";
#my $inputFileName = shift(@ARGV);

print STDERR "PROCESSOR mode => $mode, layout $layoutFile, input $inputFileName\n";




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
	#adding attribute old="" to save the value of old key
	$fullParent = &oldkey;	
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
    	
		
    	$fullParent=&assignkey ($newFeature,$fullNewFeature,$fullParent); 
    }
   
    
    #Keys assigned to feature re-arranging final output	
	    $fullParent = &reassurekey;
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
	
	sub reassurekey()
	{   
	    #output of assignkey function would be the input of this function
	    my $rkey =""; my $rname=""; my @rpriority = ""; my $rassign =""; my $rfullParent = $fullParent; my $rnewFullParent = ""; my $rprimary =""; my $rfeature = "";
		
		 #traversing over each feature
		 while($fullParent =~ /(<feature id=\"([^\"]*)\" key="(.*?)".*?<\/feature>)/msg)
		 {
		   $rfeature = $1;
		   $rkey = $3;
		   $rname = $2;
		   #extracting the name of feature
		   $rname =~ s/.*-(.*)/$1/;
		   #extracting the primary value of feature
		   if($rfeature =~ /\<primary_value\>(.*?)\<\/primary_value>/)
		   {
			$rprimary = $1;
		   }
		   
		   #arranging the priority of given features in descending order
		   if ($con =~ /<d?feature name="$rname" short_name="([^\"]*)" type="([^\"]*)" mandatory="([^\"]*)" defaultKey="([^\"]*)" priority="([^\"]*)" shiftable="([^\"]*)" coloc="([^\"]*)" defaultValue="([^\"]*)".*?\/>/ms) #getting various values like priority, shiftable, colocatable from config file for the new feature
		   {		 
		        push(@rpriority,"$5-$rname-$rprimary-$2"); @rpriority = reverse sort @rpriority;		   
		   }		   
		 }
		 my $rcount = 1;
		 foreach $rassign (@rpriority)
		 {
			
		    my $rnewname = "";
			
			if($rassign =~ /.*-(.*)-(.*)-(.*)/)
			{
				
				$rnewname = $1;
			    
			}
			my $rnfeat = ""; my $rnkey ; my $rnprimary =""; my $rnname = "";
			
		    while($rfullParent =~ /(<feature id=\"([^\"]*)\" key="(.*?)".*?<\/feature>)/msg)
			{
			    $rnfeat = $1;
				$rnkey = $3;
				$rnname = $2;
				$rnname =~ s/.*-(.*)/$1/;
				if($rnfeat =~ /\<primary_value\>(.*?)\<\/primary_value>/)
				{
					$rnprimary = $1;
				}
				if($rassign =~ /.*-$rnname-$rnprimary-key/)
				{   
				     
                    
				    my $rncount = "";
					if (length($rcount)==1){$rncount = "0$rcount";} else {$rncount=$rcount;}
					
					#giving the key to each feature in ascending order from 1 to no. of feature
					$rnfeat =~ s/key="(.*?)"/key="$rncount"/;
					$rnfeat =~ s/id=".*(@.*?)"/id="$rncount$1"/;
					$rcount++;
					$rnewFullParent .= $rnfeat;
				}
				
			}
			
		 }
		 return $rnewFullParent;
	}
    
    #Arrange IDs of final output, just to arrange feature in order of key assigned by business logic
    sub arrangeID
    {
    	
    	foreach $key (1..54)	
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
			if($feature =~ /old="(.*?)"/ms)
			{
				$ok = $1;				
			}
    		
    		if ($id=~/([0-9]+)@([0-9]+#.*)/)
    		{
    			 
    			$newkey=$1; $oldkey=$2; $oldkey=~s/#/@/;
				
				#$oldkey =~ s/.*@/$ok@/ms;
				
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
    			while ($cstring=~/(<cfeature id="$oldkey\-([^\"]*)" key="[^\"]*">.*?<\/cfeature>)/msg)
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
			my $parentValue = "";
			
			
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
    	my $tempfullprt = ""; 
    	$fullPrt = $fullParent;
    	if ($station =~ /id=\"([^\"]*)\"/ms) {$staid = $1;}
    	while ($con =~ /<feature name="([^\"]*)" short_name="([^\"]*)" type="station" mandatory="y" defaultKey="([^\"]*)" priority="[^\"]*" shiftable="n" coloc="([yn])" defaultValue="([^\"]*)"\/>/msg)
    	{	
    		my $name = $2; my $defkey = $3; my $defVal = $5; my $coloc=$4;
    		if (($fullParent !~ /<feature id="[^\-]*\-$name"/) and ($completeNewFeature !~ /<feature id="[^\-]*\-$name"/))
    		{	
    			if (length($defkey)==1){$defkey="0$defkey"; }			
    			
    				if (length($defkey)==1){$defkey="0$defkey"; }
    				$tempfullprt .= "<feature id=\"$defkey\@$staid\-$name\" key=\"$defkey\"><primary_value>$defVal<\/primary_value></feature>";				
    			
    			
    		}
    		
    	}
    	#print "$fullPrt";
    	return $tempfullprt.$fullPrt;
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
    	
    	#my $document = XML::LibXML->new->parse_file("$binDir/stationOut.xml");
    	#my $pp = XML::LibXML::PrettyPrint->new(indent_string => "  ");
    	#$pp->pretty_print($document); # modified in-place
    	#open (Fout,">$binDir/stationOut.xml");
    	#my $ppXML = $document->toString;
    	#print Fout $ppXML;
    	#close Fout;
    	
    }

}
elsif($mode eq 'activation')
{        
    
#provide path of directory where code is installed
#my $appDir = 'E:/work/craig/sample';



#provide config file name
#my $configFileName = "CICMconfig.xml";

#output file will be created by name output_xml.xml
my $outputFileName = "output_xml.xml";
my $config = ""; my $inputXML = ""; my $currentMatch = ""; my $currentName="";	my $currentID = "";	my $xPath = ""; my $parse = ""; my $nodeValue = ""; my $varName = ""; my $action = "";my $key = "";
my $startKey=""; my $endKey=""; my $transactionId=""; my $transactionIdCounter = 1;my $primary_value = ""; my $allActions = ""; my $addKey = ""; my $deleteKey = ""; my $replaceKey = "";  my $updateKey = "";
my $updateFeatureID = ""; my $addFeatureID = ""; my $deleteFeatureID = ""; my $replaceFeatureID = ""; my $completeID = ""; my $tobePort = ""; my $asisPort = "";
my $tobe = ""; my $asis =""; my $parentKey = ""; my $parentName = ""; my $tobeList = ""; my $asisList = "";
undef $/;

#creating handler for config file
open (CONFIG, "$binDir/$layoutFile") or die "could not open config file";
$config = <CONFIG>; 

$config = &ReplaceRequired (); 

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
		    &StartProcess('','','',$updateKey,'','','',$updateFeatureID);
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
		if($tobeList =~ /$parentName:$key/msg)
		{ 
		   $finalParent = $parentName;
		}
	}
	
	#evaluating the xpaths of each activation element	
	while($config =~ /(\<(delete)Command.*?\>)/msg)
	{   
	    $action = $2;
	    my $addCommand = $1;	
		#putting condition for a valid activation command such as its activation command present in config, required and key value lies between start key and end key
		if ( ($addCommand =~ /linkto=\"$finalParent:$currentName\"/ or $addCommand =~ /linkto=\"$currentName\"/)	  and  $addCommand =~ /required=\"y\"/	  and   (($key == $deleteKey) or ($key == $replaceKey)) )
			{	
			    
			    if($key == $deleteKey)
				{
				  if($deleteFeatureID != '')
                  {
				    if($deleteFeatureID eq $completeID)
					{
					  &GenerateCommand($action, $addCommand, $transactionIdCounter, $transactionId, $parse, $primary_value, $currentID, $currentName, $key, $asisPort);
					  $transactionIdCounter++;
					}
                  }
                  else
				  {
					  &GenerateCommand($action, $addCommand, $transactionIdCounter, $transactionId, $parse, $primary_value, $currentID, $currentName, $key, $asisPort);
					  $transactionIdCounter++;
				  }				  
				}
				elsif($key == $replaceKey)
				{
				  if($replaceFeatureID != '')
                  {
				    if($replaceFeatureID eq $completeID)
					{
					  &GenerateCommand($action, $addCommand, $transactionIdCounter, $transactionId, $parse, $primary_value, $currentID, $currentName, $key, $asisPort);
					  $transactionIdCounter++;
					}
                  }
                  else
				  {
					  &GenerateCommand($action, $addCommand, $transactionIdCounter, $transactionId, $parse, $primary_value, $currentID, $currentName, $key, $asisPort);
					  $transactionIdCounter++;
				  }				  
				}
				
			}
		
		
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
	    my $addCommand = $1;	
		#putting condition for a valid activation command such as its activation command present in config, required and key value lies between start key and end key
		if( ($addCommand =~ /linkto=\"$finalParent:$currentName\"/ or $addCommand =~ /linkto=\"$currentName\"/)	  and	  $addCommand =~ /required=\"y\"/	  and   (($key == $addKey  and $action eq 'add')	or	($key == $replaceKey  and $action eq 'add')	or  ($key == $updateKey  and $action eq 'update')) )
		{  
            if($key == $addKey)
			{
			  if($addFeatureID != '')
			  {  
			    if($addFeatureID eq $completeID)
				{
				  &GenerateCommand($action, $addCommand, $transactionIdCounter, $transactionId, $parse, $primary_value, $currentID, $currentName, $key, $tobePort);
				  $transactionIdCounter++;
				}
			  }
			  else
			  {
				  &GenerateCommand($action, $addCommand, $transactionIdCounter, $transactionId, $parse, $primary_value, $currentID, $currentName, $key, $tobePort);
				  $transactionIdCounter++;
			  }				  
			}
            elsif($key == $replaceKey)
			{
			  if($replaceFeatureID != '')
			  {
				if($replaceFeatureID eq $completeID)
				{
				  &GenerateCommand($action, $addCommand, $transactionIdCounter, $transactionId, $parse, $primary_value, $currentID, $currentName, $key, $tobePort);
				  $transactionIdCounter++;
				}
			  }
			  else
			  {
				  &GenerateCommand($action, $addCommand, $transactionIdCounter, $transactionId, $parse, $primary_value, $currentID, $currentName, $key, $tobePort);
				  $transactionIdCounter++;
			  }				  
			}
			elsif($key == $updateKey)
			{ ;
			  if($updateFeatureID != '')
			  {  
				if($updateFeatureID eq $completeID)
				{ 
				  &GenerateCommand($action, $addCommand, $transactionIdCounter, $transactionId, $parse, $primary_value, $currentID, $currentName, $key, $tobePort);
				  $transactionIdCounter++;
				}
			  }
			  else
			  {
				  &GenerateCommand($action, $addCommand, $transactionIdCounter, $transactionId, $parse, $primary_value, $currentID, $currentName, $key, $tobePort);
				  $transactionIdCounter++;
			  }				  
			}
			
		}
		
	}
}




}

sub ReplaceRequired
{	
	my $newConfig = $config;
	my $parser = XML::XPath->new(filename => "$binDir/$inputFileName");
	
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
}

sub GenerateCommand
{
		my ($action, $addCommand, $transactionIdCounter, $transactionId, $parse, $primary_value, $currentID, $currentName, $key, $tobePort) = (@_);
		my $varName = "";
		my $xPath = "";		
		my $actObject = "";
		my $actCommand = "";
		#my $stid = "";
		#e.g <deleteCommand name="delete-AUD_FEATURE"
		if($addCommand =~ /.*Command\s+name=\"(\w+)-([\w_]+)\"/)
		{
			$actObject = $2;
			$actCommand = $1;
			#print STDERR "LINE : $addCommand \n actObj $actObject actCommand $actCommand\n";
		}
		print OUTPUT "\n\t<subtransaction id=\"$transactionId-$transactionIdCounter\">\n\t\t<algRequest>\n\t\t\t<object action=\"$actCommand\" name=\"$actObject\">\n\t\t\t\t<message station=\"$tobePort\" key=\"$key\">";		
		while($addCommand =~ /(var-.*?\s)/msg)
		{   			    
			$varName = $1;
			$xPath = $1;
			$xPath =~ s/.*\"(.*)\".*/$1/;								
			$varName =~ s/=.*//;
			$varName =~ s/var-//;		
			my $nodeValue = "";				
			if($xPath =~ /xpath:/)	{ $xPath =~ s/.*xpath:|\"//msg;	$nodeValue = $parse->findvalue($xPath); }				
			elsif($xPath =~ /element:/)	{  $xPath =~ s/element\://;
				  if($primary_value =~ /\<$xPath\>(.*?)\<\/$xPath\>/)  { $nodeValue = $1;  }					  
										}
			elsif($xPath =~ /attribute:/) {  $xPath =~ s/attribute\://;
				  if($primary_value =~ /$xPath\=\"(.*?)\"/) { $nodeValue = $1;  }					  
										  }
			elsif($xPath =~ /default:/)	{ $xPath =~ s/.*default:|\"//msg;	$nodeValue = $xPath;}
			
			print OUTPUT "\n\t\t\t\t<var value=\"$nodeValue\" name=\"$varName\"/>";
		
		}
					 
		print OUTPUT "\n\t\t\t\t</message>\n\t\t\t</object>\n\t\t</algRequest>\n\t</subtransaction>";
}