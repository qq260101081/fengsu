<?php

namespace App\Model\Dao;

use Swoft\Bean\Annotation\Mapping\Bean;
use Swoft\Db\DB;

/**
 *
 * @Bean()
 */
class UserCenterDao
{
    private $_pageSize = 15;

    /**
     * 指定用户文章列表
     * @param $userId
     * @param $page
     * @return mixed
     * @throws \Swoft\Db\Exception\DbException
     */
    public function getArticleList($userId, $page)
    {
        $offset = ($page - 1) * $this->_pageSize;
        $sql = 'SELECT
            a.random_id,
            a.user_id,
            a.title,
            a.pv,
            a.rv,
            a.star,
            a.publish_time,
            b.nickname,
            b.avatar,
            GROUP_CONCAT(d.url ) AS imgs
        FROM
            fs_article a
            LEFT JOIN fs_user b ON a.user_id = b.user_id
            LEFT JOIN fs_art_content c ON a.art_id = c.art_id
            LEFT JOIN fs_art_img d ON a.art_id = d.art_id 
        WHERE a.status < 10 AND a.user_id = ' . $userId . '
        GROUP BY a.art_id  
        ORDER BY a.art_id DESC  
        LIMIT ' . $offset . ',' . $this->_pageSize;
        return DB::select($sql);
    }

    /**
     * 获取指定用户关注列表
     * @param $userId
     * @param $page
     * @return mixed
     * @throws \Swoft\Db\Exception\DbException
     */
    public function getSubscribeList($userId, $page)
    {
        $offset = ($page - 1) * $this->_pageSize;

        $sql = "SELECT
            a.subscribe_id,
            a.sub_user_id,
            a.status,
            b.sex,
            b.nickname,
            b.avatar,
            ( SELECT COUNT( 1 ) FROM fs_subscribe WHERE user_id = a.sub_user_id ) AS fans_num,
            ( SELECT COUNT( 1 ) FROM fs_article WHERE user_id = a.sub_user_id ) AS art_num 
        FROM
            `fs_subscribe` AS `a`
            LEFT JOIN fs_user AS b ON a.sub_user_id = b.user_id 
        WHERE
            a.user_id = {$userId}
        ORDER BY 
            a.subscribe_id DESC  
        LIMIT 
            {$offset}, {$this->_pageSize}";
        return DB::select($sql);
    }

    /**
     * 获取指定用户粉丝列表
     * @param $userId
     * @param $page
     * @return mixed
     * @throws \Swoft\Db\Exception\DbException
     */
    public function getFansList($userId, $page)
    {
        $offset = ($page - 1) * $this->_pageSize;

        $sql = "SELECT
            a.subscribe_id,
            a.user_id,
            b.sex,
            b.nickname,
            b.avatar,
            ( SELECT COUNT( 1 ) FROM fs_subscribe WHERE user_id = a.user_id ) AS fans_num,
            ( SELECT COUNT( 1 ) FROM fs_article WHERE user_id = a.user_id ) AS art_num,
            IFNULL( ( SELECT status FROM fs_subscribe WHERE user_id = 1 AND sub_user_id = a.user_id ), 1 ) AS status 
        FROM
            `fs_subscribe` AS `a`
            LEFT JOIN fs_user AS b ON a.user_id = b.user_id 
        WHERE
            a.sub_user_id = {$userId} 
            AND a.status = 0 
        ORDER BY
            a.subscribe_id DESC 
            LIMIT {$offset},
            {$this->_pageSize}";

        return DB::select($sql);
    }

    /**
     * 获取指定用户收藏列表
     * @param $userId
     * @param $page
     * @return mixed
     * @throws \Swoft\Db\Exception\DbException
     */
    public function getCollectionList($userId, $page)
    {
        $offset = ($page - 1) * $this->_pageSize;

        $sql = "SELECT
            a.collection_id,
            a.create_time,
            b.avatar,
            b.nickname,
            c.pv,
            c.rv,
            c.star,
            c.title,
            GROUP_CONCAT( d.url ) AS imgs,
            e.content 
        FROM
            fs_collection a
            LEFT JOIN fs_user b ON a.art_user_id = b.user_id
            LEFT JOIN fs_article c ON a.art_id = c.art_id
            LEFT JOIN fs_art_img d ON a.art_id = d.art_id
            LEFT JOIN fs_art_content e ON a.art_id = e.art_id 
        WHERE
            a.user_id = {$userId} AND a.status = 0
        GROUP BY
            a.collection_id 
        ORDER BY
            a.collection_id DESC 
            LIMIT {$offset},
            {$this->_pageSize}";
        return DB::select($sql);
    }

    /**
     * 获取指定用户收藏列表
     * @param $userId
     * @param $page
     * @return mixed
     * @throws \Swoft\Db\Exception\DbException
     */
    public function getRecordList($userId, $page)
    {
        $offset = ($page - 1) * $this->_pageSize;
        $sql = "SELECT
            a.record_id,
            a.create_time,
            b.avatar,
            b.nickname,
            c.pv,
            c.rv,
            c.star,
            c.title,
            GROUP_CONCAT( d.url ) AS imgs,
            e.content 
        FROM
            fs_record a
            LEFT JOIN fs_user b ON a.art_user_id = b.user_id
            LEFT JOIN fs_article c ON a.art_id = c.art_id
            LEFT JOIN fs_art_img d ON a.art_id = d.art_id
            LEFT JOIN fs_art_content e ON a.art_id = e.art_id 
        WHERE
            a.user_id = {$userId} AND a.status = 0
        GROUP BY
            a.record_id 
        ORDER BY
            a.record_id DESC 
            LIMIT {$offset},
            {$this->_pageSize}";

        return DB::select($sql);
    }
}
