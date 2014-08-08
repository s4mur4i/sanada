#!/bin/sh

# Comment out this line to have a randomly-generated prefix or change
# to something else (must be in the form of XX:XX)
PREFIX="ac:de:48"
# Xen virtual 00-16-3E
# generate the MAC
SOURCE=$(dd if=/dev/urandom count=1 2>/dev/null | openssl dgst -md5)
MACADDR="${PREFIX}:$(echo ${SOURCE} | \
sed 's/^\(..\)\(..\)\(..\).*$/\1:\2:\3/')"
echo $MACADDR
