<?php

namespace Userstory\CompetingView\entities;

use yii\db\ActiveRecord;

/**
 * Модель записи о конкурентном просмотре.
 *
 * @property integer $id         Идентфикатор записи
 * @property integer $entityName Имя сущности
 * @property integer $entityId   Идентификатор сущности
 * @property integer $userId     Идентификатор пользователя
 * @property integer $viewDate   Время просмотра
 *
 * @package Userstory\CompetingView\entities
 */
class CompetingView extends ActiveRecord
{
    /**
     * Метод возвращает имя таблицы в БД, соответствующий этой модели.
     *
     * @return string
     */
    public static function tableName()
    {
        return '{{%competing_view}}';
    }

    /**
     * Правила проверки для атрибутов этой модели.
     *
     * @return array
     */
    public function rules()
    {
        return [
            [
                [
                    'entityName',
                    'viewDate',
                ],
                'required',
            ],
        ];
    }
}
