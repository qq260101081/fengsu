<?php

namespace App\Model\Data;

use App\Model\Dao\CollectionDao;
use Swoft\Bean\Annotation\Mapping\Bean;
use Swoft\Bean\Annotation\Mapping\Inject;

/**
 *
 * @Bean()
 */
class CollectionData
{
    /**
     *
     * @Inject()
     * @var CollectionDao
     */
    private $collectionDao;

    /**
     * 文章是否已存在收藏
     *
     * @param $userId
     * @param $artId
     * @return object|\Swoft\Db\Eloquent\Builder|\Swoft\Db\Eloquent\Model|null
     * @throws \ReflectionException
     * @throws \Swoft\Bean\Exception\ContainerException
     * @throws \Swoft\Db\Exception\DbException
     */
    public function existCollection($userId, $artId)
    {
        return $this->collectionDao->existCollection($userId, $artId);
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
        return $this->collectionDao->updateStatus($userId, $artId, $status);
    }
}
