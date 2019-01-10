<?php

namespace Userstory\UserAdmin\forms;

use Userstory\User\entities\UserAuthActiveRecord;
use yii;
use yii\db\Expression;
use yii\base\Exception;

/**
 * Class UserAuthForm.
 * Класс формы для управления аутентификационными данными пользователя.
 *
 * @property boolean $canChangeLogin
 * @property boolean $canChangePassword
 *
 * @package Userstory\UserAdmin\forms
 */
class UserAuthForm extends UserAuthActiveRecord
{
    /**
     * Свойство формы, сообщающая может ли пользователь сменить логин.
     *
     * @var boolean|null
     */
    protected $canChangeLogin;

    /**
     * Свойство формы, сообщающая может ли пользователь изменить пароль.
     *
     * @var boolean|null
     */
    protected $canChangePassword;

    /**
     * Метод возвращает может ли пользователь сменить логин.
     *
     * @return boolean
     */
    public function getCanChangeLogin()
    {
        return $this->canChangeLogin;
    }

    /**
     * Метод задает может ли пользователь сменить логин.
     *
     * @param boolean $canChangeLogin Значение для установки.
     *
     * @return static
     */
    public function setCanChangeLogin($canChangeLogin)
    {
        $this->canChangeLogin = $canChangeLogin;
        return $this;
    }

    /**
     * Метод возвращает может ли пользователь изменить пароль.
     *
     * @return boolean
     */
    public function getCanChangePassword()
    {
        return $this->canChangePassword;
    }

    /**
     * Метод задает может ли пользователь изменить пароль.
     *
     * @param boolean $canChangePassword Значение для установки.
     *
     * @return static
     */
    public function setCanChangePassword($canChangePassword)
    {
        $this->canChangePassword = $canChangePassword;
        return $this;
    }

    /**
     * Метод класс, определяющий правила валидации формы.
     *
     * @return array
     */
    public function rules()
    {
        return array_merge(parent::rules(), [
            [
                ['login'],
                'required',
            ],
            [
                ['login'],
                'validateLoginUnique',
            ],
            [
                ['password'],
                'string',
                'min' => 6,
                'max' => 255,
            ],
        ]);
    }

    /**
     * Метод проверки уникальности указанного логина.
     *
     * @param string $attribute проверяемый атрибут.
     *
     * @return boolean
     */
    public function validateLoginUnique($attribute)
    {
        $condition = new Expression(sprintf('lower(%s) = :system', Yii::$app->getDb()->quoteColumnName('authSystem')));
        $query     = static::find()->andWhere($condition, ['system' => $this->authSystem]);
        $query     = $query->andWhere(new Expression('lower(login) = lower(:login)'), ['login' => $this->$attribute]);

        if (null !== $this->id) {
            $query->andWhere(new Expression('id <> :id'), ['id' => $this->id]);
        }

        $result = $query->exists();

        if ($result) {
            $this->addError($attribute, $attribute . ' is not unique');
            return false;
        }

        return true;
    }

    /**
     * Метод устанавливает хэш пароля, если пароль был указан.
     *
     * @param boolean $insert вставка или обновление.
     *
     * @throws Exception Исключение генерируется во внутренних вызовах.
     *
     * @return boolean
     */
    public function beforeSave($insert)
    {
        $result = parent::beforeSave($insert);

        if (! $result) {
            return $result;
        }

        if (! empty($this->password)) {
            $this->passwordHash = Yii::$app->security->generatePasswordHash($this->password);
        }

        return $result;
    }
}
