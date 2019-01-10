<?php

namespace Userstory\ComponentMigration\models\db;

use yii;
use yii\base\InvalidConfigException;
use yii\base\NotSupportedException;
use yii\db\ActiveRecord;
use yii\db\Migration as YiiMigration;
use yii\db\Query;

/**
 * Расширенный класс для осуществления миграций.
 *
 * @package Userstory\ComponentMigration\migrations
 *
 * @property \yii\db\Connection $db
 */
abstract class AbstractMigration extends YiiMigration
{
    /**
     * Имя класса, связанного с миграцией.
     *
     * @var string|null
     */
    protected $relationClass;

    /**
     * Наименование связанной с миграцией таблицы.
     * Для того, чтобы свойство tableName инициализировалось, необходимо в целевом классе объявить свойство relationClass.
     *
     * @var string|null
     */
    protected $tableName;

    /**
     * Свойство хранит список правил для ролей.
     *
     * @var array
     */
    protected $permissionRoleList = [];

    /**
     * Определение имени связанной с миграцией таблицей.
     *
     * @return void
     */
    public function init()
    {
        parent::init();
        if (null !== $this->relationClass && null === $this->tableName && is_subclass_of($this->relationClass, ActiveRecord::class)) {
            $class           = $this->relationClass;
            $this->tableName = $class::tableName();
        }
    }

    /**
     * Деинициализация (в транзакции) таблицы.
     *
     * @return void
     */
    public function safeDown()
    {
        if ($this->tableName) {
            $this->dropTable($this->tableName);
        }
    }

    /**
     * Метод добавляет суффикс для имени таблицы, констрейнта и т.д. и т.п.
     *
     * @param string $tableName название таблицы. Возможно в виде {{%table_name}}.
     * @param string $suffix    суффикс, который следует подставить в название.
     *
     * @return string
     */
    protected function addSuffix($tableName, $suffix)
    {
        return preg_replace('/^(\{\{)?([^\}]+)(\}\})?$/', '$1$2' . $suffix . '$3', $tableName);
    }

    /**
     * Возвращает список опций. Актуально для MySQL.
     *
     * @param array $options список опций таблицы.
     *
     * @return null|string
     */
    protected function getTableOptions(array $options = [])
    {
        if ('mysql' !== $this->db->driverName) {
            return null;
        }
        $defaultOptions = [
            'DEFAULT CHARACTER SET' => 'utf8',
            'DEFAULT COLLATE'       => 'utf8_general_ci',
            'ENGINE'                => 'InnoDB',
        ];
        foreach ($options as $option => $value) {
            if ($option = $this->normalizeColumnOption($option)) {
                if ('COMMENT' === $option) {
                    $value = $this->db->quoteValue($value);
                }
                $defaultOptions[$option] = $value;
            }
        }

        array_walk($defaultOptions, function(&$value, $key) {
            $value = $key . ' ' . $value;
        });
        return implode(' ', $defaultOptions);
    }

    /**
     * Метод нормализует (удяляет лишнее) из названия опции.
     *
     * @param string $name нормализация опции столбца.
     *
     * @return string|null
     */
    protected function normalizeColumnOption($name)
    {
        $removeSymbols = [
            '-',
            '_',
            ' ',
        ];
        switch (strtolower(str_replace($removeSymbols, '', $name))) {
            case 'charset':
            case 'characterset':
            case 'defaultcharset':
            case 'defaultcharacterset':
                return 'DEFAULT CHARACTER SET';

            case 'collate':
            case 'defaultcollate':
                return 'DEFAULT COLLATE';

            case 'engine':
                return 'ENGINE';

            case 'comment':
                return 'COMMENT';
        }

        return null;
    }

