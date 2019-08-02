<?php declare(strict_types=1);


namespace App\Model\Entity;

use Swoft\Db\Annotation\Mapping\Column;
use Swoft\Db\Annotation\Mapping\Entity;
use Swoft\Db\Annotation\Mapping\Id;
use Swoft\Db\Eloquent\Model;


/**
 * 用户表
 * Class User
 *
 * @since 2.0
 *
 * @Entity(table="user")
 */
class User extends Model
{
    /**
     * 主键ID
     * @Id()
     * @Column(name="user_id", prop="userId")
     *
     * @var int
     */
    private $userId;

    /**
     * 手机号
     *
     * @Column()
     *
     * @var string
     */
    private $phone;

    /**
     * 用户昵称
     *
     * @Column()
     *
     * @var string
     */
    private $nickname;

    /**
     * 登录密码
     *
     * @Column(hidden=true)
     *
     * @var string
     */
    private $password;

    /**
     * 头像地址
     *
     * @Column()
     *
     * @var string
     */
    private $avatar;

    /**
     * 性别1男2女0未知
     *
     * @Column()
     *
     * @var int
     */
    private $sex;

    /**
     * 生日
     *
     * @Column()
     *
     * @var string
     */
    private $birthday;

    /**
     * 省编码
     *
     * @Column()
     *
     * @var int
     */
    private $province;

    /**
     * 市编码
     *
     * @Column()
     *
     * @var int
     */
    private $city;

    /**
     * 区编码
     *
     * @Column()
     *
     * @var int
     */
    private $area;

    /**
     * 个性签名
     *
     * @Column()
     *
     * @var string
     */
    private $signature;

    /**
     * 1正常2禁用
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
     * 最后登录时间
     *
     * @Column(name="last_login_time", prop="lastLoginTime")
     *
     * @var int
     */
    private $lastLoginTime;


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
     * @param string $phone
     *
     * @return void
     */
    public function setPhone(string $phone): void
    {
        $this->phone = $phone;
    }

    /**
     * @param string $nickname
     *
     * @return void
     */
    public function setNickname(string $nickname): void
    {
        $this->nickname = $nickname;
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
     * @param string $avatar
     *
     * @return void
     */
    public function setAvatar(string $avatar): void
    {
        $this->avatar = $avatar;
    }

    /**
     * @param int $sex
     *
     * @return void
     */
    public function setSex(int $sex): void
    {
        $this->sex = $sex;
    }

    /**
     * @param string $birthday
     *
     * @return void
     */
    public function setBirthday(string $birthday): void
    {
        $this->birthday = $birthday;
    }

    /**
     * @param int $province
     *
     * @return void
     */
    public function setProvince(int $province): void
    {
        $this->province = $province;
    }

    /**
     * @param int $city
     *
     * @return void
     */
    public function setCity(int $city): void
    {
        $this->city = $city;
    }

    /**
     * @param int $area
     *
     * @return void
     */
    public function setArea(int $area): void
    {
        $this->area = $area;
    }

    /**
     * @param string $signature
     *
     * @return void
     */
    public function setSignature(string $signature): void
    {
        $this->signature = $signature;
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
     * @param int $lastLoginTime
     *
     * @return void
     */
    public function setLastLoginTime(int $lastLoginTime): void
    {
        $this->lastLoginTime = $lastLoginTime;
    }

    /**
     * @return int
     */
    public function getUserId(): int
    {
        return $this->userId;
    }

    /**
     * @return string
     */
    public function getPhone(): string
    {
        return $this->phone;
    }

    /**
     * @return string
     */
    public function getNickname(): string
    {
        return $this->nickname;
    }

    /**
     * @return string
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    /**
     * @return string
     */
    public function getAvatar(): string
    {
        return $this->avatar;
    }

    /**
     * @return int
     */
    public function getSex(): int
    {
        return $this->sex;
    }

    /**
     * @return string
     */
    public function getBirthday(): string
    {
        return $this->birthday;
    }

    /**
     * @return int
     */
    public function getProvince(): int
    {
        return $this->province;
    }

    /**
     * @return int
     */
    public function getCity(): int
    {
        return $this->city;
    }

    /**
     * @return int
     */
    public function getArea(): int
    {
        return $this->area;
    }

    /**
     * @return string
     */
    public function getSignature(): string
    {
        return $this->signature;
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
    public function getLastLoginTime(): int
    {
        return $this->lastLoginTime;
    }

}
