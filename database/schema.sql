-- Schema script for tbmd

-- Remove anything already existing for a clean slate
GRANT USAGE ON *.* TO 'tbmd'@'localhost';
DROP USER 'tbmd'@'localhost';
DROP DATABASE IF EXISTS tbmd;

-- create our database and user
CREATE DATABASE tbmd;
CREATE USER 'tbmd'@'localhost' IDENTIFIED BY 'tbmd';
GRANT ALL PRIVILEGES ON tbmd.* TO 'tbmd'@'localhost';
FLUSH PRIVILEGES;

USE tbmd;

-- create tables
CREATE TABLE people (
  id INT PRIMARY KEY AUTO_INCREMENT NOT NULL,
  fname VARCHAR (50),
  lname VARCHAR (50),
  birthdate DATE,
  image_link VARCHAR(50),
  submit_date DATE NOT NULL,
  bio BLOB
);

CREATE TABLE movie (
  id INT PRIMARY KEY AUTO_INCREMENT NOT NULL,
  director_id INT,
  title VARCHAR(50),
  release_date DATE,
  submit_date DATE NOT NULL,
  image_link VARCHAR(50),
  synopsis BLOB,
  FOREIGN KEY (director_id) REFERENCES people(id)
);

CREATE TABLE actor (
  movie_id INT,
  people_id INT,
  FOREIGN KEY (movie_id) REFERENCES movie(id),
  FOREIGN KEY (people_id) REFERENCES people(id)
);

CREATE TABLE users (
  id INT PRIMARY KEY AUTO_INCREMENT NOT NULL,
  email VARCHAR(50) UNIQUE,
  username VARCHAR(50) NOT NULL,
  password VARCHAR(100) NOT NULL,
  join_date DATE NOT NULL
);

CREATE TABLE reviews (
  id INT PRIMARY KEY AUTO_INCREMENT NOT NULL,
  user_id INT,
  movie_id INT,
  submit_date DATE NOT NULL,
  rating INT NOT NULL,
  review_content BLOB,
  FOREIGN KEY (user_id) REFERENCES users(id),
  FOREIGN KEY (movie_id) REFERENCES movie(id)
);

