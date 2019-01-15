<?php

declare(strict_types = 1);

namespace Userstory\Yii2Dto\dataTransferObjects\results;

use Userstory\Yii2Dto\interfaces\results\BaseResultInterface;
use Userstory\Yii2Errors\traits\errors\WithErrorsTrait;
use yii\base\InvalidConfigException;
use function DeepCopy\deep_copy;

/**
 * Базовый класс результата.
 */
class BaseResult implements BaseResultInterface
{
    use WithErrorsTrait;

    /**
     * Метод проверяет является ли результат успешным.
     *
     * @return bool
     *
     * @throws InvalidConfigException Исключение генерируется в случае неверной конфигурации подсистемы ошибок.
     */
    public function isSuccess(): bool
    {
        return ! $this->hasUSErrors();
    }

    /**
     * Метод возвращает копию текущего обхекта.
     *
     * @return static
     */
    public function copy()
    {
        return deep_copy($this);
    }
}
