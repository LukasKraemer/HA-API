CREATE TABLE IF NOT EXISTS  `log` (
    `idlog` INT(11) NOT NULL AUTO_INCREMENT,
    `action` VARCHAR(64) NOT NULL,
    `time` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `user_iduser` INT(5) NOT NULL,
    PRIMARY KEY (
                `idlog`
        )
);

CREATE TABLE IF NOT EXISTS  `user` (
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

CREATE TABLE IF NOT EXISTS `state` (
    `idstate` INT(2) NOT NULL AUTO_INCREMENT,
    `name` VARCHAR(64) NOT NULL,
    PRIMARY KEY (
                `idstate`
        )
);
CREATE TABLE IF NOT EXISTS `loggedtrips` (
    `index` INT(11) NOT NULL AUTO_INCREMENT,
    `filename` VARCHAR(50) NULL DEFAULT NULL,
    `Datum` TEXT NULL DEFAULT NULL,
    `type` INT(11) NULL DEFAULT NULL,
    `tripNumber` INT(11) NULL DEFAULT NULL,
    PRIMARY KEY (`index`),
    UNIQUE INDEX `filename_UNIQUE` (`filename` ASC) VISIBLE,
    INDEX `fk_loggedtrips_1_idx` (`type` ASC) VISIBLE,
    INDEX `fk_loggedtrips_2_idx` (`tripNumber` ASC) VISIBLE,
    CONSTRAINT `fk_loggedtrips_1`
        FOREIGN KEY (`type`)
        REFERENCES `car_angular`.`typeTrip` (`idtypeTrip`)
        ON DELETE NO ACTION
        ON UPDATE NO ACTION,
    CONSTRAINT `fk_loggedtrips_2`
        FOREIGN KEY (`tripNumber`)
        REFERENCES `car_angular`.`summary` (`trip_number`)
        ON DELETE NO ACTION
        ON UPDATE NO ACTION);

CREATE TABLE IF NOT EXISTS `fast_log` (
    `counter` INT(11) NOT NULL,
    `Date` DATE NULL DEFAULT NULL,
    `Time` TIME NULL DEFAULT NULL,
    `rps` BIGINT(20) NULL DEFAULT NULL,
    `odo` BIGINT(20) NULL DEFAULT NULL,
    `speed_obd` BIGINT(20) NULL DEFAULT NULL,
    `gps_lat` DOUBLE NULL DEFAULT NULL,
    `gps_lon` DOUBLE NULL DEFAULT NULL,
    `gps_speed` BIGINT(20) NULL DEFAULT NULL,
    `gps_alt` BIGINT(20) NULL DEFAULT NULL,
    `hv_v` DOUBLE NULL DEFAULT NULL,
    `hv_a` DOUBLE NULL DEFAULT NULL,
    `soc` DOUBLE NULL DEFAULT NULL,
    `ice_temp` BIGINT(20) NULL DEFAULT NULL,
    `ice_rpm` BIGINT(20) NULL DEFAULT NULL,
    `ice_pwr` DOUBLE NULL DEFAULT NULL,
    `brk_reg_trq` BIGINT(20) NULL DEFAULT NULL,
    `brk_mcyl_trq` BIGINT(20) NULL DEFAULT NULL,
    `trip_nbs` BIGINT(20) NULL DEFAULT NULL,
    `trip_ev_nbs` BIGINT(20) NULL DEFAULT NULL,
    `trip_mov_nbs` BIGINT(20) NULL DEFAULT NULL,
    `trip_dist` DOUBLE NULL DEFAULT NULL,
    `trip_ev_dist` DOUBLE NULL DEFAULT NULL,
    `hsi` BIGINT(20) NULL DEFAULT NULL,
    `mg2_rpm` BIGINT(20) NULL DEFAULT NULL,
    `ign` BIGINT(20) NULL DEFAULT NULL,
    `ltft` BIGINT(20) NULL DEFAULT NULL,
    `stft` BIGINT(20) NULL DEFAULT NULL,
    `tripfuel` DOUBLE NULL DEFAULT NULL,
    `fuelflowh` DOUBLE NULL DEFAULT NULL,
    `dcl` DOUBLE NULL DEFAULT NULL,
    `ccl` BIGINT(20) NULL DEFAULT NULL,
    `bsfc` BIGINT(20) NULL DEFAULT NULL,
    `ice_load` BIGINT(20) NULL DEFAULT NULL,
    `inverter_temp` BIGINT(20) NULL DEFAULT NULL,
    `battery_temp` BIGINT(20) NULL DEFAULT NULL,
    `mg_temp` BIGINT(20) NULL DEFAULT NULL,
    `inhaling_temp` BIGINT(20) NULL DEFAULT NULL,
    `ambient_temp` BIGINT(20) NULL DEFAULT NULL,
    `room_temp` BIGINT(20) NULL DEFAULT NULL,
    `mg2_torque` DOUBLE NULL DEFAULT NULL,
    `mg1_rpm` BIGINT(20) NULL DEFAULT NULL,
    `mg1_torque` DOUBLE NULL DEFAULT NULL,
    `mgr_rpm` BIGINT(20) NULL DEFAULT NULL,
    `mgr_torque` BIGINT(20) NULL DEFAULT NULL,
    `glideindex` DOUBLE NULL DEFAULT NULL,
    `accelerator` BIGINT(20) NULL DEFAULT NULL,
    `positivekwh` DOUBLE NULL DEFAULT NULL,
    `negativekwh` DOUBLE NULL DEFAULT NULL,
    `trip_counter` INT(11) NOT NULL,
    PRIMARY KEY (`counter`, `trip_counter`));


CREATE TABLE IF NOT EXISTS  `permission` (
    `idpermission` INT(2) NOT NULL,
    `name` VARCHAR(64) NOT NULL,
    PRIMARY KEY (
                `idpermission`
        )
);

CREATE TABLE IF NOT EXISTS `overview` (
    `trip_number` INT(11) NOT NULL,
    `day` DATE NULL DEFAULT NULL,
    `time_Begins` TEXT NULL DEFAULT NULL,
    `time_End` TEXT NULL DEFAULT NULL,
    `km_start` BIGINT(20) NULL DEFAULT NULL,
    `km_end` BIGINT(20) NULL DEFAULT NULL,
    `trip_length` DOUBLE NULL DEFAULT NULL,
    `trip_length_ev` DOUBLE NULL DEFAULT NULL,
    `driving` DOUBLE NULL DEFAULT NULL,
    `driving_ev` DOUBLE NULL DEFAULT NULL,
    `driving_move` DOUBLE NULL DEFAULT NULL,
    `driving_stop` DOUBLE NULL DEFAULT NULL,
    `fuel` DOUBLE NULL DEFAULT NULL,
    `outside_temp` DOUBLE NULL DEFAULT NULL,
    `outside_temp_average` DOUBLE NULL DEFAULT NULL,
    `soc_average` DOUBLE NULL DEFAULT NULL,
    `soc_minimum` DOUBLE NULL DEFAULT NULL,
    `soc_maximal` DOUBLE NULL DEFAULT NULL,
    `soc_start` DOUBLE NULL DEFAULT NULL,
    `soc_end` DOUBLE NULL DEFAULT NULL,
    `consumption_average` DOUBLE NULL DEFAULT NULL,
    `ev_proportion` BIGINT(20) NULL DEFAULT NULL,
    `speed_average` BIGINT(20) NULL DEFAULT NULL,
    `speed_max` BIGINT(20) NULL DEFAULT NULL,
    `soc_change` BIGINT(20) NULL DEFAULT NULL,
    `rotation_speed_average` DOUBLE NULL DEFAULT NULL,
    `rotation_speed_max` BIGINT(20) NULL DEFAULT NULL,
    `engine load_average` DOUBLE NULL DEFAULT NULL,
    `engine_load_max` BIGINT(20) NULL DEFAULT NULL,
    `battery_temp_max` BIGINT(20) NULL DEFAULT NULL,
    `battery_temp_average` DOUBLE NULL DEFAULT NULL,
    `battery_temp_min` BIGINT(20) NULL DEFAULT NULL,
    `engine_cooling_temperature_max` BIGINT(20) NULL DEFAULT NULL,
    `engine_cooling_temperature_average` DOUBLE NULL DEFAULT NULL,
    `engine_cooling_temperature_min` BIGINT(20) NULL DEFAULT NULL,
    `electric_motor_temp_max` BIGINT(20) NULL DEFAULT NULL,
    `electric_motor_temp_average` DOUBLE NULL DEFAULT NULL,
    `electric_motor_temp_min` BIGINT(20) NULL DEFAULT NULL,
    `inverter_motor_temp_max` BIGINT(20) NULL DEFAULT NULL,
    `inverter_motor_temp_average` DOUBLE NULL DEFAULT NULL,
    `inverter_motor_temp_min` BIGINT(20) NULL DEFAULT NULL,
    `indoor_temp_max` BIGINT(20) NULL DEFAULT NULL,
    `indoor_temp_average` DOUBLE NULL DEFAULT NULL,
    `indoor_temp_min` BIGINT(20) NULL DEFAULT NULL,
    PRIMARY KEY (`trip_number`),
    INDEX `ix_summary_id` (`trip_number` ASC) VISIBLE);

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