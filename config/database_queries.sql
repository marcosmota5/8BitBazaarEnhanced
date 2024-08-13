/* Database creation part. For the cloud server, comment the drop and create parts */

-- Drop the database if it exists
DROP DATABASE IF EXISTS db_8bitbazzar;

-- Create the database
CREATE DATABASE db_8bitbazzar;

-- Use the database
USE db_8bitbazzar;

/* Tables creation */

-- Users table
CREATE TABLE tb_users (
	id INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    first_name VARCHAR(30) NOT NULL,
    last_name VARCHAR(30) NOT NULL,
    sex ENUM('M', 'F', 'N') NOT NULL,
    email VARCHAR(50) NOT NULL UNIQUE,
	password_hash BINARY(64) NOT NULL,
    salt CHAR(36) NOT NULL,
    register_date DATETIME NOT NULL,
    phone_number VARCHAR(20),
    picture_path VARCHAR(1024),
    birth_date DATE NOT NULL,
	address_line_1 VARCHAR(100) NOT NULL,
    address_line_2 VARCHAR(100),
    postal_code VARCHAR(20) NOT NULL,
    city VARCHAR(30) NOT NULL,
    state_province VARCHAR(30) NOT NULL,
    country VARCHAR(30) NOT NULL,
    status ENUM('A', 'I') NOT NULL
);

CREATE TABLE tb_products (
	id INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    code CHAR(10) NOT NULL UNIQUE,
    name VARCHAR(255) NOT NULL,
    description VARCHAR(2048),
    type VARCHAR(50) NOT NULL,
    picture_path VARCHAR(1024),
    quantity_in_stock INT UNSIGNED NOT NULL,
    price DECIMAL(20,2) UNSIGNED NOT NULL,
    discount DECIMAL(20,2) UNSIGNED NOT NULL,
    is_featured_deal BIT NOT NULL,
    is_deal BIT NOT NULL,
    status ENUM('A', 'I') NOT NULL
);

CREATE TABLE tb_orders (
	id INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    code CHAR(10) NOT NULL,
    order_date DATETIME NOT NULL,
    total_amount DECIMAL(20,2) UNSIGNED NOT NULL,
    user_id INT UNSIGNED NOT NULL,
    recipient_name VARCHAR(60) NOT NULL,
    phone_number VARCHAR(20),
	address_line_1 VARCHAR(100) NOT NULL,
    address_line_2 VARCHAR(100),
    postal_code VARCHAR(20) NOT NULL,
    city VARCHAR(30) NOT NULL,
    state_province VARCHAR(30) NOT NULL,
    country VARCHAR(30) NOT NULL,
    CONSTRAINT fk_order_user FOREIGN KEY (user_id) REFERENCES tb_users (id)
);

CREATE TABLE tb_order_items (
	order_id INT UNSIGNED NOT NULL,
    product_id INT UNSIGNED NOT NULL,
    quantity INT UNSIGNED NOT NULL,
	price DECIMAL(20,2) UNSIGNED NOT NULL,
    discount DECIMAL(20,2) UNSIGNED NOT NULL,
    total_price DECIMAL(20,2) UNSIGNED NOT NULL,
    CONSTRAINT fk_order_item_order FOREIGN KEY (order_id) REFERENCES tb_orders (id) ON DELETE CASCADE,
    CONSTRAINT fk_order_item_product FOREIGN KEY (product_id) REFERENCES tb_products (id)
);

/* Default data insertion */
INSERT INTO tb_products
(
    code,
    name,
    description,
    type,
    picture_path,
    quantity_in_stock,
    price,
    discount,
    is_featured_deal,
    is_deal,
    status
) VALUES
(
	'0000000001',
    'Donkey Kong Classics',
    'Donkey Kong Classics is a video game collection of the Donkey Kong series, consisting of the games Donkey Kong and Donkey Kong Jr. This compilation is for the Nintendo Entertainment System, which was developed by Nintendo EAD. It was released on October 1988 in the US, three years after the original release of the NES, and August 10, 1989 in Europe. It was never released in Japan. Nothing has changed in gameplay and modes. The only difference is the title screen. It is now a blue color, and the player can switch between the two games and the single and multi-player modes from there. They are exactly the same as the Arcade Classics Series versions of the games. The above text is from the Super Mario Wiki and is available under a Creative Commons license. Attribution must be provided through a list of authors or a link back to the original article. <a href="https://www.mariowiki.com/Donkey_Kong_Classics">Source</a>.',
    'NES cartridge',
    'images/products/product1.webp',
    5,
    35.99,
    0.25,
    1,
    1,
    'A'
);

