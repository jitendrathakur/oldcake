use XML::Twig;
use DBI;
use Data::Dumper;

# buffers for holding text
my $catbuf = '';
my $itembuf = '';

our $dbUser='dev4';
our $dbPasswd='dev123';
our $dbPath='sadb_lab_RE3:176.28.15.224:3306';
our $execPath='/var/www/html/voipphoneRE3/XSLTWork/POC2/merged_scripts';

my $dbh = DBI->connect("dbi:mysql:$dbPath", "$dbUser", "$dbPasswd");
my $fileName = "$execPath/output_xml.xml";

open (FH, $fileName);
undef $/;
my $content = <FH>;
close FH;
$/ = "\n";

# initialize parser with handlers for node processing
my $twigActivation= new XML::Twig( TwigHandlers => { 
                             "/Activation"    => \&transaction,
	});
# parse, handling nodes on the way
$twigActivation->parsefile($fileName);

$rc  = $dbh->disconnect;

# handle a station element
sub transaction {
  my( $tree, $elem ) = @_;
  
  $statement = "insert ignore into transactions values (?,'',?,1,NOW())";
  $rv  = $dbh->do($statement, undef, $elem->att( 'id' ), $content); 
  print "TRANSACTION: ",  $elem->att( 'id' ), "\t", $catbuf;
  $catbuf = '';

}

