<?php declare(strict_types=1);


namespace App\Model\Entity;

use Swoft\Db\Annotation\Mapping\Column;
use Swoft\Db\Annotation\Mapping\Entity;
use Swoft\Db\Annotation\Mapping\Id;
use Swoft\Db\Eloquent\Model;


/**
 * 后台管理员角色表
 * Class Roles
 *
 * @since 2.0
 *
 * @Entity(table="roles")
 */
class Roles extends Model
{
    /**
     * 主键
     * @Id()
     * @Column()
     *
     * @var int
     */
    private $id;

    /**
     * 角色名称
     *
     * @Column()
     *
     * @var string
     */
    private $name;

    /**
     * 父级角色ID
     *
     * @Column(name="parent_id", prop="parentId")
     *
     * @var int
     */
    private $parentId;

    /**
     * 权限id, json格式
     *
     * @Column()
     *
     * @var string
     */
    private $permissions;


    /**
     * @param int $id
     *
     * @return void
     */
    public function setId(int $id): void
    {
        $this->id = $id;
    }

    /**
     * @param string $name
     *
     * @return void
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * @param int $parentId
     *
     * @return void
     */
    public function setParentId(int $parentId): void
    {
        $this->parentId = $parentId;
    }

    /**
     * @param string $permissions
     *
     * @return void
     */
    public function setPermissions(string $permissions): void
    {
        $this->permissions = $permissions;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return int
     */
    public function getParentId(): int
    {
        return $this->parentId;
    }

    /**
     * @return string
     */
    public function getPermissions(): string
    {
        return $this->permissions;
    }

}
