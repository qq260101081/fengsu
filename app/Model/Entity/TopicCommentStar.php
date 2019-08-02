<?php declare(strict_types=1);


namespace App\Model\Entity;

use Swoft\Db\Annotation\Mapping\Column;
use Swoft\Db\Annotation\Mapping\Entity;
use Swoft\Db\Annotation\Mapping\Id;
use Swoft\Db\Eloquent\Model;


/**
 * 话题点赞表
 * Class TopicCommentStar
 *
 * @since 2.0
 *
 * @Entity(table="topic_comment_star")
 */
class TopicCommentStar extends Model
{
    /**
     * 话题点赞表主键
     * @Id()
     * @Column(name="topic_comment_star_id", prop="topicCommentStarId")
     *
     * @var int
     */
    private $topicCommentStarId;

    /**
     * 话题ID
     *
     * @Column(name="topic_id", prop="topicId")
     *
     * @var int
     */
    private $topicId;

    /**
     * 被点赞的评论的ID
     *
     * @Column(name="topic_comment_id", prop="topicCommentId")
     *
     * @var int
     */
    private $topicCommentId;

    /**
     * 被点赞的评论所属的用户的id
     *
     * @Column(name="topic_comment_user_id", prop="topicCommentUserId")
     *
     * @var int
     */
    private $topicCommentUserId;

    /**
     * 点赞的用户的id
     *
     * @Column(name="star_user_id", prop="starUserId")
     *
     * @var int
     */
    private $starUserId;

    /**
     * 0已点赞1取消点赞
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
     * 1已读  0未读
     *
     * @Column(name="is_read", prop="isRead")
     *
     * @var int
     */
    private $isRead;


    /**
     * @param int $topicCommentStarId
     *
     * @return void
     */
    public function setTopicCommentStarId(int $topicCommentStarId): void
    {
        $this->topicCommentStarId = $topicCommentStarId;
    }

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
     * @param int $topicCommentId
     *
     * @return void
     */
    public function setTopicCommentId(int $topicCommentId): void
    {
        $this->topicCommentId = $topicCommentId;
    }

    /**
     * @param int $topicCommentUserId
     *
     * @return void
     */
    public function setTopicCommentUserId(int $topicCommentUserId): void
    {
        $this->topicCommentUserId = $topicCommentUserId;
    }

    /**
     * @param int $starUserId
     *
     * @return void
     */
    public function setStarUserId(int $starUserId): void
    {
        $this->starUserId = $starUserId;
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
     * @param int $isRead
     *
     * @return void
     */
    public function setIsRead(int $isRead): void
    {
        $this->isRead = $isRead;
    }

    /**
     * @return int
     */
    public function getTopicCommentStarId(): int
    {
        return $this->topicCommentStarId;
    }

    /**
     * @return int
     */
    public function getTopicId(): int
    {
        return $this->topicId;
    }

    /**
     * @return int
     */
    public function getTopicCommentId(): int
    {
        return $this->topicCommentId;
    }

    /**
     * @return int
     */
    public function getTopicCommentUserId(): int
    {
        return $this->topicCommentUserId;
    }

    /**
     * @return int
     */
    public function getStarUserId(): int
    {
        return $this->starUserId;
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

    /**
     * @return int
     */
    public function getIsRead(): int
    {
        return $this->isRead;
    }

}
