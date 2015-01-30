#!/usr/bin/perl

use DBI;
our $dbUser='root';
our $dbPasswd='wankdorf';
our $dbPath='sadb_RE3:localhost:3306';
our $base_path='/var/www/html/voipphoneRE3/app/locale/';
$lang = shift @ARGV;

my $dbh = DBI->connect("dbi:mysql:$dbPath", "$dbUser", "$dbPasswd");
my $fileName = $base_path . $lang . '/LC_MESSAGES/default.po';
#my $fileName = shift @ARGV;

#Examples

#msgid  "Customer List"
#msgstr "Customer list"

#msgid  "close_window"
#msgstr "Close window"

if (($lang ne "eng") && ($lang ne "ita") && ($lang ne "fre") && ($lang ne "deu")&& ($lang ne "fff")) 
{

	#die "language neeeded : eng, ita, deu, fre\n";
	&process_lang('eng');
	&process_lang('fre');
	&process_lang('ita');
	&process_lang('deu');
}
else
{
	&process_lang($lang);
	print "processing $fileName\n";
}

sub process_lang($lang)
{
	$lang = shift(@_);
	my $fileName = $base_path . $lang . '/LC_MESSAGES/default.po';
	print "processing $fileName\n";
	open(POFILE, "$fileName");

	$/='msgid';

	while(<POFILE>)
	{
	$tag='';
	$tag_id='';
	$trans='';
	
		@lines = split(/\n/, $_);
		
		print "\t LINE :";
		foreach (@lines)
		{
			print "\t\t($_)\n";
			if($_ =~ /^ +"(.*)"/)
			{
				$tag = $1;
	
			}
			if($_ =~ /^msgstr "(.*)"/)
			{
				$trans = $1;
	
			}
			else
			{
				#print  "NO MATCH $_\n";
			}
		}
	
		if($trans ne '')
		{
		#print "ORIG TRANS => $trans\n";
		#$trans =~ s/\'/\\'/g;
		#print "NEW TRANS => $trans\n";

		
	
			my $sql = "SELECT id,tag FROM tags WHERE tag=?";
			my @row = $dbh->selectrow_array($sql,undef,$tag);
			if(@row) { 
				my ($tag_id,$tag) = @row;
		
				print "FOUND TAG ($tag) => $tag_id : TRANS => $trans\n";
	
				my $sql = "SELECT id, tag_id, translation FROM transentries WHERE translation=? and language=?";
				my @row = $dbh->selectrow_array($sql,undef,$trans,$lang);
					
				if(@row) { 
					my ($tag_id,$tag) = @row;
	
					print "FOUND TRANSLATION NOT INSERTING => $tag_id : TRANS => $trans\n";
					#DO NOTHING
				}
				else{
		
					print "ORIG TRANS => $trans\n";
					$trans =~ s/\'/\\'/g;
					print "NEW TRANS => $trans\n";

					print "NOT FOUND TRANSLATION INSERTING => $tag_id : TRANS => $trans\n";
					$dbh->do("
       					INSERT INTO transentries 
       					(id, tag_id, translation, language, created)
              					VALUES
             					('','$tag_id','$trans','$lang', 'NOW()')
             					ON DUPLICATE KEY UPDATE
       						created='NOW()';
             				");
				}
			}
			else
			{
	
				my $sql = "SELECT id, tag_id, translation FROM transentries WHERE translation=? and language=?";
				my @row = $dbh->selectrow_array($sql,undef,$trans, $lang);
			
				print  "TAG :: $tag not found in database, creating zombie";
	
			 	$dbh->do("
                        	INSERT INTO tags
                                	(id, tag, original_tag, type, created)
                                	VALUES
                                	('','$tag','$tag','zombie', 'NOW()')
                                	ON DUPLICATE KEY UPDATE
                                        	created='NOW()';
                                	");
	
                                	$id = $dbh->last_insert_id("", "", "tags", "");
	
					my $sql = "SELECT id, tag_id, translation FROM transentries WHERE translation=? and language=?";
					my @row = $dbh->selectrow_array($sql,undef,$trans,$lang);
					#my $sql = "SELECT id, tag_id, translation FROM transentries WHERE translation=?";
					#my @row = $dbh->selectrow_array($sql,undef,$trans);
						
					if(@row) { 
						my ($tag_id,$tag) = @row;
		
						print "FOUND TRANSLATION NOT INSERTING => $tag_id : TRANS => $trans\n";
						#DO NOTHING
					}
					else
					{
						print "ORIG TRANS => $trans\n";
						$trans =~ s/\'/\\'/g;
						print "NEW TRANS => $trans\n";

						print "NOT FOUND TRANSLATION INSERTING => $tag_id : TRANS => $trans\n";
						$dbh->do("
       							INSERT INTO transentries 
       							(id, tag_id, found_tag, translation, language, created, status)
              						VALUES
             						('','$id','$tag','$trans','$lang', 'NOW()', '99')
             						ON DUPLICATE KEY UPDATE
       							created='NOW()';
             					");
					}
			}
		}
	
	}
}
 	#disconnect from DB
	$dbh->disconnect();



