<?php
namespace App\Model\Logic;

use App\Model\Data\DisabledWordData;
use Swoft\Bean\Annotation\Mapping\Bean;
use Swoft\Bean\Annotation\Mapping\Inject;

/**
 *
 * @Bean()
 */
class DisabledWordLogic
{
    /**
     * @Inject()
     * @var DisabledWordData
     */
    private $disabledWordData;


    public function getDisabledWord()
    {
        return $this->disabledWordData->getDisabledWord();
    }


}
