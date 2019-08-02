<?php


namespace App\Model\Dao;

use App\Model\Entity\ArtContent;
use App\Model\Entity\Article;
use App\Model\Entity\ArtImg;
use App\Model\Entity\Collection;
use App\Model\Entity\DisabledWord;
use App\Model\Entity\Star;
use Swoft\Bean\Annotation\Mapping\Bean;
use Swoft\Db\DB;
use Swoft\Db\Query;
use Swoft\Redis\Redis;

/**
 *
 * @Bean()
 */
class DisabledWordDao
{
    public function getDisabledWord(){
        //敏感词库是否已存入缓存
        $disabledWord = Redis::get('disabledWord');
        if (!$disabledWord){
            //未存入，先读取到缓存
            $disabledWord = Query::table(DisabledWord::class)->get(['content'])->getResult();
            $disabledWord = array_column($disabledWord, 'content');
            //编码成json格式，存储到缓存
            $disabledWordJson = json_encode($disabledWord);
            $res = Redis::set('disabledWord', $disabledWordJson);
            if (!$res){
                return false;
            }
        }else{ //敏感词库已在缓存中
            //解码成数组
            $disabledWord = json_decode($disabledWord, true);
        }

        return $disabledWord;
    }
}