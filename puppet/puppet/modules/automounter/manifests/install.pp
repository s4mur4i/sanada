class automounter::install {
	package { "autofs5":
		ensure => installed,
	}
}
