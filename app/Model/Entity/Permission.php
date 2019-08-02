<?php declare(strict_types=1);


namespace App\Model\Entity;

use Swoft\Db\Annotation\Mapping\Column;
use Swoft\Db\Annotation\Mapping\Entity;
use Swoft\Db\Annotation\Mapping\Id;
use Swoft\Db\Eloquent\Model;


/**
 * 
 * Class Permission
 *
 * @since 2.0
 *
 * @Entity(table="permission")
 */
class Permission extends Model
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
     * 权限路径
     *
     * @Column()
     *
     * @var string
     */
    private $path;

    /**
     * 备注
     *
     * @Column()
     *
     * @var string
     */
    private $mark;


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
     * @param string $path
     *
     * @return void
     */
    public function setPath(string $path): void
    {
        $this->path = $path;
    }

    /**
     * @param string $mark
     *
     * @return void
     */
    public function setMark(string $mark): void
    {
        $this->mark = $mark;
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
    public function getPath(): string
    {
        return $this->path;
    }

    /**
     * @return string
     */
    public function getMark(): string
    {
        return $this->mark;
    }

}
