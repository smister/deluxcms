-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: 2016-12-19 04:06:53
-- 服务器版本： 5.6.17
-- PHP Version: 5.5.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `yiicms`
--

-- --------------------------------------------------------

--
-- 表的结构 `s_auth`
--

CREATE TABLE IF NOT EXISTS `s_auth` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `member_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '关联会员',
  `source` varchar(50) NOT NULL DEFAULT '' COMMENT '来源（如微博)',
  `source_id` varchar(50) NOT NULL DEFAULT '' COMMENT '来源 id',
  PRIMARY KEY (`id`),
  KEY `idx_user` (`member_id`),
  KEY `idx_souce` (`source_id`,`source`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='用户授权登录' AUTO_INCREMENT=4 ;

--
-- 转存表中的数据 `s_auth`
--

INSERT INTO `s_auth` (`id`, `member_id`, `source`, `source_id`) VALUES
(3, 15, 'weibo', '91013');

-- --------------------------------------------------------

--
-- 表的结构 `s_auth_assignment`
--

CREATE TABLE IF NOT EXISTS `s_auth_assignment` (
  `item_name` varchar(64) NOT NULL,
  `user_id` varchar(64) NOT NULL,
  `created_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`item_name`,`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `s_auth_assignment`
--

INSERT INTO `s_auth_assignment` (`item_name`, `user_id`, `created_at`) VALUES
('chao', '1', 1476116333);

-- --------------------------------------------------------

--
-- 表的结构 `s_auth_item`
--

CREATE TABLE IF NOT EXISTS `s_auth_item` (
  `name` varchar(64) NOT NULL,
  `type` int(11) NOT NULL,
  `description` text,
  `rule_name` varchar(64) DEFAULT NULL,
  `data` text,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`name`),
  KEY `rule_name` (`rule_name`),
  KEY `type` (`type`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `s_auth_item`
--

INSERT INTO `s_auth_item` (`name`, `type`, `description`, `rule_name`, `data`, `created_at`, `updated_at`) VALUES
('chao', 1, '超级管理员', NULL, NULL, 1476027623, 1476117409),
('test_add', 2, NULL, NULL, NULL, 1476027260, 1476027260),
('test_index', 2, NULL, NULL, NULL, 1476027251, 1476027251),
('user_create', 2, NULL, NULL, NULL, 1476027295, 1476027295),
('user_index', 2, NULL, NULL, NULL, 1476027281, 1476027281);

-- --------------------------------------------------------

--
-- 表的结构 `s_auth_item_child`
--

CREATE TABLE IF NOT EXISTS `s_auth_item_child` (
  `parent` varchar(64) NOT NULL,
  `child` varchar(64) NOT NULL,
  PRIMARY KEY (`parent`,`child`),
  KEY `child` (`child`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `s_auth_item_child`
--

INSERT INTO `s_auth_item_child` (`parent`, `child`) VALUES
('chao', 'test_add'),
('chao', 'test_index'),
('chao', 'user_create'),
('chao', 'user_index');

-- --------------------------------------------------------

--
-- 表的结构 `s_auth_item_menu`
--

CREATE TABLE IF NOT EXISTS `s_auth_item_menu` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `parent_id` mediumint(8) unsigned NOT NULL DEFAULT '0' COMMENT '0 为父类',
  `nickname` varchar(20) NOT NULL DEFAULT '' COMMENT '昵称',
  `name` varchar(64) NOT NULL DEFAULT '' COMMENT '对应 auth_item 的 name',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=11 ;

--
-- 转存表中的数据 `s_auth_item_menu`
--

INSERT INTO `s_auth_item_menu` (`id`, `parent_id`, `nickname`, `name`) VALUES
(5, 0, '测试', 'test'),
(6, 5, '测试首页', 'test_index'),
(7, 5, '测试添加', 'test_add'),
(8, 0, '用户', 'user'),
(9, 8, '用户列表', 'user_index'),
(10, 8, '用户新添', 'user_create');

-- --------------------------------------------------------

--
-- 表的结构 `s_auth_rule`
--

CREATE TABLE IF NOT EXISTS `s_auth_rule` (
  `name` varchar(64) NOT NULL,
  `data` text,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `s_comment`
--

CREATE TABLE IF NOT EXISTS `s_comment` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `top_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '关联评论最高 id',
  `parent_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '关联评论回复 id',
  `post_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '帖子 id',
  `member_id` int(11) NOT NULL DEFAULT '0' COMMENT '评论会员',
  `content` varchar(500) NOT NULL DEFAULT '' COMMENT '评论内容',
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '0=不可用,1=可用',
  `updated_at` int(11) NOT NULL DEFAULT '631152000',
  `created_at` int(11) NOT NULL DEFAULT '631152000',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='用户评论' AUTO_INCREMENT=14 ;

--
-- 转存表中的数据 `s_comment`
--

INSERT INTO `s_comment` (`id`, `top_id`, `parent_id`, `post_id`, `member_id`, `content`, `status`, `updated_at`, `created_at`) VALUES
(2, 0, 0, 7, 1, '测试测试', 1, 1478620603, 1478620603),
(6, 2, 2, 7, 1, '测试内容', 1, 1478704514, 1478704514),
(7, 2, 2, 7, 1, '测试测试啊啊啊啊啊', 1, 1478704533, 1478704533),
(8, 2, 7, 7, 1, '回复摧毁', 1, 1478704817, 1478704817),
(9, 2, 8, 7, 1, '灰灰灰灰', 1, 1478705498, 1478705498),
(10, 2, 9, 7, 1, '灰灰灰啊啊啊啊啊', 1, 1478705890, 1478705890),
(11, 0, 0, 8, 1, '回复啦', 1, 1478706382, 1478706382),
(12, 11, 11, 8, 1, '恩恩。测试一下', 1, 1479137490, 1478706455),
(13, 0, 0, 7, 1, '我是ajax登录的', 1, 1480348695, 1480348695);

-- --------------------------------------------------------

--
-- 表的结构 `s_media`
--

