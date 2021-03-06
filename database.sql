CREATE DATABASE semiva_login;

CREATE DATABASE semiva_login_test;

CREATE TABLE users(
    id INT(11) PRIMARY KEY ,
    email VARCHAR(255) ,
    name VARCHAR(255) NOT NULL ,
    password VARCHAR(255) NOT NULL
) ENGINE InnoDB;

CREATE TABLE sessions(
    id VARCHAR(255) PRIMARY KEY ,
    user_id VARCHAR(255) NOT NULL
)ENGINE InnoDB;

ALTER TABLE sessions
ADD CONSTRAINT fk_sessions_user
    FOREIGN KEY (user_id)
        REFERENCES users(id);