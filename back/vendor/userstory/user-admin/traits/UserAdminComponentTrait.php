<?php

namespace Userstory\UserAdmin\traits;

use Userstory\UserAdmin\components\UserAdminComponent;
use yii;

/**
 * Trait UserAdminComponentTrait.
 * Трейт, содержащий логику доступа к компоненту сущности.
 *
 * @package Userstory\UserAdmin\traits
 */
trait UserAdminComponentTrait
{
    /**
     * Объект компонента админки.
     *
     * @var UserAdminComponent|null
     */
    protected $userAdminComponent;

    /**
     * Метод возвращает объект компонента.
     *
     * @return UserAdminComponent
     */
    protected function getUserAdminComponent()
    {
        if (! $this->userAdminComponent) {
            $this->userAdminComponent = Yii::$app->get('userAdmin');
        }

        return $this->userAdminComponent;
    }
}
