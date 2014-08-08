#!/bin/bash

#########################
#
#	Update bind from DNA
#
#########################
error() {
logger -t bindupdate "$1"
rm -fr $temp
exit 1;
}
#### 
# Lets create the tmp dir
cd /tmp
temp="/tmp/`mktemp -d tmp.XXX`"
cd $temp
####
# Lets get the normal domain
wget --quiet --user=public --password=public -O db.szamuraj.info --ca-certificate=/infra/CA/private.crt https://szamuraj.ath.cx/dna/download.phtml/domain/normal/szamuraj.info
dos2unix -q db.szamuraj.info
if [ $? -ne 0 ] 
then
	error "There was an error in bind update during wget" 
fi
/usr/sbin/named-checkzone -q szamuraj.info $temp/db.szamuraj.info
if [ $? -ne 0 ]
then
   	error "There was an error in named-checkzone" 
fi
cp $temp/db.szamuraj.info /etc/bind/db.szamuraj.info
if [ $? -ne 0 ]
then
	error "There was an error in bind update during copy" 
fi

####
# Lets get reverse
wget --quiet --user=public --password=public -O 16.10.10.in-addr.arpa --ca-certificate=/infra/CA/private.crt https://szamuraj.ath.cx/dna/download.phtml/domain/reverse/10.10.16
dos2unix -q 16.10.10.in-addr.arpa
if [ $? -ne 0 ]
then
    error "There was an error in bind update during wget"
fi
/usr/sbin/named-checkzone -q 16.10.10.in-addr.arpa $temp/16.10.10.in-addr.arpa
if [ $? -ne 0 ]
then
    error "There was an error in named-checkzone"
fi
cp $temp/16.10.10.in-addr.arpa /etc/bind/16.10.10.in-addr.arpa
if [ $? -ne 0 ]
then
    error "There was an error in bind update during copy"
fi
/etc/init.d/bind9 reload >/dev/null
if [ $? -ne 0 ]
then
    error "Bind reload has failed during update"
fi
rm -fr $temp

