define line($file, $line, $ensure = 'present') {
	case $ensure {
		default : { err ( "unknown ensure value ${ensure}" ) }
		present: {
		    exec { "/bin/echo '${line}' > '${file}';/usr/sbin/dpkg-reconfigure --frontend noninteractive tzdata":
			unless => "/bin/grep -q '${line}' '${file}'"
		    }
		}
		absent: {
		    exec { "/bin/grep -vFx '${line}' '${file}' | /usr/bin/tee '${file}' > /dev/null 2>&1":
		      onlyif => "/bin/grep -q '${line}' '${file}'"
		    }
		}
	}
}

class base::mailname {
	line { "mailname":
                file => "/etc/mailname",
                line => "$fqdn",
	}
	file { "/etc/timezone":
		ensure => present,
		owner => 'root',
		group => 'root',
		mode => '0644',
		require => Line["mailname"],
	}
}
