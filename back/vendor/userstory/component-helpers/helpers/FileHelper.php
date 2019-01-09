<?php

namespace Userstory\ComponentHelpers\helpers;

use Exception;
use Userstory\ComponentHelpers\helpers\exceptions\FileHelperException;
use Userstory\ComponentHelpers\helpers\exceptions\FileNotCloseException;
use Userstory\ComponentHelpers\helpers\exceptions\FileNotLockException;
use Userstory\ComponentHelpers\helpers\exceptions\FileNotOpenException;
use Userstory\ComponentHelpers\helpers\exceptions\FileNotUnlockException;
use Userstory\ComponentHelpers\helpers\exceptions\FileNotWriteException;
use Userstory\ComponentHelpers\helpers\exceptions\IsNotWritableException;
use yii;
use yii\helpers\FileHelper as YiiFileHelper;

/**
 * Class FileHelper. Дополняет функционал стандартного FileHelper от yii.
 *
 * @package Userstory\ComponentBase\models
 */
class FileHelper extends YiiFileHelper
{
    const FILE_WRITE_OPERATION_REWRITE = 'rewrite';
    const FILE_WRITE_OPERATION_APPEND  = 'append';

    /**
     * Метод проверяет наличие каталога.
     *
     * @param string $path путь к каталогу.
     *
     * @return boolean
     */
    public static function isDirectory($path)
    {
        return is_dir($path);
    }

    /**
     * Метод проверяет, существует ли файл по указанному пути.
     *
     * @param string $path путь к каталогу.
     *
     * @return boolean
     */
    public static function isFile($path)
    {
        return is_file($path);
    }

    /**
     * Метод проверяет наличие прав на запись.
     *
     * @param string $path путь к каталогу.
     *
     * @return boolean
     */
    public static function isWritable($path)
    {
        return self::fileExists($path) && is_writable($path);
    }

    /**
     * Метод проверяет наличие прав на чтение.
     *
     * @param string $path путь к каталогу.
     *
     * @return boolean
     */
    public static function isReadable($path)
    {
        return self::fileExists($path) && is_readable($path);
    }

    /**
     * Получаем содержимое файла.
     *
     * @param string          $path           Путь до файла.
     * @param boolean|integer $useIncludePath Искать ли файл в каталогах, описанных в параметре include_path php ini.
     * @param integer         $offset         Смещение, после которого нужно читать.
     *
     * @return string|mixed
     *
     * @throws FileHelperException Если файл не обычный файл или нет доступа на чтение.
     */
    public static function fileGetContents($path, $useIncludePath = null, $offset = null)
    {
        if (! static::isFile($path) || ! static::isReadable($path)) {
            throw new FileHelperException('The file is not a regular file or not readable');
        }
        return file_get_contents($path, $useIncludePath, null, $offset);
    }

    /**
     * Сохраняем содержимое файла.
     *
     * @param string $path    Путь до файла.
     * @param string $content Содержимое файла.
     * @param mixed  $flags   Дополнительные флаги.
     * @param mixed  $context Контекст сохранения.
     *
     * @return mixed
     */
    public static function filePutContents($path, $content, $flags = null, $context = null)
    {
        return file_put_contents($path, $content, $flags, $context);
    }

    /**
     * Метод удаляет файл по указанному пути.
     *
     * @param string  $path     путь к файлу.
     * @param boolean $strictly требуется ли строгое удаление.
     *
     * @return true
     * @throws FileHelperException генерируется в случае проблем с удалением.
     */
    public static function remove($path, $strictly = true)
    {
        if (static::isFile($path)) {
            return static::deleteFile($path);
        }
        if (static::isDirectory($path)) {
            return static::deleteDirectory($path);
        }
        if (! $strictly && ! static::isDirectory($path)) {
            return true;
        }
        throw new FileHelperException('The file or directory in the specified path does not exist');
    }

    /**
     * Метод удаляет директорию по указанному пути.
     *
     * @param string $path путь к целевой директории.
     *
     * @return true
     * @throws FileHelperException генерируется в случае проблем с чтением файла или директории.
     */
    protected static function deleteDirectory($path)
    {
        if (! static::isDirectory($path)) {
            throw new FileHelperException('The directory in the specified path does not exist');
        }
        if (! static::isWritable($path)) {
            throw new FileHelperException('The path is not writable');
        }
        try {
            static::removeDirectory($path);
        } catch (Exception $e) {
            throw new FileHelperException('Error while deleting directory');
        }
        return true;
    }

