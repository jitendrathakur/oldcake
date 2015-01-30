use XML::Twig;
use DBI;
use Data::Dumper;
use FindBin qw($Bin);
my $binDir = $Bin;
use lib "$Bin/lib";
use Config::Any::INI;
use Config::Any::XML;

my $binDir = $Bin;

# buffers for holding text
my $catbuf = '';
my $itembuf = '';
our %asis; # arrau holding all current feature keys
our %tobeKey; # arrau holding all current feature keys
our $asisBlankAudKey; # array holding blank AUD in ASIS DB (cfeatures)
our $asisBlankAudFeature; # array holding blank AUD in ASIS DB (cfeatures)
our %asisFeature;

my $inputFileName = shift(@ARGV);


#Now read config settings
my $config_file = 'config.ini';
my $config_path = $binDir . '/etc/' .$config_file;
 #-e "$config_path" or croak "Config file config.ini does not exist\n";

my $config = Config::Any::INI->load("$config_path");
#print Dumper $config;
print STDERR "CONFIG mysql server $config->{mysql}->{host}";

#our $dbUser='dev4';
#our $dbPasswd='dev123';
#our $dbPath='sadb_lab_RE3:176.28.15.224:3306';
our $dbUser=$config->{mysql}->{username};
our $dbPasswd=$config->{mysql}->{password};
our $dbPath=$config->{mysql}->{db} . ':' . $config->{mysql}->{host} . ':' . $config->{mysql}->{port};

#our $debug = 1;


my $dbh = DBI->connect("dbi:mysql:$dbPath", "$dbUser", "$dbPasswd");
my $fileName = "$binDir/$inputFileName";
open (LOG, "> $binDir/tobpopulator_execution.log");


#my $fileName = shift @ARGV;
# initialize parser with handlers for node processing
my $twigStation= new XML::Twig( TwigHandlers => { 
	                            "/Configuration/Station"    => \&station,

                                          });

# parse, handling nodes on the way
$twigStation->parsefile($fileName);

# initialize parser with handlers for node processing
my $twig= new XML::Twig( TwigHandlers => { 
                             "/Configuration/Station/feature"    => \&feature,
                             "/Configuration/Station/feature/cfeature"    => \&child,
                                          });

# parse, handling nodes on the way
$twig->parsefile( $fileName);




#At the end of the process identify the keys that have had features deleted.

foreach $keyt (keys %asisKey)
 {
  			print STDERR "Checking Delete for : $keyt\t : ";
  			if($tobeKey{$keyt})
  			{
  				print STDERR " EXISTS\n";
  				
  			}
  			else
  			{
  				#Check if the existing feature in cfeature was AUD with blank priamry_value. If so repopulate
  				
  				if($asisBlankAudKey{$keyt} == 1)
  				{
  					#means there is a blank AUD
  					print STDERR "BLANK AUD ON KEY $keyt - REPOPULATING BLANK AUD\n";
  					
  					my $blankAudFeature = $keyt . '-AUD';
  					#First update the features table creating the features.
  					$statement = "insert ignore into features values (?,?,?,?,'','',NOW(),NOW(),?,1,1,1)";
  					#$rv  = $dbh->do($statement, undef, $id, $key, $short_name, $primary, $status); 
  					#$DBI::err && die $DBI::errstr;
  					$rv  = $dbh->do($statement, undef, $blankAudFeature, $keyt, 'AUD', '', 1); 
  					$DBI::err && die $DBI::errstr;
  	
  				}
  				else
  				{

	  				print STDERR "!! FEATURE DELETED !!\n";
	  				$statement = "update stationkeys set status = 7 WHERE id = ?";
	  				$rv  = $dbh->do($statement, undef, $keyt); 
	  				$DBI::err && die $DBI::errstr;
  				}
  			}
 }


foreach $asisFeature (keys %asisDeleteFeatureCheck)
 {
 	print STDERR "Checking Delete for : $feature\t : ";
 	if($tobeFeature{$asisFeature})
  			{
  				print STDERR " EXISTS\n";
  				
  			}
  			else
  			{
  				if($asisBlankAudFeature{$asisFeature} == 1)
  				{
  					#means there is a blank AUD FEature $asisFeature
  					print STDERR "BLANK AUD  - DO NOTHING\n";
    	
  				}
  				else
  				{
  					print STDERR "!! FEATURE DELETED !!\n";
	  				$statement = "update c_features set status = 7 WHERE id = ?";
	  				$rv  = $dbh->do($statement, undef, $asisFeature); 
	  				$DBI::err && die $DBI::errstr;	
  				}
  			}
 }



