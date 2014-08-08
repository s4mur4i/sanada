#!/usr/bin/perl
use strict;

# NOTE: "Programming Perl" by Larry Wall et al., page 214
my $re_split_by_matching_parentheses;

#$re_split_by_matching_parentheses = qr/\((?:(?>[^()]+)|(??{$re_split_by_matching_parentheses}))*\)/;
#my $s = '&(ingyom) : (|(asdf)(qwer)(zxcv))(valami)';

$re_split_by_matching_parentheses = qr/\{(?:(?>[^{}]+)|(??{$re_split_by_matching_parentheses}))*\}/;

my $s = '123412 {ingyom} 12341233 {|{asdf}{qwer}{zxcv}} 1123 {valami} 444 ';
print "original = '$s'\n";

#my @subexp = $s =~ /$re_split_by_matching_parentheses/g or die "anyán";
#for my $i (0..$#subexp) {
#    print "subexp[$i] = '$subexp[$i]'\n";
#}
#$s =~ s/$re_split_by_matching_parentheses/-/g or die "apán";

my ($match) = $s =~ /($re_split_by_matching_parentheses)/ or die "anyán";
print "match = '$match'\n";
$s =~ s/$re_split_by_matching_parentheses/-/ or die "apán";

print "remainder = '$s'\n";


