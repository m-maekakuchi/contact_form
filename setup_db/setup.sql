DROP DATABASE IF EXISTS sample_form;
CREATE DATABASE sample_form;
USE sample_form;

DROP TABLE IF EXISTS `inquiry`;
CREATE TABLE inquiry(
   `id`           INT          NOT NULL AUTO_INCREMENT PRIMARY KEY
  ,`name`         VARCHAR(255) NOT NULL
  ,`kana`         VARCHAR(255) NOT NULL
  ,`tel`          VARCHAR(13)  NOT NULL
  ,`gender`       INT          NOT NULL
  ,`email`        VARCHAR(255) NOT NULL
  ,`confirm_mail` VARCHAR(255) NOT NULL
  ,`content`      text
)DEFAULT CHARSET=utf8;