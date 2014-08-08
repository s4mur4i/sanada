class ocsagent::daemon {
	file { "/etc/cron.d/ocsinventory-agent":
		ensure => file,
		source => "puppet://$puppetserver/modules/ocsagent/cron/ocsinventory-agent",
		require => Class["ocsagent::config"],
		mode => 0544,
		owner => 'root',
		group => 'root',
	}

	exec { "daemon":
		command => "/usr/local/bin/ocsinventory-agent -d",
		unless => "ps -ef |grep -v grep | grep -q ocsinventory-agent",
		path => [ "/usr/bin", "/usr/sbin", "/bin" ] ,
	}
}
