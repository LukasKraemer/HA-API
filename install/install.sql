CREATE TABLE  `log` (
                       `idlog` INT(11) NOT NULL AUTO_INCREMENT,
                       `action` VARCHAR(64) NOT NULL,
                       `time` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
                       `user_iduser` INT(5) NOT NULL,
                       PRIMARY KEY (
                                    `idlog`
                           )
);

CREATE TABLE `user` (
                        `iduser` INT(5) NOT NULL AUTO_INCREMENT,
                        `name` VARCHAR(64) NOT NULL,
                        `passwd` VARCHAR(128) NOT NULL,
                        `permission` INT(2) NOT NULL,
                        `state_id` INT(2) NOT NULL,
                        `created` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                        PRIMARY KEY (
                                     `iduser`
                            )
);

CREATE TABLE `state` (
                         `idstate` INT(2) NOT NULL AUTO_INCREMENT,
                         `name` VARCHAR(64) NOT NULL,
                         PRIMARY KEY (
                                      `idstate`
                             )
);

CREATE TABLE `tokenlist` (
                             `idtokenlist` INT(5) NOT NULL AUTO_INCREMENT,
                             `state_id` INT(2) NOT NULL,
                             `user_iduser` INT(5) NOT NULL,
                             `created` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
                             PRIMARY KEY (
                                          `idtokenlist`
                                 )
);

CREATE TABLE `permission` (
                              `idpermission` INT(2) NOT NULL,
                              `name` VARCHAR(64) NOT NULL,
                              PRIMARY KEY (
                                           `idpermission`
                                  )
);
commit;

INSERT INTO permission (idpermission, name) VALUES (1, 'nothing');
INSERT INTO permission (idpermission, name) VALUES (2, 'app-GetValues');
INSERT INTO permission (idpermission, name) VALUES (3, 'app-startProgram');
INSERT INTO permission (idpermission, name) VALUES (4, 'app-upload');
INSERT INTO permission (idpermission, name) VALUES (5, 'all App feature');
INSERT INTO permission (idpermission, name) VALUES (6, 'app and Summary');
INSERT INTO permission (idpermission, name) VALUES (7, 'only sumary');
INSERT INTO permission (idpermission, name) VALUES (8, 'admin and summary');
INSERT INTO permission (idpermission, name) VALUES (9, 'admin and App');
INSERT INTO permission (idpermission, name) VALUES (10, 'all');



INSERT INTO state (idstate, name) VALUES (1,'allowed');
INSERT INTO state (idstate, name) VALUES (2,'locked');
INSERT INTO state (idstate, name) VALUES (3,'another');
INSERT INTO state (idstate, name) VALUES (4,'deleted');
INSERT INTO state (idstate, name) VALUES (5,'expired');
INSERT INTO state (idstate, name) VALUES (6,'invalid');