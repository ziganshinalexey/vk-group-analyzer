<?php

declare(strict_types = 1);

namespace Userstory\Yii2Errors\traits\errors;

use Userstory\Yii2Errors\interfaces\errors\ComponentInterface;
use yii;
use yii\base\InvalidConfigException;

/**
 * Трейт ComponentTrait.
 * Трейт для работы с компонентом подсистемы ошибок.
 *
 * @package Userstory\Yii2Errors\traits\errors
 */
trait ComponentTrait
{
    /**
     * Компонент подсистемы ошибок.
     *
     * @var ComponentInterface|null
     */
    protected $errorsComponentTrait;

    /**
     * Метод возвращает компонент подсистемы ошибок.
     *
     * @return ComponentInterface
     *
     * @throws InvalidConfigException Исключение генерируется в случае неверной конфигурации подсистемы.
     */
    public function getErrorsComponent(): ComponentInterface
    {
        if (null === $this->errorsComponentTrait) {
            $this->errorsComponentTrait = Yii::$app->get(ComponentInterface::COMPONENT_KEY);
        }
        return $this->errorsComponentTrait;
    }

    /**
     * Метод устанавливает компонент подсистемы ошибок.
     *
     * @param ComponentInterface $component Новое значение.
     *
     * @return static
     */
    public function setErrorsComponent(ComponentInterface $component)
    {
        $this->errorsComponentTrait = $component;
        return $this;
    }
}
