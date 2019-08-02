<?php declare(strict_types=1);


namespace App\Model\Entity;

use Swoft\Db\Annotation\Mapping\Column;
use Swoft\Db\Annotation\Mapping\Entity;
use Swoft\Db\Annotation\Mapping\Id;
use Swoft\Db\Eloquent\Model;


/**
 * 文章收藏表
 * Class Collection
 *
 * @since 2.0
 *
 * @Entity(table="collection")
 */
class Collection extends Model
{
    /**
     * 主键ID
     * @Id()
     * @Column(name="collection_id", prop="collectionId")
     *
     * @var int
     */
    private $collectionId;

    /**
     * 文章ID
     *
     * @Column(name="art_id", prop="artId")
     *
     * @var int
     */
    private $artId;

    /**
     * 用户ID
     *
     * @Column(name="user_id", prop="userId")
     *
     * @var int
     */
    private $userId;

    /**
     * 文章所属用户ID
     *
     * @Column(name="art_user_id", prop="artUserId")
     *
     * @var int
     */
    private $artUserId;

    /**
     * 0收藏中1已删除
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
     * @param int $collectionId
     *
     * @return void
     */
    public function setCollectionId(int $collectionId): void
    {
        $this->collectionId = $collectionId;
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
    public function getCollectionId(): int
    {
        return $this->collectionId;
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
