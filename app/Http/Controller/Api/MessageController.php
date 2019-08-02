<?php


namespace App\Http\Controller\Api;

use App\Model\Entity\ArtComment;
use App\Model\Entity\ArtCommentStar;
use App\Model\Entity\Collection;
use App\Model\Entity\Notice;
use App\Model\Entity\NoticeMsg;
use App\Model\Entity\Star;
use App\Model\Entity\TopicComment;
use Swoft\Db\DB;
use Swoft\Http\Server\Annotation\Mapping\Middleware;
use Swoft\Http\Server\Annotation\Mapping\Controller;
use Swoft\Http\Server\Annotation\Mapping\RequestMapping;
use Swoft\Http\Server\Annotation\Mapping\RequestMethod;
use App\Http\Middleware\LoginAuthMiddleware;
use App\Http\Middleware\ControllerApiMiddleware;
use Swoft\Redis\Redis;
use Swoft\Validator\Annotation\Mapping\Validate;

/**
 * 消息管理控制器
 * Class MessageController
 * @package App\Controllers\Api
 * @Middleware(class=ControllerApiMiddleware::class)
 * @Controller(prefix="/api/message/")
 */
class MessageController
{


    /**
     * 我收到的评论接口
     * @Middleware(class=LoginAuthMiddleware::class)
     * @RequestMapping(route="comment", RequestMethod={RequestMethod::POST})
     */
    public function comment(){

        $userId = Redis::get('userId');
        $offset = request()->json('offset');
        $limit = request()->json('limit');

        $messageData = Db::query("SELECT
                                            c.*, `user`.avatar, `user`.nickname
                                        FROM
                                            (
                                            SELECT
                                                1 AS message_type,
                                                art_comment_id,
                                                art_id,
                                                comment_user_id,
                                                parent_comment_id,
                                                parent_comment_user_id,
                                                content,
                                                is_read,
                                                create_time 
                                            FROM
                                                fs_art_comment 
                                            WHERE
                                                parent_comment_user_id = {$userId} UNION
                                            SELECT
                                                2 AS message_type,
                                                topic_comment_id,
                                                topic_id,
                                                comment_user_id,
                                                parent_comment_id,
                                                parent_comment_user_id,
                                                content,
                                                is_read,
                                                create_time 
                                            FROM
                                                fs_topic_comment 
                                            WHERE
                                            parent_comment_user_id = {$userId}) AS c 
                                            
                                            LEFT JOIN
                                            fs_user as `user`
                                            on
                                            `user`.user_id = c.comment_user_id
                                            
                                        ORDER BY
                                            is_read ASC,
                                            create_time DESC 
                                            LIMIT {$offset},{$limit}")->getResult();

        //根据消息类型查询不同的表获取回复内容
        foreach ($messageData as $k => $val){
            $messageData[$k]['create_time'] = date('Y/m/d H:i', strtotime($val['create_time']));

            if ($val['message_type'] == 1){ //文章
                //被回复的内容
                $messageData[$k]['masterContent'] = Query::table(ArtComment::class)
                    ->where('art_comment_id', $val['parent_comment_id'])
                    ->one(['content'])->getResult()['content'];

            }else if($val['message_type'] == 2){ //话题
                //被回复的内容
                $messageData[$k]['masterContent'] = Query::table(TopicComment::class)
                    ->where('topic_comment_id', $val['parent_comment_id'])
                    ->one(['content'])->getResult()['content'];
            }
        }

        return successResponse($messageData);
    }

    /**
     * 我收到的点赞收藏 接口
     * @Middleware(class=LoginAuthMiddleware::class)
     * @RequestMapping(route="starCollect", RequestMethod={RequestMethod::POST})
     */
    public function starCollect()
    {
        $userId = Redis::get('userId');
        $offset = request()->json('offset');
        $limit = request()->json('limit');

        $messageData = Db::query("SELECT
                                            c.*, art.title, `user`.avatar, `user`.nickname
                                        FROM
                                            (
                                            SELECT
                                                 1 as message_type,user_id,art_id,is_read, create_time
                                            FROM
                                                fs_star 
                                            WHERE
                                                `art_user_id` = {$userId} UNION
                                            SELECT
                                                2 as message_type, art_comment_user_id as user_id,art_id,is_read, create_time
                                            FROM
                                                fs_art_comment_star 
                                            WHERE
                                                art_comment_user_id = {$userId} UNION
                                            SELECT
                                                3 as message_type, user_id as user_id,art_id,is_read, create_time
                                            FROM
                                                fs_collection 
                                            WHERE
                                                art_user_id = {$userId} 
                                            ) AS c 
                                            LEFT JOIN 
                                                fs_article as art
                                                on
                                                art.art_id=c.art_id
                                                
                                                LEFT JOIN
                                                fs_user as `user`
                                                on
                                                `user`.user_id = c.user_id
                                        ORDER BY
                                            is_read ASC,
                                            create_time DESC 
                                            LIMIT {$offset},
                                            {$limit}")->getResult();



         //时间戳转换
        $messageData = array_map(function ($v){
            $v['create_time'] = date('Y/m/d H:i', $v['create_time']);
            return $v;
        }, $messageData);
        return successResponse($messageData);
    }


    /**
     * 通知列表接口
     * @Middleware(class=LoginAuthMiddleware::class)
     * @RequestMapping(route="notice", RequestMethod={RequestMethod::POST})
     */
    public function notice()
    {
        $userId = Redis::get('userId');
        $offset = request()->json('offset');
        $limit = request()->json('limit');

        $noticeMsg = Query::table(NoticeMsg::class, 'msg')
            ->leftJoin(Notice::class, 'msg.notice_id = notice.notice_id', 'notice')
            ->where('msg.user_id', $userId)
            ->limit($limit, $offset)
            ->get(['notice.title', 'notice.content', 'msg.create_time'])->getResult();

        //时间戳转换
        $noticeMsg = array_map(function ($v){
            $v['create_time'] = date('m-d', $v['create_time']);
            return $v;
        }, $noticeMsg);

        return successResponse($noticeMsg);
    }

    /**
     *@Middleware(class=LoginAuthMiddleware::class)
     *@Validate(validator="ApiValidator", fields={"type"})
     *@RequestMapping(route="read", RequestMethod={RequestMethod::POST})
     * @return \Swoft\Http\Message\Server\Response
     */
    public function read(){
        $userId = Redis::get('userId');
        //类型 1 评论  2点赞和收藏  3通知
        $type = request()->json('type');

        switch ($type){
            case 1: //评论
                //文章评论设为已读
                Query::table(ArtComment::class)
                    ->where('parent_comment_user_id', $userId)
                    ->where('is_read', 0)
                    ->update(['is_read' => 1])->getResult();

                //话题评论设为已读
                Query::table(TopicComment::class)
                    ->where('parent_comment_user_id', $userId)
                    ->where('is_read', 0)
                    ->update(['is_read' => 1])->getResult();

                break;
            case 2: //点赞和收藏
                //文章的点赞设为已读
                Query::table(Star::class)
                    ->where('art_user_id', $userId)
                    ->where('is_read', 0)
                    ->update(['is_read' => 1])->getResult();
                //文章评论的点赞设为已读
                Query::table(Collection::class)
                    ->where('art_comment_user_id', $userId)
                    ->where('is_read', 0)
                    ->update(['is_read' => 1])->getResult();
                //文章收藏设为已读
                Query::table(Collection::class)
                    ->where('art_user_id', $userId)
                    ->where('is_read', 0)
                    ->update(['is_read' => 1])->getResult();
                break;
            case 3: //通知
                //通知设为已读
                Query::table(NoticeMsg::class)
                    ->where('user_id', $userId)
                    ->where('is_read', 0)
                    ->update(['is_read' => 1])->getResult();
                break;
        }

        return successResponse();

    }

    /**
     * 评论未读消息数量接口
     *@Middleware(class=LoginAuthMiddleware::class)
     *@RequestMapping(route="commentCount", RequestMethod={RequestMethod::POST})
     * @return \Swoft\Http\Message\Server\Response
     */
    public function commentCount(){
        $userId = Redis::get('userId');
        $topicCommentCount = TopicComment::count('*', ['parent_comment_id' => $userId, 'is_read' => 0])->getResult();
        $artCommentCount = ArtComment::count('*', ['parent_comment_id' => $userId, 'is_read' => 0])->getResult();
        $commentCount = $topicCommentCount + $artCommentCount;
        return successResponse(['commentCount' => $commentCount]);
    }

    /**
     * 点赞收藏未读消息数量接口
     *@Middleware(class=LoginAuthMiddleware::class)
     *@RequestMapping(route="starCollectCount", RequestMethod={RequestMethod::POST})
     * @return \Swoft\Http\Message\Server\Response
     */
    public function starCollectCount(){
        $userId = Redis::get('userId');

        //文章的点赞未读数量
       $starCount = Query::table(Star::class)
            ->where('art_user_id', $userId)
            ->where('is_read', 0)
            ->count('*')->getResult();
        //文章评论的点赞未读数量
        $artCommentStarCount = Query::table(ArtCommentStar::class)
            ->where('art_comment_user_id', $userId)
            ->where('is_read', 0)
            ->count('*')->getResult();
        //文章收藏未读数量
        $artCollectCount = Query::table(Collection::class)
            ->where('art_user_id', $userId)
            ->where('is_read', 0)
            ->count('*')->getResult();

        $commentCount = $starCount + $artCommentStarCount + $artCollectCount;
        return successResponse(['starCollectCount' => $commentCount]);
    }

    /**
     * 通知未读消息数量接口
     *@Middleware(class=LoginAuthMiddleware::class)
     *@RequestMapping(route="noticeCount", RequestMethod={RequestMethod::POST})
     * @return \Swoft\Http\Message\Server\Response
     */
    public function noticeCount(){
        $userId = Redis::get('userId');
        $noticeCount = NoticeMsg::count('*', ['user_id' => $userId, 'is_read' => 0])->getResult();
        return successResponse(['noticeCount' => $noticeCount]);
    }

}