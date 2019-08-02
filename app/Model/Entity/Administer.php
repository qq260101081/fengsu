<?php declare(strict_types=1);


namespace App\Model\Entity;

use Swoft\Db\Annotation\Mapping\Column;
use Swoft\Db\Annotation\Mapping\Entity;
use Swoft\Db\Annotation\Mapping\Id;
use Swoft\Db\Eloquent\Model;


/**
 * 后台管理员表
 * Class Administer
 *
 * @since 2.0
 *
 * @Entity(table="administer")
 */
class Administer extends Model
{
    /**
     * 主键
     * @Id()
     * @Column(name="administer_id", prop="administerId")
     *
     * @var int
     */
    private $administerId;

    /**
     * 角色ID
     *
     * @Column(name="roles_id", prop="rolesId")
     *
     * @var int
     */
    private $rolesId;

    /**
     * 用户名
     *
     * @Column()
     *
     * @var string
     */
    private $username;

    /**
     * 使用php的password_hash函数生成的密码
     *
     * @Column(hidden=true)
     *
     * @var string
     */
    private $password;

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
     * @param int $administerId
     *
     * @return void
     */
    public function setAdministerId(int $administerId): void
    {
        $this->administerId = $administerId;
    }

    /**
     * @param int $rolesId
     *
     * @return void
     */
    public function setRolesId(int $rolesId): void
    {
        $this->rolesId = $rolesId;
    }

    /**
     * @param string $username
     *
     * @return void
     */
    public function setUsername(string $username): void
    {
        $this->username = $username;
    }

    /**
     * @param string $password
     *
     * @return void
     */
    public function setPassword(string $password): void
    {
        $this->password = $password;
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
    public function getAdministerId(): int
    {
        return $this->administerId;
    }

    /**
     * @return int
     */
    public function getRolesId(): int
    {
        return $this->rolesId;
    }

    /**
     * @return string
     */
    public function getUsername(): string
    {
        return $this->username;
    }

    /**
     * @return string
     */
    public function getPassword(): string
    {
        return $this->password;
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
