<?php
namespace App\Http\Controller\Api;

use App\Model\Logic\AppLogic;
use Swoft\Bean\Annotation\Mapping\Inject;
use Swoft\Http\Server\Annotation\Mapping\Middleware;
use Swoft\Http\Server\Annotation\Mapping\Controller;
use Swoft\Http\Server\Annotation\Mapping\RequestMapping;
use Swoft\Http\Server\Annotation\Mapping\RequestMethod;
use App\Http\Middleware\LoginAuthMiddleware;


/**
 * @Controller(prefix="/api/app")
 */
class AppController{

    /**
     * 注入逻辑层
     * @Inject()
     * @var AppLogic
     */
    private $logic;

    /**
     * 获取版本号
     * @Middleware(LoginAuthMiddleware::class)
     * @RequestMapping(route="version", method=RequestMethod::GET)
     * @return \Swoft\Http\Message\Response
     * @throws \ReflectionException
     * @throws \Swoft\Bean\Exception\ContainerException
     */
    public function version()
    {
        $data = $this->logic->getVersion();

        return successResponse($data['data'], $data['code']);
    }

    /**
     * * 获取关于我们
     * @RequestMapping(route="about", method=RequestMethod::GET)
     * @return \Swoft\Http\Message\Response
     * @throws \ReflectionException
     * @throws \Swoft\Bean\Exception\ContainerException
     */
    public function about()
    {
        $data = $this->logic->getAbout();
        return successResponse($data['data'], $data['code']);
    }

}
