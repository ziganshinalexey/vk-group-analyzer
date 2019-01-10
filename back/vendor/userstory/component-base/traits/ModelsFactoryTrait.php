<?php

namespace Userstory\ComponentBase\traits;

use Userstory\ComponentBase\models\ModelsFactory;
use yii;
use yii\base\InvalidConfigException;

/**
 * Трейт ModelsFactoryTrait.
 * Позволяет добавить механизм работы с фабрикой моделей в класс.
 *
 * @package Userstory\ComponentBase\traits
 */
trait ModelsFactoryTrait
{

    /**
     * Конфигурация фабрики моделей.
     *
     * @var array
     */
    protected $modelFactoryConfig = [
        'class'                              => ModelsFactory::class,
        ModelsFactory::MODEL_CONFIG_LIST_KEY => [],
    ];

    /**
     * Созданный инстанс фабрики моделей.
     *
     * @var ModelsFactory|null
     */
    protected $modelFactory;

    /**
     * Метод позволяет установить конфигурацию фабрики моделей.
     *
     * @param array $value Конфигурация фабрики моделей.
     *
     * @return static
     */
    public function setModelFactoryConfig(array $value)
    {
        $this->modelFactoryConfig = $value;
        return $this;
    }

    /**
     * Метод позволяет получить фабрику моделей.
     *
     * @return ModelsFactory
     *
     * @throws InvalidConfigException Исключение генерируется в случае неверной конфигурации фабрики моделей.
     */
    public function getModelFactory()
    {
        if ($this->modelFactory) {
            return $this->modelFactory;
        }
        $this->modelFactory = Yii::createObject($this->modelFactoryConfig);
        if (! $this->modelFactory instanceof ModelsFactory) {
            throw new InvalidConfigException('Фабрика моделей должна быть производной от класс ' . ModelsFactory::class);
        }
        return $this->modelFactory;
    }

    /**
     * Метод позволяет установить фабрику моделей.
     *
     * @param ModelsFactory $modelsFactory Новое значение.
     *
     * @return static
     */
    public function setModelFactory(ModelsFactory $modelsFactory)
    {
        $this->modelFactory = $modelsFactory;
        return $this;
    }
}
