<?php


namespace App\Http\Controller\Api;

use App\Model\Entity\CommentMsg;
use App\Model\Entity\DisabledWord;
use App\Model\Entity\Topic;
use App\Model\Entity\TopicComment;
use App\Model\Entity\TopicCommentStar;
use App\Model\Entity\TopicVote;
use App\Model\Entity\User;
use App\Model\Logic\DisabledWordLogic;
use http\Env\Response;
use Swoft\Db\DB;
use Swoft\Db\Query;
use Swoft\Http\Server\Annotation\Mapping\Middleware;
use Swoft\Http\Message\Request;
use Swoft\Http\Server\Annotation\Mapping\Controller;
use Swoft\Http\Server\Annotation\Mapping\RequestMapping;
use Swoft\Http\Server\Annotation\Mapping\RequestMethod;
use App\Http\Middleware\LoginAuthMiddleware;
use App\Http\Middleware\ControllerApiMiddleware;
use Swoft\Bean\Annotation\Mapping\Inject;
use DfaFilter\SensitiveHelper;
use Swoft\Redis\Redis;

/**
 * 话题控制器
 * Class TopicController
 * @package App\Controllers\Api
 * @Middleware(class=ControllerApiMiddleware::class)
 * @Controller(prefix="/api/topic")
 */
class TopicController
{

    //评论对象 - 话题
    const COMMENT_OBJ_TOPIC = 1;
    //评论对象 - 话题下的评论
    const COMMENT_OBJ_COMMENT = 2;

    //点赞状态 0 点赞
    const STAR_STATUS_YES= 0;
    //点赞状态 1 取消点赞
    const STAR_STATUS_NO = 1;

    /**
     * 注入逻辑层
     * @Inject()
     * @var DisabledWordLogic
     */
    private $disabledWordLogic;

    /**
     * 获取发现列表
     * @RequestMapping(route="/api/topic/list", RequestMethod={RequestMethod::GET})
     */
    public function list(){
        $offset = request()->json('offset');
        $limit = request()->json('limit');
//        response()->apiResponse(request()->json());
        $data = Query::table(Topic::class)->where('status',0)->limit($limit, $offset)->get()->getResult();
        return successResponse($data);
    }

    /**
     * 话题详情接口
     * @RequestMapping(route="info", RequestMethod={RequestMethod::POST})
     * @return \Swoft\Http\Message\Server\Response
     */
    public function info(){
        $topicId = request()->json('topic_id');
        $dataInfo = Query::table(Topic::class)->where('status',0)->where('topic_id', $topicId)->get()->getResult();
        $dataInfo['create_time'] = date('Y/m/d H:i', strtotime($dataInfo['create_time']));

        if (!$dataInfo){
            return errorResponse('', 10002);
        }
        return successResponse($dataInfo);
    }

    /**
     * 话题投票接口
     * $voteType 投票类型 1正方  2反方
     * @Middleware(class=LoginAuthMiddleware::class)
     * @RequestMapping(route="vote")
     * @return \Swoft\Http\Message\Server\Response
     */
    public function vote(){
        $topicId = request()->json('topic_id');
        $voteType = request()->json('vote_type');
        $userId = Redis::get('userId');

        Db::beginTransaction();
        $topicInfo = Query::table(Topic::class)->where('status',0)->where('topic_id', $topicId)->one()->getResult();
//        return response()->apiResponse($topicInfo, 0);

        if (!$topicId){
            return errorResponse('', 10002);
        }

        //是否已投票
        $isVote = Query::table(TopicVote::class)->condition([
            'user_id' => $userId,
            'topic_id' => $topicId,
        ])->one(['topic_vote_id'])->getResult();
        if ($isVote){
            return errorResponse("不能重复投票");
        }

        switch ($voteType){
            //正方
            case 1:
                $saveData = ['good' => $topicInfo['good'] + 1];
                break;
            //反方
            case 2:
                $saveData = ['bad' => $topicInfo['bad'] + 1];
                break;
        }

        //写入话题记录表
        $resultVote = Query::table(TopicVote::class)->insert([
            'user_id' => $userId,
            'topic_id' => $topicId,
            'vote_type' => $voteType,
        ])->getResult();

        //增加话题点赞数
        $resultTopic = Query::table(Topic::class)->where('topic_id', $topicId)->update($saveData);
        if (!$resultTopic || !$resultVote){
            Db::rollback();
            return errorResponse();
        }

        Db::commit();
        return successResponse();
    }

