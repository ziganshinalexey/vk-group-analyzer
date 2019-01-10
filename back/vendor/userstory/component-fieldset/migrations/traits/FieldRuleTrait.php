<?php

namespace Userstory\ComponentFieldset\migrations\traits;

/**
 * Trait FieldRuleTrait
 * Трэйт для миграции для получения правил валидации полей филдсета.
 *
 * @package Userstory\ComponentFieldset\migrations\traits
 */
trait FieldRuleTrait
{
    /**
     * Возвращает правило для фильтрации целых чисел.
     *
     * @return string
     */
    public function getIntFilterRule()
    {
        return [
            [
                'filter',
                'filter' => 'intval',
            ],
        ];
    }

    /**
     * Возвращает сериализованное правило safe.
     *
     * @return string
     */
    public function getSafeRule()
    {
        return [
            ['safe'],
        ];
    }

    /**
     * Возвращает правило для значения по умолчанию.
     *
     * @param mixed $value значение по умолчанию.
     *
     * @return string
     */
    public function getDefaultRule($value)
    {
        return [
            [
                'default',
                'value' => $value,
            ],
        ];
    }

    /**
     * Сериализует данные для сохранения правил в базу.
     *
     * @param mixed $value данные для кодирования.
     *
     * @return string
     */
    public function encode($value)
    {
        return json_encode($value, JSON_BIGINT_AS_STRING | JSON_UNESCAPED_UNICODE);
    }
}
