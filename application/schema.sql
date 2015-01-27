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
-- Table structure for table user
--

CREATE TABLE IF NOT EXISTS user (
  user_id           bigint unsigned                     NOT NULL AUTO_INCREMENT,
  password          varchar(255)      COLLATE utf8_bin  NOT NULL,
  email             varchar(100)      COLLATE utf8_bin  NOT NULL UNIQUE,
  email_verified    tinyint(1)                          NOT NULL DEFAULT '0',
  email_key         varchar(50)       COLLATE utf8_bin  DEFAULT NULL,
  last_ip           varchar(40)       COLLATE utf8_bin  NOT NULL,
  last_login        datetime                            NOT NULL DEFAULT '0000-00-00 00:00:00',
  created           timestamp                           NOT NULL DEFAULT '0000-00-00 00:00:00',
  modified          timestamp         NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (user_id)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Table structure for table user_autologin
--

CREATE TABLE IF NOT EXISTS user_autologin (
  key_id            char(32)          COLLATE utf8_bin  NOT NULL,
  user_id           bigint unsigned                     NOT NULL DEFAULT '0',
  user_agent        varchar(150)      COLLATE utf8_bin  NOT NULL,
  last_ip           varchar(40)       COLLATE utf8_bin  NOT NULL,
  last_login        timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (key_id, user_id),
  FOREIGN KEY (user_id) REFERENCES user(user_id) ON UPDATE CASCADE ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Table structure for table user_profile
--

CREATE TABLE IF NOT EXISTS user_profile (
  user_id           bigint unsigned                     NOT NULL,
  disp_name         varchar(32)       COLLATE utf8_bin  NOT NULL,
  bio               text              COLLATE utf8_bin  DEFAULT NULL,
  profile_image_id  bigint unsigned                     DEFAULT NULL,
  cover_image_id    bigint unsigned                     DEFAULT NULL,
  PRIMARY KEY (user_id),
  FOREIGN KEY (user_id) REFERENCES user(user_id) ON UPDATE CASCADE ON DELETE CASCADE
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin;


-- --------------------------------------------------------

--
-- Table structure for table activity
--

CREATE TABLE IF NOT EXISTS activity (
  activity_id       bigint unsigned                     NOT NULL AUTO_INCREMENT,
  type              varchar(32)       COLLATE utf8_bin  NOT NULL, -- type = actor, people, collection, comment
  user_id           bigint unsigned                     NOT NULL,
  created           timestamp                           NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (activity_id),
  FOREIGN KEY (user_id)         REFERENCES user(user_id)          ON UPDATE CASCADE ON DELETE CASCADE
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Table structure for table notification
--

CREATE TABLE IF NOT EXISTS notification (
  activity_id       bigint unsigned                     NOT NULL,
  notif_user_id     bigint unsigned                     NOT NULL,
  seen_at           timestamp                           NOT NULL DEFAULT '0000-00-00 00:00:00',
  email_sent_at     timestamp                           NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (activity_id, user_id),
  FOREIGN KEY (activity_id) REFERENCES activity(activity_id) ON UPDATE CASCADE ON DELETE CASCADE,
  FOREIGN KEY (user_id)     REFERENCES user(user_id)               ON UPDATE CASCADE ON DELETE CASCADE
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Table structure for table people_graph
--

CREATE TABLE IF NOT EXISTS people_graph (
  activity_id       bigint unsigned                     NOT NULL UNIQUE,
  user_id           bigint unsigned                     NOT NULL,
  follow_user_id    bigint unsigned                     NOT NULL,
  created           timestamp                           NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (user_id, follow_user_id),
  FOREIGN KEY (activity_id)     REFERENCES activity(activity_id)  ON UPDATE CASCADE ON DELETE CASCADE,
  FOREIGN KEY (user_id)         REFERENCES user(user_id)          ON UPDATE CASCADE ON DELETE CASCADE,
  FOREIGN KEY (follow_user_id)  REFERENCES user(user_id)          ON UPDATE CASCADE ON DELETE CASCADE
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------
