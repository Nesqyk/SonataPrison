--#!sqlite
--# { p
--#  { query
--#    { generic
CREATE TABLE IF NOT EXISTS Players (
uuid VARCHAR(36) PRIMARY KEY NOT NULL ,
uname VARCHAR(15) NOT NULL,
mine INT DEFAULT 1,
prestige INT  DEFAULT 0,
money INT DEFAULT 0,
scoreboard INT DEFAULT 1
);
--#    }
--#    { insert
INSERT FROM Players WHERE (uuid,uname) VALUES (uuid,uname)
--#    }
--#  }
--# }