<?php

namespace App\Model\Dao;

use App\Model\Entity\Feedback;
use Swoft\Bean\Annotation\Mapping\Bean;

/**
 *
 * @Bean()
 */
class FeedbackDao
{
    /**
     * 创建
     * @param $data
     * @return int
     * @throws \ReflectionException
     * @throws \Swoft\Bean\Exception\ContainerException
     * @throws \Swoft\Db\Exception\DbException
     */
    public function create($data)
    {
         $model = Feedback::new($data);
         $model->save();
         return $model->getId();
    }

}