    /**
     * 话题评论接口
     * @param string  $name
     * @param Request $request
     * @Middleware(class=LoginAuthMiddleware::class)
     * @RequestMapping(route="comment")
     * @return array
     */
    public function comment(){
        $topicId = request()->json('topic_id');
        $content = request()->json('content');
        //发表评论用户的id
        $commentUserId = session()->get('userId');
        if (!$content){
            return errorResponse('评论内容不能为空');
        }

        //获取敏感词库
        $disabledWord = $this->disabledWordLogic->getDisabledWord();
        //将敏感词构建成树结构
        $handle = SensitiveHelper::init()->setTree($disabledWord);
        //敏感词替换为**
        $filterContent = $handle->replace($content, '*', true);

        //写入话题评论表
        $commentId = Query::table(TopicComment::class)->insert([
            'topic_id' => $topicId,
            'comment_user_id' => $commentUserId,
            'parent_comment_id' => 0,
            'belong_comment_id' => 0,
            'content' => $filterContent,
            'type' => 1,
        ])->getResult();

        if (!$commentId){
            return errorResponse();
        }

        return successResponse();
    }

    /**
     * 回复评论接口
     * @param Request $request
     * @Middleware(class=LoginAuthMiddleware::class)
     * @RequestMapping(route="replyComment")
     * @return array
     */
    public function replyComment(){
        //话题id
        $topicId = request()->json('topic_id');
        //被回复的评论的id
        $parentCommentId= request()->json('parent_comment_id');

        //查询回复从属的评论的id
        $parentCommentInfo = TopicComment::findOne(['topic_comment_id' => $parentCommentId])->getResult();
//        return response()->apiResponse($parentCommentInfo, 1);

        $belongCommentId = $parentCommentInfo['belongCommentId']?:$parentCommentInfo['topicCommentId'];

        //回复内容
        $content = request()->json('content');
        //发表评论用户的id
        $commentUserId = session()->get('userId');
        $commentUserId = 2;

        if (!$content){
            return errorResponse('评论内容不能为空');
        }

        //获取敏感词库
        $disabledWord = $this->disabledWordLogic->getDisabledWord();
        //将敏感词构建成树结构
        $handle = SensitiveHelper::init()->setTree($disabledWord);
        //敏感词替换为**
        $filterContent = $handle->replace($content, '*', true);
//
//        if ($parentCommentInfo['type'] == 1){ //回复评论
//            $parent_comment_id = 0;
//            $parent_comment_user_id = 0;
//        }else if ($parentCommentInfo['type'] == 2){ //回复评论的评论
//            $parent_comment_id = $parentCommentInfo['topicCommentId'];
//            $parent_comment_user_id = $parentCommentInfo['commentUserId'];
//        }

        //写入话题评论表
        $commentId = Query::table(TopicComment::class)->insert([
            'topic_id' => $topicId,
            'comment_user_id' => $commentUserId,
            'parent_comment_id' => $parentCommentId,
            'parent_comment_user_id' => $parentCommentInfo['commentUserId'],
            'belong_comment_id' => $belongCommentId,
            'content' => $filterContent,
            'type' => 2,
        ])->getResult();

        if (!$commentId){
            return errorResponse();
        }
        return successResponse();
    }

