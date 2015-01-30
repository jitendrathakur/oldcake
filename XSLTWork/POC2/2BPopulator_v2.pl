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
our $execPath='/var/www/html/voipphoneRE3/XSLTWork/POC2';

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
  $statement = "delete from features WHERE id like ?";
  $rv  = $dbh->do($statement, undef, '%' . $elem->att( 'id' ) . '%'); 
  $DBI::err && die $DBI::errstr;
  print "STATON: ",  $elem->att( 'id' ), "\t", $catbuf;
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
  
  # LOOP THROUGH RESULTS
  while($query_handle->fetch()) {
     print "\n$id, $short_name, $primary_value <br />";
	$asis{$id} = $primary_value;
	if ($primary_value eq '')
	{
		$primary_value = 'NULL';
	}
	$asisFeature{$primary_value}{$short_name} = $id;
  } 

}


# handle a feautue element
sub feature {
  my( $tree, $elem ) = @_;
  $id = $elem->att( 'id' ) ;
  print LOG "FEATURE : $id\n";

  $key = $elem->att( 'key' ) . '@' . $elem->parent->att( 'id' );
  $primary = $elem->first_child_text('primary_value');
  $primary =~ s/[\n\r]+//g; 
  $primary =~ s/^\s+//; 
  $primary =~ s/\s+$//; 
  $short_name = $elem->first_child_text('short_name');
  $short_name =~ s/[\n\r]+//g; 
  $short_name =~ s/^\s+//; 
  $short_name =~ s/\s+$//; 

	if ($primary eq '')
	{
		$primary = 'NULL';
	}


  #------------------checkin Status--------------------
  print LOG "checking exists asis{$id}\n";
  #Check to see if the asis exists and is the same as the todoz
  if(exists $asis{$id})
  {
  	if ($asis{$id} eq '')
	{
		$asis{$id} = 'NULL';
	}
  	print LOG "YES\n";
  	print LOG "checking  SAME VALUE asis{$id} $asis{$id} : $primary\n";
	$status = '4'; # will be used if don't match
	if ($asis{$id} eq $primary)
	{
		print LOG "YES\n";
		$status = '1'; # will be used if match
	}
	else
	{
		print LOG "NO\n";

	}
  }
  else
  {
  	print LOG "NOi : DOes not exist\n";
  	
  	#print LOG Dumper(\%asisFeature);
  	print LOG "checking asisFeature{$primary}{$short_name}\n";
  	if(exists $asisFeature{$primary} && defined $asisFeature{$primary}{$short_name})
  	{	
  		$status = '5'; # lookss like moved
  		print LOG "MOVED FEATURES\n";
  	}
  	else
  	{
		$status = '4'; # lookss like added
		print LOG "ADDED FEATURES\n";
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
  $statement = "insert ignore into features values (?,?,?,?,?,'',NOW(),NOW(),$status,1,1)";
  $rv  = $dbh->do($statement, undef, $id, $key, $short_name, $primary, $label, $status); 
  $DBI::err && die $DBI::errstr;
  
  
  #Temporary workaround until staitonky DN is correctly modeled
  if($short_name eq 'DN')
  {	
  	$statement = "update stationkeys set DN=? where id=? ";
  	$rv  = $dbh->do($statement, undef,$primary, $key); 
  	$DBI::err && die $DBI::errstr;
  }
  
  print "\nFEATURE :";
  print "\t ID :  $id";
  print "\t KEY :  $key";
  print "\t SHORTNAME :  $short_name";
  print "\t PRIMARY :  $primary";
  print "\t LABEL :  $label";
  $catbuf = '';
}

# handle a feautue elementte
sub child {
  my( $tree, $elem ) = @_;
  $id = $elem->att( 'id' ) ;
  print LOG "FEATURE : $id\n";
  $key = $elem->att( 'key' ) . '@' . $elem->parent->parent->att( 'id' );
  $primary = $elem->first_child_text('primary_value');
  $primary =~ s/[\n\r]+//g; 
  $primary =~ s/^\s+//; 
  $primary =~ s/\s+$//; 


  print LOG "checking exists asis{$id}\n";
  #Check to see if the asis exists and is the same as the todoz
  if(exists $asis{$id})
  {
  	if ($asis{$id} eq '')
	{
		$asis{$id} = 'NULL';
	}
  	print LOG "YES\n";
  	print LOG "checking  SAME VALUE asis{$id} $asis{$id} : $primary\n";
	$status = '4'; # will be used if don't match
	if ($asis{$id} eq $primary)
	{
		print LOG "YES\n";
		$status = '1'; # will be used if match
	}
  }
  else
  {
  	print LOG "NOi : DOes not exist\n";
  	
  	print LOG Dumper(\%asisFeature);
  	print LOG "checking asisFeature{$primary}{$short_name}\n";
  	if(exists $asisFeature{$primary} && defined $asisFeature{$primary}{$short_name})
  	{	
  		$status = '5'; # lookss like moved
  		print LOG "MOVED FEATURES\n";
  	}
  	else
  	{
		$status = '4'; # lookss like added
		print LOG "ADDED FEATURES\n";
  	}
  } 	
   
#-----------------Ens checkign status---------------------
  #----------End status determine-----------------
   


  $label = $elem->first_child_text('label');
  if ($elem->att( 'id' ) =~ /.*-(.*)/) { $short_name = $1;}
  $statement = "insert ignore into features values (?,?,?,?,'','',NOW(),NOW(),?,1,1)";
  $rv  = $dbh->do($statement, undef, $id, $key, $short_name, $primary, $status); 
  $DBI::err && die $DBI::errstr;
  print "\nCHILD FEATURE :";
  print "\t ID :  $id";
  print "\t KEY :  $key";
  print "\t SHORTNAME :  $short_name";
  print "\t PRIMARY :  $primary";
  print "\t LABEL :  $label";
  #print "FEATURE: ", $elem->att( 'id' ),$elem->att( 'key' ) . '@' . $elem->parent->parent->att( 'id' ), $short_name, $elem->first_child_text('primary_value') , "\n", $catbuf;
  $catbuf = '';
}

sub recreate2b
{
	use DBI;
$dbh = DBI->connect($data_source, $username, $auth, \%attr);
$statement = "UPDATE some_table SET som_col = ? WHERE id = ?";
$rv  = $dbh->do($statement, undef, $som_val, $id); 
$DBI::err && die $DBI::errstr;
$rc  = $dbh->disconnect;
	
}
