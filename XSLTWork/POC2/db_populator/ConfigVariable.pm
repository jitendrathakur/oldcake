package ConfigVariable;

sub configVariable
{
my $Platform = "mysql";
my $Database = "test";
my $Host = "localhost";
my $Port = "3306";
my $Tablename = "table_entry";
my $User = "root";
my $Pw = "pass";
return
  ($Platform, $Database, $Host, $Port, $Tablename, $User, $Pw)
}
1;