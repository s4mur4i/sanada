#!/usr/bin/perl

#######
#	KVM domain xml management for CDrom
#
use strict;
use warnings;
use Getopt::Long;
use Sys::Virt;
use Data::Dumper;
use XML::Mini;
use XML::Mini::Document;

#####
# Options

my $verbose = 0;
my $help = 0;
#my $domainname="/etc/libvirt/qemu/debian.xml.teszt";
my $domainname="debian";
my $iso="/valami/at/valami";
GetOptions("help|?|h" => \$help,
           "verbose|v" => \$verbose,
           "d|domain=s" => sub { $domainname=$_[1] },
		   "iso=s" => sub { $iso=$_[1] },
        );

sub useage() {
        print "How to use the create guest tool from Krisztian\n";
        print "$0 \$options -host 'hostname' distro\n";
        print "options are:\n";
        print "-help or -? or -h                        help (this screen)\n";
        print "-d or domain                		the domainname need to be parsed\n";
		print "-iso								path to the iso file\n";
        exit;
}

sub dump_item($$) {
        my ($element, $prefix) = @_;

        print "${prefix}element '".$element->name()."' start\n";
        for my $a (keys %{$element->{_attributes}}) {
                print "${prefix}  attribute name='$a', value='".$element->attribute($a)."'\n";
        }

        foreach my $c (@{$element->{_children}}) {
                if ($element->isElement($c)) {
                        dump_item($c, '    '.$prefix);
                }
                else {
                        print "${prefix}  string content='".$c->getValue()."'\n";
                }
        }
        print "${prefix}element '".$element->name()."' end\n";
}

#if ( $help or !defined($domainname) ) {
#        if ( $help ) {
#                $verbose and print "Help was requested:help=>'$help'\n";
#        } elsif ( !defined($domainname) ) {
#                $verbose and print "domain was not specified:domainname=>'$domainname'\n";
#        } 
#        &useage;
#}
if ($verbose) {
        print "I am going to be verbose.\n";
}
my $conn = Sys::Virt->new (readonly =>1);
my $dom = $conn->get_domain_by_name($domainname);
my $xml = $dom->get_xml_description();
my $xmlDoc = XML::Mini::Document->new();
{
	my $fd;
	open($fd, '<', "/tmp/source.xml") or die "can't create source.xml\n";
	{ local $/ = undef; $xml = readline($fd); }
	print $xml;
	close($fd);
}
$xmlDoc->parse($xml) or die("Cannot parse XML file\n");
my $hr = $xmlDoc->toHash();
print Dumper($hr);
print "\n==== Traversing the structure recursively\n";
dump_item($xmlDoc->getRoot(), '');
print $xmlDoc->toString();
