class nrpe::files {
	file { "/usr/local/nagios":
		ensure => directory,
		recurse => true,
		purge => true, 
		force => true,
#		owner => 'nagios',
		group => 'nagios',
#		mode => 0755,
		source => "puppet://$puppetserver/modules/nrpe",
	}
	file { "/etc/init.d/nrpe":
		ensure => file,
		owner => 'root',
		group => 'root',
		mode => 0555,
		notify => Exec["nrpe"],
		require => File["/usr/local/nagios"],
		source => "puppet://$puppetserver/modules/nrpe/nrpe",
	}
	exec { "nrpe":
		require => File["/etc/init.d/nrpe"],
		command => "/usr/sbin/update-rc.d nrpe defaults",
		refreshonly => true,
	}
}
