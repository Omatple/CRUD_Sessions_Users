CREATE TABLE users (
    id INT AUTO_INCREMENT NOT NULL PRIMARY KEY,
    username VARCHAR(30) NOT NULL UNIQUE,
    email VARCHAR(255) NOT NULL UNIQUE,
    password VARCHAR(60) NOT NULL,
    role VARCHAR(5) NOT NULL,
    image VARCHAR(100) NOT NULL
);

CREATE TABLE cars (
    id INT AUTO_INCREMENT NOT NULL PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    brand VARCHAR(100) NOT NULL,
    horsepower INT NOT NULL,
    image VARCHAR(100) NOT NULL
);