<?php declare(strict_types=1);


namespace App\Model\Entity;

use Swoft\Db\Annotation\Mapping\Column;
use Swoft\Db\Annotation\Mapping\Entity;
use Swoft\Db\Annotation\Mapping\Id;
use Swoft\Db\Eloquent\Model;


/**
 * 
 * Class Menu
 *
 * @since 2.0
 *
 * @Entity(table="menu")
 */
class Menu extends Model
{
    /**
     * 主键
     * @Id(incrementing=false)
     * @Column(name="menu_id", prop="menuId")
     *
     * @var int
     */
    private $menuId;

    /**
     * 菜单名称
     *
     * @Column()
     *
     * @var string
     */
    private $name;

    /**
     * 0 正常  1禁用
     *
     * @Column()
     *
     * @var int
     */
    private $display;


    /**
     * @param int $menuId
     *
     * @return void
     */
    public function setMenuId(int $menuId): void
    {
        $this->menuId = $menuId;
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
     * @param int $display
     *
     * @return void
     */
    public function setDisplay(int $display): void
    {
        $this->display = $display;
    }

    /**
     * @return int
     */
    public function getMenuId(): int
    {
        return $this->menuId;
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
    public function getDisplay(): int
    {
        return $this->display;
    }

}
