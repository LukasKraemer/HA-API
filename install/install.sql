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
CREATE TABLE `summary` (
                           `trip_number` bigint(20) NOT NULL,
                           `day` date DEFAULT NULL,
                           `time_Begins` text DEFAULT NULL,
                           `time_End` text DEFAULT NULL,
                           `km_start` bigint(20) DEFAULT NULL,
                           `km_end` bigint(20) DEFAULT NULL,
                           `trip_length` double DEFAULT NULL,
                           `trip_length_ev` double DEFAULT NULL,
                           `driving` double DEFAULT NULL,
                           `driving_ev` double DEFAULT NULL,
                           `driving_move` double DEFAULT NULL,
                           `driving_stop` double DEFAULT NULL,
                           `fuel` double DEFAULT NULL,
                           `outside_temp` double DEFAULT NULL,
                           `outside_temp_average` double DEFAULT NULL,
                           `soc_average` double DEFAULT NULL,
                           `soc_minimum` double DEFAULT NULL,
                           `soc_maximal` double DEFAULT NULL,
                           `soc_start` double DEFAULT NULL,
                           `soc_end` double DEFAULT NULL,
                           `consumption_average` double DEFAULT NULL,
                           `ev_proportion` bigint(20) DEFAULT NULL,
                           `speed_average` bigint(20) DEFAULT NULL,
                           `speed_max` bigint(20) DEFAULT NULL,
                           `soc_change` bigint(20) DEFAULT NULL,
                           `rotation_speed_average` double DEFAULT NULL,
                           `rotation_speed_max` bigint(20) DEFAULT NULL,
                           `engine load_average` double DEFAULT NULL,
                           `engine_load_max` bigint(20) DEFAULT NULL,
                           `battery_temp_max` bigint(20) DEFAULT NULL,
                           `battery_temp_average` double DEFAULT NULL,
                           `battery_temp_min` bigint(20) DEFAULT NULL,
                           `engine_cooling_temperature_max` bigint(20) DEFAULT NULL,
                           `engine_cooling_temperature_average` double DEFAULT NULL,
                           `engine_cooling_temperature_min` bigint(20) DEFAULT NULL,
                           `electric_motor_temp_max` bigint(20) DEFAULT NULL,
                           `electric_motor_temp_average` double DEFAULT NULL,
                           `electric_motor_temp_min` bigint(20) DEFAULT NULL,
                           `inverter_motor_temp_max` bigint(20) DEFAULT NULL,
                           `inverter_motor_temp_average` double DEFAULT NULL,
                           `inverter_motor_temp_min` bigint(20) DEFAULT NULL,
                           `indoor_temp_max` bigint(20) DEFAULT NULL,
                           `indoor_temp_average` double DEFAULT NULL,
                           `indoor_temp_min` bigint(20) DEFAULT NULL,
                           PRIMARY KEY (`trip_number`),
                           KEY `ix_summary_id` (`trip_number`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
CREATE TABLE `rawData` (
                           `counter` bigint(20) NOT NULL,
                           `Date` text DEFAULT NULL,
                           `Time` text DEFAULT NULL,
                           `rps` bigint(20) DEFAULT NULL,
                           `odo` bigint(20) DEFAULT NULL,
                           `speed_obd` bigint(20) DEFAULT NULL,
                           `gps_lat` double DEFAULT NULL,
                           `gps_lon` double DEFAULT NULL,
                           `gps_speed` bigint(20) DEFAULT NULL,
                           `gps_alt` bigint(20) DEFAULT NULL,
                           `hv_v` double DEFAULT NULL,
                           `hv_a` double DEFAULT NULL,
                           `soc` double DEFAULT NULL,
                           `ice_temp` bigint(20) DEFAULT NULL,
                           `ice_rpm` bigint(20) DEFAULT NULL,
                           `ice_pwr` double DEFAULT NULL,
                           `brk_reg_trq` bigint(20) DEFAULT NULL,
                           `brk_mcyl_trq` bigint(20) DEFAULT NULL,
                           `trip_nbs` bigint(20) DEFAULT NULL,
                           `trip_ev_nbs` bigint(20) DEFAULT NULL,
                           `trip_mov_nbs` bigint(20) DEFAULT NULL,
                           `trip_dist` double DEFAULT NULL,
                           `trip_ev_dist` double DEFAULT NULL,
                           `hsi` bigint(20) DEFAULT NULL,
                           `mg2_rpm` bigint(20) DEFAULT NULL,
                           `ign` bigint(20) DEFAULT NULL,
                           `ltft` bigint(20) DEFAULT NULL,
                           `stft` bigint(20) DEFAULT NULL,
                           `tripfuel` double DEFAULT NULL,
                           `fuelflowh` double DEFAULT NULL,
                           `dcl` double DEFAULT NULL,
                           `ccl` bigint(20) DEFAULT NULL,
                           `bsfc` bigint(20) DEFAULT NULL,
                           `ice_load` bigint(20) DEFAULT NULL,
                           `inverter_temp` bigint(20) DEFAULT NULL,
                           `battery_temp` bigint(20) DEFAULT NULL,
                           `mg_temp` bigint(20) DEFAULT NULL,
                           `inhaling_temp` bigint(20) DEFAULT NULL,
                           `ambient_temp` bigint(20) DEFAULT NULL,
                           `room_temp` bigint(20) DEFAULT NULL,
                           `mg2_torque` double DEFAULT NULL,
                           `mg1_rpm` bigint(20) DEFAULT NULL,
                           `mg1_torque` double DEFAULT NULL,
                           `mgr_rpm` bigint(20) DEFAULT NULL,
                           `mgr_torque` bigint(20) DEFAULT NULL,
                           `glideindex` double DEFAULT NULL,
                           `accelerator` bigint(20) DEFAULT NULL,
                           `positivekwh` double DEFAULT NULL,
                           `negativekwh` double DEFAULT NULL,
                           `trip_counter` bigint(20) NOT NULL,
                           PRIMARY KEY (`counter`,`trip_counter`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


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