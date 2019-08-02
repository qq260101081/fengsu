<?php

namespace App\Model\Data;

use App\Model\Dao\ArtCategoryDao;
use Swoft\Bean\Annotation\Mapping\Bean;
use Swoft\Bean\Annotation\Mapping\Inject;

/**
 *
 * @Bean()
 */
class ArtCategoryData
{
    /**
     *
     * @Inject()
     * @var ArtCategoryDao
     */
    private $artCategoryDao;

    /**
     * 获取所有
     * @return mixed
     */
    public function getAll()
    {
        return $this->artCategoryDao->getAll();
    }

    /**
     * 获取热度初始分数
     * @param $artCategoryId
     * @return mixed
     */
    public function getScore($artCategoryId)
    {
        return $this->artCategoryDao->getScore($artCategoryId);
    }
}
