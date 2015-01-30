use XML::Twig;
use DBI;

# buffers for holding text
my $catbuf = '';
my $itembuf = '';

our %asis;
our $dbUser='root';
our $dbPasswd='wankdorf';
our $dbPath='sadb_RE3:localhost:3306';
our $execPath='/var/www/html/voipphoneRE3/XSLTWork/POC2';

my $dbh = DBI->connect("dbi:mysql:$dbPath", "$dbUser", "$dbPasswd");
my $fileName = "$execPath/stationOut_originalFormat.xml";


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
  $query = "SELECT id, primary_value FROM c_features where id like '%$stationId%'";
  $query_handle = $dbh->prepare($query);
  
  # EXECUTE THE QUERY
  $query_handle->execute();
  
  # BIND TABLE COLUMNS TO VARIABLES
  $query_handle->bind_columns(undef, \$id, \$primary_value);
  
  # LOOP THROUGH RESULTS
  while($query_handle->fetch()) {
     print "\n$id, $primary_value <br />";
	$asis{$id} = $primary_value;
  } 

}


# handle a feautue element
sub feature {
  my( $tree, $elem ) = @_;
  $id = $elem->att( 'id' ) ;

  $key = $elem->att( 'key' ) . '@' . $elem->parent->att( 'id' );
  $primary = $elem->first_child_text('primary_value');
  $primary =~ s/[\n\r]+//g; 
  $primary =~ s/^\s+//; 
  $primary =~ s/\s+$//; 

  #Check to see if the asis exists and is the same as the todo
  if(exists $asis{$id})
  {
	$status = '4'; # will be used if don't match
	if ($asis{$id} eq $primary)
	{
		$status = '1'; # will be used if match
	}
  }
  else
  {
	$status = '4'; # lookss like added
  } 	
   


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
  $key = $elem->att( 'key' ) . '@' . $elem->parent->parent->att( 'id' );
  $primary = $elem->first_child_text('primary_value');
  $primary =~ s/[\n\r]+//g; 
  $primary =~ s/^\s+//; 
  $primary =~ s/\s+$//; 

  #Check to see if the asis exists and is the same as the todo
  if(exists $asis{$id})
  {
	$status = '4';
	if ($asis{$id} eq $primary)
	{
		$status = '1';
	}
  }
  else
  {
	$status = '4';
  } 	
   


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
