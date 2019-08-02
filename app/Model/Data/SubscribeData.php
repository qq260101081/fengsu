<?php

namespace App\Model\Data;

use App\Model\Dao\SubscribeDao;
use Swoft\Bean\Annotation\Mapping\Bean;
use Swoft\Bean\Annotation\Mapping\Inject;

/**
 *
 * @Bean()
 */
class SubscribeData
{
    /**
     *
     * @Inject()
     * @var SubscribeDao
     */
    private $subscribeDao;

    /**
     * 关注用户
     * @param $userId
     * @param $subUserId
     * @return mixed
     */
    public function subscribe($userId, $subUserId)
    {
        $data = [
            'user_id' => $userId,
            'sub_user_id' => $subUserId,
            'create_time' => time(),
        ];
        return $this->subscribeDao->create($data);
    }

    /**
     * 取消关注
     * @param $userId
     * @param $subUserId
     * @return mixed
     */
    public function unSubscribe($userId, $subUserId)
    {
        $data = [
            'status' => 1,
            'update_time' => time(),
        ];
        $where = ['user_id' => $userId, 'sub_user_id' => $subUserId];
        return $this->subscribeDao->update($data, $where);
    }

    /**
     * 更新关注状态
     *
     * @param $userId
     * @param $subUserId
     * @return mixed
     */
    public function upSubscribe($userId, $subUserId)
    {
        $data = [
            'status' => 0,
            'create_time' => time(),
            'update_time' => time(),
        ];
        $where = ['user_id' => $userId, 'sub_user_id' => $subUserId];
        return $this->subscribeDao->update($data, $where);
    }

    /**
     * 关注是否已存在
     * @param $userId
     * @param $subUserId
     * @param int $status
     * @return mixed
     */
    public function existSubscribe($userId, $subUserId)
    {
        return $this->subscribeDao->existSubscribe($userId, $subUserId);
    }

}
