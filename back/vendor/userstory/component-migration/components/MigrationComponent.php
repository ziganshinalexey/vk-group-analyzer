<?php

namespace Userstory\ComponentMigration\components;

use yii\base\Component;

/**
 * Класс MigrationComponent. В сущности, нужен только для того, чтобы валидатор не ргулася.
 *
 * @package Userstory\ComponentMigration\components
 */
class MigrationComponent extends Component
{
    /**
     * Создаём объект класса $class с параметрами $db.
     *
     * @param array|string $db    Параметры для создания.
     * @param string       $class Название класса.
     *
     * @return mixed
     */
    public function createObject($db, $class)
    {
        return new $class(['db' => $db]);
    }
}
