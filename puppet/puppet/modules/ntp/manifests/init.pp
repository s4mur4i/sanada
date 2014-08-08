class ntp ( $realserver = "ntp.szamuraj.info" , $realstratum = "11" ) {
	case $operatingsystem {
	  	debian, ubuntu: { 
          		$service_name    = 'ntp'
	 		$conf_template   = 'ntp.conf.debian.erb'
	 	}

	}
	case $virtual {
                kvm: {
			$ensure = "false"
			$package = "purged"
			$enable = "false"
			$file = "absent"
		}
		default: {
			$ensure = "running"
			$package = "installed"
			$enable = "true"
			$file = "file"


			service { 'ntp':
        	        name      => $service_name,
        	        ensure    => $ensure,
        	        enable    => $enable,
        	        subscribe => File['ntp.conf'],
	        }

		}
	}	

	if $fqdn == "ricardo.szamuraj.info" {
		$server = [ "ntp2.usv.ro","ntp.stairweb.de" ]
		$stratum = "10"
	} else {
		$server = $realserver
		$stratum = $realstratum
	}

	package { 'ntp':
        	ensure => $package,
      	}

	file { 'ntp.conf':
		path    => '/etc/ntp.conf',
		ensure  => $file,
		notify => Exec["restart"],
		require => Package['ntp'],
		content => template("ntp/${conf_template}"),
      	}
	exec { "restart":
		command => "/etc/init.d/ntp stop;/usr/sbin/ntpdate ntp.szamuraj.info ;/etc/init.d/ntp start",
		refreshonly => true,
	}
}
