<?php
namespace App\Model\Logic;

use App\Model\Data\ArticleData;
use App\Model\Data\ArtCategoryData;
use App\Model\Data\CollectionData;
use App\Model\Data\StarData;
use DfaFilter\SensitiveHelper;
use Swoft\Bean\Annotation\Mapping\Bean;
use Swoft\Bean\Annotation\Mapping\Inject;

/**
 *
 * @Bean()
 */
class ArticleLogic
{
    /**
     * @Inject()
     * @var ArticleData
     */
    private $articleData;

    /**
     * @Inject()
     * @var ArtCategoryData
     */
    private $artCategoryData;

    /**
     * @Inject()
     * @var CollectionData
     */
    private $collectionData;

    /**
     * @Inject()
     * @var StarData
     */
    private $starData;

    /**
     * @Inject()
     * @var DisabledWordLogic
     */
    private $disabledWordLogic;

    /**
     * 文章-关注列表
     * @param $page
     * @return mixed
     */
    public function getSubscribeList($userId, $page)
    {
        $result = $this->articleData->getSubscribeList($userId, $page);
        return ['data' => $result, 'code' => '0'];
    }

    /**
     * 文章-推荐列表
     * @param $page
     * @return mixed
     */
    public function getRecommendList($page)
    {
        $result = $this->articleData->getRecommendList($page);
        return ['data' => $result, 'code' => '0'];
    }

    /**
     * 获取文章最新发布列表
     *
     * @param $page
     * @return array
     * @throws \ReflectionException
     * @throws \Swoft\Bean\Exception\ContainerException
     * @throws \Swoft\Db\Exception\DbException
     */
    public function getNewList($page)
    {
        $result = $this->articleData->getNewList($page);
        return ['data' => $result, 'code' => '0'];
    }

    /**
     * 文章-分类列表
     * @param $categoryId
     * @param $page
     * @return mixed
     */
    public function getCategoryList($categoryId, $page)
    {
        $result = $this->articleData->getCategoryList($categoryId, $page);
        return ['data' => $result, 'code' => '0'];
    }

    /**
     * 文章详情
     * @param $randomId
     * @return mixed
     */
    public function getDetail($randomId)
    {
        $result = $this->articleData->getDetail($randomId);
        return ['data' => $result, 'code' => '0'];
    }

    /**
     * 文章收藏
     *
     * @param $userId
     * @param $randomId
     * @return array
     * @throws \ReflectionException
     * @throws \Swoft\Bean\Exception\ContainerException
     * @throws \Swoft\Db\Exception\DbException
     */
    public function collection($userId, $randomId)
    {
        $artExist = $this->articleData->artExistByRandomId($randomId);
        // 文章不存在
        if(!$artExist)
        {
            return ['data' => [], 'code' => '50000'];
        }

        // 已经收藏过直接返回
        $existCollection = $this->collectionData->existCollection($userId, $artExist['art_id']);

        if($existCollection)
        {
            if ($existCollection['status'] == 1)
            {
                $result = $this->collectionData->updateStatus($userId, $artExist['art_id'], 0);
                if ($result)
                {
                    return ['data' => [], 'code' => '0'];
                }
            }
            else
            {
                return ['data' => [], 'code' => '0'];
            }

        }
        else
        {
            // 插入收藏表及更新文章收藏数
            $collectionId = $this->articleData->collection($userId, $artExist['user_id'], $artExist['art_id']);

            if ($collectionId)
            {
                return ['data' => [], 'code' => '0'];
            }
        }

        return ['data' => [], 'code' => '1'];
    }

