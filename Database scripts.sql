CREATE DATABASE TouristApp;

USE TouristApp;

CREATE TABLE users (
uid int(11) AUTO_INCREMENT PRIMARY KEY,
first_name varchar(20) NOT NULL,
last_name varchar(20) NOT NULL,
phone_number int(12) NOT NULL,
email varchar(30) NOT NULL,
username varchar(15) NOT NULL,
password_key varchar(30) NOT NULL,
usertype varchar(20)
);


CREATE TABLE stories (
  id INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(255) NOT NULL,
  email VARCHAR(255) NOT NULL,
  title VARCHAR(255) NOT NULL,
  story TEXT NOT NULL,
  location VARCHAR(255) NOT NULL,
  photo_path VARCHAR(255),
  video_path VARCHAR(255)
);
