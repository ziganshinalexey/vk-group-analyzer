<?php

namespace Userstory\I18n\operations;

use Userstory\I18n\traits\I18nComponentTrait;
use yii;
use yii\base\InvalidConfigException;

/**
 * Класс AbstractMessageExportOperation реализует методы экспорта в файл.
 *
 * @package Userstory\I18n\operations
 */
abstract class AbstractMessageExportOperation
{
    use I18nComponentTrait;

    /**
     * Метод возвращает подписи к колонкам.
     *
     * @return array
     */
    protected function getColumnLabels()
    {
        return [
            Yii::t('Admin.ModuleI18N', 'ConstantId', 'Constant Id'),
            Yii::t('Admin.ModuleI18N.SourceMessage', 'Category', 'Category'),
            Yii::t('Admin.ModuleI18N.SourceMessage', 'Comment', 'Comment'),
            Yii::t('Admin.ModuleI18N.SourceMessage', 'Message', 'Message'),
            Yii::t('Admin.ModuleI18N.Message', 'DefaultTranslation', 'Default language translation'),
            Yii::t('Admin.ModuleI18N.Message', 'Translation', 'Translation'),
        ];
    }

    /**
     * Метод возвращает контент для файла.
     *
     * @param integer $languageId Идентификатор требуемого языка.
     *
     * @return array
     *
     * @throws InvalidConfigException Генерирует при неверной конфигурации.
     */
    protected function getContent($languageId)
    {
        $constants = $this->getI18nComponent()->getModelFactory()->getSourceMessageGetter()->getAll();
        $defLangId = $this->getI18nComponent()->getDefaultLanguageId();

        $result = [];
        foreach ($constants as $constant) {
            $result[] = [
                $constant->getId(),
                $constant->getCategory(),
                $constant->getComment(),
                $constant->message,
                isset($constant->messages[$defLangId]) ? $constant->messages[$defLangId]->translation : '',
                isset($constant->messages[$languageId]) ? $constant->messages[$languageId]->translation : '',
            ];
        }
        return $result;
    }
}
