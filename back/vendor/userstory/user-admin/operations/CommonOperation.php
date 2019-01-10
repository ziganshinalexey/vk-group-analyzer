<?php

namespace Userstory\UserAdmin\operations;

use Userstory\ComponentHelpers\helpers\ArrayHelper;
use Userstory\User\components\AuthorizationComponent;
use Userstory\User\components\UserRoleComponent;
use Userstory\UserAdmin\forms\PermissionForm;
use Userstory\UserAdmin\traits\UserAdminComponentTrait;
use yii;
use yii\base\BaseObject;

/**
 * Class CommonOperation.
 * Класс операций для группирования общей логики работы с пользователями админки.
 *
 * @package Userstory\UserAdmin\operations
 */
class CommonOperation extends BaseObject
{
    use UserAdminComponentTrait;

    /**
     * Метод возвращает список разрешений для заданию роли.
     *
     * @param integer $roleId         Идентификатор роли.
     * @param boolean $isOnlyAssigned Включить ли в список только назначенные разрешения.
     *
     * @return array
     */
    public function getRolePermissions($roleId, $isOnlyAssigned)
    {
        $adminComponent = $this->getUserAdminComponent();
        $form           = $adminComponent->modelFactory->getPermissionForm();
        $models         = [];

        if ($roleId) {
            /* @var UserRoleComponent $roleComponent */
            $roleComponent     = Yii::$app->userRole;
            $query             = $roleComponent->rolePermissionQuery;
            $query->modelClass = $form::className();

            /* @var PermissionForm[] $models */
            $models = $query->byId($roleId)->indexBy('permission')->all();

            foreach ($models as $model) {
                $model->isAssigned = true;
            }
        }

        /* @var AuthorizationComponent $authManager */
        $authManager        = Yii::$app->authManager;
        $defaultPermissions = $authManager->permissionsList;

        foreach ($defaultPermissions as $permission => $description) {
            if (! ArrayHelper::keyExists($permission, $models)) {
                if (! $isOnlyAssigned) {
                    $models[$permission] = $adminComponent->modelFactory->getPermissionForm([
                        'roleId'      => $roleId,
                        'permission'  => $permission,
                        'isGlobal'    => false,
                        'isAssigned'  => false,
                        'description' => $description,
                    ]);
                }
            } else {
                $model              = $models[$permission];
                $model->description = $description;
            }
        }

        ArrayHelper::multisort($models, 'permission');

        return $models;
    }
}
