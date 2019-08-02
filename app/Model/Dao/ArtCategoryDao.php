<?php

namespace App\Model\Dao;

use App\Model\Entity\FsArtCategory;
use Swoft\Bean\Annotation\Mapping\Bean;

/**
 *
 * @Bean()
 */
class ArtCategoryDao
{
    /**
     * 获取所有
     * @return mixed
     */
    public function getAll()
    {
        return FsArtCategory::findAll()->getResult();
    }

    /**
     * 获取热度初始分数
     * @param $artCategoryId
     * @return mixed
     */
    public function getScore($artCategoryId)
    {
        return FsArtCategory::findById($artCategoryId, [ 'field' => ['score']])->getResult();
    }

}
