<?php

namespace App\Model\Data;

use App\Model\Dao\ArtCommentDao;
use App\Model\Dao\ArticleDao;
use Swoft\Bean\Annotation\Mapping\Bean;
use Swoft\Bean\Annotation\Mapping\Inject;

/**
 *
 * @Bean()
 */
class ArtCommentData
{
    /**
     *
     * @Inject()
     * @var ArtCommentDao
     */
    private $artCommentDao;

    public function getDefaultTwo($artId)
    {
        return $this->artCommentDao->getDefaultTwo($artId);
    }

}
