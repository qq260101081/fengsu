<?php
namespace App\Model\Logic;

use App\Model\Data\AppData;
use Swoft\Bean\Annotation\Mapping\Bean;
use Swoft\Bean\Annotation\Mapping\Inject;

/**
 *
 * @Bean()
 */
class AppLogic
{
    /**
     *
     * @Inject()
     * @var AppData
     */
    private $appData;

    /**
     * 获取APP最新版本号
     * @return array
     */
    public function getVersion()
    {
        $result = $this->appData->getVersion();
        return ['data' => $result, 'code' => '0'];
    }

    /**
     * 获取关于我们
     * @return array
     */
    public function getAbout()
    {
        $result = $this->appData->getAbout();
        return ['data' => $result, 'code' => '0'];
    }

}
