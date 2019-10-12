CREATE DATABASE IF NOT EXISTS laravel_master;
USE laravel_master;

CREATE TABLE IF NOT EXISTS users(
    id             int(255) auto_increment not null,
    role           varchar(20),
    name           varchar(100),
    surname        varchar(200),
    nick           varchar(100),
    email          varchar(255),
    password       varchar(255),
    image          varchar(255),
    created_at     DATETIME,
    update_at      DATETIME,
    remenber_token varchar(255),
    CONSTRAINT pk_users PRIMARY KEY(id)

)ENGINE=InnoDb;

CREATE TABLE IF NOT EXISTS images(
    id             int(255) auto_increment not null,
    user_id        int(255),
    image_path     varchar(255),
    description    text,
    created_at     DATETIME,
    update_at      DATETIME,
    remenber_token varchar(255),
    CONSTRAINT pk_images PRIMARY KEY(id),
    CONSTRAINT fk_images_users FOREIGN KEY (user_id) REFERENCES users(id)

)ENGINE=InnoDb;

CREATE TABLE IF NOT EXISTS comments(
    id             int(255) auto_increment not null,
    user_id        int(255),
    image_id       int(255),
    content        text,
    created_at     DATETIME,
    update_at      DATETIME,
    remenber_token varchar(255),
    CONSTRAINT pk_comments PRIMARY KEY(id),
    CONSTRAINT fk_comments_users FOREIGN KEY (user_id) REFERENCES users(id),
    CONSTRAINT fk_comments_images FOREIGN KEY (image_id) REFERENCES images(id)
)ENGINE=InnoDb;

CREATE TABLE IF NOT EXISTS likes(
    id             int(255) auto_increment not null,
    user_id        int(255),
    image_id       int(255),
    created_at     DATETIME,
    update_at      DATETIME,
    remenber_token varchar(255),
    CONSTRAINT pk_likes PRIMARY KEY(id),
    CONSTRAINT fk_likes_users FOREIGN KEY (user_id) REFERENCES users(id),
    CONSTRAINT fk_likes_images FOREIGN KEY (image_id) REFERENCES images(id)
)ENGINE=InnoDb;

-- Tabla users
INSERT INTO users VALUES(NULL, 'user', 'Victor', 'Robles', 'victorroblesweb','victorrobles@gmail.com','pass', null, CURTIME(), CURTIME(), NULL);

-- Tabla images
INSERT INTO images VALUES(NULL, 1, 'test.jpg', 'Descripcion de prueba', CURTIME(), CURTIME());
INSERT INTO images VALUES(NULL, 1, 'playa.jpg', 'Descripcion de prueba 2', CURTIME(), CURTIME());
INSERT INTO images VALUES(NULL, 1, 'arena.jpg', 'Descripcion de prueba 3', CURTIME(), CURTIME());
INSERT INTO images VALUES(NULL, 3, 'familia.jpg', 'Descripcion de prueba 3', CURTIME(), CURTIME());

-- Tabla comments
INSERT INTO comments VALUES(null, 1, 4,'Buena Foto de Familia',CURTIME(), CURTIME());
INSERT INTO comments VALUES(null, 2, 1,'Buena Foto de PLAYA!',CURTIME(), CURTIME());
INSERT INTO comments VALUES(null, 2, 4,'que Bueno!',CURTIME(), CURTIME());

-- Tabla Likes
INSERT INTO likes VALUES(null, 1, 4,CURTIME(), CURTIME());
INSERT INTO likes VALUES(null, 2, 4,CURTIME(), CURTIME());
INSERT INTO likes VALUES(null, 3, 1,CURTIME(), CURTIME());
INSERT INTO likes VALUES(null, 3, 2,CURTIME(), CURTIME());
INSERT INTO likes VALUES(null, 2, 1,CURTIME(), CURTIME());