<?php

namespace App\Http\Controller\Api;

use App\Model\Entity\ArtComment;
use App\Model\Entity\Article;
use App\Model\Entity\User;
use App\Model\Logic\ArticleLogic;
use DfaFilter\SensitiveHelper;
use Swoft\Bean\Annotation\Mapping\Inject;
use Swoft\Http\Server\Annotation\Mapping\Middleware;
use Swoft\Http\Server\Annotation\Mapping\Controller;
use Swoft\Http\Server\Annotation\Mapping\RequestMapping;
use Swoft\Http\Server\Annotation\Mapping\RequestMethod;
use Swoft\Http\Message\Request;
use Swoft\Redis\Redis;

use App\Http\Middleware\LoginAuthMiddleware;
use App\Http\Middleware\ControllerApiMiddleware;
use App\Model\Logic\DisabledWordLogic;
use Swoft\Context\Context;

/**
 * @Controller(prefix="/api/article")
 */
class ArticleController{

    /**
     * 注入逻辑层
     * @Inject()
     * @var ArticleLogic
     */
    private $logic;

    /**
     * 注入逻辑层
     * @Inject()
     * @var DisabledWordLogic
     */
    private $disabledWordLogic;

    /**
     * 文章-关注列表
     *
     * @Middleware(LoginAuthMiddleware::class)
     * @RequestMapping(route="subscribeList", method=RequestMethod::GET)
     * @return \Swoft\Http\Message\Response
     * @throws \ReflectionException
     * @throws \Swoft\Bean\Exception\ContainerException
     */
    public function subscribeList()
    {
        $userId = Redis::get('userId');

        $page = Context::mustGet()->getRequest()->query('page', 1);

        $data = $this->logic->getSubscribeList($userId, $page);

        return successResponse($data['data'], $data['code']);
    }

    /**
     * 文章-推荐列表
     * RequestMapping(route="recommendList", method=RequestMethod::GET)
     * @param Request $request
     * @return \Swoft\Http\Message\Response
     * @throws \ReflectionException
     * @throws \Swoft\Bean\Exception\ContainerException
     */
    public function recommendList(Request $request)
    {
        $page = $request->input('page', 1);

        $data = $this->logic->getRecommendList($page);
        return successResponse($data['data'], $data['code']);
    }

    /**
     * 文章最新列表
     * @RequestMapping(route="newList", method=RequestMethod::GET)
     * @return \Swoft\Http\Message\Response
     * @throws \ReflectionException
     * @throws \Swoft\Bean\Exception\ContainerException
     * @throws \Swoft\Db\Exception\DbException
     */
    public function newList()
    {
        $page = Context::mustGet()->getRequest()->query('page', 1);
        $data = $this->logic->getNewList($page);
        return successResponse($data['data'], $data['code']);
    }

    /**
     * 文章-分类列表（美食、景点、节日、活动等）
     * @param Request $request
     * @RequestMapping(route="categoryList", method=RequestMethod::GET)
     * @return array

    public function categoryList(Request $request)
    {
        $page = $request->input('page', 1);
        $categoryId = $request->input('atr_category_id', 1);

        $data = $this->logic->getCategoryList($categoryId, $page);
        return successResponse($data['data']);
    }*/

    /**
     * 获取文章详情
     * @param Request $request
     * @RequestMapping(route="detail", method=RequestMethod::GET)
     * @return \Swoft\Http\Message\Server\Response
     */
    public function detail(Request $request)
    {
        $randomId = $request->input('random_id', '');

        $data = $this->logic->getDetail($randomId);

        return successResponse($data);
    }

    /**
     * 文章收藏
     * @Middleware(LoginAuthMiddleware::class)
     * @RequestMapping(method=RequestMethod::POST)
     */
    public function collection()
    {
        $userId = Redis::get('userId');
        $randomId = Context::mustGet()->getRequest()->post('random_id', '');

        $data = $this->logic->collection($userId, $randomId);
        return successResponse($data['data'], $data['code']);
    }

    /**
     * 文章点赞
     * @param Request $request
     * @Middleware(LoginAuthMiddleware::class)
     * @RequestMapping(route="star", method=RequestMethod::POST)
     * @return mixed|\Swoft\Http\Message\Server\Response
     */
    public function star(Request $request)
    {
        $userId = Redis::get('userId');
        $randomId = $request->input('random_id', '');

        $data = $this->logic->star($userId, $randomId);
        return successResponse($data['data'], $data['code']);
    }

