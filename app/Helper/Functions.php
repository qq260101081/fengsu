<?php
/**
 * This file is part of Swoft.
 *
 * @link https://swoft.org
 * @document https://doc.swoft.org
 * @contact group@swoft.org
 * @license https://github.com/swoft-cloud/swoft/blob/master/LICENSE
 */

// you can add some custom functions.
use Swoft\Http\Message\Response;
use Swoft\Http\Message\ContentType;
use Swoft\Context\Context;

/**
 * 对象转数组
 * @param $obj
 * @return mixed
 */
function obj_to_array($obj){
    return json_decode(json_encode($obj), true);
}


/**
 * 数据验签
 * @param $params
 * @param string $sign
 * @param int $timestamp
 * @param string $device_type
 * @param string $access_token
 * @return bool
 */
function check_sign($params = [], string $sign, int $timestamp, string $device_type, $access_token = ''){
    if ($device_type == 'android'){
        $config = config('android');
    }else if($device_type == 'ios'){
        $config = config('ios');
    }else{
        return false;
    }
    if (!empty($params)){
        ksort($params);
        $params = http_build_query($params);
        $params = $params . '&';
    }
    $string = $params . "device_type=" . $device_type . "&timestamp=" . $timestamp . "&appsecret=" . $config['appsecret'];
    if ($access_token){
        $string .=  "&access_token=" . $access_token;
    }
//    return $string;

    $serverSign = strtoupper(md5($string));
    return $serverSign == $sign;
}

/**
 * @param int $userId
 * @param int $type 生成token类型 1: access_token  2:refresh_token
 * @return string
 */
function create_token(int $userId, int $type = 1){
    $prefix = $type == 1 ? 'a':'r';
    $token = strtr(uniqid($prefix . $userId,true), array('.' => ''));
    return $token;
}

/**
 * @param $phone
 * @return bool
 */
function is_phone($phone)
{
    if (!preg_match("/^1[3456789]{1}\d{9}$/", $phone)) {
        return false;
    }
    return true;
}

/**
 * 生成指定长度随机字符串
 * @param int $length
 * @param string $char
 * @return string
 */
function strRand($length = 22, $char = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ_')
{
    $string = '';
    for($i = $length; $i > 0; $i--)
    {
        $string .= $char[mt_rand(0, strlen($char) - 1)];
    }
    return $string;
}

/**
 * 公共错误信息返回
 * @param string $msg
 * @param int $code
 * @param array $data
 * @param int $status
 * @return Response
 * @throws ReflectionException
 * @throws \Swoft\Bean\Exception\ContainerException
 */
function errorResponse(string $msg = '', int $code = 1, array $data = [], int $status = 200): Response
{

    Context::mustGet()->getResponse()->withStatus($status);
    Context::mustGet()->getResponse()->withContentType(ContentType::JSON, 'utf-8');

    $responseData = [
        'code' => $code,
        'msg' => $msg?:Swoft::t("apiMsg.{$code}", [], 'zh')
    ];
    if ($data)
    {
        $responseData['data'] = $data;
    }

    return Context::mustGet()->getResponse()->withData($responseData);
}

/**
 * 公共成功信息返回
 * @param array $data
 * @param int $code
 * @param string $msg
 * @param int $status
 * @return Response
 * @throws ReflectionException
 * @throws \Swoft\Bean\Exception\ContainerException
 */
function successResponse($data = [], int $code = 0, string $msg = '', int $status = 200): Response
{
    if (is_object($data)){
        $data = obj_to_array($data);
    }
    Context::mustGet()->getResponse()->withStatus($status);
    Context::mustGet()->getResponse()->withContentType(ContentType::JSON, 'utf-8');

    $responseData = ['code' => $code, 'msg' => $msg?:Swoft::t("apiMsg.{$code}", [], 'zh'), 'data' => $data];

    return Context::mustGet()->getResponse()->withData($responseData);
}