    /**
     * Метод удаляет файл по указанному пути.
     *
     * @param string $path путь к целевой директории.
     *
     * @return true
     * @throws FileHelperException генерируется в случае проблем с чтением файла или директории.
     */
    protected static function deleteFile($path)
    {
        if (! static::isFile($path)) {
            throw new FileHelperException('The file in the specified path does not exist');
        }
        if (! static::isWritable($path)) {
            throw new FileHelperException('The path is not writable');
        }
        if (! unlink($path)) {
            throw new FileHelperException('Error while deleting file');
        }
        return true;
    }

    /**
     * Метод выполняет удаление файла.
     *
     * @param string $path Путь к удаляемому файлу.
     *
     * @return boolean
     */
    public static function unlink($path)
    {
        return unlink($path);
    }

    /**
     * Метод возвращает указанный файл.
     *
     * @param string $path путь к каталогу.
     *
     * @return integer
     * @throws FileHelperException генерируется в случае проблем с чтением файла.
     */
    public static function readFile($path)
    {
        if (! static::isFile($path)) {
            throw new FileHelperException('The file in the specified path does not exist');
        }
        if (! static::isReadable($path)) {
            throw new FileHelperException('The file is not readable');
        }
        $file = readfile($path);
        if (false === $file) {
            throw new FileHelperException('Error while reading file');
        }
        return $file;
    }

    /**
     * Метод возвращает хэш на указанный файл.
     *
     * @param string $path     путь к каталогу.
     * @param string $hashType метод хэширования.
     *
     * @return string
     * @throws FileHelperException генерируется в случае проблем с чтением файла.
     */
    public static function getFileHash($path, $hashType = 'sha256')
    {
        if (! static::isFile($path)) {
            throw new FileHelperException('The file in the specified path does not exist');
        }
        if (! static::isReadable($path)) {
            throw new FileHelperException('The file is not readable');
        }
        return hash_file($hashType, $path);
    }

    /**
     * Метод создаёт каталог по указанному пути и с указанными правами доступа.
     *
     * @param string  $path      путь к каталогу.
     * @param integer $mode      права доступа.
     * @param boolean $recursive создавать ли директроии рекурсивно.
     *
     * @return true
     *
     * @throws FileHelperException генерируется в случае проблем с созданием директории.
     */
    public static function createDirectory($path, $mode = 0775, $recursive = true)
    {
        try {
            if (! parent::createDirectory($path, $mode, $recursive)) {
                throw new FileHelperException('Error while creating directory');
            }
        } catch (Exception $e) {
            throw new FileHelperException('Error while creating directory');
        }
        return true;
    }

    /**
     * Метод переименовывает файл или каталог.
     *
     * @param string $oldName старое имя.
     * @param string $newName новое имя.
     * @param string $path    путь к каталогу.
     *
     * @return true
     * @throws FileHelperException генерируется в случае проблем с переименовыванием файла или директории.
     */
    public static function rename($oldName, $newName, $path = null)
    {
        if (null === $path) {
            $path = static::getPathFromFullName($newName);
        } else {
            $newName = $path . $newName;
        }
        static::createDirectory($path, 0777);
        if (! static::isWritable($oldName) || ! static::isWritable(static::getPathFromFullName($newName))) {
            throw new FileHelperException('The path is not writable');
        }
        if (! rename($oldName, $newName)) {
            throw new FileHelperException('Error while rename file or directory');
        }
        return true;
    }

    /**
     * Метод записывает новый файл.
     *
     * @param string $content Данные для сохранения.
     * @param string $newName новое имя.
     * @param string $path    путь к каталогу.
     *
     * @return true
     *
     * @throws FileHelperException генерируется в случае проблем с переименовыванием файла или директории.
     *
     * @deprecated Следует использовать FileHelper::fileWrite(...)
     */
    public static function writeFile($content, $newName, $path = null)
    {
        if (null === $path) {
            $pathInfo = pathinfo($newName);
            $newName  = $pathInfo['basename'];
            $path     = $pathInfo['dirname'] . DIRECTORY_SEPARATOR;
        }
        static::createDirectory($path, 0777);
        if (! static::isWritable($path)) {
            throw new FileHelperException('The path is not writable');
        }
        $fp = fopen($path . $newName, 'w');
        if (false === $fp) {
            throw new FileHelperException('Error while writing file');
        }
        if (false === fwrite($fp, $content)) {
            throw new FileHelperException('Error while writing file');
        }
        if (false === fclose($fp)) {
            throw new FileHelperException('Error while writing file');
        }
        return true;
    }

