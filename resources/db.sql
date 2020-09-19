-- #! sqlite
-- # { p
-- #  { query
-- #   { generic
CREATE TABLE IF NOT EXISTS Chopin(
c_uuid VARCHAR(36) NOT NULL,
c_username VARCHAR(20) NOT NULL,
c_mine TINYINT DEFAULT 1,
c_prestige INT DEFAULT 0,
c_rank TINYINT DEFAULT 0,
c_money INT DEFAULT 0,
c_scoreboard INT DEFAULT 0,
c_multiplier INT DEFAULT 0.0,
PRIMARY KEY (c_uuid)
);
-- #   }
-- #   { insert
INSERT INTO Chopin (c_uuid_c_username) VALUES (c_uuid,c_username);
-- #   }
-- #   { update
UPDATE Chopin(c_username) SET (c_mine,c_prestige,c_rank,c_money,c_scoreboard,c_booster) VALUES (c_mine,c_prestige,c_rank,c_money,c_scoreboard,c_multiplier)
-- #   }
-- #  }
-- # }