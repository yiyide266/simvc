DROP TABLE `sim_art_taglink`;
DROP TABLE `sim_article`;
DROP TABLE `sim_art_tag`;
DROP TABLE `sim_art_category`;

CREATE TABLE `sim_art_category` (
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

CREATE TABLE `sim_art_tag` (
`t_id` SMALLINT( 5 ) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY ,
`t_name` VARCHAR( 32 ) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL
) ENGINE = INNODB CHARACTER SET utf8 COLLATE utf8_unicode_ci;


CREATE TABLE `sim_article` (
`a_id` INT( 10 ) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY ,
`a_title` VARCHAR( 255 ) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL ,
`a_content` TEXT CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL ,
`a_pub_time` INT( 10 ) UNSIGNED NOT NULL DEFAULT '0',
`a_pub_dpt` VARCHAR( 32 ) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL ,
`a_pub_author` VARCHAR( 32 ) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL ,
`a_creat_time` INT( 10 ) UNSIGNED NOT NULL DEFAULT '0',
`a_creat_uid` INT( 10 ) UNSIGNED NOT NULL DEFAULT '0',
`a_update_time` INT( 10 ) UNSIGNED NOT NULL DEFAULT '0',
`a_cid` SMALLINT( 5 ) UNSIGNED NOT NULL DEFAULT '0',
`a_sort` INT( 10 ) UNSIGNED NOT NULL DEFAULT '0',
FOREIGN KEY (`a_creat_uid`) REFERENCES `sim_users`(`u_id`),
FOREIGN KEY (`a_cid`) REFERENCES `sim_art_category`(`c_id`),
INDEX a_search ( `a_title`(10) ),
INDEX a_search_2 ( `a_cid` )
) ENGINE = INNODB CHARACTER SET utf8 COLLATE utf8_unicode_ci;

CREATE TABLE `sim_art_taglink` (
`tl_id` SMALLINT( 5 ) UNSIGNED AUTO_INCREMENT NOT NULL PRIMARY KEY ,
`t_id` SMALLINT( 5 ) UNSIGNED NOT NULL ,
`a_id` INT( 10 ) UNSIGNED NOT NULL ,
FOREIGN KEY (`t_id`) REFERENCES `sim_art_tag`(`t_id`),
FOREIGN KEY (`a_id`) REFERENCES `sim_article`(`a_id`)
) ENGINE = INNODB CHARACTER SET utf8 COLLATE utf8_unicode_ci;



INSERT INTO `sim_art_tag` ( `t_name` )
VALUES( 'tag_1' ),
( 'tag_2' );

INSERT INTO `sim_art_category` ( `c_name`,`c_spec`,`c_type`,`c_pid`,`c_t_f`,`c_t_r_l`,`c_t_r_r`,`c_t_l`,`c_t_s` )
VALUES( 'category_1','spec',0,0,1,0,3,0,0 ),
( 'category_2','spec',0,0,2,0,1,0,0 ),
( 'category_3','spec',0,0,3,0,1,0,0 ),
( 'category_1_1','spec',0,0,1,1,2,0,0 );

INSERT INTO `sim_article` ( `a_title`,`a_content`,`a_pub_time`,`a_pub_dpt`,`a_pub_author`,`a_creat_time`,`a_creat_uid`,`a_update_time`,`a_cid`,`a_sort` )
VALUES( 'article_1','content',0,'dpt','author',0,1,0,1,0 ),
( 'article_2','content',0,'dpt','author',0,1,0,1,0 ),
( 'article_3','content',0,'dpt','author',0,1,0,3,0 ),
( 'article_4','content',0,'dpt','author',0,1,0,3,0 ),
( 'article_5','content',0,'dpt','author',0,1,0,3,0 ),
( 'article_6','content',0,'dpt','author',0,1,0,4,0 );

INSERT INTO `sim_art_taglink` ( `t_id`,`a_id` )
VALUES( 2,2 ),
( 2,3 ),
( 2,4 ),
( 1,6 );

SELECT * FROM `sim_art_category` AS a RIGHT JOIN `sim_article` AS b ON a.`c_id` = b.`a_cid` WHERE a.`c_t_f` = 1 AND a.`c_t_r_l` > -1 AND a.`c_t_r_r` < 4;

SELECT * FROM `sim_art_category` AS a RIGHT JOIN `sim_article` AS b ON a.`c_id` = b.`a_cid` RIGHT JOIN `sim_art_taglink` AS c ON b.`a_id` = c.`a_id` WHERE a.`c_t_f` = 1 AND a.`c_t_r_l` > -1 AND a.`c_t_r_r` < 4 AND c.`t_id` = 2;

SELECT * FROM `sim_art_category` AS a RIGHT JOIN `sim_article` AS b ON a.`c_id` = b.`a_cid` RIGHT JOIN `sim_art_taglink` AS c ON b.`a_id` = c.`a_id` WHERE a.`c_t_f` = 1 AND a.`c_t_r_l` > -1 AND a.`c_t_r_r` < 4 AND c.`t_id` in (1,2);



/*
²åÈëart_category£¬´æ´¢¹ý³Ì
status:0,²åÈë×æÏµ½ÚµãÊ§°Ü£¬»Ø¹ö
status:1,²åÈë×æÏµ½Úµã³É¹¦£¬·µ»Ø²åÈëu_id
status:2,¸¸½Úµã²»´æÔÚ
status:3,²åÈë×æÏµ½ÚµãÊ§°Ü£¬»Ø¹ö
status:4,²åÈë×Ó½Úµã³É¹¦£¬·µ»Ø²åÈëu_id
*/
DROP PROCEDURE IF EXISTS insert_art_category;
DELIMITER //
CREATE PROCEDURE insert_art_category( IN p_name VARCHAR(32), IN p_spec VARCHAR(255), IN p_type INT(3), IN p_pid INT(10), IN p_t_s INT(10) )
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
	INSERT INTO `sim_art_category` ( `c_name`,`c_spec`,`c_type`,`c_pid`,`c_t_f`,`c_t_r_l`,`c_t_r_r`,`c_t_l`,`c_t_s` ) VALUES ( p_name, p_spec, p_type, d_pid, d_t_f, d_t_r_l, d_t_r_r, d_t_l, p_t_s);
	SET d_id = LAST_INSERT_ID();
	UPDATE `sim_art_category` SET `c_t_f` = d_id WHERE `c_id` = d_id;
	IF d_error = 1 THEN
		ROLLBACK;
		SELECT d_status AS `status`;
	ELSE
		COMMIT;
		SET d_status = 1;
		SELECT d_status AS `status`, d_id AS `c_id`;
	END IF;
ELSE
	SELECT `c_t_f`, `c_t_r_l`, `c_t_r_r`, `d_t_l`, COUNT(*) INTO d_t_f, d_t_r_l, d_t_r_r, d_t_l, d_count FROM `sim_art_category` WHERE `c_id` = p_pid;
	IF d_count = 0 THEN
		SET d_status = 2;
		SELECT d_status AS `status`;
	ELSE	
		SET d_t_r_l = d_t_r_r;
		SET d_t_r_r = d_t_r_r + 1;
		SET d_t_l = d_t_l + 1;
		START TRANSACTION;
		UPDATE `sim_art_category` SET `c_t_r_l` = `c_t_r_l` + 2 WHERE `c_t_f` = d_t_f AND `c_t_r_l` > d_t_r_l;
		SET d_t_l = d_t_l - 1;
		UPDATE `sim_art_category` SET `c_t_r_r` = `c_t_r_r` + 2 WHERE `c_t_f` = d_t_f AND `c_t_r_r` >= d_t_r_l;
		SET d_t_l = d_t_l + 1;
		INSERT INTO `sim_art_category` ( `c_name`,`c_spec`,`c_type`,`c_pid`,`c_t_f`,`c_t_r_l`,`c_t_r_r`,`c_t_l`,`c_t_s` ) VALUES ( p_name, p_spec, p_type, p_pid, d_t_f, d_t_r_l, d_t_r_r, d_t_l, p_t_s);
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
call insert_art_category('category_1', 'spec', '0', '0', '0');


/*
art_categoryÉ¾³ý´æ´¢¹ý³Ì
status:0,½Úµã²»´æÔÚ
status:1,Ö´ÐÐÊ§°Ü£¬»Ø¹ö
status:2,Ö´ÐÐ³É¹¦£¬·µ»ØÓ°ÏìÐÐÊýeffect
*/
DROP PROCEDURE IF EXISTS drop_art_category;
DELIMITER //
CREATE PROCEDURE drop_art_category( IN p_id INT(10) )
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
SELECT `c_t_f`, `c_t_r_l`, `c_t_r_r`, `c_t_l`, COUNT(*) INTO d_t_f, d_t_r_l, d_t_r_r, d_t_l, d_count FROM `sim_art_category` WHERE `c_id` = p_id;
IF d_count = 1 THEN
SET d_offset = d_t_r_r - d_t_r_l + 1;
START TRANSACTION;
IF d_offset = 2 THEN
DELETE FROM `sim_art_category` WHERE `c_id` = p_id;
ELSE
DELETE FROM `sim_art_category` WHERE `c_t_f` = d_t_f AND `c_t_r_l` >= d_t_r_l AND `c_t_r_r` <= d_t_r_r;
END IF;
SET d_effect = ROW_COUNT();
UPDATE `sim_art_category` SET `c_t_r_l` = `c_t_r_l` - d_offset WHERE `c_t_f` = d_t_f AND `c_t_r_l` > d_t_r_l;
UPDATE `sim_art_category` SET `c_t_r_r` = `c_t_r_r` - d_offset WHERE `c_t_f` = d_t_f AND `c_t_r_r` > d_t_r_r;
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
call drop_art_category( 2 ); 





/*article comment*/
CREATE TABLE `sim_art_comment` (
`c_id`	SMALLINT( 5 ) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY ,
`c_aid` INT( 10 ) UNSIGNED NOT NULL DEFAULT '0',
`c_uid` INT( 10 ) UNSIGNED NOT NULL DEFAULT '0',
`c_content` TEXT CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
`c_comment_time` INT( 10 ) UNSIGNED NOT NULL DEFAULT '0',
`c_status` TINYINT( 3 ) UNSIGNED NOT NULL DEFAULT '0',
`c_pid` INT( 10 ) UNSIGNED NOT NULL DEFAULT '0',
`c_t_f` INT( 10 ) UNSIGNED NOT NULL DEFAULT '0',
`c_t_r_l` INT( 10 ) UNSIGNED NOT NULL DEFAULT '0',
`c_t_r_r` INT( 10 ) UNSIGNED NOT NULL DEFAULT '0',
`c_t_l` INT( 10 ) UNSIGNED NOT NULL DEFAULT '0',
`c_t_s` INT( 10 ) UNSIGNED NOT NULL DEFAULT '0',
FOREIGN KEY (`c_uid`) REFERENCES `sim_users`(`u_id`),
FOREIGN KEY (`c_aid`) REFERENCES `sim_article`(`a_id`),
INDEX comment_search ( `c_t_f`, `c_t_r_l`, `c_t_r_r`, `c_t_l`, `c_t_s` )
) ENGINE = INNODB CHARACTER SET utf8 COLLATE utf8_unicode_ci;

CREATE TABLE `sim_art_comment_unread` (
`cu_id`	SMALLINT( 5 ) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY ,
`c_id` INT( 10 ) UNSIGNED NOT NULL DEFAULT '0',
`u_id` INT( 10 ) UNSIGNED NOT NULL DEFAULT '0',
FOREIGN KEY (`c_id`) REFERENCES `sim_art_comment`(`c_id`),
FOREIGN KEY (`u_id`) REFERENCES `sim_users`(`u_id`),
INDEX comment_unread_search ( `c_id`, `u_id` )
) ENGINE = INNODB CHARACTER SET utf8 COLLATE utf8_unicode_ci;


/*
²åÈëart_comment£¬´æ´¢¹ý³Ì
status:0,²åÈë×æÏµ½ÚµãÊ§°Ü£¬»Ø¹ö
status:1,²åÈë×æÏµ½Úµã³É¹¦£¬·µ»Ø²åÈëu_id
status:2,¸¸½Úµã²»´æÔÚ
status:3,²åÈë×æÏµ½ÚµãÊ§°Ü£¬»Ø¹ö
status:4,²åÈë×Ó½Úµã³É¹¦£¬·µ»Ø²åÈëu_id
*/
DROP PROCEDURE IF EXISTS insert_art_comment;
DELIMITER //
CREATE PROCEDURE insert_art_comment( IN p_aid INT(10),IN p_uid INT(10),IN p_content VARCHAR(1000), IN p_comment_time INT(10), IN p_status INT(3), IN p_pid INT(10), IN p_t_s INT(10) )
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
	INSERT INTO `sim_art_comment` ( `c_aid`,`c_uid`,`c_content`,`c_comment_time`,`c_status`,`c_pid`,`c_t_f`,`c_t_r_l`,`c_t_r_r`,`c_t_l`,`c_t_s` ) VALUES ( p_aid, p_uid, p_content, p_comment_time, p_status, d_pid, d_t_f, d_t_r_l, d_t_r_r, d_t_l, p_t_s);
	SET d_id = LAST_INSERT_ID();
	UPDATE `sim_art_comment` SET `c_t_f` = d_id WHERE `c_id` = d_id;
	IF d_error = 1 THEN
		ROLLBACK;
		SELECT d_status AS `status`;
	ELSE
		COMMIT;
		SET d_status = 1;
		SELECT d_status AS `status`, d_id AS `c_id`;
	END IF;
ELSE
	SELECT `c_t_f`, `c_t_r_l`, `c_t_r_r`, `d_t_l`, COUNT(*) INTO d_t_f, d_t_r_l, d_t_r_r, d_t_l, d_count FROM `sim_art_comment` WHERE `c_id` = p_pid;
	IF d_count = 0 THEN
		SET d_status = 2;
		SELECT d_status AS `status`;
	ELSE	
		SET d_t_r_l = d_t_r_r;
		SET d_t_r_r = d_t_r_r + 1;
		SET d_t_l = d_t_l + 1;
		START TRANSACTION;
		UPDATE `sim_art_comment` SET `c_t_r_l` = `c_t_r_l` + 2 WHERE `c_t_f` = d_t_f AND `c_t_r_l` > d_t_r_l;
		SET d_t_l = d_t_l - 1;
		UPDATE `sim_art_comment` SET `c_t_r_r` = `c_t_r_r` + 2 WHERE `c_t_f` = d_t_f AND `c_t_r_r` >= d_t_r_l;
		SET d_t_l = d_t_l + 1;
		INSERT INTO `sim_art_comment` ( `c_aid`,`c_uid`,`c_content`,`c_comment_time`,`c_status`,`c_pid`,`c_t_f`,`c_t_r_l`,`c_t_r_r`,`c_t_l`,`c_t_s` ) VALUES ( p_aid, p_uid, p_content, p_comment_time, p_status, p_pid, d_t_f, d_t_r_l, d_t_r_r, d_t_l, p_t_s);
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
call insert_art_comment('1', '1', 'comment_1', '0', '1', '0', '0');

/*
art_commentÉ¾³ý´æ´¢¹ý³Ì
status:0,½Úµã²»´æÔÚ
status:1,Ö´ÐÐÊ§°Ü£¬»Ø¹ö
status:2,Ö´ÐÐ³É¹¦£¬·µ»ØÓ°ÏìÐÐÊýeffect
*/
DROP PROCEDURE IF EXISTS drop_art_comment;
DELIMITER //
CREATE PROCEDURE drop_art_comment( IN p_id INT(10) )
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
SELECT `c_t_f`, `c_t_r_l`, `c_t_r_r`, `c_t_l`, COUNT(*) INTO d_t_f, d_t_r_l, d_t_r_r, d_t_l, d_count FROM `sim_art_comment` WHERE `c_id` = p_id;
IF d_count = 1 THEN
SET d_offset = d_t_r_r - d_t_r_l + 1;
START TRANSACTION;
IF d_offset = 2 THEN
DELETE FROM `sim_art_comment` WHERE `c_id` = p_id;
ELSE
DELETE FROM `sim_art_comment` WHERE `c_t_f` = d_t_f AND `c_t_r_l` >= d_t_r_l AND `c_t_r_r` <= d_t_r_r;
END IF;
SET d_effect = ROW_COUNT();
UPDATE `sim_art_comment` SET `c_t_r_l` = `c_t_r_l` - d_offset WHERE `c_t_f` = d_t_f AND `c_t_r_l` > d_t_r_l;
UPDATE `sim_art_comment` SET `c_t_r_r` = `c_t_r_r` - d_offset WHERE `c_t_f` = d_t_f AND `c_t_r_r` > d_t_r_r;
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
call drop_art_comment( 2 );
