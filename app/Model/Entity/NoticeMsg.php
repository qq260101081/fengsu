<?php declare(strict_types=1);


namespace App\Model\Entity;

use Swoft\Db\Annotation\Mapping\Column;
use Swoft\Db\Annotation\Mapping\Entity;
use Swoft\Db\Annotation\Mapping\Id;
use Swoft\Db\Eloquent\Model;


/**
 * 通知消息表
 * Class NoticeMsg
 *
 * @since 2.0
 *
 * @Entity(table="notice_msg")
 */
class NoticeMsg extends Model
{
    /**
     * 主键ID
     * @Id()
     * @Column(name="notice_msg_id", prop="noticeMsgId")
     *
     * @var int
     */
    private $noticeMsgId;

    /**
     * 用户ID
     *
     * @Column(name="user_id", prop="userId")
     *
     * @var int
     */
    private $userId;

    /**
     * 通知ID
     *
     * @Column(name="notice_id", prop="noticeId")
     *
     * @var int
     */
    private $noticeId;

    /**
     * 创建时间
     *
     * @Column(name="create_time", prop="createTime")
     *
     * @var int
     */
    private $createTime;

    /**
     * 
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
     * @param int $noticeMsgId
     *
     * @return void
     */
    public function setNoticeMsgId(int $noticeMsgId): void
    {
        $this->noticeMsgId = $noticeMsgId;
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
     * @param int $noticeId
     *
     * @return void
     */
    public function setNoticeId(int $noticeId): void
    {
        $this->noticeId = $noticeId;
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
    public function getNoticeMsgId(): int
    {
        return $this->noticeMsgId;
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
    public function getNoticeId(): int
    {
        return $this->noticeId;
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
