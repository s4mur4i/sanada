#!/bin/bash

### Disk resize on host for guest

usage()
{
cat << EOF
usage: $0 [-h] [-v] -s=VAR -n=VAR
This script is useable only with lvm devices and needs to be given path to /dev/mapper device

OPTIONS:
   -h      	Show this message
   -s 		Size of new disk (Gigs)
   -d		Lvm path
   -v		Verbose
   -n		name of KVM domain
EOF
}
SIZE=
DISK=
VERBOSE=0
BLOCK=
stdout=/dev/null

while getopts "hvs:d:n:" opt; do
  case $opt in
    s)
	  SIZE=$OPTARG
	  BLOCK=$(($SIZE*1024*1024))
	  SIZE=$SIZE"G"
      ;;
    d)
	  kpartx -dv `readlink -f $OPTARG`
	  DISK=$OPTARG
      ;;
    h)
      usage
	  exit 1
      ;;
	v)
	  VERBOSE=1
	  stdout=/dev/stdout
	  echo "Lets be verbose" >$stdout 2>&1 
	  set -x
	  ;;
	n)
	  DISK=`/script/host_info.pl -h $OPTARG -disk`
	  ;;
    \?)
      echo "Invalid option: -$OPTARG" >&2
	  exit 1
      ;;
  esac
done

if [[ -z $SIZE  ]] || [[ -z $DISK ]]
	then
	usage
	exit 1
fi

if [ ! -b $DISK ] 
	then
	echo "It is not a disk."
	exit 1
fi
CBLOCK=`fdisk -s $DISK`
VDISK=(`kpartx -av $DISK | awk -v dir=\`dirname $DISK\` '/add/{print dir"/"$3}'`)
SWAP=`fdisk -ul $DISK | awk '(/\//) && (/swap/)'`

if [[ ! -z $SWAP ]]; then
	echo "Swap detected" >$stdout 2>&1
	SWAPSIZE=`echo $SWAP | awk '{print $3-$2}'`
	fdisk $DISK >$stdout 2>&1  <<EOF
    d
	2
    w
EOF
fi

if [ $BLOCK -lt $CBLOCK ]; then 
	echo "We need to shrink filesystem." >$stdout 2>&1 
	fsck -n ${VDISK[0]} >$stdout 2>&1 
	e2fsck -f ${VDISK[0]} >$stdout 2>&1 
	tune2fs -O ^has_journal ${VDISK[0]} >$stdout 2>&1 
	e2fsck -f ${VDISK[0]} >$stdout 2>&1 
	MIN=`fdisk -ul $DISK | awk '/^\/dev\/mapper/ {print $3}'`
	MINSIZE=`resize2fs -P ${VDISK[0]} 2>/dev/null | awk '{print $7}'`
	BLOCK=`dumpe2fs ${VDISK[0]} 2>$stdout | awk '/Block size/ {print $3}'`
	SECTOR=`fdisk -l $DISK | awk '/^Units =(.*[^=])=(\d*)/ {print $9}'`
	CSIZE=`echo | awk -v minsize=$MINSIZE -v block=$BLOCK '{print "+"(minsize*4)+block"K"}'`
	#CSIZE=`resize2fs -P ${VDISK[0]} 2>/dev/null | awk -v block=\`dumpe2fs ${VDISK[0]} 2>$stdout | awk '/Block size/ {print $3}'\` -v constant=\`fdisk -l $DISK | awk '/^Units =(.*[^=])=(\d*)/ {print $9}'\` '{print "+"($7*4)+int(constant/block)+1"K"}'`
	resize2fs -M ${VDISK[0]} >$stdout 2>&1
	kpartx -dv $DISK >$stdout 2>&1 
	fdisk -u $DISK >$stdout 2>&1  <<EOF
	d
	n
	p
	1
	$MIN
	$CSIZE
	a
	1
	w
EOF
	partprobe $DISK >$stdout 2>&1 
	lvresize -f -L $SIZE $DISK >$stdout 2>&1 
	## Divert for swap
	if [[ ! -z $SWAP ]]; then
		MAX=`fdisk -ul $DISK 2>/dev/null | awk /sectors$/ | awk -v swap=$SWAPSIZE '{print $8-swap-1}'`
		SWAPMIN=`echo | awk -v max=$MAX '{print max+1}'`
		SWAPMAX=`echo | awk -v min=$SWAPMIN -v size=$SWAPSIZE '{print min+size}'`
		fdisk -u $DISK >$stdout 2>&1 <<EOF
		d
		n
		p
		1
		$MIN
		$MAX
		a
		1
		n
		p
		2
		$SWAPMIN
		$SWAPMAX
		t
		2
		82
		w
