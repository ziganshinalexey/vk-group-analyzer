<?php

declare(strict_types = 1);

namespace Ziganshinalexey\KeywordAdmin\factories;

use Userstory\ComponentBase\models\ModelsFactory;
use yii\base\InvalidConfigException;
use Ziganshinalexey\KeywordAdmin\forms\keyword\CreateForm;
use Ziganshinalexey\KeywordAdmin\forms\keyword\DeleteForm;
use Ziganshinalexey\KeywordAdmin\forms\keyword\FindForm;
use Ziganshinalexey\KeywordAdmin\forms\keyword\UpdateForm;
use Ziganshinalexey\KeywordAdmin\forms\keyword\ViewForm;
use Ziganshinalexey\KeywordAdmin\interfaces\keyword\FactoryInterface;

/**
 * Фабрика. Реализует породждение моделей пакета для работы админки с сущностью "Ключевое фраза".
 */
class KeywordAdminFactory extends ModelsFactory implements FactoryInterface
{
    public const KEYWORD_VIEW_FORM   = 'keywordViewForm';
    public const KEYWORD_CREATE_FORM = 'keywordCreateForm';
    public const KEYWORD_UPDATE_FORM = 'keywordUpdateForm';
    public const KEYWORD_DELETE_FORM = 'keywordDeleteForm';
    public const KEYWORD_FIND_FORM   = 'keywordFindForm';

    /**
     * Метод возвращает форму для создания сущности "Ключевое фраза".
     *
     * @throws InvalidConfigException Исключение генерируется в случае проблем при создании объекта-модели.
     *
     * @return CreateForm
     */
    public function getCreateForm(): CreateForm
    {
        return $this->getModelInstance(self::KEYWORD_CREATE_FORM, [], false);
    }

    /**
     * Метод возвращает форму для удаления данных сущности "Ключевое фраза".
     *
     * @throws InvalidConfigException Исключение генерируется в случае проблем при создании объекта-модели.
     *
     * @return DeleteForm
     */
    public function getDeleteForm(): DeleteForm
    {
        return $this->getModelInstance(self::KEYWORD_DELETE_FORM, [], false);
    }

    /**
     * Метод возвращает форму для поиска данных сущности "Ключевое фраза".
     *
     * @throws InvalidConfigException Исключение генерируется в случае проблем при создании объекта-модели.
     *
     * @return FindForm
     */
    public function getFindForm(): FindForm
    {
        return $this->getModelInstance(self::KEYWORD_FIND_FORM, [], false);
    }

    /**
     * Метод возвращает форму для обновления данных сущности "Ключевое фраза".
     *
     * @throws InvalidConfigException Исключение генерируется в случае проблем при создании объекта-модели.
     *
     * @return UpdateForm
     */
    public function getUpdateForm(): UpdateForm
    {
        return $this->getModelInstance(self::KEYWORD_UPDATE_FORM, [], false);
    }

    /**
     * Метод возвращает форму для просмотра одного экземпляра сущности "Ключевое фраза".
     *
     * @throws InvalidConfigException Исключение генерируется в случае проблем при создании объекта-модели.
     *
     * @return ViewForm
     */
    public function getViewForm(): ViewForm
    {
        return $this->getModelInstance(self::KEYWORD_VIEW_FORM, [], false);
    }
}
