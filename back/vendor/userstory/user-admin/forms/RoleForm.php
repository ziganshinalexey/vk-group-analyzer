<?php

namespace Userstory\UserAdmin\forms;

use Exception as GlobalException;
use yii\base\Model;
use Userstory\User\entities\AuthRoleActiveRecord as AuthRole;
use Userstory\UserAdmin\traits\UserAdminComponentTrait;
use yii;

/**
 * Class RoleForm.
 * Класс формы для работы с ролями пользователей.
 *
 * @property PermissionForm[] $permissions
 *
 * @package Userstory\UserAdmin\forms
 */
class RoleForm extends AuthRole
{
    use UserAdminComponentTrait;

    /**
     * Список разрешений текуще роли.
     *
     * @var PermissionForm[]|null
     */
    protected $permissions;

    /**
     * Метод возвращает заголовки для аттрибутов.
     *
     * @return array
     */
    public function attributeLabels()
    {
        $labels                = parent::attributeLabels();
        $labels['canModified'] = Yii::t('User.AuthRole.Attribute', 'isSystem', 'Системная');

        return $labels;
    }

    /**
     * Метод загружает данные в форму.
     *
     * @param array|mixed $data     Данные для загрузки.
     * @param string|null $formName Название формы.
     *
     * @return boolean
     */
    public function load($data, $formName = null)
    {
        return parent::load($data, $formName) && Model::loadMultiple($this->getPermissions(), $data);
    }

    /**
     * Метод проверяет данные на валидность.
     *
     * @param array|mixed $attributeNames Список атрибутов для проверки.
     * @param boolean     $clearErrors    Очистить ли ошибки перед проверкой.
     *
     * @return boolean
     */
    public function validate($attributeNames = null, $clearErrors = true)
    {
        return parent::validate($attributeNames, $clearErrors) && Model::validateMultiple($this->getPermissions());
    }

    /**
     * Метод сохраняет данные формы.
     *
     * @throws GlobalException Исключение, если возникли ошибки при сохранении данных формы.
     *
     * @return boolean
     */
    public function saveForm()
    {
        if (! $this->validate()) {
            return false;
        }

        $transaction = static::getDb()->beginTransaction();

        try {
            if ($this->save() && $this->savePermissions()) {
                $transaction->commit();
            } else {
                $transaction->rollBack();
                return false;
            }
        } catch (GlobalException $e) {
            $transaction->rollBack();
            throw $e;
        }

        return true;
    }

    /**
     * Метод возвращает список разрешений роли.
     *
     * @param boolean $isOnlyAssigned Включить ли в список только назначенные разрешения.
     *
     * @return PermissionForm[]
     */
    public function getPermissions($isOnlyAssigned = false)
    {
        if (null === $this->permissions) {
            $this->permissions = $this->getUserAdminComponent()->commonOperation->getRolePermissions($this->id, $isOnlyAssigned);
        }

        return $this->permissions;
    }

    /**
     * Метод сохраняет разрешения текущей роли.
     *
     * @return boolean
     */
    protected function savePermissions()
    {
        if (! $this->canModified) {
            return false;
        }

        foreach ($this->permissions as $permission) {
            if ($permission->isAssigned) {
                if ($permission->isNewRecord || $permission->isAttributeChanged('isGlobal')) {
                    $permission->roleId = $this->id;
                    $permission->save(false);
                }
            } elseif (! $permission->isNewRecord) {
                $permission->delete();
            }
        }

        Yii::$app->authManager->clearCache();

        return true;
    }
}
