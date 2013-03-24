CREATE TABLE address (id BIGINT UNSIGNED AUTO_INCREMENT, name VARCHAR(100) NOT NULL, surname VARCHAR(100), street VARCHAR(100) NOT NULL, postal_code VARCHAR(10) NOT NULL, city VARCHAR(100) NOT NULL, province VARCHAR(100) NOT NULL, country VARCHAR(100) NOT NULL, phone_number VARCHAR(15) NOT NULL, user_id BIGINT UNSIGNED NOT NULL, INDEX user_id_idx (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = INNODB;
CREATE TABLE category (id BIGINT UNSIGNED AUTO_INCREMENT, name VARCHAR(100) NOT NULL, description VARCHAR(255), parent_category_id BIGINT UNSIGNED, INDEX parent_category_id_idx (parent_category_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = INNODB;
CREATE TABLE log (id BIGINT UNSIGNED AUTO_INCREMENT, timestamp datetime NOT NULL, priority_name VARCHAR(10) NOT NULL, priority TINYINT UNSIGNED NOT NULL, message TEXT NOT NULL, identity VARCHAR(40) NOT NULL, ip_address VARCHAR(39), url VARCHAR(255) NOT NULL, stack_trace text, post text, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = INNODB;
CREATE TABLE notification (id BIGINT UNSIGNED AUTO_INCREMENT, related_object_id BIGINT NOT NULL, type VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = INNODB;
CREATE TABLE user (id BIGINT UNSIGNED AUTO_INCREMENT, login VARCHAR(100) NOT NULL, password CHAR(40) NOT NULL, salt SMALLINT UNSIGNED NOT NULL, secret_code CHAR(40), email VARCHAR(100) NOT NULL, active TINYINT(1) DEFAULT '0' NOT NULL, last_login DATETIME, role VARCHAR(255) DEFAULT 'user' NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, UNIQUE INDEX login_unique_idx (login), UNIQUE INDEX secret_code_unique_idx (secret_code), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = INNODB;
ALTER TABLE address ADD CONSTRAINT address_user_id_user_id FOREIGN KEY (user_id) REFERENCES user(id) ON DELETE CASCADE;
ALTER TABLE category ADD CONSTRAINT category_parent_category_id_category_id FOREIGN KEY (parent_category_id) REFERENCES category(id) ON DELETE RESTRICT;
