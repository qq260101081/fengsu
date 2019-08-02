<?php

namespace App\Model\Dao;

use App\Model\Entity\FsArtCategory;
use Swoft\Bean\Annotation\Mapping\Bean;

/**
 *
 * @Bean()
 */
class AppDao
{
    /**
     * 获取关于我们
     * @return mixed
     */
    public function getAbout()
    {
        return ['about' => '2019年7月份上线“风俗"APP'];
    }

    /**
     * 获取版本号
     * @return mixed
     */
    public function getVersion()
    {
        return ['version' => '1.0'];
    }

}
