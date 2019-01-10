<?php

declare(strict_types = 1);

namespace Userstory\Database\interfaces;

use yii\db\Connection;

/**
 * Интерфейс ObjectWithDbConnectionInterface.
 * Интерфейс объекта, работающего с подключением к базе данных.
 */
interface ObjectWithDbConnectionInterface
{
    /**
     * Метод получает объект подключения к базе данных.
     *
     * @return Connection
     */
    public function getDbConnection(): Connection;

    /**
     * Метод устанавливает подключение к базе данных.
     *
     * @param Connection $dbConnection Новое значение.
     *
     * @return static
     */
    public function setDbConnection(Connection $dbConnection);
}
