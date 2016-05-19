DROP TABLE IF EXISTS `sim_prod_sproptemplate`;
DROP TABLE IF EXISTS `sim_prod_sproplink`;
DROP TABLE IF EXISTS `sim_prod_proplink`;
DROP TABLE IF EXISTS `sim_prod_spropval`;
DROP TABLE IF EXISTS `sim_prod_sprop`;
DROP TABLE IF EXISTS `sim_product`;
DROP TABLE IF EXISTS `sim_prod_sproppackage`;
DROP TABLE IF EXISTS `sim_prod_propval`;
DROP TABLE IF EXISTS `sim_prod_prop`;

DROP TABLE IF EXISTS `sim_prod_category`;


CREATE TABLE `sim_prod_sproptemplate` (
`sppt_id`	SMALLINT( 5 ) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY ,
`sppt_name` VARCHAR( 32 ) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
`sppt_spec` VARCHAR( 255 ) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
`sppt_template` TEXT CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL
) ENGINE = INNODB CHARACTER SET utf8 COLLATE utf8_unicode_ci;

CREATE TABLE `sim_prod_sproppackage` (
`sppp_id`	SMALLINT( 5 ) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY ,
`sppp_type`	TINYINT( 1 ) UNSIGNED NOT NULL DEFAULT '0',
`sppp_name` VARCHAR( 32 ) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
INDEX sp_search ( `sppp_type` )
) ENGINE = INNODB CHARACTER SET utf8 COLLATE utf8_unicode_ci;

CREATE TABLE `sim_prod_sprop` (
`spp_id`	INT( 10 ) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY ,
`spp_name` VARCHAR( 32 ) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
`spp_pid` SMALLINT( 5 ) UNSIGNED NOT NULL DEFAULT '0',
`spp_fid` INT( 10 ) UNSIGNED NOT NULL DEFAULT '0' ,
`spp_t_s` INT( 10 ) UNSIGNED NOT NULL DEFAULT '0',
FOREIGN KEY (`spp_pid`) REFERENCES `sim_prod_sproppackage`(`sppp_id`),
#FOREIGN KEY (`spp_fid`) REFERENCES `sim_prod_sprop`(`spp_id`),
INDEX sprop_search ( `spp_pid`, `spp_t_s` ),
INDEX sprop_search_2 ( `spp_pid`, `spp_fid` )
) ENGINE = INNODB CHARACTER SET utf8 COLLATE utf8_unicode_ci;

CREATE TABLE `sim_prod_spropval` (
`sppv_id`	INT( 10 ) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY ,
`sppv_type` TINYINT( 1 ) UNSIGNED NOT NULL DEFAULT '0',
`sppv_val` VARCHAR( 32 ) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
`sppv_spid` INT( 10 ) UNSIGNED NOT NULL DEFAULT '0',
`sppv_pid` INT( 10 ) UNSIGNED NOT NULL DEFAULT '0',
`sppv_apt` TINYINT( 1 ) UNSIGNED NOT NULL DEFAULT '0',
`sppv_ap` DECIMAL( 10,2 ) UNSIGNED NOT NULL DEFAULT '0',
`sppv_st` TINYINT( 1 ) UNSIGNED NOT NULL DEFAULT '0',
`sppv_s` VARCHAR( 255 ) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
`sppv_sku` INT( 10 ) UNSIGNED NOT NULL DEFAULT '0',
`sppv_t_s` INT( 10 ) UNSIGNED NOT NULL DEFAULT '0',
FOREIGN KEY (`sppv_spid`) REFERENCES `sim_prod_sprop`(`spp_id`),
INDEX sprop_search ( `sppv_pid`, `sppv_t_s` ),
INDEX sprop_search_2 ( `sppv_spid` )
) ENGINE = INNODB CHARACTER SET utf8 COLLATE utf8_unicode_ci;





