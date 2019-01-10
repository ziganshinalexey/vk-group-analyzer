<?php

namespace Userstory\ComponentBase\components;

use Userstory\ComponentBase\interfaces\FileOperationInterface;
use Userstory\ComponentBase\operations\PathFileOperations;
use Userstory\ComponentHelpers\helpers\FileHelper;
use yii\base\Component;
use yii\web\UploadedFile;

/**
 * Класс UploadFileComponent управления загрузки/сохранения файлов.
 *
 * @package Userstory\ComponentBase\components
 */
class UploadFileComponent extends Component
{
    /**
     * Метод возвращает модель операций над файлами.
     *
     * @param mixed  $model     Модель данных.
     * @param string $attribute Атрибут модели, к которой прикреплен файл.
     *
     * @return FileOperationInterface
     */
    public function getInstance($model, $attribute)
    {
        if (FileHelper::isFile($attribute)) {
            return PathFileOperations::getInstance($model, $attribute);
        } else {
            return UploadedFile::getInstance($model, $attribute);
        }
    }

    /**
     * Метод возвращает модели операций над файлами.
     *
     * @param mixed  $model     Модель данных.
     * @param string $attribute Атрибут модели, к которой прикреплен файл.
     *
     * @return FileOperationInterface[]
     */
    public function getInstances($model, $attribute)
    {
        if (FileHelper::isFile($attribute)) {
            return PathFileOperations::getInstances($model, $attribute);
        } else {
            return UploadedFile::getInstances($model, $attribute);
        }
    }
}
