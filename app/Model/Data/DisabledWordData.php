<?php

namespace App\Model\Data;

use App\Model\Dao\DisabledWordDao;
use Swoft\Bean\Annotation\Mapping\Bean;
use Swoft\Bean\Annotation\Mapping\Inject;

/**
 *
 * @Bean()
 */
class DisabledWordData
{
    /**
     *
     * @Inject()
     * @var DisabledWordDao
     */
    private $disabledWordDao;

    public function getDisabledWord()
    {
        return $this->disabledWordDao->getDisabledWord();
    }

}