    /**
     * Метод записывает данные в файл.
     * Генерирует генерирует исключения в случае возникновения ошибок.
     *
     * @param string  $path    Путь к записываемому файлу.
     * @param string  $content Данные для сохранения.
     * @param boolean $lock    Необходимо ли выполнять блокировку файла.
     * @param string  $mode    Тип операции записи, которую нужно выполнить над файлом. Допустимы значения для этого параметра:
     *                         FileHelper::FILE_WRITE_MODE_REWRITE и FileHelper::FILE_WRITE_MODE_APPEND.
     *
     * @return void
     *
     * @throws FileNotCloseException Исключение генерируется в случае, если файл не был закрыт.
     * @throws FileNotLockException Исключение генерируется в случае, если файл не был заблокирован.
     * @throws FileNotOpenException Исключение генерируется в случае, если файл не был открыт.
     * @throws FileNotUnlockException Исключение генерируется в случае, если файл не был разблокирован.
     * @throws FileNotWriteException Исключение генерируется в случае, если файл не был записан.
     * @throws IsNotWritableException Исключение генерируется в случае, если путь до файла не дотступен для записи.
     */
    public static function fileWrite($path, $content, $lock = true, $mode = '')
    {
        $fileDir   = dirname($path) . DIRECTORY_SEPARATOR;
        $fopenMode = self::getFopenModeForWriteOperation($mode);
        self::createDirectory($fileDir, 0777);
        if (! self::isWritable($fileDir)) {
            throw new IsNotWritableException(sprintf('Directory "%s" is not writable', $fileDir));
        }
        if (self::fileExists($path) && ! self::isWritable($path)) {
            throw new IsNotWritableException(sprintf('File "%s" is not writable', $path));
        }
        if (false === ($fp = fopen($path, $fopenMode))) {
            throw new FileNotOpenException(sprintf('Can not open file "%s"', $path));
        }
        if ($lock && ! flock($fp, LOCK_EX)) {
            throw new FileNotLockException(sprintf('Can not lock file "%s"', $path));
        }
        if (false === fwrite($fp, $content)) {
            throw new FileNotWriteException(sprintf('Can not write file "%s"', $path));
        }
        if ($lock && ! flock($fp, LOCK_UN)) {
            throw new FileNotUnlockException(sprintf('Can not unlock file "%s"', $path));
        }
        if (false === fclose($fp)) {
            throw new FileNotCloseException(sprintf('Can not close file "%s"', $path));
        }
    }

    /**
     * Метод получает режим работы для функции fopen для операций записи в файл.
     *
     * @param mixed $writeOperation Операция записи, для получения значения.
     *
     * @return string
     */
    protected static function getFopenModeForWriteOperation($writeOperation)
    {
        switch ($writeOperation) {

            case static::FILE_WRITE_OPERATION_APPEND:
                return 'a';

            case static::FILE_WRITE_OPERATION_REWRITE:
                return 'w';
        }
        return 'w';
    }

    /**
     * Метод получает путь к файлу.
     *
     * @param string $path полный путь файла.
     *
     * @return string
     */
    protected static function getPathFromFullName($path)
    {
        $position = mb_strripos($path, DIRECTORY_SEPARATOR, null, 'UTF-8') + 1;
        return mb_substr($path, 0, $position, 'UTF-8');
    }

    /**
     * Метод возвращает размер файла.
     *
     * @param string $dir путь к целевому файлу.
     *
     * @return integer
     * @throws FileHelperException генерируется в случае проблем с чтением файла или директории.
     */
    public static function getSize($dir)
    {
        $isFile = static::isFile($dir);
        if (! $isFile && ! static::isDirectory($dir)) {
            throw new FileHelperException('The file or directory in the specified path does not exist');
        }
        if ($isFile) {
            $size = static::fileSize($dir);
        } else {
            $size = static::getDirectorySize($dir);
        }
        if (false === $size) {
            throw new FileHelperException('Error while reading file or directory');
        }
        return $size;
    }

