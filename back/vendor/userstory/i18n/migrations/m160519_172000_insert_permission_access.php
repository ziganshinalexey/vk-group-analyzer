<?php

use Userstory\ComponentMigration\models\db\AbstractMigration;

/**
 * Данный класс реализует миграцию для добавления данных о правах доступа.
 */
class m160519_172000_insert_permission_access extends AbstractMigration
{
    /**
     * Свойство хранит список правил для ролей.
     *
     * @var array
     */
    protected $permissionRoleList = [
        'admin' => [
            'Admin.Language.Index'            => 1,
            'Admin.Language.Create'           => 1,
            'Admin.Language.Update'           => 1,
            'Admin.Language.Delete'           => 1,
            'Admin.Language.GetFile'          => 1,
            'Admin.Language.ExportConstants'  => 1,
            'Admin.Language.ImportConstants'  => 1,
            'Admin.Translation.Index'         => 1,
            'Admin.Translation.Ajax'          => 1,
            'Admin.Translation.ChangeComment' => 1,
        ],
    ];

    /**
     * Данный метод вставляет данные о правах доступа.
     *
     * @return void
     */
    public function safeUp()
    {
        $this->addPermissionOnRole();
    }

    /**
     * Данный метод удаляет данные о правах доступа.
     *
     * @return void
     */
    public function safeDown()
    {
        $this->removePermissionOnRole();
    }
}
