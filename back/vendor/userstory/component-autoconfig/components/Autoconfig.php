<?php

namespace Userstory\ComponentAutoconfig\components;

use RuntimeException;
use Userstory\ComponentHelpers\helpers\exceptions\FileHelperException;
use Userstory\ComponentHelpers\helpers\FileHelper;
use Userstory\ComponentHelpers\helpers\ArrayHelper;
use Userstory\ComponentAutoconfig\interfaces\AutoconfigInterface;

/**
 * Данный класс отвечает за создание общего конфигурационного файла.
 *
 * @package Userstory\ComponentAutoconfig\components
 */
class Autoconfig
{
    /**
     * Данное свойство содержит общий массив с конфигурацией.
     *
     * @var array
     */
    protected $config = [];

    /**
     * Данное свойство содержит путь к директории с базовой конфигурацией.
     *
     * @var string|null
     */
    protected $configPath;

    /**
     * Данное свойство содержит путь к директории с кэшем.
     *
     * @var string|null
     */
    protected $cachePath;

    /**
     * Данное свойство содержит имя файла с закэшированным конфигом.
     *
     * @var string|null
     */
    protected $cacheFile;

    /**
     * Данное свойство содержит заданные по умолчанию маски дополнительных конфигурационных файлов, которые
     * используются случае, если маски дополнительных конфигурационных файлов не переданы.
     *
     * @var array
     */
    protected $defaultMasks = [
        '*.global.php',
        '*.local.php',
    ];

    /**
     * Конструктор данного класса.
     *
     * @param string|null $configPath Путь к директории с базовой конфигурацией.
     * @param string|null $cacheFile  Имя файла для файла кэша.
     */
    public function __construct($configPath = null, $cacheFile = null)
    {
        if ($configPath && FileHelper::isDirectory($configPath)) {
            // При получении configPath от пользователя справа обрезаются слеши
            $this->configPath = rtrim($configPath, '/\\');
        }

        $this->setCacheFile($cacheFile);
    }

    /**
     * Данный метод собирает в один массив и возвращает базовую конфигурацию, конфигурации пользовательских модулей
     * и дополнительные конфигурации.
     *
     * @param string $baseConfig Имя файла с базовой конфигурацией.
     * @param array  $modules    Массив с именами классов пользовательских модулей или их конфигурациями.
     * @param array  $masks      Массив с масками файлов дополнительных конфигураций.
     *
     * @throws RuntimeException Генерируется, если по каким-то причинам невозможна запись полученного конфига в файл.
     *
     * @return array
     */
    public function load($baseConfig, array $modules = [], array $masks = [])
    {
        // Если путь к директории с базовой конфигурацией не был задан через конструктор ранее, то задать его сейчас
        if (null === $this->configPath) {
            $this->configPath = dirname($baseConfig);
        }

        // Если имя файла с закэшированным конфигом не было задан через конструктор ранее, то задать его сейчас
        if (null === $this->cacheFile) {
            $this->setCacheFile(basename($baseConfig));
        }

        // Установить путь к файлу, из которого будет получена (либо в который будет записана) вся конфигурация
        $cacheConfig = $this->getCachePath() . DIRECTORY_SEPARATOR . $this->cacheFile;

        // Если константа YII_DEBUG не определена И файл с конфигурацией существует и доступен для чтения, то вернуть
        // его содержимое
        if (! ( defined('YII_DEBUG') && YII_DEBUG ) && FileHelper::isReadable($cacheConfig)) {
            return require $cacheConfig;
        }

        // Добавить конфигурации пользовательских модулей в общий массив
        $this->loadModulesConfig();

        // Добавить дополнительные конфигурации (то есть конфигурации, файлы которых соответствуют заданным маскам) в
        // общий массив
        $this->loadAdditionalConfigs($masks);

        // Добавить базовую конфигурацию в общий массив
        $this->mergeFileConfig($baseConfig);

        // Добавить конфигурации пользовательских модулей, классы которых были переданы в качестве параметра, в общий
        // массив
        $this->loadSpecifiedModulesConfig($modules);

        // Записать общий массив с конфигурацией в файл
        $this->writeConfigIntoFile($cacheConfig);
        return $this->config;
    }

