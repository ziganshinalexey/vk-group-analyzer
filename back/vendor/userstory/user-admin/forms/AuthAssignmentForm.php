<?php

namespace Userstory\UserAdmin\forms;

use Userstory\User\entities\AuthAssignmentActiveRecord as AuthAssignment;

/**
 * Class AuthAssignmentForm.
 * Класс формы назначения для назначения роли пользователю.
 *
 * @package Userstory\UserAdmin\forms
 */
class AuthAssignmentForm extends AuthAssignment
{
    /**
     * Метод возвращает правила валидации.
     *
     * @return array
     */
    public function rules()
    {
        return [
            [
                ['isActive'],
                'required',
            ],
            [
                ['isActive'],
                'boolean',
            ],
        ];
    }
}
