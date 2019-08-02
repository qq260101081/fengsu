<?php
namespace App\Model\Logic;

use App\Model\Data\ArtCategoryData;
use Swoft\Bean\Annotation\Mapping\Bean;
use Swoft\Bean\Annotation\Mapping\Inject;

/**
 *
 * @Bean()
 */
class ArtCategoryLogic
{
    /**
     *
     * @Inject()
     * @var ArtCategoryData
     */
    private $artCategoryData;

    /**
     * 获取所有
     * @return array
     */
    public function getAll()
    {
        $result = $this->artCategoryData->getAll();
        return ['data' => $result, 'code' => '0'];
    }

}
