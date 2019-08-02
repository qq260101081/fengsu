<?php declare(strict_types=1);


namespace App\Model\Entity;

use Swoft\Db\Annotation\Mapping\Column;
use Swoft\Db\Annotation\Mapping\Entity;
use Swoft\Db\Annotation\Mapping\Id;
use Swoft\Db\Eloquent\Model;


/**
 * 话题投票记录表
 * Class TopicVote
 *
 * @since 2.0
 *
 * @Entity(table="topic_vote")
 */
class TopicVote extends Model
{
    /**
     * 主键ID
     * @Id()
     * @Column(name="topic_vote_id", prop="topicVoteId")
     *
     * @var int
     */
    private $topicVoteId;

    /**
     * 用户ID
     *
     * @Column(name="user_id", prop="userId")
     *
     * @var int
     */
    private $userId;

    /**
     * 话题ID
     *
     * @Column(name="topic_id", prop="topicId")
     *
     * @var int
     */
    private $topicId;

    /**
     * 投票类型 1正方 2反方
     *
     * @Column(name="vote_type", prop="voteType")
     *
     * @var int
     */
    private $voteType;

    /**
     * 
     *
     * @Column(name="update_time", prop="updateTime")
     *
     * @var string
     */
    private $updateTime;

    /**
     * 
     *
     * @Column(name="create_time", prop="createTime")
     *
     * @var string
     */
    private $createTime;


    /**
     * @param int $topicVoteId
     *
     * @return void
     */
    public function setTopicVoteId(int $topicVoteId): void
    {
        $this->topicVoteId = $topicVoteId;
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
     * @param int $topicId
     *
     * @return void
     */
    public function setTopicId(int $topicId): void
    {
        $this->topicId = $topicId;
    }

    /**
     * @param int $voteType
     *
     * @return void
     */
    public function setVoteType(int $voteType): void
    {
        $this->voteType = $voteType;
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
    public function getTopicVoteId(): int
    {
        return $this->topicVoteId;
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
    public function getTopicId(): int
    {
        return $this->topicId;
    }

    /**
     * @return int
     */
    public function getVoteType(): int
    {
        return $this->voteType;
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
