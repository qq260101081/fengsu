<?php declare(strict_types=1);


namespace App\Model\Entity;

use Swoft\Db\Annotation\Mapping\Column;
use Swoft\Db\Annotation\Mapping\Entity;
use Swoft\Db\Annotation\Mapping\Id;
use Swoft\Db\Eloquent\Model;


/**
 * 文章图片表
 * Class ArtImg
 *
 * @since 2.0
 *
 * @Entity(table="art_img")
 */
class ArtImg extends Model
{
    /**
     * 主键ID
     * @Id()
     * @Column(name="art_img_id", prop="artImgId")
     *
     * @var int
     */
    private $artImgId;

    /**
     * 文章ID
     *
     * @Column(name="art_id", prop="artId")
     *
     * @var int|null
     */
    private $artId;

    /**
     * 图片地址
     *
     * @Column()
     *
     * @var string
     */
    private $url;


    /**
     * @param int $artImgId
     *
     * @return void
     */
    public function setArtImgId(int $artImgId): void
    {
        $this->artImgId = $artImgId;
    }

    /**
     * @param int|null $artId
     *
     * @return void
     */
    public function setArtId(?int $artId): void
    {
        $this->artId = $artId;
    }

    /**
     * @param string $url
     *
     * @return void
     */
    public function setUrl(string $url): void
    {
        $this->url = $url;
    }

    /**
     * @return int
     */
    public function getArtImgId(): int
    {
        return $this->artImgId;
    }

    /**
     * @return int|null
     */
    public function getArtId(): ?int
    {
        return $this->artId;
    }

    /**
     * @return string
     */
    public function getUrl(): string
    {
        return $this->url;
    }

}
