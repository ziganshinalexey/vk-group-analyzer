<?php

declare(strict_types = 1);

namespace Userstory\Database\traits;

use yii;
use yii\db\Connection;

/**
 * Трейт ObjectWithDbConnectionTrait.
 * Трейт содержит необходимую логику для работы с подключением к базе данных.
 */
trait ObjectWithDbConnectionTrait
{
    /**
     * Объект подключения к базе данных.
     *
     * @var Connection|null
     */
    protected $dbConnection;

    /**
     * Метод получает объект подключения к базе данных.
     *
     * @return Connection
     */
    public function getDbConnection(): Connection
    {
        if (null === $this->dbConnection) {
            $this->dbConnection = Yii::$app->db;
        }
        return $this->dbConnection;
    }

    /**
     * Метод устанавливает подключение к базе данных.
     *
     * @param Connection $dbConnection Новое значение.
     *
     * @return static
     */
    public function setDbConnection(Connection $dbConnection)
    {
        $this->dbConnection = $dbConnection;
        return $this;
    }
}
