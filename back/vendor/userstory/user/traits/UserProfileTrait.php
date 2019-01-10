<?php

namespace Userstory\User\traits;

use Userstory\User\components\UserProfileComponent;
use yii;
use yii\base\InvalidConfigException;

/**
 * Трейт UserProfileTrait.
 * Трейт для доступа к компоненту профиля пользователя.
 *
 * @package vendor\userstory\user\traits
 */
trait UserProfileTrait
{
    /**
     * Объект компонента профиля пользователя.
     *
     * @var UserProfileComponent|null
     */
    protected $userProfileComponent;

    /**
     * Метод возвращает объект компонента профиля пользователя.
     *
     * @return UserProfileComponent
     *
     * @throws InvalidConfigException Исключение генерируется в случае неверной конфигурации менеджера авторизации.
     */
    public function getUserProfileComponent()
    {
        if (! $this->userProfileComponent) {
            $this->userProfileComponent = Yii::$app->userProfile;
            if (! $this->userProfileComponent instanceof UserProfileComponent) {
                throw new InvalidConfigException(get_class($this->userProfileComponent) . ' must be extends from ' . UserProfileComponent::class);
            }
        }
        return $this->userProfileComponent;
    }
}
