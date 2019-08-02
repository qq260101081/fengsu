<?php

namespace App\Model\Dao;

use App\Model\Entity\Collection;
use App\Model\Entity\Record;
use App\Model\Entity\User;
use Swoft\Bean\Annotation\Mapping\Bean;
use Swoft\Db\DB;

/**
 *
 * @Bean()
 * @uses      UserDao
 */
class UserDao
{
    /**
     * 指定ID获取一条
     * @param $userId
     * @return \Swoft\Core\ResultInterface
     */
    public function getOneById($userId)
    {
        return User::findById($userId);
    }

    /**
     * 指定ID获取指定字段
     * @param $userId
     * @param $fields
     * @return mixed
     * @throws \Swoft\Db\Exception\DbException
     */
    public function getFieldById($userId, $fields)
    {
        $fieldsStr = implode(',', $fields);
        $sql = "SELECT {$fieldsStr} FROM fs_user WHERE user_id = {$userId} LIMIT 1";
        return DB::select($sql);

       // return  User::findOne(['user_id' => $userId], ['fields' => $fields])->getResult();
    }

    /**
     * 指定用户ID查找用户是否存在
     * @param $userId
     * @return object|\Swoft\Db\Eloquent\Builder|\Swoft\Db\Eloquent\Model|null
     * @throws \ReflectionException
     * @throws \Swoft\Bean\Exception\ContainerException
     * @throws \Swoft\Db\Exception\DbException
     */
    public function existById($userId)
    {
        return User::where(['user_id' => $userId])->first(['user_id']);
    }

    /**
     * 指定用户ID更新字段
     * @param $data
     * @param $userId
     * @return int
     * @throws \ReflectionException
     * @throws \Swoft\Bean\Exception\ContainerException
     * @throws \Swoft\Db\Exception\DbException
     */
    public function updateField($data, $userId)
    {
        return User::where(['user_id' => $userId])->first()->update($data);
    }

    /**
     * 删除收藏（逻辑删除）
     * @param $userId
     * @param $collectionId
     * @return int
     * @throws \ReflectionException
     * @throws \Swoft\Bean\Exception\ContainerException
     * @throws \Swoft\Db\Exception\DbException
     */
    public function delCollection($userId, $collectionId)
    {
        return Collection::where(['user_id' => $userId, 'collection_id' => $collectionId])->update(['status' => 1]);
    }

    /**
     * 删除浏览记录（逻辑删除）
     * @param $userId
     * @param $recordId
     * @return int
     * @throws \ReflectionException
     * @throws \Swoft\Bean\Exception\ContainerException
     * @throws \Swoft\Db\Exception\DbException
     */
    public function delRecord($userId, $recordId)
    {
        return Record::where(['user_id' => $userId, 'record_id' => $recordId])->update(['status' => 1]);
    }

}
