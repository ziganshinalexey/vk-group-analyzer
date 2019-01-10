<?php

declare( strict_types = 1 );

namespace Userstory\Yii2Forms\forms\rest;

use Userstory\ComponentBase\interfaces\AbstractFilterInterface;
use Userstory\Yii2Forms\interfaces\rest\ListFormInterface;
use Userstory\Yii2Forms\validators\rest\AbstractFilterValidator;
use yii\base\InvalidCallException;
use yii\base\InvalidConfigException;

/**
 * Абстрактной класс формы для просмотра списка DTO.
 */
abstract class AbstractListRestForm extends AbstractRestForm implements ListFormInterface
{
    /**
     * Свойство хранит объект фильтра для формы выборки.
     *
     * @var AbstractFilterInterface|null
     */
    protected $filter;

    /**
     * Свойство хранит объект валидатора для фильтра.
     *
     * @var AbstractFilterValidator|null
     */
    protected $filterValidator;

    /**
     * Свойство хранит флаг полноты записей в ответе.
     *
     * @var boolean|null
     */
    protected $more;

    /**
     * Метод возвращает флаг полноты записей в ответе.
     *
     * @return boolean
     *
     * @throws InvalidCallException Генерирует при преждевременном вызове метода.
     */
    public function getMore(): bool
    {
        if (null === $this->more) {
            throw new InvalidCallException(__METHOD__ . '() Метод необходимо вызывать после метода run().');
        }
        return (bool)$this->more;
    }

    /**
     * Метод задает объект фильтра для формы выборки.
     *
     * @param AbstractFilterInterface $value Новое значение.
     *
     * @return ListFormInterface
     */
    public function setFilter(AbstractFilterInterface $value): ListFormInterface
    {
        $this->filter = $value;
        return $this;
    }

    /**
     * Метод задает объект валидатора для фильтра.
     *
     * @param AbstractFilterValidator $value Новое значение.
     *
     * @return ListFormInterface
     */
    public function setFilterValidator(AbstractFilterValidator $value): ListFormInterface
    {
        $this->filterValidator = $value;
        return $this;
    }

    /**
     * Метод возвращает объект валидатора для фильтра.
     *
     * @return AbstractFilterValidator
     *
     * @throws InvalidConfigException Генерирует в случае неверной конфигурации класса.
     */
    protected function getFilterValidator(): AbstractFilterValidator
    {
        if (null === $this->filterValidator) {
            throw new InvalidConfigException(__METHOD__ . '() Валидатор для фильтра не задан.');
        }
        return $this->filterValidator;
    }

    /**
     * Метод возвращает объект ДТО для работы с формой.
     *
     * @return null
     */
    public function getPrototype()
    {
        return null;
    }

    /**
     * Метод возвращает объект фильтра для формы выборки.
     *
     * @return mixed
     *
     * @throws InvalidConfigException Генерирует в случае отсутствия фильта.
     */
    abstract public function getFilter();
}
