CREATE DATABASE import_test;

CREATE TABLE product (
  id int(10) unsigned NOT NULL AUTO_INCREMENT,
  name varchar(50) NOT NULL,
  descr varchar(255) NOT NULL,
  code varchar(10) NOT NULL,
  created_at datetime DEFAULT NULL,
  updated_at datetime NOT NULL DEFAULT NOW() ON UPDATE NOW(),
  discontinued_at datetime DEFAULT NULL,
  PRIMARY KEY (id),
  UNIQUE KEY (code)
) ENGINE=InnoDB;
