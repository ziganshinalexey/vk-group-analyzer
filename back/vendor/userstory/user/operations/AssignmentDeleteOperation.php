<?php

namespace Userstory\User\operations;

use yii\base\Model;
use Userstory\User\entities\AuthAssignmentActiveRecord;

/**
 * Класс занимается удалением полномочий.
 *
 * @package Userstory\User\models
 */
class AssignmentDeleteOperation extends Model
{
    /**
     * Объект полномочия пользователя.
     *
     * @var AuthAssignmentActiveRecord|null
     */
    protected $assignmentAr;

    /**
     * Метод для удаления сущности полномочия.
     *
     * @return boolean
     */
    public function delete()
    {
        if (null === $this->assignmentAr) {
            return true;
        }

        return (bool)$this->assignmentAr->delete();
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
