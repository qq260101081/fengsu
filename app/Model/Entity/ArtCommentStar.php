<?php declare(strict_types=1);


namespace App\Model\Entity;

use Swoft\Db\Annotation\Mapping\Column;
use Swoft\Db\Annotation\Mapping\Entity;
use Swoft\Db\Annotation\Mapping\Id;
use Swoft\Db\Eloquent\Model;


/**
 * 文章点赞表
 * Class ArtCommentStar
 *
 * @since 2.0
 *
 * @Entity(table="art_comment_star")
 */
class ArtCommentStar extends Model
{
    /**
     * 主键ID
     * @Id()
     * @Column(name="art_comment_star_id", prop="artCommentStarId")
     *
     * @var int
     */
    private $artCommentStarId;

    /**
     * 文章ID
     *
     * @Column(name="art_id", prop="artId")
     *
     * @var int
     */
    private $artId;

    /**
     * 被点赞的评论的ID
     *
     * @Column(name="art_comment_id", prop="artCommentId")
     *
     * @var int
     */
    private $artCommentId;

    /**
     * 被点赞的评论的用户id
     *
     * @Column(name="art_comment_user_id", prop="artCommentUserId")
     *
     * @var int
     */
    private $artCommentUserId;

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
     * 1已读  0未读
     *
     * @Column(name="is_read", prop="isRead")
     *
     * @var int
     */
    private $isRead;


    /**
     * @param int $artCommentStarId
     *
     * @return void
     */
    public function setArtCommentStarId(int $artCommentStarId): void
    {
        $this->artCommentStarId = $artCommentStarId;
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
     * @param int $artCommentId
     *
     * @return void
     */
    public function setArtCommentId(int $artCommentId): void
    {
        $this->artCommentId = $artCommentId;
    }

    /**
     * @param int $artCommentUserId
     *
     * @return void
     */
    public function setArtCommentUserId(int $artCommentUserId): void
    {
        $this->artCommentUserId = $artCommentUserId;
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
    public function getArtCommentStarId(): int
    {
        return $this->artCommentStarId;
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
    public function getArtCommentId(): int
    {
        return $this->artCommentId;
    }

    /**
     * @return int
     */
    public function getArtCommentUserId(): int
    {
        return $this->artCommentUserId;
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
    public function getIsRead(): int
    {
        return $this->isRead;
    }

}
