class svn::files {
	file { "/script":
		ensure => directory,
		mode => 0555,
		owner => 'root',
		group => 'root',
		require => Class["svn::install","ssh"],
		notify => Exec["create"],
	}

	exec { "svn update /script/":
		path =>  [ "/usr/bin", "/usr/sbin", "/bin" ] ,
		unless => "echo \"\" | awk -v line=`svn st -u /script/ 2>&1| wc -l` '{ if ( line > 1 ) exit 1; else exit 0 }'",
	}
	exec {	"create":
		command => "rm -rf /script/*;svn co http://svn/projects/infra/trunk /script/",
		path =>  [ "/usr/bin", "/usr/sbin", "/bin" ] ,
		subscribe => File["/script"],
		unless => "echo \"\" | awk -v ret=\"$(svn st /script 2>&1)\" '{ if (ret ~ /svn.*/ ) exit 1; else exit 0 }'",
	}
}
