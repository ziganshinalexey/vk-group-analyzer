<?php

declare(strict_types = 1);

namespace Userstory\Yii2Dto\interfaces\results;

use Userstory\Yii2Dto\interfaces\WithIdListInterface;

/**
 * Интерфейс результата для работы через список ИД.
 */
interface IdListResultInterface extends BaseResultInterface, WithIdListInterface
{

}
