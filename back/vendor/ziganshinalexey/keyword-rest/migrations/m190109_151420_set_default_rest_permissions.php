<?php

declare(strict_types = 1);

use Userstory\ComponentMigration\models\db\AbstractMigration;

/**
 * Класс реализует миграцию для установки прав доступа на конкретные роли к конкретным методам.
 */
class m190109_151420_set_default_rest_permissions extends AbstractMigration
{
    /**
     * Права доступа для установки на конкретные роли.
     *
     * @var array
     */
    protected $permissionRoleList = [
        'admin' => [
            'Keyword.Keyword.Create' => 1,
            'Keyword.Keyword.Update' => 1,
            'Keyword.Keyword.Delete' => 1,
            'Keyword.Keyword.View'   => 1,
            'Keyword.Keyword.List'   => 1,
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
