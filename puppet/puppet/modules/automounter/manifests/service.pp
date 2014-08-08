class automounter::service {
	if $fqdn == "ricardo.szamuraj.info" {
		$ensure = 'stopped'
	} else {
		$ensure = 'running'
	}
	service { "autofs":
		ensure => $ensure,
		hasstatus => false,
		hasrestart => true,
		enable => true,
		pattern => "automount",
		require => Class["automounter::install"],
	}
}
