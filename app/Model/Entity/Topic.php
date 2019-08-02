<?php declare(strict_types=1);


namespace App\Model\Entity;

use Swoft\Db\Annotation\Mapping\Column;
use Swoft\Db\Annotation\Mapping\Entity;
use Swoft\Db\Annotation\Mapping\Id;
use Swoft\Db\Eloquent\Model;


/**
 * 话题表
 * Class Topic
 *
 * @since 2.0
 *
 * @Entity(table="topic")
 */
class Topic extends Model
{
    /**
     * 主键ID
     * @Id()
     * @Column(name="topic_id", prop="topicId")
     *
     * @var int
     */
    private $topicId;

    /**
     * 随机ID
     *
     * @Column(name="random_id", prop="randomId")
     *
     * @var string
     */
    private $randomId;

    /**
     * 标题
     *
     * @Column()
     *
     * @var string
     */
    private $title;

    /**
     * 图片列表
     *
     * @Column(name="pic_list", prop="picList")
     *
     * @var string
     */
    private $picList;

    /**
     * 正方点赞数
     *
     * @Column()
     *
     * @var int
     */
    private $good;

    /**
     * 反方点赞数
     *
     * @Column()
     *
     * @var int
     */
    private $bad;

    /**
     * 正方的标题描述
     *
     * @Column(name="good_title", prop="goodTitle")
     *
     * @var string
     */
    private $goodTitle;

    /**
     * 反方的标题描述
     *
     * @Column(name="bad_title", prop="badTitle")
     *
     * @var string
     */
    private $badTitle;

    /**
     * 0正常1下架
     *
     * @Column()
     *
     * @var int
     */
    private $status;

    /**
     * 更新时间
     *
     * @Column(name="update_time", prop="updateTime")
     *
     * @var string
     */
    private $updateTime;

    /**
     * 创建时间
     *
     * @Column(name="create_time", prop="createTime")
     *
     * @var string
     */
    private $createTime;


    /**
     * @param int $topicId
     *
     * @return void
     */
    public function setTopicId(int $topicId): void
    {
        $this->topicId = $topicId;
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
     * @param string $title
     *
     * @return void
     */
    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    /**
     * @param string $picList
     *
     * @return void
     */
    public function setPicList(string $picList): void
    {
        $this->picList = $picList;
    }

    /**
     * @param int $good
     *
     * @return void
     */
    public function setGood(int $good): void
    {
        $this->good = $good;
    }

    /**
     * @param int $bad
     *
     * @return void
     */
    public function setBad(int $bad): void
    {
        $this->bad = $bad;
    }

    /**
     * @param string $goodTitle
     *
     * @return void
     */
    public function setGoodTitle(string $goodTitle): void
    {
        $this->goodTitle = $goodTitle;
    }

    /**
     * @param string $badTitle
     *
     * @return void
     */
    public function setBadTitle(string $badTitle): void
    {
        $this->badTitle = $badTitle;
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
     * @param string $updateTime
     *
     * @return void
     */
    public function setUpdateTime(string $updateTime): void
    {
        $this->updateTime = $updateTime;
    }

    /**
     * @param string $createTime
     *
     * @return void
     */
    public function setCreateTime(string $createTime): void
    {
        $this->createTime = $createTime;
    }

    /**
     * @return int
     */
    public function getTopicId(): int
    {
        return $this->topicId;
    }

    /**
     * @return string
     */
    public function getRandomId(): string
    {
        return $this->randomId;
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @return string
     */
    public function getPicList(): string
    {
        return $this->picList;
    }

    /**
     * @return int
     */
    public function getGood(): int
    {
        return $this->good;
    }

    /**
     * @return int
     */
    public function getBad(): int
    {
        return $this->bad;
    }

    /**
     * @return string
     */
    public function getGoodTitle(): string
    {
        return $this->goodTitle;
    }

    /**
     * @return string
     */
    public function getBadTitle(): string
    {
        return $this->badTitle;
    }

    /**
     * @return int
     */
    public function getStatus(): int
    {
        return $this->status;
    }

    /**
     * @return string
     */
    public function getUpdateTime(): string
    {
        return $this->updateTime;
    }

    /**
     * @return string
     */
    public function getCreateTime(): string
    {
        return $this->createTime;
    }

}