$rc  = $dbh->disconnect;

# handle a station element
sub station {
  my( $tree, $elem ) = @_;
  
  #$statement = "update stationkeys set DN='' WHERE station_id = ?";
  #$rv  = $dbh->do($statement, undef, $elem->att( 'id' )); 
  #$DBI::err && die $DBI::errstr;
  if($debug != 1)
  {
  	#$statement = "delete from features WHERE id like ?"; # original
  	#delete only the main features. not expansion modules	
  	$statement = "delete f from features f left join stationkeys sk on f.stationkey_id = sk.id WHERE sk.station_id = ? and sk.keynumber < 15";
  	$rv  = $dbh->do($statement, undef, $elem->att( 'id' )); 
  	$DBI::err && die $DBI::errstr;
  	
  	#delete the instruction features (99)
  	
  	$statement = "delete f from features f where f.id REGEXP ?";
  	$requestFeature = '^99@' . $elem->att( 'id' );
  	$rv  = $dbh->do($statement, undef, $requestFeature); 
  	$DBI::err && die $DBI::errstr;
  	
  	$statement = "update stationkeys set status = 1 WHERE station_id = ?";
  	$rv  = $dbh->do($statement, undef, $elem->att( 'id' )); 
  	$DBI::err && die $DBI::errstr;
  }
  print STDERR "\nSTATON: ",  $elem->att( 'id' ), "\t", $catbuf;
  $catbuf = '';

  #Populate asis array
  $stationId =  $elem->att( 'id' );
  # PREPARE THE QUERY
  #$query = "SELECT id, stationkey_id, short_name, primary_value FROM c_features where id like '%$stationId%'";
  #Get only the 1-15 asis features
  $query = "SELECT f.id, f.stationkey_id, f.short_name, f.primary_value FROM c_features f left join stationkeys sk on f.stationkey_id = sk.id where sk.station_id = '$stationId' and sk.keynumber < 15";
  
  
  $query_handle = $dbh->prepare($query);
  
  # EXECUTE THE QUERY
  $query_handle->execute();
  
  # BIND TABLE COLUMNS TO VARIABLES
  $query_handle->bind_columns(undef, \$id, \$stationkey_id, \$short_name, \$primary_value);

  
  # LOOP THROUGH RESULTS
  while($query_handle->fetch()) {
     print STDERR "\n ASIS $id, $stationkey_id, $short_name, $primary_value <br />";
	
	if (($primary_value eq '') && ($short_name eq 'AUD'))
	{
		#$primary_value = 'NULL';
		$asisBlankAudKey{$stationkey_id} = 1;
		$asisBlankAudFeature{$id} = 1;
	}
	$asis{$id} = $primary_value;
	$asisKey{$stationkey_id} = 1;
	$asisFeature{$primary_value}{$short_name} = $id;
	$asisDeleteFeatureCheck{$id} = 1;
	#$asisFeature{$primary_value} = $short_name;
	#print STDERR "building Asis hash asis{$primary_value} = $short_name\n";
	print STDERR "building Asis hash asisFeature{$primary_value}{$short_name} = $id\n" if $debug;
  } 
if(! keys (%asisFeature))
{
	print STDERR "\n\n!! ASIS IS EMPTY !!\n\n" if $debug;
} 
#print STDERR Dumper(%asisFeature);

}


