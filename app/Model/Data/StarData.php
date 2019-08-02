<?php

namespace App\Model\Data;

use App\Model\Dao\StarDao;
use Swoft\Bean\Annotation\Mapping\Bean;
use Swoft\Bean\Annotation\Mapping\Inject;

/**
 *
 * @Bean()
 */
class StarData
{
    /**
     *
     * @Inject()
     * @var StarDao
     */
    private $starDao;

    /**
     * 文章是否已存在点赞
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
        return $this->starDao->existStar($userId, $artId);
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
        return $this->starDao->updateStatus($userId, $artId, $status);
    }
}
