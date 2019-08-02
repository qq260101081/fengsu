<?php

namespace App\Model\Data;

use App\Model\Dao\CollectionDao;
use App\Model\Dao\RecordDao;
use App\Model\Dao\SubscribeDao;
use App\Model\Dao\ArticleDao;
use App\Model\Dao\UserCenterDao;
use App\Model\Dao\UserDao;
use Swoft\Bean\Annotation\Mapping\Bean;
use Swoft\Bean\Annotation\Mapping\Inject;

/**
 *
 * @Bean()
 */
class UserCenterData
{
    /**
     *
     * @Inject()
     * @var RecordDao
     */
    private $recordDao;

    /**
     *
     * @Inject()
     * @var ArticleDao
     */
    private $articleDao;

    /**
     *
     * @Inject()
     * @var UserDao
     */
    private $userDao;

    /**
     *
     * @Inject()
     * @var UserCenterDao
     */
    private $userCenterDao;

    /**
     *
     * @Inject()
     * @var SubscribeDao
     */
    private $subscribeDao;

    /**
     * @Inject()
     * @var CollectionDao
     */
    private $collectionDao;

    /**
     * 指定用户ID获取指定字段信息
     * @param $userId
     * @return \Swoft\Core\ResultInterface
     */
    public function getUserInfo($userId)
    {
        return $this->userDao->getFieldById($userId, [
            'user_id',
            'nickname',
            'avatar'
        ]);
    }

    /**
     * 获取指定用户ID修改信息
     * @param $userId
     * @return \Swoft\Core\ResultInterface
     */
    public function getUserEditInfo($userId)
    {
        return $this->userDao->getFieldById($userId, [
            'avatar',
            'nickname',
            'sex',
            'birthday',
            'province',
            'city',
            'area',
            'signature'
        ]);
    }

    /**
     * 指定用户ID查出除下架状态的所有文章总数
     * @param $userId
     * @return \Swoft\Core\ResultInterface
     */
    public function getUserArticleNum($userId)
    {
        return $this->articleDao->getAllNumByUserId($userId);
    }

    /**
     * 获取指定用户的用户关注总数
     * @param $userId
     * @return \Swoft\Core\ResultInterface
     */
    public function getSubscribeNum($userId)
    {
        return $this->subscribeDao->getSubscribeNum($userId);
    }

    /**
     * 获取指定用户的粉丝总数
     * @param $userId
     * @return \Swoft\Core\ResultInterface
     */
    public function getFansNum($userId)
    {
        return $this->subscribeDao->getFansNum($userId);
    }

    /**
     * 获取指定用户的收藏总数
     * @param $userId
     * @return \Swoft\Core\ResultInterface
     */
    public function getCollectionNum($userId)
    {
        return $this->collectionDao->getCollectionNum($userId);
    }

    /**
     * 获取指定用户的浏览记录总数
     * @param $userId
     * @return \Swoft\Core\ResultInterface
     */
    public function getRecordNum($userId)
    {
        return $this->recordDao->getRecordNum($userId);
    }

    /**
     * 获取指定用户文章列表
     * @param $userId
     * @param $apge
     * @return mixed
     * @throws \Swoft\Db\Exception\DbException
     */
    public function getArticleList($userId, $apge)
    {
        return $this->userCenterDao->getArticleList($userId, $apge);
    }

    /**
     * 获取指定用户关注列表
     * @param $userId
     * @param $apge
     * @return mixed
     * @throws \Swoft\Db\Exception\DbException
     */
    public function getSubscribeList($userId, $apge)
    {
        return $this->userCenterDao->getSubscribeList($userId, $apge);
    }

    /**
     * 获取指定用户粉丝列表
     * @param $userId
     * @param $apge
     * @return mixed
     * @throws \Swoft\Db\Exception\DbException
     */
    public function getFansList($userId, $apge)
    {
        return $this->userCenterDao->getFansList($userId, $apge);
    }

    /**
     * 获取指定用户收藏列表
     * @param $userId
     * @param $apge
     * @return mixed
     * @throws \Swoft\Db\Exception\DbException
     */
    public function getCollectionList($userId, $apge)
    {
        return $this->userCenterDao->getCollectionList($userId, $apge);
    }

    /**
     * 获取指定用户浏览记录列表
     * @param $userId
     * @param $apge
     * @return mixed
     * @throws \Swoft\Db\Exception\DbException
     */
    public function getRecordList($userId, $apge)
    {
        return $this->userCenterDao->getRecordList($userId, $apge);
    }

}
