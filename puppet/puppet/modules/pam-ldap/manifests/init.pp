class pam-ldap {
	package { "libnss-ldap" :
		ensure => present
	}
	file { "/etc/nsswitch.conf" :
		owner => "root",
	        group => "root",
		require => Package["libnss-ldap"],
	        mode => 0644,
	        source => "puppet://$puppetserver/modules/pam-ldap/nsswitch.conf",
	}
	file { "/etc/pam_ldap.conf" :
		owner => "root",
	        group => "root",
		require => Package["libnss-ldap"],
	        mode => 0644,
	        source => "puppet://$puppetserver/modules/pam-ldap/pam_ldap.conf",
	}
	file { "/etc/libnss-ldap.conf" :
		owner => "root",
	        group => "root",
		require => Package["libnss-ldap"],
	        mode => 0644,
	        source => "puppet://$puppetserver/modules/pam-ldap/libnss-ldap.conf",
	}
	file { "/etc/pam.d/common-session" :
		owner => "root",
	        group => "root",
		require => Package["libnss-ldap"],
	        mode => 0644,
	        source => "puppet://$puppetserver/modules/pam-ldap/common-session",
	}
}
