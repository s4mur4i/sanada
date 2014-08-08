class ssh::config {
	$partial_hostname = regsubst($fqdn, '\.szamuraj\.info$', '')
	if $partial_hostname == $hostname {
		$host_aliases = [ $ipaddress, $hostname ]
	} else {
		$host_aliases = [ $ipaddress, $hostname, $partial_hostname ]
	}
	@@sshkey { "${fqdn}": 
		ensure => present,
		type => 'rsa', 
		key => $sshrsakey, 
		host_aliases => $hostaliases,
	}
    	Sshkey <<| |>>
	file { "/etc/ssh/ssh_known_hosts":
   	 	mode    => 644,
  	}
}
