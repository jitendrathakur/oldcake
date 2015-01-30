use XML::Twig;
use DBI;
use Data::Dumper;

# buffers for holding text
my $catbuf = '';
my $itembuf = '';

our %asis;
our %asisFeature;
our $dbUser='dev4';
our $dbPasswd='dev123';
our $dbPath='sadb_lab_RE3:176.28.15.224:3306';
#our $debug = 1;
our $execPath='/var/www/html/voipphoneRE3/XSLTWork/POC2/merged_scripts';

my $dbh = DBI->connect("dbi:mysql:$dbPath", "$dbUser", "$dbPasswd");
my $fileName = "$execPath/stationOut_originalFormat.xml";
open (LOG, "> $execPath/tobpopulator_execution.log");


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

$rc  = $dbh->disconnect;

# handle a station element
sub station {
  my( $tree, $elem ) = @_;
  
  #$statement = "update stationkeys set DN='' WHERE station_id = ?";
  #$rv  = $dbh->do($statement, undef, $elem->att( 'id' )); 
  #$DBI::err && die $DBI::errstr;
  if($debug != 1)
  {
  	$statement = "delete from features WHERE id like ?";
  	$rv  = $dbh->do($statement, undef, '%' . $elem->att( 'id' ) . '%'); 
  	$DBI::err && die $DBI::errstr;
  }
  print STDERR "STATON: ",  $elem->att( 'id' ), "\t", $catbuf;
  $catbuf = '';

  #Populate asis array
  $stationId =  $elem->att( 'id' );
  # PREPARE THE QUERY
  $query = "SELECT id, short_name, primary_value FROM c_features where id like '%$stationId%'";
  $query_handle = $dbh->prepare($query);
  
  # EXECUTE THE QUERY
  $query_handle->execute();
  
  # BIND TABLE COLUMNS TO VARIABLES
  $query_handle->bind_columns(undef, \$id, \$short_name, \$primary_value);

	print STDERR "HERE\n";
  
  # LOOP THROUGH RESULTS
  while($query_handle->fetch()) {
     print STDERR "\n ASIS $id, $short_name, $primary_value <br />";
	$asis{$id} = $primary_value;
	if ($primary_value eq '')
	{
		$primary_value = 'NULL';
	}
	$asisFeature{$primary_value}{$short_name} = $id;
	#$asisFeature{$primary_value} = $short_name;
	print STDERR "building Asis hash asisFeature{$primary_value} = $short_name\n";
  } 

}


