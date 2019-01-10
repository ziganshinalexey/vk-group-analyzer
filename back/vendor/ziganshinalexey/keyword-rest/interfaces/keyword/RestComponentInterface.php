<?php

declare(strict_types = 1);

namespace Ziganshinalexey\KeywordRest\interfaces\keyword;

use Userstory\ComponentHydrator\interfaces\HydratorInterface;
use Userstory\Yii2Forms\interfaces\rest\CreateFormInterface;
use Userstory\Yii2Forms\interfaces\rest\DeleteFormInterface;
use Userstory\Yii2Forms\interfaces\rest\UpdateFormInterface;
use Userstory\Yii2Forms\interfaces\rest\ViewFormInterface;

/**
 * Интерфейс компонента для работы с сущностями "Ключевое фраза".
 */
interface RestComponentInterface
{
    /**
     * Метод возвращает интерфейс формы создания сущности "Ключевое фраза".
     *
     * @return CreateFormInterface
     */
    public function getCreateForm(): CreateFormInterface;

    /**
     * Метод возвращает интерфейс формы удаления сущности "Ключевое фраза".
     *
     * @return DeleteFormInterface
     */
    public function getDeleteForm(): DeleteFormInterface;

    /**
     * Метод возвращает интерефейс гидратора фильтра поиска сущности "Ключевое фраза".
     *
     * @return HydratorInterface
     */
    public function getFilterHydrator(): HydratorInterface;

    /**
     * Метод возвращает интерефейс операции поиска списка сущностей "Ключевое фраза".
     *
     * @return ListFormInterface
     */
    public function getListForm(): ListFormInterface;

    /**
     * Метод возвращает интерфейс формы редактирования сущности "Ключевое фраза".
     *
     * @return UpdateFormInterface
     */
    public function getUpdateForm(): UpdateFormInterface;

    /**
     * Метод возвращает интерефейс операции поиска одного экземпляра сущности "Ключевое фраза".
     *
     * @return ViewFormInterface
     */
    public function getViewForm(): ViewFormInterface;
}
