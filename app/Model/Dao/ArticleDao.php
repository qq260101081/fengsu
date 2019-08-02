<?php

namespace App\Model\Dao;

use App\Model\Entity\FsArtContent;
use App\Model\Entity\Article;
use App\Model\Entity\FsArtImg;
use App\Model\Entity\Collection;
use App\Model\Entity\Star;
use Swoft\Bean\Annotation\Mapping\Bean;
use Swoft\Db\DB;

/**
 *
 * @Bean()
 */
class ArticleDao
{
    private $_pageSize = 15;

    /**
     * 获取关注文章列表
     * @param $userId
     * @param $page
     * @return mixed
     * @throws \Swoft\Db\Exception\DbException
     */
    public function getSubscribeList($userId, $page)
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
            b.avatar 
        FROM
            fs_article a
            LEFT JOIN fs_user b ON a.user_id = b.user_id
            LEFT JOIN fs_art_content c ON a.art_id = c.art_id
            LEFT JOIN fs_art_img d ON a.art_id = d.art_id 
        WHERE
            a.user_id IN ( SELECT sub_user_id FROM fs_subscribe WHERE user_id = ' . $userId . ' AND status = 0 )
        AND a.status = 1
        ORDER BY a.art_id DESC    
        LIMIT ' . $offset . ',' . $this->_pageSize;
        return DB::select($sql);
    }

    /**
     * 获取推荐文章列表
     * @param $page
     * @return mixed
     * @throws \Swoft\Db\Exception\DbException
     */
    public function getRecommendList($page)
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
            GROUP_CONCAT( d.url ) AS imgs,
	        (a.hot_score * 10000000 / (UNIX_TIMESTAMP() - a.publish_time))  AS score 
        FROM
            fs_article a
            LEFT JOIN fs_user b ON a.user_id = b.user_id
            LEFT JOIN fs_art_content c ON a.art_id = c.art_id
            LEFT JOIN fs_art_img d ON a.art_id = d.art_id 
        WHERE a.status = 1 AND a.content_quality = 0
        GROUP BY a.art_id   
        ORDER BY score DESC    
        LIMIT ' . $offset . ',' . $this->_pageSize;

        return DB::select($sql);
    }

    /**
     * 获取文章最新发布列表
     *
     * @param $page
     * @return array
     */
    public function getNewList($page)
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
        WHERE a.status = 1    
        GROUP BY a.art_id  
        ORDER BY a.publish_time DESC   
        LIMIT ' . $offset . ',' . $this->_pageSize;
        return DB::select($sql);
    }

    /**
     * 获取指定分类文章列表
     * @param $categoryId
     * @param $page
     * @return mixed
     * @throws \Swoft\Db\Exception\DbException
     */
    public function getCategoryList($categoryId, $page)
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
            b.avatar 
        FROM
            fs_article a
            LEFT JOIN fs_user b ON a.user_id = b.user_id
            LEFT JOIN fs_art_content c ON a.art_id = c.art_id
            LEFT JOIN fs_art_img d ON a.art_id = d.art_id 
        WHERE a.art_category_id = ' . $categoryId . '
        AND a.status = 1
        ORDER BY a.hot_score DESC    
        LIMIT ' . $offset . ',' . $this->_pageSize;
        return DB::select($sql);
    }

    /**
     * 获取文章详情
     * @param $randomId
     * @return mixed
     * @throws \Swoft\Db\Exception\DbException
     */
    public function getDetail($randomId)
    {
        $sql = "SELECT
                a.title,
                a.star,
                a.rv,
                a.collection,
                b.content
            FROM
                fs_article a
            LEFT JOIN fs_art_content b ON a.art_id = b.art_id
            WHERE a.random_id = '{$randomId}'";

        return DB::select($sql);
    }

    /**
     * 文章是否存在
     *
     * @param $randomId
     * @param $status
     * @return object|\Swoft\Db\Eloquent\Builder|\Swoft\Db\Eloquent\Model|null
     * @throws \ReflectionException
     * @throws \Swoft\Bean\Exception\ContainerException
     * @throws \Swoft\Db\Exception\DbException
     */
    public function artExistByRandomId($randomId, $status)
    {
        return Article::where(['random_id' => $randomId, 'status' => $status])->first(['art_id', 'user_id']);
    }

    /**
     * 文章点赞
     *
     * @param $userId
     * @param $artUserId
     * @param $artId
     * @return int
     * @throws \ReflectionException
     * @throws \Swoft\Bean\Exception\ContainerException
     * @throws \Swoft\Db\Exception\DbException
     */
    public function star($userId, $artUserId, $artId)
    {
        DB::beginTransaction();

        $result = Article::where('art_id', $artId)->increment('star', 1);

        $model = Star::new([
            'user_id' => $userId,
            'art_id' => $artId,
            'art_user_id' => $artUserId,
            'create_time' => time()
        ]);
        $model->save();
        $starId = $model->getStarId();
        if ($starId && $result)
        {
            DB::commit();
            return $starId;
        }
        DB::rollBack();
        return 0;
    }

    /**
     * 文章收藏
     * @param $userId
     * @param $artUserId
     * @param $artId
     * @return mixed
     * @throws \Swoft\Db\Exception\DbException
     */
    public function collection($userId, $artUserId, $artId)
    {
        DB::beginTransaction();

        $result = Article::where('art_id', $artId)->increment('collection', 1);

        $model = Collection::new([
            'user_id' => $userId,
            'art_id' => $artId,
            'art_user_id' => $artUserId,
            'create_time' => time(),
        ]);
        $model->save();
        $collectionId = $model->getCollectionId();

        if ($result && $collectionId)
        {
            DB::commit();
            return $collectionId;
        }

        DB::rollBack();
        return 0;

    }

    /**
     * 文章创建
     * @param $artData
     * @param $contentData
     * @param $imgListData
     * @return mixed
     * @throws \Swoft\Db\Exception\DbException
     */
    public function create($artData, $contentData, $imgListData)
    {
        Db::beginTransaction();

        // 文章表插入
        $artModel = new Article();
        $artId = $artModel->fill($artData)->save()->getResult();

        //文章内容表插入
        $contentModel = new FsArtContent();
        $contentData = array_merge($contentData, ['art_id' => $artId]);
        $contentModel->fill($contentData)->save()->getResult();

        // 文章图片表插入
        if ($imgListData)
        {
            $imgModel = new FsArtImg();
            foreach ($imgListData as $k => $v)
            {
                $imgListData[$k]['art_id'] = $artId;
            }
            $imgModel::batchInsert($imgListData)->getResult();
        }

        Db::commit();

        return $artData['random_id'];
    }

    /**
     * 指定用户ID查出除下架状态的所有文章总数
     * @param $userId
     * @return \Swoft\Core\ResultInterface
     */
    public function getAllNumByUserId($userId)
    {
        return Article::count('art_id', ['user_id' => $userId, ['status', '<', 10]]);
    }

    /**
     * 指定用户ID查出除下架状态的所有文章总数
     * @param $userId
     * @return \Swoft\Core\ResultInterface
     */
    public function getUserArticleNum($userId)
    {
        return Article::count('art_id', ['user_id' => $userId, ['status', '<', 10]]);
    }
}
