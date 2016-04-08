/*\u7528\u6237\u8868users*/
CREATE TABLE `sim_users` (
`u_id` INT( 10 ) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY ,
`u_account_hash` INT( 10 ) UNSIGNED NOT NULL ,
`u_account` VARCHAR( 16 ) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL	UNIQUE ,
`u_pass` VARCHAR( 32 ) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL ,
`u_pid` INT( 10 ) UNSIGNED NOT NULL DEFAULT '0',
`u_t_f` INT( 10 ) UNSIGNED NOT NULL DEFAULT '0',
`u_t_r_l` INT( 10 ) UNSIGNED NOT NULL DEFAULT '0',
`u_t_r_r` INT( 10 ) UNSIGNED NOT NULL DEFAULT '0',
`u_t_l` INT( 10 ) UNSIGNED NOT NULL DEFAULT '0',
`u_t_s` INT( 10 ) UNSIGNED NOT NULL DEFAULT '0',
INDEX u_search ( `u_account`(10) ),
INDEX u_search_2 ( `u_account_hash`, `u_account` ),
INDEX tree_search ( `u_t_f`, `u_t_r_l`, `u_t_r_r`, `u_t_l`, `u_t_s` )
) ENGINE = INNODB CHARACTER SET utf8 COLLATE utf8_unicode_ci;

CREATE TABLE `sim_sess` (
`u_id` INT( 10 ) UNSIGNED NOT NULL PRIMARY KEY ,
`u_sess` INT( 10 ) UNSIGNED NOT NULL ,
`u_sess_expire` INT( 10 ) UNSIGNED NOT NULL ,
) ENGINE = INNODB CHARACTER SET utf8 COLLATE utf8_unicode_ci;


/*\u89d2\u8272\u8868roles*/
CREATE TABLE `sim_roles` (
`r_id` SMALLINT( 5 ) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY ,
`r_name` VARCHAR( 16 ) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL	UNIQUE
) ENGINE = INNODB CHARACTER SET utf8 COLLATE utf8_unicode_ci;
/*\u7528\u6237\u89d2\u8272\u6620\u5c04\u8868use_roles*/
CREATE TABLE `sim_user_roles` (
`ur_id` SMALLINT( 5 ) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY ,
`u_id`	INT( 10 )	UNSIGNED	NOT NULL ,
`r_id`	SMALLINT( 5 )	UNSIGNED	NOT NULL,
FOREIGN KEY (`u_id`) REFERENCES `sim_users`(`u_id`),
FOREIGN KEY (`r_id`) REFERENCES `sim_roles`(`r_id`),
INDEX roles_search ( `u_id`, `r_id` )
) ENGINE = INNODB CHARACTER SET utf8 COLLATE utf8_unicode_ci;
/*\u6743\u9650\u8282\u70b9\u8868node*/
CREATE TABLE `sim_cnode` (
`n_id`	SMALLINT( 5 ) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY ,
`n_name` VARCHAR( 32 ) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
`n_type` TINYINT( 3 ) UNSIGNED NOT NULL DEFAULT '0' CHECK (`n_type`<3),
`n_pid` INT( 10 ) UNSIGNED NOT NULL DEFAULT '0',
`n_t_f` INT( 10 ) UNSIGNED NOT NULL DEFAULT '0',
`n_t_r_l` INT( 10 ) UNSIGNED NOT NULL DEFAULT '0',
`n_t_r_r` INT( 10 ) UNSIGNED NOT NULL DEFAULT '0',
`n_t_l` INT( 10 ) UNSIGNED NOT NULL DEFAULT '0',
`n_t_s` INT( 10 ) UNSIGNED NOT NULL DEFAULT '0',
INDEX tree_search ( `n_t_f`, `n_t_r_l`, `n_t_r_r`, `n_t_l`, `n_t_s` )
) ENGINE = INNODB CHARACTER SET utf8 COLLATE utf8_unicode_ci;
/*\u6743\u9650\u8868\u6620\u5c04\u8868access*/
CREATE TABLE `sim_cnode_access` (
`r_id` SMALLINT( 5 ) UNSIGNED NOT NULL,
`n_id` SMALLINT( 5 ) UNSIGNED NOT NULL,
FOREIGN KEY (`r_id`) REFERENCES `_roles`(`r_id`),
FOREIGN KEY (`n_id`) REFERENCES `_cnode`(`n_id`)
) ENGINE = INNODB CHARACTER SET utf8 COLLATE utf8_unicode_ci;

