<?php

declare(strict_types = 1);

namespace Userstory\Yii2Dto\interfaces\results;

use Userstory\Yii2Dto\interfaces\WithIdInterface;

/**
 * Интерфейс результата для работы через ИД.
 */
interface IdResultInterface extends BaseResultInterface, WithIdInterface
{

}
