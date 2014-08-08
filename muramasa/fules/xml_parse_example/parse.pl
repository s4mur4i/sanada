#!/usr/bin/env perl
use strict;
use XML::Mini;
use XML::Mini::Document;
use Data::Dumper;

sub unescapeEntities($) {
    my ($s) = @_;

    $s =~ s/\&lt;/</g;
    $s =~ s/\&gt;/>/g;
    $s =~ s/\&quot;/"/g;
    $s =~ s/\&#([^;]*);/chr(hex($1))/g;
    $s =~ s/\&amp;/&/g;
    return $s;
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


print "\n==== Reading file\n";
my $filename = "debian.xml.teszt";
my $xmlDoc = XML::Mini::Document->new();
$xmlDoc->parse($filename) or die("Cannot parse XML file\n");

print "\n==== Contents as a hash\n";
my $hr = $xmlDoc->toHash();
print Dumper($hr);

print "\n==== Traversing the structure recursively\n";
dump_item($xmlDoc->getRoot(), '');
