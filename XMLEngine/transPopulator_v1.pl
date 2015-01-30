use XML::Twig;
use DBI;
use Data::Dumper;

use FindBin qw($Bin);
my $binDir = $Bin;
use lib "$Bin/lib";
use Config::Any::INI;
use Config::Any::XML;

our $binDir=$Bin;

# buffers for holding text
my $catbuf = '';
my $itembuf = '';

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

my $inputFileName = shift(@ARGV);

my $dbh = DBI->connect("dbi:mysql:$dbPath", "$dbUser", "$dbPasswd");
my $fileName = "$binDir/$inputFileName";

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
  
  $statement = "insert ignore into transactions values (?,'',?,'',1,NOW())";
  $rv  = $dbh->do($statement, undef, $elem->att( 'id' ), $content); 
  print "TRANSACTION: ",  $elem->att( 'id' ), "\t", $catbuf;
  $catbuf = '';

}

