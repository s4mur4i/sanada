#!/usr/bin/perl

use strict;
use warnings;
use Getopt::Long;
use DBI;
use Switch;
use File::Copy;

#####
# Options

my $verbose = 0;
my $help = 0;
my $host;
my $user = "root";
my $password= "Beta8537";
my $hostname;
my $dhcpconfpath="/etc/dhcp/dhcpd.conf";
GetOptions("help|?" => \$help,
           "verbose|v" => \$verbose,
           "user|u=s" => \$user,
           "password|p=s" => \$password,
           "h|host=s" => sub { $host=0; $hostname=$_[1] },
		   "d" => sub { $dhcpconfpath=$_[1] },
        );

sub useage() {
        print "How to use the remove guest tool from Krisztian\n";
        print "$0 \$options -host hostname\n";
        print "options are:\n";
        print "-help or -? or -h                        help (this screen)\n";
        print "-u or -user=string                       Connect user for mysql(default: $user)\n";
        print "-p or -password=string                   Connect password for mysql(default: $password)\n";
		print "-d					Location for dhcp conf (default: $dhcpconfpath)\n";
		print "-h or -host				Host to remove\n";
        exit;
}

if ( $help or !defined($host) ) {
        if ( $help ) {
                $verbose and print "Help was requested:help=>'$help'\n";
        } elsif ( !defined($host) ) {
                $verbose and print "Host was not specified:host=>'$host'\n";
        } 
        &useage;
}

if ($verbose) {
        print "I am going to be verbose.\n";
}

####
# Open mysql conenction

my $dbh = DBI->connect('dbi:mysql:dna',"$user","$password",{ RaiseError => 1, AutoCommit => 0 }) or die "Connection Error: $DBI::errstr\n";
my $sql = "delete from computers where NameBegin=\"$hostname\"\;";
$verbose and print "My sql insert is: '$sql'\n";
my $sth = $dbh->prepare($sql);
$sth->execute() or die "SQL Error: $DBI::errstr\n";

$sql = "UPDATE domains set ModifyD=UNIX_TIMESTAMP() where ID='2'\;";
$verbose and print "My sql insert is: '$sql'\n";
$sth = $dbh->prepare($sql);
$sth->execute() or die "SQL Error: $DBI::errstr\n";

$sql = "UPDATE domains set ModifyD=UNIX_TIMESTAMP() where ID='3'\;";
$verbose and print "My sql insert is: '$sql'\n";
$sth = $dbh->prepare($sql);
$sth->execute() or die "SQL Error: $DBI::errstr\n";

$dbh->disconnect;

####
# Remove from dhcpd.conf
copy("$dhcpconfpath","$dhcpconfpath.bkup");
my $re_split;
$re_split = qr/\{(?:(?>[^{}]+)|(??{$re_split}))*\}/;
my $dhcp = do {local $/ = undef; open (my $dhcpconf, "$dhcpconfpath"); <$dhcpconf>};
$dhcp =~ s/host $hostname $re_split//;
$dhcp =~ s/\n+/\n/g;
open (my $dhcpdconf, ">$dhcpconfpath") or die"Cannot open file:$!";
print $dhcpdconf $dhcp;
close $dhcpdconf;
system("/etc/init.d/isc-dhcp-server restart >/dev/null");
if ( $? != 0 ) {
	        $verbose and print "There was an error restarting dhcp server..";
}
####
# Remove from nagios
system("ssh","nagios","rm /etc/nagios3/conf.d/${hostname}_nagios2.cfg >/dev/null 2>&1;/etc/init.d/nagios3 restart >/dev/null 2>&1");
####
# Stop and undefine virtual machine
system("virsh destroy $hostname >/dev/null 2>&1");
system("virsh undefine $hostname >/dev/null 2>&1");

####
#  LVM cleanup
if ( -e "/dev/mapper/muramasa-vg_$hostname") {
	my $status = system("lvremove -f /dev/mapper/muramasa-vg_$hostname >/dev/null 2>&1");
	if ( $status != 0 ) {
		 print "There was an error removing the lv:'vg_$hostname'\n";
		 print "Trying to remove maps\n";
		 system("kpartx -dv /dev/mapper/muramasa-vg_$hostname >/dev/null 2>&1");
		 my $status = system("lvremove -f /dev/mapper/muramasa-vg_$hostname >/dev/null 2>&1");
		 	if ( $status != 0 ) {
				die "Error removing lv from lvm:'vg_$hostname'\n";
			}

	}
}
