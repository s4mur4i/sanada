#!/bin/sh
######## Debug information 
exec >> /root/bootstrap,out 2>&1
set -x
######## SSH keys
#mkdir /root/.ssh
#mkdir /home/s4mur4i/.ssh
#wget -O /root/.ssh/authorized_keys http://szamuraj.info/debian/authorized_keys
#chown root:root /root/.ssh/authorized_keys
#wget -O /home/s4mur4i/.ssh/authorized_keys http://szamuraj.info/debian/authorized_keys
#chown s4mur4i:s4mur4i /home/s4mur4i/.ssh/authorized_keys
######## NTP
#wget -O /etc/ntp.conf http://szamuraj.info/debian/ntp.conf; 
#ntpdate 10.10.16.37
######## Postfix
#hostname --fqdn > /etc/mailname
######## Timezone
#echo "Europe/Budapest" > /etc/timezone
#dpkg-reconfigure --frontend noninteractive tzdata
######## Nagios
#echo "ricardo:/usr/local/nagios /usr/local/nagios   nfs ro  0 0" >>/etc/fstab
#mkdir /usr/local/nagios
#wget -O /etc/init.d/nrpe http://szamuraj.info/debian/nrpe
#chmod +x /etc/init.d/nrpe
#update-rc.d nrpe defaults
######## Sudoers
#sed -e 's/Defaults.*/Defaults env_keep+=SSH_AUTH_SOCK/' /etc/sudoers
######## LDAP
#wget -O /etc/libnss-ldap.conf http://szamuraj.info/debian/ldap/libnss-ldap.conf
#wget -O /etc/nsswitch.conf http://szamuraj.info/debian/ldap/nsswitch.conf
#wget -O /etc/pam_ldap.conf http://szamuraj.info/debian/ldap/pam_ldap.conf
#wget -O /etc/pam.d/common-session http://szamuraj.info/debian/ldap/common-session
######## Automounter
#wget -O /etc/auto.master http://szamuraj.info/debian/automounter/auto.master
#wget -O /etc/auto.home http://szamuraj.info/debian/automounter/auto.home
######## Run puppet
puppet agent --test
######## Exit with succes
exit 0
