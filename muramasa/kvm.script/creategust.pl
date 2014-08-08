#!/usr/bin/perl

use strict;
use warnings;
use Getopt::Long;
use DBI;
use Switch;
use File::Copy;
use File::Basename;

#####
# Options

my $verbose = 0;
my $help = 0;
#my $host;
my $user = "yahoo";
my $password= "Password123";
my $hostname;
my $ippre="10.10.16";
my $lastip;
my $ip;
my $size=2;
my $distro;
my $mem=1024;
my $dbhost="db.szamuraj.info";
GetOptions("help|?" => \$help,
           "verbose|v" => \$verbose,
           "user|u=s" => sub { $user = $_[1] },
           "password|p=s" => sub { $password = $_[1] },
	       "h|host=s" => sub { $hostname = $_[1] },
	       "s|size=s" => sub { $size = $_[1] },
		   "cd" =>  sub { $distro="cloned" },
		   "cc" =>  sub { $distro="clonec" },
		   "fd" =>  sub { $distro="freshd" },
		   "fc" =>  sub { $distro="freshc" },
		   "m|mem=s" => sub { $mem = $_[1] },
		   "dbhost=s" => sub { $dbhost = $_[1] },
        );

sub useage() {
        print "How to use the create guest tool from Krisztian\n";
        print "$0 \$options -host 'hostname' distro\n";
        print "options are:\n";
        print "-help or -? or -h                      	help (this screen)\n";
        print "-u or -user=string               	Connect user for mysql(default: $user)\n";
        print "-p or -password=string   		Connect password for mysql(default: $password)\n";
        print "-s or -size=string   			Size of LVM disk(default:$size G)\n";
        print "-m or -mem=string   			Memory size(default:$mem M)\n";
        print "-dbhost=string				change mysql db server(default:$dbhost)\n";
        print "distro: clone-debian, fresh-debian, clone-centos, fresh-centos\n";
        exit;
}

if ( $help or !defined($hostname) or !defined($distro) ) {
	if ( $help ) {
		$verbose and print "Help was requested:help=>'$help'\n";
	} elsif ( !defined($hostname) ) {
		$verbose and print "Host was not specified:host=>'$hostname'\n";
	} elsif ( !defined($distro) ) {
		$verbose and print "Distro was not specified:distro=>'$distro'\n";
	}
	&useage;
}

if ($verbose) {
	print "I am going to be verbose.\n";
}

####
# Open mysql conenction

my $dbh = DBI->connect("dbi:mysql:dna:$dbhost","$user","$password",{ RaiseError => 1, AutoCommit => 0 }) or die "Connection Error: $DBI::errstr\n";

####
# Dns setting
#my $scripts="/kvm.script";
my $scripts=dirname($0);
chomp(my $mac= `$scripts/mac.sh`);
( my $cmac = $mac ) =~ s/://g;
$verbose and print "My mac address is: '$mac', cmac is '$cmac'\n";
####
# Generate IP address
for ( my $i = 30; $i <=250; $i++) {
        my $sql="select IPEnd from computers where IPEnd=\"$i\"\;";
		$verbose and print "My sql insert is: '$sql'\n";
        my $query = $dbh->selectrow_array($sql);
        if (!defined($query)) {
            $verbose and print "My ip address is: '$ippre.$i'\n";
			$lastip=$i;
			$ip="$ippre.$i";
			last;
        }
}

#####
## Test hostname is already present.
$verbose and print "My hostname is: '$hostname'\n";
my $sql="select NameBegin from computers where NameBegin=\"$hostname\"\;";
$verbose and print "My sql insert is: '$sql'\n";
my $query = $dbh->selectrow_array($sql);
if (!defined($query)) {
	$verbose and print "My hostname is unique: '$hostname'\n";
} else {
	die ("Not uniqe hostname: '$hostname'\n");
}
#
#
#### 
## Prepare the sql string
#$sql ="INSERT INTO `powerdns`.`records` VALUES ( NULL, '4' , '$hostname.szamuraj.info', 'A' , '$ip', '86400', '0' , NOW() , '$mac')\;";
$sql ="INSERT INTO `dna`.`computers` VALUES ( NULL, '3', '$lastip', '2', '$hostname', '$cmac', '1', '1', 'virtual', UNIX_TIMESTAMP(), '0', '0', '0', '0', '0', '0', UNIX_TIMESTAMP())\;";
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

