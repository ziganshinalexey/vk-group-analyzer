<?php

declare(strict_types = 1);

namespace Ziganshinalexey\KeywordAdmin\interfaces\keyword;

use Ziganshinalexey\KeywordAdmin\forms\keyword\CreateForm;
use Ziganshinalexey\KeywordAdmin\forms\keyword\DeleteForm;
use Ziganshinalexey\KeywordAdmin\forms\keyword\FindForm;
use Ziganshinalexey\KeywordAdmin\forms\keyword\UpdateForm;
use Ziganshinalexey\KeywordAdmin\forms\keyword\ViewForm;

/**
 * Интерфейс фабрики. Опеределяет методы порождения моделей пакета.
 */
interface FactoryInterface
{
    /**
     * Метод возвращает форму для создания сущности "Ключевое фраза".
     *
     * @return CreateForm
     */
    public function getCreateForm(): CreateForm;

    /**
     * Метод возвращает форму для удаления данных сущности "Ключевое фраза".
     *
     * @return DeleteForm
     */
    public function getDeleteForm(): DeleteForm;

    /**
     * Метод возвращает форму для поиска данных сущности "Ключевое фраза".
     *
     * @return FindForm
     */
    public function getFindForm(): FindForm;

    /**
     * Метод возвращает форму для обновления данных сущности "Ключевое фраза".
     *
     * @return UpdateForm
     */
    public function getUpdateForm(): UpdateForm;

    /**
     * Метод возвращает форму для просмотра одного экземпляра сущности "Ключевое фраза".
     *
     * @return ViewForm
     */
    public function getViewForm(): ViewForm;
}
