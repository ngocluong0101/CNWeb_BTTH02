-- Tạo database
CREATE DATABASE onlinecourse;
USE onlinecourse;

-- Bảng users
CREATE TABLE users (
    id INT PRIMARY KEY AUTO_INCREMENT,
    username VARCHAR(255) UNIQUE NOT NULL,
    email VARCHAR(255) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    fullname VARCHAR(255),
    role INT NOT NULL DEFAULT 0, -- 0: student, 1: instructor, 2: admin
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP
);

-- Bảng categories
CREATE TABLE categories (
    id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(255) NOT NULL,
    description TEXT,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP
);

-- Bảng courses
CREATE TABLE courses (
    id INT PRIMARY KEY AUTO_INCREMENT,
    title VARCHAR(255) NOT NULL,
    description TEXT,
    instructor_id INT,
    category_id INT,
    price DECIMAL(10,2) DEFAULT 0,
    duration_weeks INT,
    level VARCHAR(50),
    image VARCHAR(255),
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,

    FOREIGN KEY (instructor_id) REFERENCES users(id),
    FOREIGN KEY (category_id) REFERENCES categories(id)
);

-- Bảng enrollments
CREATE TABLE enrollments (
    id INT PRIMARY KEY AUTO_INCREMENT,
    course_id INT NOT NULL,
    student_id INT NOT NULL,
    enrolled_date DATETIME DEFAULT CURRENT_TIMESTAMP,
    status VARCHAR(50) DEFAULT 'active',
    progress INT DEFAULT 0,

    FOREIGN KEY (course_id) REFERENCES courses(id),
    FOREIGN KEY (student_id) REFERENCES users(id)
);

-- Bảng lessons
CREATE TABLE lessons (
    id INT PRIMARY KEY AUTO_INCREMENT,
    course_id INT NOT NULL,
    title VARCHAR(255),
    content LONGTEXT,
    video_url VARCHAR(255),
    order_num INT NOT NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,

    FOREIGN KEY (course_id) REFERENCES courses(id)
);

-- Bảng materials
CREATE TABLE materials (
    id INT PRIMARY KEY AUTO_INCREMENT,
    lesson_id INT NOT NULL,
    filename VARCHAR(255),
    file_path VARCHAR(255),
    file_type VARCHAR(50),
    uploaded_at DATETIME DEFAULT CURRENT_TIMESTAMP,

    FOREIGN KEY (lesson_id) REFERENCES lessons(id)
);


INSERT INTO users (username, email, password, fullname, role)
VALUES
('admin', 'admin@example.com', '123456', 'Administrator', 2),
('teacher1', 'teacher1@example.com', '123456', 'Nguyen Van A', 1),
('student1', 'student1@example.com', '123456', 'Tran Thi B', 0),
('student2', 'student2@example.com', '123456', 'Le Van C', 0);



INSERT INTO categories (name, description)
VALUES
('Web Development', 'Learn how to build modern websites'),
('Data Science', 'Courses about data processing, ML, AI'),
('Mobile Development', 'Android + iOS application development'),
('Business', 'Courses for marketing, management and strategy');



INSERT INTO courses (title, description, instructor_id, category_id, price, duration_weeks, level, image)
VALUES
('PHP Web Development', 'Learn fundamental to advanced PHP for web apps.', 2, 1, 199.00, 6, 'Beginner', 'php.jpg'),
('Machine Learning Basics', 'Introduction to ML: regression, classification, models.', 2, 2, 299.00, 8, 'Intermediate', 'ml.jpg'),
('Android Apps with Java', 'Build Android mobile apps using Java.', 2, 3, 249.00, 10, 'Beginner', 'android.jpg');



INSERT INTO lessons (course_id, title, content, video_url, order_num)
VALUES
-- Lessons cho PHP course
(1, 'Giới thiệu PHP', 'Tổng quan về PHP và môi trường phát triển.', 'video1.mp4', 1),
(1, 'Biến và Kiểu dữ liệu', 'Hiểu về biến, kiểu dữ liệu, ép kiểu.', 'video2.mp4', 2),
(1, 'Lập trình hướng đối tượng', 'OOP trong PHP: class, object, kế thừa.', 'video3.mp4', 3),

-- Lessons cho ML course
(2, 'Giới thiệu Machine Learning', 'Khái niệm ML, supervised vs unsupervised.', 'ml_intro.mp4', 1),
(2, 'Linear Regression', 'Học mô hình hồi quy tuyến tính.', 'ml_lr.mp4', 2),

-- Lessons cho Android course
(3, 'Giới thiệu Android Studio', 'Cài đặt và sử dụng Android Studio.', 'android1.mp4', 1),
(3, 'Activity và Layout', 'Hiểu về Activity, XML Layout.', 'android2.mp4', 2);



INSERT INTO materials (lesson_id, filename, file_path, file_type)
VALUES
(1, 'php_intro.pdf', 'uploads/materials/php_intro.pdf', 'pdf'),
(2, 'php_variables.docx', 'uploads/materials/php_variables.docx', 'docx'),
(4, 'ml_overview.pdf', 'uploads/materials/ml_overview.pdf', 'pdf'),
(6, 'android_setup.pdf', 'uploads/materials/android_setup.pdf', 'pdf');



INSERT INTO enrollments (course_id, student_id, status, progress)
VALUES
(1, 3, 'active', 20),   -- student1 học PHP
(1, 4, 'active', 0),    -- student2 học PHP
(2, 3, 'completed', 100), -- student1 học ML
(3, 4, 'active', 10);    -- student2 học Android


ALTER TABLE users ADD status TINYINT DEFAULT 1;
