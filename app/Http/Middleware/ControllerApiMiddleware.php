<?php

namespace App\Http\Middleware;

use Psr\Http\Server\RequestHandlerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Swoft\Bean\Annotation\Mapping\Bean;
use Swoft\Http\Server\Contract\MiddlewareInterface;
use Swoft\Redis\Redis;


/**
 * APP接口数据验证中间件，所有接口控制器都需要引入
 * @Bean()
 * @uses      ControllerApiMiddleware
 * @version   2019年07月08日
 * @author    Berg
 */
class ControllerApiMiddleware implements MiddlewareInterface
{
    protected $params;

    /**
     * Process an incoming server request and return a response, optionally delegating
     * response creation to a handler.
     * @param \Psr\Http\Message\ServerRequestInterface $request
     * @param \Psr\Http\Server\RequestHandlerInterface $handler
     * @return \Psr\Http\Message\ResponseInterface
     * @throws \InvalidArgumentException
     */
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        //用户登录凭证
        $access_token = request()->getHeaderLine('access-token');
        //客户端类型
        $device_type = request()->getHeaderLine('device-type');
        //api版本号
        $version = request()->getHeaderLine('version');
        //客户端请求的时间戳
        $timestamp = request()->getHeaderLine('timestamp');
        //客户端签名
        $sign = request()->getHeaderLine('sign');
//        return response()->apiResponse([$device_type],10001);

        if (!in_array($device_type, ['android', 'ios'])){
            return errorResponse('device-type参数错误，必须为android或ios');
        }
        if (!$timestamp){
            return errorResponse('缺少timestamp参数');
        }
        if (!$sign){
            return errorResponse('缺少sign参数');
        }

        $parsedBody = request()->json();
        $checkSign = check_sign($parsedBody, $sign, $timestamp, $device_type, $access_token);
//        return response()->apiResponse([$checkSign],10001);

        // 如果验证不通过
        if (!$checkSign) {
//            return response()->apiResponse([],10001);
        }

        //请求已过期
        if (($timestamp + config('request_expires_in')) < time()){
            return errorResponse('',30005);
        }

        //如果已登录，设置userId到session，兼容某些不需要强制验证登录的地方
        $accessToken = request()->getHeaderLine('access-token');
        $userId = Redis::get($accessToken);
        Redis::set($accessToken, $userId);
        //session()->put('userId', $userId);

        // 委托给下一个中间件处理
        $response = $handler->handle($request);
        return $response->withAddedHeader('Middleware-Action-Test', 'success');
    }


}