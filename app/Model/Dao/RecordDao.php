<?php

namespace App\Model\Dao;

use App\Model\Entity\FsRecord;
use Swoft\Bean\Annotation\Mapping\Bean;

/**
 *
 * @Bean()
 */
class RecordDao
{
    /**
     * 创建一条记录
     * @param $data
     * @return mixed
     */
    public function create($data)
    {
        $model = new FsRecord();
        return $model->fill($data)->save()->getResult();
    }

    /**
     * 更新一条数据
     * @param $data
     * @param $where
     * @return mixed
     */
    public function update($data, $where)
    {
        return FsRecord::updateOne($data, $where)->getResult();
    }

    /**
     * 浏览记录是否存在
     * @param $userId
     * @param $subUserId
     * @param $status
     * @return mixed
     */
    public function existRecord($userId, $status)
    {
        return FsRecord::findOne(
            ['user_id' => $userId, 'status' => $status]
        )->getResult();
    }

    /**
     * 获取指定用户的用户浏览记录总数
     * @param $userId
     * @return \Swoft\Core\ResultInterface
     */
    public function getRecordNum($userId)
    {
        return FsRecord::count('record_id', ['user_id' => $userId, 'status' => 0]);
    }

}
