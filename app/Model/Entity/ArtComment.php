<?php declare(strict_types=1);


namespace App\Model\Entity;

use Swoft\Db\Annotation\Mapping\Column;
use Swoft\Db\Annotation\Mapping\Entity;
use Swoft\Db\Annotation\Mapping\Id;
use Swoft\Db\Eloquent\Model;


/**
 * 话题评论表
 * Class ArtComment
 *
 * @since 2.0
 *
 * @Entity(table="art_comment")
 */
class ArtComment extends Model
{
    /**
     * 主键ID
     * @Id()
     * @Column(name="art_comment_id", prop="artCommentId")
     *
     * @var int
     */
    private $artCommentId;

    /**
     * 话题ID
     *
     * @Column(name="art_id", prop="artId")
     *
     * @var int
     */
    private $artId;

    /**
     * 发表评论用户的id
     *
     * @Column(name="comment_user_id", prop="commentUserId")
     *
     * @var int
     */
    private $commentUserId;

    /**
     * 被回复的评论的id
     *
     * @Column(name="parent_comment_id", prop="parentCommentId")
     *
     * @var int
     */
    private $parentCommentId;

    /**
     * 被回复的评论的user_id
     *
     * @Column(name="parent_comment_user_id", prop="parentCommentUserId")
     *
     * @var int
     */
    private $parentCommentUserId;

    /**
     * 从属的话题一级评论
     *
     * @Column(name="belong_comment_id", prop="belongCommentId")
     *
     * @var int
     */
    private $belongCommentId;

    /**
     * 评论内容
     *
     * @Column()
     *
     * @var string
     */
    private $content;

    /**
     * 评论类型 1文章的评论 2文章的评论的回复
     *
     * @Column()
     *
     * @var int
     */
    private $type;

    /**
     * 点赞数
     *
     * @Column()
     *
     * @var int
     */
    private $star;

    /**
     * 1已读  0未读
     *
     * @Column(name="is_read", prop="isRead")
     *
     * @var int
     */
    private $isRead;

    /**
     * 状态：1正常2涉敏感10删除
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
     * @param int $artCommentId
     *
     * @return void
     */
    public function setArtCommentId(int $artCommentId): void
    {
        $this->artCommentId = $artCommentId;
    }

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
     * @param int $commentUserId
     *
     * @return void
     */
    public function setCommentUserId(int $commentUserId): void
    {
        $this->commentUserId = $commentUserId;
    }

    /**
     * @param int $parentCommentId
     *
     * @return void
     */
    public function setParentCommentId(int $parentCommentId): void
    {
        $this->parentCommentId = $parentCommentId;
    }

    /**
     * @param int $parentCommentUserId
     *
     * @return void
     */
    public function setParentCommentUserId(int $parentCommentUserId): void
    {
        $this->parentCommentUserId = $parentCommentUserId;
    }

    /**
     * @param int $belongCommentId
     *
     * @return void
     */
    public function setBelongCommentId(int $belongCommentId): void
    {
        $this->belongCommentId = $belongCommentId;
    }

    /**
     * @param string $content
     *
     * @return void
     */
    public function setContent(string $content): void
    {
        $this->content = $content;
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
     * @param int $star
     *
     * @return void
     */
    public function setStar(int $star): void
    {
        $this->star = $star;
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
    public function getArtCommentId(): int
    {
        return $this->artCommentId;
    }

    /**
     * @return int
     */
    public function getArtId(): int
    {
        return $this->artId;
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
    public function getParentCommentId(): int
    {
        return $this->parentCommentId;
    }

    /**
     * @return int
     */
    public function getParentCommentUserId(): int
    {
        return $this->parentCommentUserId;
    }

    /**
     * @return int
     */
    public function getBelongCommentId(): int
    {
        return $this->belongCommentId;
    }

    /**
     * @return string
     */
    public function getContent(): string
    {
        return $this->content;
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
    public function getStar(): int
    {
        return $this->star;
    }

    /**
     * @return int
     */
    public function getIsRead(): int
    {
        return $this->isRead;
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