#####
# LVM management
chomp(my $free = `vgs -o vg_free --noheadings|grep g`);
my $unit = substr $free,-1,1;
if ( $unit eq 'g' ) {
	$verbose and print "My units in Volume Group is gigabyte\n";
	$free =~ s/^\s*(\d+)\.?\d+g?/$1/;
	$verbose and print "VG free space:'$free'\n";
	$verbose and print "Requested size is:'$size\n";
} else {
	die "Fix me for understanding what size unit this is.\n";
}
if ( $free <= $size ) {
	die "Not enough space on Harddrive\n";
}
for my $lvs ( `lvs -o lv_name --noheadings` ) {
	chomp($lvs);
	$lvs =~ s/^\s*(\S+)\s*/$1/;
	$verbose and print "The lv is : '$lvs'\n";
	if ( $lvs eq "vg_$hostname") {
		die "There is an LV already under this name:'vg_$hostname'\n";
	} else {
		$verbose and print "There is no lv under name 'vg_$hostname'\n";
	}
} 
#######
# Creating the LV
my $status = system("lvcreate -n vg_$hostname -L 2G muramasa >/dev/null 2>&1");
if ( $status != 0 ) {
	die "There was an error creating the lv:'vg_$hostname'\n";
}
######
# Adding to dhcpd.conf
my $dhcpconfpath="/etc/dhcp/dhcpd.conf";
copy("$dhcpconfpath","$dhcpconfpath.bkup");
my $re_split;
$re_split = qr/\{(?:(?>[^{}]+)|(??{$re_split}))*\}/;
open (my $dhcpconf, "<$dhcpconfpath");
my @dhcp = <$dhcpconf>;
close $dhcpconf;
unlink($dhcpconfpath);
open ( $dhcpconf, ">$dhcpconfpath");
for ( my $i= @dhcp-1;$i>0;$i--) {
	chomp $dhcp[$i];
	if ( $dhcp[$i] =~ /}/ ) {
		$dhcp[$i]= "\nhost $hostname {\n\thardware ethernet $mac;\n\tfixed-address $ip;\n\toption host-name $hostname;\n}\n}\n" or die "cannot edit dhcp.conf\n";
		last;
	}
}
print $dhcpconf @dhcp;
close $dhcpconf;

