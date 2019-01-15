<?php

declare(strict_types = 1);

namespace Ziganshinalexey\Yii2VkApi\traits\group;

use yii;
use yii\base\InvalidConfigException;
use Ziganshinalexey\Yii2VkApi\interfaces\group\ComponentInterface;

/**
 * Трейт, содержащий логику доступа к компоненту "ВК группа".
 */
trait GroupComponentTrait
{
    /**
     * Экземпляр объекта компонента "ВК группа".
     *
     * @var ComponentInterface|null
     */
    protected $groupComponent;

    /**
     * Метод возвращает объект компонента "ВК группа".
     *
     * @throws InvalidConfigException Если компонент не зарегистрирован.
     *
     * @return ComponentInterface
     */
    public function getGroupComponent(): ComponentInterface
    {
        if (! $this->groupComponent) {
            $this->groupComponent = Yii::$app->get('vkGroup');
        }
        return $this->groupComponent;
    }

    /**
     * Метод устанавливает объект компонента "ВК группа".
     *
     * @param ComponentInterface $component Новое значение компонента.
     *
     * @return void
     */
    public function setGroupComponent(ComponentInterface $component): void
    {
        $this->groupComponent = $component;
    }
}
