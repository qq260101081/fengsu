<?php

namespace App\Http\Controller\Api;

use App\Model\Entity\User;
use Swoft\Http\Server\Annotation\Mapping\Middleware;
use Swoft\Http\Message\Request;
use Swoft\Http\Message\Response;

use Swoft\Http\Server\Annotation\Mapping\Controller;
use Swoft\Http\Server\Annotation\Mapping\RequestMapping;
use Swoft\Http\Server\Annotation\Mapping\RequestMethod;
use App\Http\Middleware\LoginAuthMiddleware;
use App\Http\Middleware\ControllerApiMiddleware;
use Swoft\Redis\Redis;

/**
 * RESTful和参数验证测试demo.
 * @Middleware(ControllerApiMiddleware::class)
 * @Controller(prefix="/api")
 */
class LoginController
{

    /**
     * 发送短信验证码
     * @param Request $request
     * @return Response
     * @throws \Psr\SimpleCache\InvalidArgumentException
     * @RequestMapping(route="sendsms")
     */
    public function sendsms(Request $request){

        $phone = $request->json('phone');
//        return \response()->apiResponse([$request->getBodyParams()], 1);

//        print_r($request->getBodyParams());die;
        if (!is_phone($phone)){
            return errorResponse('','手机号格式不正确');
        }

        //获取极光配置信息
        $jiguangConfig = config('jiguang');
//        return \response()->apiResponse($jiguangConfig, 1);

        $jsms = new \JiGuang\JSMS($jiguangConfig['app_key'], $jiguangConfig['master_secret'], [ 'disable_ssl' => true]);

        //发送验证码
        $response = $jsms->sendCode($phone, $jiguangConfig['sms_tempid'], 9569);
        $statusCode = $response['body']['error']['code'];
        $message = $response['body']['error']['message'];
        //发送失败
        if ($statusCode != 0){
            return errorResponse($message, 1, $response['body']['error']);
        }

        //成功 验证码存入缓存
        Redis::set($phone, $response['code']);
        return successResponse($response['body']['error']['code']);
    }


    /**
     * 登录接口
     * 地址:/user//.
     * @RequestMapping(route="login", method={RequestMethod::POST})
     */
    public function login(Request $request)
    {
        $params = $request->json();
//        return response()->apiResponse($this->params, 1, '缺少参数phone');

        $phone = $params['phone'];
        $clientCode = $params['code'];
        if (!$phone){
            return errorResponse('缺少参数phone');
        }
        if (!$clientCode){
            return errorResponse('缺少参数code');
        }
        //验证短信验证码
        $serverCode = Redis::get($phone);
        if ($clientCode != $serverCode){
            //调试，暂时注释
//            return response()->apiResponse($postData,30001);
        }

        //清除短信验证码
        Redis::del($phone);

        $user = new User();
        $userData = $user->findOne(['phone' => $phone])->getResult();
        $userId = $userData['userId'];

        //用户未注册，写入用户信息
        if (!$userId){
            $userId = $user->fill($params)->save()->getResult();
            if (!$userId){
                return errorResponse('', 30003, $params);
            }
        }

        //生成用户token
        $accessToken = create_token($userId, 1);
        $refreshToken = create_token($userId, 2);

        //设置token
       $resultAccess = Redis::set($accessToken, $userId, config('access_token_expires_in'));
        $resultRefresh = Redis::set($refreshToken, $userId, config('refresh_token_expires_in'));
        if (!$resultAccess || !$resultRefresh){
           return errorResponse('', 30002, $params);
       }

        //登陆成功
        return successResponse(['access_token' => $accessToken, 'refresh_token' => $refreshToken, 'expires_in' => config('access_token_expires_in')]);
    }

    /**
     * 退出登录接口
     * 地址:/user//.
     * @Middleware(class=LoginAuthMiddleware::class)
     * @RequestMapping(route="login/logout", method={RequestMethod::DELETE})
     */
    public function logout(Request $request)
    {
        $accessToken = request()->getHeaderLine('access-token');
        $refreshToken = $request->json('refresh_token');
        $result = Redis::del([$accessToken, $refreshToken]);
        //退出登陆成功
        return successResponse();
    }


    /**
     * @RequestMapping(route="login/refresh_token", method={RequestMethod::PUT})
     * @param Request $request
     */
    public function refresh_token(Request $request){
        $accessToken = request()->getHeaderLine('access-token');
        $refresh_token = $request->json('refresh_token');
        if (!$accessToken){
            return errorResponse( '缺少access_token参数');
        }
        if (!$refresh_token){
            return errorResponse('缺少refreshToken参数');
        }

        //查询refresh_token
        $userId = Redis::get($refresh_token);
        if (!$userId){
            return errorResponse('', 30006);
        }

        //删除旧的access_token
        Redis::del($accessToken);

        //设置新的access_token
        $newaccess_token = create_token($userId);
        Redis::set($newaccess_token, $userId, config('access_token_expires_in'));

        // 成功 返回
        return successResponse(['access_token' => $newaccess_token, 'expires_in' => config('access_token_expires_in')]);
    }

}
