<?php

declare(strict_types = 1);

namespace Ziganshinalexey\PersonTypeRest\interfaces\personType;

use Userstory\Yii2Forms\interfaces\rest\ListFormInterface as BaseListFormInterface;
use Ziganshinalexey\PersonType\interfaces\personType\filters\MultiFilterInterface;

/**
 * Интерфейс фабрики. Опеределяет методы порождения моделей пакета.
 */
interface ListFormInterface extends BaseListFormInterface
{
    /**
     * Метод возвращает объект фильтра для формы выборки сущности "Тип личности".
     *
     * @return MultiFilterInterface
     */
    public function getFilter(): MultiFilterInterface;
}
