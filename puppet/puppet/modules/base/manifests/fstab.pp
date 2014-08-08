class base::fstab {
	case $virtual {
		kvm: {
			file { "/etc/fstab":
				notify => Exec["mount"],
				ensure => file,
				owner => 'root',
				group => 'root',
				source => "puppet://$puppetserver/modules/base/fstab",
			}
		}
	}
	exec { "mount":
		command => "/bin/mount -a",
		refreshonly => true,
	}
}
