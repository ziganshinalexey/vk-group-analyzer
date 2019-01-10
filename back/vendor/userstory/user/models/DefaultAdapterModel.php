<?php

namespace Userstory\User\models;

use Userstory\User\components\AuthenticationComponent;
use Userstory\User\entities\UserAuthActiveRecord;
use Userstory\User\traits\FactoryCommonTrait;
use yii;
use yii\base\InvalidConfigException;
use yii\base\InvalidParamException;

/**
 * Class DefaultAdapterModel.
 * Класс, реализующий внутресистемный адаптер аутентификации.
 *
 * @package Userstory\User\models
 */
class DefaultAdapterModel extends AbstractAdapterModel
{
    use FactoryCommonTrait;

    /**
     * Метод возвращает имя адаптера.
     *
     * @return string
     */
    public function getName()
    {
        return 'default';
    }

    /**
     * Метод проверяет, актуальна ли информация пользователя.
     *
     * @param UserAuthActiveRecord $user проверяемый пользователь.
     *
     * @inherit
     *
     * @return boolean
     */
    public function isActual(UserAuthActiveRecord $user)
    {
        return true;
    }

    /**
     * Метод осуществляет проверку аутентификации внутренними средствами.
     *
     * @throws InvalidParamException Генерируется если логин/пароль не верны.
     *
     * @throws InvalidConfigException Исключение генерируется во внутренних вызовах.
     *
     * @return ResultModel
     */
    public function authenticate()
    {
        $expression = $this->getExpression('lower(login) = lower(:login)');
        $userAuth   = UserAuthActiveRecord::find()->where(['authSystem' => 'default'])->andWhere($expression, ['login' => $this->identity])->one();

        if (! $userAuth instanceof UserAuthActiveRecord) {
            return $this->getResult([
                'code'     => ResultModel::FAILURE_IDENTITY_NOT_FOUND,
                'identity' => null,
                'messages' => [ResultModel::FAILURE_IDENTITY_NOT_FOUND => 'Identity not found'],
            ]);
        }

        /* @var AuthenticationComponent $authService */
        $authService = Yii::$app->authenticationService;

        if ($authService->validatePassword($this->credential, $userAuth->passwordHash)) {
            return $this->getResult([
                'code'     => ResultModel::SUCCESS,
                'identity' => $userAuth,
            ]);
        }

        return $this->getResult([
            'code'     => ResultModel::FAILURE_CREDENTIAL_INVALID,
            'identity' => null,
            'messages' => [ResultModel::FAILURE_CREDENTIAL_INVALID => 'Credential invalid.'],
        ]);
    }
}
