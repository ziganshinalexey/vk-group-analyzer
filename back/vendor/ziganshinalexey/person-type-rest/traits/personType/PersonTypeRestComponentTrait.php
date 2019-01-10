<?php

declare(strict_types = 1);

namespace Ziganshinalexey\PersonTypeRest\traits\personType;

use yii;
use yii\base\InvalidConfigException;
use Ziganshinalexey\PersonTypeRest\interfaces\personType\RestComponentInterface;

/**
 * Трейт, содержащий логику доступа к компоненту "Тип личности".
 */
trait PersonTypeRestComponentTrait
{
    /**
     * Экземпляр объекта компонента "Тип личности".
     *
     * @var RestComponentInterface|null
     */
    protected $personTypeRestComponent;

    /**
     * Метод возвращает объект компонента "Тип личности".
     *
     * @throws InvalidConfigException Если компонент не зарегистрирован.
     *
     * @return RestComponentInterface
     */
    public function getPersonTypeRestComponent(): RestComponentInterface
    {
        if (! $this->personTypeRestComponent) {
            $this->personTypeRestComponent = Yii::$app->get('personTypeRest');
        }
        return $this->personTypeRestComponent;
    }

    /**
     * Метод устанавливает объект компонента "Тип личности".
     *
     * @param RestComponentInterface $component Новое значение компонента.
     *
     * @return void
     */
    public function setPersonTypeRestComponent(RestComponentInterface $component): void
    {
        $this->personTypeRestComponent = $component;
    }
}
