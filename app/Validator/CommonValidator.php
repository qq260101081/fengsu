<?php declare(strict_types=1);

namespace App\Validator;

use Swoft\Validator\Annotation\Mapping\IsInt;
use Swoft\Validator\Annotation\Mapping\IsString;
use Swoft\Validator\Annotation\Mapping\Range;
use Swoft\Validator\Annotation\Mapping\Length;
use Swoft\Validator\Annotation\Mapping\Validator;

/**
 * Class CommonValidator
 *
 * @since 2.0
 *
 * @Validator(name="CommonValidator")
 */
class CommonValidator
{
    /**
     * @IsInt()
     * @var int
     */
    protected $type;

    /**
     * @IsInt()
     * @Range(min=0, max=2000, message="最大支持2000页")
     * @var int
     */
    protected $page;

    /**
     * @IsString()
     * @Length(name="content", min=5, max=100, message="内容必须是5到100个字符")
     * @var string
     */
    protected $content;



}
