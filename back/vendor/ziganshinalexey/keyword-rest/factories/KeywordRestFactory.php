<?php

declare(strict_types = 1);

namespace Ziganshinalexey\KeywordRest\factories;

use Userstory\ComponentBase\models\ModelsFactory;
use Userstory\ComponentHydrator\interfaces\HydratorInterface;
use Userstory\Yii2Forms\interfaces\rest\CreateFormInterface;
use Userstory\Yii2Forms\interfaces\rest\DeleteFormInterface;
use Userstory\Yii2Forms\interfaces\rest\UpdateFormInterface;
use Userstory\Yii2Forms\interfaces\rest\ViewFormInterface;
use Userstory\Yii2Forms\validators\rest\AbstractFilterValidator;
use yii\base\InvalidConfigException;
use Ziganshinalexey\Keyword\interfaces\keyword\dto\KeywordInterface;
use Ziganshinalexey\Keyword\interfaces\keyword\filters\MultiFilterInterface;
use Ziganshinalexey\Keyword\traits\keyword\KeywordComponentTrait;
use Ziganshinalexey\KeywordRest\interfaces\keyword\FactoryInterface;
use Ziganshinalexey\KeywordRest\interfaces\keyword\ListFormInterface;

/**
 * Фабрика. Реализует породждение моделей пакета для работы с сущностью "Ключевое фраза".
 */
class KeywordRestFactory extends ModelsFactory implements FactoryInterface
{
    use KeywordComponentTrait;

    public const KEYWORD_CREATE_FORM      = 'keywordCreateForm';
    public const KEYWORD_DELETE_FORM      = 'keywordDeleteForm';
    public const KEYWORD_LIST_FORM        = 'keywordListForm';
    public const KEYWORD_UPDATE_FORM      = 'keywordUpdateForm';
    public const KEYWORD_VIEW_FORM        = 'keywordViewForm';
    public const KEYWORD_FILTER           = 'keywordFilter';
    public const KEYWORD_FILTER_HYDRATOR  = 'keywordFilterHydrator';
    public const KEYWORD_FILTER_VALIDATOR = 'keywordFilterValidator';
    public const KEYWORD_HYDRATOR         = 'keywordHydrator';
    public const KEYWORD_PROTOTYPE        = 'keywordPrototype';

    /**
     * Метод возвращает форму создания сущности "Ключевое фраза".
     *
     * @throws InvalidConfigException Исключение генерируется в случае проблем при создании объекта-модели.
     *
     * @return CreateFormInterface
     */
    public function getKeywordCreateForm(): CreateFormInterface
    {
        return  $this->getModelInstance(self::KEYWORD_CREATE_FORM, [], false)
                     ->setPrototype($this->getPrototype())
                     ->setHydrator($this->getKeywordHydrator());
    }

    /**
     * Метод возвращает форму удаления сущности "Ключевое фраза".
     *
     * @throws InvalidConfigException Исключение генерируется в случае проблем при создании объекта-модели.
     *
     * @return DeleteFormInterface
     */
    public function getKeywordDeleteForm(): DeleteFormInterface
    {
        return $this->getModelInstance(self::KEYWORD_DELETE_FORM, [], false);
    }

    /**
     * Метод возвращает форму фильтра списка "Ключевое фраза".
     *
     * @throws InvalidConfigException Исключение генерируется в случае проблем при создании объекта-модели.
     *
     * @return MultiFilterInterface
     */
    public function getKeywordFilter(): MultiFilterInterface
    {
        return $this->getModelInstance(self::KEYWORD_FILTER, [], false);
    }

    /**
     * Метод возвращает гидратор фильтра списка "Ключевое фраза".
     *
     * @throws InvalidConfigException Исключение генерируется в случае проблем при создании объекта-модели.
     *
     * @return HydratorInterface
     */
    public function getKeywordFilterHydrator(): HydratorInterface
    {
        return $this->getModelInstance(self::KEYWORD_FILTER_HYDRATOR, [], false);
    }

    /**
     * Метод возвращает валидатор фильтра сущности "Ключевое фраза".
     *
     * @throws InvalidConfigException Исключение генерируется в случае проблем при создании объекта-модели.
     *
     * @return AbstractFilterValidator
     */
    protected function getKeywordFilterValidator(): AbstractFilterValidator
    {
        return $this->getModelInstance(self::KEYWORD_FILTER_VALIDATOR, [], false);
    }

    /**
     * Метод возвращает гидратор для сущности "Ключевое фраза".
     *
     * @throws InvalidConfigException Исключение генерируется в случае проблем при создании объекта-модели.
     *
     * @return HydratorInterface
     */
    public function getKeywordHydrator(): HydratorInterface
    {
        return $this->getModelInstance(self::KEYWORD_HYDRATOR, [], false);
    }

    /**
     * Метод возвращает форму просмотра списка "Ключевое фраза".
     *
     * @throws InvalidConfigException Исключение генерируется в случае проблем при создании объекта-модели.
     *
     * @return ListFormInterface
     */
    public function getKeywordListForm(): ListFormInterface
    {
        return $this->getModelInstance(self::KEYWORD_LIST_FORM, [], false)
                    ->setFilter($this->getKeywordFilter())
                    ->setFilterValidator($this->getKeywordFilterValidator());
    }

    /**
     * Метод возвращает форму редактирования сущности "Ключевое фраза".
     *
     * @throws InvalidConfigException Исключение генерируется в случае проблем при создании объекта-модели.
     *
     * @return UpdateFormInterface
     */
    public function getKeywordUpdateForm(): UpdateFormInterface
    {
        return $this->getModelInstance(self::KEYWORD_UPDATE_FORM, [], false)
                    ->setPrototype($this->getPrototype())
                    ->setHydrator($this->getKeywordHydrator());
    }

    /**
     * Метод возвращает форму просмотра одной сущности "Ключевое фраза".
     *
     * @throws InvalidConfigException Исключение генерируется в случае проблем при создании объекта-модели.
     *
     * @return ViewFormInterface
     */
    public function getKeywordViewForm(): ViewFormInterface
    {
        return $this->getModelInstance(self::KEYWORD_VIEW_FORM, [], false);
    }

    /**
     * Метод возвращает объект прототипа сущности "Ключевое фраза".
     *
     * @throws InvalidConfigException Исключение генерируется в случае проблем при создании объекта-модели.
     *
     * @return KeywordInterface
     */
    protected function getPrototype(): KeywordInterface
    {
        return $this->getModelInstance(self::KEYWORD_PROTOTYPE, [], false);
    }
}