CREATE TABLE `sim_prod_category` (
`c_id`	SMALLINT( 5 ) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY ,
`c_name` VARCHAR( 32 ) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
`c_spec` VARCHAR( 255 ) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
`c_type` TINYINT( 3 ) UNSIGNED NOT NULL DEFAULT '0',
`c_pid` INT( 10 ) UNSIGNED NOT NULL DEFAULT '0',
`c_t_f` INT( 10 ) UNSIGNED NOT NULL DEFAULT '0',
`c_t_r_l` INT( 10 ) UNSIGNED NOT NULL DEFAULT '0',
`c_t_r_r` INT( 10 ) UNSIGNED NOT NULL DEFAULT '0',
`c_t_l` INT( 10 ) UNSIGNED NOT NULL DEFAULT '0',
`c_t_s` INT( 10 ) UNSIGNED NOT NULL DEFAULT '0',
INDEX category_search ( `c_t_f`, `c_t_r_l`, `c_t_r_r`, `c_t_l`, `c_t_s` )
) ENGINE = INNODB CHARACTER SET utf8 COLLATE utf8_unicode_ci;

CREATE TABLE `sim_product` (
`p_id`	INT( 10 ) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY ,
`p_name` VARCHAR( 32 ) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
`p_cid`	SMALLINT( 5 ) UNSIGNED NOT NULL DEFAULT '0',
`p_spid`	SMALLINT( 5 ) UNSIGNED NOT NULL DEFAULT '0',
FOREIGN KEY (`p_cid`) REFERENCES `sim_prod_category`(`c_id`),
FOREIGN KEY (`p_spid`) REFERENCES `sim_prod_sproppackage`(`sppp_id`),
INDEX p_search ( `p_cid` )
) ENGINE = INNODB CHARACTER SET utf8 COLLATE utf8_unicode_ci;

CREATE TABLE `sim_prod_prop` (
`pp_id`	INT( 10 ) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY ,
`pp_name` VARCHAR( 32 ) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
`pp_cid` SMALLINT( 5 ) UNSIGNED NOT NULL DEFAULT '0',
`pp_t_s` INT( 10 ) UNSIGNED NOT NULL DEFAULT '0',
FOREIGN KEY (`pp_cid`) REFERENCES `sim_prod_category`(`c_id`),
INDEX prop_search ( `pp_cid`, `pp_t_s` )
) ENGINE = INNODB CHARACTER SET utf8 COLLATE utf8_unicode_ci;

CREATE TABLE `sim_prod_propval` (
`ppv_id`	INT( 10 ) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY ,
`ppv_val` VARCHAR( 32 ) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
`ppv_pid` INT( 10 ) UNSIGNED NOT NULL DEFAULT '0',
`ppv_t_s` INT( 10 ) UNSIGNED NOT NULL DEFAULT '0',
FOREIGN KEY (`ppv_pid`) REFERENCES `sim_prod_prop`(`pp_id`),
INDEX prop_search ( `ppv_pid`, `ppv_t_s` )
) ENGINE = INNODB CHARACTER SET utf8 COLLATE utf8_unicode_ci;

CREATE TABLE `sim_prod_proplink` (
`ppl_id`	INT( 10 ) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY ,
`ppl_pvid` INT( 10 ) UNSIGNED NOT NULL DEFAULT '0',
`ppl_pid` INT( 10 ) UNSIGNED NOT NULL DEFAULT '0',
FOREIGN KEY (`ppl_pvid`) REFERENCES `sim_prod_propval`(`ppv_id`),
FOREIGN KEY (`ppl_pid`) REFERENCES `sim_product`(`p_id`),
INDEX prop_search ( `ppl_pvid`, `ppl_pid` ),
INDEX p_search ( `ppl_pid` )
) ENGINE = INNODB CHARACTER SET utf8 COLLATE utf8_unicode_ci;



