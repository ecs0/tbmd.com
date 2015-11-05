-- Schema script for tbmd

CREATE TABLE people (
  id INT PRIMARY KEY AUTO_INCREMENT NOT NULL,
  fname VARCHAR (50),
  lname VARCHAR (50),
  birthdate DATE,
  submit_date DATE NOT NULL,
  bio BLOB
  );

CREATE TABLE movie (
  id INT PRIMARY KEY AUTO_INCREMENT NOT NULL,
  director_id INT REFERENCES people(id),
  title VARCHAR(50),
  release_date DATE,
  submit_date DATE NOT NULL,
  image_link VARCHAR(50),
  synopsis BLOB
  );

CREATE TABLE actor (
  movie_id INT REFERENCES movie(id),
  people_id INT REFERENCES people(id)
);

CREATE TABLE users (
  id INT PRIMARY KEY AUTO_INCREMENT NOT NULL,
  email VARCHAR(50) UNIQUE,
  username VARCHAR(50),
  password VARCHAR(100),
  join_date DATE NOT NULL
);

CREATE TABLE reviews (
  id INT PRIMARY KEY AUTO_INCREMENT NOT NULL,
  user_id INT REFERENCES users(id),
  movie_id INT REFERENCES movie(id),
  submit_date DATE NOT NULL,
  rating INT NOT NULL,
  review_content BLOB
);

