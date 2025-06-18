
-- DB para utilizar no projeto--

CREATE DATABASE casecrypto;
USER casecrypto;

CREATE TABLE user (
	id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100),
    lastName VARCHAR(100),
    email VARCHAR(255),
    password VARCHAR(255)
);

CREATE TABLE casecrypto (
	id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    FOREIGN KEY (user_id) REFERENCES user (id)
);

CREATE TABLE coin (
	id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    symbol VARCHAR(50),
    name VARCHAR(100),
    image TEXT,
    price FLOAT,
    quantity FLOAT,
    case_id INT NOT NULL,
    FOREIGN KEY (case_id) REFERENCES casecrypto (id)
);