    /**
     * 话题评论列表接口
     * @RequestMapping(route="/api/topic/commentList", RequestMethod={RequestMethod::POST})
     */
    public function commentList(){
        $topicId = request()->json('topic_id');
        $offset = request()->json('offset');
        $limit = request()->json('limit');

        //话题是否存在
        $topicInfo = Query::table(Topic::class)->where('status',0)->where('topic_id', $topicId)->one()->getResult();
        if (!$topicInfo){
            return errorResponse('', 10002);
        }
        //查询话题下的所有一级评论
        $topicCommentList = Query::table(TopicComment::class, 'comment')
            ->leftJoin(User::class, 'comment.comment_user_id=user.user_id', 'user')
            ->where('comment.topic_id', $topicId)
            ->where('comment.type', 1)
            ->orderBy('comment.create_time', 'desc')
            ->limit($limit, $offset)->get()->getResult();
        if (!$topicCommentList){
            return successResponse();
        }

        //循环查询评论下的回复
        foreach ($topicCommentList as $key => $value){
            //评论下的回复列表
            $replayCommentList = Query::table(TopicComment::class, 'reply')
                ->where('reply.belong_comment_id', $value['topic_comment_id'])
                ->limit(5, 0)->get()->getResult();

            //回复为空，直接跳过
            if (!$replayCommentList){
                $topicCommentList[$key]['son'] = [];
                continue;
            }
            //取出回复列表所有用户的ID
            $userIdArr = [];
            foreach ($replayCommentList as $k => $val){
                array_push($userIdArr, $val['comment_user_id']);
                if ($val['parent_comment_user_id']){
                    array_push($userIdArr, $val['parent_comment_user_id']);
                }
            }

            //查询出回复列表所有用户的昵称
            $replayUserList = Query::table(User::class)
                ->whereIn('user_id', $userIdArr)->get(['user_id', 'nickname'])->getResult();
            $userKeyValue = [];
            //组装成[user_id => nickname]的格式，方便取用
            foreach ($replayUserList as $k => $val){
                $userKeyValue[$val['user_id']]  = $val['nickname'];
            }

            //通过user_id获取到昵称
            foreach ($replayCommentList as $k => $val){
                $replayCommentList[$k]['user_nickname'] = $userKeyValue[$val['comment_user_id']];

                //如果上级是一级评论，设parent_user_nickname为空
                $parent = TopicComment::findOne(['topic_comment_id' => $val['parent_comment_user_id']])->getResult();

                if ($parent['type'] == 1){
                    $replayCommentList[$k]['parent_user_nickname'] = '';
                }else{
                    if ($val['parent_comment_user_id']){
                        $replayCommentList[$k]['parent_user_nickname'] = $userKeyValue[$val['parent_comment_user_id']];
                    }else{
                        $replayCommentList[$k]['parent_user_nickname'] = '';
                    }
                }
            }
            $topicCommentList[$key]['son'] = $replayCommentList;

            //时间戳格式转换
            $topicCommentList[$key]['create_time'] = date('Y/m/d H:i', strtotime($value['create_time']));
        }

        //返回数据
        return successResponse($topicCommentList);
    }

