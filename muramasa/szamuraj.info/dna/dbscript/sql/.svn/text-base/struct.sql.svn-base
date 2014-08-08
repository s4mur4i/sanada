-- MySQL dump 10.9
--
-- Host: localhost    Database: dna
-- ------------------------------------------------------
-- Server version	4.1.8a-Debian_6-log

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE="NO_AUTO_VALUE_ON_ZERO" */;

--
-- Table structure for table `computers`
--

DROP TABLE IF EXISTS `computers`;
CREATE TABLE `computers` (
  `ID` int(11) NOT NULL auto_increment,
  `IPDomainID` int(11) NOT NULL default '0',
  `IPEnd` char(16) NOT NULL default '0',
  `NameDomainID` int(11) NOT NULL default '0',
  `NameBegin` char(127) NOT NULL default '0',
  `HWAddr` char(12) default NULL,
  `RootID` int(11) NOT NULL default '0',
  `Building` char(1) NOT NULL default '',
  `Room` char(16) NOT NULL default '',
  `CreateD` int(11) NOT NULL default '0',
  `BannedUntilD` int(11) NOT NULL default '0',
  `AccessClass` int(11) NOT NULL default '0', # 1: Lamer, 2: Gamer, 3: Server
  `IsOfficial` int(11) NOT NULL default '0', # Boolean
  `ValidUntilD` int not null default 1, -- LOL! Really one, "1", egy!
  `LimitedUntilD` int not null default 0,
  `LastValidityWarningD` int not null default 0,
  PRIMARY KEY  (`ID`),
  KEY `RootID` (`RootID`),
  KEY `BannedUntilD` (`BannedUntilD`),
  KEY `AccessClass` (`AccessClass`),
  KEY `IsOfficial` (`IsOfficial`),
  KEY `IPDomainID` (`IPDomainID`),
  KEY `IPEnd` (`IPEnd`),
  KEY `NameDomainID` (`NameDomainID`),
  KEY `NameBegin` (`NameBegin`),
  KEY `ValidUntilD` (`ValidUntilD`),
  KEY `LimitedUntilD` (`LimitedUntilD`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Table structure for table `dhcpds`
--

DROP TABLE IF EXISTS `dhcpds`;
CREATE TABLE `dhcpds` (
  `ID` int(11) NOT NULL auto_increment,
  `NetBase` char(15) NOT NULL default '0.0.0.0',
  `NetMaskWidth` int(11) NOT NULL default '0',
  `DefaultLeaseTime` int(11) NOT NULL default '600',
  `MaxLeaseTime` int(11) NOT NULL default '7200',
  `NameServers` char(255) NOT NULL default '',
  `DefaultDomain` char(194) NOT NULL default '',
  `GatewayIP` char(15) NOT NULL default '255.255.255.254',
  PRIMARY KEY  (`ID`),
  UNIQUE KEY `NetBase` (`NetBase`,`NetMaskWidth`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Table structure for table `domains`
--

DROP TABLE IF EXISTS `domains`;
CREATE TABLE `domains` (
  `ID` int(11) NOT NULL auto_increment,
  `DomainType` int(11) NOT NULL default '0',
  `IPBegin` varchar(16) NOT NULL default '',
  `NameEnd` varchar(128) NOT NULL default '',
  `TTL` int(11) NOT NULL default '604800',
  `SOAServer` varchar(255) NOT NULL default '',
  `SOAEmail` varchar(255) NOT NULL default '',
  `SOASerial` int(11) NOT NULL default '1',
  `SOARefresh` int(11) NOT NULL default '86400',
  `SOARetry` int(11) NOT NULL default '7200',
  `SOAExpire` int(11) NOT NULL default '3600000',
  `SOANegTTL` int(11) NOT NULL default '172800',
  `ModifyD` int(11) NOT NULL default '0',
  `LastExportD` int(11) NOT NULL default '0',
  `Text` mediumtext,
  `ClientConfig` mediumtext,
  PRIMARY KEY  (`ID`),
  KEY `DomainType` (`DomainType`),
  KEY `IPBegin` (`IPBegin`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Table structure for table `cnames`
--

DROP TABLE IF EXISTS `cnames`;
CREATE TABLE `cnames` (
  `ID` int(11) NOT NULL auto_increment,
  `CreateD` int(11) NOT NULL default '0',
  `CreatedByUserID` int(11) NOT NULL default '0',
  `ModifyD` int(11) NOT NULL default '0',
  `ModifiedByUserID` int(11) NOT NULL default '0',
  `NameDomainID1` int(11) NOT NULL default '0',
  `NameBegin1` char(64) NOT NULL,
  `Target` char(255) NOT NULL default '',
  `Descr` mediumtext,
  PRIMARY KEY  (`ID`),
  UNIQUE KEY `NameDomainID1` (`NameDomainID1`,`NameBegin1`,`Target`),
  KEY `NameDomainID1_2` (`NameDomainID1`),
  KEY `NameBegin1` (`NameBegin1`),
  KEY `Target` (`Target`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Table structure for table `masterips`
--

DROP TABLE IF EXISTS `masterips`;
CREATE TABLE `masterips` (
  `ID` int(11) NOT NULL auto_increment,
  `IPDomainID` int(11) NOT NULL default '0',
  `IPEnd` char(16) NOT NULL default '',
  PRIMARY KEY  (`ID`),
  UNIQUE KEY `IPDomainID` (`IPDomainID`,`IPEnd`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Table structure for table `masternames`
--

DROP TABLE IF EXISTS `masternames`;
CREATE TABLE `masternames` (
  `ID` int(11) NOT NULL auto_increment,
  `NameDomainID` int(11) NOT NULL default '0',
  `NameBegin` char(128) NOT NULL default '',
  PRIMARY KEY  (`ID`),
  UNIQUE KEY `NameDomainID` (`NameDomainID`,`NameBegin`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Table structure for table `roots`
--

DROP TABLE IF EXISTS `roots`;
CREATE TABLE `roots` (
  `ID` int(11) NOT NULL auto_increment,
  `PersonalID` char(16) NOT NULL default '',
  `Nick` char(16) NOT NULL default '',
  `RealName` char(64) NOT NULL default '',
  `Building` char(1) NOT NULL default '',
  `Room` char(16) NOT NULL default '',
  `Email` char(128) NOT NULL default '',
  `ComputerCount` int(11) NOT NULL default '0',
  PRIMARY KEY  (`ID`),
  UNIQUE KEY `Nick` (`Nick`),
  KEY `RealName` (`RealName`),
  KEY `ComputerCount` (`ComputerCount`),
  KEY `PersonalID` (`PersonalID`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Table structure for table `sessions`
--

DROP TABLE IF EXISTS `sessions`;
CREATE TABLE `sessions` (
  `ID` int(11) NOT NULL auto_increment,
  `UserID` int(11) NOT NULL default '1',
  `Cookie` bigint(20) NOT NULL default '0',
  `BeginD` int(11) NOT NULL default '0',
  `EndD` int(11) NOT NULL default '0',
  `IP` char(24) NOT NULL default '0.0.0.0',
  `Host` char(128) NOT NULL default '',
  `Browser` char(128) NOT NULL default '',
  PRIMARY KEY  (`ID`),
  KEY `sessions_UserID` (`UserID`),
  KEY `sessions_Cookie` (`Cookie`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `ID` int(11) NOT NULL auto_increment,
  `Nick` char(16) NOT NULL default '',
  `Password` char(32) NOT NULL default '',
  `CreateD` int(11) NOT NULL default '0',
  `LoginD` int(11) NOT NULL default '0',
  `TouchD` int(11) NOT NULL default '0',
  `LogoutD` int(11) NOT NULL default '0',
  `DeleteD` int(11) NOT NULL default '0',
  `Email` char(128) NOT NULL default '',
  `RealName` char(64) NOT NULL default '',
  `Rights` char(255) not null default '',
  PRIMARY KEY  (`ID`),
  UNIQUE KEY `users_Nick` (`Nick`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

drop table if exists `rights`;
create table `rights` (
	ID char(32) not null default "",
	Name char(64) not null default "",
	PRIMARY KEY(ID),
	KEY (Name)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

drop table if exists banlog;
create table banlog (
	ID int not null auto_increment, # Just the usual
	CreateD int not null default 0, # Entry date
	UserID int not null default 0, # The evil''s ID
	UserNick char(16) not null default '', # The evil''s Nick
	UserName char(64) not null default '', # The evil''s RealName
	EventType int not null default 0, # 1: BAN, 2: UNBAN
	BanEndD int not null default 0, # End of banning. When unbanning, the it is the current timestamp
	ComputerID int not null default 0, # -> comuter.ID
	ComputerName char(255) not null default "",
	ComputerIP char(16) not null default "0.0.0.0",
	ComputerRealName char(64) not null default "",
	Comment mediumtext,
	PRIMARY KEY(ID),
	KEY (CreateD),
	KEY (EventType),
	KEY (ComputerID)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

drop table if exists variables;
create table variables (
	Name char(32) not null default '',
	Value mediumtext,
	Descr char(255) not null default '',
	PRIMARY KEY(Name)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

drop table if exists log;
create table log (
	ID int not null auto_increment,
	Weight int not null default 0, # 1: NORMAL, 2: WARNING
	EventD int not null default 0,
	UserID int not null default 0, # The evil''s ID
	UserNick char(16) not null default '', # The evil''s Nick
	UserName char(64) not null default '', # The evil''s RealName
	Event char(32) not null default '',
	Params mediumtext,
	PRIMARY KEY(ID),
	KEY (Weight),
	KEY (EventD),
	KEY (UserID),
	KEY (UserNick),
	KEY (UserName),
	KEY (Event),
	FULLTEXT (Params)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

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
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
