<?php

namespace App\Model\Dao;

use App\Model\Entity\Collection;
use Swoft\Bean\Annotation\Mapping\Bean;
use Swoft\Db\DB;

/**
 *
 * @Bean()
 */
class CollectionDao
{
    /**
     * 文章是否已收藏过
     * @param $userId
     * @param $artId
     * @return object|\Swoft\Db\Eloquent\Builder|\Swoft\Db\Eloquent\Model|null
     * @throws \ReflectionException
     * @throws \Swoft\Bean\Exception\ContainerException
     * @throws \Swoft\Db\Exception\DbException
     */
    public function existCollection($userId, $artId)
    {
        return Collection::where(
            ['art_id' => $artId, 'user_id' => $userId]
        )->first(['collection_id', 'status']);
    }

    /**
     * 更新收藏状态
     *
     * @param $userId
     * @param $artId
     * @param $status
     * @return bool|int
     * @throws \ReflectionException
     * @throws \Swoft\Bean\Exception\ContainerException
     * @throws \Swoft\Db\Exception\DbException
     */
    public function updateStatus($userId, $artId, $status)
    {
        return Collection::where(['user_id' => $userId, 'art_id' => $artId])->first()
            ->update(['status' => $status, 'update_time' => time()]);
    }

    /**
     * 获取指定用户的收藏总数
     * @param $userId
     * @return \Swoft\Core\ResultInterface
     */
    public function getCollectionNum($userId)
    {
        return Collection::count('collection_id', ['user_id' => $userId, 'status' => 0]);
    }
}
