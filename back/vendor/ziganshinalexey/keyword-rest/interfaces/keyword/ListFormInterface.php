<?php

declare(strict_types = 1);

namespace Ziganshinalexey\KeywordRest\interfaces\keyword;

use Userstory\Yii2Forms\interfaces\rest\ListFormInterface as BaseListFormInterface;
use Ziganshinalexey\Keyword\interfaces\keyword\filters\MultiFilterInterface;

/**
 * Интерфейс фабрики. Опеределяет методы порождения моделей пакета.
 */
interface ListFormInterface extends BaseListFormInterface
{
    /**
     * Метод возвращает объект фильтра для формы выборки сущности "Ключевое фраза".
     *
     * @return MultiFilterInterface
     */
    public function getFilter(): MultiFilterInterface;
}
