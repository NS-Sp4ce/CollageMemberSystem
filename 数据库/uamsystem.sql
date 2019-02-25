-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- 主机： localhost
-- 生成日期： 2019-02-25 06:32:28
-- 服务器版本： 5.7.23-log
-- PHP 版本： 7.2.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- 数据库： `uamsystem`
--

-- --------------------------------------------------------

--
-- 表的结构 `college`
--

CREATE TABLE `college` (
  `college_id` int(3) NOT NULL,
  `college_name` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

-- --------------------------------------------------------

--
-- 表的结构 `manager`
--

CREATE TABLE `manager` (
  `admin_id` int(3) NOT NULL,
  `admin_name` varchar(40) NOT NULL,
  `admin_pwd` varchar(40) DEFAULT NULL,
  `admin_email` varchar(255) DEFAULT NULL,
  `admin_phone` varchar(11) DEFAULT NULL,
  `admin_avatar` varchar(255) DEFAULT NULL,
  `admin_qq` varchar(15) DEFAULT NULL,
  `admin_create_time` datetime NOT NULL,
  `admin_level` int(2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

--
-- 转存表中的数据 `manager`
--

INSERT INTO `manager` (`admin_id`, `admin_name`, `admin_pwd`, `admin_email`, `admin_phone`, `admin_avatar`, `admin_qq`, `admin_create_time`, `admin_level`) VALUES
(1, 'admin', '21232f297a57a5a743894a0e4a801fc3', '', '', '', '', '0000-00-00 00:00:00', 1),

-- --------------------------------------------------------

--
-- 表的结构 `manager_level`
--

CREATE TABLE `manager_level` (
  `level_id` int(2) NOT NULL,
  `level_name` varchar(15) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

--
-- 转存表中的数据 `manager_level`
--

INSERT INTO `manager_level` (`level_id`, `level_name`) VALUES
(1, '超级管理员'),
(2, '管理员'),
(3, '信息录入员');

-- --------------------------------------------------------

--
-- 表的结构 `member`
--

CREATE TABLE `member` (
  `mem_id` int(10) NOT NULL,
  `mem_name` varchar(40) DEFAULT NULL COMMENT '姓名',
  `mem_gender` varchar(6) DEFAULT NULL COMMENT '性别',
  `mem_stunum` varchar(20) DEFAULT NULL COMMENT '学号',
  `mem_password` varchar(50) DEFAULT NULL,
  `mem_phone` varchar(11) DEFAULT NULL COMMENT '手机',
  `mem_qq` varchar(20) DEFAULT NULL COMMENT 'QQ',
  `mem_class` varchar(100) DEFAULT NULL COMMENT '班级',
  `mem_college` varchar(100) DEFAULT NULL COMMENT '学院',
  `mem_join_time` int(4) DEFAULT NULL,
  `mem_pay_check` varchar(4) DEFAULT NULL COMMENT '缴费'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

-- --------------------------------------------------------

--
-- 表的结构 `payment`
--

CREATE TABLE `payment` (
  `pay_id` int(2) NOT NULL,
  `pay_name` varchar(8) DEFAULT NULL,
  `pay_check` varchar(4) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

-- --------------------------------------------------------

--
-- 表的结构 `sign_in_log`
--

CREATE TABLE `sign_in_log` (
  `sign_in_id` int(255) NOT NULL,
  `sign_in_name` varchar(40) DEFAULT NULL,
  `sign_in_ip` varchar(100) DEFAULT NULL,
  `sign_in_ua` varchar(255) DEFAULT NULL,
  `sign_in_time` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

-- --------------------------------------------------------

--
-- 表的结构 `site_config`
--

CREATE TABLE `site_config` (
  `site_id` int(255) NOT NULL,
  `site_name` varchar(255) DEFAULT NULL,
  `site_logo` longtext,
  `site_main_page` longtext,
  `program_version` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

-- --------------------------------------------------------

--
-- 表的结构 `teaching`
--

CREATE TABLE `teaching` (
  `edu_id` int(100) NOT NULL,
  `edu_teacher` varchar(50) DEFAULT NULL,
  `edu_time` date DEFAULT NULL,
  `edu_content` longtext,
  `edu_phone` varchar(11) DEFAULT NULL,
  `edu_status` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

--
-- 转储表的索引
--

--
-- 表的索引 `college`
--
ALTER TABLE `college`
  ADD PRIMARY KEY (`college_id`) USING BTREE;

--
-- 表的索引 `manager`
--
ALTER TABLE `manager`
  ADD PRIMARY KEY (`admin_id`) USING BTREE,
  ADD KEY `level` (`admin_level`) USING BTREE;

--
-- 表的索引 `manager_level`
--
ALTER TABLE `manager_level`
  ADD PRIMARY KEY (`level_id`) USING BTREE;

--
-- 表的索引 `member`
--
ALTER TABLE `member`
  ADD PRIMARY KEY (`mem_id`) USING BTREE,
  ADD KEY `mem_name` (`mem_name`) USING BTREE,
  ADD KEY `checkpay` (`mem_pay_check`) USING BTREE,
  ADD KEY `id` (`mem_id`) USING BTREE;

--
-- 表的索引 `payment`
--
ALTER TABLE `payment`
  ADD PRIMARY KEY (`pay_id`) USING BTREE,
  ADD KEY `会员名` (`pay_name`) USING BTREE,
  ADD KEY `pay_check` (`pay_check`) USING BTREE;

--
-- 表的索引 `sign_in_log`
--
ALTER TABLE `sign_in_log`
  ADD PRIMARY KEY (`sign_in_id`) USING BTREE;

--
-- 表的索引 `site_config`
--
ALTER TABLE `site_config`
  ADD PRIMARY KEY (`site_id`) USING BTREE;

--
-- 表的索引 `teaching`
--
ALTER TABLE `teaching`
  ADD PRIMARY KEY (`edu_id`) USING BTREE;

--
-- 在导出的表使用AUTO_INCREMENT
--

--
-- 使用表AUTO_INCREMENT `college`
--
ALTER TABLE `college`
  MODIFY `college_id` int(3) NOT NULL AUTO_INCREMENT;

--
-- 使用表AUTO_INCREMENT `manager`
--
ALTER TABLE `manager`
  MODIFY `admin_id` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- 使用表AUTO_INCREMENT `manager_level`
--
ALTER TABLE `manager_level`
  MODIFY `level_id` int(2) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- 使用表AUTO_INCREMENT `member`
--
ALTER TABLE `member`
  MODIFY `mem_id` int(10) NOT NULL AUTO_INCREMENT;

--
-- 使用表AUTO_INCREMENT `payment`
--
ALTER TABLE `payment`
  MODIFY `pay_id` int(2) NOT NULL AUTO_INCREMENT;

--
-- 使用表AUTO_INCREMENT `sign_in_log`
--
ALTER TABLE `sign_in_log`
  MODIFY `sign_in_id` int(255) NOT NULL AUTO_INCREMENT;

--
-- 使用表AUTO_INCREMENT `site_config`
--
ALTER TABLE `site_config`
  MODIFY `site_id` int(255) NOT NULL AUTO_INCREMENT;

--
-- 使用表AUTO_INCREMENT `teaching`
--
ALTER TABLE `teaching`
  MODIFY `edu_id` int(100) NOT NULL AUTO_INCREMENT;

--
-- 限制导出的表
--

--
-- 限制表 `manager`
--
ALTER TABLE `manager`
  ADD CONSTRAINT `level` FOREIGN KEY (`admin_level`) REFERENCES `manager_level` (`level_id`);

--
-- 限制表 `member`
--
ALTER TABLE `member`
  ADD CONSTRAINT `checkpay` FOREIGN KEY (`mem_pay_check`) REFERENCES `payment` (`pay_check`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
