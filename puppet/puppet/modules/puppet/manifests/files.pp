class puppet::files {
	file { "/etc/default/puppet":
		ensure => present,
		source => "puppet://$puppetserver/modules/puppet/puppet",
		mode => "0644",
		owner => 'root',
		group => 'root',
	}
	if $fqdn != 'puppet.szamuraj.info' {
		file { "/etc/puppet/puppet.conf":
			source => "puppet://$puppetserver/modules/puppet/puppet.conf",
			mode => "0644",
			owner => 'root',
			group => 'root',
			ensure => file,
			notify => Class["puppet::service"],
		}
	}
}