/*\u5b58\u50a8\u8fc7\u7a0b*/
DROP PROCEDURE IF EXISTS insert_user;
DELIMITER //
CREATE PROCEDURE insert_user( IN p_acc_hash INT(10), IN p_acc VARCHAR(16), IN p_pass VARCHAR(32), IN p_pid INT(10), IN p_t_s INT(10) )
BEGIN
DECLARE d_count INT DEFAULT 0;
DECLARE d_status INT DEFAULT 0;
DECLARE d_error INT DEFAULT 0;
DECLARE d_id INT DEFAULT 0;
DECLARE d_pid INT DEFAULT 0;
DECLARE d_t_f INT DEFAULT 0;
DECLARE d_t_r_l INT DEFAULT 0;
DECLARE d_t_r_r INT DEFAULT 1;
DECLARE d_t_l INT DEFAULT 0;
DECLARE d_t_s INT DEFAULT 0;
DECLARE CONTINUE HANDLER FOR SQLEXCEPTION SET d_error=1;
IF p_pid = 0 THEN
START TRANSACTION;
INSERT INTO `sim_users` ( `u_account_hash`, `u_account`, `u_pass`, `u_pid`, `u_t_f`, `u_t_r_l`, `u_t_r_r`, `u_t_l`, `u_t_s` ) VALUES ( p_acc_hash, p_acc, p_pass, d_pid, d_t_f, d_t_r_l, d_t_r_r, d_t_l, p_t_s);
SET d_id = LAST_INSERT_ID();
UPDATE `sim_users` SET `u_t_f` = d_id WHERE `u_id` = d_id;
IF d_error = 1 THEN
ROLLBACK;
SELECT d_status AS `status`;
ELSE
COMMIT;
SET d_status = 1;
SELECT d_status AS `status`, d_id AS `u_id`;
END IF;
ELSE
SELECT `u_t_f`, `u_t_r_l`, `u_t_r_r`, `d_t_l`, COUNT(*) INTO d_t_f, d_t_r_l, d_t_r_r, d_t_l, d_count FROM `sim_users` WHERE `u_id` = p_pid;
IF d_count = 0 THEN
SET d_status = 2;
SELECT d_status AS `status`;
ELSE	
SET d_t_r_l = d_t_r_r;
SET d_t_r_r = d_t_r_r + 1;
SET d_t_l = d_t_l + 1;
START TRANSACTION;
UPDATE `sim_users` SET `u_t_r_l` = `u_t_r_l` + 2 WHERE `u_t_f` = d_t_f AND `u_t_r_l` > d_t_r_l;
SET d_t_l = d_t_l - 1;
UPDATE `sim_users` SET `u_t_r_r` = `u_t_r_r` + 2 WHERE `u_t_f` = d_t_f AND `u_t_r_r` >= d_t_r_l;
SET d_t_l = d_t_l + 1;
INSERT INTO `sim_users` ( `u_account_hash`, `u_account`, `u_pass`, `u_pid`, `u_t_f`, `u_t_r_l`, `u_t_r_r`, `u_t_l`, `u_t_s` ) VALUES ( p_acc_hash, p_acc, p_pass, p_pid, d_t_f, d_t_r_l, d_t_r_r, d_t_l, p_t_s);
SET d_id = LAST_INSERT_ID();
IF d_error = 1 THEN
ROLLBACK;
SET d_status = 3;
SELECT d_status AS `status`;
ELSE
COMMIT;
SET d_status = 4;
SELECT d_status AS `status`, d_id AS `u_id`;
END IF;
END IF;
END IF;
END
//
DELIMITER ;
call insert_user('123', 'test_1', '123', '0', '0');
/*\u5220\u9664\u8282\u70b9\u5b58\u50a8\u8fc7\u7a0b*/
DROP PROCEDURE IF EXISTS drop_user;
DELIMITER //
CREATE PROCEDURE drop_user( IN p_id INT(10) )
BEGIN
DECLARE d_count INT DEFAULT 0;
DECLARE d_status INT DEFAULT 0;
DECLARE d_error INT DEFAULT 0;
DECLARE d_id INT DEFAULT 0;
DECLARE d_pid INT DEFAULT 0;
DECLARE d_t_f INT DEFAULT 0;
DECLARE d_t_r_l INT DEFAULT 0;
DECLARE d_t_r_r INT DEFAULT 1;
DECLARE d_t_l INT DEFAULT 0;
DECLARE d_t_s INT DEFAULT 0;
DECLARE d_offset INT DEFAULT 0;
DECLARE d_effect INT DEFAULT 0;
DECLARE CONTINUE HANDLER FOR SQLEXCEPTION SET d_error=1;
SELECT `u_t_f`, `u_t_r_l`, `u_t_r_r`, `d_t_l`, COUNT(*) INTO d_t_f, d_t_r_l, d_t_r_r, d_t_l, d_count FROM `sim_users` WHERE `u_id` = p_id;
IF d_count = 1 THEN
SET d_offset = d_t_r_r - d_t_r_l + 1;
START TRANSACTION;
IF d_offset = 2 THEN
DELETE FROM `sim_users` WHERE `u_id` = p_id;
ELSE
DELETE FROM `sim_users` WHERE `u_t_f` = d_t_f AND `u_t_r_l` >= d_t_r_l AND `u_t_r_r` <= d_t_r_r;
END IF;
SET d_effect = ROW_COUNT();
UPDATE `sim_users` SET `u_t_r_l` = `u_t_r_l` - d_offset WHERE `u_t_f` = d_t_f AND `u_t_r_l` > d_t_r_l;
UPDATE `sim_users` SET `u_t_r_r` = `u_t_r_r` - d_offset WHERE `u_t_f` = d_t_f AND `u_t_r_r` > d_t_r_r;
IF d_error = 1 THEN
ROLLBACK;
SET d_status = 1;
ELSE
COMMIT;
SET d_status = 2;
END IF;
END IF;
SELECT d_status AS `status`, d_effect as `effect`;
END
//
DELIMITER ;
call drop_user( 2 ); 
