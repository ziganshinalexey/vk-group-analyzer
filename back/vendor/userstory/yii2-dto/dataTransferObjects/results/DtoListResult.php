<?php

declare(strict_types = 1);

namespace Userstory\Yii2Dto\dataTransferObjects\results;

use Userstory\Yii2Dto\interfaces\results\DtoListResultInterface;
use Userstory\Yii2Dto\traits\WithDtoListTrait;

/**
 * Класс результата, основанный на списке ДТО.
 */
class DtoListResult extends BaseResult implements DtoListResultInterface
{
    use WithDtoListTrait;
}
