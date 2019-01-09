<?php

namespace Userstory\ComponentHelpers\helpers;

use ZipArchive;

/**
 * Унаследованный от стандартного ZipArchive, обеспечивает удобство работы при добавлении директорий в зип-архив.
 *
 * @package Userstory\ComponentHelpers\helpers
 */
class ZipHelper extends ZipArchive
{
    /**
     * Рекурсивное добавление директории в зип-архив.
     *
     * @param string $path    Путь до директории.
     * @param string $cutPath Обрезать ли путь (для именования директории).
     *
     * @return boolean
     */
    public function addDir($path, $cutPath = '')
    {
        $dirName = '' !== $cutPath ? substr($path, strlen($cutPath)) : $path;
        if (false === $this->addEmptyDir($dirName)) {
            return false;
        }
        $contents = glob($path . '/*');
        foreach ($contents as $file) {
            if (FileHelper::isDirectory($file)) {
                if (false === $this->addDir($file, $cutPath)) {
                    return false;
                }
            } elseif (FileHelper::isFile($file)) {
                $localName = substr($file, strlen($cutPath));
                if (false === $this->addFile($file, $localName)) {
                    return false;
                }
            }
        }
        return true;
    }
}
