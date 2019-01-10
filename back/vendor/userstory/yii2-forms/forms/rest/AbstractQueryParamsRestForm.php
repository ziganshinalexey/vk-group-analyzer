<?php

declare( strict_types = 1 );

namespace Userstory\Yii2Forms\forms\rest;

use InvalidArgumentException;

/**
 * Абстрактной класс формы для REST форм.
 */
abstract class AbstractQueryParamsRestForm extends AbstractRestForm
{
    /**
     * Свойство хранит идентификатор записи.
     *
     * @var integer|null
     */
    protected $id;

    /**
     * Метод возвращает идентификатор записи.
     *
     * @return integer
     */
    public function getId(): int
    {
        if (empty($this->id)) {
            throw new InvalidArgumentException(__METHOD__ . '() Идентификатор не задан.');
        }
        return (int)$this->id;
    }

    /**
     * Переопределенный метод возвращает список правил для валидации.
     *
     * @return array
     */
    public function rules()
    {
        return [
            [
                'id',
                'required',
            ],
            [
                'id',
                'integer',
                'max' => 2147483647,
            ],
        ];
    }

    /**
     * Переопределенный метод нужен для корректной работы load.
     *
     * @return array
     */
    public function scenarios()
    {
        return [
            self::SCENARIO_DEFAULT => ['id'],
        ];
    }
}
