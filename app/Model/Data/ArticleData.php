<?php

namespace App\Model\Data;

use App\Model\Dao\ArticleDao;
use Swoft\Bean\Annotation\Mapping\Bean;
use Swoft\Bean\Annotation\Mapping\Inject;

/**
 *
 * @Bean()
 */
class ArticleData
{
    /**
     *
     * @Inject()
     * @var ArticleDao
     */
    private $articleDao;

    public function getSubscribeList($userId, $page)
    {
        return $this->articleDao->getSubscribeList($userId, $page);
    }

    public function getRecommendList($page)
    {
        return $this->articleDao->getRecommendList($page);
    }

    /**
     * 获取文章最新发布列表
     * @param $page
     * @return \Swoft\Stdlib\Collection
     * @throws \ReflectionException
     * @throws \Swoft\Bean\Exception\ContainerException
     * @throws \Swoft\Db\Exception\DbException
     */
    public function getNewList($page)
    {
        return $this->articleDao->getNewList($page);
    }

    public function getCategoryList($categoryId, $page)
    {
        return $this->articleDao->getCategoryList($categoryId, $page);
    }

    public function getDetail($randomId)
    {
        return $this->articleDao->getDetail($randomId);
    }

    /**
     * 文章是否存在
     *
     * @param $randomId
     * @param int $status
     * @return object|\Swoft\Db\Eloquent\Builder|\Swoft\Db\Eloquent\Model|null
     * @throws \ReflectionException
     * @throws \Swoft\Bean\Exception\ContainerException
     * @throws \Swoft\Db\Exception\DbException
     */
    public function artExistByRandomId($randomId, $status = 1)
    {
        return $this->articleDao->artExistByRandomId($randomId, $status);
    }

    /**
     * 文章点赞
     * @param $userId
     * @param $artUserId
     * @param $artId
     * @return mixed
     * @throws \Swoft\Db\Exception\DbException
     */
    public function star($userId, $artUserId, $artId)
    {
        return $this->articleDao->star($userId, $artUserId, $artId);
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
        return $this->articleDao->collection($userId, $artUserId, $artId);
    }

    /**
     * 文章创建
     * @param $userId
     * @param $cid
     * @param $title
     * @param $contentQuality
     * @param $content
     * @param $hotScore
     * @param $imgList
     * @param $status
     * @param $pubTime
     * @return mixed
     * @throws \Swoft\Db\Exception\DbException
     */
    public function create( $userId, $cid, $title, $contentQuality, $content, $hotScore, $imgList, $status, $pubTime)
    {
        // 文章数据
        $artData = [
            'random_id' => strRand(),
            'user_id' => $userId,
            'art_category_id' => $cid,
            'title' => $title,
            'content_quality' =>  $contentQuality,
            'hot_score' => $hotScore,
            'status' => $status, // 默认已审核
            'province' => 440000, //默认广东省
            'city' => 440100, // 默认广州市
            'area' => 440106, // 默认天河区
            'create_time' => time(),
            'publish_time' => $pubTime,
        ];

        // 内容数据
        $contentData = ['content' => $content];

        // 图片数据
        $imgListData = [];
        foreach ($imgList as $k => $v)
        {
            $imgListData[$k]['url'] = $v;
        }
        return $this->articleDao->create($artData, $contentData, $imgListData);
    }
}
