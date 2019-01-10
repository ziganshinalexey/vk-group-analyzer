<?php

declare(strict_types = 1);

use Userstory\ComponentMigration\models\db\AbstractMigration;

/**
 * Класс реализует миграцию для установки прав доступа на конкретные роли к конкретным методам.
 */
class m190109_151441_set_default_admin_permissions extends AbstractMigration
{
    /**
     * Права доступа для установки на конкретные роли.
     *
     * @var array
     */
    protected $permissionRoleList = [
        'admin' => [
            'Admin.PersonType.PersonType.View' => 1,
            'Admin.PersonType.PersonType.List' => 1,
        ],
    ];

    /**
     * Данный метод откатывает миграцию - удаляет установленные права.
     *
     * @return void
     */
    public function safeDown(): void
    {
        $this->removePermissionOnRole();
    }

    /**
     * Данный метод устанавливает права доступа к методам.
     *
     * @return void
     */
    public function safeUp(): void
    {
        $this->addPermissionOnRole();
    }
}
