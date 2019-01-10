<?php

namespace Userstory\User\models;

use Userstory\User\interfaces\AdapterInterface;
use yii\base\BaseObject;

/**
 * Class AbstractAdapterModel.
 * Абстрактный класс для реализации адаптера аутентификации.
 *
 * @package Userstory\User\models
 */
abstract class AbstractAdapterModel extends BaseObject implements AdapterInterface
{
    /**
     * Свойство, хранящее логин пользователя.
     *
     * @var string|null
     */
    protected $identity;

    /**
     * Свойства, хранящее пароль пользователя.
     *
     * @var string|null
     */
    protected $credential;

    /**
     * Получение установленного пароля пользователя.
     *
     * @return string
     */
    public function getCredential()
    {
        return $this->credential;
    }

    /**
     * Устанавливает пароль пользователя.
     *
     * @param string $credential устанавливаемый пароль.
     *
     * @return static
     */
    public function setCredential($credential)
    {
        $this->credential = $credential;
        return $this;
    }

    /**
     * Получение установленного логина пользователя.
     *
     * @return string
     */
    public function getIdentity()
    {
        return $this->identity;
    }

    /**
     * Устанавливает логин пользователя.
     *
     * @param string $identity устанавливаемый логин.
     *
     * @return static
     */
    public function setIdentity($identity)
    {
        $this->identity = $identity;
        return $this;
    }
}
