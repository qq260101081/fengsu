<?php

namespace App\Http\Middleware;

use Psr\Http\Server\RequestHandlerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Swoft\Bean\Annotation\Mapping\Bean;
use Swoft\Http\Server\Contract\MiddlewareInterface;
use Swoft\Redis\Redis;


/**
 * 登录验证中间件，统一处理权限认证，需要验证登录的控制器或方法 必须引入此中间件
 * @Bean()
 * @uses      LoginAuthMiddleware
 * @version   2019年07月08日
 * @author    Berg
 */
class LoginAuthMiddleware implements MiddlewareInterface
{
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
//        $accessToken = request()->getHeaderLine('access-token');
//        $userId = cache()->get($accessToken);
//        if (!$accessToken || !$userId){
//            return response()->apiResponse([], 30004);
//        }
//
//        //用户有操作则延长access_token有效期
//        cache()->set($accessToken, $userId, config('access_token_expires_in'));
//
////        设置session
//        session()->put('userId', $userId);

        Redis::set('userId', 1);
        //session()->put('userId', 1);

        // 委托给下一个中间件处理
        $response = $handler->handle($request);
        return $response->withAddedHeader('Middleware-Action-Test', 'success');
    }

}