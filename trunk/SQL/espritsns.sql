-- 
-- Database: `espritsns`
-- 

-- --------------------------------------------------------

-- 
-- Table structure for table `activities`
-- 

CREATE TABLE `activities` (
  `id` int(11) NOT NULL auto_increment,
  `user_id` int(11) NOT NULL,
  `app_id` int(11) NOT NULL,
  `title` char(128) NOT NULL,
  `body` char(255) NOT NULL,
  `created` int(11) NOT NULL,
  KEY `id` (`id`),
  KEY `activity_stream_id` (`user_id`),
  KEY `created` (`created`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=52 ;

-- --------------------------------------------------------

-- 
-- Table structure for table `activity_media_items`
-- 

CREATE TABLE `activity_media_items` (
  `id` int(11) NOT NULL auto_increment,
  `activity_id` int(11) NOT NULL,
  `mime_type` char(64) NOT NULL,
  `media_type` enum('AUDIO','IMAGE','VIDEO') NOT NULL,
  `url` char(128) NOT NULL,
  KEY `id` (`id`),
  KEY `activity_id` (`activity_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

-- --------------------------------------------------------

-- 
-- Table structure for table `application_settings`
-- 

CREATE TABLE `application_settings` (
  `application_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `module_id` int(11) NOT NULL,
  `name` char(128) NOT NULL,
  `value` varchar(255) NOT NULL,
  UNIQUE KEY `application_id` (`application_id`,`user_id`,`module_id`,`name`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

-- 
-- Table structure for table `applications`
-- 

CREATE TABLE `applications` (
  `id` int(11) NOT NULL auto_increment,
  `url` char(128) NOT NULL,
  `title` char(128) default NULL,
  `directory_title` varchar(128) default NULL,
  `screenshot` char(128) default NULL,
  `thumbnail` char(128) default NULL,
  `author` char(128) default NULL,
  `author_email` char(128) default NULL,
  `description` mediumtext,
  `settings` mediumtext,
  `version` varchar(64) NOT NULL,
  `height` int(11) NOT NULL default '0',
  `scrolling` int(11) NOT NULL default '0',
  `modified` int(11) NOT NULL,
  `order` int(11) default '0',
  `approved` varchar(10) NOT NULL default 'yes',
  UNIQUE KEY `url` (`url`),
  KEY `id` (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=112 ;

-- --------------------------------------------------------

-- 
-- Table structure for table `user_album`
-- 

CREATE TABLE `user_album` (
  `user_id` int(11) NOT NULL,
  `photo_id` int(11) NOT NULL,
  `photo_name` varchar(50) NOT NULL,
  `thumb_name` varchar(50) NOT NULL,
  `photo_caption` varchar(100) default NULL,
  KEY `user_id` (`user_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

-- 
-- Table structure for table `user_applications`
-- 

CREATE TABLE `user_applications` (
  `id` int(11) NOT NULL auto_increment,
  `user_id` int(11) NOT NULL,
  `application_id` int(11) NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `user_id` (`user_id`),
  KEY `application_id` (`application_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=16 ;

-- --------------------------------------------------------

-- 
-- Table structure for table `user_broadcast`
-- 

CREATE TABLE `user_broadcast` (
  `user_id` int(11) NOT NULL,
  `header` varchar(100) default NULL,
  `article` varchar(1024) default NULL,
  `article_title` varchar(50) default NULL,
  `time_expire` datetime NOT NULL,
  PRIMARY KEY  (`user_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

-- 
-- Table structure for table `user_friend`
-- 

CREATE TABLE `user_friend` (
  `user_id` int(11) NOT NULL,
  `friend_id` int(11) NOT NULL,
  `pending` enum('yes','no') NOT NULL,
  PRIMARY KEY  (`friend_id`,`user_id`),
  KEY `friend_id` (`friend_id`),
  KEY `user_id` (`user_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

-- 
-- Table structure for table `user_main`
-- 

CREATE TABLE `user_main` (
  `user_id` int(11) NOT NULL auto_increment,
  `user_name` varchar(25) NOT NULL,
  `user_password` varchar(25) NOT NULL,
  `user_email` varchar(25) NOT NULL,
  PRIMARY KEY  (`user_id`),
  UNIQUE KEY `user_name` (`user_name`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=71 ;

-- --------------------------------------------------------

-- 
-- Table structure for table `user_online_status`
-- 

CREATE TABLE `user_online_status` (
  `user_id` int(11) NOT NULL,
  `last_online_time` datetime NOT NULL,
  `online_status` enum('yes','no') NOT NULL,
  KEY `user_id` (`user_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

-- 
-- Table structure for table `user_profile`
-- 

CREATE TABLE `user_profile` (
  `user_id` int(11) NOT NULL,
  `first_name` varchar(25) default NULL,
  `last_name` varchar(25) default NULL,
  `Gender` enum('m','f') default NULL,
  `user_image` varchar(50) default NULL,
  `profile_url` varchar(100) NOT NULL,
  `country` varchar(50) default NULL,
  `city` varchar(50) default NULL,
  `interests` varchar(100) NOT NULL,
  `date_of_birth` varchar(20) NOT NULL,
  KEY `user_id` (`user_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

-- 
-- Table structure for table `user_scrap`
-- 

CREATE TABLE `user_scrap` (
  `scrap_id` int(11) NOT NULL,
  `sender_id` int(11) NOT NULL,
  `receiver_id` int(11) NOT NULL,
  `scrap_content` text NOT NULL,
  KEY `user_id` (`receiver_id`),
  KEY `sender_id` (`sender_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
