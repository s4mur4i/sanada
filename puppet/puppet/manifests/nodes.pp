#node 'puppet.szamuraj.info' inherits standard {
#}
node default inherits standard {
}

node standard {
	include sudo, automounter, pam-ldap, ssh, ntp, nrpe, base, puppet, svn, vim
	include ocsagent
}
node test inherits default{
#	include ocsagent
}

node test2 inherits default{
#	include ocsagent
}
