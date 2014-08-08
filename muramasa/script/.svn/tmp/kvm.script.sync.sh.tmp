#!/bin/bash
mkdir /kvm.script >/dev/null 2>&1
suc=`echo \"\" | awk -v line=\`svn st /kvm.script/ 2>&1 | wc -l\` '{ if ( line >= 1 ) print 1 ; else print 0 }'`
if [ "$suc" -gt 0 ] ; then
	svn co http://svn/projects/kvm/trunk /kvm.script/ >/dev/null 2>&1
fi
