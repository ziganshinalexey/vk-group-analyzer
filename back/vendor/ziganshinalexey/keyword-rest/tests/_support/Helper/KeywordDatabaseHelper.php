<?php

declare(strict_types = 1);

namespace Ziganshinalexey\KeywordRest\tests\Helper;

use Codeception\Exception\ModuleException;
use Codeception\Module;
use Codeception\Module\Db;
use Userstory\ComponentHelpers\helpers\ArrayHelper;
use yii;
use Ziganshinalexey\Keyword\entities\KeywordActiveRecord;

/**
 * Хелпер для создания предусловий в тестах API сущности "Ключевое фраза".
 */
class KeywordDatabaseHelper extends Module
{
    /**
     * Добавляет запись в таблицы сущности "Ключевое фраза".
     *
     * @param array $params Значение полей записи, которую нужно добавить.
     *
     * @throws ModuleException Если модуль DB не зарегистрирован в конфигурации codeception.
     *
     * @return int
     */
    protected function addKeywordEntity(array $params): int
    {
        return $this->getModuleDb()->haveInDatabase($this->getKeywordTableName(), [
            'text'         => ArrayHelper::getValue($params, 'text', sqs('text')),
            'personTypeId' => ArrayHelper::getValue($params, 'personTypeId', 1),
        ]);
    }

    /**
     * Проверяет отсутствие записи в таблице сущности "Ключевое фраза".
     *
     * @param array $criteria Критерии, которым должна удолвлетворять искомая запись.
     *
     * @throws ModuleException Если модуль DB не зарегистрирован в конфигурации codeception.
     *
     * @return void
     */
    public function dontSeeInKeywordTable(array $criteria): void
    {
        $this->getModuleDb()->dontSeeInDatabase($this->getKeywordTableName(), $criteria);
    }

    /**
     * Возвращает название таблицы сущности "Ключевое фраза".
     *
     * @return string
     */
    protected function getKeywordTableName(): string
    {
        return Yii::$app->db->schema->getRawTableName(KeywordActiveRecord::tableName());
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
     * Возвращает значение поля из таблицы сущности "Ключевое фраза".
     *
     * @param string $column   Название столца значение которого нужно вернуть.
     * @param array  $criteria Критерии, которым должна удолвлетворять искомая запись.
     *
     * @throws ModuleException Если модуль DB не зарегистрирован в конфигурации codeception.
     *
     * @return mixed
     */
    public function grabFromKeywordTable(string $column, array $criteria)
    {
        return $this->getModuleDb()->grabFromDatabase($this->getKeywordTableName(), $column, $criteria);
    }

    /**
     * Проверяет наличие записи в таблице сущности "Ключевое фраза".
     *
     * @param array $criteria Критерии, которым должна удолвлетворять искомая запись.
     *
     * @throws ModuleException Если модуль DB не зарегистрирован в конфигурации codeception.
     *
     * @return void
     */
    public function seeInKeywordTable(array $criteria): void
    {
        $this->getModuleDb()->seeInDatabase($this->getKeywordTableName(), $criteria);
    }

    /**
     * Обновляет запись в таблицы сущности "Ключевое фраза".
     *
     * @param int   $id     Идентификатор обновляемой записи.
     * @param array $params Значение полей записи, которую нужно добавить.
     *
     * @throws ModuleException Если модуль DB не зарегистрирован в конфигурации codeception.
     *
     * @return void
     */
    protected function updateKeywordEntityById(int $id, array $params): void
    {
        $this->getModuleDb()->updateInDatabase($this->getKeywordTableName(), [
            'text'         => ArrayHelper::getValue($params, 'text', sqs('text')),
            'personTypeId' => ArrayHelper::getValue($params, 'personTypeId', 1),
        ], [
            'id' => $id,
        ]);
    }
}