    /**
     * 获取评论的回复列表接口
     * @RequestMapping(route="/api/topic/replyCommentList", RequestMethod={RequestMethod::POST})
     */
    public function replyCommentList(){
        $topicCommentId = request()->json('topic_comment_id');
        $offset = request()->json('offset');
        $limit = request()->json('limit');

        //查看评论是否存在
        $topicCommentInfo = Query::table(TopicComment::class)
            ->where('status',1)
            ->where('topic_comment_id', $topicCommentId)->one()->getResult();
        if (!$topicCommentInfo){
            return errorResponse('', 10002);
        }

        //评论下的回复列表
        $replayCommentList = Query::table(TopicComment::class)
            ->where('belong_comment_id', $topicCommentId)
            ->limit($limit, $offset)
            ->orderBy('create_time', 'desc')
            ->get()->getResult();

        //取出回复列表所有用户的ID
        $userIdArr = [];
        foreach ($replayCommentList as $k => $val){
            array_push($userIdArr, $val['comment_user_id'],$val['parent_comment_user_id']);
        }

        //查询出回复列表所有用户的昵称
        $replayUserList = Query::table(User::class)
            ->whereIn('user_id', $userIdArr)->get(['user_id', 'nickname'])->getResult();
        $userKeyValue = [];
        foreach ($replayUserList as $k => $val){
            $userKeyValue[$val['user_id']]  = $val['nickname'];
        }

        //通过user_id获取到昵称
        foreach ($replayCommentList as $k => $val){
            $replayCommentList[$k]['user_nickname'] = $userKeyValue[$val['comment_user_id']];
            //如果上级是一级评论，设parent_user_nickname为空
            $parent = TopicComment::findOne(['topic_comment_id' => $val['parent_comment_user_id']])->getResult();

            if ($parent['type'] == 1){
                $replayCommentList[$k]['parent_user_nickname'] = '';
            }else{
                if ($val['parent_comment_user_id']){
                    $replayCommentList[$k]['parent_user_nickname'] = $userKeyValue[$val['parent_comment_user_id']];
                }else{
                    $replayCommentList[$k]['parent_user_nickname'] = '';
                }
            }
        }

        return successResponse($replayCommentList);
    }

    /**
     * 给评论点赞接口
     * @Middleware(class=LoginAuthMiddleware::class)
     * @RequestMapping(route="startComment", RequestMethod={RequestMethod::POST})
     */
    public function startComment(){
        $star_user_id = session()->get('userId');
        $topicId = request()->json('topic_id');
        $topicCommentId = request()->json('topic_comment_id');
        $topicCommentUserId = request()->json('topic_comment_user_id');

        //查看评论是否存在
        $topicCommentInfo = Query::table(TopicComment::class)
            ->where('status',1)
            ->where('topic_comment_id', $topicCommentId)->one()->getResult();
        if (!$topicCommentInfo){
            return errorResponse('', 10002);
        }

        //是否已点赞
        $isStar = Query::table(TopicCommentStar::class)->condition([
            'topic_comment_id' => $topicCommentId,
            'star_user_id' => $star_user_id,
            'status' => self::STAR_STATUS_YES,
        ])->one()->getResult();
        if ($isStar){
            return errorResponse('您已点过赞了');
        }

        Db::beginTransaction();
        //写入话题点赞记录表
        $resultVote = Query::table(TopicCommentStar::class)->insert([
            'topic_id' => $topicId,
            'topic_comment_id' => $topicCommentId,
            'star_user_id' => $star_user_id,
            'topic_comment_user_id' => $topicCommentUserId,
        ])->getResult();

        //评论的点赞数+1
        $star = $topicCommentInfo['star'] + 1;
        $updateStar = Query::table(TopicComment::class)
            ->where('topic_comment_id', $topicCommentId)->update(['star' => $star])->getResult();

        if (!$resultVote || !$updateStar){
            Db::rollback();
            return errorResponse();
        }

        Db::commit();
        return successResponse();
    }

    /**
     * 取消评论的点赞接口
     * @Middleware(class=LoginAuthMiddleware::class)
     * @RequestMapping(route="cancelStartComment", RequestMethod={RequestMethod::POST})
     */
    public function cancelStartComment(){
        $star_user_id = session()->get('userId');
        $topicCommentStartId = request()->json('topic_comment_star_id');

        //点赞状态设为取消
        $result = Query::table(TopicCommentStar::class)
            ->where('status', self::STAR_STATUS_NO)
            ->where('star_user_id', $star_user_id)
            ->where('topic_comment_star_id', $topicCommentStartId)
            ->delete()->getResult();

        if (!$result){
            return errorResponse();
        }
        return successResponse();
    }

}