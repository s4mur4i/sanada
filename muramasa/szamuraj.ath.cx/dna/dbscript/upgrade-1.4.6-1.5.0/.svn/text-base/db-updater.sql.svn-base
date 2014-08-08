DROP TABLE IF EXISTS `cnames`;
CREATE TABLE `cnames` (
  `ID` int(11) NOT NULL auto_increment,
  `CreateD` int(11) NOT NULL default '0',
  `CreatedByUserID` int(11) NOT NULL default '0',
  `ModifyD` int(11) NOT NULL default '0',
  `ModifiedByUserID` int(11) NOT NULL default '0',
  `NameDomainID1` int(11) NOT NULL default '0',
  `NameBegin1` char(127) NOT NULL default '',
  `Target` char(255) NOT NULL default '',
  PRIMARY KEY  (`ID`),
  UNIQUE KEY `NameDomainID1` (`NameDomainID1`,`NameBegin1`,`Target`),
  KEY `NameDomainID1_2` (`NameDomainID1`),
  KEY `NameBegin1` (`NameBegin1`),
  KEY `Target` (`Target`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
