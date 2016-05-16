DROP TABLE IF EXISTS `sim_prod_proplink`;
DROP TABLE IF EXISTS `sim_prod_propval`;
DROP TABLE IF EXISTS `sim_prod_prop`;
DROP TABLE IF EXISTS `sim_product`;
DROP TABLE IF EXISTS `sim_prod_category`;


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
FOREIGN KEY (`p_cid`) REFERENCES `sim_prod_category`(`c_id`),
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



INSERT INTO `sim_prod_category` ( `c_name`,`c_spec`,`c_type`,`c_pid`,`c_t_f`,`c_t_r_l`,`c_t_r_r` ) VALUES ( 'ÊÖC','ÊÖC·Öî','0','0','1','0','3' ),( 'ÖÇÄÜC','ÊÖC·Öî','0','1','1','1','2' ),
( '¼Òë','¼Òë·Öî','0','0','3','0','1' );

INSERT INTO `sim_product` ( `p_name`,`p_cid` ) VALUES ( 'ÖZ»ùN95','1' ),
( 'ÈÝÂ±ùÏä20L','3' ),( 'Ë÷ÄáZ1','2' );

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
/*
îÉ«£º°×  Ë{   ¼t
³ß´ç£º S    X    XL


*/