CREATE TABLE `sim_prod_sproplink` (
`sppl_id`	INT( 10 ) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY ,
`sppl_pvid` INT( 10 ) UNSIGNED NOT NULL DEFAULT '0',
`sppl_pid` INT( 10 ) UNSIGNED NOT NULL DEFAULT '0',
FOREIGN KEY (`sppl_pvid`) REFERENCES `sim_prod_spropval`(`sppv_id`),
FOREIGN KEY (`sppl_pid`) REFERENCES `sim_product`(`p_id`),
INDEX sprop_search ( `sppl_pvid`, `sppl_pid` ),
INDEX sp_search ( `sppl_pid` )
) ENGINE = INNODB CHARACTER SET utf8 COLLATE utf8_unicode_ci;




INSERT INTO `sim_prod_sproppackage` ( `sppp_type`,`sppp_name` ) VALUES ( '0','default package' ),
( '1','ÊÖCÙÐÔ' ),( '1','¼ÒëÙÐÔ' );

INSERT INTO `sim_prod_category` ( `c_name`,`c_spec`,`c_type`,`c_pid`,`c_t_f`,`c_t_r_l`,`c_t_r_r` ) VALUES ( 'ÊÖC','ÊÖC·Öî','0','0','1','0','3' ),( 'ÖÇÄÜC','ÊÖC·Öî','0','1','1','1','2' ),
( '¼Òë','¼Òë·Öî','0','0','3','0','1' );

INSERT INTO `sim_product` ( `p_name`,`p_cid`,`p_spid` ) VALUES ( 'ÖZ»ùN95','1','2' ),
( 'ÈÝÂ±ùÏä20L','3','3' ),( 'Ë÷ÄáZ1','2','2' );

INSERT INTO `sim_prod_prop` ( `pp_name`,`pp_cid` ) VALUES ( '·Ö±æÂÊ','1' ),( 'ë³ØÈÝÁ¿','1' ),( 'ÖÆÊ½','1' ),( 'ÌÀíÆ÷','2' ),
( 'Æ·ÅÆ','3' ),( 'ÈÝÁ¿','3' ),( '¶àéT','3' );

INSERT INTO `sim_prod_propval` ( `ppv_val`,`ppv_pid` ) VALUES ( '800X480','1' ),( '1280X720','1' ),( '1920X1080','1' ),
( '1000-1500mah','2' ),( '1500-2000mah','2' ),( '2000-3000mah','2' ),
( 'GSM','3' ),( 'FDD','3' ),( 'LTE','3' ),
( '¸ßÍ¨','4' ),( 'Â°l¿Æ','4' ),( 'ÈAé','4' ),
( 'Î÷éT×Ó','5' ),( 'ÃÀµÄ','5' ),( 'ÈÝÂ','5' ),
( '10-15L','6' ),( '15-20L','6' ),( '20-30L','6' ),
( 'ÎéT','7' ),( 'ëpéT','7' ),( 'ÈýéT','7' );

INSERT INTO `sim_prod_proplink` ( `ppl_pvid`,`ppl_pid` ) VALUES ( '2','1' ),( '6','1' ),( '8','1' ),( '10','3' ),( '8','3' );


SELECT * FROM `sim_prod_category` AS `a` RIGHT JOIN `sim_prod_prop` AS `b` ON `a`.`c_id` = `b`.`pp_cid` WHERE a.`c_t_f` = 1 AND a.`c_t_r_l` > -1 AND a.`c_t_r_r` < 4;
SELECT * FROM `sim_prod_category` AS `a` RIGHT JOIN `sim_prod_prop` AS `b` ON `a`.`c_id` = `b`.`pp_cid` RIGHT JOIN `sim_prod_propval` AS `c` ON `b`.`pp_id` = `c`.`ppv_pid` WHERE a.`c_t_f` = 1 AND a.`c_t_r_l` > -1 AND a.`c_t_r_r` < 4;

SELECT * FROM `sim_prod_category` AS `a` RIGHT JOIN `sim_product`  AS `b` ON `a`.`c_id` = `b`.`p_cid` LEFT JOIN `sim_prod_proplink` AS `c` ON `b`.`p_id` = `c`.`ppl_pid` WHERE a.`c_t_f` = 1 AND a.`c_t_r_l` > -1 AND a.`c_t_r_r` < 4  AND c.`ppl_pvid` in (2);