INSERT INTO tb_products
(
    code,
    name,
    description,
    type,
    picture_path,
    quantity_in_stock,
    price,
    discount,
    is_featured_deal,
    is_deal,
    status
) VALUES
(
	'0000000002',
    'The Legend of Zelda',
    'The Legend of Zelda is the first installment of the Zelda series. Its plot centers around a boy named Link, who becomes the central protagonist throughout the series. It originally came out in 1986 for the Famicom Disk System in Japan and internationally on the NES in 1987. It has since been re-released for several systems, including the Nintendo GameCube, the Game Boy Advance, and the Virtual Console. The Japanese version of the game is known as The Hyrule Fantasy: The Legend of Zelda. <a href="https://zelda.fandom.com/wiki/The_Legend_of_Zelda">Source</a>.',
    'NES cartridge',
    'images/products/product2.jpg',
    3,
    47.99,
    0.15,
    1,
    1,
    'A'
);

INSERT INTO tb_products
(
    code,
    name,
    description,
    type,
    picture_path,
    quantity_in_stock,
    price,
    discount,
    is_featured_deal,
    is_deal,
    status
) VALUES
(
	'0000000003',
    'Super Mario Bros.',
    'Super Mario Bros. is a video game released for the Family Computer and Nintendo Entertainment System in 1985. It shifted the gameplay away from its single-screen arcade predecessor, Mario Bros., and instead featured side-scrolling platformer levels. While not the first game of the Super Mario franchise (the first being Donkey Kong), Super Mario Bros. is the most iconic, and it introduced various series staples, including power-ups, classic enemies such as Goombas, and the basic premise of rescuing Princess Peach from Bowser. <a href="https://www.mariowiki.com/Super_Mario_Bros">Source</a>.',
    'NES cartridge',
    'images/products/product3.webp',
    6,
    26.99,
    0.25,
    1,
    1,
    'A'
);

INSERT INTO tb_products
(
    code,
    name,
    description,
    type,
    picture_path,
    quantity_in_stock,
    price,
    discount,
    is_featured_deal,
    is_deal,
    status
) VALUES
(
	'0000000004',
    'Super Bomberman 3',
    'Super Bomberman 3 (スーパーボンバーマン3, Sūpā Bonbāman 3) is an action game developed and published by Hudson Soft for the Super Nintendo and released in 1995. It is the third game in the Super Bomberman series. <a href="https://bomberman.fandom.com/wiki/Super_Bomberman_3">Source</a>.',
    'SNES cartridge',
    'images/products/product4.jpg',
    1,
    39.99,
    0,
    0,
    0,
    'A'
);

INSERT INTO tb_products
(
    code,
    name,
    description,
    type,
    picture_path,
    quantity_in_stock,
    price,
    discount,
    is_featured_deal,
    is_deal,
    status
) VALUES
(
	'0000000005',
    'Super Mario Kart',
    'Super Mario Kart is a racing game for the Super Nintendo Entertainment System. The game was first released in 1992 and rereleased in 1996 as a Player\'s Choice title, being the first title in the lineup. Unlike the other racing games at the time, which focused on single-player racing with more complicated tracks, Super Mario Kart was focused on two players and was designed to be an easy and intuitive "pick up and play" experience that heavily involves the use of acquiring weapons on an obstacle course-like track to impede another player\'s progress. The development of a one-on-one Battle Mode was invented as another way to enjoy the competitive aspects of the game. Another notable aspect of the game is its Mode 7 graphics, where the game simulates a 3D plane by rotating and scaling a background graphic on a scanline-by-scanline basis, allowing players to simulate driving in a 3D environment. <a href="https://www.mariowiki.com/Super_Mario_Kart">Source</a>.',
    'SNES cartridge',
    'images/products/product5.jpg',
    2,
    28.99,
    0,
    0,
    0,
    'A'
);

-- Set the current datetime to be used in the operations
SET @current_datetime = NOW();

-- Set the salt value as a random generated UUID
SET @salt_value = UUID();

-- Inser the user
INSERT INTO tb_users 
(
	first_name,
	last_name,
	sex,
	email,
	password_hash,
	salt,
	register_date,
	phone_number,
	picture_path,
	birth_date,
	address_line_1,
	address_line_2,
	postal_code,
	city,
	state_province,
	country,
	status
) VALUES 
(
	'Admin',
	' ',
	'N',
	'admin@marcosmota.tech',
	SHA2(CONCAT('Admin@123', @salt_value), 256),
	@salt_value,
	@current_datetime,
	'',
	'images/users/no-picture.png',
	'1990-01-01',
	'No address',
	'',
	'',
	'Toronto',
	'Ontario',
	'Canada',
	'A'
);