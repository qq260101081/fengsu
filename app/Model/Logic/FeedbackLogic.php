<?php
namespace App\Model\Logic;

use App\Model\Data\FeedbackData;
use Swoft\Bean\Annotation\Mapping\Bean;
use Swoft\Bean\Annotation\Mapping\Inject;

/**
 *
 * @Bean()
 */
class FeedbackLogic
{
    /**
     *
     * @Inject()
     * @var FeedbackData
     */
    private $feedbackData;

    /**
     * 创建
     * @param $userId
     * @param $data
     * @return array
     */
    public function create($userId, $data)
    {
        $data['user_id'] = $userId;
        $result = $this->feedbackData->create($data);
        if ($result)
        {
            return ['data' => [], 'code' => '0'];
        }
        return ['data' => [], 'code' => '1'];
    }

}