CREATE TABLE IF NOT EXISTS `s_media` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `filename` varchar(255) NOT NULL DEFAULT '' COMMENT '文件名称',
  `type` varchar(127) NOT NULL DEFAULT '' COMMENT '文件类型',
  `url` varchar(255) NOT NULL DEFAULT '' COMMENT '链接地址',
  `size` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '文件大小',
  `created_at` int(11) NOT NULL DEFAULT '631152000',
  `updated_at` int(11) NOT NULL DEFAULT '631152000',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=28 ;

--
-- 转存表中的数据 `s_media`
--

INSERT INTO `s_media` (`id`, `filename`, `type`, `url`, `size`, `created_at`, `updated_at`) VALUES
(12, 'no_avatar.jpg', 'image/jpeg', 'uploads/2016/09/14/2016091418291314012.jpg', 1848, 1473870553, 1473870553),
(13, 'no_avatar.jpg', 'image/jpeg', 'uploads/2016/09/14/2016091418402072462.jpg', 1848, 1473871220, 1473871220),
(14, 'no_avatar.jpg', 'image/jpeg', 'uploads/2016/09/14/2016091418410351289.jpg', 1848, 1473871263, 1473871263),
(16, 'no_avatar.jpg', 'image/jpeg', 'uploads/2016/09/14/2016091418424193229.jpg', 1848, 1473871361, 1473871361),
(17, 'no_avatar.jpg', 'image/jpeg', 'uploads/2016/09/14/2016091418434116097.jpg', 1848, 1473871421, 1473871421),
(18, 'no_avatar.jpg', 'image/jpeg', 'uploads/2016/09/14/2016091418440861649.jpg', 1848, 1473871448, 1473871448),
(19, 'no_avatar.jpg', 'image/jpeg', 'uploads/2016/09/14/2016091418460430418.jpg', 1848, 1473871564, 1473871564),
(20, 'no_avatar.jpg', 'image/jpeg', 'uploads/2016/09/14/2016091418464327915.jpg', 1848, 1473871603, 1473871603),
(21, 'no_avatar.jpg', 'image/jpeg', 'uploads/2016/09/14/2016091418492524776.jpg', 1848, 1473871765, 1473871765),
(22, 'no_avatar.jpg', 'image/jpeg', 'uploads/2016/09/14/2016091418510873932.jpg', 1848, 1473871868, 1473871868),
(24, 'no_avatar.jpg', 'image/jpeg', 'uploads/2016/09/14/2016091418524075541.jpg', 1848, 1473871960, 1473871960),
(25, 'mi_banner21580X700.jpg', 'image/jpeg', 'uploads/2016/10/25/2016102517392380537.jpg', 25063, 1477409963, 1477409963),
(26, 'no_avatar.jpg', 'image/jpeg', 'uploads/2016/12/12/2016121210162216149.jpg', 1848, 1481534182, 1481534182),
(27, '11_avatar.jpg', 'image/jpeg', 'uploads/2016/12/15/2016121516284313924.jpg', 1848, 1481815723, 1481815732);

-- --------------------------------------------------------

--
-- 表的结构 `s_member`
--

CREATE TABLE IF NOT EXISTS `s_member` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(255) NOT NULL DEFAULT '',
  `nickname` varchar(50) NOT NULL DEFAULT '' COMMENT '昵称',
  `avatar` varchar(255) NOT NULL DEFAULT '' COMMENT '头像',
  `password_hash` varchar(255) NOT NULL DEFAULT '',
  `auth_key` varchar(32) NOT NULL DEFAULT '',
  `password_reset_token` varchar(255) NOT NULL DEFAULT '',
  `email` varchar(255) NOT NULL DEFAULT '' COMMENT '邮箱',
  `address` varchar(255) NOT NULL DEFAULT '' COMMENT '地址',
  `sex` tinyint(1) NOT NULL DEFAULT '1' COMMENT '性别[0=女,1=男]',
  `status` smallint(6) unsigned NOT NULL DEFAULT '1',
  `registration_ip` varchar(15) NOT NULL DEFAULT '' COMMENT '注册 ip',
  `email_validate` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '邮箱是否验证',
  `created_at` int(11) NOT NULL DEFAULT '631152000',
  `updated_at` int(11) NOT NULL DEFAULT '631152000',
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='会员表' AUTO_INCREMENT=16 ;

--
-- 转存表中的数据 `s_member`
--

INSERT INTO `s_member` (`id`, `username`, `nickname`, `avatar`, `password_hash`, `auth_key`, `password_reset_token`, `email`, `address`, `sex`, `status`, `registration_ip`, `email_validate`, `created_at`, `updated_at`) VALUES
(1, 'smister', 'mrs', '', '$2y$13$7/48ZbUV8qg2zgDWhSRhdOop8hGWnyB5w31diiEDl0Hcijna0xdAC', '', '', '39800921@qq.com', '深圳', 1, 1, '127.0.0.1', 0, 1477324196, 1477324202),
(2, 'mrs1', 'mrs1', '', '$2y$13$roqDa7xQMbUUeTI0cab18upu0wD0Xdy4DT3qmor5ULsHm249Wq4Na', '', '', '398009251@qq.com', '', 1, 1, '127.0.0.1', 1, 1478531020, 1478531020),
(3, 'test', 'test', '', '$2y$13$.hqOY1pO/aeYw6v86VWAPugTMlJbdIdduKKrfS.nPG/UIYlW7Omyy', '', '', '39802951@qq.com', '', 1, 1, '127.0.0.1', 1, 1478531236, 1478531236),
(4, 'test22', 'test22', '', '$2y$13$X4z3Ct5zBCr8XmsOswtARuRm/pkNCP7m5VGNsRW2FHuZD1wuUVne2', '', '', '3980021@qq.com', '', 1, 1, '127.0.0.1', 1, 1478533250, 1478533250),
(5, 'test22333', 'smister', '', '$2y$13$0H2Wu3wxMh0W1qJe6lTjveM7N4KljgKAPec.DNmJ1CN1MFyhYxiJe', '', '', '398009951@qq.com', '深圳', 1, 1, '127.0.0.1', 1, 1478533412, 1479998675),
(10, 'aaa', 'aaa', '', '$2y$13$Du4rTfrMAgSc.1CqE6Tlsu7FSddCLGQ3dNScObtBvZifIq9hpXpwm', '', '', 'aaa@qq.com', '', 1, 1, '127.0.0.1', 1, 1479996413, 1479996413),
(11, 'bb', 'bb', '', '$2y$13$xIkHm7dlLB4E0zwwy0TOB.Wex5XyHAWZS7Bw8SJ45z4ozrWhLIgJ2', '', '', 'bb@qq.com', '', 1, 1, '127.0.0.1', 1, 1479996655, 1479996655),
(15, 'mrs28107', 'mrs44199', 'http://www.smister.com/mrs.jpg', '$2y$13$CKXVsx4VuQhfcEvXZzrOau//m5fxZ1Z8sIhgTWx4QH6jggXABj8kW', '', '', '', '深圳', 0, 1, '127.0.0.1', 0, 1480863989, 1480863989);

