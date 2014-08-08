alter table roots drop Nick;
insert into variables set
	Name='EMAIL_SIMULATE_ONLY'
	,Value="true"
	,Descr='Ha az értéke "true", akkor E-mail küldések nem történnek meg.'
;
alter table computers add LastValidityWarningD int not null default 0;
