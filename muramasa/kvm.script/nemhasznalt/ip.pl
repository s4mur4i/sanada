#!/usr/bin/perl
use strict;

my $ippre="10.10.16.";
my $user = "root";
my $password= "Beta8537";
use DBI;

### build up mysql connection
#
my $dbh = DBI->connect('dbi:mysql:dbmydnsconfig',"$user","$password",{ RaiseError => 1, AutoCommit => 0 }) or die "Connection Error: $DBI::errstr\n";
for ( my $i = 40; $i <=250; $i++) {
	my $ip="$ippre$i";
	my $sql="select data from dns_rr where data=\"$ip\"\;";
	my $query = $dbh->selectrow_array($sql);
	if (!defined($query)) {
		print $ip;
		exit 0;
	}
}
exit 1;
$dbh->disconnect();

