drop table if exists deniednets;
create table deniednets (
	ID int not null auto_increment,
	Network char(15) not null default 0,
	MaskLength int not null default 32,
	Descr mediumtext,
	CreateD int not null default 0,
	CreateByUserID int not null default 0,
	ModifyD int not null default 0,
	ModifyByUserID int not null default 0,
	PRIMARY KEY(ID),
	UNIQUE KEY(Network,MaskLength),
	KEY(Network),
	KEY(CreateD)
);