system("/etc/init.d/isc-dhcp-server restart >/dev/null");
if ( $? != 0 ) {
	$verbose and print "There was an error restart dhcp server..reverting";
	copy("$dhcpconfpath.bkup","$dhcpconfpath");
	system("/etc/init.d/isc-dhcp-server restart >/dev/null");
}
######
# Adding to nagios
open (my $nagiosfh, ">/tmp/$hostname") or die "Cannot open filehandel : $!";
print $nagiosfh "define host{\n\tuse\tgeneric-host\n\thost_name\t$hostname\n\talias\t$hostname.szamuraj.info\n\taddress\t$ip\n\tparents\tmuramasa\n}";
close $nagiosfh;
system("scp -q /tmp/$hostname root\@nagios:/etc/nagios3/conf.d/" . $hostname . "_nagios2.cfg; ssh nagios /etc/init.d/nagios3 restart >/dev/null 2>&1");
unlink "/tmp/$hostname"; 
#####
#
switch ($distro) {
	case "cloned" {
		$verbose and print "Cloning debian\n";
		( $verbose and `virt-clone -o debian -n $hostname -f /dev/mapper/muramasa-vg_$hostname -m $mac --force`  ) or ( `virt-clone -o debian -n $hostname -f /dev/mapper/muramasa-vg_$hostname -m $mac --force >/dev/null 2>&1` );
		$verbose and print "Cloning complete lets resize to requested size\n";
		( $verbose and `/script/resize.sh -v -s $size -n $hostname` ) or ( `/script/resize.sh -s $size -n $hostname` );
		}
	case "clonec" {
		$verbose and print "Cloning centos\n";
		( $verbose and `virt-clone -o centos -n $hostname -f /dev/mapper/muramasa-vg_$hostname -m $mac --force`  ) or ( `virt-clone -o centos -n $hostname -f /dev/mapper/muramasa-vg_$hostname -m $mac --force >/dev/null 2>&1` );
        $verbose and print "Cloning complete lets resize to requested size\n";
        ( $verbose and `/script/resize.sh -v -s $size -n $hostname` ) or ( `/script/resize.sh -s $size -n $hostname` );

		}
	case "freshd" {
		$verbose and print "Fresh install debian\n";
		( $verbose and system("/script/resize.sh -v -s $size -d /dev/mapper/muramasa-vg_$hostname") ) or ( system("/script/resize.sh -s $size -d /dev/mapper/muramasa-vg_$hostname >/dev/null 2>&1") );
		my $args = 	" -n $hostname".
					" --description \"Automatic install of guest $hostname\"".
					" -r $mem".
					" --vcpus 1".
					" -l http://szamuraj.info/debian/mirror/installer-amd64/".
					" --os-type=linux".
					" --os-variant=debiansqueeze".
					" --disk /dev/mapper/muramasa-vg_$hostname".
					" --network bridge=br0,model=virtio,mac=$mac".
					" --nographics".
					" --noautoconsole".
					" --autostart".
					" -x \"console=tty0".
					      " console=ttyS0,115200n8".
						  " url=http://szamuraj.info/debian/preseed.cfg".
						  " debian-installer/locale=en_US.UTF-8".
#						  " debian-installer/locale string hu_HU".
#						  " localechooser/supported-locales en_US.UTF-8, de_DE.UTF-8".
#						  " keyboard-configuration/layoutcode string hu".
						  " console-setup/ask_detect=false".
						  " console-setup/layoutcode=en".
						  " netcfg/get_hostname=$hostname".
						  " netcfg/get_domain=szamuraj.info".
						"\"";
			$args .= " >/dev/null 2>&1" if (!$verbose);
			system("virt-install $args");
			system("/infra/cron/bind_update.sh");
        }
		case "freshc" {
			$verbose and print "Fresh install centos\n";
			( $verbose and system("/script/resize.sh -v -s $size -d /dev/mapper/muramasa-vg_$hostname") ) or ( system("/script/resize.sh -s $size -d /dev/mapper/muramasa-vg_$hostname >/dev/null 2>&1") );
			 my $args =  " -n $hostname".
                    " --description \"Automatic install of guest $hostname\"".
                    " -r $mem".
                    " --vcpus 1".
                    " -l http://szamuraj.info/centos/mirror/".
                    " --os-type=linux".
                    " --os-variant=rhel5.4".
                    " --disk /dev/mapper/muramasa-vg_$hostname".
                    " --network bridge=br0,model=virtio,mac=$mac".
                    " --nographics".
                    " --noautoconsole".
                    " --autostart".
                    " -x \"console=tty0".
                          " console=ttyS0,115200n8".
                          " ks=http://szamuraj.info/centos/ks.cfg".
                          " ksdevice=link".
                          " ip=dhcp".
                          " DEBCONF_DEBUG=5".
						  " method=http://szamuraj.info/centos/mirror/".
                        "\"";
            $args .= " >/dev/null 2>&1" if (!$verbose);
            system("virt-install $args");
		}
}
