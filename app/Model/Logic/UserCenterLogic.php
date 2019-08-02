<?php
namespace App\Model\Logic;

use Swoft\Bean\Annotation\Mapping\Bean;
use App\Model\Data\UserCenterData;
use Swoft\Bean\Annotation\Mapping\Inject;

/**
 * 用户中心逻辑层
 * @Bean()
 * @uses      UserCenterLogic
 */
class UserCenterLogic
{
    /**
     * @Inject()
     * @var UserCenterData
     */
    private $userCenterData;

    /**
     * 用户主页
     * @param $userId
     * @return array
     */
    public function index($userId)
    {
        $resData = [];
        $resData['user'] = $this->userCenterData->getUserInfo($userId);
        $resData['article_num'] = $this->userCenterData->getUserArticleNum($userId);
        $resData['subscribe_num'] = $this->userCenterData->getSubscribeNum($userId);
        $resData['fans_num'] = $this->userCenterData->getFansNum($userId);
        $resData['collection_num'] = $this->userCenterData->getCollectionNum($userId);
        $resData['record_num'] = $this->userCenterData->getRecordNum($userId);
        return ['data' => $resData, 'code' => '0'];
    }

    /** 获取指定用户文章列表
     * @param $userId
     * @param $page
     * @return mixed
     * @throws \Swoft\Db\Exception\DbException
     */
    public function articleList($userId, $page)
    {
        $data = $this->userCenterData->getArticleList($userId, $page);
        return ['data' => $data, 'code' => '0'];
    }

    /** 获取指定用户关注列表
     * @param $userId
     * @param $page
     * @return mixed
     * @throws \Swoft\Db\Exception\DbException
     */
    public function subscribeList($userId, $page)
    {
        $data = $this->userCenterData->getSubscribeList($userId, $page);
        return ['data' => $data, 'code' => '0'];
    }

    /** 获取指定用户粉丝列表
     * @param $userId
     * @param $page
     * @return mixed
     * @throws \Swoft\Db\Exception\DbException
     */
    public function fansList($userId, $page)
    {
        $data = $this->userCenterData->getFansList($userId, $page);
        return ['data' => $data, 'code' => '0'];
    }

    /** 获取用户编辑页面信息
     * @param $userId
     * @return mixed
     * @throws \Swoft\Db\Exception\DbException
     */
    public function userEditInfo($userId)
    {
        $data = $this->userCenterData->getUserEditInfo($userId);
        return ['data' => $data, 'code' => '0'];
    }

    /**
     * 获取指定用户收藏列表
     * @param $userId
     * @param $page
     * @return array
     * @throws \Swoft\Db\Exception\DbException
     */
    public function collectionList($userId, $page)
    {
        $data = $this->userCenterData->getCollectionList($userId, $page);
        return ['data' => $data, 'code' => '0'];
    }

    /**
     * 获取指定用户浏览记录列表
     * @param $userId
     * @param $page
     * @return array
     * @throws \Swoft\Db\Exception\DbException
     */
    public function recordList($userId, $page)
    {
        $data = $this->userCenterData->getRecordList($userId, $page);
        return ['data' => $data, 'code' => '0'];
    }


}