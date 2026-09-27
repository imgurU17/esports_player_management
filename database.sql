CREATE DATABASE IF NOT EXISTS esports_manager;

USE esports_manager;

CREATE TABLE admins (
    admin_id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL
);

CREATE TABLE teams (
    team_id INT AUTO_INCREMENT PRIMARY KEY,
    team_name VARCHAR(100) NOT NULL,
    game VARCHAR(50) NOT NULL,
    manager_name VARCHAR(100) NOT NULL
);

CREATE TABLE players (
    player_id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    username VARCHAR(100) NOT NULL,
    game VARCHAR(50) NOT NULL,
    age INT NOT NULL,
    skill_level VARCHAR(50) NOT NULL,
    team_id INT NULL,

    FOREIGN KEY (team_id)
    REFERENCES teams(team_id)
    ON DELETE SET NULL
);

CREATE TABLE tournaments (
    tournament_id INT AUTO_INCREMENT PRIMARY KEY,
    tournament_name VARCHAR(150) NOT NULL,
    game VARCHAR(50) NOT NULL,
    tournament_date DATE NOT NULL,
    status VARCHAR(50) NOT NULL
);

CREATE TABLE performance (
    performance_id INT AUTO_INCREMENT PRIMARY KEY,
    player_id INT NOT NULL,
    matches_played INT DEFAULT 0,
    wins INT DEFAULT 0,
    losses INT DEFAULT 0,
    points INT DEFAULT 0,
    kills INT DEFAULT 0,
    assists INT DEFAULT 0,

    FOREIGN KEY (player_id)
    REFERENCES players(player_id)
    ON DELETE CASCADE
);

INSERT INTO admins (username, password)
VALUES ('admin', SHA2('admin123',256));

INSERT INTO teams
(team_name, game, manager_name)
VALUES
('Team Titans','BGMI','Rahul'),
('Nova Esports','Valorant','Amit'),
('Phoenix Gaming','Free Fire','Arjun');

INSERT INTO players
(name, username, game, age, skill_level, team_id)
VALUES
('Shadow X','ShadowX','BGMI',20,'Expert',1),
('Ace Pro','AcePro','Valorant',21,'Advanced',2),
('Blaze','Blaze','Free Fire',19,'Intermediate',3);

INSERT INTO tournaments
(tournament_name, game, tournament_date, status)
VALUES
('India Gaming Cup','BGMI','2026-10-15','Upcoming'),
('Valorant College Cup','Valorant','2026-11-05','Upcoming');

INSERT INTO performance
(player_id,matches_played,wins,losses,points,kills,assists)
VALUES
(1,15,12,3,120,85,40),
(2,10,8,2,80,65,30),
(3,12,7,5,70,55,20);

CREATE TABLE ratings (
    rating_id INT AUTO_INCREMENT PRIMARY KEY,
    user_name VARCHAR(100) NOT NULL,
    rating INT NOT NULL,
    feedback TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);