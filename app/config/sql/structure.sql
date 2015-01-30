-- phpMyAdmin SQL Dump
-- version 3.5.8.1deb1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jan 15, 2014 at 02:21 AM
-- Server version: 5.5.32-0ubuntu0.13.04.1
-- PHP Version: 5.4.9-4ubuntu2.4

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `phone`
--

-- --------------------------------------------------------

--
-- Table structure for table `active_dn`
--

CREATE TABLE IF NOT EXISTS `active_dn` (
  `id` int(11) NOT NULL,
  `function` varchar(255) NOT NULL,
  `emer` varchar(255) NOT NULL,
  `display` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `bakoms`
--

CREATE TABLE IF NOT EXISTS `bakoms` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `PLZ` int(11) DEFAULT NULL,
  `PLZ_Z` int(11) DEFAULT NULL,
  `ort` varchar(255) DEFAULT NULL,
  `KT` varchar(255) DEFAULT NULL,
  `emer` varchar(255) DEFAULT NULL,
  `gemNr` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5078 ;

-- --------------------------------------------------------

--
-- Table structure for table `base_dn`
--

CREATE TABLE IF NOT EXISTS `base_dn` (
  `id` int(11) NOT NULL,
  `rangeName` varchar(255) NOT NULL,
  `location_id` varchar(255) NOT NULL,
  `type` varchar(20) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

CREATE TABLE IF NOT EXISTS `customers` (
  `id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `bsk` int(11) NOT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `type` varchar(255) NOT NULL,
  `moh_id` int(11) NOT NULL,
  `presentation_group` varchar(255) DEFAULT NULL,
  `onDemand` tinyint(1) NOT NULL DEFAULT '0',
  `SLA` varchar(255) NOT NULL DEFAULT '0',
  `CTI` tinyint(1) NOT NULL DEFAULT '0',
  `NSC` tinyint(1) NOT NULL DEFAULT '0',
  `ONB` tinyint(1) NOT NULL DEFAULT '0',
  `CD` tinyint(1) NOT NULL DEFAULT '0',
  `OC` tinyint(1) NOT NULL DEFAULT '0',
  `Info1` varchar(255) NOT NULL DEFAULT '0',
  `Info2` varchar(255) NOT NULL DEFAULT '0',
  `Info3` varchar(255) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `c_features`
--

CREATE TABLE IF NOT EXISTS `c_features` (
  `id` varchar(255) NOT NULL,
  `stationkey_id` varchar(255) NOT NULL,
  `short_name` varchar(255) DEFAULT NULL,
  `primary_value` varchar(255) DEFAULT NULL,
  `label` varchar(255) DEFAULT NULL,
  `cs2kfeatures` varchar(255) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `test` varchar(255) DEFAULT NULL,
  `ord` int(4) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `stationkey_id` (`stationkey_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `c_stationkeys`
--

CREATE TABLE IF NOT EXISTS `c_stationkeys` (
  `id` varchar(255) NOT NULL,
  `keynumber` int(11) NOT NULL,
  `dn` int(11) DEFAULT NULL,
  `station_id` varchar(255) NOT NULL,
  `customer_id` varchar(255) NOT NULL,
  `location_id` int(11) DEFAULT NULL,
  `label` varchar(255) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `c_stations`
--

CREATE TABLE IF NOT EXISTS `c_stations` (
  `4voip_id` varchar(255) NOT NULL,
  `id` varchar(255) NOT NULL,
  `customer_id` varchar(255) NOT NULL,
  `port` varchar(255) NOT NULL,
  `phone_type` varchar(255) DEFAULT NULL,
  `type` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `CWT` varchar(255) NOT NULL,
  `CFRA` tinyint(1) NOT NULL,
  `SIMRING` varchar(255) NOT NULL,
  `COMBOX` tinyint(1) NOT NULL DEFAULT '0',
  `MOH` tinyint(1) NOT NULL DEFAULT '0',
  `CTI` tinyint(1) NOT NULL DEFAULT '0',
  `extensions` tinyint(1) NOT NULL DEFAULT '0',
  `slug` varchar(255) NOT NULL,
  `desc` text NOT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `dns`
--

CREATE TABLE IF NOT EXISTS `dns` (
  `id` int(11) DEFAULT NULL,
  `location_id` varchar(255) DEFAULT NULL,
  `rangeName` varchar(255) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  `status` varchar(255) DEFAULT NULL,
  `function` varchar(255) DEFAULT NULL,
  `emer` varchar(255) DEFAULT NULL,
  `display` varchar(255) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `executions`
--

CREATE TABLE IF NOT EXISTS `executions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `scenario_id` varchar(255) NOT NULL,
  `user_id` varchar(255) NOT NULL,
  `targetDate` datetime DEFAULT NULL,
  `applyDate` datetime DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  `status` varchar(255) NOT NULL,
  `operation` varchar(255) NOT NULL,
  `response` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=258 ;

-- --------------------------------------------------------

--
-- Table structure for table `features`
--

CREATE TABLE IF NOT EXISTS `features` (
  `id` varchar(255) NOT NULL,
  `stationkey_id` varchar(255) NOT NULL,
  `short_name` varchar(255) DEFAULT NULL,
  `primary_value` varchar(255) DEFAULT NULL,
  `label` varchar(255) DEFAULT NULL,
  `cs2kfeatures` varchar(255) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `test` varchar(255) DEFAULT NULL,
  `ord` int(4) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `stationkey_id` (`stationkey_id`),
  KEY `primary_value` (`primary_value`),
  KEY `short_name` (`short_name`),
  KEY `label` (`label`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `groups`
--

CREATE TABLE IF NOT EXISTS `groups` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `customer_id` varchar(255) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `identifier` varchar(255) DEFAULT NULL,
  `desc` varchar(255) DEFAULT NULL,
  `type` varchar(255) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `createdby` varchar(255) DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=919864151 ;

-- --------------------------------------------------------

--
-- Table structure for table `i18n`
--

CREATE TABLE IF NOT EXISTS `i18n` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `locale` varchar(6) NOT NULL,
  `model` varchar(255) NOT NULL,
  `foreign_key` int(10) NOT NULL,
  `field` varchar(255) NOT NULL,
  `content` text,
  PRIMARY KEY (`id`),
  KEY `locale` (`locale`),
  KEY `model` (`model`),
  KEY `row_id` (`foreign_key`),
  KEY `field` (`field`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `locations`
--

CREATE TABLE IF NOT EXISTS `locations` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `lbl` varchar(255) DEFAULT NULL,
  `customer_id` varchar(255) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `zip` int(11) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `emergency` varchar(255) DEFAULT NULL,
  `loctype` varchar(255) DEFAULT NULL,
  `scm_name` varchar(60) DEFAULT NULL,
  `middle_box` int(11) DEFAULT NULL,
  `cer1` varchar(60) DEFAULT NULL,
  `cer2` varchar(60) DEFAULT NULL,
  `srv_code` int(11) DEFAULT NULL,
  `call_splitting` tinyint(1) DEFAULT NULL,
  `bw` int(11) DEFAULT NULL,
  `technology` varchar(60) DEFAULT NULL,
  `pro_nr` varchar(60) DEFAULT NULL,
  `slug` varchar(255) NOT NULL,
  `desc` text NOT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=51038935 ;

-- --------------------------------------------------------

--
-- Table structure for table `logs`
--

CREATE TABLE IF NOT EXISTS `logs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user` varchar(255) NOT NULL,
  `log_entry` text NOT NULL,
  `slug` varchar(255) NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  `status` int(11) NOT NULL DEFAULT '1',
  `modification_status` tinyint(4) NOT NULL,
  `modification_response` text,
  `app_type` varchar(60) DEFAULT NULL,
  `bsk` varchar(255) DEFAULT NULL,
  `customer_id` varchar(255) DEFAULT NULL,
  `affected_obj` varchar(255) DEFAULT NULL,
  `affected_obj_name` varchar(64) DEFAULT NULL,
  `affected_obj_type` varchar(64) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=113496 ;

-- --------------------------------------------------------

--
-- Table structure for table `mediatrixes`
--

CREATE TABLE IF NOT EXISTS `mediatrixes` (
  `id` varchar(255) NOT NULL,
  `location_id` varchar(255) NOT NULL,
  `type` varchar(255) NOT NULL,
  `location_desc` text NOT NULL,
  `default_gw` varchar(60) DEFAULT NULL,
  `mask` varchar(60) DEFAULT NULL,
  `ipaddress` varchar(60) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `oams`
--

CREATE TABLE IF NOT EXISTS `oams` (
  `id` int(11) NOT NULL,
  `report` varchar(1024) DEFAULT NULL,
  `date` varchar(255) DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `odsentries`
--

CREATE TABLE IF NOT EXISTS `odsentries` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `scenario_id` varchar(255) DEFAULT NULL,
  `source` varchar(16) DEFAULT NULL,
  `dest` varchar(16) DEFAULT NULL,
  `state` varchar(8) DEFAULT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=14241 ;

-- --------------------------------------------------------

--
-- Table structure for table `ports`
--

CREATE TABLE IF NOT EXISTS `ports` (
  `id` varchar(255) NOT NULL,
  `mediatrix_id` varchar(255) NOT NULL,
  `station_id` varchar(255) NOT NULL,
  `type` varchar(255) NOT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `potentries`
--

CREATE TABLE IF NOT EXISTS `potentries` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tag_id` varchar(512) DEFAULT NULL,
  `page` varchar(255) DEFAULT NULL,
  `linenumber` int(11) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `createdBy` varchar(64) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=261 ;

-- --------------------------------------------------------

--
-- Table structure for table `scenarios`
--

CREATE TABLE IF NOT EXISTS `scenarios` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `Name` varchar(255) NOT NULL,
  `Summary` text,
  `ActScript` text,
  `DeActScript` text,
  `customer_id` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `scenarios_name` (`Name`,`customer_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1035 ;

-- --------------------------------------------------------

--
-- Table structure for table `stationkeys`
--

CREATE TABLE IF NOT EXISTS `stationkeys` (
  `id` varchar(255) NOT NULL,
  `keynumber` int(11) NOT NULL,
  `dn` int(11) DEFAULT NULL,
  `station_id` varchar(255) NOT NULL,
  `customer_id` varchar(255) NOT NULL,
  `location_id` int(11) DEFAULT NULL,
  `label` varchar(255) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `stations`
--

CREATE TABLE IF NOT EXISTS `stations` (
  `4voip_id` varchar(255) NOT NULL,
  `id` varchar(255) NOT NULL,
  `customer_id` varchar(255) NOT NULL,
  `port` varchar(255) NOT NULL,
  `phone_type` varchar(255) DEFAULT NULL,
  `type` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `CWT` varchar(255) NOT NULL,
  `CFRA` tinyint(1) NOT NULL,
  `SIMRING` varchar(255) NOT NULL,
  `COMBOX` tinyint(1) NOT NULL DEFAULT '0',
  `MOH` tinyint(1) NOT NULL DEFAULT '0',
  `CTI` tinyint(1) NOT NULL DEFAULT '0',
  `extensions` tinyint(1) NOT NULL DEFAULT '0',
  `msb` tinyint(4) DEFAULT NULL,
  `slug` varchar(255) NOT NULL,
  `desc` text NOT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tagentries`
--

CREATE TABLE IF NOT EXISTS `tagentries` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tag_id` varchar(512) DEFAULT NULL,
  `page` varchar(255) DEFAULT NULL,
  `linenumber` int(11) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `createdBy` varchar(64) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=260 ;

-- --------------------------------------------------------

--
-- Table structure for table `tags`
--

CREATE TABLE IF NOT EXISTS `tags` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `original_tag` varchar(1024) DEFAULT NULL,
  `type` varchar(64) DEFAULT NULL,
  `comment` varchar(1024) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `createdBy` varchar(64) DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  `modifiedBy` varchar(64) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=261 ;

-- --------------------------------------------------------

--
-- Table structure for table `transentries`
--

CREATE TABLE IF NOT EXISTS `transentries` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tag_id` varchar(512) DEFAULT NULL,
  `language` varchar(8) DEFAULT NULL,
  `translation` varchar(1024) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `createdBy` varchar(64) DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  `modifiedBy` varchar(64) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=261 ;

-- --------------------------------------------------------

--
-- Table structure for table `trunkentries`
--

CREATE TABLE IF NOT EXISTS `trunkentries` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `dn_id` int(11) DEFAULT NULL,
  `trunk_id` varchar(255) DEFAULT NULL,
  `state` varchar(8) DEFAULT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=220699 ;

-- --------------------------------------------------------

--
-- Table structure for table `trunks`
--

CREATE TABLE IF NOT EXISTS `trunks` (
  `id` varchar(64) NOT NULL,
  `location_id` varchar(255) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `scm_name` varchar(255) DEFAULT NULL,
  `channel` int(5) DEFAULT NULL,
  `gate_type` varchar(255) DEFAULT NULL,
  `pbx_type` varchar(255) DEFAULT NULL,
  `redundancy` varchar(255) DEFAULT NULL,
  `sbc` varchar(255) DEFAULT NULL,
  `call_scenario` varchar(255) DEFAULT NULL,
  `remark` text,
  `scm_remark` text,
  `pbx_ip` varchar(64) DEFAULT NULL,
  `nat_ip` varchar(64) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `userlogs`
--

CREATE TABLE IF NOT EXISTS `userlogs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `station_id` int(11) NOT NULL,
  `user_id` varchar(255) NOT NULL,
  `user_name` varchar(100) NOT NULL,
  `time` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3324 ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
