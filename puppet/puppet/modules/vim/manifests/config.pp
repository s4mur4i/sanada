class vim::config {
	file {  "/etc/vim/vimrc":
		require => Class["vim::install"],
		ensure => file,
		owner => 'root',
		group => 'root',
		mode => 0744,
		source => "puppet://$puppetserver/modules/vim/vimrc",
		checksum => md5,
	}
}
