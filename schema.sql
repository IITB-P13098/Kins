-- CREATE DATABASE IF NOT EXISTS ci_kins;

-- --------------------------------------------------------

--
-- Table structure for table ci_sessions
--

CREATE TABLE IF NOT EXISTS ci_sessions (
  session_id        varchar(40)       COLLATE utf8_bin  NOT NULL DEFAULT '0',
  ip_address        varchar(45)       COLLATE utf8_bin  NOT NULL DEFAULT '0',
  user_agent        varchar(120)      COLLATE utf8_bin  NOT NULL,
  last_activity     int unsigned                        NOT NULL DEFAULT '0',
  user_data         text              COLLATE utf8_bin  NOT NULL,
  PRIMARY KEY (session_id),
  KEY last_activity_idx (last_activity)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Table structure for table login_attempt
--

CREATE TABLE IF NOT EXISTS login_attempt (
  attempt_id        int                                 NOT NULL AUTO_INCREMENT,
  ip_address        varchar(40)       COLLATE utf8_bin  NOT NULL,
  login             varchar(50)       COLLATE utf8_bin  NOT NULL,
  time              timestamp                           NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (attempt_id)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Table structure for table user
--

CREATE TABLE IF NOT EXISTS user (
  user_id           bigint unsigned                     NOT NULL AUTO_INCREMENT,
  username          varchar(50)       COLLATE utf8_bin  NOT NULL UNIQUE,
  full_name         varchar(32)       COLLATE utf8_bin  NOT NULL,
  bio               text              COLLATE utf8_bin  DEFAULT NULL,
  location          varchar(32)       COLLATE utf8_bin  DEFAULT NULL, -- city/town, state, country
  time_zone         varchar(32)       COLLATE utf8_bin  DEFAULT NULL, -- (us) region
  utc_offset        int                                 NOT NULL DEFAULT '0',
  lang              varchar(8)        COLLATE utf8_bin  DEFAULT 'en', -- (en)
  profile_image_url text              COLLATE ascii_bin DEFAULT NULL,
  cover_image_url   text              COLLATE ascii_bin DEFAULT NULL,

  created           timestamp                           NOT NULL DEFAULT CURRENT_TIMESTAMP,
  updated           timestamp                           NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  deactivated       tinyint(1)                          NOT NULL DEFAULT '0',
  PRIMARY KEY (user_id)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Table structure for table user_login
--

CREATE TABLE IF NOT EXISTS user_login (
  user_id                 bigint unsigned                       NOT NULL,
  email                   varchar(100)      COLLATE utf8_bin    NOT NULL  UNIQUE,
  verified                tinyint(1)                            NOT NULL  DEFAULT '0',
  password                varchar(255)      COLLATE utf8_bin    NOT NULL,
  last_ip                 varchar(40)       COLLATE utf8_bin    NOT NULL,
  last_login              timestamp                             NOT NULL  DEFAULT '0000-00-00 00:00:00',
  banned                  tinyint(1)                            NOT NULL  DEFAULT '0',
  ban_reason              varchar(255)      COLLATE utf8_bin              DEFAULT NULL,

  email_key               varchar(32)       COLLATE ascii_bin             DEFAULT NULL,
  -- email_key_requested     timestamp                             NOT NULL  DEFAULT '0000-00-00 00:00:00',
  password_key            varchar(32)       COLLATE ascii_bin             DEFAULT NULL,
  -- password_key_requested  timestamp                             NOT NULL  DEFAULT '0000-00-00 00:00:00',

  updated                 timestamp                             NOT NULL  DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (user_id),
  FOREIGN KEY (user_id) REFERENCES user(user_id) ON UPDATE CASCADE ON DELETE CASCADE
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Table structure for table user_autologin
--

CREATE TABLE IF NOT EXISTS user_autologin (
  user_id           bigint unsigned                     NOT NULL,
  autologin_key     char(32)          COLLATE ascii_bin NOT NULL,
  user_agent        varchar(150)      COLLATE utf8_bin  NOT NULL,
  last_ip           varchar(40)       COLLATE utf8_bin  NOT NULL,
  last_login        timestamp                           NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (user_id, autologin_key),
  FOREIGN KEY (user_id) REFERENCES user(user_id) ON UPDATE CASCADE ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;