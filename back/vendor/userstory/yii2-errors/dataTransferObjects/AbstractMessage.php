<?php

declare(strict_types = 1);

namespace Userstory\Yii2Errors\dataTransferObjects;

use Userstory\Yii2Errors\interfaces\BaseMessageInterface;
use function DeepCopy\deep_copy;

/**
 * Класс AbstractMessage.
 * Базовый класс сообщения.
 */
class AbstractMessage implements BaseMessageInterface
{
    /**
     * Код сообщения, идентифицирующий проблемную ситуацию.
     *
     * @var string
     */
    protected $code = '';

    /**
     * Тайтл сообщения, описывающий проблемную ситуацию.
     *
     * @var string
     */
    protected $title = '';

    /**
     * Источник, описывающий откуда пришло сообщение.
     *
     * @var string
     */
    protected $source = '';

    /**
     * Конструктор для создания объекта класса.
     *
     * @param string $title  Тайтл сообщения.
     * @param string $source Источник сообщения.
     * @param string $code   Код сообщения.
     *
     * @return void
     */
    public function __construct(string $title = '', string $source = '', string $code = '')
    {
        $this->setMessageTitle($title);
        $this->setMessageSource($source);
        $this->setMessageCode($code);
    }

    /**
     * Метод возвращает источник сообщения.
     *
     * @return string
     */
    public function getSource(): string
    {
        return $this->source;
    }

    /**
     * Метод возвращает код сообщения.
     *
     * @return string
     */
    public function getCode(): string
    {
        return $this->code;
    }

    /**
     * Метод возвращает тайтл сообщения.
     *
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * Метод устанавливает код сообщения.
     *
     * @param string $code Новое значение.
     *
     * @return void
     */
    protected function setMessageCode(string $code): void
    {
        $this->code = $code;
    }

    /**
     * Метод устанавливает источник сообщения.
     *
     * @param string $source Новое значение.
     *
     * @return void
     */
    protected function setMessageSource(string $source): void
    {
        $this->source = $source;
    }

    /**
     * Метод устанавливает тайтл сообщения.
     *
     * @param string $title Новое значение.
     *
     * @return void
     */
    protected function setMessageTitle(string $title): void
    {
        $this->title = $title;
    }

    /**
     * Метод возвращает копию текущего объекта.
     *
     * @return BaseMessageInterface
     */
    protected function copyMessage(): BaseMessageInterface
    {
        return deep_copy($this);
    }
}
