<?php

namespace App\Model\Data;

use App\Model\Dao\FeedbackDao;
use Swoft\Bean\Annotation\Mapping\Bean;
use Swoft\Bean\Annotation\Mapping\Inject;

/**
 *
 * @Bean()
 */
class FeedbackData
{
    /**
     *
     * @Inject()
     * @var FeedbackDao
     */
    private $feedbackDao;

    /**
     * 创建
     * @param $data
     * @return mixed
     */
    public function create($data)
    {
        $data['create_time'] = time();
        return $this->feedbackDao->create($data);
    }
}
