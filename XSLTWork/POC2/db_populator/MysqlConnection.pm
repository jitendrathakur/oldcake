use DBI;
package MysqlConnection;
#PERL packages used


sub connection
{
#my ($platform,$database,$host,$port,$tablename,$user,$pw) = "";


my ($platform,$database,$host,$port,$tablename,$user,$pw) = (@_);


#DATA SOURCE NAME 
#Edit DSN variable
$dsn = "dbi:mysql:$database:localhost:3306";

#STATEMENT TO CONNECT
my $connect = DBI->connect($dsn, $user, $pw);

}
1;