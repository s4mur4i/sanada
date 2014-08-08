#!/usr/bin/perl
###############
#
#		Query information about the host
#
use strict;
use warnings;
use Getopt::Long;
use Switch;

###XML locations
my $XMLDIR="/etc/libvirt/qemu";
my $debug = 0;
my $help = 0;
my $host = 0;
my $list = 0;
my $memory = 0;
my $vcpu = 0;
my $disk = 0;
my $mac = 0;
my $name = 0;
my $verbose =0;
my $all = 1;

GetOptions("help|?" => \$help,
           "verbose|v" => \$verbose,
           "h|host=s" => \$host,
           "l|list" => \$list,
			"xml=s"   => \$XMLDIR,
			"mem" => sub { $memory=1 , $all=0 } ,
			"disk" => sub { $disk=1 , $all=0 } ,
			"cpu" => sub { $vcpu=1 , $all=0 } ,
			"name" => sub { $name=1, $all=0 },
			"mac" => sub { $mac=1, $all=0},
			"all" => \$all,
			"d|debug" => \$debug
        );

if ( $help ) {
	print "How to use the query host tool\n";
	print "$0 \$options \n";
	print "-? or help		help\n";
	print "-l or list		list all host information\n";
	print "-h or host		show information for one host\n";
	print "-xml			Change default XML directory (default: '$XMLDIR')\n";
	print "-v or verbose		be verbose by output\n";
	print "-mem			show memory\n";
	print "-name			show name in output\n";
	print "-disk			show disk\n";
	print "-cpu			return number of cpus\n";
	print "-mac 			return mac address\n";
	print "-all 			print all info\n";
	print "-debug			print debug information\n";
}

sub openxml($) {
	my $file= $_[0];
	$debug and print $file."\n";
	my $omemory = 0 ;
	my $ovcpu = 0 ;
	my $odisk = 0 ;
	my $omac = 0 ;
	my $oname = 0 ;
	my ( $prefix,$postfix ) = 0;
	open ( my $FILE, $file );
	while ( my $line = <$FILE>) {
		chomp $line;
		$debug and print $line."\n";
		if ( $line =~ /^\s*<mac address='/ ) {
			( $prefix, $omac, $postfix ) = $line =~ /(^\s*<mac address=')([^']*[^'])('\/>\s*$)/;
			$debug and print "The mac address is:'$omac'\n";
		}
		if ( $line =~ /^\s*<memory>/ ) {
			( $prefix, $omemory, $postfix ) = $line =~ /(^\s*<memory>)([^>]*[^<])(<\/memory>\s*$)/;
			$debug and print "My memory is:'$omemory'\n";
		}
		if ( $line =~ /^\s*<vcpu>/ ) {
			( $prefix, $ovcpu, $postfix ) = $line =~ /(^\s*<vcpu>)([^<>]*)(<\/vcpu>\s*$)/;
			$debug and print "My Vcpu is:'$ovcpu'\n";
		}
		if ( $line =~ /^\s*<source dev='/ ) {
			( $prefix, $odisk, $postfix ) = $line =~ /(^\s*<source dev=')([^']*[^'])('\/>\s*$)/;
			$debug and print "My disk is:'$odisk'\n";
		}
		if ( $line =~ /^\s*<name>/ ) {
			( $prefix, $oname, $postfix ) = $line =~ /(^\s*<name>)([^']*[^'])(<\/name>\s*$)/;
			$debug and print "My name is:'$oname'\n";
		}
	}
	return ( $oname, $omemory, $omac, $ovcpu, $odisk );
	close $FILE;
}

sub format(@) {
	my ( $fname, $fmemory, $fmac, $fcpu, $fdisk) = @_;
	my $outstring = "";
	$debug and print "My variables for format sub:name =>'$fname' memory =>'$fmemory' mac =>'$fmac' cpu =>'$fcpu' disk =>'$fdisk'\n";
	if ( $all ) {
		$debug and print "All argument found.\n";
		($verbose and $outstring= "host=$fname memory=$fmemory mac=$fmac cpu=$fcpu disk=$fdisk" ) or $outstring="$fname $fmemory $fmac $fcpu $fdisk";
	} else {
		$debug and print "I am in the else tree\n";
		if ( $name ne 0 ) {
			$debug and print "Name specified\n";
			($verbose and $outstring .= "host=$fname ") or $outstring.="$fname ";
			$debug and print "My outstring is:'$outstring'\n";
		} 
		if ( $memory ne 0 ) {
			$debug and print "Memory specified.\n";
			($verbose and $outstring .= "memory=$fmemory ") or $outstring.="$fmemory ";
			$debug and print "\n";
		} 
		if ( $mac ne 0 ) {
			$debug and print "Mac specified.\n";
			($verbose and $outstring .= "mac=$fmac ") or $outstring.="$fmac ";
			$debug and print "\n";
		} 
		if ( $vcpu ne 0 ) {
			$debug and print "CPU specified.\n";
			($verbose and $outstring .= "cpu=$fcpu " ) or $outstring.="$fcpu ";
			$debug and print "\n";
		} 
		if ( $disk ne 0 ) {
			$debug and print "Disk specified.\n";
			($verbose and $outstring .= "disk=$fdisk") or $outstring.="$fdisk ";
			$debug and print "\n";
		}
	}
	$debug and print "My outstring is:'$outstring'\n";
	return($outstring);
}

if ( $host ) {
	$debug and print "Host specified :'$host'\n";
	my $file="$XMLDIR/$host.xml";
	$debug and print "My file is '$file'\n";
	if ( -e $file ) {
		$debug and print "File exists\n";
		my @output = openxml($file);
		$debug and print "My output was:'@output'\n";
		( $verbose and print &format(@output)."\n") or print &format(@output)."\n";
	} else {
		$debug and print "File doesnt exist:'$file'\n";
	}
} 
elsif ( $list ) {
	$debug and print "List specified\n";
	my @files=<$XMLDIR/*.xml>; 
	$debug and print "My list is:'@files'\n";
	foreach my $file ( @files ) {
		$debug and print "File found doing sub on it:'$file'\n";
		my @output = openxml($file);
		$debug and print "My output was:'@output'\n";
		( $verbose and print &format(@output)."\n" ) or print &format(@output)."\n";
	}
} else {
	$debug and print "No host or list specified.\n";
}

