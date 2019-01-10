<?php

declare(strict_types = 1);

namespace Ziganshinalexey\PersonType\traits\personType;

use yii;
use yii\base\InvalidConfigException;
use Ziganshinalexey\PersonType\interfaces\personType\ComponentInterface;

/**
 * Трейт, содержащий логику доступа к компоненту "Тип личности".
 */
trait PersonTypeComponentTrait
{
    /**
     * Экземпляр объекта компонента "Тип личности".
     *
     * @var ComponentInterface|null
     */
    protected $personTypeComponent;

    /**
     * Метод возвращает объект компонента "Тип личности".
     *
     * @throws InvalidConfigException Если компонент не зарегистрирован.
     *
     * @return ComponentInterface
     */
    public function getPersonTypeComponent(): ComponentInterface
    {
        if (! $this->personTypeComponent) {
            $this->personTypeComponent = Yii::$app->get('personType');
        }
        return $this->personTypeComponent;
    }

    /**
     * Метод устанавливает объект компонента "Тип личности".
     *
     * @param ComponentInterface $component Новое значение компонента.
     *
     * @return void
     */
    public function setPersonTypeComponent(ComponentInterface $component): void
    {
        $this->personTypeComponent = $component;
    }
}
