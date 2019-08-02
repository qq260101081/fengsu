<?php declare(strict_types=1);


namespace App\Model\Entity;

use Swoft\Db\Annotation\Mapping\Column;
use Swoft\Db\Annotation\Mapping\Entity;
use Swoft\Db\Annotation\Mapping\Id;
use Swoft\Db\Eloquent\Model;


/**
 * 点赞关注消息表
 * Class StarCollectionMsg
 *
 * @since 2.0
 *
 * @Entity(table="star_collection_msg")
 */
class StarCollectionMsg extends Model
{
    /**
     * 主键ID
     * @Id()
     * @Column(name="star_collection_msg_id", prop="starCollectionMsgId")
     *
     * @var int
     */
    private $starCollectionMsgId;

    /**
     * 文章或话题ID
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
     * @Column(name="art_user_id", prop="artUserId")
     *
     * @var int
     */
    private $artUserId;

    /**
     * 消息类型，0文章点赞1文章评论点赞2话题评论点赞3收藏
     *
     * @Column()
     *
     * @var int
     */
    private $type;

    /**
     * 评论表主键ID
     *
     * @Column(name="comment_id", prop="commentId")
     *
     * @var int
     */
    private $commentId;

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
     * @param int $starCollectionMsgId
     *
     * @return void
     */
    public function setStarCollectionMsgId(int $starCollectionMsgId): void
    {
        $this->starCollectionMsgId = $starCollectionMsgId;
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
     * @param int $artUserId
     *
     * @return void
     */
    public function setArtUserId(int $artUserId): void
    {
        $this->artUserId = $artUserId;
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
     * @param int $commentId
     *
     * @return void
     */
    public function setCommentId(int $commentId): void
    {
        $this->commentId = $commentId;
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
    public function getStarCollectionMsgId(): int
    {
        return $this->starCollectionMsgId;
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
    public function getArtUserId(): int
    {
        return $this->artUserId;
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
    public function getCommentId(): int
    {
        return $this->commentId;
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
