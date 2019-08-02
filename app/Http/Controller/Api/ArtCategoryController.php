<?php
namespace App\Http\Controller\Api;

use App\Model\Logic\ArtCategoryLogic;
use Swoft\Bean\Annotation\Mapping\Inject;
use Swoft\Http\Server\Annotation\Mapping\Middleware;
use Swoft\Http\Server\Annotation\Mapping\Controller;
use Swoft\Http\Server\Annotation\Mapping\RequestMapping;
use Swoft\Http\Server\Annotation\Mapping\RequestMethod;
use App\Http\Middleware\LoginAuthMiddleware;


/**
 * Class ArtCategoryController
 * @package App\Controllers\Api
 * @Controller(prefix="/api")
 */
class ArtCategoryController{

    /**
     * 注入逻辑层
     * @Inject()
     * @var ArtCategoryLogic
     */
    private $logic;

    /**
     * 获取所有文章分类
     * @Middleware(LoginAuthMiddleware::class)
     * @RequestMapping(route="artCategory", method=RequestMethod::GET)
     * @return array
     */
    public function getAll()
    {
        $data = $this->logic->getAll();

        return successResponse($data['data'], $data['code']);
    }

}
