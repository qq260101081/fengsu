<?php declare(strict_types=1);


namespace App\Model\Entity;

use Swoft\Db\Annotation\Mapping\Column;
use Swoft\Db\Annotation\Mapping\Entity;
use Swoft\Db\Annotation\Mapping\Id;
use Swoft\Db\Eloquent\Model;


/**
 * 文章分类表
 * Class ArtCategory
 *
 * @since 2.0
 *
 * @Entity(table="art_category")
 */
class ArtCategory extends Model
{
    /**
     * 主键ID
     * @Id()
     * @Column(name="art_category_id", prop="artCategoryId")
     *
     * @var int
     */
    private $artCategoryId;

    /**
     * 分类名称
     *
     * @Column()
     *
     * @var string
     */
    private $name;

    /**
     * 热度分
     *
     * @Column()
     *
     * @var float
     */
    private $score;

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
     * @param int $artCategoryId
     *
     * @return void
     */
    public function setArtCategoryId(int $artCategoryId): void
    {
        $this->artCategoryId = $artCategoryId;
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
     * @param float $score
     *
     * @return void
     */
    public function setScore(float $score): void
    {
        $this->score = $score;
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
    public function getArtCategoryId(): int
    {
        return $this->artCategoryId;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return float
     */
    public function getScore(): float
    {
        return $this->score;
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
