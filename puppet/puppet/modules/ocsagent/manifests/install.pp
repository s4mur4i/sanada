class ocsagent::install {
	@package { [ "dmidecode", "libxml-simple-perl", "libcompress-zlib-perl", "libnet-ip-perl", "libwww-perl", "libdigest-md5-file-perl", "libnet-ssleay-perl", "libcrypt-ssleay-perl", "libnet-snmp-perl", "libproc-pid-file-perl", "libproc-daemon-perl", "net-tools", "pciutils", "smartmontools", "read-edid", "nmap"]: 
		# nem tudtam berakni: libsys-syslog-perl
		ensure => installed,
		tag => 'ocsagent::packagestoinstall'
	}
	Package <| tag == 'ocsagent::packagestoinstall' |>
}	
