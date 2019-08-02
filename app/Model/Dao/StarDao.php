<?php

namespace App\Model\Dao;

use App\Model\Entity\Star;
use Swoft\Bean\Annotation\Mapping\Bean;

/**
 *
 * @Bean()
 */
class StarDao
{
    /**
     * 文章是否已点赞过
     *
     * @param $userId
     * @param $artId
     * @return object|\Swoft\Db\Eloquent\Builder|\Swoft\Db\Eloquent\Model|null
     * @throws \ReflectionException
     * @throws \Swoft\Bean\Exception\ContainerException
     * @throws \Swoft\Db\Exception\DbException
     */
    public function existStar($userId, $artId)
    {
        return Star::where(
            ['art_id' => $artId, 'user_id' => $userId]
        )->first(['star_id', 'status']);
    }

    /**
     * 更新点赞状态
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
        return Star::where(['user_id' => $userId, 'art_id' => $artId])->first()
            ->update(['status' => $status, 'update_time' => time()]);
    }
}
