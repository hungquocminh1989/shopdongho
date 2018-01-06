/*
Navicat MySQL Data Transfer

Source Server         : localhost
Source Server Version : 50635
Source Host           : localhost:3306
Source Database       : test1

Target Server Type    : MYSQL
Target Server Version : 50635
File Encoding         : 65001

Date: 2018-01-06 17:38:14
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for m_category
-- ----------------------------
DROP TABLE IF EXISTS `m_category`;
CREATE TABLE `m_category` (
  `m_category_id` int(11) NOT NULL AUTO_INCREMENT,
  `category_name` longtext CHARACTER SET utf8 COLLATE utf8_vietnamese_ci,
  `del_flg` int(11) DEFAULT '0',
  PRIMARY KEY (`m_category_id`)
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for m_image
-- ----------------------------
DROP TABLE IF EXISTS `m_image`;
CREATE TABLE `m_image` (
  `m_image_id` int(11) NOT NULL AUTO_INCREMENT,
  `m_product_id` int(11) DEFAULT NULL,
  `image_path` longtext,
  `default_flg` int(11) DEFAULT '0',
  `del_flg` int(11) DEFAULT '0',
  PRIMARY KEY (`m_image_id`)
) ENGINE=InnoDB AUTO_INCREMENT=56 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for m_product
-- ----------------------------
DROP TABLE IF EXISTS `m_product`;
CREATE TABLE `m_product` (
  `m_product_id` int(11) NOT NULL AUTO_INCREMENT,
  `m_category_id` int(11) DEFAULT NULL,
  `product_name` longtext,
  `product_no` longtext,
  `product_price` longtext,
  `product_info` longtext,
  `product_link` longtext,
  `del_flg` int(11) DEFAULT '0',
  PRIMARY KEY (`m_product_id`)
) ENGINE=InnoDB AUTO_INCREMENT=29 DEFAULT CHARSET=utf8;