INSERT INTO `sim_prod_sprop` ( `spp_name`,`spp_pid`,`spp_fid` ) VALUES ( '°æ±¾','2','0' ),( 'îÉ«','2','1' ),( 'ÐÍÌ','3','0' );

INSERT INTO `sim_prod_spropval` ( `sppv_val`,`sppv_spid` ) VALUES ( 'µÍÅä°æ','1' ),( 'ËÊ°æ','1' ),( '¸ßÅä°æ','1' ),
( 'ºÚ','2' ),( 'ãy','2' ),( 'Ãµ¹å½ð','2' ),
( 'TX-021','3' ),( 'TX-031','3' ),( 'TX-051','3' );

INSERT INTO `sim_prod_sproplink` ( `sppl_pvid`,`sppl_pid` ) VALUES ( '2','1' ),( '6','1' ),( '8','1' ),( '10','3' ),( '8','3' );

SELECT * FROM `sim_product` AS `a` RIGHT JOIN `sim_prod_sproppackage` AS `b` ON `a`.`p_spid` = `b`.`sppp_id` RIGHT JOIN `sim_prod_sprop` AS `c` ON `b`.`sppp_id` = `c`.`spp_pid` RIGHT JOIN `sim_prod_spropval` AS `d` ON `c`.`spp_id` = `d`.`sppv_spid` WHERE a.`p_id` = 1;

SELECT * FROM `sim_prod_spropval` WHERE `sppv_spid` = 8 GROUP BY `sppv_val` ORDER BY `sppv_id`;





/*

INSERT INTO `sim_prod_sprop` ( `spp_name`,`spp_pid` ) VALUES ( '°æ±¾','2' ),( 'îÉ«','2' ),( 'ÐÍÌ','3' );

INSERT INTO `sim_prod_spropval` ( `sppv_val`,`sppv_spid`,`sppv_pid` ) VALUES ( 'µÍÅä°æ','1','' ),( 'ËÊ°æ','1' ),( '¸ßÅä°æ','1' ),
( 'ºÚ','2' ),( 'ãy','2' ),( 'Ãµ¹å½ð','2' ),
( 'TX-021','3' ),( 'TX-031','3' ),( 'TX-051','3' );

*/




/*
2?¨¨?art_category¡ê?¡ä?¡ä¡é1y3¨¬
status:0,2?¨¨?¡Á??¦Ì?¨²¦Ì?¨º¡ì¡ã¨¹¡ê???1?
status:1,2?¨¨?¡Á??¦Ì?¨²¦Ì?3¨¦1|¡ê?¡¤¦Ì??2?¨¨?u_id
status:2,???¨²¦Ì?2?¡ä??¨²
status:3,2?¨¨?¡Á??¦Ì?¨²¦Ì?¨º¡ì¡ã¨¹¡ê???1?
status:4,2?¨¨?¡Á¨®?¨²¦Ì?3¨¦1|¡ê?¡¤¦Ì??2?¨¨?u_id
*/
DROP PROCEDURE IF EXISTS insert_prod_category;
DELIMITER //
CREATE PROCEDURE insert_prod_category( IN p_name VARCHAR(32), IN p_spec VARCHAR(255), IN p_type INT(3), IN p_pid INT(10), IN p_t_s INT(10) )
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
	INSERT INTO `sim_prod_category` ( `c_name`,`c_spec`,`c_type`,`c_pid`,`c_t_f`,`c_t_r_l`,`c_t_r_r`,`c_t_l`,`c_t_s` ) VALUES ( p_name, p_spec, p_type, d_pid, d_t_f, d_t_r_l, d_t_r_r, d_t_l, p_t_s);
	SET d_id = LAST_INSERT_ID();
	UPDATE `sim_prod_category` SET `c_t_f` = d_id WHERE `c_id` = d_id;
	IF d_error = 1 THEN
		ROLLBACK;
		SELECT d_status AS `status`;
	ELSE
		COMMIT;
		SET d_status = 1;
		SELECT d_status AS `status`, d_id AS `c_id`;
	END IF;
