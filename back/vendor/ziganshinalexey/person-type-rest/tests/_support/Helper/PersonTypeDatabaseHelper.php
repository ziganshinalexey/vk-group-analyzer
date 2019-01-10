<?php

declare(strict_types = 1);

namespace Ziganshinalexey\PersonTypeRest\tests\Helper;

use Codeception\Exception\ModuleException;
use Codeception\Module;
use Codeception\Module\Db;
use Userstory\ComponentHelpers\helpers\ArrayHelper;
use yii;
use Ziganshinalexey\PersonType\entities\PersonTypeActiveRecord;

/**
 * Хелпер для создания предусловий в тестах API сущности "Тип личности".
 */
class PersonTypeDatabaseHelper extends Module
{
    /**
     * Добавляет запись в таблицы сущности "Тип личности".
     *
     * @param array $params Значение полей записи, которую нужно добавить.
     *
     * @throws ModuleException Если модуль DB не зарегистрирован в конфигурации codeception.
     *
     * @return int
     */
    protected function addPersonTypeEntity(array $params): int
    {
        return $this->getModuleDb()->haveInDatabase($this->getPersonTypeTableName(), [
            'name' => ArrayHelper::getValue($params, 'name', sqs('name')),
        ]);
    }

    /**
     * Проверяет отсутствие записи в таблице сущности "Тип личности".
     *
     * @param array $criteria Критерии, которым должна удолвлетворять искомая запись.
     *
     * @throws ModuleException Если модуль DB не зарегистрирован в конфигурации codeception.
     *
     * @return void
     */
    public function dontSeeInPersonTypeTable(array $criteria): void
    {
        $this->getModuleDb()->dontSeeInDatabase($this->getPersonTypeTableName(), $criteria);
    }

    /**
     * Возвращает стандартный модуль codeception DB.
     *
     * @throws ModuleException Если модуль DB не зарегистрирован в конфигурации codeception.
     *
     * @return Db|Module
     */
    protected function getModuleDb(): Db
    {
        return $this->getModule('Db');
    }

    /**
     * Возвращает название таблицы сущности "Тип личности".
     *
     * @return string
     */
    protected function getPersonTypeTableName(): string
    {
        return Yii::$app->db->schema->getRawTableName(PersonTypeActiveRecord::tableName());
    }

    /**
     * Возвращает значение поля из таблицы сущности "Тип личности".
     *
     * @param string $column   Название столца значение которого нужно вернуть.
     * @param array  $criteria Критерии, которым должна удолвлетворять искомая запись.
     *
     * @throws ModuleException Если модуль DB не зарегистрирован в конфигурации codeception.
     *
     * @return mixed
     */
    public function grabFromPersonTypeTable(string $column, array $criteria)
    {
        return $this->getModuleDb()->grabFromDatabase($this->getPersonTypeTableName(), $column, $criteria);
    }

    /**
     * Проверяет наличие записи в таблице сущности "Тип личности".
     *
     * @param array $criteria Критерии, которым должна удолвлетворять искомая запись.
     *
     * @throws ModuleException Если модуль DB не зарегистрирован в конфигурации codeception.
     *
     * @return void
     */
    public function seeInPersonTypeTable(array $criteria): void
    {
        $this->getModuleDb()->seeInDatabase($this->getPersonTypeTableName(), $criteria);
    }

    /**
     * Обновляет запись в таблицы сущности "Тип личности".
     *
     * @param int   $id     Идентификатор обновляемой записи.
     * @param array $params Значение полей записи, которую нужно добавить.
     *
     * @throws ModuleException Если модуль DB не зарегистрирован в конфигурации codeception.
     *
     * @return void
     */
    protected function updatePersonTypeEntityById(int $id, array $params): void
    {
        $this->getModuleDb()->updateInDatabase($this->getPersonTypeTableName(), [
            'name' => ArrayHelper::getValue($params, 'name', sqs('name')),
        ], [
            'id' => $id,
        ]);
    }
}