# handle a feautue element
sub feature {
	
	
  my( $tree, $elem ) = @_;
  $id = $elem->att( 'id' ) ;
  print STDERR "\nSTART OF FEATURE : $id\n";

  $key = $elem->att( 'key' ) . '@' . $elem->parent->att( 'id' );
  $tobeKey{$key} = 1;
  $tobeFeature{$id} = 1;
  $primary = $elem->first_child_text('primary_value');
  $primary =~ s/[\n\r]+//g; 
  $primary =~ s/^\s+//; 
  $primary =~ s/\s+$//; 
  $short_name = $elem->first_child_text('short_name');
  
  $short_name =~ s/[\n\r]+//g; 
  $short_name =~ s/^\s+//; 
  $short_name =~ s/\s+$//; 
  
  if ($short_name eq '')
  {
  	#create from id
  	if($id =~ /\d+\@\d+\-(\w+)/)
  	{
  	 	$short_name = $1;
  	}
  	
  }
  
  print STDERR "short_name 1: $short_name ";
  
  if($short_name =~ /DN_(\w+)/)
  {
  	 $short_name = 'DN';
  	 $trail = $1;
  	 print STDERR " TRANSFORMED TO DN WITH TRAIL=> $trail\n";
  }

   
	if ($primary eq '')
	{
		#$primary = 'NULL';
	}


  #------------------checkin Status--------------------
  
  #print STDERR Dumper(%asisFeature);
  print STDERR "1checking exists asis{$id}\n";
  #Check to see if the asis exists and is the same as the todoz
  if(exists $asis{$id})
  {
  	#if ($asis{$id} eq '')
	#{
	#	$asis{$id} = 'NULL';
	#}
  	print STDERR "YES EXITS\n";
  	print STDERR "checking 1 IF SAME VALUE asis{$id} =>  $asis{$id} : $primary\n";
	#$status = '4'; # will be used if don't match
	if ($asis{$id} eq $primary)
	{
		print STDERR "YES SAME VALUE\n";
		$status = '1'; # will be used if match
	}
	else
	{
		#Check if exists on other key (to capture AUD/BLF)
		print STDERR "NO DIFFERENT VALUES\n";
		#$status = '4'; # lookss like moved
  		#print STDERR "$status  UPDATED FEATURE\n";
  			
  			
		#if($asisFeature{$primary} eq $short_name)
		#Check if the same primary_value is on another key (to check it is is a move rather than update)
		print STDERR "CHECKING asisFeature{$primary}{$short_name}\n";
		if(exists($asisFeature{$primary}))
		{ 
				if($asisFeature{$primary}{$short_name} ne $id)
				{
					$status = '5'; # lookss like moved
  					print STDERR "$status  MOVED FEATURE\n";
				}
				else
				{				
  					$status = '4'; # lookss like updated
  					print STDERR "$status  UPDATED FEATURE\n";
  				}	
  			
  		}
  		else
  		{
			$status = '6'; # lookss like added	
			print STDERR "$status  ADDED FEATURE\n";
  		}
		
	}
  }
  else
  {
  	#print STDERR Dumper(%asisFeature);
  	print STDERR "NOi : DOes not exist\n";
  	
  	
  	#print Dumper(\%asisFeature);
  	print STDERR "checking can find the feature in asis on other key IF asisFeature{$primary}{$short_name} NE : $id\n";
 
  	if(exists($asisFeature{$primary}) && defined($asisFeature{$primary}{$short_name}))
  	{
  		
  		print STDERR "YEs : Primary_value $primary  DOes  exist\n";
  		#print STDERR Dumper(%asisFeature);
  		#%tarray = $asisFeature{$primary};
  		#foreach $keyt (keys %tarray)
  		#{
  		#	print STDERR "$keyt : $tarray{$keyt}\n";
  		#}
  		
  		#if($asisFeature{$primary}{$short_name} ne $id)
  		#{	
  			$status = '5'; # lookss like moved
  			print STDERR " $status MOVED FEATURE\n";
  		#}
  	}
  	else
  	{
  		print STDERR "NOO : Primary_value $primary DOes  NOT exist\n";
		$status = '6'; # lookss like added
		print STDERR "$status  ADDED FEATURE\n";
  	}
  } 	
   
#-----------------Ens checkign status---------------------

  if ($elem->att( 'id' ) =~ /.*-(.*)/) { $short_name = $1;}
  #Workaround to make sure 2 digit.
  if ($id =~ /^\d\d.*/) 
  { 
  		#This is correct
  }
  else
  {
  		$id = '0' . $id;
  }
  
  if ($short_name eq 'DN')
  {
  	$label = $primary . '<br>';
  }
else
  {
  	$label = $elem->first_child_text('label');
  	$label =~ s/[\n\r]+//g; 
  	$label =~ s/^\s+//; 
 	 $label =~ s/\s+$//; 
  }
  if($debug != 1)
  {
  	#First update the features table creating the features.
  	$statement = "insert ignore into features values (?,?,?,?,?,'',NOW(),NOW(),?,1,1,1)";
  	$rv  = $dbh->do($statement, undef, $id, $key, $short_name, $primary, $label, $status); 
  	$DBI::err && die $DBI::errstr;
  	
  	#Now change the state of the stationkeys based on the features
  	
  	
  	if(($status == 5) || ($status == 6))
  	{
  			if($asisKey{$key} == 1)
  			{
  				#If feature has been moved or added to a key 
  				#And the key has a record in the ASIS model.
  				#then replace all the features on that key by setting the activation to REPLACE.
  				
  				#???This is poor logic becasue on key 1 if there are station features that are added it will casue that key to be replaced.
  				# This means all features are replaced on key 
  				
  				  	$statement = "update stationkeys set status=? where id=? ";
  					$rv  = $dbh->do($statement, undef,5, $key); 
  					$DBI::err && die $DBI::errstr;
  					print STDERR "SETTING KEY STATUS : $key : REPLACE (5) ";
  				
  			}
  			else
  			{
  				  	#If feature has been moved or added to a key 
  					#And the key has 0 feature record in the ASIS model.
  					#then replace all the features on that key by setting the activation to ADD.
  				  	$statement = "update stationkeys set status=? where id=? ";
  					$rv  = $dbh->do($statement, undef,6, $key); 
  					$DBI::err && die $DBI::errstr;
  					
  					print STDERR "SETTING KEY STATUS : $key : ADD (6) ";

  			}

  	}

  }
  
  
  #Temporary workaround until staitonky DN is correctly modeled
  if($short_name eq 'DN')
  {	
  	if($debug != 1)
  	{
  		$statement = "update stationkeys set DN=? where id=? ";
  		$rv  = $dbh->do($statement, undef,$primary, $key); 
  		$DBI::err && die $DBI::errstr;
  		
  		
  		
  	}
  }
  
  print STDERR "\n END OF FEATURE :";
  print STDERR "\t ID :  $id";
  print STDERR "\t KEY :  $key";
  print STDERR "\t SHORTNAME :  $short_name";
  print STDERR "\t PRIMARY :  $primary";
  print STDERR "\t LABEL :  $label\n";
  $catbuf = '';
}

