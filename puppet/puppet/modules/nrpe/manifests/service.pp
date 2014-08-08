class nrpe::service {
	service { "nrpe":
		ensure => running,
		require => Class["nrpe::files"],
		hasstatus => false,
		hasrestart => true,
		enable => true,	
	}
}
