<?php

declare(strict_types = 1);

use Userstory\ComponentMigration\models\db\AbstractMigration;

/**
 * Класс реализует миграцию для установки прав доступа на конкретные роли к конкретным методам.
 */
class m190109_151446_set_default_rest_permissions extends AbstractMigration
{
    /**
     * Права доступа для установки на конкретные роли.
     *
     * @var array
     */
    protected $permissionRoleList = [
        'admin' => [
            'PersonType.PersonType.Create' => 1,
            'PersonType.PersonType.Update' => 1,
            'PersonType.PersonType.Delete' => 1,
            'PersonType.PersonType.View'   => 1,
            'PersonType.PersonType.List'   => 1,
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
