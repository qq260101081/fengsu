<?php
/**
 * This file is part of Swoft.
 *
 * @link https://swoft.org
 * @document https://doc.swoft.org
 * @contact group@swoft.org
 * @license https://github.com/swoft-cloud/swoft/blob/master/LICENSE
 */

namespace App\Model\Logic;

use Swoft\Bean\Annotation\Mapping\Bean;
use App\Model\Data\SubscribeData;
use App\Model\Data\UserData;
use Swoft\Bean\Annotation\Mapping\Inject;

/**
 * 用户逻辑层
 * @Bean()
 * @uses      UserLogic
 */
class UserLogic
{
    /**
     * @Inject()
     * @var UserData
     */
    private $userData;

    /**
     *
     * @Inject()
     * @var SubscribeData
     */
    private $subscribeData;

    /**
     * 关注用户
     * @param int $userId
     * @param int $subUserId
     * @return array
     */
    public function subscribe(int $userId, int $subUserId)
    {
        // 被关注用户是否存在
        $result = $this->userData->existById($subUserId);
        if (!$result)
        {
            return ['data' => [], 'code' => '10500'];
        }

        // 是否已存在关注
        $result = $this->subscribeData->existSubscribe($userId, $subUserId);
        if($result)
        {
            if ($result['status'] == 0)
            {
                return ['data' => [], 'code' => '0'];
            }
            else
            {
                $result = $this->subscribeData->upSubscribe($userId, $subUserId);
                if ($result){
                    return ['data' => [], 'code' => '0'];
                }
            }
        }
        else
        {
            // 插入关注记录
            $result = $this->subscribeData->subscribe($userId, $subUserId);
            if ($result){
                return ['data' => [], 'code' => '0'];
            }
        }
        return ['data' => [], 'code' => '1'];
    }

    /**
     * 取消关注
     * @param int $userId
     * @param int $subUserId
     * @return array
     */
    public function unSubscribe(int $userId, int $subUserId)
    {
        // 是否已存在关注
        $result = $this->subscribeData->existSubscribe($userId, $subUserId);

        if (!$result)
        {
            return ['data' => [], 'code' => '0'];
        }

        // 更新关注状态
        $result = $this->subscribeData->unSubscribe($userId, $subUserId);
        if (!$result){
            return ['data' => [], 'code' => '1'];
        }
        return ['data' => [], 'code' => '0'];
    }

    /**
     * 更新用户资料
     * @param $params
     * @param $userId
     * @return array
     */
    public function updateInfo($params, $userId)
    {
        // 判断用户合法
        if (isset($params['nickname']))
        {
            $nicknameLen = mb_strlen($params['nickname'], 'UTF8');
            if ($nicknameLen < 2 || $nicknameLen > 20)
            {
                return ['data' => [], 'code' => '10501'];
            }
        }
        isset($params['sex']) && (int)$params['sex'];
        // 判断生日合法
        if(isset($params['birthday']))
        {
            $birthday = strtotime($params['birthday']);
            if (!$birthday || date('Y', strtotime($birthday)) < 1940)
            {
                return ['data' => [], 'code' => '10502'];
            }
        }

        $result = $this->userData->updateInfo($params, $userId);

        if ($result)
        {
            return ['data' => [], 'code' => '0'];
        }

        return ['data' => [], 'code' => '1'];
    }

    /**
     * 删除收藏
     * @param $userId
     * @param $collectionId
     * @return mixed
     */
    public function delCollection($userId, $collectionId)
    {
        $result = $this->userData->delCollection($userId, $collectionId);
        if ($result)
        {
            return ['data' => [], 'code' => '0'];
        }
        return ['data' => [], 'code' => '1'];
    }

    /**
     * 删除浏览记录
     * @param $userId
     * @param $recordId
     * @return mixed
     */
    public function delRecord($userId, $recordId)
    {
        $result = $this->userData->delRecord($userId, $recordId);
        if ($result)
        {
            return ['data' => [], 'code' => '0'];
        }
        return ['data' => [], 'code' => '1'];
    }

}