    /**
     * Метод возвращает размер директории.
     *
     * @param string $path путь к целевой директории.
     *
     * @return integer
     * @throws FileHelperException генерируется в случае проблем с чтением файла или директории.
     */
    protected static function getDirectorySize($path)
    {
        $fileSize = 0;
        $dir      = scandir($path);

        foreach ($dir as $file) {
            if (('.' !== $file) && ('..' !== $file)) {
                if (static::isDirectory($path . '/' . $file)) {
                    $fileSize += static::getDirectorySize($path . '/' . $file);
                } else {
                    $fileSize += static::fileSize($path . '/' . $file);
                }
            }
        }

        return $fileSize;
    }

    /**
     * Метод возвращает размер файла по указанному пути.
     *
     * @param string $path путь к целевому файлу.
     *
     * @return integer
     * @throws FileHelperException генерируется в случае проблем с чтением файла или директории.
     */
    protected static function fileSize($path)
    {
        if (! static::isReadable($path)) {
            throw new FileHelperException('The file is not readable');
        }
        try {
            $size = filesize($path);
            if (false === $size) {
                throw new FileHelperException('Error while getting size');
            }
        } catch (Exception $e) {
            throw new FileHelperException('Error while getting size');
        }
        return $size;
    }

    /**
     * Метод возвращает форматированный размер файла.
     *
     * @param integer $size размер файла в байтах.
     * @param boolean $full отображать ли размер файла в полном формате ( 1 МБ (1000000 байт) ).
     *
     * @return boolean|float
     */
    public static function getFormattedSize($size, $full = true)
    {
        $fileSizeName = [
            Yii::t('yii', 'B'),
            Yii::t('yii', 'KB'),
            Yii::t('yii', 'MB'),
            Yii::t('yii', 'GB'),
            Yii::t('yii', 'TB'),
        ];
        if (0 === $size) {
            return '0 ' . $fileSizeName[0];
        }
        $fileSize = round($size / pow(1024, ($i = floor(log($size, 1024)))), 0) . $fileSizeName[$i];
        return $full ? $fileSize . ' (' . number_format($size, 0, '', ' ') . ' ' . $fileSizeName[0] . ')' : $fileSize;
    }

    /**
     * Метод определяет тип MIME для указанного файла..
     *
     * @param string  $path           путь к каталогу.
     * @param string  $magicFile      параметр родителя.
     * @param boolean $checkExtension параметр родителя.
     *
     * @inherit
     *
     * @throws Exception генерируется в случае проблем с чтением фалйа.
     * @throws FileHelperException генерируется в случае проблем с чтением фалйа.
     *
     * @return string
     */
    public static function getMimeType($path, $magicFile = null, $checkExtension = true)
    {
        if (! static::isFile($path)) {
            throw new FileHelperException('The file in the specified path does not exist');
        }
        if (! static::isReadable($path)) {
            throw new FileHelperException('The file is not readable');
        }
        try {
            return parent::getMimeType($path);
        } catch (Exception $e) {
            throw $e;
        }
    }

    /**
     * Метод копирует файл по указанному пути.
     *
     * @param string $from откуда нужно скопировать.
     * @param string $to   куда нужно скопировать.
     *
     * @return void
     * @throws FileHelperException генерируется в случае проблем с чтением файла или директории.
     */
    public static function copyFile($from, $to)
    {
        $path = static::getPathFromFullName($to);
        static::createDirectory($path, 0777);
        if (! static::isFile($from)) {
            throw new FileHelperException('The file in the specified path does not exist');
        }
        if (! static::isReadable($from)) {
            throw new FileHelperException('The file is not readable');
        }
        if (! copy($from, $to)) {
            throw new FileHelperException('Error while copying file');
        }
    }

    /**
     * Метод возвращает список каталогов и файлов по указанному пути.
     *
     * @param string $path путь к целевой директории.
     *
     * @return array
     * @throws FileHelperException генерируется в случае проблем с чтением файла или директории.
     */
    public static function scanDir($path)
    {
        if (! static::isReadable($path)) {
            throw new FileHelperException('The path is not readable');
        }
        if (! static::isDirectory($path)) {
            throw new FileHelperException('The directory in the specified path does not exist');
        }
        try {
            $directoryList = scandir($path);
            if (false === $directoryList) {
                throw new FileHelperException('Error while scanning dir');
            }
            return $directoryList;
        } catch (Exception $e) {
            throw new FileHelperException('Error while scanning dir');
        }
    }

