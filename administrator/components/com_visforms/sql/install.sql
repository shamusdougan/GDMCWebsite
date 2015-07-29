drop table if exists #__visforms;

create table #__visforms
(
   id                           int(11) not null AUTO_INCREMENT,
   asset_id INTEGER UNSIGNED NOT NULL DEFAULT 0,
   name                         text,
   title                        text,
   checked_out 					int(10) NOT NULL default '0',
   checked_out_time datetime NOT NULL default '0000-00-00 00:00:00',
   description                  longtext,
   emailfrom                    text,
   emailfromname				text,
   emailto                      text,
   emailcc                      text,
   emailbcc                     text,
   subject						text,	
   created                      datetime NOT NULL default '0000-00-00 00:00:00',
   created_by                   int(11),
   hits                         int(11) NOT NULL default '0',
   published                    tinyint,
   saveresult                   tinyint,
   emailresult                  tinyint,
   textresult                   longtext,
   redirecturl					text,
   spambotcheck                 tinyint(1) NOT NULL default '0',
   captcha                    	tinyint,
   uploadpath					text,
   maxfilesize					int,
   allowedextensions			text,
   poweredby                   	tinyint,
   emailreceipt                 tinyint,
   emailreceipttext             longtext,
   emailreceiptfrom             text,
   emailreceiptfromname         text,
   emailreceiptsubject			text,
   emailreceiptsettings			text,
   emailresultincfile           tinyint,
   fronttitle                   text,
   frontdescription             longtext,
   frontendsettings				text,
   access                       int(11) NOT NULL default '0',
   language                     char(7) NOT NULL,
   exportsettings               text,
   layoutsettings               text,
   spamprotection               text,
   captchaoptions               text,
   primary key (id)
) ENGINE=MyISAM AUTO_INCREMENT=0;

drop table if exists #__visfields;

create table #__visfields
(
   id                           int(11) not null AUTO_INCREMENT,
   asset_id INTEGER UNSIGNED NOT NULL DEFAULT 0,
   fid                          int(11),
   name                         text,
   label                  	    text,
   checked_out 					int(10) NOT NULL default '0',
   checked_out_time datetime NOT NULL default '0000-00-00 00:00:00',
   created                      datetime NOT NULL default '0000-00-00 00:00:00',
   created_by                   int(11) NOT NULL default '0',
   typefield                    text,
   defaultvalue					text,
   published                    tinyint,
   ordering                     int(11) not null DEFAULT 0,
   labelCSSclass				text,
   fieldCSSclass				text,
   textseparator				text,
   customtext					text,
   frontdisplay					tinyint,
   includefieldonexport         tinyint(4) not null DEFAULT 1,
   allowurlparam                tinyint(4) not null DEFAULT 0,
   customtextposition            tinyint(4) not null DEFAULT 0,
   uniquevaluesonly             tinyint(4) not null DEFAULT 0,
   restrictions                 text,
   primary key (id)
) ENGINE=MyISAM AUTO_INCREMENT=0;
