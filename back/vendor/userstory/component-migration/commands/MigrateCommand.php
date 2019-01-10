<?php

namespace Userstory\ComponentMigration\commands;

use yii;
use yii\base\InvalidParamException;
use yii\console\controllers\MigrateController as YiiMigrateController;
use yii\helpers\Console;
use Userstory\ComponentHelpers\helpers\FileHelper;

/**
 * Переопределенный контроллер по осуществлению миграций.
 *
 * @package app\commands
 */
class MigrateCommand extends YiiMigrateController
{
    /**
     * Шаблон класса для создания новых миграций.
     *
     * @var string
     */
    public $templateFile = '@vendor/userstory/component-migration/templates/migration.php';

    /**
     * Переоределенный массив частных случаев шаблонов миграций.
     *
     * @var array
     */
    public $generatorTemplateFiles = [
        'create_table'    => '@vendor/userstory/component-migration/templates/create_table.php',
        'drop_table'      => '@vendor/userstory/component-migration/templates/drop_table.php',
        'add_column'      => '@vendor/userstory/component-migration/templates/add_column.php',
        'drop_column'     => '@vendor/userstory/component-migration/templates/drop_column.php',
        'create_junction' => '@vendor/userstory/component-migration/templates/create_junction.php',
    ];

    /**
     * Массив путей, где необходимо найти файлы миграций.
     *
     * @var array
     */
    public $migrationPathList = [];

    /**
     * Метод определяющий поведение после выполнения каких-либо действий.
     *
     * @param mixed $action выполняемая команда.
     * @param mixed $result результат выполнения команды.
     *
     * @return mixed
     */
    public function afterAction($action, $result)
    {
        $this->flushCache();
        return parent::afterAction($action, $result);
    }

    /**
     * Метод сбрасывает кэш базы данных.
     *
     * @return void
     */
    public function flushCache()
    {
        if ($this->db && is_object($this->db) && $this->db->schemaCacheDuration > 0) {
            $this->db->schema->refresh();
        }
    }

    /**
     * Действие, выполняющее очистку кэша базы данных.
     *
     * @return void
     */
    public function actionFlush()
    {
        $this->flushCache();
    }

    /**
     * Метод создающий новый класс миграции на основании шаблона.
     *
     * @param string $class имя создаваемого класса миграции.
     *
     * @return mixed
     *
     * @throws InvalidParamException алиас не объявлен.
     */
    protected function createMigration($class)
    {
        $migrationFound = false;
        if (is_string($this->migrationPath)) {
            $migrationFound = $this->requireMigrationFile($this->migrationPath, $class);
        } elseif (is_array($this->migrationPath)) {
            foreach ($this->migrationPath as $migrationPath) {
               $migrationFound = $this->requireMigrationFile($migrationPath, $class);
               if (true === $migrationFound) {
                   break;
               }
            }
        }
        if (! $migrationFound && is_array($this->migrationPathList) && ! empty($this->migrationPathList)) {
            foreach ($this->migrationPathList as $path) {
                $realPath = Yii::getAlias($path);
                if ($this->requireMigrationFile($realPath, $class)) {
                    break;
                }
            }
        }

        /* @var $migrationComponent \Userstory\ComponentMigration\components\MigrationComponent */
        $migrationComponent = Yii::$app->migration;
        return $migrationComponent->createObject($this->db, $class);
    }

    /**
     * Подключаем файл миграции, если таковой существует.
     *
     * @param string $path  Путь до директории с миграциями.
     * @param string $class Название класса.
     *
     * @return boolean Подключили файл или нет.
     */
    protected function requireMigrationFile($path, $class)
    {
        $file     = $path . DIRECTORY_SEPARATOR . $class . '.php';
        if (FileHelper::fileExists($file)) {
            require_once $file;
            return true;
        }
        return false;
    }

    /**
     * Метод осуществляет поиск всех доступных миграций.
     *
     * @throws InvalidParamException Генерируется, если в списке путей миграций есть не валидный путь.
     *
     * @return array
     */
    protected function getNewMigrations()
    {
        $applied = [];
        foreach ($this->getMigrationHistory(null) as $version => $time) {
            $applied[substr($version, 1, 13)] = true;
        }

        $migrations = [];
        $this->getDefaultMigrations($migrations, $applied);

        if (is_array($this->migrationPathList) && ! empty($this->migrationPathList)) {
            $this->searchInMigrationPath($migrations, $applied);
        }

        sort($migrations);
        return $migrations;
    }

    /**
     * Получить список непримененных миграций из указанной директории.
     *
     * @param string $dirPath    Путь до директории.
     * @param array  $migrations Ссылка на Массив неприменнёных миграций.
     * @param array  $applied    Ссылка на Массив применённых миграций.
     *
     * @return void
     */
    protected function getMigrationsFromDir($dirPath, array &$migrations, array &$applied)
    {
        $handle = opendir($dirPath);
        while (false !== ($file = readdir($handle))) {
            if ('.' === $file || '..' === $file) {
                continue;
            }
            $path = $dirPath . DIRECTORY_SEPARATOR . $file;
            if (preg_match('/^(m(\d{6}_\d{6})_.*?)\.php$/', $file, $matches) && ! isset($applied[$matches[2]]) && FileHelper::isFile($path)) {
                $migrations[] = $matches[1];
            }
        }
        closedir($handle);
    }

    /**
     * Получить список неприменённых миграций по пут(и|ям), которы[йе] описан[ы]? в поле migrationPath.
     *
     * @param array $migrations Ссылка на Массив неприменнёных миграций.
     * @param array $applied    Ссылка на Массив применённых миграций.
     *
     * @return void
     */
    protected function getDefaultMigrations(array &$migrations, array &$applied)
    {
        if (is_string($this->migrationPath)) {
            $this->getMigrationsFromDir($this->migrationPath, $migrations, $applied);
        } elseif (is_array($this->migrationPath)) {
            foreach ($this->migrationPath as $migrationPath) {
                $this->getMigrationsFromDir($migrationPath, $migrations, $applied);
            }
        }
    }

    /**
     * Метод осуществляет поиск миграцией по указанным в конфигурации путям.
     *
     * @param array $migrations массив найденных миграций.
     * @param array $applied    массив уже примененных миграций.
     *
     * @throws InvalidParamException Генерируется, если в списке путей миграций есть не валидный путь.
     *
     * @return void
     */
    protected function searchInMigrationPath(array &$migrations, array $applied)
    {
        foreach ($this->migrationPathList as $path) {
            $realPath = Yii::getAlias($path);
            if (false === $realPath || ! FileHelper::isDirectory($realPath)) {
                $this->stdout('Error: The migration directory does not exist: ' . $path . "\n", Console::FG_RED);
                exit(1);
            }
            $this->getMigrationsFromDir($realPath, $migrations, $applied);
        }
    }

    /**
     * Метод отключает интерактивность при выполнении команды migrate up.
     *
     * @param integer $limit количество миграций.
     *
     * @return integer
     */
    public function actionUp($limit = 0)
    {
        $this->interactive = false;
        return parent::actionUp($limit);
    }
}
