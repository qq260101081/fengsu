<?php declare(strict_types=1);


namespace App\Model\Entity;

use Swoft\Db\Annotation\Mapping\Column;
use Swoft\Db\Annotation\Mapping\Entity;
use Swoft\Db\Annotation\Mapping\Id;
use Swoft\Db\Eloquent\Model;


/**
 * 评论消息表
 * Class CommentMsg
 *
 * @since 2.0
 *
 * @Entity(table="comment_msg")
 */
class CommentMsg extends Model
{
    /**
     * 主键ID
     * @Id()
     * @Column(name="comment_msg_id", prop="commentMsgId")
     *
     * @var int
     */
    private $commentMsgId;

    /**
     * 文章ID或话题ID
     *
     * @Column(name="art_topic_id", prop="artTopicId")
     *
     * @var int
     */
    private $artTopicId;

    /**
     * 评论用户ID
     *
     * @Column(name="user_id", prop="userId")
     *
     * @var int
     */
    private $userId;

    /**
     * 被评论用户ID
     *
     * @Column(name="comment_user_id", prop="commentUserId")
     *
     * @var int
     */
    private $commentUserId;

    /**
     * 评论表ID
     *
     * @Column(name="comment_id", prop="commentId")
     *
     * @var int
     */
    private $commentId;

    /**
     * 评论类型，0文章1话题
     *
     * @Column()
     *
     * @var int
     */
    private $type;

    /**
     * 0未读1已读2删除
     *
     * @Column()
     *
     * @var int
     */
    private $status;

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
     * @param int $commentMsgId
     *
     * @return void
     */
    public function setCommentMsgId(int $commentMsgId): void
    {
        $this->commentMsgId = $commentMsgId;
    }

    /**
     * @param int $artTopicId
     *
     * @return void
     */
    public function setArtTopicId(int $artTopicId): void
    {
        $this->artTopicId = $artTopicId;
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
     * @param int $commentUserId
     *
     * @return void
     */
    public function setCommentUserId(int $commentUserId): void
    {
        $this->commentUserId = $commentUserId;
    }

    /**
     * @param int $commentId
     *
     * @return void
     */
    public function setCommentId(int $commentId): void
    {
        $this->commentId = $commentId;
    }

    /**
     * @param int $type
     *
     * @return void
     */
    public function setType(int $type): void
    {
        $this->type = $type;
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
     * @return int
     */
    public function getCommentMsgId(): int
    {
        return $this->commentMsgId;
    }

    /**
     * @return int
     */
    public function getArtTopicId(): int
    {
        return $this->artTopicId;
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
    public function getCommentUserId(): int
    {
        return $this->commentUserId;
    }

    /**
     * @return int
     */
    public function getCommentId(): int
    {
        return $this->commentId;
    }

    /**
     * @return int
     */
    public function getType(): int
    {
        return $this->type;
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

}
