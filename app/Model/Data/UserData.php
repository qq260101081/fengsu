<?php

namespace App\Model\Data;

use App\Model\Dao\UserDao;
use Swoft\Bean\Annotation\Mapping\Bean;
use Swoft\Bean\Annotation\Mapping\Inject;

/**
 *
 * @Bean()
 */
class UserData
{
    /**
     *
     * @Inject()
     * @var UserDao
     */
    private $userDao;

    /**
     * 指定用户ID查找用户是否存在
     * @param $userId
     * @return mixed
     */
    public function existById($userId)
    {
        return $this->userDao->existById($userId);
    }

    /**
     * 更新用户资料
     *
     * @param $field
     * @param $userId
     * @return int
     * @throws \ReflectionException
     * @throws \Swoft\Bean\Exception\ContainerException
     * @throws \Swoft\Db\Exception\DbException
     */
    public function updateInfo($field, $userId)
    {
        $field['update_time'] = time();
        return $this->userDao->updateField($field, $userId);
    }

    /**
     * 删除收藏
     *
     * @param $userId
     * @param $collectionId
     * @return int
     * @throws \ReflectionException
     * @throws \Swoft\Bean\Exception\ContainerException
     * @throws \Swoft\Db\Exception\DbException
     */
    public function delCollection($userId, $collectionId)
    {
        return $this->userDao->delCollection($userId, $collectionId);
    }

    /**
     * 删除浏览记录
     * @param $userId
     * @param $recordId
     * @return mixed
     */
    public function delRecord($userId, $recordId)
    {
        return $this->userDao->delRecord($userId, $recordId);
    }
}
