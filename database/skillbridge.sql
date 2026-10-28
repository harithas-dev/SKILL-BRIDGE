CREATE DATABASE IF NOT EXISTS skillbridge
    CHARACTER SET utf8mb4
    COLLATE utf8mb4_unicode_ci;

USE skillbridge;

CREATE TABLE users (
    user_id INT AUTO_INCREMENT PRIMARY KEY,
    first_name VARCHAR(50) NOT NULL,
    last_name VARCHAR(50) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    phone VARCHAR(20),
    location VARCHAR(100),
    bio VARCHAR(500),
    profile_image VARCHAR(255),
    role ENUM('user', 'admin') NOT NULL DEFAULT 'user',
    account_status ENUM('active', 'disabled') NOT NULL DEFAULT 'active',
    created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

CREATE TABLE skill_categories (
    category_id INT AUTO_INCREMENT PRIMARY KEY,
    category_name VARCHAR(100) NOT NULL UNIQUE
) ENGINE=InnoDB;

CREATE TABLE skills (
    skill_id INT AUTO_INCREMENT PRIMARY KEY,
    category_id INT NOT NULL,
    skill_name VARCHAR(100) NOT NULL,
    CONSTRAINT uq_skill_category_name UNIQUE (category_id, skill_name),
    CONSTRAINT fk_skills_category
        FOREIGN KEY (category_id) REFERENCES skill_categories(category_id)
        ON UPDATE CASCADE
        ON DELETE RESTRICT
) ENGINE=InnoDB;

CREATE TABLE teaching_skills (
    teaching_skill_id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    skill_id INT NOT NULL,
    experience_level ENUM('Beginner', 'Intermediate', 'Advanced', 'Expert') NOT NULL,
    years_experience INT,
    description VARCHAR(500) NOT NULL,
    hourly_rate DECIMAL(10, 2) NOT NULL,
    created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT uq_user_teaching_skill UNIQUE (user_id, skill_id),
    CONSTRAINT fk_teaching_skills_user
        FOREIGN KEY (user_id) REFERENCES users(user_id)
        ON UPDATE CASCADE
        ON DELETE CASCADE,
    CONSTRAINT fk_teaching_skills_skill
        FOREIGN KEY (skill_id) REFERENCES skills(skill_id)
        ON UPDATE CASCADE
        ON DELETE RESTRICT
) ENGINE=InnoDB;

CREATE TABLE learning_requests (
    request_id INT AUTO_INCREMENT PRIMARY KEY,
    learner_id INT NOT NULL,
    teacher_id INT NOT NULL,
    teaching_skill_id INT NOT NULL,
    message VARCHAR(500) NOT NULL,
    status ENUM('Pending', 'Accepted', 'Rejected') NOT NULL DEFAULT 'Pending',
    request_date DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    accepted_date DATETIME,
    CONSTRAINT fk_learning_requests_learner
        FOREIGN KEY (learner_id) REFERENCES users(user_id)
        ON UPDATE CASCADE
        ON DELETE CASCADE,
    CONSTRAINT fk_learning_requests_teacher
        FOREIGN KEY (teacher_id) REFERENCES users(user_id)
        ON UPDATE CASCADE
        ON DELETE CASCADE,
    CONSTRAINT fk_learning_requests_teaching_skill
        FOREIGN KEY (teaching_skill_id) REFERENCES teaching_skills(teaching_skill_id)
        ON UPDATE CASCADE
        ON DELETE CASCADE
) ENGINE=InnoDB;

CREATE TABLE notifications (
    notification_id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    message VARCHAR(255) NOT NULL,
    is_read BOOLEAN NOT NULL DEFAULT FALSE,
    created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT fk_notifications_user
        FOREIGN KEY (user_id) REFERENCES users(user_id)
        ON UPDATE CASCADE
        ON DELETE CASCADE
) ENGINE=InnoDB;
