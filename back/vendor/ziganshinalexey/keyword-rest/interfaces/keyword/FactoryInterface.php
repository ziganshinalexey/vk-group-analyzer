<?php

declare(strict_types = 1);

namespace Ziganshinalexey\KeywordRest\interfaces\keyword;

use Userstory\ComponentHydrator\interfaces\HydratorInterface;
use Userstory\Yii2Forms\interfaces\rest\CreateFormInterface;
use Userstory\Yii2Forms\interfaces\rest\DeleteFormInterface;
use Userstory\Yii2Forms\interfaces\rest\UpdateFormInterface;
use Userstory\Yii2Forms\interfaces\rest\ViewFormInterface;
use Ziganshinalexey\Keyword\interfaces\keyword\filters\MultiFilterInterface;

/**
 * Интерфейс фабрики. Опеределяет методы порождения моделей пакета.
 */
interface FactoryInterface
{
    /**
     * Метод возвращает интерфейс формы создания сущности "Ключевое фраза".
     *
     * @return CreateFormInterface
     */
    public function getKeywordCreateForm(): CreateFormInterface;

    /**
     * Метод возвращает интерфейс формы удаления сущностей "Ключевое фраза".
     *
     * @return DeleteFormInterface
     */
    public function getKeywordDeleteForm(): DeleteFormInterface;

    /**
     * Метод возвращает форму фильтра списка сущностей "Ключевое фраза".
     *
     * @return MultiFilterInterface
     */
    public function getKeywordFilter(): MultiFilterInterface;

    /**
     * Метод возвращает гидратор фильтра сущности "Ключевое фраза".
     *
     * @return HydratorInterface
     */
    public function getKeywordFilterHydrator(): HydratorInterface;

    /**
     * Метод возвращает гидратор для сущности "Ключевое фраза".
     *
     * @return HydratorInterface
     */
    public function getKeywordHydrator(): HydratorInterface;

    /**
     * Метод возвращает интерфейс формы для поиска списка сущностей "Ключевое фраза".
     *
     * @return ListFormInterface
     */
    public function getKeywordListForm(): ListFormInterface;

    /**
     * Метод возвращает интерфейс формы обновления сущности "Ключевое фраза".
     *
     * @return UpdateFormInterface
     */
    public function getKeywordUpdateForm(): UpdateFormInterface;

    /**
     * Метод возвращает интерфейс формы для просмотра одной сущности "Ключевое фраза".
     *
     * @return ViewFormInterface
     */
    public function getKeywordViewForm(): ViewFormInterface;
}