    /**
     * Добавление вторичного ключа, метод самостоятельно определяет имя ограничения.
     *
     * @param string       $table      таблица на которой создаются вторичные ключи.
     * @param string|array $columns    список столбцов, участвующий в ограничении.
     * @param string       $refTable   целевая таблица на которую будет ссылаться вторичный ключ.
     * @param string|array $refColumns список столбцов в целевой таблице.
     * @param null|string  $delete     действие, выполняемое при удалении значения в целевой таблице.
     * @param null|string  $update     действие, выполняемое при изменении значения в целевой таблице.
     *
     * @return void
     */
    public function addForeignKeyWithSuffix($table, $columns, $refTable, $refColumns, $delete = null, $update = null)
    {
        $name = $this->addSuffix($table, '_' . implode('_', (array)$columns) . '_fk');
        parent::addForeignKey($name, $table, $columns, $refTable, $refColumns, $delete, $update);
    }

    /**
     * Создание столбца с типом данных дата/время с часовым поясом. Актуально для PostgreSQL.
     *
     * @param integer|null $precision точность данных.
     *
     * @throws NotSupportedException Генерируется в родителе в случае, если нет поддержки для текущего типа драйвера.
     *
     * @return \yii\db\ColumnSchemaBuilder
     */
    protected function dateTimeWithTZ($precision = null)
    {
        if ('pgsql' === $this->db->driverName) {
            return $this->getDb()->getSchema()->createColumnSchemaBuilder(sprintf('timestamp(%d) with time zone', $precision));
        }

        return $this->dateTime($precision);
    }

    /**
     * Создание столбца с типом данных время с часовым поясом. Актуально для PostgreSQL.
     *
     * @param integer|null $precision точность данных.
     *
     * @throws NotSupportedException Генерируется в родителе в случае, если нет поддержки для текущего типа драйвера.
     *
     * @return \yii\db\ColumnSchemaBuilder
     */
    protected function timeWithTZ($precision = null)
    {
        if ('pgsql' === $this->db->driverName) {
            return $this->getDb()->getSchema()->createColumnSchemaBuilder(sprintf('time(%d) with time zone', $precision));
        }

        return $this->time($precision);
    }

    /**
     * Добавление типа mediumtext(только mysql) для столбца таблицы.
     *
     * @return yii\db\ColumnSchemaBuilder
     */
    protected function mediumText()
    {
        if ('mysql' === $this->db->driverName) {
            return $this->getDb()->getSchema()->createColumnSchemaBuilder('mediumtext');
        }
        return $this->text();
    }

    /**
     * Метод регистрирует вторичные ключи для связи с профилем создающего и изменяющего.
     *
     * @param string $tableName имя целевой таблицы профиля пользователя.
     * @param string $refTable  имя таблицы профилей, с которой будут установлены вторичные ключи.
     * @param string $delete    действие, при удалении связанной сущности.
     * @param string $update    действие, при изменении первичного ключа связанной сущности.
     *
     * @throws InvalidConfigException Генерируется в родителе в случае, компонент authManager не существует.
     *
     * @return void
     */
    public function addForeignKeyForModifiers($tableName, $refTable = null, $delete = 'SET NULL', $update = 'CASCADE')
    {
        if (null === $refTable) {
            if (! Yii::$app->has('authenticationService')) {
                return;
            }
            $userProfileClass = Yii::$app->get('authenticationService')->getUserProfileClass();
            $refTable         = $userProfileClass::tableName();
        }
        $this->addForeignKey($this->addSuffix($tableName, '_creatorId_fk'), $tableName, 'creatorId', $refTable, 'id', $delete, $update);
        $this->addForeignKey($this->addSuffix($tableName, '_updaterId_fk'), $tableName, 'updaterId', $refTable, 'id', $delete, $update);
    }

    /**
     * Перегрузка базового метода создания таблицы.
     *
     * @param string            $table   имя создаеваемой таблицы.
     * @param mixed             $columns определение столбцов.
     * @param null|string|array $options дополнительные параметры.
     *
     * @return void
     */
    public function createTable($table, $columns, $options = null)
    {
        $comment = null;
        if (is_array($options)) {
            $comment = isset($options['comment']) ? $options['comment'] : null;
            unset($options['comment']);
            $options = $this->getTableOptions($options);
        }
        parent::createTable($table, $columns, $options);
        if (null !== $comment) {
            $this->addCommentToTable($table, $comment);
        }
    }

