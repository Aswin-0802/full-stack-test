CREATE DATABASE IF NOT EXISTS wpoets_test CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

USE wpoets_test;

CREATE TABLE IF NOT EXISTS categories (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    icon VARCHAR(255) NOT NULL DEFAULT '',
    sort_order INT NOT NULL DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS slides (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    category_id INT UNSIGNED NOT NULL,
    title VARCHAR(200) NOT NULL,
    description TEXT NOT NULL,
    image VARCHAR(255) NOT NULL DEFAULT '',
    sort_order INT NOT NULL DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    CONSTRAINT fk_slides_category
        FOREIGN KEY (category_id) REFERENCES categories(id)
        ON DELETE CASCADE
) ENGINE=InnoDB;

INSERT INTO categories (name, icon, sort_order) VALUES
('Technology', 'files/images/DL-technology.svg', 1),
('Communication', 'files/images/DL-communication.svg', 2),
('Learning', 'files/images/DL-learning.svg', 3);

INSERT INTO slides (category_id, title, description, image, sort_order) VALUES
(1, 'Cloud Infrastructure', 'Build scalable cloud solutions that grow with your business needs and keep your data secure.', 'files/images/slides/technology-1.jpg', 1),
(1, 'Modern Development', 'Leverage cutting-edge frameworks and tools to deliver robust, maintainable applications.', 'files/images/slides/technology-2.jpg', 2),
(1, 'Data & Analytics', 'Transform raw data into actionable insights that drive smarter business decisions.', 'files/images/slides/technology-3.jpg', 3),
(2, 'Brand Messaging', 'Craft compelling narratives that resonate with your audience and strengthen your brand identity.', 'files/images/slides/communication-1.jpg', 1),
(2, 'Digital Campaigns', 'Reach your target audience through strategic multi-channel digital marketing campaigns.', 'files/images/slides/communication-2.jpg', 2),
(2, 'Social Engagement', 'Build meaningful connections with your community across social media platforms.', 'files/images/slides/communication-3.jpg', 3),
(3, 'Workshop Training', 'Hands-on workshops designed to upskill your team with practical, real-world knowledge.', 'files/images/slides/learning-1.jpg', 1),
(3, 'Online Courses', 'Flexible e-learning modules that let your team learn at their own pace, anywhere.', 'files/images/slides/learning-2.jpg', 2),
(3, 'Knowledge Sharing', 'Foster a culture of continuous learning through collaborative knowledge-sharing sessions.', 'files/images/slides/learning-3.jpg', 3);
