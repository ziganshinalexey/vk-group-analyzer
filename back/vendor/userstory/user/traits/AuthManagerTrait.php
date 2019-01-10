<?php

namespace vendor\userstory\user\traits;

use Userstory\User\components\AuthorizationComponent;
use yii;
use yii\base\InvalidConfigException;

/**
 * Трейт AuthManagerTrait.
 * Трейт для работы с менеджеров авторизации.
 *
 * @package vendor\userstory\user\traits
 */
trait AuthManagerTrait
{
    /**
     * Объект менеджера авторизации.
     *
     * @var AuthorizationComponent|null
     */
    protected $authManager;

    /**
     * Метод получает менеджер авторизации.
     *
     * @return AuthorizationComponent
     *
     * @throws InvalidConfigException Исключение генерируется в случае неверной конфигурации менеджера авторизации.
     */
    public function getAuthManager()
    {
        if (! $this->authManager) {
            $this->authManager = Yii::$app->authManager;
            if (! $this->authManager instanceof AuthorizationComponent) {
                throw new InvalidConfigException(get_class($this->authManager) . ' must be extends from ' . AuthorizationComponent::class);
            }
        }
        return $this->authManager;
    }
}
