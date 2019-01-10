<?php

declare(strict_types = 1);

namespace Ziganshinalexey\Keyword\entities;

use Userstory\ComponentBase\traits\ModifierAwareTrait;
use yii;
use yii\db\ActiveRecord;
use Ziganshinalexey\Keyword\validators\keyword\KeywordValidator;

/**
 * Модель данных сущности "Ключевое фраза"
 * Не использовать сохранение модели через метод save() за пределами Save-операции пакета.
 * Желательно, вообще не использовать.
 *
 * @property int    $id           Идентификатор.
 * @property int    $personTypeId Идентификатор типа личности.
 * @property string $text         Название.
 */
class KeywordActiveRecord extends ActiveRecord
{
    use ModifierAwareTrait;

    public const TRANSLATE_CATEGORY = 'Admin.Keyword.Keyword';

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
            'text',
            'personTypeId',
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
            'id'           => Yii::t(self::TRANSLATE_CATEGORY, 'field.id', 'Идентификатор'),
            'text'         => Yii::t(self::TRANSLATE_CATEGORY, 'field.text', 'Название'),
            'personTypeId' => Yii::t(self::TRANSLATE_CATEGORY, 'field.personTypeId', 'Идентификатор типа личности'),
        ];
    }

    /**
     * Данный метод возвращает массив, содержащий правила валидации атрибутов.
     *
     * @return array
     */
    public function rules(): array
    {
        return KeywordValidator::getRules();
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
        return '{{%keyword}}';
    }
}
