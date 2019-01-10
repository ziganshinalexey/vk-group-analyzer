<?php

namespace Userstory\ComponentBase\operations;

use Userstory\ComponentBase\interfaces\FileOperationInterface;
use Userstory\ComponentHelpers\helpers\FileHelper;
use yii;
use yii\web\UploadedFile;

/**
 * Класс PathFileOperations реализует операции загрузки/сохранения файлов.
 *
 * @package Userstory\ComponentBase\operations
 */
class PathFileOperations extends UploadedFile implements FileOperationInterface
{
    /**
     * Свойство хранит экземпляры операций с файлами.
     *
     * @var FileOperationInterface[]|null
     */
    protected static $files;

    /**
     * Метод задает путь к файлу.
     *
     * @param string $value Новое значение.
     *
     * @return void
     */
    public function setTempName($value)
    {
        $this->tempName = $value;
    }

    /**
     * Метод возвращает путь к файлу.
     *
     * @return string
     */
    public function getTempName()
    {
        return $this->tempName;
    }

    /**
     * Метод возвращает расширение файла.
     *
     * @return string
     */
    public function getExtension()
    {
        return strtolower(pathinfo($this->tempName, PATHINFO_EXTENSION));
    }

    /**
     * Метод возвращает экзермпляр операций с файлами.
     *
     * @param mixed  $model     Модель данных.
     * @param string $attribute Атрибут модели, к которой прикреплен файл.
     *
     * @inherit
     *
     * @return FileOperationInterface
     */
    public static function getInstance($model, $attribute)
    {
        return Yii::createObject([
            'class'    => static::class,
            'tempName' => $attribute,
        ]);
    }

    /**
     * Метод возвращает экзермпляр операций с файлами.
     *
     * @param mixed  $model     Модель данных.
     * @param string $attribute Атрибут модели, к которой прикреплен файл.
     *
     * @inherit
     *
     * @return FileOperationInterface[]
     */
    public static function getInstances($model, $attribute)
    {
        foreach ($attribute as $tempName) {
            static::$files[] = Yii::createObject([
                'class'    => static::class,
                'tempName' => $tempName,
            ]);
        }
        return static::$files;
    }

    /**
     * Метод сохраняет файл в указанную директорию.
     *
     * @param string  $file           Путь, куда нужно сохранить файл.
     * @param boolean $deleteTempFile Флаг удаления временного файла.
     *
     * @return boolean
     */
    public function saveAs($file, $deleteTempFile = true)
    {
        FileHelper::copyFile($this->tempName, $file);
        if ($deleteTempFile) {
            return FileHelper::remove($this->tempName);
        }
        return true;
    }

    /**
     * Метод неявного пребразования в строку.
     *
     * @return string
     */
    public function __toString()
    {
        return strtolower(pathinfo($this->tempName, PATHINFO_FILENAME));
    }
}
