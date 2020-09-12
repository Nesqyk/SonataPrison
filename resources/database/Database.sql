--#!sqlite
--# { p
--#   { query
--#     { generic
CREATE TABLE IF NOT EXISTS players WHERE
(
uuid VARCHAR(30) PRIMARY KEY NOT NULL,
username VARCHAR(20) NOT NULL,
mine VARCHAR(1) NULL 'a',
prestige INT NULL 0,
scoreboard INT NULL 1
);
--#     }
--#   }
--#   { insert
--#       :uuid string
--#   }
INSERT * FROM players WHERE uuid = :uuid;
--#   {
--#   } select
--#     :uuid string
SELECT * FROM players WHERE uuid = :uuid;
--#   }
--#   { update
UPDATE * FROM players WHERE uuid = :uuid;
--#   }
--# }