EOF
		partprobe $DISK >$stdout 2>&1 
		VDISK=(`kpartx -av $DISK | awk -v dir=\`dirname $DISK\` '/add/{print dir"/"$3}'`)
		mkswap -f ${VDISK[1]} >$stdout 2>&1
	else
		fdisk -u $DISK >$stdout 2>&1 <<EOF
		d
		n
		p
		1
		$MIN
		
		a
		1
		w
EOF
		partprobe $DISK >$stdout 2>&1 
		VDISK=(`kpartx -av $DISK | awk -v dir=\`dirname $DISK\` '/add/{print dir"/"$3}'`)
	fi
	e2fsck -f ${VDISK[0]} >$stdout 2>&1 
	resize2fs ${VDISK[0]} >$stdout 2>&1
	e2fsck -f ${VDISK[0]} >$stdout 2>&1 
	fsck -n ${VDISK[0]} >$stdout 2>&1 
	tune2fs -j ${VDISK[0]} >$stdout 2>&1 
	kpartx -dv $DISK >$stdout 2>&1 
	kpartx -dv `readlink -f $DISK` >$stdout 2>&1 
elif [ $BLOCK -gt $CBLOCK ]; then
	echo "We need to expand the filesystem." >$stdout 2>&1 
 	lvextend -f -L $SIZE $DISK >$stdout 2>&1 
    e2fsck -f ${VDISK[0]} >$stdout 2>&1 
	tune2fs -O ^has_journal ${VDISK[0]} >$stdout 2>&1
	e2fsck -f ${VDISK[0]} >$stdout 2>&1
	kpartx -dv $DISK >$stdout 2>&1
	if [[ ! -z $SWAP ]]; then
		MIN=`fdisk -ul $DISK | awk '/^\/dev\/mapper/ {print $3}'`
		MAX=`fdisk -ul $DISK 2>/dev/null | awk /cylinders$/ | awk -v swap=$SWAPSIZE '{print $5-swap-1}'`
        SWAPMIN=`echo | awk -v max=$MAX '{print max+1}'`
        SWAPMAX=`echo | awk -v min=$SWAPMIN -v size=$SWAPSIZE '{print min+size}'`
        fdisk -u $DISK >$stdout 2>&1 <<EOF
        d
        n
        p
        1
        $MIN
        $MAX
        a
        1
        n
        p
        2
        $SWAPMIN
        $SWAPMAX
        t
        2
        82
        w
EOF
    	partprobe $DISK >$stdout 2>&1
    	VDISK=(`kpartx -av $DISK | awk -v dir=\`dirname $DISK\` '/add/{print dir"/"$3}'`)
    	mkswap -f ${VDISK[1]} >$stdout 2>&1
	else
		MIN=`fdisk -ul $DISK | awk '/^\/dev\/mapper/ {print $3}'`
		fdisk -u $DISK >$stdout 2>&1 <<EOF
		d
		n
		p
		1
		$MIN

		a
		1
		w
EOF
		partprobe $DISK >$stdout 2>&1 
    	kpartx -av $DISK >$stdout 2>&1 
	fi
	fsck -a -f ${VDISK[0]} >$stdout 2>&1
    e2fsck -f -p ${VDISK[0]} >$stdout 2>&1 
    resize2fs -f ${VDISK[0]} 2>&1 >$stdout
    e2fsck -f ${VDISK[0]} >$stdout 2>&1 
    fsck -n ${VDISK[0]} >$stdout 2>&1 
	tune2fs -j ${VDISK[0]} >$stdout 2>&1 
    kpartx -dv $DISK >$stdout 2>&1 
    kpartx -dv `readlink -f $DISK` >$stdout 2>&1 
else
	echo "Size is same as present size."; >$stdout 2>&1 
	 kpartx -dv $DISK >$stdout 2>&1
	 kpartx -dv `readlink -f $DISK` >$stdout 2>&1
fi
#### END
if [ $VERBOSE ] 
then
	set +x 
fi
