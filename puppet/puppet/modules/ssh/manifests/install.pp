class ssh::install ($ensure=present, $port='22') {
  package { 'sshd':
    name => 'openssh-server',
    ensure => $ensure,
  }
  file { "/etc/ssh/sshd_config":
            notify  => Class["ssh::service"],
            mode    => 600,
            owner   => "root",
            group   => "root",
            require => Package["openssh-server"],
            source => "puppet://$puppetserver/modules/ssh/sshd_config",
        }

        file { "/etc/ssh/ssh_config":
            notify  => Class["ssh::service"],
            mode    => 600,
            owner   => "root",
            group   => "root",
            require => Package["openssh-server"],
            source => "puppet://$puppetserver/modules/ssh/ssh_config",
        }
	file { "/root/.ssh":
		notify  => Class["ssh::service"],
            	mode    => 600,
		ensure	=> directory,
            	owner   => "root",
            	group   => "root",
		require => Package["openssh-server"],
	}

	file { "/root/.ssh/authorized_keys":
                notify  => Class["ssh::service"],
                mode    => 600,
                owner   => "root",
                group   => "root",
                require => Package["openssh-server"],
                source => "puppet://$puppetserver/modules/ssh/authorized_keys",
        }

}
