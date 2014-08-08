class puppet::service {
	service { "puppet":
		ensure => running,
		hasrestart => true,
		hasstatus => true,
		enable => true,
		require => Class["puppet::files"],
	}
}
