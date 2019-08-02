<?php
namespace App\Http\Controller\Api;

use App\Model\Logic\FeedbackLogic;
use Swoft\Bean\Annotation\Mapping\Inject;
use Swoft\Http\Server\Annotation\Mapping\Middleware;
use Swoft\Http\Server\Annotation\Mapping\Controller;
use Swoft\Http\Server\Annotation\Mapping\RequestMapping;
use Swoft\Http\Server\Annotation\Mapping\RequestMethod;
use Swoft\Validator\Annotation\Mapping\Validate;
use Swoft\Context\Context;
use App\Http\Middleware\LoginAuthMiddleware;
use Swoft\Redis\Redis;


/**
 * Class FeedbackController
 * @package App\Controllers\Api
 * @Controller(prefix="/api/feedback")
 */
class FeedbackController{

    /**
     * 注入逻辑层
     * @Inject()
     * @var FeedbackLogic
     */
    private $logic;

    /**
     * 反馈
     * @Middleware(LoginAuthMiddleware::class)
     * @RequestMapping(route="create", method=RequestMethod::POST)
     * @Validate(validator="CommonValidator", fields={"content"})
     * @return \Swoft\Http\Message\Response
     * @throws \ReflectionException
     * @throws \Swoft\Bean\Exception\ContainerException
     */
    public function create()
    {
        $userId = Redis::get('userId');
        $request = Context::mustGet()->getRequest();

        $data = $this->logic->create($userId, $request->post());

        return successResponse($data['data'], $data['code']);
    }

}