    /**
     * Метод возвращает время последней записи блоков файла.
     *
     * @param string $path путь к целевому файлу.
     *
     * @return mixed
     * @throws FileHelperException генерируется в случае проблем с чтением файла или директории.
     */
    public static function fileModifiedTime($path)
    {
        if (! static::isReadable($path)) {
            throw new FileHelperException('The path is not readable');
        }
        if (! static::isFile($path)) {
            throw new FileHelperException('The file in the specified path does not exist');
        }
        try {
            $time = filemtime($path);
            if (false === $time) {
                throw new FileHelperException('Error while scanning file');
            }
            return $time;
        } catch (Exception $e) {
            throw new FileHelperException('Error while scanning file');
        }
    }

    /**
     * Метод возвращает время последнего доступа к файлу.
     *
     * @param string $path путь к целевому файлу.
     *
     * @return mixed
     * @throws FileHelperException генерируется в случае проблем с чтением файла или директории.
     */
    public static function fileAccessedTime($path)
    {
        if (! static::isReadable($path)) {
            throw new FileHelperException('The path is not readable');
        }
        if (! static::isFile($path)) {
            throw new FileHelperException('The file in the specified path does not exist');
        }
        try {
            $time = fileatime($path);
            if (false === $time) {
                throw new FileHelperException('Error while scanning file');
            }
            return $time;
        } catch (Exception $e) {
            throw new FileHelperException('Error while scanning file');
        }
    }

    /**
     * Метод проверяет наличие файла.
     *
     * @param string $path путь к каталогу.
     *
     * @return boolean
     */
    public static function fileExists($path)
    {
        return file_exists($path);
    }

    /**
     * Метод форматирует данные в фромат CSV и записывает в файл.
     *
     * @param resource $handle    Текущий ресурс файла.
     * @param array    $fields    Данные для преобразования и записи.
     * @param string   $delimiter Разделитель.
     *
     * @return void
     */
    public static function putCsv($handle, array $fields, $delimiter)
    {
        fputcsv($handle, $fields, $delimiter);
    }

    /**
     * Метод форматирует данные из формата CSV.
     *
     * @param resource $handle    Текущий ресурс файла.
     * @param integer  $length    Длина считываемых данных.
     * @param string   $delimiter Разделитель.
     *
     * @return array
     */
    public static function getCsv($handle, $length, $delimiter)
    {
        return fgetcsv($handle, $length, $delimiter);
    }

    /**
     * Меняет права на доступ к файлу.
     *
     * @param string $fileName Путь до файла.
     * @param string $mode     Устанавливаемые права.
     *
     * @return boolean
     */
    public static function chmod($fileName, $mode)
    {
        return chmod($fileName, $mode);
    }

    /**
     * Метод возвращает тип файла или false, если файл не найден.
     *
     * @param string $path Путь к файлу.
     *
     * @return string|false
     */
    public static function getFileType($path)
    {
        if (! file_exists($path) || is_dir($path)) {
            return false;
        }

        $fileInfo = finfo_open(FILEINFO_MIME_TYPE);
        $mimeType = finfo_file($fileInfo, $path);
        finfo_close($fileInfo);

        return $mimeType;
    }

    /**
     * Метод возвращает имя директирии для врменных файлов.
     *
     * @return string
     *
     * @throws FileHelperException Генерирует в случае отсутствия прав на запись.
     */
    public static function getTempDirName()
    {
        $tmpDirName = sys_get_temp_dir();
        if (! static::isReadable($tmpDirName) || ! static::isWritable($tmpDirName)) {
            throw new FileHelperException('The path is not writable');
        }
        return $tmpDirName;
    }

    /**
     * Метод создает файл в директории для временных файлов и возвращает путь.
     *
     * @param string $prefix префикс для созданного файла.
     *
     * @return string
     */
    public static function createTempFile($prefix = '')
    {
        return tempnam(static::getTempDirName(), $prefix);
    }
}
