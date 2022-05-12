DROP TABLE IF EXISTS Users;
CREATE TABLE `Users` (
  `username` varchar(45) NOT NULL,
  `password` varchar(45) NOT NULL,
  PRIMARY KEY (`username`)
);


DROP TABLE IF EXISTS Units;
CREATE TABLE Units
(
	unit_id int NOT NULL AUTO_INCREMENT PRIMARY KEY,
	unit_name varchar(255) not NULL,
	unit_intro text
);

DROP TABLE IF EXISTS Topics;
CREATE TABLE Topics
(
	topic_id int NOT NULL AUTO_INCREMENT PRIMARY KEY,
	topic_name varchar(255) NOT NULL,
	topic_intro text,
	unit_id  int NOT NULL,
	FOREIGN KEY (unit_id) REFERENCES Units(unit_id) ON DELETE CASCADE
);

DROP TABLE IF EXISTS SubTopics;
CREATE TABLE SubTopics
(
	subtopic_id int NOT NULL AUTO_INCREMENT PRIMARY KEY,
	subtopic_name varchar(255) NOT NULL,
	content text,
	topic_id int NOT NULL,
	FOREIGN KEY (topic_id) REFERENCES Topics(topic_id) ON DELETE CASCADE
);
DROP TABLE IF EXISTS Quizzes;
CREATE TABLE Quizzes
(
	quiz_id int NOT NULL AUTO_INCREMENT PRIMARY KEY,
	quiz_title varchar(255) NOT NULL,
	unit_id int NOT NULL,
	FOREIGN KEY (unit_id) REFERENCES Units(unit_id) ON DELETE CASCADE
);

DROP TABLE IF EXISTS Questions;
CREATE TABLE Questions
(
	question_id int NOT NULL AUTO_INCREMENT PRIMARY KEY,
	content text NOT NULL,
	quiz_id int NOT NULL,
	FOREIGN KEY (quiz_id) REFERENCES Quizzes(quiz_id) ON DELETE CASCADE
);

DROP TABLE IF EXISTS Answers;
CREATE TABLE Answers
(
	answer_id int NOT NULL AUTO_INCREMENT PRIMARY KEY,
	content text NOT NULL,
	iscorrect BOOLEAN NOT NULL,
	question_id int NOT NULL,
	FOREIGN KEY (question_id) REFERENCES Questions(question_id) ON DELETE CASCADE
);

DROP TABLE IF EXISTS Enrollments;
CREATE TABLE Enrollments
(
	unit_id int NOT NULL,
	username varchar(45) NOT NULL,
    PRIMARY KEY (unit_id, username),
	FOREIGN KEY (unit_id) REFERENCES Units(unit_id) ON DELETE CASCADE,
    FOREIGN KEY (username) REFERENCES Users(username) ON DELETE CASCADE ON UPDATE CASCADE
);

DROP TABLE IF EXISTS Summaries;
CREATE TABLE Summaries
(
	content text,
	unit_id  int NOT NULL PRIMARY KEY,
	FOREIGN KEY (unit_id) REFERENCES Units(unit_id) ON DELETE CASCADE
);
