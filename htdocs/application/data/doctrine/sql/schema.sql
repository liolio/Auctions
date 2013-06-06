CREATE TABLE address (id BIGINT UNSIGNED AUTO_INCREMENT, name VARCHAR(100) NOT NULL, surname VARCHAR(100), street VARCHAR(100) NOT NULL, postal_code VARCHAR(10) NOT NULL, city VARCHAR(100) NOT NULL, province VARCHAR(100) NOT NULL, country VARCHAR(100) NOT NULL, phone_number VARCHAR(15) NOT NULL, user_id BIGINT UNSIGNED NOT NULL, INDEX user_id_idx (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = INNODB;
CREATE TABLE attachment (id BIGINT UNSIGNED AUTO_INCREMENT, auction_id BIGINT UNSIGNED NOT NULL, file_id BIGINT UNSIGNED NOT NULL, UNIQUE INDEX attachment_unique_idx (auction_id, file_id), INDEX auction_id_idx (auction_id), INDEX file_id_idx (file_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = INNODB;
CREATE TABLE auction (id BIGINT UNSIGNED AUTO_INCREMENT, title VARCHAR(100) NOT NULL, description TEXT NOT NULL, number_of_items BIGINT UNSIGNED NOT NULL, start_time DATETIME NOT NULL, duration VARCHAR(255) DEFAULT '7' NOT NULL, user_id BIGINT UNSIGNED NOT NULL, category_id BIGINT UNSIGNED NOT NULL, currency_id BIGINT UNSIGNED NOT NULL, thumbnail_file_id BIGINT UNSIGNED, stage VARCHAR(255) DEFAULT 'active' NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, INDEX user_id_idx (user_id), INDEX category_id_idx (category_id), INDEX currency_id_idx (currency_id), INDEX thumbnail_file_id_idx (thumbnail_file_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = INNODB;
CREATE TABLE auction_transaction_type (id BIGINT UNSIGNED AUTO_INCREMENT, auction_id BIGINT UNSIGNED NOT NULL, transaction_type_id BIGINT UNSIGNED NOT NULL, price DECIMAL(15, 2) NOT NULL, INDEX transaction_type_id_idx (transaction_type_id), INDEX auction_id_idx (auction_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = INNODB;
CREATE TABLE banking_information (id BIGINT UNSIGNED AUTO_INCREMENT, bank_name VARCHAR(100) NOT NULL, account_number VARCHAR(100) NOT NULL, currency_id BIGINT UNSIGNED NOT NULL, user_id BIGINT UNSIGNED NOT NULL, INDEX user_id_idx (user_id), INDEX currency_id_idx (currency_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = INNODB;
CREATE TABLE category (id BIGINT UNSIGNED AUTO_INCREMENT, name VARCHAR(100) NOT NULL, description VARCHAR(255), parent_category_id BIGINT UNSIGNED, INDEX parent_category_id_idx (parent_category_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = INNODB;
CREATE TABLE currency (id BIGINT UNSIGNED AUTO_INCREMENT, name VARCHAR(100) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = INNODB;
CREATE TABLE delivery (id BIGINT UNSIGNED AUTO_INCREMENT, auction_id BIGINT UNSIGNED NOT NULL, delivery_type_id BIGINT UNSIGNED NOT NULL, price DECIMAL(15, 2) NOT NULL, INDEX auction_id_idx (auction_id), INDEX delivery_type_id_idx (delivery_type_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = INNODB;
CREATE TABLE delivery_form (id BIGINT UNSIGNED AUTO_INCREMENT, comment TEXT, stage VARCHAR(255) DEFAULT 'to_fill' NOT NULL, transaction_id BIGINT UNSIGNED NOT NULL, address_id BIGINT UNSIGNED, delivery_id BIGINT UNSIGNED, INDEX transaction_id_idx (transaction_id), INDEX address_id_idx (address_id), INDEX delivery_id_idx (delivery_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = INNODB;
CREATE TABLE delivery_type (id BIGINT UNSIGNED AUTO_INCREMENT, name VARCHAR(100) NOT NULL, cash_on_delivery TINYINT(1) NOT NULL, UNIQUE INDEX delivery_type_unique_idx (name, cash_on_delivery), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = INNODB;
CREATE TABLE file (id BIGINT UNSIGNED AUTO_INCREMENT, filename VARCHAR(255) NOT NULL, original_filename VARCHAR(255) NOT NULL, mime_type VARCHAR(25) NOT NULL, size VARCHAR(45) NOT NULL, user_id BIGINT UNSIGNED NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, INDEX user_id_idx (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = INNODB;
CREATE TABLE log (id BIGINT UNSIGNED AUTO_INCREMENT, timestamp datetime NOT NULL, priority_name VARCHAR(10) NOT NULL, priority TINYINT UNSIGNED NOT NULL, message TEXT NOT NULL, identity VARCHAR(40) NOT NULL, ip_address VARCHAR(39), url VARCHAR(255) NOT NULL, stack_trace text, post text, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = INNODB;
CREATE TABLE notification (id BIGINT UNSIGNED AUTO_INCREMENT, related_object_id BIGINT NOT NULL, type VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = INNODB;
CREATE TABLE transaction (id BIGINT UNSIGNED AUTO_INCREMENT, user_id BIGINT UNSIGNED NOT NULL, auction_transaction_type_id BIGINT UNSIGNED NOT NULL, price DECIMAL(15, 2) NOT NULL, number_of_items BIGINT UNSIGNED NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, INDEX user_id_idx (user_id), INDEX auction_transaction_type_id_idx (auction_transaction_type_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = INNODB;
CREATE TABLE transaction_type (id BIGINT UNSIGNED AUTO_INCREMENT, name VARCHAR(100) NOT NULL UNIQUE, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = INNODB;
CREATE TABLE user (id BIGINT UNSIGNED AUTO_INCREMENT, login VARCHAR(100) NOT NULL, password CHAR(40) NOT NULL, salt SMALLINT UNSIGNED NOT NULL, secret_code CHAR(40), email VARCHAR(100) NOT NULL, active TINYINT(1) DEFAULT '0' NOT NULL, last_login DATETIME, role VARCHAR(255) DEFAULT 'user' NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, UNIQUE INDEX login_unique_idx (login), UNIQUE INDEX secret_code_unique_idx (secret_code), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = INNODB;
ALTER TABLE address ADD CONSTRAINT address_user_id_user_id FOREIGN KEY (user_id) REFERENCES user(id) ON DELETE CASCADE;
ALTER TABLE attachment ADD CONSTRAINT attachment_file_id_file_id FOREIGN KEY (file_id) REFERENCES file(id) ON DELETE RESTRICT;
ALTER TABLE attachment ADD CONSTRAINT attachment_auction_id_auction_id FOREIGN KEY (auction_id) REFERENCES auction(id) ON DELETE CASCADE;
ALTER TABLE auction ADD CONSTRAINT auction_user_id_user_id FOREIGN KEY (user_id) REFERENCES user(id) ON DELETE CASCADE;
ALTER TABLE auction ADD CONSTRAINT auction_thumbnail_file_id_file_id FOREIGN KEY (thumbnail_file_id) REFERENCES file(id) ON DELETE RESTRICT;
ALTER TABLE auction ADD CONSTRAINT auction_currency_id_currency_id FOREIGN KEY (currency_id) REFERENCES currency(id) ON DELETE RESTRICT;
ALTER TABLE auction ADD CONSTRAINT auction_category_id_category_id FOREIGN KEY (category_id) REFERENCES category(id) ON DELETE RESTRICT;
ALTER TABLE auction_transaction_type ADD CONSTRAINT auction_transaction_type_transaction_type_id_transaction_type_id FOREIGN KEY (transaction_type_id) REFERENCES transaction_type(id) ON DELETE RESTRICT;
ALTER TABLE auction_transaction_type ADD CONSTRAINT auction_transaction_type_auction_id_auction_id FOREIGN KEY (auction_id) REFERENCES auction(id) ON DELETE CASCADE;
ALTER TABLE banking_information ADD CONSTRAINT banking_information_user_id_user_id FOREIGN KEY (user_id) REFERENCES user(id) ON DELETE CASCADE;
ALTER TABLE banking_information ADD CONSTRAINT banking_information_currency_id_currency_id FOREIGN KEY (currency_id) REFERENCES currency(id) ON DELETE RESTRICT;
ALTER TABLE category ADD CONSTRAINT category_parent_category_id_category_id FOREIGN KEY (parent_category_id) REFERENCES category(id) ON DELETE RESTRICT;
ALTER TABLE delivery ADD CONSTRAINT delivery_delivery_type_id_delivery_type_id FOREIGN KEY (delivery_type_id) REFERENCES delivery_type(id) ON DELETE RESTRICT;
ALTER TABLE delivery ADD CONSTRAINT delivery_auction_id_auction_id FOREIGN KEY (auction_id) REFERENCES auction(id) ON DELETE CASCADE;
ALTER TABLE delivery_form ADD CONSTRAINT delivery_form_transaction_id_transaction_id FOREIGN KEY (transaction_id) REFERENCES transaction(id) ON DELETE RESTRICT;
ALTER TABLE delivery_form ADD CONSTRAINT delivery_form_delivery_id_delivery_id FOREIGN KEY (delivery_id) REFERENCES delivery(id) ON DELETE RESTRICT;
ALTER TABLE delivery_form ADD CONSTRAINT delivery_form_address_id_address_id FOREIGN KEY (address_id) REFERENCES address(id) ON DELETE SET NULL;
ALTER TABLE file ADD CONSTRAINT file_user_id_user_id FOREIGN KEY (user_id) REFERENCES user(id) ON DELETE CASCADE;
ALTER TABLE transaction ADD CONSTRAINT transaction_user_id_user_id FOREIGN KEY (user_id) REFERENCES user(id) ON DELETE CASCADE;
ALTER TABLE transaction ADD CONSTRAINT taai FOREIGN KEY (auction_transaction_type_id) REFERENCES auction_transaction_type(id) ON DELETE CASCADE;
