<?php

namespace Userstory\ComponentBase\interfaces;

/**
 * Интерфейс FileOperationInterface Объявляет класс загрузки/сохранения файлов.
 *
 * @package Userstory\ComponentBase\interfaces
 */
interface FileOperationInterface
{
    /**
     * Метод возвращает экзермпляр операций с файлами.
     *
     * @param mixed  $model     Модель данных.
     * @param string $attribute Атрибут модели, к которой прикреплен файл.
     *
     * @return FileOperationInterface
     */
    public static function getInstance($model, $attribute);

    /**
     * Метод возвращает экзермпляр операций с файлами.
     *
     * @param mixed  $model     Модель данных.
     * @param string $attribute Атрибут модели, к которой прикреплен файл.
     *
     * @return FileOperationInterface[]
     */
    public static function getInstances($model, $attribute);

    /**
     * Метод сохраняет файл в указанную директорию.
     *
     * @param string  $file           Путь, куда нужно сохранить файл.
     * @param boolean $deleteTempFile Флаг удаления временного файла.
     *
     * @return boolean
     */
    public function saveAs($file, $deleteTempFile = true);

    /**
     * Метод неявного пребразования в строку.
     *
     * @return string
     */
    public function __toString();
}
