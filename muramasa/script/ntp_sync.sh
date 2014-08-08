#!/bin/bash
###########
# Sync ntp
usage()
{
cat << EOF
usage: $0 [-s] [-c]

OPTIONS:
   -h           Show this message
   -s           server variable
   -v		be verbose
EOF
}

if [ -z $server ]; then
        case `uname -n` in
                ntp)
                        server=0.hu.pool.ntp.org
                        ;;
                *)
                        server=ntp.szamuraj.info
                        ;;
        esac

fi


res() {
/etc/init.d/ntp stop >$stdout 2>&1
ntpdate $server >$stdout 2>&1
/etc/init.d/ntp start >$stdout 2>&1
}

stdout=/dev/null
case "$1" in
OK)
	;;

WARNING)
	;;

UNKNOWN)
	;;

CRITICAL)
	case "$2" in
	SOFT)
		case "$3" in
		3)
			res
			;;
		esac
		;;
	HARD)
		res
		;;
	esac
	;;
*)
while getopts "hcs:v" opt; do
  case $opt in
    s)
        server=$OPTARG
        ;;
    h)
        usage
        exit 1
        ;;
    v)
        stdout=/dev/stdout
        ;;
    *)
        usage
        exit 1
 	 esac
	done
	res
	;;

esac

exit 0
