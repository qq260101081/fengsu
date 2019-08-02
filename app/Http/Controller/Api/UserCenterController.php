<?php
namespace App\Http\Controller\Api;

use Swoft\Http\Server\Annotation\Mapping\Middleware;
use Swoft\Http\Message\Request;
use Swoft\Http\Server\Annotation\Mapping\Controller;
use Swoft\Http\Server\Annotation\Mapping\RequestMapping;
use Swoft\Http\Server\Annotation\Mapping\RequestMethod;
use App\Model\Logic\UserCenterLogic;
use App\Http\Middleware\LoginAuthMiddleware;
use App\Http\Middleware\ControllerApiMiddleware;
use Swoft\Context\Context;
use Swoft\Bean\Annotation\Mapping\Inject;
use Swoft\Redis\Redis;

/**
 * Class UserCenterController
 * @Controller(prefix="/api/userCenter")
 * @Middleware(LoginAuthMiddleware::class)
 */
class UserCenterController
{
    /**
     * @Inject()
     * @var UserCenterLogic
     */
    private $logic;

    /**
     * 我的主页
     * @RequestMapping(route="index", method=RequestMethod::GET)
     * @return \Swoft\Http\Message\Server\Response
     */
    public function index()
    {
        $userId = Redis::get('userId');
        $data = $this->logic->index($userId);
        return successResponse($data['data'], $data['code']);
    }

    /**
     * 用户文章列表
     * @RequestMapping(route="articleList", method={RequestMethod::GET})
     * @param Request $request
     * @return \Swoft\Http\Message\Server\Response
     * @throws \Swoft\Db\Exception\DbException
     */
    public function articleList(Request $request)
    {
        $userId = $request->input('user_id', 0);
        $page = $request->input('page', 1);

        $data = $this->logic->articleList($userId, $page);
        return successResponse($data['data'], $data['code']);
    }

    /**
     * 用户关注列表
     *
     * @RequestMapping(method=RequestMethod::GET)
     * @return \Swoft\Http\Message\Response
     * @throws \ReflectionException
     * @throws \Swoft\Bean\Exception\ContainerException
     * @throws \Swoft\Db\Exception\DbException
     */
    public function subscribeList()
    {
        $userId = Context::mustGet()->getRequest()->query('user_id', 0);
        $page = Context::mustGet()->getRequest()->query('page', 1);

        $data = $this->logic->subscribeList($userId, $page);
        return successResponse($data['data'], $data['code']);
    }

    /**
     * 用户粉丝列表
     * @RequestMapping(method=RequestMethod::GET)
     * @return \Swoft\Http\Message\Response
     * @throws \ReflectionException
     * @throws \Swoft\Bean\Exception\ContainerException
     * @throws \Swoft\Db\Exception\DbException
     */
    public function fansList()
    {
        $userId = Context::mustGet()->getRequest()->query('user_id', 0);
        $page   = Context::mustGet()->getRequest()->query('page', 1);

        $data   = $this->logic->fansList($userId, $page);
        return successResponse($data['data'], $data['code']);
    }

    /**
     * 获取用户编辑资料
     * @RequestMapping(method=RequestMethod::GET)
     * @return \Swoft\Http\Message\Response
     * @throws \ReflectionException
     * @throws \Swoft\Bean\Exception\ContainerException
     * @throws \Swoft\Db\Exception\DbException
     */
    public function userInfo()
    {
        $userId = Redis::get('userId');
        $data = $this->logic->userEditInfo($userId);

        return successResponse($data['data'], $data['code']);
    }

    /**
     * 用户收藏列表
     * @RequestMapping(method=RequestMethod::GET)
     * @return \Swoft\Http\Message\Response
     * @throws \ReflectionException
     * @throws \Swoft\Bean\Exception\ContainerException
     * @throws \Swoft\Db\Exception\DbException
     */
    public function collectionList()
    {
        $userId = Redis::get('userId');
        $page = Context::mustGet()->getRequest()->query('page', 1);

        $data = $this->logic->collectionList($userId, $page);

        return successResponse($data['data'], $data['code']);
    }

    /**
     * 用户浏览记录列表
     * @RequestMapping(method=RequestMethod::GET)
     * @return \Swoft\Http\Message\Response
     * @throws \ReflectionException
     * @throws \Swoft\Bean\Exception\ContainerException
     * @throws \Swoft\Db\Exception\DbException
     */
    public function recordList()
    {
        $userId = Redis::get('userId');
        $page = Context::mustGet()->getRequest()->query('page', 1);
        $data = $this->logic->recordList($userId, $page);

        return successResponse($data['data'], $data['code']);
    }

}
