#!/usr/bin/perl

##################
#
#		Lets get some dhcp info
#

use strict;
use warnings;
use Getopt::Long;

my $debug =0;
my $help = 0;
my $conf ="/etc/dhcp/dhcpd.conf";
my %hash = ();
my $name = 0;
my $query = "all";
my $verbose = 0;

GetOptions("help|?|h" => \$help,
           "debug|d" => \$debug,
		   "c|conf=s" => \$conf,
		   "n|name=s" => \$name,
		   "m|mac" => sub { $query = "mac" } ,
		   "ip" => sub { $query = "ip" } ,
		   "v|verbose" => \$verbose,
        );

if ( $help ) {
        print "How to use the query host tool, if no name is specified then all is shown, if no parameter specified all is shown\n";
        print "$0 \$options \n";
        print "-? or help              help\n";
        print "-d or debug           show debug by output\n";
        print "-v or verbose           show extra info by output\n";
        print "-c or conf		place of dhcpd.conf(default: $conf)\n";
        print "-n or name              query only specific host\n";
		print "-m or mac		query only mac addresses\n";
		print "-ip			query only ip-s\n";
}

if ( ! -e $conf) {
	$debug and print "The conf file doesnt exist.\n";
	exit 2;
}

open ( my $FILE, $conf);
while (my $sor = <$FILE>) {
	if ( $sor =~ /^\s*host/) {
		my ($mac, $ip, $name) = 0;
		do { 
			chomp $sor;
			$debug and print "Found line within host:'$sor'\n";
			if ($sor =~ /^\s*host/ ) { 
				(($name) = $sor =~ /^\s*host\s*([^ ]*)/) and ($debug and print "A name ='$name'\n");
			}
			if ( $sor =~ /^\s*hardware ethernet/ ) {
				(($mac) = $sor =~ /^\s*hardware ethernet\s*([^ ]*);/) and ($debug and print "A name ='$mac'\n");
			}
			if ( $sor =~ /^\s*fixed-address/ ) {
				(($ip) = $sor =~ /^\s*fixed-address\s*([^ ]*);/) and ($debug and print "A name ='$ip'\n");
			}
			$sor = <$FILE>;
		} while ($sor !~ /^\s*}/ ); 
		$hash{ $name } = { 'mac' => $mac, 'ip' => $ip, 'name' => $name};
	}
}

sub host($) {
	my $host = $_[0];
	$debug and print "Doing host:'$host'\n";
	my $mac = $hash{$host}{'mac'};
	my $ip = $hash{$host}{'ip'};
	$debug and print "My attributes are:mac => '$mac',ip => '$ip'\n";
	if ( $query eq "all" ) {
		$debug and print "All parameters need to be printed.\n";
		($verbose and print "name=$host mac=$mac ip=$ip\n") or (print "$host $mac $ip\n");
	} elsif ( $query eq "mac" ) {
		$debug and print "Mac requested.\n";
		($verbose and print "name=$host mac=$mac \n") or (print "$host $mac\n");
	} elsif ( $query eq "ip" ) {
		$debug and print "IP address requested\n"; 
		($verbose and print "name=$host ip=$ip\n") or (print "$host $ip\n");
	}
}

if ( $name eq 0 ) {
	for my $host ( keys %hash ) {
		host($host);
	}
} else {
	host($name);
}
