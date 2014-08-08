#!/bin/sh
dirnev=`dirname $0`
source-highlight $dirnev/changelog -s changelog -t 4 -c design/include/source.css --no-doc -f html
