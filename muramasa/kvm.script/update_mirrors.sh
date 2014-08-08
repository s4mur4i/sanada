#!/bin/bash

#####################
#	Update mirrors in 

usage()
{
cat << EOF
usage: $0 [-h] [-v] 
Update locl mirrors for debian and centos.

OPTIONS:
   -h           	Show this message
   -v           	Verbose
   -d or --debian 	debian mirror 
   -c or --centos	centos mirror
EOF
}
VERBOSE=0
stdout=/dev/null
debianlink="ftp.hu.debian.org::debian/dists/squeeze/main/"
debian=0
centoslink="ftp.freepark.org::linux/centos/6.2/os/x86_64/"
centos=0

TEMP=`getopt -o hvd::c:: --long --debian::,--centos:: -n 'update_mirror.sh' -- "$@"`

if [ $? != 0 ] ; then echo "Terminating..." >&2 ; exit 1 ; fi

# Note the quotes around `$TEMP': they are essential!
eval set -- "$TEMP"
while true; do
	case "$1" in
  	-d|--debian)
	  case "$2" in
		  "") 
			  shift 2 
			  ;;
		  *) 
			  debianlink=$2
              shift 2 
              ;;
	  esac
	  debian=1
	  ;;
  	-c|--centos)
	  case "$2" in
		  "") 
			  shift 2 
			  ;;
		  *)  
			  centoslink=$2
              shift 2 
              ;;
	  esac
	  centos=1
	  ;;
    -h)
      usage
      exit 1
	  shift
      ;;
    -v)
       VERBOSE=1
       stdout=/dev/stdout
       echo "Lets be verbose" >$stdout 2>&1
       set -x
	   shift
       ;;
	--) 
	    shift  
	    break 
		;;
    *)
      echo "Invalid option: -$1" >&2
      exit 1
  esac
done

if [ $debian -eq 1 ] 
then
	echo "We need to do debian install" >$stdout
	rsync -v -r -a --include="**binary-amd64/" --include="**installer-amd64/" --include="debian-installer/" --exclude="/*" --delete $debianlink /var/www/szamuraj.info/debian/mirror/ >$stdout 2>&1

fi
if [ $centos -eq 1 ] 
then
	echo "We need to do centos install" >$stdout
	rsync -v -r -a --delete $centoslink /var/www/szamuraj.info/centos/mirror/ >$stdout 2>&1
fi
chown -R www-data:www-data /var/www/szamuraj.info/centos/mirror
chown -R www-data:www-data /var/www/szamuraj.info/debian
