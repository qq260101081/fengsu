<?php

namespace App\Model\Dao;

use Swoft\Bean\Annotation\Mapping\Bean;
use Swoft\Db\DB;

/**
 *
 * @Bean()
 */
class ArtCommentDao
{
    private $_pageSize = 15;

    /*public function getList($userId, $page)
    {
        $offset = ($page - 1) * $this->_pageSize;
        $sql = 'SELECT
            a.random_id,
            a.user_id,
            a.title,
            a.pv,
            a.rv,
            a.star,
            b.nickname,
            b.avatar 
        FROM
            fs_article a
            LEFT JOIN fs_user b ON a.user_id = b.user_id
            LEFT JOIN fs_art_content c ON a.art_id = c.art_id
            LEFT JOIN fs_art_img d ON a.art_id = d.art_id 
        WHERE
            a.user_id IN ( SELECT sub_user_id FROM fs_subscribe WHERE user_id = ' . $userId . ' )
        ORDER BY a.art_id DESC    
        LIMIT ' . $offset . ',' . $this->_pageSize;
        return DB::select($sql);
    }*/

    public function getDefaultTwo($artId)
    {

        Db::query();
    }
}
