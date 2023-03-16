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
  source_name VARCHAR(255) NOT NULL,
  story_title VARCHAR(255) NOT NULL,
  category VARCHAR(15) NOT NULL,
  description TEXT NOT NULL,
  location VARCHAR(255),
  latitude DECIMAL(10, 8) NOT NULL,
  longitude DECIMAL(10, 8) NOT NULL,
  picture_data BLOB,
  video_data BLOB,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE ratings (
  id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  story_id INT(11) UNSIGNED NOT NULL,
  username varchar(15) NOT NULL,
  rating INT(11) UNSIGNED NOT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);



CREATE TABLE removed_stories (
  id INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  source_name VARCHAR(255) NOT NULL,
  story_title VARCHAR(255) NOT NULL,
  category VARCHAR(15) NOT NULL,
  description TEXT NOT NULL,
  location VARCHAR(255),
  latitude DECIMAL(10, 8) NOT NULL,
  longitude DECIMAL(10, 8) NOT NULL,
  picture_data BLOB,
  video_data BLOB,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);