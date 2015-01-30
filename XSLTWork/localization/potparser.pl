#!/usr/bin/perl

use DBI;
our $dbUser='root';
our $dbPasswd='wankdorf';
our $dbPath='sadb_RE3:localhost:3306';
our $execPath='/var/www/html/voipphoneRE3/XSLTWork/POC2';

my $dbh = DBI->connect("dbi:mysql:$dbPath", "$dbUser", "$dbPasswd");
my $fileName = "$execPath/stationOut_originalFormat.xml";
#my $fileName = shift @ARGV;




open(POTFILE, './y.pot');

$/='msgstr ""';

while(<POTFILE>)
{
%file = {};
%line = {};
	@lines = split(/\n/, $_);
	
	print "\t LINE \n";
	foreach (@lines)
	{
		#: /views/stations/edit.ctp:589#: /views/stations_orig/edit.ctp:539msgid "CFB"msgstr ""
		if($_ =~ /^#(.*):(\d+)/)
		{
			$file{$_} = $1;
			$line{$_} = $2;
			
		}
		elsif($_ =~ /^msgid "(.*)"/)
		{
			$tag = $1;

			my $sql = "SELECT id,tag FROM tags WHERE tag=?";
                	my @row = $dbh->selectrow_array($sql,undef,$tag);
                	if(@row) {
				print "TAG $tag ALREADY EXISTS!!\n";
			}
			else
			{
				print "TAG $tag BEING ADDED!!\n";


 			$dbh->do("
            		INSERT INTO tags 
                       		(id, tag, original_tag, type, created)
                       		VALUES
                       		('','$tag','$tag','code', 'NOW()')
                       		ON DUPLICATE KEY UPDATE
                       			created='NOW()';
                       		");
			
				$id = $dbh->last_insert_id("", "", "tags", "");
			}

		}
		else
		{
			#print  "NO MATCH $_\n";
		}
	}

	foreach my $key(keys %file)
	{
		#print "TAG $tag => $file{$key} : $line{$key}\n";


		if( $file{$key} ne '')
		{
			print "TAG $tag => $file{$key} : $line{$key}\n";


 				$dbh->do("
            			INSERT INTO potentries 
                        			(id, tag_id, page, linenumber, created)
                        			VALUES
                        			('','$id',' $file{$key}','$line{$key}', 'NOW()')
                        			ON DUPLICATE KEY UPDATE
                        			created='NOW()';
                 		");
			
		}
	}	
}
 #disconnect from DB
$dbh->disconnect();


