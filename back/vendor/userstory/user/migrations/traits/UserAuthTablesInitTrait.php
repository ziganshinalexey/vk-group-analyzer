<?php

namespace Userstory\User\migrations\traits;

use Userstory\ComponentFieldset\entities\Fieldset;
use Userstory\ComponentFieldset\entities\FieldSetting;
use Userstory\User\entities\AuthAssignmentActiveRecord;
use Userstory\User\entities\AuthRoleActiveRecord;
use Userstory\User\entities\AuthRoleMapActiveRecord;
use Userstory\User\entities\AuthRolePermissionActiveRecord;
use Userstory\User\entities\UserAuthActiveRecord;
use Userstory\User\entities\UserProfileActiveRecord;
use Userstory\User\entities\UserProfileSettingActiveRecord;
use Userstory\User\traits\FactoryCommonTrait;
use yii\base\InvalidConfigException;

/**
 * Class UserAuthTablesInitTrait
 * Производит инициализацию названий таблиц для миграции в данном модуле.
 *
 * @package Userstory\User\migrations\traits
 */
trait UserAuthTablesInitTrait
{
    use FactoryCommonTrait;

    /**
     * Имя таблици с ролями системы .
     *
     * @var null|string
     */
    protected $authRoleTable;

    /**
     * Имя таблици для связи ролей и профилей.
     *
     * @var null|string
     */
    protected $authAssignmentTable;

    /**
     * Имя таблици для связи ролей и профилей.
     *
     * @var null|string
     */
    protected $authRoleMapTable;

    /**
     * Имя таблици для связи ролей и профилей.
     *
     * @var null|string
     */
    protected $authRolePermissionTable;

    /**
     * Имя таблици авторизации пользователя.
     *
     * @var null|string
     */
    protected $userAuthTable;

    /**
     * Имя таблици профиля пользователя.
     *
     * @var null|string
     */
    protected $userProfileTable;

    /**
     * Имя таблици дополнительных настроек профиля пользователя.
     *
     * @var null|string
     */
    protected $userProfileSettingsTable;

    /**
     * Имя таблици класса фиелдсета.
     *
     * @var null|string
     */
    protected $fieldsetTable;

    /**
     * Имя таблици натрокет фиелдсета.
     *
     * @var null|string
     */
    protected $fieldSettingsTable;

    /**
     * Инициализирует имена таблиц для миграций.
     *
     * @return void
     *
     * @throws InvalidConfigException если компонент authManager не настроен.
     */
    public function init()
    {
        $this->authRoleTable            = AuthRoleActiveRecord::tableName();
        $this->authAssignmentTable      = AuthAssignmentActiveRecord::tableName();
        $this->authRoleMapTable         = AuthRoleMapActiveRecord::tableName();
        $this->authRolePermissionTable  = AuthRolePermissionActiveRecord::tableName();
        $this->userAuthTable            = UserAuthActiveRecord::tableName();
        $this->userProfileTable         = UserProfileActiveRecord::tableName();
        $this->userProfileSettingsTable = UserProfileSettingActiveRecord::tableName();
        $this->fieldsetTable            = Fieldset::tableName();
        $this->fieldSettingsTable       = FieldSetting::tableName();

        parent::init();
    }
}
