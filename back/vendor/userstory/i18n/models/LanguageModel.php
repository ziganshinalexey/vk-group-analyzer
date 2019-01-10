<?php

namespace Userstory\I18n\models;

use Userstory\ComponentBase\models\Model;
use Userstory\I18n\interfaces\LanguageInterface;
use yii;

/**
 * Класс LanguageModel реализует модель хранения данных о языке.
 * Сохранение модели должно осуществлятся только через компонент i18n.
 * Сохранение LanguageActiveRecord::save() может привести к нарушению целостности данных.
 *
 * @package Userstory\I18n\models
 */
class LanguageModel extends Model implements LanguageInterface
{
    /**
     * Свойство хранит идентификатор языка.
     *
     * @var integer|null
     */
    protected $id;

    /**
     * Свойство хранит код языка.
     *
     * @var string|null
     */
    protected $code;

    /**
     * Свойство хранит название языка.
     *
     * @var string|null
     */
    protected $name;

    /**
     * Свойство хранит флаг языка по-умолчанию.
     *
     * @var boolean|null
     */
    protected $isDefault;

    /**
     * Свойство хранит флаг активности языка.
     *
     * @var boolean|null
     */
    protected $isActive;

    /**
     * Свойство хранит урл языка.
     *
     * @var string|null
     */
    protected $url;

    /**
     * Свойство хранит название изображения языка.
     *
     * @var string|null
     */
    protected $icon;

    /**
     * Свойство хранит локаль языка.
     *
     * @var string|null
     */
    protected $locale;

    /**
     * Свойство хранит флаг новой записи.
     *
     * @var string|null
     */
    protected $isNewRecord;

    /**
     * Метод задает идентификатор языка.
     *
     * @param integer $value Новое значение.
     *
     * @return void
     */
    public function setId($value)
    {
        $this->id = $value;
    }

    /**
     * Метод возвращает идентификатор языка.
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Метод задает название кода языка.
     *
     * @param string $value Новое значение.
     *
     * @return void
     */
    public function setCode($value)
    {
        $this->code = $value;
    }

    /**
     * Метод возвращает код языка.
     *
     * @return string
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * Метод задает название языка.
     *
     * @param string $value Новое значение.
     *
     * @return void
     */
    public function setName($value)
    {
        $this->name = $value;
    }

    /**
     * Метод возвращает название языка.
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Метод задает флаг языка по-умолчанию.
     *
     * @param boolean $value Новое значение.
     *
     * @return void
     */
    public function setIsDefault($value)
    {
        $this->isDefault = $value;
    }

    /**
     * Метод возвращает флаг языка по-умолчанию.
     *
     * @return boolean
     */
    public function getIsDefault()
    {
        return $this->isDefault;
    }

    /**
     * Метод задает флаг активности языка.
     *
     * @param boolean $value Новое значение.
     *
     * @return void
     */
    public function setIsActive($value)
    {
        $this->isActive = $value;
    }

    /**
     * Метод возвращает флаг активности языка.
     *
     * @return boolean
     */
    public function getIsActive()
    {
        return $this->isActive;
    }

    /**
     * Метод задает название урла языка.
     *
     * @param string $value Новое значение.
     *
     * @return void
     */
    public function setUrl($value)
    {
        $this->url = $value;
    }

    /**
     * Метод возвращает урл языка.
     *
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * Метод задает название изображения языка.
     *
     * @param string $value Новое значение.
     *
     * @return void
     */
    public function setIcon($value)
    {
        $this->icon = $value;
    }

    /**
     * Метод возвращает название изображения языка.
     *
     * @return string
     */
    public function getIcon()
    {
        return $this->icon;
    }

    /**
     * Метод задает локаль языка.
     *
     * @param string $value Новое значение.
     *
     * @return void
     */
    public function setLocale($value)
    {
        $this->locale = $value;
    }

    /**
     * Метод возвращает локаль языка.
     *
     * @return string
     */
    public function getLocale()
    {
        return $this->locale;
    }

    /**
     * Метод задает флаг новой записи.
     *
     * @param boolean $value Новое значение.
     *
     * @return void
     */
    public function setIsNewRecord($value)
    {
        $this->isNewRecord = $value;
    }

    /**
     * Метод возвращает флаг новой записи.
     *
     * @return boolean
     */
    public function getIsNewRecord()
    {
        if (null === $this->isNewRecord) {
            return true;
        }
        return $this->isNewRecord;
    }

    /**
     * Переопределенный метод возвращает список сценариев с активными атрибутами (Нужно для метода load).
     *
     * @return array
     */
    public function scenarios()
    {
        return [
            self::SCENARIO_DEFAULT => [
                'id',
                'code',
                'name',
                'isDefault',
                'isActive',
                'url',
                'icon',
                'locale',
            ],
        ];
    }

    /**
     * Переопределенный метод возвращает список атрибутов для модели (Нужно для метода getAttributes).
     *
     * @return array
     */
    public function attributes()
    {
        return $this->scenarios()[$this->getScenario()];
    }

    /**
     * Переопределенный метод возвращает список подписей атрибутов.
     *
     * @return array
     */
    public function attributeLabels()
    {
        return static::labels();
    }

    /**
     * Метод возвращает подписи для атрибутов модели.
     *
     * @return array
     */
    public static function labels()
    {
        return [
            'id'        => Yii::t('Admin.I18N.Language', 'Language ID', 'Id'),
            'code'      => Yii::t('Admin.I18N.Language', 'Language code', 'Code'),
            'name'      => Yii::t('Admin.I18N.Language', 'Language name', 'Name'),
            'isDefault' => Yii::t('Admin.I18N.Language', 'default language', 'is Default'),
            'isActive'  => Yii::t('Admin.I18N.Language', 'published', 'is Active'),
            'url'       => Yii::t('Admin.I18N.Language', 'Url', 'Url'),
            'icon'      => Yii::t('Admin.I18N.Language', 'Icon', 'Icon'),
        ];
    }

    /**
     * Метод копирования объекта.
     *
     * @return LanguageInterface
     */
    public function copy()
    {
        return new static();
    }
}
