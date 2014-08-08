#!/bin/bash

list="$( fdupes -rqSm /ftp/raid/music/ )"
regex="No duplicates found."
if [[ "$list" =~ "$regex" ]] ; then
	sleep 1
else
	echo $list | mailx -s "Music duplications" admin@szamuraj.com
fi
