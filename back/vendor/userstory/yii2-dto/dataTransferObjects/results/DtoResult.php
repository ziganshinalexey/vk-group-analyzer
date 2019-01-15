<?php

declare(strict_types = 1);

namespace Userstory\Yii2Dto\dataTransferObjects\results;

use Userstory\Yii2Dto\interfaces\results\DtoResultInterface;
use Userstory\Yii2Dto\traits\WithDtoTrait;

/**
 * Класс результата, основанный на ДТО.
 */
class DtoResult extends BaseResult implements DtoResultInterface
{
    use WithDtoTrait;
}
