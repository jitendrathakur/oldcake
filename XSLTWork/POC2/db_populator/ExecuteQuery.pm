use DBD::mysql;
package ExecuteQuery;


sub createTable
{
my ($db,$var);
my $Connection; my $Tablename;
($Connection, $Tablename)	= @_;
my $query = "CREATE TABLE $Tablename (id INT AUTO_INCREMENT PRIMARY KEY, log_id INT(11), transaction varchar(11), status INT, created DATETIME)";
$var = $Connection->prepare($query);
	$var->execute();
}


sub insertIntoTable
{
my ($db, $id, $log_id, $transaction, $status);
my $Connection; my $Tablename;
($Connection,$Tablename, $id, $log_id, $transaction, $status)	= @_;
print $transaction."\n";
my $query = "INSERT INTO $Tablename ( log_id, transaction, status, created) VALUES(NULL,'$transaction',$status,now())";
$var = $Connection->prepare($query);
	$var->execute();
}
1;