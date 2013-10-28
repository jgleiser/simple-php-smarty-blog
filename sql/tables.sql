drop TABLE IF EXISTS article_tag1;
drop TABLE IF EXISTS tags;
drop TABLE IF EXISTS article_photo1;
drop TABLE IF EXISTS photos;
drop TABLE IF EXISTS comments;
drop TABLE IF EXISTS articles;
drop TABLE IF EXISTS blogs;
drop TABLE IF EXISTS users;

CREATE TABLE users (
	id INT NOT NULL auto_increment,
	username VARCHAR(30) NOT NULL UNIQUE,
	password VARCHAR(40) NOT NULL,
	name VARCHAR(80) NOT NULL,
	email VARCHAR(80) NOT NULL UNIQUE,
	PRIMARY KEY (id)
) ENGINE =  InnoDB;

CREATE TABLE blogs (
	id INT NOT NULL auto_increment,
	userid INT NOT NULL,
	title VARCHAR(80) NOT NULL,
	summary TEXT NOT NULL,
	created TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
	PRIMARY KEY(id),
	FOREIGN KEY (userid) REFERENCES users(id) ON DELETE CASCADE
) ENGINE =  InnoDB;

CREATE TABLE articles (
    id INT NOT NULL auto_increment,
    headline VARCHAR(80) NOT NULL,
	userid INT NOT NULL,
	article_body TEXT NOT NULL,
	blogid INT NOT NULL,
	created TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (id),
	FOREIGN KEY (userid) REFERENCES users(id) ON DELETE CASCADE,
	FOREIGN KEY (blogid) REFERENCES blogs(id) ON DELETE CASCADE
) ENGINE =  InnoDB;

-- name is UNIQUE since we dont need repeated tags
CREATE TABLE tags (
	id INT NOT NULL auto_increment,
	name VARCHAR(80) NOT NULL UNIQUE,
	PRIMARY KEY (id)
) ENGINE =  InnoDB;

CREATE TABLE photos (
	id INT NOT NULL auto_increment,
	imagedata BLOB DEFAULT "",
    imagename VARCHAR(40) DEFAULT "",
    imagetype VARCHAR(40) DEFAULT "",
    imagesize VARCHAR(40) DEFAULT "",
	PRIMARY KEY (id)
) ENGINE =  InnoDB;

CREATE TABLE comments (
	id INT NOT NULL auto_increment,
	title VARCHAR(80) NOT NULL,
	userid INT NOT NULL,
	comment_text TEXT NOT NULL,
	articleid INT NOT NULL,
	created TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
	PRIMARY KEY (id),
	FOREIGN KEY (userid) REFERENCES users(id) ON DELETE CASCADE,
	FOREIGN KEY (articleid) REFERENCES articles(id) ON DELETE CASCADE
) ENGINE =  InnoDB;

CREATE TABLE article_photo1 (
	id INT NOT NULL auto_increment,
	articleid INT NOT NULL,
	photoid INT NOT NULL,
	PRIMARY KEY (id),
	FOREIGN KEY (articleid) REFERENCES articles(id) ON DELETE CASCADE,
	FOREIGN KEY (photoid) REFERENCES photos(id) ON DELETE CASCADE
) ENGINE =  InnoDB;

CREATE TABLE article_tag1 (
	id INT NOT NULL auto_increment,
	articleid INT NOT NULL,
	tagid INT NOT NULL,
	PRIMARY KEY (id),
	FOREIGN KEY (articleid) REFERENCES articles(id) ON DELETE CASCADE,
	FOREIGN KEY (tagid) REFERENCES tags(id) ON DELETE CASCADE
) ENGINE =  InnoDB;
