/*
 Navicat Premium Data Transfer

 Source Server         : MySQL to Navicat
 Source Server Type    : MySQL
 Source Server Version : 100121
 Source Host           : localhost:3306
 Source Schema         : db_dynamic_shop

 Target Server Type    : MySQL
 Target Server Version : 100121
 File Encoding         : 65001

 Date: 23/07/2018 08:54:06
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for td_user_jenis_prop
-- ----------------------------
DROP TABLE IF EXISTS `td_user_jenis_prop`;
CREATE TABLE `td_user_jenis_prop`  (
  `kd_user_jenis_prop` varchar(10) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `user_jenis_kd` varchar(10) CHARACTER SET latin1 COLLATE latin1_general_ci DEFAULT NULL,
  `user_prop_kd` varchar(10) CHARACTER SET latin1 COLLATE latin1_general_ci DEFAULT NULL,
  `tgl_input` datetime(0) DEFAULT NULL,
  `user_kd` varchar(10) CHARACTER SET latin1 COLLATE latin1_general_ci DEFAULT NULL,
  PRIMARY KEY (`kd_user_jenis_prop`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = latin1 COLLATE = latin1_general_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for td_user_jenis_prop_opt
-- ----------------------------
DROP TABLE IF EXISTS `td_user_jenis_prop_opt`;
CREATE TABLE `td_user_jenis_prop_opt`  (
  `kd_user_jenis_prop_opt` varchar(10) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `user_jenis_kd` varchar(10) CHARACTER SET latin1 COLLATE latin1_general_ci DEFAULT NULL,
  `user_prop_kd` varchar(10) CHARACTER SET latin1 COLLATE latin1_general_ci DEFAULT NULL,
  `user_prop_opt_kd` varchar(10) CHARACTER SET latin1 COLLATE latin1_general_ci DEFAULT NULL,
  `tgl_input` datetime(0) DEFAULT NULL,
  `user_kd` varchar(10) CHARACTER SET latin1 COLLATE latin1_general_ci DEFAULT NULL,
  PRIMARY KEY (`kd_user_jenis_prop_opt`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = latin1 COLLATE = latin1_general_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for td_user_prop
-- ----------------------------
DROP TABLE IF EXISTS `td_user_prop`;
CREATE TABLE `td_user_prop`  (
  `kd_duser_prop` varchar(10) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `user_kd` varchar(10) CHARACTER SET latin1 COLLATE latin1_general_ci DEFAULT NULL,
  `user_prop_kd` varchar(10) CHARACTER SET latin1 COLLATE latin1_general_ci DEFAULT NULL,
  `nm_properties` varchar(255) CHARACTER SET latin1 COLLATE latin1_general_ci DEFAULT NULL,
  `value` text CHARACTER SET latin1 COLLATE latin1_general_ci,
  `tgl_input` datetime(0) DEFAULT NULL,
  `admin_kd` varchar(10) CHARACTER SET latin1 COLLATE latin1_general_ci DEFAULT NULL,
  PRIMARY KEY (`kd_duser_prop`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = latin1 COLLATE = latin1_general_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for td_user_prop_opt
-- ----------------------------
DROP TABLE IF EXISTS `td_user_prop_opt`;
CREATE TABLE `td_user_prop_opt`  (
  `kd_user_prop_opt` varchar(10) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `user_prop_kd` varchar(10) CHARACTER SET latin1 COLLATE latin1_general_ci DEFAULT NULL,
  `option_prop` varchar(255) CHARACTER SET latin1 COLLATE latin1_general_ci DEFAULT NULL,
  `tgl_input` datetime(0) DEFAULT NULL,
  `user_kd` varchar(10) CHARACTER SET latin1 COLLATE latin1_general_ci DEFAULT NULL,
  PRIMARY KEY (`kd_user_prop_opt`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = latin1 COLLATE = latin1_general_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for tm_user
-- ----------------------------
DROP TABLE IF EXISTS `tm_user`;
CREATE TABLE `tm_user`  (
  `kd_user` varchar(10) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `user_jenis_kd` varchar(10) CHARACTER SET latin1 COLLATE latin1_general_ci DEFAULT NULL,
  `user_id` varchar(255) CHARACTER SET latin1 COLLATE latin1_general_ci DEFAULT NULL,
  `user_pass` varchar(255) CHARACTER SET latin1 COLLATE latin1_general_ci DEFAULT NULL,
  `tgl_input` datetime(0) DEFAULT NULL,
  `tgl_edit` datetime(0) DEFAULT NULL,
  `user_kd` varchar(10) CHARACTER SET latin1 COLLATE latin1_general_ci DEFAULT NULL,
  PRIMARY KEY (`kd_user`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = latin1 COLLATE = latin1_general_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for tm_user_jenis
-- ----------------------------
DROP TABLE IF EXISTS `tm_user_jenis`;
CREATE TABLE `tm_user_jenis`  (
  `kd_user_jenis` varchar(10) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `kd_parent` varchar(10) CHARACTER SET latin1 COLLATE latin1_general_ci DEFAULT NULL,
  `nm_jenis` varchar(255) CHARACTER SET latin1 COLLATE latin1_general_ci DEFAULT NULL,
  `tgl_input` datetime(0) DEFAULT NULL,
  `tgl_edit` datetime(0) DEFAULT NULL,
  `user_kd` varchar(10) CHARACTER SET latin1 COLLATE latin1_general_ci DEFAULT NULL,
  PRIMARY KEY (`kd_user_jenis`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = latin1 COLLATE = latin1_general_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for tm_user_prop
-- ----------------------------
DROP TABLE IF EXISTS `tm_user_prop`;
CREATE TABLE `tm_user_prop`  (
  `kd_user_prop` varchar(10) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `nm_properties` varchar(255) CHARACTER SET latin1 COLLATE latin1_general_ci DEFAULT NULL,
  `tipe_prop` enum('textfield','textbox','date','email','number','option') CHARACTER SET latin1 COLLATE latin1_general_ci DEFAULT NULL,
  `tgl_input` datetime(0) DEFAULT NULL,
  `tgl_edit` datetime(0) DEFAULT NULL,
  `user_kd` varchar(10) CHARACTER SET latin1 COLLATE latin1_general_ci DEFAULT NULL,
  PRIMARY KEY (`kd_user_prop`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = latin1 COLLATE = latin1_general_ci ROW_FORMAT = Compact;

SET FOREIGN_KEY_CHECKS = 1;
