#!/usr/bin/perl
#########################################
##                                     	#
##				       	#
##   Manage mysql settings for my dns	#
##					#
##   By: Krisztian Banhidy		#
##					#
##					#
##					#
#########################################
use strict;
use warnings;
use DBI;
use Getopt::Long;
use Switch;

my $sql = 0;
my $verbose = 0;
my $help = 0;
my $user = "root";
my $password= "Beta8537";
my $mode = 0;

GetOptions("help|?" => \$help, 
	   "verbose|v" => \$verbose,
	   "user|u=s" => \$user,
	   "password|p=s" => \$password,
	   "s|select=s" => sub { $sql = $_[1]; $mode="select" },
	   "i|insert=s" => sub { $sql = $_[1]; $mode="insert" }
	);

if ( $help) {
	print "How to use the mysql tool from Krisztian\n";
	print "$0 \$options\n";
	print "options are:\n";
	print "-help or -?  			help (this screen)\n";
	print "-s or -select=\"string\"  		sql select string\n";
	print "-i or -insert=\"string\" 	sql insert string\n";
	print "-u or -user=string  		Connect user\n";
	print "-p or -password=string  	Connect password\n";
	exit;
}

my $dbh = DBI->connect('dbi:mysql:dbmydnsconfig',"$user","$password",{ RaiseError => 1, AutoCommit => 0 }) or die "Connection Error: $DBI::errstr\n";

## Lets get serial
my $serial = $dbh->selectrow_array('select serial from dns_soa where origin="szamuraj.local."');
print "a serial '$serial'\n";


#my $sql = 'select name,data,mac from dns_rr WHERE mac IS NOT NULL';
#INSERT INTO `dbmydnsconfig`.`dns_rr` VALUES (NULL , '1', '0', 'riud', 'ruid', '', '1', '1', 'test.szamuraj.local', 'A' , '1.2.3.4', '0', '86400', 'Y',CURRENT_TIMESTAMP , NULL , 'dsa:das');
switch ($mode) {
	case "select" {
		my $sth = $dbh->prepare($sql);
		$sth->execute() or die "SQL Error: $DBI::errstr\n";
		while ( my @row = $sth->fetchrow_array) {
        		print "@row\n";
		}
	}
	case "insert" {
		my $sth = $dbh->prepare($sql);
		$sth->execute() or die "SQL Error: $DBI::errstr\n";
	}
}
$dbh->disconnect();