    /**
     * 文章创建
     * @Middleware(LoginAuthMiddleware::class)
     * @RequestMapping(route="create", method=RequestMethod::POST)
     * @return \Swoft\Http\Message\Server\Response
     * @throws \Swoft\Db\Exception\DbException
     */
    public function create()
    {
        $userId  = Redis::get('userId');
        $title   = Context::mustGet()->getRequest()->post('title', '');
        $type   = Context::mustGet()->getRequest()->post('type', 0);
        $content = Context::mustGet()->getRequest()->post('content', '');
        $imgList = Context::mustGet()->getRequest()->post('img_list', '');

        $data    = $this->logic->create($userId, $title, $content, $type, $imgList);

        return successResponse($data['data'], $data['code']);
    }


    /**
     * 评论文章接口
     * @param string  $name
     * @param Request $request
     * @Middleware(class=LoginAuthMiddleware::class)
     * @RequestMapping(route="comment")
     * @return array
     */
    public function comment(){
        $artId = request()->json('art_id');
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

        //写入评论表
        $commentId = Query::table(ArtComment::class)->insert([
            'art_id' => $artId,
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
        //文章id
        $artId = request()->json('art_id');

        //被回复的评论的id
        $parentCommentId= request()->json('art_comment_id');

        //查询回复从属的评论的id
        $parentCommentInfo = ArtComment::findOne(['art_comment_id' => $parentCommentId])->getResult();

        //评论所属的一级评论的id
        $belongCommentId = $parentCommentInfo['belongCommentId']?:$parentCommentInfo['artCommentId'];

        //回复内容
        $content = request()->json('content');

        //发表评论用户的id
        $commentUserId = session()->get('userId');

        if (!$content){
            return errorResponse('','评论内容不能为空');
        }

        //获取敏感词库
        $disabledWord = $this->disabledWordLogic->getDisabledWord();
        //将敏感词构建成树结构
        $handle = SensitiveHelper::init()->setTree($disabledWord);
        //敏感词替换为**
        $filterContent = $handle->replace($content, '*', true);

        //写入文章评论表
        $commentId = Query::table(ArtComment::class)->insert([
            'art_id' => $artId,
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
     * 文章评论列表接口
     * @RequestMapping(route="commentList", RequestMethod={RequestMethod::POST})
     */
    public function commentList(){
        $artId = request()->json('art_id');
        $offset = request()->json('offset');
        $limit = request()->json('limit');

        //文章是否存在
        $artInfo = Query::table(Article::class)->where('status',0)->where('art_id', $artId)->one()->getResult();
        if (!$artInfo){
            return errorResponse('', 10002);
        }
        //查询文章下的所有一级评论
        $artCommentList = Query::table(ArtComment::class, 'comment')
            ->leftJoin(User::class, 'comment.comment_user_id=user.user_id', 'user')
            ->where('comment.art_id', $artId)
            ->where('comment.type', 1)
            ->orderBy('comment.create_time', 'desc')
            ->limit($limit, $offset)->get()->getResult();
        if (!$artCommentList){
            return successResponse();
        }

        //循环查询评论下的回复
        foreach ($artCommentList as $key => $value){
            //评论下的回复列表
            $replayCommentList = Query::table(ArtComment::class, 'reply')
                ->where('reply.belong_comment_id', $value['art_comment_id'])
                ->limit(5, 0)->get()->getResult();

            //回复为空，直接跳过
            if (!$replayCommentList){
                $artCommentList[$key]['son'] = [];
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
                $parent = ArtComment::findOne(['art_comment_id' => $val['parent_comment_user_id']])->getResult();

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
            $artCommentList[$key]['son'] = $replayCommentList;

            //时间戳格式转换
            $artCommentList[$key]['create_time'] = date('Y/m/d H:i', strtotime($value['create_time']));
        }

        //返回数据
        return successResponse($artCommentList);
    }


    /**
     * 获取评论的回复列表接口
     * @RequestMapping(route="replyCommentList", RequestMethod={RequestMethod::POST})
     */
    public function replyCommentList(){
        $artCommentId = request()->json('art_comment_id');
        $offset = request()->json('offset');
        $limit = request()->json('limit');

        //查看评论是否存在
        $artCommentInfo = Query::table(ArtComment::class)
            ->where('status',1)
            ->where('art_comment_id', $artCommentId)->one()->getResult();
        if (!$artCommentInfo){
            return errorResponse('', 10002);
        }

        //评论下的回复列表
        $replayCommentList = Query::table(ArtComment::class)
            ->where('belong_comment_id', $artCommentId)
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
            $parent = ArtComment::findOne(['art_comment_id' => $val['parent_comment_user_id']])->getResult();

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
    
}
