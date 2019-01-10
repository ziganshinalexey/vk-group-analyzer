<?php

declare(strict_types = 1);

namespace Ziganshinalexey\KeywordAdmin\interfaces\keyword;

use Ziganshinalexey\KeywordAdmin\forms\keyword\CreateForm;
use Ziganshinalexey\KeywordAdmin\forms\keyword\DeleteForm;
use Ziganshinalexey\KeywordAdmin\forms\keyword\FindForm;
use Ziganshinalexey\KeywordAdmin\forms\keyword\UpdateForm;
use Ziganshinalexey\KeywordAdmin\forms\keyword\ViewForm;

/**
 * Интерфейс компонента для работы с админкой сущностей "Ключевое фраза".
 */
interface AdminComponentInterface
{
    /**
     * Метод возвращает форму создания экземпляров сущности "Ключевое фраза".
     *
     * @return CreateForm
     */
    public function create(): CreateForm;

    /**
     * Метод возвращает форму удаления экземпляра сущности "Ключевое фраза".
     *
     * @return DeleteForm
     */
    public function delete(): DeleteForm;

    /**
     * Метод возвращает форму поиска экземпляров сущности "Ключевое фраза".
     *
     * @return FindForm
     */
    public function find(): FindForm;

    /**
     * Метод возвращает форму обновления экземпляра сущности "Ключевое фраза".
     *
     * @return UpdateForm
     */
    public function update(): UpdateForm;

    /**
     * Метод возвращает прототип админской модели "Ключевое фраза".
     *
     * @return ViewForm
     */
    public function view(): ViewForm;
}
