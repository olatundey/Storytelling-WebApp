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