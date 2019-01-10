<?php

namespace Userstory\I18n\traits;

use Userstory\I18n\entities\LanguageActiveRecord;

/**
 * Трэит LanguageRelationTrait Для определения связи в АктивнойЗаписи (Валидатор не пустил норм название).
 *
 * @property LanguageActiveRecord $language Модель языка.
 *
 * @package Userstory\I18n\traits
 */
trait LanguageRelationTrait
{
    /**
     * Метод возвращает связанную модель языка.
     *
     * @param string $field Имя поля, по которому связаны сущности.
     *
     * @return LanguageActiveRecord
     */
    public function getLanguage($field = 'languageId')
    {
        return $this->hasOne(LanguageActiveRecord::class, ['id' => $field]);
    }
}
