CREATE DATABASE TouristApp;

USE TouristApp;

CREATE TABLE users (
uid int(11) AUTO_INCREMENT PRIMARY KEY,
first_name varchar(20),
last_name varchar(20),
phone_number int(12),
email varchar(30),
username varchar(15),
password_key varchar(30),
usertype varchar(20)
);