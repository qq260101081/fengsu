/*
 Navicat Premium Data Transfer

 Source Server         : 本地mac装的数据库
 Source Server Type    : MySQL
 Source Server Version : 50726
 Source Host           : localhost:3306
 Source Schema         : fengsu

 Target Server Type    : MySQL
 Target Server Version : 50726
 File Encoding         : 65001

 Date: 02/08/2019 22:43:22
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for fs_administer
-- ----------------------------
DROP TABLE IF EXISTS `fs_administer`;
CREATE TABLE `fs_administer` (
  `administer_id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键',
  `roles_id` int(11) NOT NULL COMMENT '角色ID',
  `username` varchar(15) NOT NULL COMMENT '用户名',
  `password` varchar(255) NOT NULL COMMENT '使用php的password_hash函数生成的密码',
  `disable` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '禁用状态 1禁止登陆 0正常',
  `login_num` mediumint(8) unsigned NOT NULL DEFAULT '0' COMMENT '登录次数',
  `last_login_ip` varchar(128) NOT NULL DEFAULT '' COMMENT '最后登录IP',
  `last_login_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '最后登录时间',
  `update_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '更新时间',
  `create_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  PRIMARY KEY (`administer_id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 ROW_FORMAT=DYNAMIC COMMENT='后台管理员表';

-- ----------------------------
-- Table structure for fs_app_config
-- ----------------------------
DROP TABLE IF EXISTS `fs_app_config`;
CREATE TABLE `fs_app_config` (
  `app_config_id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键',
  `name` varchar(10) NOT NULL COMMENT 'app名称',
  `start_img` varchar(255) NOT NULL COMMENT '启动图，url',
  `logo` varchar(255) NOT NULL COMMENT 'app的logo',
  `login_expires_in` varchar(255) NOT NULL COMMENT '登录有效期，时间到后需要用户重新登录',
  `update_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '更新时间',
  `create_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  PRIMARY KEY (`app_config_id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 ROW_FORMAT=DYNAMIC COMMENT='APP配置表';

-- ----------------------------
-- Table structure for fs_art_category
-- ----------------------------
DROP TABLE IF EXISTS `fs_art_category`;
CREATE TABLE `fs_art_category` (
  `art_category_id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键ID',
  `name` varchar(18) NOT NULL DEFAULT '' COMMENT '分类名称',
  `score` decimal(8,1) unsigned NOT NULL DEFAULT '0.0' COMMENT '热度分',
  `create_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `update_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '更新时间',
  PRIMARY KEY (`art_category_id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='文章分类表';

-- ----------------------------
-- Table structure for fs_art_comment
-- ----------------------------
DROP TABLE IF EXISTS `fs_art_comment`;
CREATE TABLE `fs_art_comment` (
  `art_comment_id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键ID',
  `art_id` int(11) unsigned NOT NULL COMMENT '话题ID',
  `comment_user_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '发表评论用户的id',
  `parent_comment_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '被回复的评论的id',
  `parent_comment_user_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '被回复的评论的user_id',
  `belong_comment_id` int(10) NOT NULL COMMENT '从属的话题一级评论',
  `content` varchar(250) CHARACTER SET utf8mb4 NOT NULL COMMENT '评论内容',
  `type` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '评论类型 1文章的评论 2文章的评论的回复',
  `star` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '点赞数',
  `is_read` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '1已读  0未读',
  `status` tinyint(3) unsigned NOT NULL DEFAULT '1' COMMENT '状态：1正常2涉敏感10删除',
  `update_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '更新时间',
  `create_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  PRIMARY KEY (`art_comment_id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='话题评论表';

-- ----------------------------
-- Table structure for fs_art_comment_star
-- ----------------------------
DROP TABLE IF EXISTS `fs_art_comment_star`;
CREATE TABLE `fs_art_comment_star` (
  `art_comment_star_id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键ID',
  `art_id` int(11) unsigned NOT NULL COMMENT '文章ID',
  `art_comment_id` int(11) unsigned NOT NULL COMMENT '被点赞的评论的ID',
  `art_comment_user_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '被点赞的评论的用户id',
  `star_user_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '点赞的用户的id',
  `status` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '0已点赞1取消点赞',
  `create_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `update_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '更新时间',
  `is_read` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '1已读  0未读',
  PRIMARY KEY (`art_comment_star_id`) USING BTREE,
  KEY `

topic_id` (`art_id`) USING BTREE,
  KEY `create_time` (`create_time`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='文章点赞表';

-- ----------------------------
-- Table structure for fs_art_content
-- ----------------------------
DROP TABLE IF EXISTS `fs_art_content`;
CREATE TABLE `fs_art_content` (
  `art_id` int(10) unsigned NOT NULL COMMENT '外键文章ID',
  `content` text CHARACTER SET utf8mb4 NOT NULL COMMENT '文章内容',
  PRIMARY KEY (`art_id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='文章内容表';

-- ----------------------------
-- Table structure for fs_art_img
-- ----------------------------
DROP TABLE IF EXISTS `fs_art_img`;
CREATE TABLE `fs_art_img` (
  `art_img_id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键ID',
  `art_id` int(11) unsigned DEFAULT '0' COMMENT '文章ID',
  `url` varchar(255) NOT NULL DEFAULT '' COMMENT '图片地址',
  PRIMARY KEY (`art_img_id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='文章图片表';

-- ----------------------------
-- Table structure for fs_article
-- ----------------------------
DROP TABLE IF EXISTS `fs_article`;
CREATE TABLE `fs_article` (
  `art_id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键ID',
  `random_id` char(22) NOT NULL DEFAULT '' COMMENT '随机ID',
  `user_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '用户ID',
  `art_category_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '分类ID',
  `title` varchar(150) NOT NULL DEFAULT '' COMMENT '标题',
  `hot_score` decimal(10,1) unsigned NOT NULL DEFAULT '0.0' COMMENT '热度分',
  `pv` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '浏览数',
  `rv` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '评论数',
  `collection` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '收藏数',
  `star` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '点赞数',
  `status` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '1已审2敏感词3举报10下架',
  `province` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '省编码',
  `city` int(10) unsigned DEFAULT '0' COMMENT '市编码',
  `area` int(10) unsigned DEFAULT '0' COMMENT '区编码',
  `content_quality` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '内容质量0正常，1为全中文且小于10个字',
  `create_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `update_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '更新时间',
  `top_end_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '置顶结束时间',
  `publish_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '发布时间',
  PRIMARY KEY (`art_id`) USING BTREE,
  KEY `hot_score` (`hot_score`) USING BTREE,
  KEY `status` (`status`) USING BTREE,
  KEY `top_end_time` (`top_end_time`) USING BTREE,
  KEY `user_id` (`user_id`) USING BTREE,
  KEY `random_id` (`random_id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='文章表';

-- ----------------------------
-- Table structure for fs_collection
-- ----------------------------
DROP TABLE IF EXISTS `fs_collection`;
CREATE TABLE `fs_collection` (
  `collection_id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键ID',
  `art_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '文章ID',
  `user_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '用户ID',
  `art_user_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '文章所属用户ID',
  `status` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '0收藏中1已删除',
  `create_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `update_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '更新时间',
  `is_read` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '1已读  0未读',
  PRIMARY KEY (`collection_id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='文章收藏表';

-- ----------------------------
-- Table structure for fs_comment_msg
-- ----------------------------
DROP TABLE IF EXISTS `fs_comment_msg`;
CREATE TABLE `fs_comment_msg` (
  `comment_msg_id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键ID',
  `art_topic_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '文章ID或话题ID',
  `user_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '评论用户ID',
  `comment_user_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '被评论用户ID',
  `comment_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '评论表ID',
  `type` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '评论类型，0文章1话题',
  `status` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '0未读1已读2删除',
  `create_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `update_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '更新时间',
  PRIMARY KEY (`comment_msg_id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='评论消息表';

-- ----------------------------
-- Table structure for fs_disabled_word
-- ----------------------------
DROP TABLE IF EXISTS `fs_disabled_word`;
CREATE TABLE `fs_disabled_word` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `content` varchar(20) NOT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  FULLTEXT KEY `content` (`content`) /*!50100 WITH PARSER `ngram` */ 
) ENGINE=MyISAM AUTO_INCREMENT=14101 DEFAULT CHARSET=utf8mb4 ROW_FORMAT=DYNAMIC COMMENT='敏感词库';

