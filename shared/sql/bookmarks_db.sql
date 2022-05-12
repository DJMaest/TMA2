

CREATE TABLE `bookmarks` (
  `used_count` int(11) NOT NULL,
  `url` varchar(450) NOT NULL,
  PRIMARY KEY (`url`)
);


CREATE TABLE `users` (
  `username` varchar(45) NOT NULL,
  `password` varchar(45) NOT NULL,
  PRIMARY KEY (`username`)
);

CREATE TABLE `user_bookmarks` (
  `username` varchar(45) NOT NULL,
  `bookmark_url` varchar(450) NOT NULL,
  `title` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`username`,`bookmark_url`),
  FOREIGN KEY (`username`) REFERENCES 
  `users` (`username`)
  ON UPDATE CASCADE
  ON DELETE CASCADE
);
