class ocsagent::config {
	file { "/tmp/OCSagent":
		ensure => directory,
		recurse => true,
		owner => 'root',
		group => 'root',
		source => "puppet://$puppetserver/modules/ocsagent/source/",
		require => Class["ocsagent::install"],
#		notify => Exec["compile"],
	}

	exec { "compile":
		path =>  [ "/usr/bin", "/usr/sbin", "/bin" ] ,
		subscribe => File ["/tmp/OCSagent"],
		command => "/bin/sh -c \"cd /tmp/OCSagent; perl Makefile.PL ;make;make install>/tmp/test\" ",
		creates => "/etc/ocsinventory",
#		unless => "echo \"\"; if [ -d /etc/ocsinventory ]; then exit 0 ; else exit 1 ;fi ",
	}
}