    /**
     * 文章点赞
     *
     * @param $userId
     * @param $randomId
     * @return array
     * @throws \ReflectionException
     * @throws \Swoft\Bean\Exception\ContainerException
     * @throws \Swoft\Db\Exception\DbException
     */
    public function star($userId, $randomId)
    {
        $artExist = $this->articleData->artExistByRandomId($randomId);
        // 文章不存在
        if(!$artExist)
        {
            return ['data' => [], 'code' => '50000'];
        }

        // 已经点赞过直接返回
        $existStar = $this->starData->existStar($userId, $artExist['art_id']);

        if($existStar)
        {
            if ($existStar['status'] == 1)
            {
                $result = $this->starData->updateStatus($userId, $artExist['art_id'], 0);
                if ($result)
                {
                    return ['data' => [], 'code' => '0'];
                }
            }
            else
            {
                return ['data' => [], 'code' => '0'];
            }
        }
        else
        {
            // 插入点赞表及更新文章点赞数
            $result = $this->articleData->star($userId, $artExist['user_id'], $artExist['art_id']);
            if ($result)
            {
                return ['data' => ['star_id' => $result], 'code' => '0'];
            }
        }
        return ['data' => [], 'code' => '1'];
    }


    /**
     * 文章创建
     *
     * @param int $userId
     * @param string $title
     * @param string $content
     * @param int $type
     * @param string $imgList
     * @return array
     * @throws \DfaFilter\Exceptions\PdsBusinessException
     * @throws \DfaFilter\Exceptions\PdsSystemException
     * @throws \Swoft\Db\Exception\DbException
     */
    public function create(int $userId, string $title, string $content, int $type, string $imgList)
    {
        $resData = ['data' => [], 'code' => '0'];

        $imgList = json_decode($imgList, true);
        $imgNum = count($imgList);
        $titleLen = mb_strlen($title, 'utf8');
        $contentLen = mb_strlen($content, 'utf8');


        // 判断发布类型
        if ($type == 0) //纯文字类型
        {
            // 1.内容不能少于5个字
            if ($contentLen < 5)
            {
                return ['data' => [], 'code' => '50004'];
            }
            // 2.图片最多为9张
            if ($imgNum > 9)
            {
                return ['data' => [], 'code' => '50005'];
            }
        }
        else // 图片类型
        {
            // 1.标题或内容必须填写一项
            if (empty($title) && empty($content))
            {

            }
        }

        // 标题字数最多为40个字
        if ($title)
        {
            if ($titleLen > 40)
            {
                return ['data' => [], 'code' => '50006'];
            }
        }

        // 内容字数限制
        if ($contentLen > 2000)
        {
            return ['data' => [], 'code' => '50007'];
        }

        // 初始热度分计算
        $hotScore = 0; // 热度分
        $contentQuality = 0; // 内容质量
        $status = 1; // 状态默认已审
        $pubTime = time(); // 发布时间
        // 1. 内容分类得分
        $category = $this->artCategoryData->getScore($cid);
        if(!$category)
        {
            return ['data' => [], 'code' => '50001'];
        }
        $hotScore += $category['score'];
        // 2. 标题为空 -0.2分
        if (!$title)
        {
            $hotScore -= 0.2;
        }
        // 3. 内容字数小于10且 全为中文 0.2分 并不出现在推荐页面
        if(mb_strlen($content, 'UTF8') < 10 && preg_match('/^[\x{4e00}-\x{9fa5}]+$/u', $content) > 0)
        {
            $hotScore = 0.2;
            $contentQuality = 1;
        }

        // 检查敏感词
        $disabledWord = $this->disabledWordLogic->getDisabledWord();
        $handle = SensitiveHelper::init()->setTree($disabledWord);
        // 仅且获取一个敏感词
        $titleSensitive = $handle->getBadWord($title, 1);
        $contentSensitive = $handle->getBadWord($content, 1);
        if ($titleSensitive)
        {
            $status = 2;
            $pubTime = 0;
            $resData['data']['sensitive_word'] = $titleSensitive;
            $resData['code'] = '50002';
        }
        if ($contentSensitive)
        {
            $status = 2;
            $pubTime = 0;
            $resData['code'] = '50003';
            $resData['sensitive_word'] = $contentSensitive;
        }



        $randomId = $this->articleData->create(
            $userId, $cid, $title, $contentQuality, $content, $hotScore, $imgList, $status, $pubTime
        );

        $resData['data']['random_id'] = $randomId;
        return $resData;
    }
}
