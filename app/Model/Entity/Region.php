<?php declare(strict_types=1);


namespace App\Model\Entity;

use Swoft\Db\Annotation\Mapping\Column;
use Swoft\Db\Annotation\Mapping\Entity;
use Swoft\Db\Annotation\Mapping\Id;
use Swoft\Db\Eloquent\Model;


/**
 * 地区表
 * Class Region
 *
 * @since 2.0
 *
 * @Entity(table="region")
 */
class Region extends Model
{
    /**
     * 
     * @Id()
     * @Column(name="region_id", prop="regionId")
     *
     * @var int
     */
    private $regionId;

    /**
     * 
     *
     * @Column()
     *
     * @var string
     */
    private $name;

    /**
     * 
     *
     * @Column()
     *
     * @var string
     */
    private $code;

    /**
     * 
     *
     * @Column(name="parent_code", prop="parentCode")
     *
     * @var string
     */
    private $parentCode;

    /**
     * 
     *
     * @Column()
     *
     * @var int|null
     */
    private $level;


    /**
     * @param int $regionId
     *
     * @return void
     */
    public function setRegionId(int $regionId): void
    {
        $this->regionId = $regionId;
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
     * @param string $code
     *
     * @return void
     */
    public function setCode(string $code): void
    {
        $this->code = $code;
    }

    /**
     * @param string $parentCode
     *
     * @return void
     */
    public function setParentCode(string $parentCode): void
    {
        $this->parentCode = $parentCode;
    }

    /**
     * @param int|null $level
     *
     * @return void
     */
    public function setLevel(?int $level): void
    {
        $this->level = $level;
    }

    /**
     * @return int
     */
    public function getRegionId(): int
    {
        return $this->regionId;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getCode(): string
    {
        return $this->code;
    }

    /**
     * @return string
     */
    public function getParentCode(): string
    {
        return $this->parentCode;
    }

    /**
     * @return int|null
     */
    public function getLevel(): ?int
    {
        return $this->level;
    }

}
