CREATE DATABASE student_system;
USE student_system;

CREATE TABLE students (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    course VARCHAR(100) NOT NULL,
    grade VARCHAR(10) NOT NULL,
    image VARCHAR(255)
);

CREATE TABLE courses (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL
);

INSERT INTO courses (name) VALUES 
('برمجة الويب'),
('قواعد البيانات'),
('هياكل البيانات'),
('الذكاء الاصطناعي');