-- --------------------------------------------------------

--
-- 表的结构 `s_member_visit_log`
--

CREATE TABLE IF NOT EXISTS `s_member_visit_log` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `ip` varchar(15) NOT NULL DEFAULT '' COMMENT '最新登录 ip',
  `user_agent` varchar(255) NOT NULL DEFAULT '' COMMENT '用户代理',
  `browser` varchar(30) NOT NULL DEFAULT '' COMMENT '浏览器',
  `os` varchar(20) NOT NULL DEFAULT '' COMMENT '系统',
  `member_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '关联会员',
  `visit_time` int(11) NOT NULL DEFAULT '631152000' COMMENT '访问时间',
  PRIMARY KEY (`id`),
  KEY `visit_log_user_id` (`member_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='会员登录日志' AUTO_INCREMENT=25 ;

--
-- 转存表中的数据 `s_member_visit_log`
--

INSERT INTO `s_member_visit_log` (`id`, `ip`, `user_agent`, `browser`, `os`, `member_id`, `visit_time`) VALUES
(1, '127.0.0.1', 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:49.0) Gecko/20100101 Firefox/49.0', 'Firefox', 'Windows', 3, 1478532022),
(2, '127.0.0.1', 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:49.0) Gecko/20100101 Firefox/49.0', 'Firefox', 'Windows', 4, 1478533814),
(3, '127.0.0.1', 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:49.0) Gecko/20100101 Firefox/49.0', 'Firefox', 'Windows', 1, 1478620405),
(4, '127.0.0.1', 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:49.0) Gecko/20100101 Firefox/49.0', 'Firefox', 'Windows', 1, 1478702532),
(5, '127.0.0.1', 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:49.0) Gecko/20100101 Firefox/49.0', 'Firefox', 'Windows', 1, 1478702684),
(6, '127.0.0.1', 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:49.0) Gecko/20100101 Firefox/49.0', 'Firefox', 'Windows', 1, 1478703079),
(7, '127.0.0.1', 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:49.0) Gecko/20100101 Firefox/49.0', 'Firefox', 'Windows', 1, 1478704154),
(8, '127.0.0.1', 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:49.0) Gecko/20100101 Firefox/49.0', 'Firefox', 'Windows', 5, 1479740198),
(9, '127.0.0.1', 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:49.0) Gecko/20100101 Firefox/49.0', 'Firefox', 'Windows', 5, 1479740630),
(10, '127.0.0.1', 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:49.0) Gecko/20100101 Firefox/49.0', 'Firefox', 'Windows', 5, 1479740902),
(11, '127.0.0.1', 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:49.0) Gecko/20100101 Firefox/49.0', 'Firefox', 'Windows', 5, 1479914653),
(12, '127.0.0.1', 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:49.0) Gecko/20100101 Firefox/49.0', 'Firefox', 'Windows', 5, 1479995179),
(13, '127.0.0.1', 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:49.0) Gecko/20100101 Firefox/49.0', 'Firefox', 'Windows', 5, 1479997235),
(14, '127.0.0.1', 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:49.0) Gecko/20100101 Firefox/49.0', 'Firefox', 'Windows', 1, 1480084585),
(15, '127.0.0.1', 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:49.0) Gecko/20100101 Firefox/49.0', 'Firefox', 'Windows', 1, 1480084631),
(16, '127.0.0.1', 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:49.0) Gecko/20100101 Firefox/49.0', 'Firefox', 'Windows', 1, 1480084840),
(17, '127.0.0.1', 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:49.0) Gecko/20100101 Firefox/49.0', 'Firefox', 'Windows', 1, 1480089505),
(18, '127.0.0.1', 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:49.0) Gecko/20100101 Firefox/49.0', 'Firefox', 'Windows', 1, 1480348334),
(19, '127.0.0.1', 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:49.0) Gecko/20100101 Firefox/49.0', 'Firefox', 'Windows', 1, 1480348679),
(20, '127.0.0.1', 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:50.0) Gecko/20100101 Firefox/50.0', 'Firefox', 'Windows', 15, 1480863989),
(21, '127.0.0.1', 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:50.0) Gecko/20100101 Firefox/50.0', 'Firefox', 'Windows', 1, 1482068946),
(22, '127.0.0.1', 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:50.0) Gecko/20100101 Firefox/50.0', 'Firefox', 'Windows', 1, 1482069134),
(23, '127.0.0.1', 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:50.0) Gecko/20100101 Firefox/50.0', 'Firefox', 'Windows', 1, 1482069154),
(24, '127.0.0.1', 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:50.0) Gecko/20100101 Firefox/50.0', 'Firefox', 'Windows', 1, 1482070120);

-- --------------------------------------------------------

--
-- 表的结构 `s_menu`
--

CREATE TABLE IF NOT EXISTS `s_menu` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(32) NOT NULL DEFAULT '' COMMENT '名称',
  `created_at` int(11) NOT NULL DEFAULT '631152000',
  `updated_at` int(11) NOT NULL DEFAULT '631152000',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='菜单栏表' AUTO_INCREMENT=4 ;

--
-- 转存表中的数据 `s_menu`
--

