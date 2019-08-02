<?php
namespace App\Http\Controller\Api;

use App\Model\Entity\User;
use Swoft\Http\Server\Annotation\Mapping\Middleware;
use Swoft\Http\Message\Request;
use Swoft\Http\Server\Annotation\Mapping\Controller;
use Swoft\Http\Server\Annotation\Mapping\RequestMapping;
use Swoft\Http\Server\Annotation\Mapping\RequestMethod;
use App\Model\Logic\UserLogic;
use App\Http\Middleware\LoginAuthMiddleware;
use App\Http\Middleware\ControllerApiMiddleware;
use Swoft\Bean\Annotation\Mapping\Inject;
use Swoft\Redis\Redis;
use Swoft\Context\Context;

/**
 *
 * @Controller(prefix="/api/user")
 */
class UserController
{
    /**
     * @Inject()
     * @var ControllerApiMiddleware
     */
    private $apiMiddleware;

    /**
     * @Inject()
     * @var UserLogic
     */
    private $logic;

    /**
     * 登录接口
     * 地址:/user//.
     * @RequestMapping(route="login", method={RequestMethod::POST})
     */
    public function login(Request $request)
    {
        $params = $request->json('params');
//        return response()->apiResponse($this->params, 1, '缺少参数phone');

        $phone = $params['phone'];
        $clientCode = $params['code'];
        if (!$phone){
            return errorResponse('缺少参数phone');
        }
        if (!$clientCode){
            return errorResponse( '缺少参数code');
        }
        //验证短信验证码
        $serverCode = Redis::get($phone);
        if ($clientCode != $serverCode){
            //调试，暂时注释
//            return response()->apiResponse($postData,1002);
        }

        //清除短信验证码
        Redis::del($phone);

        $user = new User();

        $userData = $user->findOne(['phone' => $phone])->getResult();
        $userId = $userData['userId'];
//        return response()->apiResponse([$userId], 1);
//        return response()->apiResponse(json_decode(json_encode($userData), true), 1);

        //用户未注册，写入用户信息
        if (!$userId){
            $userId = $user->fill($params)->save()->getResult();
            if (!$userId){
                return successResponse($params);
            }
        }
//        return response()->apiResponse([$userId], 1);

        //生成用户token
        $accessToken = create_token($userId);
        $refreshToken = create_token($userId, 2);

        //设置token
       Redis::set($accessToken, $userId, config('access_token_expires_in'));
       $result =  Redis::set($refreshToken, $userId, config('refresh_token_expires_in'));
        if (!$result){
           return errorResponse('',1003, $params);
       }

        //登陆成功
        return successResponse(['access_token' => $accessToken, 'refresh_token' => $refreshToken, 'expires_in' => config('access_token_expires_in')]);
    }

    /**
     * 退出登录接口
     * 地址:/user//.
     * @RequestMapping(route="logout", method={RequestMethod::DELETE})
     */
    public function logout(Request $request)
    {
        $accessToken = $request->json('access_token');
        $refreshToken = $request->json('params.refreshToken');

        $result = Redis::del([$accessToken, $refreshToken]);
        //退出登陆成功
        return successResponse();
    }


    /**
     * @RequestMapping(route="refresh_token", method={RequestMethod::PUT})
     * @param Request $request
     */
    public function refresh_token(Request $request){
        $accessToken = $request->json('access_token');
        $refresh_token = $request->json('params.refreshToken');
        if (!$accessToken){
            return errorResponse('缺少access_token参数');
        }
        if (!$refresh_token){
            return errorResponse('缺少refreshToken参数');
        }

        //查询refresh_token
        $userId = Redis::get($refresh_token);
//        return response()->apiResponse([$userId], 1007);

        if (!$userId){
            return errorResponse('', 1007);
        }

        //删除旧的access_token
        Redis::del($accessToken);

        //设置新的access_token
        $newaccess_token = create_token($userId);
        Redis::set($newaccess_token, $userId, config('access_token_expires_in'));

        // 成功 返回
        return successResponse(['access_token' => $newaccess_token, 'expires_in' => config('access_token_expires_in')]);
    }


    /**
     * 查询一个用户信息
     * 地址:/api/user/6.
     * @Middleware(LoginAuthMiddleware::class)
     * @RequestMapping(route="info", method={RequestMethod::GET})
     *
     * @param int $uid
     *
     * @return array
     */
    public function getUser()
    {
        $userId = Redis::get('userId');
        $user = new User();
        $userData = $user->findOne(['user_id' => $userId])->getResult();
        if (empty($userData)){
            return errorResponse('用户信息不存在');
        }

        return successResponse(obj_to_array($userData));
    }

    /**
     * 关注用户
     *
     * @Middleware(LoginAuthMiddleware::class)
     * @RequestMapping(method=RequestMethod::POST)
     * @return \Swoft\Http\Message\Response
     * @throws \ReflectionException
     * @throws \Swoft\Bean\Exception\ContainerException
     */
    public function subscribe()
    {
        $userId = Redis::get('userId');
        $subUserId = Context::mustGet()->getRequest()->post('sub_user_id', 0);

        $data = $this->logic->subscribe($userId, $subUserId);

        return successResponse($data['data'], $data['code']);
    }

    /**
     * 取消关注
     *
     * @Middleware(LoginAuthMiddleware::class)
     * @RequestMapping(method=RequestMethod::POST)
     * @return \Swoft\Http\Message\Response
     * @throws \ReflectionException
     * @throws \Swoft\Bean\Exception\ContainerException
     */
    public function unSubscribe()
    {
        $userId = Redis::get('userId');
        $subUserId = Context::mustGet()->getRequest()->post('sub_user_id', 0); // 被关注的用户ID

        $data = $this->logic->unSubscribe($userId, $subUserId);

        return successResponse($data['data'], $data['code']);
    }

    /**
     * * 更新用户资料
     * @Middleware(LoginAuthMiddleware::class)
     * @RequestMapping(method=RequestMethod::POST)
     * @return \Swoft\Http\Message\Response
     * @throws \ReflectionException
     * @throws \Swoft\Bean\Exception\ContainerException
     */
    public function updateInfo()
    {
        $userId = Redis::get('userId');

        $params = Context::mustGet()->getRequest()->post();

        $data = $this->logic->updateInfo($params, $userId);

        return successResponse($data['data'], $data['code']);
    }

    /**
     * 删除收藏
     * @Middleware(LoginAuthMiddleware::class)
     * @RequestMapping(method=RequestMethod::POST)
     * @return \Swoft\Http\Message\Response
     * @throws \ReflectionException
     * @throws \Swoft\Bean\Exception\ContainerException
     */
    public function delCollection()
    {
        $userId = Redis::get('userId');
        $collectionId = Context::mustGet()->getRequest()->post('collection_id',0);

        $data = $this->logic->delCollection($userId, $collectionId);
        return successResponse($data['data'], $data['code']);
    }

    /**
     * 删除浏览记录
     * @Middleware(LoginAuthMiddleware::class)
     * @RequestMapping(method=RequestMethod::POST)
     * @return \Swoft\Http\Message\Response
     * @throws \ReflectionException
     * @throws \Swoft\Bean\Exception\ContainerException
     */
    public function delRecord()
    {
        $userId = Redis::get('userId');
        $recordId = Context::mustGet()->getRequest()->post('record_id',0);

        $data = $this->logic->delRecord($userId, $recordId);
        return successResponse($data['data'], $data['code']);
    }
}
