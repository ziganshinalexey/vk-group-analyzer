<?php

declare(strict_types = 1);

namespace Ziganshinalexey\Yii2VkApi\entities;

use Userstory\ComponentBase\traits\ModifierAwareTrait;
use yii;
use yii\db\ActiveRecord;
use Ziganshinalexey\Yii2VkApi\validators\group\GroupValidator;

/**
 * Модель данных сущности "ВК группа"
 * Не использовать сохранение модели через метод save() за пределами Save-операции пакета.
 * Желательно, вообще не использовать.
 *
 * @property string $activity    Название.
 * @property string $description Название.
 * @property int    $id          Идентификатор.
 * @property string $name        Название.
 */
class GroupActiveRecord extends ActiveRecord
{
    use ModifierAwareTrait;

    public const TRANSLATE_CATEGORY = 'Admin.Yii2VkApi.Group';

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
            'activity',
            'description',
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
            'id'          => Yii::t(self::TRANSLATE_CATEGORY, 'field.id', 'Идентификатор'),
            'name'        => Yii::t(self::TRANSLATE_CATEGORY, 'field.name', 'Название'),
            'activity'    => Yii::t(self::TRANSLATE_CATEGORY, 'field.activity', 'Название'),
            'description' => Yii::t(self::TRANSLATE_CATEGORY, 'field.description', 'Название'),
        ];
    }

    /**
     * Данный метод возвращает массив, содержащий правила валидации атрибутов.
     *
     * @return array
     */
    public function rules(): array
    {
        return GroupValidator::getRules();
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
        return '{{%group}}';
    }
}
