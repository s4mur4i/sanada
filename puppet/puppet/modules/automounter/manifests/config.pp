class automounter::config {
	file { "/etc/auto.home":
		ensure => file,
		mode => 0644,
		owner => 'root',
		group => 'root',
		require => Class["automounter::install"],
		notify => Class["automounter::service"],
		source => "puppet://$puppetserver/modules/automounter/auto.home",
	}
	file { "/etc/auto.master":
		ensure => file,
		mode => 0644,
		owner => 'root',
		group => 'root',
		require => Class["automounter::install"],
		notify => Class["automounter::service"],
		source => "puppet://$puppetserver/modules/automounter/auto.master",
	}
}
