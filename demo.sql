/*
 Navicat Premium Data Transfer

 Source Server         : 本地数据库
 Source Server Type    : MySQL
 Source Server Version : 50721
 Source Host           : localhost
 Source Database       : demo

 Target Server Type    : MySQL
 Target Server Version : 50721
 File Encoding         : utf-8

 Date: 03/12/2018 10:20:12 AM
*/

SET NAMES utf8;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
--  Table structure for `cs_token`
-- ----------------------------
DROP TABLE IF EXISTS `cs_token`;
CREATE TABLE `cs_token` (
  `cs_id` char(64) NOT NULL COMMENT '主键ID',
  `cs_user_id` char(64) NOT NULL COMMENT '用户ID',
  `cs_token` char(64) NOT NULL COMMENT '用户登陆身份令牌Token',
  `cs_expire_time` datetime NOT NULL COMMENT 'Token过期时间',
  `cs_login_ip` char(128) DEFAULT NULL COMMENT '登陆IP地址',
  `cs_modify_time` datetime DEFAULT NULL,
  `cs_create_time` datetime DEFAULT NULL,
  PRIMARY KEY (`cs_id`),
  KEY `index_user_id` (`cs_user_id`) USING BTREE COMMENT '用户ID'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='用户Token令牌表';

-- ----------------------------
--  Records of `cs_token`
-- ----------------------------
BEGIN;
INSERT INTO `cs_token` VALUES ('T15206903926069663237627714087026', '001', '183fe59298c4cb33d23d30b275dea6e7', '2018-03-13 02:13:31', '127.0.0.1', '2018-03-12 02:13:31', '2018-03-10 13:59:52');
COMMIT;

-- ----------------------------
--  Table structure for `cs_user`
-- ----------------------------
DROP TABLE IF EXISTS `cs_user`;
CREATE TABLE `cs_user` (
  `cs_id` char(64) NOT NULL COMMENT '用户ID，主键ID',
  `cs_user_account` char(64) NOT NULL COMMENT '用户登陆帐号',
  `cs_user_name` varchar(128) DEFAULT NULL COMMENT '用户名称',
  `cs_user_pw` char(64) NOT NULL COMMENT '用户登陆密码',
  `cs_user_birth` date DEFAULT NULL COMMENT '用户出生日期',
  `cs_modify_time` datetime DEFAULT NULL,
  `cs_create_time` datetime DEFAULT NULL,
  PRIMARY KEY (`cs_id`),
  UNIQUE KEY `index_user_account` (`cs_user_account`) USING BTREE COMMENT '用户登陆帐号'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='用户表';

-- ----------------------------
--  Records of `cs_user`
-- ----------------------------
BEGIN;
INSERT INTO `cs_user` VALUES ('001', '001', '001', '001', '2017-05-19', '2018-03-10 15:04:08', '2018-03-10 15:04:17');
COMMIT;

SET FOREIGN_KEY_CHECKS = 1;
