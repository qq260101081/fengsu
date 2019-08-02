<?php declare(strict_types=1);


namespace App\Model\Entity;

use Swoft\Db\Annotation\Mapping\Column;
use Swoft\Db\Annotation\Mapping\Entity;
use Swoft\Db\Annotation\Mapping\Id;
use Swoft\Db\Eloquent\Model;


/**
 * 
 * Class ManagerLoginLog
 *
 * @since 2.0
 *
 * @Entity(table="manager_login_log")
 */
class ManagerLoginLog extends Model
{
    /**
     * 主键
     * @Id()
     * @Column(name="login_log_id", prop="loginLogId")
     *
     * @var int
     */
    private $loginLogId;

    /**
     * 管理员表id
     *
     * @Column(name="mannager_id", prop="mannagerId")
     *
     * @var int
     */
    private $mannagerId;

    /**
     * 操作的路径
     *
     * @Column(name="action_path", prop="actionPath")
     *
     * @var string
     */
    private $actionPath;

    /**
     * 禁用状态 1禁止登陆 0正常
     *
     * @Column()
     *
     * @var int
     */
    private $disable;

    /**
     * 登录次数
     *
     * @Column(name="login_num", prop="loginNum")
     *
     * @var int
     */
    private $loginNum;

    /**
     * 最后登录IP
     *
     * @Column(name="last_login_ip", prop="lastLoginIp")
     *
     * @var string
     */
    private $lastLoginIp;

    /**
     * 最后登录时间
     *
     * @Column(name="last_login_time", prop="lastLoginTime")
     *
     * @var string
     */
    private $lastLoginTime;

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
     * @param int $loginLogId
     *
     * @return void
     */
    public function setLoginLogId(int $loginLogId): void
    {
        $this->loginLogId = $loginLogId;
    }

    /**
     * @param int $mannagerId
     *
     * @return void
     */
    public function setMannagerId(int $mannagerId): void
    {
        $this->mannagerId = $mannagerId;
    }

    /**
     * @param string $actionPath
     *
     * @return void
     */
    public function setActionPath(string $actionPath): void
    {
        $this->actionPath = $actionPath;
    }

    /**
     * @param int $disable
     *
     * @return void
     */
    public function setDisable(int $disable): void
    {
        $this->disable = $disable;
    }

    /**
     * @param int $loginNum
     *
     * @return void
     */
    public function setLoginNum(int $loginNum): void
    {
        $this->loginNum = $loginNum;
    }

    /**
     * @param string $lastLoginIp
     *
     * @return void
     */
    public function setLastLoginIp(string $lastLoginIp): void
    {
        $this->lastLoginIp = $lastLoginIp;
    }

    /**
     * @param string $lastLoginTime
     *
     * @return void
     */
    public function setLastLoginTime(string $lastLoginTime): void
    {
        $this->lastLoginTime = $lastLoginTime;
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
    public function getLoginLogId(): int
    {
        return $this->loginLogId;
    }

    /**
     * @return int
     */
    public function getMannagerId(): int
    {
        return $this->mannagerId;
    }

    /**
     * @return string
     */
    public function getActionPath(): string
    {
        return $this->actionPath;
    }

    /**
     * @return int
     */
    public function getDisable(): int
    {
        return $this->disable;
    }

    /**
     * @return int
     */
    public function getLoginNum(): int
    {
        return $this->loginNum;
    }

    /**
     * @return string
     */
    public function getLastLoginIp(): string
    {
        return $this->lastLoginIp;
    }

    /**
     * @return string
     */
    public function getLastLoginTime(): string
    {
        return $this->lastLoginTime;
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
