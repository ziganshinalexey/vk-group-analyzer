<?php

declare(strict_types = 1);

namespace Ziganshinalexey\Yii2VkApi\entities;

use Userstory\ComponentBase\traits\ModifierAwareTrait;
use yii;
use yii\db\ActiveRecord;
use Ziganshinalexey\Yii2VkApi\validators\user\UserValidator;

/**
 * Модель данных сущности "ВК пользователь"
 * Не использовать сохранение модели через метод save() за пределами Save-операции пакета.
 * Желательно, вообще не использовать.
 *
 * @property string $facultyName    Факультет.
 * @property string $firstName      Имя.
 * @property int    $id             Идентификатор.
 * @property string $lastName       Фамилия.
 * @property string $photo          Факультет.
 * @property string $universityName Университет.
 */
class UserActiveRecord extends ActiveRecord
{
    use ModifierAwareTrait;

    public const TRANSLATE_CATEGORY = 'Admin.Yii2VkApi.User';

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
            'firstName',
            'lastName',
            'universityName',
            'facultyName',
            'photo',
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
            'id'             => Yii::t(self::TRANSLATE_CATEGORY, 'field.id', 'Идентификатор'),
            'firstName'      => Yii::t(self::TRANSLATE_CATEGORY, 'field.firstName', 'Имя'),
            'lastName'       => Yii::t(self::TRANSLATE_CATEGORY, 'field.lastName', 'Фамилия'),
            'universityName' => Yii::t(self::TRANSLATE_CATEGORY, 'field.universityName', 'Университет'),
            'facultyName'    => Yii::t(self::TRANSLATE_CATEGORY, 'field.facultyName', 'Факультет'),
            'photo'          => Yii::t(self::TRANSLATE_CATEGORY, 'field.photo', 'Факультет'),
        ];
    }

    /**
     * Данный метод возвращает массив, содержащий правила валидации атрибутов.
     *
     * @return array
     */
    public function rules(): array
    {
        return UserValidator::getRules();
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
        return '{{%users}}';
    }
}