    /**
     * Добавить комментарий к таблице.
     *
     * @param string $tableName имя таблицы к которой добавляем комментарий.
     * @param string $comment   текст комментария к таблице.
     *
     * @return void
     */
    public function addCommentToTable($tableName, $comment)
    {
        $comment = $this->db->quoteValue($comment);

        switch ($this->db->driverName) {
            case 'pgsql':
                $query = sprintf('COMMENT ON TABLE %s IS %s', $tableName, $comment);
                break;

            case 'mysql':
                $query = sprintf('ALTER TABLE %s COMMENT = %s', $tableName, $comment);
                break;

            default:
                return;
        }

        $this->execute($query);
    }

    /**
     * Метод удалет вторичные ключи для связи с профилем создающего и изменяющего.
     *
     * @param string $tableName имя целевой таблицы профиля пользователя.
     *
     * @return void
     */
    public function dropForeignKeyForModifiers($tableName)
    {
        $this->dropForeignKey($this->addSuffix($tableName, '_creatorId_fk'), $tableName);
        $this->dropForeignKey($this->addSuffix($tableName, '_updaterId_fk'), $tableName);
    }

    /**
     * Добавляет первичный ключ с в таблюцу формируя суфикс по названию таблицы и столбцов.
     *
     * @param string       $table   Имя таблицы.
     * @param array|string $columns Массив столбцов.
     *
     * @return void
     */
    public function addPrimaryKeyWithSuffix($table, $columns)
    {
        $this->addPrimaryKey($this->addSuffix($table, '_' . implode('_', (array)$columns) . '_pk'), $table, $columns);
    }

    /**
     * Добавляет индекс в таблюцу формируя суфикс по названию таблицы и столбцов.
     *
     * @param string       $table   Имя таблицы.
     * @param array|string $columns Массив столбцов.
     * @param boolean      $unique  признак уникальности индекса.
     *
     * @return void
     */
    public function addIndex($table, $columns, $unique = false)
    {
        $indexName = $this->addSuffix($table, sprintf('_%s_%s', implode('_', (array)$columns), $unique ? 'udx' : 'idx'));
        $this->createIndex($indexName, $table, $columns, $unique);
    }

    /**
     * Метод проверяет существует ли таблица.
     *
     * @param string $table Название таблицы для проверки.
     *
     * @return boolean
     */
    public function isTableExists($table)
    {
        return null !== $this->db->getTableSchema($table);
    }

    /**
     * Метод проверяет содержит ли таблица столбец.
     *
     * @param string $table  Таблица для проверки.
     * @param string $column Столбец для проверки.
     *
     * @return boolean
     */
    public function isTableColumnExist($table, $column)
    {
        $columns = $this->db->getTableSchema($table)->columnNames;
        return in_array($column, $columns, true);
    }

    /**
     * Метод проверяет содержит ли таблица записи.
     *
     * @param string $table Таблица для проверки.
     *
     * @return boolean
     */
    public function hasRows($table)
    {
        return ( new Query() )->from($table)->exists();
    }

    /**
     * Метод добавляет права на роль (Может работать и без пакета юзеров, просто не добавит права).
     *
     * @return boolean
     */
    public function addPermissionOnRole()
    {
        if (Yii::$app->has('userRole')) {
            $result = true;
            foreach ($this->permissionRoleList as $roleName => $permissionList) {
                $role = Yii::$app->userRole->getRole($roleName);
                if (null === $role) {
                    continue;
                }
                $result &= Yii::$app->userRole->setPermissionOnRole($role->id, $permissionList);
            }
            return $result;
        }
        return false;
    }

    /**
     * Метод удаляет права на роль (Может работать и без пакета юзеров, просто не удалит права).
     *
     * @return boolean
     */
    public function removePermissionOnRole()
    {
        if (Yii::$app->has('userRole')) {
            $result = true;
            foreach ($this->permissionRoleList as $roleName => $permissionList) {
                $role = Yii::$app->userRole->getRole($roleName);
                if (null === $role) {
                    continue;
                }
                $result &= Yii::$app->userRole->deletePermission($role->id, $permissionList);
            }
            return $result;
        }
        return false;
    }
}
