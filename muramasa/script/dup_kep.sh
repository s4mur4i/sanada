#!/bin/bash

list="$( find /ftp/kep -type f -print0 | xargs -0 file | grep 'image data' | cut -f1 -d: | tr '\012' '\000' | xargs -0 md5sum | sort | uniq -w 32 -D )"

if [ ! -z "$list" ] ; then
	echo $list | mailx -s "Picture Duplicates" admin@szamuraj.com
fi
