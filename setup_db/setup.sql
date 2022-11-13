DROP DATABASE IF EXISTS sample_contact;
CREATE DATABASE sample_contact;
USE sample_contact;

DROP TABLE IF EXISTS `contact`;
CREATE TABLE contact(
   `id`            INT          NOT NULL AUTO_INCREMENT PRIMARY KEY
  ,`name`          VARCHAR(255) NOT NULL
  ,`kana`          VARCHAR(255) NOT NULL
  ,`tel`           VARCHAR(13)  NOT NULL
  ,`gender`        INT          NOT NULL
  ,`email`         VARCHAR(255) NOT NULL
  ,`confirmEmail`  VARCHAR(255) NOT NULL
  ,`content`       text
)DEFAULT CHARSET=utf8;