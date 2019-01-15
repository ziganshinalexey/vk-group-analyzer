<?php

declare(strict_types = 1);

namespace Userstory\Yii2Errors\dataTransferObjects\errors;

use Userstory\Yii2Errors\dataTransferObjects\AbstractMessage;
use Userstory\Yii2Errors\interfaces\errors\ErrorInterface;

/**
 * Класс Error.
 * Дата трансфер обжект для ошибок.
 */
class Error extends AbstractMessage implements ErrorInterface
{
    /**
     * Метод устанавливает код ошибки.
     *
     * @param string $code Новое значение.
     *
     * @return ErrorInterface
     */
    public function setCode(string $code): ErrorInterface
    {
        $this->setMessageCode($code);
        return $this;
    }

    /**
     * Метод устанавливает источник ошибки.
     *
     * @param string $source Новое значение.
     *
     * @return ErrorInterface
     */
    public function setSource(string $source): ErrorInterface
    {
        $this->setMessageSource($source);
        return $this;
    }

    /**
     * Метод устанавливает тайтл ошибки.
     *
     * @param string $title Новое значение.
     *
     * @return ErrorInterface
     */
    public function setTitle(string $title): ErrorInterface
    {
        $this->setMessageTitle($title);
        return $this;
    }

    /**
     * Метод возвращает копию текущего объекта.
     *
     * @return ErrorInterface
     */
    public function copy(): ErrorInterface
    {
        return $this->copyMessage();
    }
}
