<?php declare(strict_types=1);


namespace App\Model\Entity;

use Swoft\Db\Annotation\Mapping\Column;
use Swoft\Db\Annotation\Mapping\Entity;
use Swoft\Db\Annotation\Mapping\Id;
use Swoft\Db\Eloquent\Model;


/**
 * 文章内容表
 * Class ArtContent
 *
 * @since 2.0
 *
 * @Entity(table="art_content")
 */
class ArtContent extends Model
{
    /**
     * 外键文章ID
     * @Id(incrementing=false)
     * @Column(name="art_id", prop="artId")
     *
     * @var int
     */
    private $artId;

    /**
     * 文章内容
     *
     * @Column()
     *
     * @var string
     */
    private $content;


    /**
     * @param int $artId
     *
     * @return void
     */
    public function setArtId(int $artId): void
    {
        $this->artId = $artId;
    }

    /**
     * @param string $content
     *
     * @return void
     */
    public function setContent(string $content): void
    {
        $this->content = $content;
    }

    /**
     * @return int
     */
    public function getArtId(): int
    {
        return $this->artId;
    }

    /**
     * @return string
     */
    public function getContent(): string
    {
        return $this->content;
    }

}
