alter table cnames modify NameBegin1 char(64) not null;
alter table computers add LimitedUntilD int not null default 0;
alter table computers add KEY(LimitedUntilD);
insert into variables set
	Name='DEFAULT_BAN_INTERVAL'
	,Value=7*24*60*60
	,Descr='Alapértelmezett kitiltási idő (másodperc)'
;
insert into variables set
	Name='DEFAULT_LIMIT_INTERVAL'
	,Value=7*24*60*60
	,Descr='Alapértelmezett korlátozási idő (másodperc)'
;
