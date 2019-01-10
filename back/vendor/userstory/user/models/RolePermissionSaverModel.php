<?php

namespace Userstory\User\models;

use Exception;
use Userstory\User\entities\AuthRoleActiveRecord;
use Userstory\User\entities\AuthRolePermissionActiveRecord;
use Userstory\User\traits\FactoryCommonTrait;
use yii;
use yii\base\InvalidConfigException;
use yii\base\Model;
use yii\db\Connection;

/**
 * Класс ProfileSaverModel.
 * Отвечает за назначение привилегий ролям пользователей.
 *
 * @package Userstory\User\models
 */
class RolePermissionSaverModel extends Model
{
    use FactoryCommonTrait;

    /**
     * Компонент управления базой данных.
     *
     * @var Connection|null
     */
    protected $dbComponent;

    /**
     * Модель авторизации для сохранения.
     *
     * @var AuthRoleActiveRecord|null
     */
    protected $authRoleModel;

    /**
     * Модель авторизации для сохранения.
     *
     * @var AuthRolePermissionActiveRecord|null
     */
    protected $authRolePermissionModel;

    /**
     * Геттер для компонента управления базой данных.
     *
     * @return null|Connection
     */
    protected function getDbComponent()
    {
        return $this->dbComponent;
    }

    /**
     * Сеттер для установки компонента управления базой данных.
     *
     * @param Connection $dbComponent компонент управления БД.
     *
     * @return void
     */
    public function setDbComponent(Connection $dbComponent)
    {
        $this->dbComponent = $dbComponent;
    }

    /**
     * Метод устанаваливает модель роли.
     *
     * @param AuthRoleActiveRecord $authRoleModel Новое значение.
     *
     * @return static
     */
    public function setAuthRoleModel(AuthRoleActiveRecord $authRoleModel)
    {
        $this->authRoleModel = $authRoleModel;
        return $this;
    }

    /**
     * Метод устанаваливает пермишены на роль.
     *
     * @param array $permissionList Список пермишенов для установки.
     *
     * @return boolean
     */
    public function setPermissionOnRole(array $permissionList)
    {
        if (null === $this->authRoleModel) {
            return false;
        }
        $oldPermissions = $this->authRoleModel->authRolePermissions;
        $insertData     = [];
        $transaction    = $this->getDbComponent()->beginTransaction();
        try {
            foreach ($permissionList as $permission => $isGlobal) {
                $keyExist = array_key_exists($permission, $oldPermissions);
                if ($keyExist && $isGlobal !== $oldPermissions[$permission]->isGlobal) {
                    $this->authRolePermissionModel = $oldPermissions[$permission];
                    if (! $this->updatePermission($isGlobal)) {
                        $transaction->rollBack();
                        return false;
                    }
                }
                if ($keyExist) {
                    continue;
                }
                $insertData[] = [
                    $this->authRoleModel->id,
                    $permission,
                    $isGlobal,
                ];
            }
            if (empty($insertData)) {
                $transaction->rollBack();
                return true;
            }
            $command = $this->getDbComponent()->createCommand()->batchInsert(AuthRolePermissionActiveRecord::tableName(), [
                'roleId',
                'permission',
                'isGlobal',
            ], $insertData);
            $result  = is_int($command->execute()) ? true : false;
            if (! $result) {
                $transaction->rollBack();
                return false;
            }
            $transaction->commit();
            return true;
        } catch (Exception $e) {
            $transaction->rollBack();
            return false;
        }
    }

    /**
     * Метод обновляет пермишены на роль.
     *
     * @param integer $isGlobal данные для обновления.
     *
     * @return boolean
     */
    protected function updatePermission($isGlobal)
    {
        $this->authRolePermissionModel->isGlobal = $isGlobal;
        return $this->authRolePermissionModel->save();
    }

    /**
     * Метод удаляет пермишены на роль.
     *
     * @param array $permissionList Список пермишенов для установки.
     *
     * @throws InvalidConfigException Исключение генерируется во внутренних вызовах.
     *
     * @return boolean
     */
    public function deletePermission(array $permissionList)
    {
        if (null === $this->authRoleModel) {
            return false;
        }

        if (empty($permissionList)) {
            return true;
        }

        $insertData = [];
        foreach ($permissionList as $permission => $isGlobal) {
            $insertData[] = $permission;
        }

        $permissionList = implode(', ', array_map([
            Yii::$app->db,
            'quoteValue',
        ], $insertData));

        $expression = $this->getExpression(sprintf('{{roleId}} = %d AND {{permission}} IN (%s)', $this->authRoleModel->id, $permissionList));
        $command    = $this->getDbComponent()->createCommand()->delete(AuthRolePermissionActiveRecord::tableName(), $expression);

        return is_int($command->execute());
    }
}