-- ----------------------------
-- Table structure for fs_feedback
-- ----------------------------
DROP TABLE IF EXISTS `fs_feedback`;
CREATE TABLE `fs_feedback` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键ID',
  `user_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '用户ID',
  `version` char(10) DEFAULT '' COMMENT 'APP版本',
  `content` varchar(600) NOT NULL COMMENT '内容',
  `create_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `update_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '更新时间',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='反馈表';

-- ----------------------------
-- Table structure for fs_manager_login_log
-- ----------------------------
DROP TABLE IF EXISTS `fs_manager_login_log`;
CREATE TABLE `fs_manager_login_log` (
  `login_log_id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键',
  `mannager_id` tinyint(1) unsigned NOT NULL COMMENT '管理员表id',
  `action_path` varchar(255) NOT NULL COMMENT '操作的路径',
  `disable` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '禁用状态 1禁止登陆 0正常',
  `login_num` mediumint(8) unsigned NOT NULL DEFAULT '0' COMMENT '登录次数',
  `last_login_ip` varchar(128) NOT NULL COMMENT '最后登录IP',
  `last_login_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '最后登录时间',
  `update_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '更新时间',
  `create_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  PRIMARY KEY (`login_log_id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 ROW_FORMAT=DYNAMIC;

-- ----------------------------
-- Table structure for fs_menu
-- ----------------------------
DROP TABLE IF EXISTS `fs_menu`;
CREATE TABLE `fs_menu` (
  `menu_id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键',
  `name` varchar(10) NOT NULL COMMENT '菜单名称',
  `icon` varchar(255) NOT NULL COMMENT '菜单图标，存图标路径',
  `display` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '0 正常  1禁用',
  `sort` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '排序，从大到小排序',
  `update_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '更新时间',
  `create_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '添加时间',
  PRIMARY KEY (`menu_id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=45 DEFAULT CHARSET=utf8mb4 ROW_FORMAT=DYNAMIC;

-- ----------------------------
-- Table structure for fs_notice
-- ----------------------------
DROP TABLE IF EXISTS `fs_notice`;
CREATE TABLE `fs_notice` (
  `notice_id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键ID',
  `type` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '消息类型：0通知',
  `status` tinyint(3) unsigned NOT NULL DEFAULT '1' COMMENT '消息状态：1正常显示2删除',
  `title` varchar(90) NOT NULL COMMENT '标题',
  `content` text NOT NULL COMMENT '内容',
  `send_crowd` varchar(60) NOT NULL COMMENT '发送人群',
  `is_send` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '是否已发送 0未发送 1已发送',
  `timing_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '定时发送时间',
  `create_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `update_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '更新时间\r\n',
  PRIMARY KEY (`notice_id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='系统通知表';

-- ----------------------------
-- Table structure for fs_notice_msg
-- ----------------------------
DROP TABLE IF EXISTS `fs_notice_msg`;
CREATE TABLE `fs_notice_msg` (
  `notice_msg_id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键ID',
  `user_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '用户ID',
  `notice_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '通知ID',
  `create_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `update_time` int(11) unsigned NOT NULL DEFAULT '0',
  `is_read` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '1已读  0未读',
  PRIMARY KEY (`notice_msg_id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='通知消息表';

-- ----------------------------
-- Table structure for fs_permission
-- ----------------------------
DROP TABLE IF EXISTS `fs_permission`;
CREATE TABLE `fs_permission` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键',
  `path` varchar(50) NOT NULL COMMENT '权限路径',
  `mark` varchar(255) NOT NULL DEFAULT '' COMMENT '备注',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 ROW_FORMAT=DYNAMIC;

-- ----------------------------
-- Table structure for fs_record
-- ----------------------------
DROP TABLE IF EXISTS `fs_record`;
CREATE TABLE `fs_record` (
  `record_id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键ID',
  `art_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '文章ID',
  `art_user_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '文章所属用户ID',
  `user_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '用户ID',
  `status` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '0正常1已删除',
  `create_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `update_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '更新时间',
  PRIMARY KEY (`record_id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='浏历史表';

-- ----------------------------
-- Table structure for fs_region
-- ----------------------------
DROP TABLE IF EXISTS `fs_region`;
CREATE TABLE `fs_region` (
  `region_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(30) NOT NULL DEFAULT '',
  `code` char(15) NOT NULL DEFAULT '',
  `parent_code` char(15) NOT NULL DEFAULT '',
  `level` tinyint(1) unsigned DEFAULT '9',
  PRIMARY KEY (`region_id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=4103 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='地区表';

-- ----------------------------
-- Table structure for fs_roles
-- ----------------------------
DROP TABLE IF EXISTS `fs_roles`;
CREATE TABLE `fs_roles` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键',
  `name` varchar(20) NOT NULL COMMENT '角色名称',
  `parent_id` int(11) NOT NULL DEFAULT '0' COMMENT '父级角色ID',
  `permissions` varchar(255) NOT NULL COMMENT '权限id, json格式',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 ROW_FORMAT=DYNAMIC COMMENT='后台管理员角色表';

-- ----------------------------
-- Table structure for fs_star
-- ----------------------------
DROP TABLE IF EXISTS `fs_star`;
CREATE TABLE `fs_star` (
  `star_id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键ID',
  `user_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '用户ID',
  `art_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '文章ID',
  `art_user_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '文章所属用户ID',
  `status` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '0已点赞1取消点赞',
  `create_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `update_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '更新时间',
  `is_read` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '1已读  0未读',
  PRIMARY KEY (`star_id`) USING BTREE,
  KEY `user_id` (`user_id`) USING BTREE,
  KEY `art_id` (`art_id`) USING BTREE,
  KEY `art_user_id` (`art_user_id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='文章点赞表';

-- ----------------------------
-- Table structure for fs_star_collection_msg
-- ----------------------------
DROP TABLE IF EXISTS `fs_star_collection_msg`;
CREATE TABLE `fs_star_collection_msg` (
  `star_collection_msg_id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键ID',
  `art_topic_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '文章或话题ID',
  `user_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '评论用户ID',
  `art_user_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '被评论用户ID',
  `type` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '消息类型，0文章点赞1文章评论点赞2话题评论点赞3收藏',
  `comment_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '评论表主键ID',
  `status` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '0未读1已读2删除',
  `create_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `update_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '更新时间',
  PRIMARY KEY (`star_collection_msg_id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='点赞关注消息表';

-- ----------------------------
-- Table structure for fs_subscribe
-- ----------------------------
DROP TABLE IF EXISTS `fs_subscribe`;
CREATE TABLE `fs_subscribe` (
  `subscribe_id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键ID',
  `user_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '用户ID',
  `sub_user_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '被关注的用户ID',
  `status` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '0关注中1取消关注',
  `create_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `update_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '更新时间',
  PRIMARY KEY (`subscribe_id`) USING BTREE,
  KEY `uid_suid` (`user_id`,`sub_user_id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='关注表';

-- ----------------------------
-- Table structure for fs_topic
-- ----------------------------
DROP TABLE IF EXISTS `fs_topic`;
CREATE TABLE `fs_topic` (
  `topic_id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键ID',
  `random_id` char(22) NOT NULL DEFAULT '' COMMENT '随机ID',
  `title` varchar(150) NOT NULL COMMENT '标题',
  `pic_list` varchar(300) NOT NULL DEFAULT '' COMMENT '图片列表',
  `good` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '正方点赞数',
  `bad` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '反方点赞数',
  `good_title` varchar(45) NOT NULL COMMENT '正方的标题描述',
  `bad_title` varchar(45) NOT NULL COMMENT '反方的标题描述',
  `status` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '0正常1下架',
  `update_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '更新时间',
  `create_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  PRIMARY KEY (`topic_id`) USING BTREE,
  KEY `random_id` (`random_id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='话题表';

-- ----------------------------
-- Table structure for fs_topic_comment
-- ----------------------------
DROP TABLE IF EXISTS `fs_topic_comment`;
CREATE TABLE `fs_topic_comment` (
  `topic_comment_id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键ID',
  `topic_id` int(11) unsigned NOT NULL COMMENT '话题ID',
  `comment_user_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '发表评论用户的id',
  `parent_comment_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '被回复的评论的id',
  `parent_comment_user_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '被回复的评论的user_id',
  `belong_comment_id` int(10) NOT NULL COMMENT '从属的话题一级评论',
  `content` varchar(250) CHARACTER SET utf8mb4 NOT NULL COMMENT '评论内容',
  `type` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '评论类型 1话题的评论 2话题的评论的回复',
  `star` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '点赞数',
  `is_read` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '1已读  0未读',
  `status` tinyint(3) unsigned NOT NULL DEFAULT '1' COMMENT '状态：1正常2涉敏感10删除',
  `update_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '更新时间',
  `create_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  PRIMARY KEY (`topic_comment_id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='话题评论表';

-- ----------------------------
-- Table structure for fs_topic_comment_star
-- ----------------------------
DROP TABLE IF EXISTS `fs_topic_comment_star`;
CREATE TABLE `fs_topic_comment_star` (
  `topic_comment_star_id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '话题点赞表主键',
  `topic_id` int(11) unsigned NOT NULL COMMENT '话题ID',
  `topic_comment_id` int(11) unsigned NOT NULL COMMENT '被点赞的评论的ID',
  `topic_comment_user_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '被点赞的评论所属的用户的id',
  `star_user_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '点赞的用户的id',
  `status` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '0已点赞1取消点赞',
  `update_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '更新时间',
  `create_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  `is_read` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '1已读  0未读',
  PRIMARY KEY (`topic_comment_star_id`) USING BTREE,
  KEY `

topic_id` (`topic_id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='话题点赞表';

-- ----------------------------
-- Table structure for fs_topic_vote
-- ----------------------------
DROP TABLE IF EXISTS `fs_topic_vote`;
CREATE TABLE `fs_topic_vote` (
  `topic_vote_id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键ID',
  `user_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '用户ID',
  `topic_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '话题ID',
  `vote_type` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '投票类型 1正方 2反方',
  `update_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `create_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`topic_vote_id`) USING BTREE,
  KEY `random_id` (`user_id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='话题投票记录表';

-- ----------------------------
-- Table structure for fs_user
-- ----------------------------
DROP TABLE IF EXISTS `fs_user`;
CREATE TABLE `fs_user` (
  `user_id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键ID',
  `phone` char(11) NOT NULL COMMENT '手机号',
  `nickname` varchar(20) NOT NULL DEFAULT '' COMMENT '用户昵称',
  `password` varchar(64) NOT NULL DEFAULT '' COMMENT '登录密码',
  `avatar` varchar(255) NOT NULL DEFAULT '' COMMENT '头像地址',
  `sex` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '性别1男2女0未知',
  `birthday` char(10) NOT NULL DEFAULT '' COMMENT '生日',
  `province` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '省编码',
  `city` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '市编码',
  `area` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '区编码',
  `signature` varchar(300) NOT NULL DEFAULT '' COMMENT '个性签名',
  `status` tinyint(3) unsigned NOT NULL DEFAULT '1' COMMENT '1正常2禁用',
  `create_time` int(11) NOT NULL DEFAULT '0' COMMENT '创建时间',
  `update_time` int(11) NOT NULL DEFAULT '0' COMMENT '更新时间',
  `last_login_time` int(11) NOT NULL DEFAULT '0' COMMENT '最后登录时间',
  PRIMARY KEY (`user_id`) USING BTREE,
  UNIQUE KEY `phone` (`phone`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='用户表';

SET FOREIGN_KEY_CHECKS = 1;
