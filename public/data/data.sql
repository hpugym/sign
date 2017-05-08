1.建表

DROP TABLE IF EXISTS `sign_courses`;
CREATE TABLE `sign_courses` (
  `course_num` char(9) NOT NULL COMMENT '课程号',
  `course_name` varchar(255) NOT NULL COMMENT '课程名称',
  `course_type` varchar(60) NOT NULL COMMENT '课程属性',
  `course_intro` varchar(255) NOT NULL COMMENT '课程简介',
  PRIMARY KEY (`course_num`)
) ENGINE=INNODB DEFAULT CHARSET=utf8 COMMENT='课程信息表';


DROP TABLE IF EXISTS `sign_mycourses`;
CREATE TABLE `sign_mycourses` (
  `mycourse_id` int(255) NOT NULL AUTO_INCREMENT,
  `teachs_code` char(64) NOT NULL COMMENT '课程标识码',
  `stu_openid` char(28) NOT NULL COMMENT '学生微信openid',
  `mycourse_sign` int(4) NOT NULL DEFAULT '0' COMMENT '签到次数',
  `mycourse_get` int(4) NOT NULL DEFAULT '0' COMMENT '出勤次数',
  `mycourse_leave` int(4) NOT NULL DEFAULT '0' COMMENT '请假次数',
  `mycourse_lost` int(4) NOT NULL DEFAULT '0' COMMENT '缺勤次数',
  PRIMARY KEY (`mycourse_id`)
) ENGINE=INNODB DEFAULT CHARSET=utf8 COMMENT='学生选课表';



DROP TABLE IF EXISTS `sign_qrcode`;
CREATE TABLE `sign_qrcode` (
  `qrcode_code` char(64) NOT NULL COMMENT '签到标识码',
  `teachs_code` int(255) NOT NULL COMMENT '二维码场景id',
  `teach_id` char(9) NOT NULL COMMENT '教师号',
  `qrcode_add` varchar(255) NOT NULL COMMENT '签到地点',
  `qrcode_time` int(10) NOT NULL COMMENT '签到时间',
  PRIMARY KEY (`qrcode_code`)
) ENGINE=INNODB DEFAULT CHARSET=utf8 COMMENT='二维码信息表';




DROP TABLE IF EXISTS `sign_signs`;
CREATE TABLE `sign_signs` (
  `signs_id` bigint(255) NOT NULL AUTO_INCREMENT,
  `stu_openid` char(28) NOT NULL COMMENT '学生微信openid',
  `teachs_code` int(255) NOT NULL COMMENT '课程标识码',
  `qrcode_code` char(64) NOT NULL COMMENT '签到标识码',
  `signs_status` char(40) NOT NULL COMMENT '签到状态',
  `qrcode_time` int(10) NOT NULL COMMENT '开签时间',
  `signs_time` int(10) NOT NULL COMMENT '签到时间',
  PRIMARY KEY (`signs_id`)
) ENGINE=INNODB DEFAULT CHARSET=utf8 COMMENT='签到信息表';



DROP TABLE IF EXISTS `sign_students`;
CREATE TABLE `sign_students` (
  `stu_num` char(12) NOT NULL COMMENT '学号',
  `stu_openid` char(28) DEFAULT NULL COMMENT '微信openid',
  `stu_name` varchar(16) NOT NULL COMMENT '学生姓名',
  `stu_sex` varchar(4) NOT NULL COMMENT '学生性别',
  `stu_class` varchar(255) NOT NULL COMMENT '专业班级',
  `stu_college` varchar(255) NOT NULL COMMENT '学院',
  `stu_image` varchar(255) DEFAULT NULL COMMENT '学生微信头像',
  `stu_phone` char(11) DEFAULT NULL COMMENT '学生手机号',
  PRIMARY KEY (`stu_num`)
) ENGINE=INNODB DEFAULT CHARSET=utf8 COMMENT='学生信息表';



DROP TABLE IF EXISTS `sign_teachers`;
CREATE TABLE `sign_teachers` (
  `teach_id` char(9) NOT NULL COMMENT '教工号',
  `teach_name` varchar(20) NOT NULL COMMENT '教师姓名',
  `teach_sex` char(4) NOT NULL COMMENT '教师性别',
  `teach_level` varchar(100) NOT NULL COMMENT '教师职称',
  `teach_college` varchar(255) DEFAULT NULL COMMENT '教师学院',
  `teach_depart` varchar(255) DEFAULT NULL COMMENT '教师系别',
  `teach_image` varchar(255) DEFAULT NULL COMMENT '教师头像',
  `teach_phone` char(11) DEFAULT NULL COMMENT '手机号',
  `teach_add` varchar(255) DEFAULT NULL COMMENT '办公地址',
  PRIMARY KEY (`teach_id`)
) ENGINE=INNODB DEFAULT CHARSET=utf8 COMMENT='教师信息表';