    /**
     * Данный метод устанавливает путь к директории с кэшем, то есть путь к директории, в которую будет сохранен файл
     * со всей конфигурацией.
     *
     * @param string $cachePath Путь к директории с кэшем.
     *
     * @return static
     */
    public function setCachePath($cachePath)
    {
        if ($cachePath && FileHelper::isDirectory($cachePath)) {
            // При получении cachePath от пользователя справа обрезаются слеши
            $this->cachePath = rtrim($cachePath, '/\\');
        }

        return $this;
    }

    /**
     * Данный метод устанавливает имя файла с закэшированным конфигом.
     *
     * @param string $cacheFile Имя файла с закэшированным конфигом.
     *
     * @return static
     */
    protected function setCacheFile($cacheFile)
    {
        if ($cacheFile) {
            $this->cacheFile = $cacheFile;
        }

        return $this;
    }

    /**
     * Данный метод возвращает путь к директории с кэшем, то есть путь к директории, в которую будет сохранен файл со
     * всей конфигурацией.
     *
     * @return string
     */
    public function getCachePath()
    {
        if (null !== $this->cachePath) {
            return $this->cachePath;
        }

        if (isset($this->config['runtimePath'])) {
            // При получении runtimePath из общей конфигурации справа обрезаются слеши
            return $this->cachePath = rtrim($this->config['runtimePath'], '/\\');
        }

        // У configPath справа обрезаются слеши при инициализации
        return $this->cachePath = dirname($this->configPath) . '/runtime';
    }

    /**
     * Данный метод получает конфигурацию из файла, имя которого принимается в качестве параметра, и добавляет ее в
     * общий массив с конфигурацией. В случае успеха данный метод возвращает true, в противном случае возвращает false.
     *
     * @param string $file Имя файла с конфигурацией.
     *
     * @return boolean
     */
    protected function mergeFileConfig($file)
    {
        // Если переменная file содержит имя файла И файл с данным именем существует и доступен для чтения И данный
        // файл возвращает массив, то получить его конфигурацию
        if (FileHelper::isFile($file) && FileHelper::isReadable($file) && is_array($fileConfig = require $file)) {
            $this->config = ArrayHelper::merge($this->config, $fileConfig);
            return true;
        }

        return false;
    }

    /**
     * Данный метод добавляет конфигурации пользовательских модулей в общий массив.
     *
     * @return void
     */
    protected function loadModulesConfig()
    {
        // Получить массив, ключами которого являются пространства имен модулей, а значениями - их директории, и пройти
        // в цикле по каждому элементу
        foreach ($this->getPrefixesPsr4() as $namespace => $directory) {
            // Если имя пространства имен модуля начинается не с подстроки 'userstory', то перейти к следующему
            // элементу
            if (0 !== stripos($namespace, 'userstory') && 0 !== stripos($namespace, 'ziganshinalexey')) {
                continue;
            }

            // Получить имя класса Autoconfig с пространством имен модуля
            $autoconfig = $namespace . 'Autoconfig';
            $this->loadModuleConfig($autoconfig);
        }
    }

    /**
     * Метод загружает конфигурацию конкретного модуля.
     *
     * @param string $class имя загружаемого класса.
     *
     * @return void
     */
    protected function loadModuleConfig($class)
    {
        // Если пространство имен модуля, имя которого начинается с подстроки 'userstory', содержит класс
        // Autoconfig И этот класс является потомком интерфейса AutoconfigInterface...
        if (is_subclass_of($class, AutoconfigInterface::class) || method_exists($class, 'getConfig')) {
            // ...то получить конфигурацию модуля с данным пространством имен
            $this->config = ArrayHelper::merge($this->config, $class::getConfig());
        }
    }

    /**
     * Данный метод возвращает массив, ключами которого являются пространства имен модулей, а значениями - их
     * директории.
     *
     * @return array
     */
    protected function getPrefixesPsr4()
    {
        // Получить путь к файлу autoload.php
        $autoloadFile = $this->getAutoloadFile();

        // Если файл autoload.php существует и доступен для чтения...
        if (FileHelper::isReadable($autoloadFile)) {
            // ...то получить объект класса ClassLoader
            $loader = require $autoloadFile;

            // Получить массив, ключами которого являются пространства имен модулей, а значениями - их директории
            return $loader->getPrefixesPsr4();
        }

        return [];
    }

