<?php

declare(strict_types = 1);

namespace Userstory\Yii2Errors\interfaces\errors;

use Userstory\ComponentBase\interfaces\PrototypeInterface;
use Userstory\Yii2Errors\interfaces\BaseMessageInterface;

/**
 * Класс ErrorInterface.
 * Интерфейс объекта ошибки.
 */
interface ErrorInterface extends BaseMessageInterface, PrototypeInterface
{
    /**
     * Метод устанавливает код ошибки.
     *
     * @param string $code Новое значение.
     *
     * @return ErrorInterface
     */
    public function setCode(string $code): ErrorInterface;

    /**
     * Метод устанавливает источник ошибки.
     *
     * @param string $source Новое значение.
     *
     * @return ErrorInterface
     */
    public function setSource(string $source): ErrorInterface;

    /**
     * Метод устанавливает тайтл ошибки.
     *
     * @param string $title Новое значение.
     *
     * @return ErrorInterface
     */
    public function setTitle(string $title): ErrorInterface;

    /**
     * Метод выполняет копирование объекта.
     *
     * @return ErrorInterface
     */
    public function copy(): ErrorInterface;
}