INSERT INTO `s_menu` (`id`, `title`, `created_at`, `updated_at`) VALUES
(1, '后台菜单', 1472658476, 1472658476),
(3, '前台菜单', 1482068799, 1482068799);

-- --------------------------------------------------------

--
-- 表的结构 `s_menu_link`
--

CREATE TABLE IF NOT EXISTS `s_menu_link` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `menu_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '关联菜单栏 id',
  `parent_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '所属父类 id',
  `label` varchar(32) NOT NULL DEFAULT '' COMMENT '名称',
  `link` varchar(255) NOT NULL DEFAULT '' COMMENT '链接地址',
  `image` varchar(24) NOT NULL DEFAULT '' COMMENT '图片链接地址',
  `order` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '排序',
  `created_at` int(11) NOT NULL DEFAULT '631152000',
  `updated_at` int(11) NOT NULL DEFAULT '631152000',
  PRIMARY KEY (`id`),
  KEY `link_menu_id` (`menu_id`),
  KEY `link_parent_id` (`parent_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='菜单链接表' AUTO_INCREMENT=28 ;

--
-- 转存表中的数据 `s_menu_link`
--

INSERT INTO `s_menu_link` (`id`, `menu_id`, `parent_id`, `label`, `link`, `image`, `order`, `created_at`, `updated_at`) VALUES
(1, 1, 0, '首页', '/', 'home', 0, 1473265072, 1473265072),
(8, 1, 0, '网站设置', '/setting', 'server', 19, 1474817253, 1479137992),
(9, 1, 0, '菜单列表', '/menu', 'align-justify', 12, 1474817266, 1474817386),
(10, 1, 0, '用户管理', '', 'user', 13, 1474817447, 1479137604),
(11, 1, 10, '用户列表', '/user', '', 14, 1474817475, 1474817475),
(12, 1, 10, '用户登录日志', '/uservisitlog', '', 15, 1474817502, 1474817551),
(13, 1, 0, '评论列表', '/comment', 'clipboard', 5, 1479137653, 1479137653),
(14, 1, 0, '图片管理', '/media', 'photo', 10, 1479137668, 1479137689),
(15, 1, 0, '会员管理', '', 'vimeo-square', 6, 1479137720, 1479137720),
(16, 1, 15, '会员列表', '/member', '', 7, 1479137729, 1479137729),
(17, 1, 15, '会员登录日志', '/member/membervisitlog', '', 9, 1479137744, 1479137744),
(18, 1, 0, '帖子管理', '', 'edit', 1, 1479137773, 1479137773),
(19, 1, 18, '帖子列表', '/post', '', 3, 1479137780, 1479137780),
(20, 1, 18, '帖子分类列表', '/post/category', '', 2, 1479137791, 1479137829),
(21, 1, 18, '标签列表', '/post/tag', '', 4, 1479137805, 1479137805),
(22, 1, 0, '权限管理', '', 'users', 16, 1479137849, 1479137849),
(23, 1, 22, '角色列表', '/rbac', '', 17, 1479137868, 1479137868),
(24, 1, 22, '权限节点列表', '/rbac/node', '', 18, 1479137877, 1479138099),
(25, 1, 0, '轮播图列表', '/slideshow', 'tachometer', 11, 1479137911, 1479137911),
(26, 1, 15, '授权管理列表', '/auth', '', 8, 1480868147, 1480868147),
(27, 3, 0, '文章列表', '/post/list', '', 0, 1482068829, 1482068829);

-- --------------------------------------------------------

--
-- 表的结构 `s_post`
--

CREATE TABLE IF NOT EXISTS `s_post` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(100) NOT NULL COMMENT '标题',
  `category_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '所属类型',
  `image` varchar(255) NOT NULL DEFAULT '' COMMENT '图片',
  `intro` varchar(255) NOT NULL DEFAULT '' COMMENT '简介',
  `content` text COMMENT '内容',
  `slug` varchar(50) NOT NULL COMMENT 'url 链接头',
  `order` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '排序',
  `count` int(11) NOT NULL DEFAULT '0' COMMENT '浏览次数',
  `seo_title` varchar(100) NOT NULL DEFAULT '' COMMENT 'SEO-标题',
  `seo_keywords` varchar(100) NOT NULL DEFAULT '' COMMENT 'SEO-关键词',
  `seo_description` varchar(255) NOT NULL DEFAULT '' COMMENT 'SEO-描述',
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '0=不可用,1=可用',
  `comment_status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '0=可评论,1=不可评论',
  `published_at` int(11) NOT NULL DEFAULT '631152000' COMMENT '发布时间',
  `created_at` int(11) NOT NULL DEFAULT '631152000',
  `updated_at` int(11) NOT NULL DEFAULT '631152000',
  PRIMARY KEY (`id`),
  KEY `idx_normal` (`status`,`order`,`published_at`),
  KEY `idx_category` (`category_id`,`status`,`order`,`published_at`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='帖子' AUTO_INCREMENT=9 ;

--
-- 转存表中的数据 `s_post`
--

INSERT INTO `s_post` (`id`, `title`, `category_id`, `image`, `intro`, `content`, `slug`, `order`, `count`, `seo_title`, `seo_keywords`, `seo_description`, `status`, `comment_status`, `published_at`, `created_at`, `updated_at`) VALUES
(7, '测试一下', 1, 'uploads/2016/09/14/2016091418524075541.jpg', '', '<p>测试测试测试测试测试测试测试测试..</p>', 'test', 0, 145, '测试一下', '测试一下,测试一下', '测试一下,测试一下,测试一下', 1, 1, 1477872000, 1476806126, 1482069890),
(8, '少时诵诗书', 0, '', '测是一下', '<p>是啥啥啥啥啥啥</p>', '', 0, 14, '', '', '', 1, 1, 1477008000, 1477025177, 1480951686);

-- --------------------------------------------------------

--
-- 表的结构 `s_post_category`
--

CREATE TABLE IF NOT EXISTS `s_post_category` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `parent_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '所属父类',
  `name` varchar(50) NOT NULL COMMENT '分类名称',
  `slug` varchar(50) NOT NULL COMMENT 'url 链接头',
  `order` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '排序',
  `seo_title` varchar(100) NOT NULL DEFAULT '' COMMENT 'SEO-标题',
  `seo_keywords` varchar(100) NOT NULL DEFAULT '' COMMENT 'SEO-关键词',
  `seo_description` varchar(255) NOT NULL DEFAULT '' COMMENT 'SEO-描述',
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '0=不可用,1=可用',
  `created_at` int(11) NOT NULL DEFAULT '631152000',
  `updated_at` int(11) NOT NULL DEFAULT '631152000',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='帖子分类' AUTO_INCREMENT=4 ;

--
-- 转存表中的数据 `s_post_category`
--

INSERT INTO `s_post_category` (`id`, `parent_id`, `name`, `slug`, `order`, `seo_title`, `seo_keywords`, `seo_description`, `status`, `created_at`, `updated_at`) VALUES
(1, 0, '测试父类', '', 0, '', '', '', 1, 1476607447, 1476608423),
(3, 1, '另外的测试', '', 0, '另外的测试分类', '', '', 1, 631152000, 1482069486);

-- --------------------------------------------------------

--
-- 表的结构 `s_post_tag`
--

CREATE TABLE IF NOT EXISTS `s_post_tag` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(20) NOT NULL COMMENT '标签名称',
  `created_at` int(11) NOT NULL DEFAULT '631152000',
  `updated_at` int(11) NOT NULL DEFAULT '631152000',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='帖子标签' AUTO_INCREMENT=4 ;

--
-- 转存表中的数据 `s_post_tag`
--

INSERT INTO `s_post_tag` (`id`, `name`, `created_at`, `updated_at`) VALUES
(1, '测试标签', 1476719694, 1476719694),
(3, '测试', 1477025246, 1477025246);

-- --------------------------------------------------------

--
-- 表的结构 `s_post_tag_post`
--

CREATE TABLE IF NOT EXISTS `s_post_tag_post` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `post_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '帖子 id',
  `tag_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '标签 id',
  PRIMARY KEY (`id`),
  KEY `post_id` (`post_id`,`tag_id`),
  KEY `tag_id` (`tag_id`,`post_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='帖子标签' AUTO_INCREMENT=180 ;

--
-- 转存表中的数据 `s_post_tag_post`
--

INSERT INTO `s_post_tag_post` (`id`, `post_id`, `tag_id`) VALUES
(179, 7, 3),
(160, 8, 1),
(161, 8, 3);

-- --------------------------------------------------------

--
-- 表的结构 `s_setting`
--

CREATE TABLE IF NOT EXISTS `s_setting` (
  `id` tinyint(1) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL DEFAULT '' COMMENT '网站\r\n名称',
  `title` varchar(100) NOT NULL DEFAULT '' COMMENT '网站标题',
  `logo` varchar(255) NOT NULL DEFAULT '' COMMENT 'LOGO',
  `keyword` varchar(255) NOT NULL DEFAULT '' COMMENT '网站关键词(多个以,分割)',
  `description` varchar(255) NOT NULL DEFAULT '' COMMENT '网站描述',
  `email` varchar(255) NOT NULL DEFAULT '' COMMENT '邮箱',
  `backend_menu_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '后台菜单栏 id',
  `frontend_menu_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '前台菜单栏 id',
  `about_us` text NOT NULL COMMENT '关于我们描述',
  `copyright` varchar(1000) NOT NULL DEFAULT '' COMMENT '版权所有',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='网站基本配置' AUTO_INCREMENT=2 ;

--
-- 转存表中的数据 `s_setting`
--

INSERT INTO `s_setting` (`id`, `name`, `title`, `logo`, `keyword`, `description`, `email`, `backend_menu_id`, `frontend_menu_id`, `about_us`, `copyright`) VALUES
(1, 'Smister', 'YiiCMS', 'uploads/2016/09/14/2016091418524075541.jpg', 'smister,yii', 'smister,yii', 'smister@qq.com', 1, 3, '<p>sadfasdf</p>', '<p class="pull-left">&copy; DeluxCms 2016-2018</p>\r\n<p class="pull-right"><a href="http://www.smister.com">smister.com</a></p>');

-- --------------------------------------------------------

--
-- 表的结构 `s_slideshow`
--

CREATE TABLE IF NOT EXISTS `s_slideshow` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(100) NOT NULL COMMENT '标题',
  `image` varchar(255) NOT NULL DEFAULT '' COMMENT '图片',
  `link` varchar(255) NOT NULL DEFAULT '' COMMENT '链接',
  `description` varchar(255) NOT NULL DEFAULT '' COMMENT '简介',
  `order` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '排序',
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '0=不可用,1=可用',
  `created_at` int(11) NOT NULL DEFAULT '631152000',
  `updated_at` int(11) NOT NULL DEFAULT '631152000',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='轮播图' AUTO_INCREMENT=7 ;

--
-- 转存表中的数据 `s_slideshow`
--

INSERT INTO `s_slideshow` (`id`, `title`, `image`, `link`, `description`, `order`, `status`, `created_at`, `updated_at`) VALUES
(2, '测试轮播图1', 'uploads/2016/10/25/2016102517392380537.jpg', 'http://www.smister.com', 'smister', 0, 1, 1476287329, 1477409968),
(3, '测试', 'uploads/2016/10/25/2016102517392380537.jpg', 'http://www.smister.com', '测试测试测试', 1, 1, 1477410015, 1481534315),
(4, '11111111', 'uploads/2016/10/25/2016102517392380537.jpg', 'http://www.smister.com', '测试222222222', 0, 1, 1477410026, 1477410026),
(5, '测试222222', 'uploads/2016/10/25/2016102517392380537.jpg', 'http://www.smister.com', 's测试sdsddssd', 0, 1, 1477410040, 1477410040),
(6, '嗯嗯嗯嗯', 'uploads/2016/10/25/2016102517392380537.jpg', 'http://www.smister.com', 'sss刷刷刷', 0, 1, 1481884690, 1481884690);

-- --------------------------------------------------------

--
-- 表的结构 `s_sms_send_log`
--

CREATE TABLE IF NOT EXISTS `s_sms_send_log` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `is_validate` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '是否验证',
  `device_num` varchar(100) NOT NULL COMMENT '设备（例邮箱）',
  `number` varchar(10) NOT NULL COMMENT '号码',
  `created_at` int(11) NOT NULL DEFAULT '631152000',
  `expire_time` int(11) NOT NULL DEFAULT '300' COMMENT '过期时间',
  PRIMARY KEY (`id`),
  KEY `device_num` (`device_num`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='验证发送日志' AUTO_INCREMENT=23 ;

--
-- 转存表中的数据 `s_sms_send_log`
--

INSERT INTO `s_sms_send_log` (`id`, `is_validate`, `device_num`, `number`, `created_at`, `expire_time`) VALUES
(1, 0, '398009951@qq.com', '480943', 631152000, 300),
(2, 0, '398009951@qq.com', '628840', 1478188516, 300),
(3, 1, '398009951@qq.com', '495252', 1478188918, 300),
(4, 0, '398009951@qq.com', '154341', 1478189683, 300),
(5, 0, '398009951@qq.com', '567855', 1478190508, 300),
(6, 0, '398009951@qq.com', '227893', 1478190713, 300),
(7, 0, '398009951@qq.com', '711352', 1478190773, 300),
(8, 0, '398009951@qq.com', '300091', 1478530747, 300),
(9, 1, '398009951@qq.com', '175339', 1478530949, 300),
(10, 0, '398009951@qq.com', '494577', 1478531054, 300),
(11, 1, '398009951@qq.com', '336979', 1478531221, 300),
(12, 1, '398009951@qq.com', '409692', 1478533112, 300),
(13, 1, '398009951@qq.com', '131251', 1478533234, 300),
(14, 1, '398009951@qq.com', '514705', 1478533367, 300),
(15, 0, '398009951@qq.com', '281068', 1479740149, 300),
(16, 1, '398009951@qq.com', '559185', 1479914769, 300),
(17, 1, '398009951@qq.com', '747287', 1479915608, 300),
(18, 1, '398009951@qq.com', '179729', 1479995970, 300),
(19, 1, '398009951@qq.com', '199948', 1479997245, 300),
(20, 0, '398009951@qq.com', '691915', 1479997663, 300),
(21, 1, '398009951@qq.com', '355996', 1479997754, 300),
(22, 1, '398009951@qq.com', '247096', 1479997899, 300);

-- --------------------------------------------------------

--
-- 表的结构 `s_test`
--

CREATE TABLE IF NOT EXISTS `s_test` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `username` varchar(255) NOT NULL DEFAULT '' COMMENT '用户名',
  `status` smallint(1) unsigned NOT NULL DEFAULT '1' COMMENT '状态',
  `created_at` int(11) NOT NULL DEFAULT '631152000' COMMENT '创建时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='测试表' AUTO_INCREMENT=3 ;

--
-- 转存表中的数据 `s_test`
--

INSERT INTO `s_test` (`id`, `username`, `status`, `created_at`) VALUES
(1, 'smister', 1, 1234567890),
(2, 'smister4', 1, 1234567890);

-- --------------------------------------------------------

--
-- 表的结构 `s_user`
--

CREATE TABLE IF NOT EXISTS `s_user` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(255) NOT NULL DEFAULT '' COMMENT '用户名',
  `auth_key` varchar(32) NOT NULL DEFAULT '' COMMENT '密钥',
  `password_hash` varchar(255) NOT NULL DEFAULT '' COMMENT '密码',
  `password_reset_token` varchar(255) NOT NULL DEFAULT '' COMMENT '密码重置令牌',
  `email` varchar(255) NOT NULL DEFAULT '' COMMENT '邮箱',
  `status` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '状态[0=禁用,1=开启]',
  `created_at` int(11) NOT NULL DEFAULT '631152000' COMMENT '创建时间',
  `updated_at` int(11) NOT NULL DEFAULT '631152000' COMMENT '更新时间',
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='后台用户表' AUTO_INCREMENT=2 ;

--
-- 转存表中的数据 `s_user`
--

INSERT INTO `s_user` (`id`, `username`, `auth_key`, `password_hash`, `password_reset_token`, `email`, `status`, `created_at`, `updated_at`) VALUES
(1, 'smister', '', '$2y$13$88yaR5cF/zUUOZor.d1Hh.qBmIx86Zki/wPa0wgIcK4vYv/pg7yf6', '', 'smister@qq.com', 1, 1472302756, 1482071224);

-- --------------------------------------------------------

--
-- 表的结构 `s_user_visit_log`
--

CREATE TABLE IF NOT EXISTS `s_user_visit_log` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `ip` varchar(15) NOT NULL DEFAULT '' COMMENT '登录 ip',
  `user_agent` varchar(255) NOT NULL DEFAULT '' COMMENT '用户代理',
  `browser` varchar(30) NOT NULL DEFAULT '' COMMENT '浏览器',
  `os` varchar(20) NOT NULL DEFAULT '' COMMENT '操作系统',
  `user_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '用户',
  `visit_time` int(11) NOT NULL DEFAULT '631152000' COMMENT '登陆时间',
  PRIMARY KEY (`id`),
  KEY `visit_log_user_id` (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='用户登录日志' AUTO_INCREMENT=80 ;

--
-- 转存表中的数据 `s_user_visit_log`
--

INSERT INTO `s_user_visit_log` (`id`, `ip`, `user_agent`, `browser`, `os`, `user_id`, `visit_time`) VALUES
(1, '127.0.0.1', 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:48.0) Gecko/20100101 Firefox/48.0', 'Firefox', 'Windows', 1, 1472389953),
(2, '127.0.0.1', 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:48.0) Gecko/20100101 Firefox/48.0', 'Firefox', 'Windows', 1, 1472484889),
(3, '127.0.0.1', 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:48.0) Gecko/20100101 Firefox/48.0', 'Firefox', 'Windows', 1, 1472485173),
(4, '127.0.0.1', 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:48.0) Gecko/20100101 Firefox/48.0', 'Firefox', 'Windows', 1, 1472563118),
(5, '127.0.0.1', 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:48.0) Gecko/20100101 Firefox/48.0', 'Firefox', 'Windows', 1, 1472563510),
(6, '127.0.0.1', 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:48.0) Gecko/20100101 Firefox/48.0', 'Firefox', 'Windows', 1, 1472657934),
(7, '127.0.0.1', 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:48.0) Gecko/20100101 Firefox/48.0', 'Firefox', 'Windows', 1, 1472791920),
(8, '127.0.0.1', 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:48.0) Gecko/20100101 Firefox/48.0', 'Firefox', 'Windows', 1, 1473087865),
(9, '127.0.0.1', 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:48.0) Gecko/20100101 Firefox/48.0', 'Firefox', 'Windows', 1, 1473088919),
(10, '127.0.0.1', 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:48.0) Gecko/20100101 Firefox/48.0', 'Firefox', 'Windows', 1, 1473174290),
(11, '127.0.0.1', 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:48.0) Gecko/20100101 Firefox/48.0', 'Firefox', 'Windows', 1, 1473264285),
(12, '127.0.0.1', 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:48.0) Gecko/20100101 Firefox/48.0', 'Firefox', 'Windows', 1, 1473344198),
(13, '127.0.0.1', 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:48.0) Gecko/20100101 Firefox/48.0', 'Firefox', 'Windows', 1, 1473600957),
(14, '127.0.0.1', 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:48.0) Gecko/20100101 Firefox/48.0', 'Firefox', 'Windows', 1, 1473694758),
(15, '127.0.0.1', 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:48.0) Gecko/20100101 Firefox/48.0', 'Firefox', 'Windows', 1, 1473866794),
(16, '127.0.0.1', 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:48.0) Gecko/20100101 Firefox/48.0', 'Firefox', 'Windows', 1, 1473866853),
(17, '127.0.0.1', 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:48.0) Gecko/20100101 Firefox/48.0', 'Firefox', 'Windows', 1, 1473867489),
(18, '127.0.0.1', 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:48.0) Gecko/20100101 Firefox/48.0', 'Firefox', 'Windows', 1, 1473868007),
(19, '127.0.0.1', 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:48.0) Gecko/20100101 Firefox/48.0', 'Firefox', 'Windows', 1, 1473869367),
(20, '127.0.0.1', 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:48.0) Gecko/20100101 Firefox/48.0', 'Firefox', 'Windows', 1, 1473869456),
(21, '127.0.0.1', 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:48.0) Gecko/20100101 Firefox/48.0', 'Firefox', 'Windows', 1, 1473870329),
(22, '127.0.0.1', 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:48.0) Gecko/20100101 Firefox/48.0', 'Firefox', 'Windows', 1, 1474125025),
(23, '127.0.0.1', 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:48.0) Gecko/20100101 Firefox/48.0', 'Firefox', 'Windows', 1, 1474298769),
(24, '127.0.0.1', 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:48.0) Gecko/20100101 Firefox/48.0', 'Firefox', 'Windows', 1, 1474299776),
(25, '127.0.0.1', 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:48.0) Gecko/20100101 Firefox/48.0', 'Firefox', 'Windows', 1, 1474385585),
(26, '127.0.0.1', 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:48.0) Gecko/20100101 Firefox/48.0', 'Firefox', 'Windows', 1, 1474385655),
(27, '127.0.0.1', 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:48.0) Gecko/20100101 Firefox/48.0', 'Firefox', 'Windows', 1, 1474386688),
(28, '127.0.0.1', 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:48.0) Gecko/20100101 Firefox/48.0', 'Firefox', 'Windows', 1, 1474464788),
(29, '127.0.0.1', 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:48.0) Gecko/20100101 Firefox/48.0', 'Firefox', 'Windows', 1, 1474464844),
(30, '127.0.0.1', 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:48.0) Gecko/20100101 Firefox/48.0', 'Firefox', 'Windows', 1, 1474465647),
(31, '127.0.0.1', 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:48.0) Gecko/20100101 Firefox/48.0', 'Firefox', 'Windows', 1, 1474465712),
(32, '127.0.0.1', 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:48.0) Gecko/20100101 Firefox/48.0', 'Firefox', 'Windows', 1, 1474467533),
(33, '127.0.0.1', 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:48.0) Gecko/20100101 Firefox/48.0', 'Firefox', 'Windows', 1, 1474467635),
(34, '127.0.0.1', 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:48.0) Gecko/20100101 Firefox/48.0', 'Firefox', 'Windows', 1, 1474469287),
(35, '127.0.0.1', 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:48.0) Gecko/20100101 Firefox/48.0', 'Firefox', 'Windows', 1, 1474469353),
(36, '127.0.0.1', 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:48.0) Gecko/20100101 Firefox/48.0', 'Firefox', 'Windows', 1, 1474469389),
(37, '127.0.0.1', 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:48.0) Gecko/20100101 Firefox/48.0', 'Firefox', 'Windows', 1, 1474469433),
(38, '127.0.0.1', 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:48.0) Gecko/20100101 Firefox/48.0', 'Firefox', 'Windows', 1, 1474556533),
(39, '127.0.0.1', 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:48.0) Gecko/20100101 Firefox/48.0', 'Firefox', 'Windows', 1, 1474559460),
(40, '127.0.0.1', 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:48.0) Gecko/20100101 Firefox/48.0', 'Firefox', 'Windows', 1, 1474559650),
(41, '127.0.0.1', 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:48.0) Gecko/20100101 Firefox/48.0', 'Firefox', 'Windows', 1, 1474814061),
(42, '127.0.0.1', 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:48.0) Gecko/20100101 Firefox/48.0', 'Firefox', 'Windows', 1, 1474815474),
(43, '127.0.0.1', 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:48.0) Gecko/20100101 Firefox/48.0', 'Firefox', 'Windows', 1, 1475164430),
(44, '127.0.0.1', 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:48.0) Gecko/20100101 Firefox/48.0', 'Firefox', 'Windows', 1, 1475834039),
(45, '127.0.0.1', 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:48.0) Gecko/20100101 Firefox/48.0', 'Firefox', 'Windows', 1, 1476026675),
(46, '127.0.0.1', 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:48.0) Gecko/20100101 Firefox/48.0', 'Firefox', 'Windows', 1, 1476114361),
(47, '127.0.0.1', 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:48.0) Gecko/20100101 Firefox/48.0', 'Firefox', 'Windows', 1, 1476115832),
(48, '127.0.0.1', 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:48.0) Gecko/20100101 Firefox/48.0', 'Firefox', 'Windows', 1, 1476286219),
(49, '127.0.0.1', 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:48.0) Gecko/20100101 Firefox/48.0', 'Firefox', 'Windows', 1, 1476607425),
(50, '127.0.0.1', 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:48.0) Gecko/20100101 Firefox/48.0', 'Firefox', 'Windows', 1, 1476719667),
(51, '127.0.0.1', 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:49.0) Gecko/20100101 Firefox/49.0', 'Firefox', 'Windows', 1, 1476805763),
(52, '127.0.0.1', 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:49.0) Gecko/20100101 Firefox/49.0', 'Firefox', 'Windows', 1, 1477023696),
(53, '127.0.0.1', 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:49.0) Gecko/20100101 Firefox/49.0', 'Firefox', 'Windows', 1, 1477323480),
(54, '127.0.0.1', 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:49.0) Gecko/20100101 Firefox/49.0', 'Firefox', 'Windows', 1, 1477409925),
(55, '127.0.0.1', 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:49.0) Gecko/20100101 Firefox/49.0', 'Firefox', 'Windows', 1, 1477579712),
(56, '127.0.0.1', 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:49.0) Gecko/20100101 Firefox/49.0', 'Firefox', 'Windows', 1, 1478016281),
(57, '127.0.0.1', 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:49.0) Gecko/20100101 Firefox/49.0', 'Firefox', 'Windows', 1, 1479136267),
(58, '127.0.0.1', 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:49.0) Gecko/20100101 Firefox/49.0', 'Firefox', 'Windows', 1, 1479136373),
(59, '127.0.0.1', 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:49.0) Gecko/20100101 Firefox/49.0', 'Firefox', 'Windows', 1, 1479136381),
(60, '127.0.0.1', 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:49.0) Gecko/20100101 Firefox/49.0', 'Firefox', 'Windows', 1, 1479136389),
(61, '127.0.0.1', 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:49.0) Gecko/20100101 Firefox/49.0', 'Firefox', 'Windows', 1, 1479136400),
(62, '127.0.0.1', 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:49.0) Gecko/20100101 Firefox/49.0', 'Firefox', 'Windows', 1, 1479136408),
(63, '127.0.0.1', 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:49.0) Gecko/20100101 Firefox/49.0', 'Firefox', 'Windows', 1, 1479136514),
(64, '127.0.0.1', 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:49.0) Gecko/20100101 Firefox/49.0', 'Firefox', 'Windows', 1, 1479136526),
(65, '127.0.0.1', 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:49.0) Gecko/20100101 Firefox/49.0', 'Firefox', 'Windows', 1, 1479136539),
(66, '127.0.0.1', 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:49.0) Gecko/20100101 Firefox/49.0', 'Firefox', 'Windows', 1, 1479136698),
(67, '127.0.0.1', 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:49.0) Gecko/20100101 Firefox/49.0', 'Firefox', 'Windows', 1, 1479136759),
(68, '127.0.0.1', 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:50.0) Gecko/20100101 Firefox/50.0', 'Firefox', 'Windows', 1, 1480868089),
(69, '127.0.0.1', 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:50.0) Gecko/20100101 Firefox/50.0', 'Firefox', 'Windows', 1, 1481533790),
(70, '127.0.0.1', 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:50.0) Gecko/20100101 Firefox/50.0', 'Firefox', 'Windows', 1, 1481815657),
(71, '127.0.0.1', 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:50.0) Gecko/20100101 Firefox/50.0', 'Firefox', 'Windows', 1, 1481884672),
(72, '127.0.0.1', 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:50.0) Gecko/20100101 Firefox/50.0', 'Firefox', 'Windows', 1, 1482042006),
(73, '127.0.0.1', 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:50.0) Gecko/20100101 Firefox/50.0', 'Firefox', 'Windows', 1, 1482067769),
(74, '127.0.0.1', 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:50.0) Gecko/20100101 Firefox/50.0', 'Firefox', 'Windows', 1, 1482070638),
(75, '127.0.0.1', 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:50.0) Gecko/20100101 Firefox/50.0', 'Firefox', 'Windows', 1, 1482070831),
(76, '127.0.0.1', 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:50.0) Gecko/20100101 Firefox/50.0', 'Firefox', 'Windows', 1, 1482070839),
(77, '127.0.0.1', 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:50.0) Gecko/20100101 Firefox/50.0', 'Firefox', 'Windows', 3, 1482071191),
(78, '127.0.0.1', 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:50.0) Gecko/20100101 Firefox/50.0', 'Firefox', 'Windows', 1, 1482071215),
(79, '127.0.0.1', 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:50.0) Gecko/20100101 Firefox/50.0', 'Firefox', 'Windows', 1, 1482071233);

--
-- 限制导出的表
--

--
-- 限制表 `s_auth_assignment`
--
ALTER TABLE `s_auth_assignment`
  ADD CONSTRAINT `s_auth_assignment_ibfk_1` FOREIGN KEY (`item_name`) REFERENCES `s_auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- 限制表 `s_auth_item`
--
ALTER TABLE `s_auth_item`
  ADD CONSTRAINT `s_auth_item_ibfk_1` FOREIGN KEY (`rule_name`) REFERENCES `s_auth_rule` (`name`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- 限制表 `s_auth_item_child`
--
ALTER TABLE `s_auth_item_child`
  ADD CONSTRAINT `s_auth_item_child_ibfk_1` FOREIGN KEY (`parent`) REFERENCES `s_auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `s_auth_item_child_ibfk_2` FOREIGN KEY (`child`) REFERENCES `s_auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