ELSE
	SELECT `c_t_f`, `c_t_r_l`, `c_t_r_r`, `d_t_l`, COUNT(*) INTO d_t_f, d_t_r_l, d_t_r_r, d_t_l, d_count FROM `sim_prod_category` WHERE `c_id` = p_pid;
	IF d_count = 0 THEN
		SET d_status = 2;
		SELECT d_status AS `status`;
	ELSE	
		SET d_t_r_l = d_t_r_r;
		SET d_t_r_r = d_t_r_r + 1;
		SET d_t_l = d_t_l + 1;
		START TRANSACTION;
		UPDATE `sim_prod_category` SET `c_t_r_l` = `c_t_r_l` + 2 WHERE `c_t_f` = d_t_f AND `c_t_r_l` > d_t_r_l;
		SET d_t_l = d_t_l - 1;
		UPDATE `sim_prod_category` SET `c_t_r_r` = `c_t_r_r` + 2 WHERE `c_t_f` = d_t_f AND `c_t_r_r` >= d_t_r_l;
		SET d_t_l = d_t_l + 1;
		INSERT INTO `sim_prod_category` ( `c_name`,`c_spec`,`c_type`,`c_pid`,`c_t_f`,`c_t_r_l`,`c_t_r_r`,`c_t_l`,`c_t_s` ) VALUES ( p_name, p_spec, p_type, p_pid, d_t_f, d_t_r_l, d_t_r_r, d_t_l, p_t_s);
		SET d_id = LAST_INSERT_ID();
		IF d_error = 1 THEN
			ROLLBACK;
			SET d_status = 3;
			SELECT d_status AS `status`;
		ELSE
			COMMIT;
			SET d_status = 4;
			SELECT d_status AS `status`, d_id AS `c_id`;
		END IF;
	END IF;
END IF;
END
//
DELIMITER ;
call insert_prod_category('category_1', 'spec', '0', '0', '0');



/*
art_category¨¦?3y¡ä?¡ä¡é1y3¨¬
status:0,?¨²¦Ì?2?¡ä??¨²
status:1,?¡äDD¨º¡ì¡ã¨¹¡ê???1?
status:2,?¡äDD3¨¦1|¡ê?¡¤¦Ì??¨®¡ã?¨¬DD¨ºyeffect
*/
DROP PROCEDURE IF EXISTS drop_art_category;
DELIMITER //
CREATE PROCEDURE drop_prod_category( IN p_id INT(10) )
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
SELECT `c_t_f`, `c_t_r_l`, `c_t_r_r`, `c_t_l`, COUNT(*) INTO d_t_f, d_t_r_l, d_t_r_r, d_t_l, d_count FROM `sim_prod_category` WHERE `c_id` = p_id;
IF d_count = 1 THEN
SET d_offset = d_t_r_r - d_t_r_l + 1;
START TRANSACTION;
IF d_offset = 2 THEN
DELETE FROM `sim_prod_category` WHERE `c_id` = p_id;
ELSE
DELETE FROM `sim_prod_category` WHERE `c_t_f` = d_t_f AND `c_t_r_l` >= d_t_r_l AND `c_t_r_r` <= d_t_r_r;
END IF;
SET d_effect = ROW_COUNT();
UPDATE `sim_prod_category` SET `c_t_r_l` = `c_t_r_l` - d_offset WHERE `c_t_f` = d_t_f AND `c_t_r_l` > d_t_r_l;
UPDATE `sim_prod_category` SET `c_t_r_r` = `c_t_r_r` - d_offset WHERE `c_t_f` = d_t_f AND `c_t_r_r` > d_t_r_r;
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
call drop_prod_category( 2 ); 
