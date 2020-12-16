
DROP TABLE IF EXISTS userinfo;
DROP TABLE IF EXISTS filehash;
DROP TABLE IF EXISTS admininfo;

CREATE TABLE userinfo (
username	   VARCHAR(255) NOT NULL, 	
useremail   VARCHAR(255) NOT NULL,
usersalt    VARCHAR(255) NOT NULL,
Userpassword VARCHAR(255) NOT NULL,
PRIMARY KEY (username, useremail)
);

CREATE TABLE admininfo (
username   VARCHAR(255) NOT NULL, 	
useremail   VARCHAR(255) NOT NULL,
usersalt    VARCHAR(255) NOT NULL,
Userpassword VARCHAR(255) NOT NULL,
PRIMARY KEY (username, useremail)
);


CREATE TABLE filehash (
File BLOB NOT NULL,
Name VARCHAR(255) NOT NULL
);


