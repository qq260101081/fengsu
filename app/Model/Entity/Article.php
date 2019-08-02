<?php declare(strict_types=1);


namespace App\Model\Entity;

use Swoft\Db\Annotation\Mapping\Column;
use Swoft\Db\Annotation\Mapping\Entity;
use Swoft\Db\Annotation\Mapping\Id;
use Swoft\Db\Eloquent\Model;


/**
 * 文章表
 * Class Article
 *
 * @since 2.0
 *
 * @Entity(table="article")
 */
class Article extends Model
{
    /**
     * 主键ID
     * @Id()
     * @Column(name="art_id", prop="artId")
     *
     * @var int
     */
    private $artId;

    /**
     * 随机ID
     *
     * @Column(name="random_id", prop="randomId")
     *
     * @var string
     */
    private $randomId;

    /**
     * 用户ID
     *
     * @Column(name="user_id", prop="userId")
     *
     * @var int
     */
    private $userId;

    /**
     * 分类ID
     *
     * @Column(name="art_category_id", prop="artCategoryId")
     *
     * @var int
     */
    private $artCategoryId;

    /**
     * 标题
     *
     * @Column()
     *
     * @var string
     */
    private $title;

    /**
     * 热度分
     *
     * @Column(name="hot_score", prop="hotScore")
     *
     * @var float
     */
    private $hotScore;

    /**
     * 浏览数
     *
     * @Column()
     *
     * @var int
     */
    private $pv;

    /**
     * 评论数
     *
     * @Column()
     *
     * @var int
     */
    private $rv;

    /**
     * 收藏数
     *
     * @Column()
     *
     * @var int
     */
    private $collection;

    /**
     * 点赞数
     *
     * @Column()
     *
     * @var int
     */
    private $star;

    /**
     * 1已审2敏感词3举报10下架
     *
     * @Column()
     *
     * @var int
     */
    private $status;

    /**
     * 省编码
     *
     * @Column()
     *
     * @var int
     */
    private $province;

    /**
     * 市编码
     *
     * @Column()
     *
     * @var int|null
     */
    private $city;

    /**
     * 区编码
     *
     * @Column()
     *
     * @var int|null
     */
    private $area;

    /**
     * 内容质量0正常，1为全中文且小于10个字
     *
     * @Column(name="content_quality", prop="contentQuality")
     *
     * @var int
     */
    private $contentQuality;

    /**
     * 创建时间
     *
     * @Column(name="create_time", prop="createTime")
     *
     * @var int
     */
    private $createTime;

    /**
     * 更新时间
     *
     * @Column(name="update_time", prop="updateTime")
     *
     * @var int
     */
    private $updateTime;

    /**
     * 置顶结束时间
     *
     * @Column(name="top_end_time", prop="topEndTime")
     *
     * @var int
     */
    private $topEndTime;

    /**
     * 发布时间
     *
     * @Column(name="publish_time", prop="publishTime")
     *
     * @var int
     */
    private $publishTime;


    /**
     * @param int $artId
     *
     * @return void
     */
    public function setArtId(int $artId): void
    {
        $this->artId = $artId;
    }

    /**
     * @param string $randomId
     *
     * @return void
     */
    public function setRandomId(string $randomId): void
    {
        $this->randomId = $randomId;
    }

    /**
     * @param int $userId
     *
     * @return void
     */
    public function setUserId(int $userId): void
    {
        $this->userId = $userId;
    }

    /**
     * @param int $artCategoryId
     *
     * @return void
     */
    public function setArtCategoryId(int $artCategoryId): void
    {
        $this->artCategoryId = $artCategoryId;
    }

    /**
     * @param string $title
     *
     * @return void
     */
    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    /**
     * @param float $hotScore
     *
     * @return void
     */
    public function setHotScore(float $hotScore): void
    {
        $this->hotScore = $hotScore;
    }

    /**
     * @param int $pv
     *
     * @return void
     */
    public function setPv(int $pv): void
    {
        $this->pv = $pv;
    }

    /**
     * @param int $rv
     *
     * @return void
     */
    public function setRv(int $rv): void
    {
        $this->rv = $rv;
    }

    /**
     * @param int $collection
     *
     * @return void
     */
    public function setCollection(int $collection): void
    {
        $this->collection = $collection;
    }

    /**
     * @param int $star
     *
     * @return void
     */
    public function setStar(int $star): void
    {
        $this->star = $star;
    }

    /**
     * @param int $status
     *
     * @return void
     */
    public function setStatus(int $status): void
    {
        $this->status = $status;
    }

    /**
     * @param int $province
     *
     * @return void
     */
    public function setProvince(int $province): void
    {
        $this->province = $province;
    }

    /**
     * @param int|null $city
     *
     * @return void
     */
    public function setCity(?int $city): void
    {
        $this->city = $city;
    }

    /**
     * @param int|null $area
     *
     * @return void
     */
    public function setArea(?int $area): void
    {
        $this->area = $area;
    }

    /**
     * @param int $contentQuality
     *
     * @return void
     */
    public function setContentQuality(int $contentQuality): void
    {
        $this->contentQuality = $contentQuality;
    }

    /**
     * @param int $createTime
     *
     * @return void
     */
    public function setCreateTime(int $createTime): void
    {
        $this->createTime = $createTime;
    }

    /**
     * @param int $updateTime
     *
     * @return void
     */
    public function setUpdateTime(int $updateTime): void
    {
        $this->updateTime = $updateTime;
    }

    /**
     * @param int $topEndTime
     *
     * @return void
     */
    public function setTopEndTime(int $topEndTime): void
    {
        $this->topEndTime = $topEndTime;
    }

    /**
     * @param int $publishTime
     *
     * @return void
     */
    public function setPublishTime(int $publishTime): void
    {
        $this->publishTime = $publishTime;
    }

    /**
     * @return int
     */
    public function getArtId(): int
    {
        return $this->artId;
    }

    /**
     * @return string
     */
    public function getRandomId(): string
    {
        return $this->randomId;
    }

    /**
     * @return int
     */
    public function getUserId(): int
    {
        return $this->userId;
    }

    /**
     * @return int
     */
    public function getArtCategoryId(): int
    {
        return $this->artCategoryId;
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @return float
     */
    public function getHotScore(): float
    {
        return $this->hotScore;
    }

    /**
     * @return int
     */
    public function getPv(): int
    {
        return $this->pv;
    }

    /**
     * @return int
     */
    public function getRv(): int
    {
        return $this->rv;
    }

    /**
     * @return int
     */
    public function getCollection(): int
    {
        return $this->collection;
    }

    /**
     * @return int
     */
    public function getStar(): int
    {
        return $this->star;
    }

    /**
     * @return int
     */
    public function getStatus(): int
    {
        return $this->status;
    }

    /**
     * @return int
     */
    public function getProvince(): int
    {
        return $this->province;
    }

    /**
     * @return int|null
     */
    public function getCity(): ?int
    {
        return $this->city;
    }

    /**
     * @return int|null
     */
    public function getArea(): ?int
    {
        return $this->area;
    }

    /**
     * @return int
     */
    public function getContentQuality(): int
    {
        return $this->contentQuality;
    }

    /**
     * @return int
     */
    public function getCreateTime(): int
    {
        return $this->createTime;
    }

    /**
     * @return int
     */
    public function getUpdateTime(): int
    {
        return $this->updateTime;
    }

    /**
     * @return int
     */
    public function getTopEndTime(): int
    {
        return $this->topEndTime;
    }

    /**
     * @return int
     */
    public function getPublishTime(): int
    {
        return $this->publishTime;
    }

}
