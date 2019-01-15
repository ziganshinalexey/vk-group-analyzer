<?php

declare(strict_types = 1);

namespace Userstory\Yii2Dto\dataTransferObjects\results;

use Userstory\Yii2Dto\interfaces\results\IdListResultInterface;
use Userstory\Yii2Dto\traits\WithIdListTrait;

/**
 * Класс результата, основанный на списке ИД.
 */
class IdListResult extends BaseResult implements IdListResultInterface
{
    use WithIdListTrait;
}
