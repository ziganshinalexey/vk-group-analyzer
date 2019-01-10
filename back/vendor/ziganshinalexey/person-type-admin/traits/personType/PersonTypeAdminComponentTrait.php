<?php

declare(strict_types = 1);

namespace Ziganshinalexey\PersonTypeAdmin\traits\personType;

use yii;
use yii\base\InvalidConfigException;
use Ziganshinalexey\PersonTypeAdmin\interfaces\personType\AdminComponentInterface;

/**
 * Трейт, содержащий логику доступа к компоненту админки "Тип личности".
 */
trait PersonTypeAdminComponentTrait
{
    /**
     * Экземпляр объекта компонента админки "Тип личности".
     *
     * @var AdminComponentInterface|null
     */
    protected $personTypeAdminComponent;

    /**
     * Метод возвращает объект компонента админки "Тип личности".
     *
     * @throws InvalidConfigException Если компонент не зарегистрирован.
     *
     * @return AdminComponentInterface
     */
    public function getPersonTypeAdminComponent(): AdminComponentInterface
    {
        if (! $this->personTypeAdminComponent) {
            $this->personTypeAdminComponent = Yii::$app->get('personTypeAdmin');
        }
        return $this->personTypeAdminComponent;
    }

    /**
     * Метод устанавливает объект компонента "Тип личности".
     *
     * @param AdminComponentInterface $component Новое значение компонента.
     *
     * @return void
     */
    public function setPersonTypeAdminComponent(AdminComponentInterface $component): void
    {
        $this->personTypeAdminComponent = $component;
    }
}