# handle a feautue elementte
sub child {
  my( $tree, $elem ) = @_;
  $id = $elem->att( 'id' ) ;
  $tobeFeature{$id} = 1;
  
  print STDERR "\nSTART CHILD FEATURE : $id\n";
  $key = $elem->att( 'key' ) . '@' . $elem->parent->parent->att( 'id' );
  $primary = $elem->first_child_text('primary_value');
  $requestedStatus = $elem->first_child_text('status');
  $primary =~ s/[\n\r]+//g; 
  $primary =~ s/^\s+//; 
  $primary =~ s/\s+$//; 

  if ($primary eq '')
	{
		#$primary = 'NULL';
	}
	
$status = '1'; # will be used if match
  print STDERR "checking exists asis{$id}\n";
  #Check to see if the asis exists and is the same as the todoz
  if(exists $asis{$id})
  {
  	#if ($asis{$id} eq '')
	#{
	#	$asis{$id} = 'NULL';
	#}
  	print STDERR "YES\n";
  	print STDERR "checking 2 if SAME VALUE asis{$id} => $asis{$id} : $primary\n";
	$status = '4'; # will be used if don't match
	if ($asis{$id} eq $primary)
	{
		print STDERR "YES SAME VLAUE\n";
		if($requestedStatus == 4)
		{
			$status = '4'; # If there cfeature was requested to be updated. it will override , even if the feature hasn't changed (used for CFUMEMBER)
			#$status = '1'; # will be used if match
		}
		else
		{
			$status = '1'; # will be used if match
		}
	}
	else
	{
		print STDERR "NO DIFFERENT VALUEs\n";
		print STDERR "SETTING FEATURE STATUS : $id : UPDATE (6) ";
		
		#$status = '6'; # will be used if match
	}

  }
  else{
	#did the parent exist before.
	}
   
#-----------------Ens checkign status---------------------
  #----------End status determine-----------------
   


  $label = $elem->first_child_text('label');
  $label =~ s/[\n\r]+//g; 
  $label =~ s/^\s+//; 
  $label =~ s/\s+$//;
  if ($elem->att( 'id' ) =~ /.*-(.*)/) { $short_name = $1;}
  #Workaround to make sure 2 digit.
  if ($id =~ /^\d\d.*/) 
  { 
  		#This is correct
  }
  else
  {
  		$id = '0' . $id;
  }
  if($debug != 1)
  {
  	
  	
  	
  	$statement = "insert ignore into features values (?,?,?,?,'','',NOW(),NOW(),?,1,1,1)";
  	$rv  = $dbh->do($statement, undef, $id, $key, $short_name, $primary, $status); 
  	$DBI::err && die $DBI::errstr;
  	
  }
  print STDERR "\nEND CHILD FEATURE :";
  print STDERR "\t ID :  $id";
  print STDERR "\t KEY :  $key";
  print STDERR "\t SHORTNAME :  $short_name";
  print STDERR "\t PRIMARY :  $primary";
  print STDERR "\t LABEL :  $label\n";
  #print "FEATURE: ", $elem->att( 'id' ),$elem->att( 'key' ) . '@' . $elem->parent->parent->att( 'id' ), $short_name, $elem->first_child_text('primary_value') , "\n", $catbuf;
  $catbuf = '';
}