    /**
     * Данный метод возвращает строку, которая содержит путь к файлу autoload.php.
     *
     * @return string
     */
    protected function getAutoloadFile()
    {
        // Получить путь к директории с файлом autoload.php из общей конфигурации, при этом справа обрезаются слеши
        $vendorPath = isset($this->config['vendorPath']) ? rtrim($this->config['vendorPath'], '/\\') : null;

        // Если в массиве с базовой конфигурацией не указан путь к директории с данным файлом, то получить его вручную
        if (null === $vendorPath) {
            // У configPath справа обрезаются слеши при инициализации
            $vendorPath = dirname(dirname($this->configPath)) . '/vendor';
        }

        // Вернуть путь к файлу autoload.php
        return $vendorPath . '/autoload.php';
    }

    /**
     * Данный метод добавляет конфигурации пользовательских модулей, классы которых были переданы в качестве параметра,
     * в общий массив.
     *
     * @param array $modules Массив с именами классов пользовательских модулей или их конфигурациями.
     *
     * @return void
     */
    protected function loadSpecifiedModulesConfig(array $modules)
    {
        foreach ($modules as $module) {
            // Если переменная module содержит массив с конфигурацией, то добавить его в общий массив
            // Если переменная module содержит строку с именем класса, который является потомком интерфейса
            // AutoconfigInterface, то получить его конфигурацию и добавить ее в общий массив
            if (is_array($module)) {
                $this->config = ArrayHelper::merge($this->config, $module);
            } elseif (is_subclass_of($module, AutoconfigInterface::class)) {
                $this->config = ArrayHelper::merge($this->config, $module::getConfig());
            }
        }
    }

    /**
     * Данный метод добавляет дополнительные конфигурации (то есть конфигурации, файлы которых соответствуют заданным
     * маскам) в общий массив.
     *
     * @param array $masks Массив с масками файлов дополнительных конфигураций.
     *
     * @return void
     */
    protected function loadAdditionalConfigs(array $masks)
    {
        // Получить массив имен файлов, соответствующих заданным маскам
        $files = $this->getFilesFromMasks($this->getFullMasks($masks));

        // Добавить дополнительные конфигурации в общий массив
        foreach ($files as $file) {
            $this->mergeFileConfig($file);
        }
    }

    /**
     * Данный метод возвращает массив, содержащий маски файлов дополнительных конфигураций с полным путем к файлам.
     *
     * @param array $masks Массив с масками файлов дополнительных конфигураций.
     *
     * @return array
     */
    protected function getFullMasks(array $masks)
    {
        $fullMasks = [];

        if (empty($masks)) {
            $masks = $this->defaultMasks;
        }

        foreach ($masks as $mask) {
            $fullMasks[] = $this->configPath . DIRECTORY_SEPARATOR . $mask;
        }

        return $fullMasks;
    }

    /**
     * Данный метод возвращает массив файлов, соответствующих заданным маскам.
     *
     * @param array $fullMasks Массив масок файлов дополнительных конфигураций с полным путем к файлу.
     *
     * @return array
     */
    protected function getFilesFromMasks(array $fullMasks)
    {
        $files = [];

        foreach ($fullMasks as $fullMask) {
            $batchFiles = glob($fullMask, GLOB_MARK);
            sort($batchFiles, SORT_NATURAL);

            foreach ($batchFiles as $file) {
                if (FileHelper::isFile($file)) {
                    $files[] = $file;
                }
            }
        }

        return $files;
    }

    /**
     * Данный метод записывает общий массив с конфигурацией в файл, имя которого передается в качестве параметра. В
     * случае успеха данный метод возвращает true, в противном случае возвращает false.
     *
     * @param string $cacheFile Имя файла, в который будет записан общий массив с конфигурацией.
     *
     * @throws RuntimeException Генерируется, если по каким-то причинам невозможна запись полученного конфига в файл.
     *
     * @return boolean
     */
    protected function writeConfigIntoFile($cacheFile)
    {
        try {
            $fileContent = sprintf('%s?%s', '<', 'php') . PHP_EOL . PHP_EOL . 'return ' . var_export($this->config, true) . ';' . PHP_EOL;
            FileHelper::fileWrite($cacheFile, $fileContent, true, FileHelper::FILE_WRITE_OPERATION_REWRITE);
        } catch (FileHelperException $ex) {
            return false;
        }
        return true;
    }
}
