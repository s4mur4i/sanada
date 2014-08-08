alter table computers add ValidUntilD int not null default 1; -- LOL! Really one, "1", egy!
alter table computers add KEY(ValidUntilD);

update computers set ValidUntilD=UNIX_TIMESTAMP()+15*24*60*60 where PaymentState in (0,1,2);
update computers set ValidUntilD=0 where PaymentState=3; -- Here we are!

alter table computers drop PaymentState;
