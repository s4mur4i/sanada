class base::gcc {
	package { "build-essential":
		ensure => present
	}
	package { "make":
		ensure => present
	}

}
