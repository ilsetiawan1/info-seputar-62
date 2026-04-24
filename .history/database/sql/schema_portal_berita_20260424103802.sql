-- USERS
CREATE TABLE users (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255),
    email VARCHAR(255) UNIQUE,
    email_verified_at TIMESTAMP NULL,
    password VARCHAR(255),

    avatar VARCHAR(255) NULL,
    bio TEXT NULL,

    role ENUM('admin','editor','writer') DEFAULT 'writer',
    is_active BOOLEAN DEFAULT TRUE,

    remember_token VARCHAR(100) NULL,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL
) ENGINE=InnoDB;

-- CATEGORIES
CREATE TABLE categories (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255),
    slug VARCHAR(255) UNIQUE,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL
) ENGINE=InnoDB;

-- POSTS
CREATE TABLE posts (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,

    title VARCHAR(255),
    slug VARCHAR(255) UNIQUE,
    excerpt TEXT NULL,
    content LONGTEXT,

    thumbnail VARCHAR(255) NULL,

    category_id BIGINT UNSIGNED,
    author_id BIGINT UNSIGNED,

    status ENUM('draft','review','published','archived') DEFAULT 'draft',

    published_at TIMESTAMP NULL,
    is_featured BOOLEAN DEFAULT FALSE,

    views_count BIGINT UNSIGNED DEFAULT 0,

    meta_title VARCHAR(255) NULL,
    meta_description TEXT NULL,

    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,
    deleted_at TIMESTAMP NULL,

    INDEX idx_posts_status (status),
    INDEX idx_posts_category (category_id),
    INDEX idx_posts_published (published_at),

    CONSTRAINT fk_posts_category FOREIGN KEY (category_id)
        REFERENCES categories(id) ON DELETE CASCADE,

    CONSTRAINT fk_posts_author FOREIGN KEY (author_id)
        REFERENCES users(id) ON DELETE CASCADE
) ENGINE=InnoDB;

-- TAGS
CREATE TABLE tags (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255),
    slug VARCHAR(255) UNIQUE,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL
) ENGINE=InnoDB;

-- POST_TAG (PIVOT)
CREATE TABLE post_tag (
    post_id BIGINT UNSIGNED,
    tag_id BIGINT UNSIGNED,

    PRIMARY KEY (post_id, tag_id),

    CONSTRAINT fk_post_tag_post FOREIGN KEY (post_id)
        REFERENCES posts(id) ON DELETE CASCADE,

    CONSTRAINT fk_post_tag_tag FOREIGN KEY (tag_id)
        REFERENCES tags(id) ON DELETE CASCADE
) ENGINE=InnoDB;

-- COMMENTS
CREATE TABLE comments (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,

    post_id BIGINT UNSIGNED,
    user_id BIGINT UNSIGNED NULL,
    parent_id BIGINT UNSIGNED NULL,

    content TEXT,

    status ENUM('pending','approved','rejected') DEFAULT 'pending',

    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,

    INDEX idx_comments_post (post_id),

    CONSTRAINT fk_comments_post FOREIGN KEY (post_id)
        REFERENCES posts(id) ON DELETE CASCADE,

    CONSTRAINT fk_comments_user FOREIGN KEY (user_id)
        REFERENCES users(id) ON DELETE SET NULL,

    CONSTRAINT fk_comments_parent FOREIGN KEY (parent_id)
        REFERENCES comments(id) ON DELETE CASCADE
) ENGINE=InnoDB;

-- POST VIEWS
CREATE TABLE post_views (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,

    post_id BIGINT UNSIGNED,
    user_id BIGINT UNSIGNED NULL,

    ip_address VARCHAR(45) NULL,
    user_agent TEXT NULL,

    created_at TIMESTAMP NULL,

    INDEX idx_post_views_post (post_id),
    INDEX idx_post_views_date (created_at),

    CONSTRAINT fk_post_views_post FOREIGN KEY (post_id)
        REFERENCES posts(id) ON DELETE CASCADE,

    CONSTRAINT fk_post_views_user FOREIGN KEY (user_id)
        REFERENCES users(id) ON DELETE SET NULL
) ENGINE=InnoDB;

-- MEDIA
CREATE TABLE media (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,

    file_path VARCHAR(255),
    file_type VARCHAR(50) NULL,
    alt_text VARCHAR(255) NULL,

    uploaded_by BIGINT UNSIGNED,

    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,

    CONSTRAINT fk_media_user FOREIGN KEY (uploaded_by)
        REFERENCES users(id) ON DELETE CASCADE
) ENGINE=InnoDB;
