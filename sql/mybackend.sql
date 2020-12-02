/*
Navicat MySQL Data Transfer

Source Server         : root连接
Source Server Version : 50529
Source Host           : localhost:3306
Source Database       : mybackend

Target Server Type    : MYSQL
Target Server Version : 50529
File Encoding         : 65001

Date: 2020-12-02 11:30:55
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for ca_admin
-- ----------------------------
DROP TABLE IF EXISTS `ca_admin`;
CREATE TABLE `ca_admin` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(20) NOT NULL DEFAULT '' COMMENT '姓名',
  `email` varchar(30) NOT NULL DEFAULT '' COMMENT '邮箱',
  `is_admin` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否是超级管理员 1表示是 0 表示不是',
  `avatar` varchar(255) DEFAULT '' COMMENT '头像',
  `username` varchar(50) DEFAULT '' COMMENT '用户名',
  `password` varchar(255) DEFAULT NULL COMMENT '密码',
  `status` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '状态 1：有效 0：无效',
  `update_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '最后一次更新时间',
  `create_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '插入时间',
  `delete_time` int(11) unsigned DEFAULT '0',
  `last_login_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '最后一次登录时间',
  PRIMARY KEY (`id`),
  KEY `idx_email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COMMENT='用户表';

-- ----------------------------
-- Records of ca_admin
-- ----------------------------
INSERT INTO `ca_admin` VALUES ('1', 'carlos', '534994749@qq.com', '1', '', 'admin', 'bfe569e9eb3d1e43698924419a343402', '1', '0', '0', '0', '1599472360');
INSERT INTO `ca_admin` VALUES ('3', 'Carlos', '534994749@qq.com', '0', '', 'Carlos', 'bfe569e9eb3d1e43698924419a343402', '1', '0', '1600846300', '0', '0');
INSERT INTO `ca_admin` VALUES ('4', 'CA', '534994748@qq.com', '0', '', 'Ca', '', '1', '0', '1600846359', '1606879491', '0');
INSERT INTO `ca_admin` VALUES ('5', 'asdsa', '534994747.com', '0', '', 'sdsa', '0fed8aa12e735482e1132650f00927b8', '1', '0', '1600846380', '1606879488', '0');
INSERT INTO `ca_admin` VALUES ('6', '1', '1', '0', '', '1', 'bfe569e9eb3d1e43698924419a343402', '1', '0', '1600847599', '1606879486', '0');

-- ----------------------------
-- Table structure for ca_admin_log
-- ----------------------------
DROP TABLE IF EXISTS `ca_admin_log`;
CREATE TABLE `ca_admin_log` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `admin_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '管理员ID',
  `username` varchar(30) NOT NULL DEFAULT '' COMMENT '管理员名字',
  `url` varchar(1500) NOT NULL DEFAULT '' COMMENT '操作页面',
  `category` varchar(50) NOT NULL COMMENT '内容',
  `content` text,
  `message` varchar(255) DEFAULT NULL,
  `ip` varchar(50) NOT NULL DEFAULT '' COMMENT 'IP',
  `useragent` varchar(255) NOT NULL DEFAULT '' COMMENT 'User-Agent',
  `create_time` int(10) DEFAULT NULL COMMENT '操作时间',
  PRIMARY KEY (`id`),
  KEY `name` (`username`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT COMMENT='管理员日志表';

-- ----------------------------
-- Records of ca_admin_log
-- ----------------------------
INSERT INTO `ca_admin_log` VALUES ('1', '1', 'admin', '/admin/auth_group/delete?ids%5B%5D=12', 'delete', null, '删除数据id:12', '10.26.4.113', 'Mozilla/5.0 (Windows NT 6.1; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/87.0.4280.11 Safari/537.36', '1602320911');
INSERT INTO `ca_admin_log` VALUES ('2', '1', 'admin', '/admin/auth_group/delete?ids%5B%5D=11', 'delete', null, '删除数据id:11', '10.26.4.113', 'Mozilla/5.0 (Windows NT 6.1; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/87.0.4280.11 Safari/537.36', '1602320960');
INSERT INTO `ca_admin_log` VALUES ('3', '1', 'admin', '/admin/auth_group/delete?ids%5B%5D=9&ids%5B%5D=10', 'delete', null, '删除数据id:9,10', '10.26.4.113', 'Mozilla/5.0 (Windows NT 6.1; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/87.0.4280.11 Safari/537.36', '1602320993');
INSERT INTO `ca_admin_log` VALUES ('4', '1', 'admin', '/admin/AuthRule/create.html', 'create', null, '新增数据id:55', '10.26.4.113', 'Mozilla/5.0 (Windows NT 6.1; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/87.0.4280.11 Safari/537.36', '1602321324');
INSERT INTO `ca_admin_log` VALUES ('5', '1', 'admin', '/admin/auth_rule/delete?ids%5B%5D=55', 'delete', null, '删除数据id:55', '10.26.4.113', 'Mozilla/5.0 (Windows NT 6.1; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/87.0.4280.11 Safari/537.36', '1602321347');
INSERT INTO `ca_admin_log` VALUES ('6', '1', 'admin', '/admin/AuthRule/edit.html', 'edit', '{\"is_menu\":\"1\",\"pid\":\"\",\"url\":\"auth_group\\/index\",\"title\":\"\\u89d2\\u8272\\u7ba1\\u7406\",\"icon\":\"\",\"remark\":\"\",\"status\":\"1\",\"id\":\"19\"}', '编辑数据id:19', '10.26.4.113', 'Mozilla/5.0 (Windows NT 6.1; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/87.0.4280.11 Safari/537.36', '1602323403');
INSERT INTO `ca_admin_log` VALUES ('7', '1', 'admin', '/admin/AuthRule/edit.html', 'edit', '{\"is_menu\":\"1\",\"pid\":\"\",\"url\":\"admin\",\"title\":\"\\u6743\\u9650\\u7ba1\\u7406\",\"icon\":\"layui-icon layui-icon-component\",\"remark\":\"\",\"status\":\"1\",\"id\":\"1\"}', '编辑数据id:1', '10.26.4.113', 'Mozilla/5.0 (Windows NT 6.1; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/87.0.4280.11 Safari/537.36', '1602323442');
INSERT INTO `ca_admin_log` VALUES ('8', '1', 'admin', '/admin/admin/delete?ids%5B%5D=6', 'delete', '{\"ids\":[\"6\"]}', '删除数据id:6', '10.26.4.113', 'Mozilla/5.0 (Windows NT 6.1; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/88.0.4324.27 Safari/537.36', '1606879486');
INSERT INTO `ca_admin_log` VALUES ('9', '1', 'admin', '/admin/admin/delete?ids%5B%5D=5', 'delete', '{\"ids\":[\"5\"]}', '删除数据id:5', '10.26.4.113', 'Mozilla/5.0 (Windows NT 6.1; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/88.0.4324.27 Safari/537.36', '1606879488');
INSERT INTO `ca_admin_log` VALUES ('10', '1', 'admin', '/admin/admin/delete?ids%5B%5D=4', 'delete', '{\"ids\":[\"4\"]}', '删除数据id:4', '10.26.4.113', 'Mozilla/5.0 (Windows NT 6.1; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/88.0.4324.27 Safari/537.36', '1606879491');
INSERT INTO `ca_admin_log` VALUES ('11', '1', 'admin', '/admin/AuthRule/edit.html', 'edit', '{\"is_menu\":\"1\",\"pid\":\"1\",\"url\":\"auth_group\\/index\",\"title\":\"\\u89d2\\u8272\\u7ba1\\u7406\",\"icon\":\"\",\"remark\":\"\",\"status\":\"1\",\"id\":\"19\"}', '编辑数据id:19', '10.26.4.113', 'Mozilla/5.0 (Windows NT 6.1; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/88.0.4324.27 Safari/537.36', '1606879538');

-- ----------------------------
-- Table structure for ca_auth_group
-- ----------------------------
DROP TABLE IF EXISTS `ca_auth_group`;
CREATE TABLE `ca_auth_group` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `pid` int(11) unsigned DEFAULT '0' COMMENT '上级',
  `rules` varchar(255) DEFAULT '',
  `name` varchar(50) NOT NULL DEFAULT '' COMMENT '角色名称',
  `status` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '状态 1：有效 0：无效',
  `update_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '最后一次更新时间',
  `create_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '插入时间',
  `delete_time` int(11) unsigned DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8 COMMENT='角色表';

-- ----------------------------
-- Records of ca_auth_group
-- ----------------------------
INSERT INTO `ca_auth_group` VALUES ('1', '0', '1,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24', '超级管理员组', '1', '0', '1600766736', '0');
INSERT INTO `ca_auth_group` VALUES ('2', '1', '1,7,8,9', '研发部', '1', '0', '1600768371', '0');
INSERT INTO `ca_auth_group` VALUES ('3', '2', '1,7,8,9,10,11', '设计部', '1', '0', '1600831894', '0');
INSERT INTO `ca_auth_group` VALUES ('4', '0', '1,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24', '行政部', '1', '0', '1600832119', '0');
INSERT INTO `ca_auth_group` VALUES ('5', '4', '1,7,8,9,10,11,12', '前台', '1', '0', '1600832149', '0');
INSERT INTO `ca_auth_group` VALUES ('6', '5', '1,7,12', '人事', '1', '0', '1600832161', '0');
INSERT INTO `ca_auth_group` VALUES ('7', '0', '1,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24', '技术部', '1', '0', '1600832199', '0');
INSERT INTO `ca_auth_group` VALUES ('8', '7', '', 'PHP组', '1', '0', '1600832207', '0');
INSERT INTO `ca_auth_group` VALUES ('9', '7', '', 'JAVA组', '1', '0', '1600832217', '1602320993');
INSERT INTO `ca_auth_group` VALUES ('10', '7', '1,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24', 'web前端', '1', '0', '1600832232', '1602320993');
INSERT INTO `ca_auth_group` VALUES ('11', '0', '1,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24', '3D前端', '1', '0', '1600832243', '1602320959');
INSERT INTO `ca_auth_group` VALUES ('12', '0', '1,7,8', '3D建模', '1', '0', '1600841369', '1602320911');

-- ----------------------------
-- Table structure for ca_auth_group_access
-- ----------------------------
DROP TABLE IF EXISTS `ca_auth_group_access`;
CREATE TABLE `ca_auth_group_access` (
  `user_id` int(11) NOT NULL DEFAULT '0' COMMENT '用户id',
  `group_id` int(11) NOT NULL DEFAULT '0' COMMENT '角色ID',
  KEY `idx_user_id` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='用户角色表';

-- ----------------------------
-- Records of ca_auth_group_access
-- ----------------------------
INSERT INTO `ca_auth_group_access` VALUES ('1', '1');
INSERT INTO `ca_auth_group_access` VALUES ('4', '2');
INSERT INTO `ca_auth_group_access` VALUES ('5', '3');
INSERT INTO `ca_auth_group_access` VALUES ('5', '4');
INSERT INTO `ca_auth_group_access` VALUES ('6', '1');
INSERT INTO `ca_auth_group_access` VALUES ('6', '5');
INSERT INTO `ca_auth_group_access` VALUES ('3', '3');

-- ----------------------------
-- Table structure for ca_auth_rule
-- ----------------------------
DROP TABLE IF EXISTS `ca_auth_rule`;
CREATE TABLE `ca_auth_rule` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `sort` int(11) DEFAULT '0',
  `pid` int(11) unsigned DEFAULT '0',
  `is_menu` tinyint(1) DEFAULT '0' COMMENT '是否菜单 0:1是',
  `title` varchar(50) DEFAULT '' COMMENT '权限名称',
  `url` varchar(1000) DEFAULT '' COMMENT 'json 数组',
  `icon` varchar(255) DEFAULT '' COMMENT '图标',
  `status` tinyint(1) unsigned DEFAULT '1' COMMENT '状态 1：有效 0：无效',
  `update_time` int(11) unsigned DEFAULT '0' COMMENT '最后一次更新时间',
  `create_time` int(11) unsigned DEFAULT '0' COMMENT '插入时间',
  `delete_time` int(11) DEFAULT '0' COMMENT '删除时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=61 DEFAULT CHARSET=utf8 COMMENT='权限详情表';

-- ----------------------------
-- Records of ca_auth_rule
-- ----------------------------
INSERT INTO `ca_auth_rule` VALUES ('1', '0', '0', '1', '权限管理', 'admin', 'layui-icon layui-icon-component', '1', '0', '0', '0');
INSERT INTO `ca_auth_rule` VALUES ('7', '0', '1', '1', '菜单管理', 'auth_rule/index', '', '1', '0', '0', '0');
INSERT INTO `ca_auth_rule` VALUES ('8', '0', '7', '0', '查看', 'auth_rule/index', '', '1', '0', '0', '0');
INSERT INTO `ca_auth_rule` VALUES ('9', '0', '7', '0', '添加', 'auth_rule/create', '', '1', '0', '0', '0');
INSERT INTO `ca_auth_rule` VALUES ('10', '0', '7', '0', '编辑', 'auth_rule/edit', '', '1', '0', '0', '0');
INSERT INTO `ca_auth_rule` VALUES ('11', '0', '7', '0', '删除', 'auth_rule/delete', '', '1', '0', '0', '0');
INSERT INTO `ca_auth_rule` VALUES ('12', '0', '7', '0', '批量删除', 'auth_rule/delete', '', '1', '0', '0', '0');
INSERT INTO `ca_auth_rule` VALUES ('13', '0', '1', '1', '管理员管理', 'admin/index', '', '1', '0', '1600754593', '0');
INSERT INTO `ca_auth_rule` VALUES ('14', '0', '13', '0', '查看', 'admin/index', '', '1', '0', '1600754593', '0');
INSERT INTO `ca_auth_rule` VALUES ('15', '0', '13', '0', '添加', 'admin/create', '', '1', '0', '1600754593', '0');
INSERT INTO `ca_auth_rule` VALUES ('16', '0', '13', '0', '编辑', 'admin/edit', '', '1', '0', '1600754593', '0');
INSERT INTO `ca_auth_rule` VALUES ('17', '0', '13', '0', '删除', 'admin/delete', '', '1', '0', '1600754593', '0');
INSERT INTO `ca_auth_rule` VALUES ('18', '0', '13', '0', '批量删除', 'admin/delete', '', '1', '0', '1600754593', '0');
INSERT INTO `ca_auth_rule` VALUES ('19', '0', '1', '1', '角色管理', 'auth_group/index', '', '1', '0', '1600755794', '0');
INSERT INTO `ca_auth_rule` VALUES ('20', '0', '19', '0', '查看', 'auth_group/index', '', '1', '0', '1600755794', '0');
INSERT INTO `ca_auth_rule` VALUES ('21', '0', '19', '0', '添加', 'auth_group/create', '', '1', '0', '1600755794', '0');
INSERT INTO `ca_auth_rule` VALUES ('22', '0', '19', '0', '编辑', 'auth_group/edit', '', '1', '0', '1600755794', '0');
INSERT INTO `ca_auth_rule` VALUES ('23', '0', '19', '0', '删除', 'auth_group/delete', '', '1', '0', '1600755794', '0');
INSERT INTO `ca_auth_rule` VALUES ('24', '0', '19', '0', '批量删除', 'auth_group/delete', '', '1', '0', '1600755794', '0');
INSERT INTO `ca_auth_rule` VALUES ('37', '0', '0', '1', '测试', '1', '', '1', '0', '1601196719', '1601197893');
INSERT INTO `ca_auth_rule` VALUES ('38', '0', '37', '0', '查看', 'index', '', '1', '0', '1601196719', '1601197893');
INSERT INTO `ca_auth_rule` VALUES ('39', '0', '37', '0', '添加', 'create', '', '1', '0', '1601196719', '1601197893');
INSERT INTO `ca_auth_rule` VALUES ('40', '0', '37', '0', '编辑', 'edit', '', '1', '0', '1601196719', '1601197893');
INSERT INTO `ca_auth_rule` VALUES ('41', '0', '37', '0', '删除', 'delete', '', '1', '0', '1601196719', '1601197893');
INSERT INTO `ca_auth_rule` VALUES ('42', '0', '37', '0', '批量删除', 'delete', '', '1', '0', '1601196719', '1601197893');
INSERT INTO `ca_auth_rule` VALUES ('43', '0', '0', '1', '测试2', 'ce', '', '1', '0', '1601197749', '1601197893');
INSERT INTO `ca_auth_rule` VALUES ('44', '0', '43', '0', '查看', 'index', '', '1', '0', '1601197749', '1601197893');
INSERT INTO `ca_auth_rule` VALUES ('45', '0', '43', '0', '添加', 'create', '', '1', '0', '1601197749', '1601197893');
INSERT INTO `ca_auth_rule` VALUES ('46', '0', '43', '0', '编辑', 'edit', '', '1', '0', '1601197749', '1601197893');
INSERT INTO `ca_auth_rule` VALUES ('47', '0', '43', '0', '删除', 'delete', '', '1', '0', '1601197749', '1601197893');
INSERT INTO `ca_auth_rule` VALUES ('48', '0', '43', '0', '批量删除', 'delete', '', '1', '0', '1601197749', '1601197893');
INSERT INTO `ca_auth_rule` VALUES ('55', '0', '1', '1', 'test', 'test', 'layui-icon layui-icon-rate-half', '1', '0', '1602321324', '1602321346');
INSERT INTO `ca_auth_rule` VALUES ('56', '0', '55', '0', '查看', 'index', '', '1', '0', '1602321324', '1602321346');
INSERT INTO `ca_auth_rule` VALUES ('57', '0', '55', '0', '添加', 'create', '', '1', '0', '1602321324', '1602321346');
INSERT INTO `ca_auth_rule` VALUES ('58', '0', '55', '0', '编辑', 'edit', '', '1', '0', '1602321324', '1602321346');
INSERT INTO `ca_auth_rule` VALUES ('59', '0', '55', '0', '删除', 'delete', '', '1', '0', '1602321324', '1602321346');
INSERT INTO `ca_auth_rule` VALUES ('60', '0', '55', '0', '批量删除', 'delete', '', '1', '0', '1602321324', '1602321346');

-- ----------------------------
-- Table structure for ca_user
-- ----------------------------
DROP TABLE IF EXISTS `ca_user`;
CREATE TABLE `ca_user` (
  `id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of ca_user
-- ----------------------------
