<?php

namespace Userstory\UserAdmin\forms;

use Userstory\User\models\LoginFormModel;
use yii;

/**
 * Class LoginForm.
 * Расширенный для админки класс формы логина и проверки аутентификации.
 *
 * @package Userstory\UserAdmin\forms
 */
class LoginForm extends LoginFormModel
{
    /**
     * Инициация процесса аутентификации.
     *
     * @return boolean
     */
    public function login()
    {
        if (! parent::login()) {
            return false;
        }

        if (! Yii::$app->user->can('User.Admin.Access')) {
            Yii::$app->user->logout();
            $this->addError('login', 'Access is denied');

            return false;
        }

        return true;
    }
}
