<?php

namespace Userstory\I18n\traits;

use Userstory\I18n\components\I18NComponent;
use yii;
use yii\base\InvalidConfigException;

/**
 * Трэит I18nComponentTrait является вспомогательным трэитом для конпонента.
 *
 * @package Userstory\I18n\traits
 */
trait I18nComponentTrait
{
    /**
     * Свойство хранит объект языкового компонента.
     *
     * @var I18NComponent|null
     */
    protected $i18nComponent;

    /**
     * Метод возвращает объект языкового компонента.
     *
     * @return I18NComponent
     *
     * @throws InvalidConfigException Выкидывает в случае неверной конфигурации.
     */
    public function getI18nComponent()
    {
        if (empty($this->i18nComponent)) {
            if (! Yii::$app->i18n instanceof I18NComponent) {
                throw new InvalidConfigException('Class of the returned object must implement the ' . I18NComponent::class);
            }
            $this->i18nComponent = Yii::$app->i18n;
        }
        return $this->i18nComponent;
    }
}
