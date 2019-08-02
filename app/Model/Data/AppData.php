<?php

namespace App\Model\Data;

use App\Model\Dao\AppDao;
use Swoft\Bean\Annotation\Mapping\Bean;
use Swoft\Bean\Annotation\Mapping\Inject;

/**
 *
 * @Bean()
 */
class AppData
{
    /**
     *
     * @Inject()
     * @var AppDao
     */
    private $appDao;

    /**
     * 获取关于我们
     * @return mixed
     */
    public function getAbout()
    {
        return $this->appDao->getAbout();
    }

    /**
     * 获取APP最新版本号
     * @return mixed
     */
    public function getVersion()
    {
        return $this->appDao->getVersion();
    }
}