# handle a feautue element
sub feature {
  my( $tree, $elem ) = @_;
  $id = $elem->att( 'id' ) ;
  print STDERR "FEATURE : $id\n";

  $key = $elem->att( 'key' ) . '@' . $elem->parent->att( 'id' );
  $primary = $elem->first_child_text('primary_value');
  $primary =~ s/[\n\r]+//g; 
  $primary =~ s/^\s+//; 
  $primary =~ s/\s+$//; 
  $short_name = $elem->first_child_text('short_name');
  $short_name =~ s/[\n\r]+//g; 
  $short_name =~ s/^\s+//; 
  $short_name =~ s/\s+$//; 
  
  if($short_name =~ /DN_(\w+)/)
  {
  	 $short_name = 'DN';
  	 $trail = $1;
  	 print STDERR "DN=> $trail\n";
  }

	if ($primary eq '')
	{
		$primary = 'NULL';
	}


  #------------------checkin Status--------------------
  print STDERR "checking exists asis{$id}\n";
  #Check to see if the asis exists and is the same as the todoz
  if(exists $asis{$id})
  {
  	#if ($asis{$id} eq '')
	#{
	#	$asis{$id} = 'NULL';
	#}
  	print STDERR "YES EXITS\n";
  	print STDERR "checking IF SAME VALUE asis{$id} $asis{$id} : $primary\n";
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
		if(exists $asisFeature{$primary})
		{ 
				if($asisFeature{$primary}{$short_name} ne $id)
				{
					$status = '5'; # lookss like moved
  					print STDERR "$status  MOVED FEATURE\n";
				}
				else
				{				
  					$status = '4'; # lookss like moved
  					print STDERR "$status  MOVED FEATURE\n";
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
  	print STDERR "NOi : DOes not exist\n";
  	
  	#print LOG Dumper(\%asisFeature);
  	print STDERR "checking can find the feature in asis on other key asisFeature{$primary}{$short_name}\n";
  	#if(exists $asisFeature{$primary} && defined $asisFeature{$primary}{$short_name})
  	#if(exists $asisFeature{$primary})
  	#if($asisFeature{$primary} eq $short_name)
  	#if(exists $asisFeature{$primary} && defined $asisFeature{$primary}{$short_name})
  	if($asisFeature{$primary}{$short_name} ne $id)
  	{	
  		$status = '5'; # lookss like moved
  		print STDERR " $status MOVED FEATURE\n";
  	}
  	else
  	{
		$status = '6'; # lookss like added
		print STDERR "$status  ADDED FEATURE\n";
  	}
  } 	
   
#-----------------Ens checkign status---------------------

  if ($elem->att( 'id' ) =~ /.*-(.*)/) { $short_name = $1;}
  if ($short_name eq 'DN')
  {
  	$label = $primary . '<br>';
  }
else
  {
  	$label = $elem->first_child_text('label');
  }
  if($debug != 1)
  {
  	$statement = "insert ignore into features values (?,?,?,?,?,'',NOW(),NOW(),$status,1,1)";
  	$rv  = $dbh->do($statement, undef, $id, $key, $short_name, $primary, $label, $status); 
  	$DBI::err && die $DBI::errstr;
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
  
  print STDERR "\nFEATURE :";
  print STDERR "\t ID :  $id";
  print STDERR "\t KEY :  $key";
  print STDERR "\t SHORTNAME :  $short_name";
  print STDERR "\t PRIMARY :  $primary";
  print STDERR "\t LABEL :  $label";
  $catbuf = '';
}

# handle a feautue elementte
sub child {
  my( $tree, $elem ) = @_;
  $id = $elem->att( 'id' ) ;
  print STDERR "CHILD FEATURE : $id\n";
  $key = $elem->att( 'key' ) . '@' . $elem->parent->parent->att( 'id' );
  $primary = $elem->first_child_text('primary_value');
  $primary =~ s/[\n\r]+//g; 
  $primary =~ s/^\s+//; 
  $primary =~ s/\s+$//; 

  $status = '1'; # will be used if match
  print STDERR "checking exists asis{$id}\n";
  #Check to see if the asis exists and is the same as the todoz
  if(exists $asis{$id})
  {
  	if ($asis{$id} eq '')
	{
		$asis{$id} = 'NULL';
	}
  	print STDERR "YES\n";
  	print STDERR "checking if SAME VALUE asis{$id} $asis{$id} : $primary\n";
	$status = '4'; # will be used if don't match
	if ($asis{$id} eq $primary)
	{
		print STDERR "YES SAME VLAUE\n";
		$status = '1'; # will be used if match
	}
	else
	{
		#print STDERR "ADD CHILDE\n";
		#$status = '6'; # will be used if match
	}

  }
  else{
	#did the parent exist before.
	}
   
#-----------------Ens checkign status---------------------
  #----------End status determine-----------------
   


  $label = $elem->first_child_text('label');
  if ($elem->att( 'id' ) =~ /.*-(.*)/) { $short_name = $1;}
  if($debug != 1)
  {
  	$statement = "insert ignore into features values (?,?,?,?,'','',NOW(),NOW(),?,1,1)";
  	$rv  = $dbh->do($statement, undef, $id, $key, $short_name, $primary, $status); 
  	$DBI::err && die $DBI::errstr;
  }
  print STDERR "\nCHILD FEATURE :";
  print STDERR "\t ID :  $id";
  print STDERR "\t KEY :  $key";
  print STDERR "\t SHORTNAME :  $short_name";
  print STDERR "\t PRIMARY :  $primary";
  print STDERR "\t LABEL :  $label";
  #print "FEATURE: ", $elem->att( 'id' ),$elem->att( 'key' ) . '@' . $elem->parent->parent->att( 'id' ), $short_name, $elem->first_child_text('primary_value') , "\n", $catbuf;
  $catbuf = '';
}


