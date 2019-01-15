<?php

declare(strict_types = 1);

namespace Userstory\Yii2Dto\dataTransferObjects\results;

use Userstory\Yii2Dto\interfaces\results\IdResultInterface;
use Userstory\Yii2Dto\traits\WithIdTrait;

/**
 * Класс результата, основанный на ИД сущности.
 */
class IdResult extends BaseResult implements IdResultInterface
{
    use WithIdTrait;
}