DROP TABLE IF EXISTS `sign_teachs`;
CREATE TABLE `sign_teachs` (
  `teachs_code` int(255) NOT NULL AUTO_INCREMENT COMMENT '课程标识码',
  `course_num` char(9) NOT NULL COMMENT '课程号',
  `teach_id` char(9) NOT NULL COMMENT '教师号',
  `teachs_time` int(3) NOT NULL COMMENT '课程学时',
  `teachs_grade` int(2) NOT NULL COMMENT '课程学分',
  `teachs_stu` varchar(100) NOT NULL COMMENT '授课集体',
  `teachs_add` varchar(255) NOT NULL COMMENT '上课时间地点',
  `teachs_avai` int(3) NOT NULL COMMENT '课程容量',
  PRIMARY KEY (`teachs_code`)
) ENGINE=INNODB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COMMENT='教师课程表';


DROP TABLE IF EXISTS `sign_users`;
CREATE TABLE `sign_users` (
  `user_id` int(6) NOT NULL AUTO_INCREMENT,
  `user_pass` char(64) NOT NULL DEFAULT 'e10adc3949ba59abbe56e057f20f883e' COMMENT '用户密码(123456)',
  `user_type` int(1)  NOT NULL DEFAULT '1' COMMENT '用户类型',
  `user_mail` varchar(120) DEFAULT NULL COMMENT '用户邮箱',
  `user_created` int(10) NOT NULL COMMENT '注册时间',
  `user_action` int(10) NOT NULL COMMENT '最近操作时间',
  PRIMARY KEY (`user_id`)
) ENGINE=INNODB AUTO_INCREMENT=100000 DEFAULT CHARSET=utf8 COMMENT='系统用户表';

DROP TABLE IF EXISTS `sign_locals`;
CREATE TABLE `sign_locals` (
  `local_id` VARCHAR(10) NOT NULL COMMENT '教学楼编号',
  `local_college` varchar(120) NOT NULL COMMENT'教学楼名称',
  `local_lon` decimal(65,6) NOT NULL COMMENT '经度坐标',
  `local_lat` decimal(65,6) NOT NULL COMMENT '维度坐标',
  `local_created` int(10) NOT NULL COMMENT '创建时间',
  PRIMARY KEY (`local_id`)
) ENGINE=INNODB DEFAULT CHARSET=utf8 COMMENT='教学楼经纬度信息表';

DROP TABLE IF EXISTS `sign_wechats`;
CREATE TABLE `sign_wechats` (
  `wechat_openid` int(2) NOT NULL COMMENT '微信openid',
  `wechat_lon` decimal(65,10) NOT NULL DEFAULT 0.0000000000 COMMENT '经度坐标',
  `wechat_lat` decimal(65,10) NOT NULL DEFAULT 0.0000000000 COMMENT '维度坐标',
  `wechat_created` int(10) NOT NULL COMMENT DEFAULT 0 '创建时间',
  PRIMARY KEY (`wechat_openid`)
) ENGINE=INNODB DEFAULT CHARSET=utf8 COMMENT='学生临时位置信息表';


DROP TABLE IF EXISTS `sign_notices`;
CREATE TABLE `sign_notices` (
  `notice_id` int(255) NOT NULL AUTO_INCREMENT,
  `notice_title` char(128) NOT NULL COMMENT '公告标题',
  `notice_content` int(1)  NOT NULL COMMENT '公告内容',
  `notice_time` int(10) NOT NULL COMMENT '发布时间',
  PRIMARY KEY (`notice_id`)
) ENGINE=INNODB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COMMENT='公告消息表';


DROP TABLE IF EXISTS `sign_messages`;
CREATE TABLE `sign_messages` (
  `message_id` int(255) NOT NULL AUTO_INCREMENT,
  `message_to` int(6) NOT NULL COMMENT '消息接受者',
  `message_status` int(6) NOT NULL COMMENT '消息状态',
  `message_title` char(128) NOT NULL COMMENT '消息标题',
  `message_content` int(1)  NOT NULL COMMENT '消息内容',
  `message_time` int(10) NOT NULL COMMENT '消息时间',
  PRIMARY KEY (`message_id`)
) ENGINE=INNODB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COMMENT='消息表';

2.增加外键

alter table `sign_signs` add CONSTRAINT `FK_teachs_code` FOREIGN key(`teachs_code`) REFERENCES `sign_teachs`(`teachs_code`);
alter table `sign_signs` add CONSTRAINT `FK_qrcode_code`FOREIGN key(`qrcode_code`) REFERENCES `sign_qrcode`(`qrcode_code`);
alter table `sign_qrcode` add CONSTRAINT `FK_teach_id` FOREIGN key(`teach_id`) REFERENCES `sign_teachers`(`teach_id`);
alter table `sign_qrcode` add CONSTRAINT `FK_teachs_code` FOREIGN key(`teachs_code`) REFERENCES `sign_teachs`(`teachs_code`);
alter table `sign_mycourses` add CONSTRAINT `FK_teachs_code` FOREIGN key(`teachs_code`) REFERENCES `sign_teachs`(`teachs_code`);
alter table `sign_teachs` add CONSTRAINT `FK_course_num` FOREIGN key(`course_num`) REFERENCES `sign_courses`(`course_num`);
alter table `sign_teachs` add  CONSTRAINT `FK_teach_id` FOREIGN key(`teach_id`) REFERENCES `sign_teachers`(`teach_id`);


