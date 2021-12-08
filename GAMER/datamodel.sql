CREATE TABLE users (
    id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE Locations (
    Name VARCHAR(20) NOT NULL,
    Address VARCHAR(45) NOT NULL,
    City VARCHAR(45) NOT NULL,
    Province VARCHAR(45) NOT NULL,
    Postal_Code VARCHAR(45) NOT NULL,
    Latitude VARCHAR(45) NOT NULL,
    Longitude VARCHAR(45) NOT NULL,
    Telephone VARCHAR(45) NOT NULL,
    PRIMARY KEY (Name, Address)
);