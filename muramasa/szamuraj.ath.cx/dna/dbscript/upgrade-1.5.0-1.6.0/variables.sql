alter table variables add Descr char(255) not null default '';
insert into variables set
	Name='NEXT_TERMINATION_DATE'
	,Value=FROM_UNIXTIME(UNIX_TIMESTAMP()+15*24*60*60)
	,Descr='Alapértelmezett lejárati dátum ("ÉÉ-HH-NN ÓÓ:PP:MM")'
;
insert into variables set
	Name='NEXT_GRACE_DATE'
	,Value=FROM_UNIXTIME(UNIX_TIMESTAMP()+30*24*60*60)
	,Descr='Alapértelmezett haladékos lejárati dátum ("ÉÉ-HH-NN ÓÓ:PP:MM")'
;
