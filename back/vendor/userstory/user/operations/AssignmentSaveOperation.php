<?php

namespace Userstory\User\operations;

use yii\base\Model;
use Userstory\User\entities\AuthAssignmentActiveRecord;
use yii;

/**
 * Класс для присвоения ролей пользователям.
 *
 * @package Userstory\User\models
 */
class AssignmentSaveOperation extends Model
{
    /**
     * Объект полномочия пользователя.
     *
     * @var AuthAssignmentActiveRecord|null
     */
    protected $assignmentAr;

    /**
     * Правила валидации для атрибутов.
     *
     * @return array
     */
    public function rules()
    {
        return [
            [
                'assignmentAr',
                'required',
                'message' => Yii::t('User.Errors', 'Entity not found', [
                    'defaultTranslation' => 'Сущность не найдена',
                ]),
            ],
        ];
    }

    /**
     * Загрузить модель диалога и сообщения данными из формы.
     *
     * @param array|null  $data     массив данных для сохранения.
     * @param null|string $formName название формы.
     *
     * @inherit
     *
     * @return boolean
     */
    public function load($data, $formName = null)
    {
        if (! $this->validate() || empty($data)) {
            return false;
        }

        $this->assignmentAr->setAttributes($data);

        return true;
    }

    /**
     * Основной метод для сохранения полномочия.
     *
     * @return null|AuthAssignmentActiveRecord
     */
    public function save()
    {
        if ($this->assignmentAr->save()) {
            return $this->assignmentAr;
        }

        $this->addErrors($this->assignmentAr->errors);

        return null;
    }

    /**
     * Получить значение атрибута.
     *
     * @return null|AuthAssignmentActiveRecord
     */
    public function getAssignmentAr()
    {
        return $this->assignmentAr;
    }

    /**
     * Установить значение атрибуту.
     *
     * @param null|AuthAssignmentActiveRecord $assignmentAr объект записи полномочия.
     *
     * @return void
     */
    public function setAssignmentAr($assignmentAr)
    {
        $this->assignmentAr = $assignmentAr;
    }
}