3.视图

CREATE
VIEW `sign_tc`AS
SELECT
sign_teachs.teachs_code AS tc_teachs_code,
MD5(sign_teachs.teachs_code) AS tc_teachs_code_md5,
sign_teachs.teach_id AS tc_teach_id,
sign_teachs.teachs_time AS tc_teachs_time,
sign_teachs.teachs_grade AS tc_teachs_grade,
sign_teachs.teachs_stu AS tc_teachs_stu,
sign_teachs.teachs_add AS tc_teachs_add,
sign_teachs.teachs_avai AS tc_teachs_avai,
sign_teachs.teachs_status AS tc_teachs_status,
sign_courses.course_num AS tc_course_num,
sign_courses.course_name AS tc_course_name,
sign_courses.course_type AS tc_course_type,
sign_courses.course_intro AS tc_course_intro
FROM
sign_courses ,
sign_teachs
WHERE
sign_courses.course_num = sign_teachs.course_num
ORDER BY
tc_course_num ASC ;



CREATE
VIEW `sign_cs`AS
SELECT
sign_mycourses.mycourse_id AS cs_mycourse_id,
sign_mycourses.teachs_code AS cs_teachs_code,
sign_students.stu_num AS cs_stu_num,
sign_mycourses.stu_openid AS cs_stu_openid,
sign_students.stu_name AS cs_stu_name,
sign_students.stu_sex AS cs_stu_sex,
sign_students.stu_class AS cs_stu_class,
sign_students.stu_college AS cs_stu_college,
sign_students.stu_image AS cs_stu_image,
sign_students.stu_phone AS cs_stu_phone,
sign_mycourses.mycourse_sign AS cs_mycourse_sign,
sign_mycourses.mycourse_get AS cs_mycourse_get,
sign_mycourses.mycourse_leave AS cs_mycourse_leave,
sign_mycourses.mycourse_lost AS cs_mycourse_lost
FROM
sign_mycourses ,
sign_students
WHERE
sign_mycourses.stu_openid = sign_students.stu_openid
ORDER BY
cs_mycourse_id ASC ;


SELECT sign_signs.qrcode_code ,sign_qrcode.qrcode_add, sign_qrcode.qrcode_time from sign_signs ,sign_qrcode where teachs_code = 1 and sign_signs.qrcode_code = sign_qrcode.qrcode_code GROUP BY sign_signs.qrcode_code

select `sign_signs`.`signs_time` ,`sign_courses`.`course_name`, `sign_teachers`.`teach_name`, `sign_qrcode`.`qrcode_add`,`sign_teachs`.`teachs_status` from `sign_signs`, `sign_teachs` ,`sign_courses`,`sign_teachers`,`sign_qrcode`
        where(`sign_signs`.`stu_openid` = "otcDdwbEo8EHGV7u2QcKU3TNdXzU"
        and `sign_teachs`.`course_num` = `sign_courses`.`course_num`
        and `sign_signs`.`teachs_code` = `sign_teachs`.`teachs_code`
        and `sign_teachs`.`teach_id` = `sign_teachers`.`teach_id`
        and `sign_signs`.`qrcode_code` = `sign_qrcode`.`qrcode_code`)



SELECT
                     `sign_teachs`.`course_num` as `course_num`,
                     `sign_courses`.`course_name` as `course_name`,
                     `sign_teachers`.`teach_name` as `teach_name`,
                     `sign_teachs`.`teachs_time` as `teachs_time`,
                     `sign_teachs`.`teachs_grade` as `teachs_grade`,
                     `sign_teachers`.`teach_phone` as `teach_phone`,
                     `sign_signs`.`teachs_code` as `teachs_code`,
                     `sign_teachs`.`teachs_status` as `teachs_status`
FROM `sign_signs`, `sign_teachs`,`sign_teachers`,`sign_courses`
WHERE
										`sign_signs`.`stu_openid` = 'otcDdwbEo8EHGV7u2QcKU3TNdXzU' AND
                    `sign_signs`.`teachs_code` = `sign_teachs`.`teachs_code` AND
                    `sign_teachs`.`teach_id` = `sign_teachers`.`teach_id` AND
                    `sign_teachs`.`course_num` = `sign_courses`.`course_num`
GROUP BY
sign_signs.teachs_code
ORDER BY
                    `sign_teachs`.`course_num` ASC

