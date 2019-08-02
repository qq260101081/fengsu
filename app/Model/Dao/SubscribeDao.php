<?php

namespace App\Model\Dao;

use App\Model\Entity\Subscribe;
use Swoft\Bean\Annotation\Mapping\Bean;

/**
 *
 * @Bean()
 */
class SubscribeDao
{
    /**
     * 创建一条记录
     *
     * @param $data
     * @return int
     * @throws \ReflectionException
     * @throws \Swoft\Bean\Exception\ContainerException
     * @throws \Swoft\Db\Exception\DbException
     */
    public function create($data)
    {
        $model = Subscribe::new($data);
        $model->save();
        return $model->getUserId();
    }

    /**
     * 更新一条数据
     * @param $data
     * @param $where
     * @return mixed
     */
    public function update($data, $where)
    {
        return Subscribe::where($where)->first()->update($data);
    }

    /**
     * 关注是否存在
     * @param $userId
     * @param $subUserId
     * @return object|\Swoft\Db\Eloquent\Builder|\Swoft\Db\Eloquent\Model|null
     * @throws \ReflectionException
     * @throws \Swoft\Bean\Exception\ContainerException
     * @throws \Swoft\Db\Exception\DbException
     */
    public function existSubscribe($userId, $subUserId)
    {
        return Subscribe::where(
            ['user_id' => $userId, 'sub_user_id' => $subUserId]
        )->first(['status']);
    }

    /**
     * 获取指定用户的用户关注总数
     * @param $userId
     * @return \Swoft\Core\ResultInterface
     */
    public function getSubscribeNum($userId)
    {
        return Subscribe::count('subscribe_id', ['user_id' => $userId, 'status' => 0]);
    }

    /**
     * 获取指定用户的粉丝总数
     * @param $userId
     * @return \Swoft\Core\ResultInterface
     */
    public function getFansNum($userId)
    {
        return Subscribe::count('subscribe_id', ['sub_user_id' => $userId, 'status' => 0]);
    }


}
