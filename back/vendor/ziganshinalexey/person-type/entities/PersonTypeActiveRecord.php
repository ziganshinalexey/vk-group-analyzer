<?php

declare(strict_types = 1);

namespace Ziganshinalexey\PersonType\entities;

use Userstory\ComponentBase\traits\ModifierAwareTrait;
use yii;
use yii\db\ActiveRecord;
use Ziganshinalexey\PersonType\validators\personType\PersonTypeValidator;

/**
 * Модель данных сущности "Тип личности"
 * Не использовать сохранение модели через метод save() за пределами Save-операции пакета.
 * Желательно, вообще не использовать.
 *
 * @property int    $id   Идентификатор.
 * @property string $name Название.
 */
class PersonTypeActiveRecord extends ActiveRecord
{
    use ModifierAwareTrait;

    public const TRANSLATE_CATEGORY = 'Admin.PersonType.PersonType';

    /**
     * Возвращает подписи для атрибутов модели.
     *
     * @return array
     */
    public function attributeLabels(): array
    {
        return static::labels();
    }

    /**
     * Переопределенный метод возвращает список атрибутов..
     * Нужен для для корректной работы метода getAttributes.
     *
     * @return array
     */
    public function attributes(): array
    {
        return $this->scenarios()[$this->getScenario()];
    }

    /**
     * Возвращает список атрибутов AR, входящих в дефолтнй сценарий.
     *
     * @return array
     */
    public static function getDefaultScenarioFields(): array
    {
        return [
            'id',
            'name',
        ];
    }

    /**
     * Метод возвращает подписи для атрибутов модели.
     *
     * @return array
     */
    public static function labels(): array
    {
        return [
            'id'   => Yii::t(self::TRANSLATE_CATEGORY, 'field.id', 'Идентификатор'),
            'name' => Yii::t(self::TRANSLATE_CATEGORY, 'field.name', 'Название'),
        ];
    }

    /**
     * Данный метод возвращает массив, содержащий правила валидации атрибутов.
     *
     * @return array
     */
    public function rules(): array
    {
        return PersonTypeValidator::getRules();
    }

    /**
     * Переопределенный метод возвращает список сценариев с активными атрибутами.
     * Нужен для корректной работы метода load.
     *
     * @return array
     */
    public function scenarios(): array
    {
        return [
            self::SCENARIO_DEFAULT => static::getDefaultScenarioFields(),
        ];
    }

    /**
     * Данный метод возвращает имя связанной с моделью таблицы.
     *
     * @return string
     */
    public static function tableName(): string
    {
        return '{{%person_type}}';
    }
}
