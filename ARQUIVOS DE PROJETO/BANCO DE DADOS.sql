
-- CREATE SCHEMA ew_rede_social DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ;

use ew_rede_social;


CREATE TABLE IF NOT EXISTS usuario(
                id int(11) auto_increment primary key,
                nome varchar(20),
                sobrenome varchar(40),
                data_nascimento date,
                email varchar(40),
                senha varchar(20),
                genero varchar(1)
            ) Engine=InnoDB CHARSET=utf8 collate utf8_unicode_ci;
