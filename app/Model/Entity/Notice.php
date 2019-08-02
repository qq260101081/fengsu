<?php declare(strict_types=1);


namespace App\Model\Entity;

use Swoft\Db\Annotation\Mapping\Column;
use Swoft\Db\Annotation\Mapping\Entity;
use Swoft\Db\Annotation\Mapping\Id;
use Swoft\Db\Eloquent\Model;


/**
 * 系统通知表
 * Class Notice
 *
 * @since 2.0
 *
 * @Entity(table="notice")
 */
class Notice extends Model
{
    /**
     * 主键ID
     * @Id()
     * @Column(name="notice_id", prop="noticeId")
     *
     * @var int
     */
    private $noticeId;

    /**
     * 消息类型：0通知
     *
     * @Column()
     *
     * @var int
     */
    private $type;

    /**
     * 消息状态：1正常显示2删除
     *
     * @Column()
     *
     * @var int
     */
    private $status;

    /**
     * 标题
     *
     * @Column()
     *
     * @var string
     */
    private $title;

    /**
     * 内容
     *
     * @Column()
     *
     * @var string
     */
    private $content;

    /**
     * 发送人群
     *
     * @Column(name="send_crowd", prop="sendCrowd")
     *
     * @var string
     */
    private $sendCrowd;

    /**
     * 是否已发送 0未发送 1已发送
     *
     * @Column(name="is_send", prop="isSend")
     *
     * @var int
     */
    private $isSend;

    /**
     * 定时发送时间
     *
     * @Column(name="timing_time", prop="timingTime")
     *
     * @var int
     */
    private $timingTime;

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
     * @param int $noticeId
     *
     * @return void
     */
    public function setNoticeId(int $noticeId): void
    {
        $this->noticeId = $noticeId;
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
     * @param string $title
     *
     * @return void
     */
    public function setTitle(string $title): void
    {
        $this->title = $title;
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
     * @param string $sendCrowd
     *
     * @return void
     */
    public function setSendCrowd(string $sendCrowd): void
    {
        $this->sendCrowd = $sendCrowd;
    }

    /**
     * @param int $isSend
     *
     * @return void
     */
    public function setIsSend(int $isSend): void
    {
        $this->isSend = $isSend;
    }

    /**
     * @param int $timingTime
     *
     * @return void
     */
    public function setTimingTime(int $timingTime): void
    {
        $this->timingTime = $timingTime;
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
    public function getNoticeId(): int
    {
        return $this->noticeId;
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
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @return string
     */
    public function getContent(): string
    {
        return $this->content;
    }

    /**
     * @return string
     */
    public function getSendCrowd(): string
    {
        return $this->sendCrowd;
    }

    /**
     * @return int
     */
    public function getIsSend(): int
    {
        return $this->isSend;
    }

    /**
     * @return int
     */
    public function getTimingTime(): int
    {
        return $this->timingTime;
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
